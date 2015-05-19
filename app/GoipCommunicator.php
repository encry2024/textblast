<?php


namespace App;

use Monolog\Handler\SyslogUdp\UdpSocket;

class GoipCommunicator extends UdpSocket
{
    private $socket;

    /**
     * @return resource
     */
    public function getSocket()
    {
        return $this->socket;
    }
    private $goip;

    /**
     * @param
     */
    public function __construct($goipID)
    {
        $this->goip = Goip::find($goipID);
        if(!$this->goip) return FALSE;

        if(!$this->createSocketConnection()) return FALSE;

        return TRUE;
    }


    /**
     * @param
     */
    public function createSocketConnection()
    {
        //create new socket
        if(!$this->socket = new UdpSocket($this->goip->ip_address, $this->goip->port)) return FALSE;

        return TRUE;
    }


    /**
     * @param
     */
    public static function sendSMSRequest($mobileNumber, $message, $sessionID = NULL)
    {
        echo "SENDING MESSAGE TO: $mobileNumber";
        $goipCommunicator = new GoipCommunicator(3);

        //check first if socket is active
        if (!$goipCommunicator->socket) {echo "No socket connection."; return FALSE;}

        //check if goip was passed
        if (!$goipCommunicator->goip) {echo "No GoIP information to communicate."; return FALSE;}

        //check if SMS was passed
        if (!$mobileNumber OR !$message) {echo "No SMS information to send."; return FALSE;}

        /* Send Message */
        $goipCommunicator->socket->write("MSG " . $sessionID . " " . strlen($message) . " " . $message . "\n");

        /* Send Password */
        if (strpos($goipCommunicator->getResponse(), "PASSWORD") !== FALSE) {
            $goipCommunicator->socket->write("PASSWORD " . $sessionID . " " . $goipCommunicator->goip->password . "\n");
            $response = $goipCommunicator->getResponse();
        } else {
            //something went wrong. exiting the sms sending..
            echo "Something went wrong upon sending password: " . $goipCommunicator->goip->password . "\n";
            return FALSE;
        }
        /* Send recipient number */
        echo "Sending message.....\n";
        if (strpos($response, "SEND") !== FALSE) {
            $goipCommunicator->socket->write("SEND " . $sessionID . " 1 " . $mobileNumber . "\n");
        }

        /* Wait for GoIP reply */
        $retry = 0;
        while ($retry < 6) {
            // run loop in 5 seconds limit
            $timeLimit = time() + 5;
            echo "Waiting for sending status.....\n";
            while (strpos($response = $goipCommunicator->getResponse(), "OK") == FALSE) {
                //return var_dump($currentTime . '/' . $timeLimit);
                $goipCommunicator->socket->write("SEND " . $sessionID . " 1 " . $mobileNumber . "\n");
                if($timeLimit < time()) break;
                usleep(800000);
            }

            // Check if will retry again
            $willRetry = is_numeric(strpos($response, "OK"))?FALSE:TRUE;
            if ($willRetry == TRUE) {
                $goipCommunicator->socket->write("SEND " . $sessionID . " 1 " . $mobileNumber . "\n");
                $retry++;
                echo "Retrying($retry)....";
            } else {
                break;
            }
        }

        /* Check if the response is OK */
        if (strpos($goipCommunicator->getResponse(), "OK") !== FALSE) {
            echo "Message sent! Replying DONE.....\n\n";
            $goipCommunicator->socket->write("DONE " . $sessionID . "\n");

            // Update smsActivity
            $smsActivity = SmsActivity::find($sessionID);
            $smsActivity->status = 'SENT';
            $smsActivity->save();
        } else {
            echo "Message not sent! Exiting.....\n\n";

            // Update smsActivity
            $smsActivity = SmsActivity::find($sessionID);
            $smsActivity->status = 'FAILED';
            $smsActivity->save();
        }

        $goipCommunicator->socket->close();

        return;
    }

    /**
     * @param 
     */
    public static function receiveSMSRequest($smsData){
        echo "Message received! \n";
        //disect each information
        $data = explode(';', $smsData);

        echo "Getting the date \n";
        //get the date
        $smsDateTemp = explode(':', $data[0]);
        $smsDate = $smsDateTemp[1];

        echo "Getting the source goip \n";
        //get the source goip
        $smsGoipTemp = explode(':', $data[1]);
        $smsGoip = $smsGoipTemp[1];
        // respond to GoIP that we received the text
        $goip = Goip::where('name', $smsGoip)->first();
        $goipCommunicator = new GoipCommunicator($goip->id);
        $goipCommunicator->socket->write("RECEIVE " . $smsDate . " OK\n");
        $goipCommunicator->socket->close();

        echo "Getting the goip password \n";
        //get the goip password
        $smsPasswordTemp = explode(':', $data[2]);
        $smsPassword = $smsPasswordTemp[1];

        echo "Getting the source sms number \n";
        //get the source sms number
        $smsNumberTemp = explode(':', $data[3]);
        $smsNumber = $smsNumberTemp[1];

        echo "Getting the sms content \n";
        //get the sms content
        $smsContentTemp = explode(':', $data[4]);
        $smsContent = $smsContentTemp[1];

        echo "Search if sender was already added in recipient_numbers table. if not then add new \n";
        //search if sender was already added in recipient_numbers table. if not then add new
        $recipientNumber = RecipientNumber::checkPhoneExist($smsNumber);

        if(count($recipientNumber) == 0) {
            $recipient = new Recipient();
            $recipient->name = "NO NAME";
            $recipient->save();
            $recipient->phoneNumbers()->save($recipientNumber = new RecipientNumber(['recipient_id' => $recipient->id, 'phone_number' => $smsNumber]));
        }

        echo "Create new SMS instance \n";
        // Create new SMS instance
        $sms = new Sms();
        $sms->message = $smsContent;
        $sms->type = 'receive';
        $sms->save();

        echo "Create new SMS activity instance\n\n";
        // Create new SMS activity instance;
        $smsActivity = new SmsActivity();
        $smsActivity->sms_id = $sms->id;
        $smsActivity->recipient_number_id = $recipientNumber->id;
        $smsActivity->recipient_team_id = 0;
        $smsActivity->status = 'RECEIVED';
        $smsActivity->save();

        return;
    }

    /**
     * @param
     */
    public static function createSocketBindings($socket, $port = 48200)
    {
        socket_bind($socket, "0.0.0.0", env('LOCAL_PORT', $port));
    }

    /**
     * @param 
     */
    public function getResponse(){
       // socket_recvfrom($this->socket->socket, $buf, 2048, MSG_WAITALL, $this->socket->ip, $this->socket->port);
        if (false !== ($bytes = socket_recv($this->socket->socket, $buf, 4096, 0))) {
            $buf = $buf;
        }
        echo $buf . "\n";
        return $buf;
    }
}