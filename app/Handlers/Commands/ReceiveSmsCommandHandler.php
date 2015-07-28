<?php namespace App\Handlers\Commands;

use App\Commands\ReceiveSmsCommand;
use App\GoipCommunicator;

class ReceiveSmsCommandHandler {

	/**
	 * Create the command handler.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
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
