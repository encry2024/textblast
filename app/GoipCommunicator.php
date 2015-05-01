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
    public function createSocketBindings($port = 48200)
    {
        socket_bind($this->socket->socket, "0.0.0.0", env('LOCAL_PORT', $port));
    }


    /**
     * @param
     */
    public function sendSMSRequest(Sms $sms)
    {
        //check first if socket is active
        if (!$this->socket) {echo "No socket connection."; return FALSE;}

        //check if goip was passed
        if (!$this->goip) {echo "No GoIP information to communicate."; return FALSE;}

        //check if SMS was passed
        if (!$sms) {echo "No SMS information to send."; return FALSE;}

        /* Send Message */
        $this->socket->write("MSG " . $sms->id . " " . strlen($sms->message) . " " . $sms->message . "\n");
        $response = $this->getResponse();

        /* Send Password */
        if (strpos($response, "PASSWORD") !== FALSE) {
            $this->socket->write("PASSWORD " . $sms->id . " " . $this->goip->password . "\n");
            $response = $this->getResponse();
        } else {
            //something went wrong. exiting the sms sending..
            echo "Something went wrong upon sending password: " . $this->goip->password . "\n";
            $response = $this->getResponse();
            return false;
        }

        /* Send recipient number */
        $telID = rand(); //generate unique telID
        if (strpos($response, "SEND") !== FALSE) {
            //echo "Sending recipient number: " . "SEND " . $sms->id . " " . $telID . " " . $sms->phone_number . "\n" . "\n";
            $this->socket->write("SEND " . $sms->id . " " . $telID . " " . $sms->recipient_number->phone_number . "\n");
            $response = $this->getResponse();
        }

        /* Wait for GoIP reply */
        $retry = 0;
        while ($retry < 4) {
            // run loop in 5 seconds limit
            $timeLimit = ($currentTime = time()) + 5;
            echo "Waiting for sending status.....\n";
            while (strpos($response, "WAIT") !== FALSE AND $currentTime < $timeLimit) {
                $response = $this->getResponse();
                //echo "$remote_ip : $remote_port -- " . $response . "\n";
                $currentTime = time();
            }
            if ($currentTime >= $timeLimit) {
                $this->socket->write("SEND " . $sms->id . " " . $telID . " " . $sms->recipient_number->phone_number . "\n");
                $response = $this->getResponse();
                $retry++;
                echo "Retrying($retry)....";
            } else {
                break;
            }
        }

        /* Check if the response is OK */
        if (strpos($response, "OK") !== FALSE) {
            echo "Message sent! Replying DONE.....\n";
            $this->socket->write("DONE " . $sms->id . "\n");
            $response = $this->getResponse();
            $this->socket->close();

            //update sms status
            $sms->status="OK";
            $sms->save();

            return TRUE;
        }

        $this->socket->close();
        //update sms status
        $sms->status="FAILED";
        $sms->save();

        echo "Message not sent! Exiting.....\n";
        return FALSE;
    }

    /**
     * @param 
     */
    public function receiveSMSRequest($smsData){
        //return var_dump($smsData);
        //disect each information
        $data = explode(';', $smsData);

        //get the date
        $smsDateTemp = explode(':', $data[0]);
        $smsDate = $smsDateTemp[1];

        //get the source goip
        $smsGoipTemp = explode(':', $data[1]);
        $smsGoip = $smsGoipTemp[1];

        //get the goip password
        $smsPasswordTemp = explode(':', $data[2]);
        $smsPassword = $smsPasswordTemp[1];

        //get the source sms number
        $smsNumberTemp = explode(':', $data[3]);
        $smsNumber = $smsNumberTemp[1];

        //get the sms content
        $smsContentTemp = explode(':', $data[4]);
        $smsContent = $smsContentTemp[1];

        // Create new SMS instance
        $sms = new Sms();
        $sms->phone_number = $smsNumber;
        $sms->message = $smsContent;
        //Insert to database
        $sms->save();

        //insert new activity
        $sms->insertSMSActivity('RECEIVE', 'MANUAL');

        // respond to GoIP that we received the text
        $goip = Goip::where('name', $smsGoip)->first();
        $goipCommunicator = new GoipCommunicator($goip->id);
        $goipCommunicator->socket->write("RECEIVE " . $smsDate . " OK");
        $goipCommunicator->socket->close();
    }

    /**
     * @param 
     */
    public function getResponse(){
        socket_recvfrom($this->socket->socket, $buf, 512, 0, $this->socket->ip, $this->socket->port);

        echo $buf;
        return $buf;
    }
}