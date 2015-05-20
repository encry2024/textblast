<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class SendSmsCommand extends Command implements ShouldBeQueued {

	use InteractsWithQueue, SerializesModels;
	public $phoneNumber;
	public $message;
	public $sessionID;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($phoneNumber, $message, $sessionID = NULL)
	{
		$this->phoneNumber = $phoneNumber;
		$this->message = $message;
		$this->sessionID = $sessionID;
	}

}
