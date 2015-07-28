<?php namespace App\Handlers\Commands;

use App\Commands\SendSmsCommand;
use App\GoipCommunicator;

class SendSmsCommandHandler {

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
	 * @param  SendSmsCommand  $command
	 * @return void
	 */
	public function handle(SendSmsCommand $command)
	{
		GoipCommunicator::sendSMSRequest($command->phoneNumber, $command->message, $command->sessionID);
	}

}
