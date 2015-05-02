<?php namespace App\Commands;

use App\GoipCommunicator;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class ReceiveSmsCommand extends Command implements ShouldBeQueued {

	use InteractsWithQueue, SerializesModels;

	public $smsData;
	public $goipCommunicator;
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($smsData)
	{
		$this->smsData = $smsData;
	}

}
