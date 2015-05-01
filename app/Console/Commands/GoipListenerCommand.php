<?php namespace App\Console\Commands;

use App\Commands\ReceiveSmsCommand;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\GoipCommunicator;
use Illuminate\Foundation\Bus\DispatchesCommands;

class GoipListenerCommand extends Command {

	use DispatchesCommands;

	private $goipCommunicator;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'goip:listener';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Run the local listener to GoIP.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//create socket
		$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

		//create socket bindings
		GoipCommunicator::createSocketBindings($socket);

		//create listener
		while (1) {
			socket_recvfrom($socket, $buf, 512, 0, $remote_ip, $remote_port);
			echo $buf . "\n";
			/* Check if Receive data was received */
			if (strpos($buf, "RECEIVE") !== FALSE) {
				echo "Message received: $buf \n";
				//dispatch
				$this->dispatch(new ReceiveSmsCommand($buf));
			}
		}

		echo "Exiting.......";
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['example', InputArgument::OPTIONAL, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['goip_id', null, InputOption::VALUE_OPTIONAL, 'Goip ID', null],
		];
	}

}
