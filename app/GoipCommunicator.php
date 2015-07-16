<?php


namespace App;

use Illuminate\Support\Facades\DB;
use Monolog\Handler\SyslogUdp\UdpSocket;
use Carbon\Carbon;


class GoipCommunicator extends UdpSocket
{
    public $socket;

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
        echo "[".Carbon::now()->toDateTimeString()."]   SENDING MESSAGE TO: $mobileNumber \n";
        $network = GoipCommunicator::networkGetter($mobileNumber);
        $goip = Goip::where('network', $network)->first();
        $goipCommunicator = new GoipCommunicator($goip?$goip->id:env('GOIP_DEFAULT'));

        //check first if socket is active
        if (!$goipCommunicator->socket) {echo "[".Carbon::now()->toDateTimeString()."]   No socket connection.\n"; return FALSE;}

        //check if goip was passed
        if (!$goipCommunicator->goip) {echo "[".Carbon::now()->toDateTimeString()."]   No GoIP information to communicate.\n"; return FALSE;}

        //check if SMS was passed
        if (!$mobileNumber OR !$message) {echo "[".Carbon::now()->toDateTimeString()."]   No SMS information to send.\n"; return FALSE;}

        /* Send Message */
        echo "[".Carbon::now()->toDateTimeString()."]   MSG " . $sessionID . " " . strlen($message) . " " . $message . "\n";
        $goipCommunicator->socket->write("MSG " . $sessionID . " " . strlen($message) . " " . $message . "\n");

        /* Send Password */
        if (strpos($goipCommunicator->getResponse(), "PASSWORD") !== FALSE) {
            echo "[".Carbon::now()->toDateTimeString()."]   PASSWORD " . $sessionID . " " . $goipCommunicator->goip->password . "\n";
            $goipCommunicator->socket->write("PASSWORD " . $sessionID . " " . $goipCommunicator->goip->password . "\n");
            $response = $goipCommunicator->getResponse();
        } else {
            //something went wrong. exiting the sms sending..
            echo "[".Carbon::now()->toDateTimeString()."]   Something went wrong upon sending password: " . $goipCommunicator->goip->password . "\n";
            return FALSE;
        }
        /* Send recipient number */
        echo "[".Carbon::now()->toDateTimeString()."]   Sending message.....\n";
        if (strpos($response, "SEND") !== FALSE) {
            echo "[".Carbon::now()->toDateTimeString()."]   SEND " . $sessionID . " 1 " . $mobileNumber . "\n";
            $goipCommunicator->socket->write("SEND " . $sessionID . " 1 " . $mobileNumber . "\n");
        }

        /* Wait for GoIP reply */
        $retry = 0;
        while ($retry < 12) {
            // run loop in 3 seconds limit
            $timeLimit = time() + 5;
            echo "[".Carbon::now()->toDateTimeString()."]   Waiting for sending status.....\n";
            while (1) {
                usleep(1000000);
                if(is_numeric(strpos($response = $goipCommunicator->getResponse(), "OK")) == TRUE) break;
                if($timeLimit < time()) break;

                echo "[".Carbon::now()->toDateTimeString()."]   SEND " . $sessionID . " 1 " . $mobileNumber . "\n";
                $goipCommunicator->socket->write("SEND " . $sessionID . " 1 " . $mobileNumber . "\n");
            }

            // Check if will retry again
            $willRetry = is_numeric(strpos($response, "OK"))?FALSE:TRUE;
            if ($willRetry == TRUE) {
                echo "[".Carbon::now()->toDateTimeString()."]   Retrying(".++$retry.")....\n";
                echo "[".Carbon::now()->toDateTimeString()."]   SEND " . $sessionID . " 1 " . $mobileNumber . "\n";
                $goipCommunicator->socket->write("SEND " . $sessionID . " 1 " . $mobileNumber . "\n");
            } else {
                break;
            }
        }

        /* Check if the response is OK */
        if (strpos($goipCommunicator->getResponse(), "OK") !== FALSE) {
            echo "[".Carbon::now()->toDateTimeString()."]   DONE " . $sessionID . "\n";
            $goipCommunicator->socket->write("DONE " . $sessionID . "\n");
            echo "[".Carbon::now()->toDateTimeString()."]   Message sent!\n\n";

            // Update smsActivity
            $smsActivity = SmsActivity::find($sessionID);
            $smsActivity->status = 'SENT';
            $smsActivity->goip_name = $goip->name;
            $smsActivity->save();
        } else {
            echo "[".Carbon::now()->toDateTimeString()."]   Message not sent! Exiting.....\n\n";

            // Update smsActivity
            $smsActivity = SmsActivity::find($sessionID);
            $smsActivity->status = 'FAILED';
            $smsActivity->goip_name = $goip->name;
            $smsActivity->save();
        }

        $goipCommunicator->socket->close();

        return;
    }

    /**
     * @param 
     */
    public static function receiveSMSRequest($smsData){
        echo "[".Carbon::now()->toDateTimeString()."]   Message Received: " . $smsData . "\n";
        //disect each information
        $data = explode(';', $smsData);

        //get the date
        $smsDateTemp = explode(':', $data[0]);

        //get the source goip
        $smsGoipTemp = explode(':', $data[1]);

        // respond to GoIP that we received the text
        $goip = Goip::where('name', $smsGoipTemp[1])->first();
        $goipCommunicator = new GoipCommunicator($goip->id);
        echo "[".Carbon::now()->toDateTimeString()."]   RECEIVE " . $smsDateTemp[1] . " OK\n";
        $goipCommunicator->socket->write("RECEIVE " . $smsDateTemp[1] . " OK\n");
        $goipCommunicator->socket->close();

        // check if sms already received then exit
        $oldSms = Sms::where('type', 'RECEIVED')->where('other_info', $smsDateTemp[1])->get();
        if(count($oldSms)>0) {
            echo "[".Carbon::now()->toDateTimeString()."]   Sms already added. Discarding.... \n";
            return;
        }

        //get the sms content
        $smsContentTemp = explode(';msg:', $smsData);
        // exit if sms is empty
        if(empty($smsContentTemp[1])) {
            echo "[".Carbon::now()->toDateTimeString()."]   Sms content empty. Discarding.... \n";
            return;
        }

        //get the source sms number
        $smsNumberTemp = explode(':', $data[3]);

        //search if sender was already added in recipient_numbers table. if not then add new
        $recipientNumber = RecipientNumber::checkPhoneExist($smsNumberTemp[1]);

        if(count($recipientNumber) == 0) {
            $recipient = new Recipient();
            $recipient->name = "NO NAME";
            $recipient->save();
            $recipient->phoneNumbers()->save($recipientNumber = new RecipientNumber(['recipient_id' => $recipient->id, 'phone_number' => $smsNumberTemp[1]]));
        }

        // Create new SMS instance
        $sms = new Sms();
        $sms->message = $smsContentTemp[1];
        $sms->type = 'RECEIVED';
        $sms->other_info = $smsDateTemp[1];
        $sms->save();

        // Create new SMS activity instance;
        $smsActivity = $sms->sms_activity()->save(new SmsActivity(['recipient_number_id' => $recipientNumber->id, 'recipient_team_id' => 0, 'status' => 'RECEIVED', 'goip_name' => $smsGoipTemp[1]]));
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
        if (false !== ($bytes = socket_recv($this->socket->socket, $buf, 8192, 0))) {
            echo "[".Carbon::now()->toDateTimeString()."]   ".$buf;
            return $buf;
        }
    }


    /**
     * @param
     */
    public static function networkGetter($phone){
        if(strlen($phone) == 3) {
            $network = DB::table('mobile_prefix')->where('prefix', $phone)->pluck('network_name');

            return $network;
        } elseif(strlen($phone) >= 10) {
            $network = DB::table('mobile_prefix')->where('prefix', substr($phone, -10, 3))->pluck('network_name');

            return $network;
        }

        return false;
    }
}