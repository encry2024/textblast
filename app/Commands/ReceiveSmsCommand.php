<?php namespace App\Commands;

use App\Commands\Command;

use App\GoipCommunicator;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReceiveSmsCommand extends Command implements ShouldQueue {

	use InteractsWithQueue, SerializesModels;

	public $smsData;
	public $goipCommunicator;


	/**
	 * @param $smsData
	 */
	public function __construct($smsData)
	{
		$this->smsData = $smsData;
	}

	/**
	 * Handle the command.
	 *
	 * @param  ReceiveSmsCommand  $command
	 * @return void
	 */
	public function handle(ReceiveSmsCommand $command)
	{
		GoipCommunicator::receiveSMSRequest($command->smsData);
	}

}
