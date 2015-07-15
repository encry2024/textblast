<?php namespace App\Console\Commands;

use App\Commands\ReceiveSmsCommand;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\GoipCommunicator;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Carbon\Carbon;
use App\Goip;

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
			echo "[".Carbon::now()->toDateTimeString()."]  " . $buf . "\n";
			/* Check if Receive data was received */
			if (strpos($buf, "RECEIVE") !== FALSE) {
				$smsData = $buf;
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

				//dispatch
				$this->dispatch(new ReceiveSmsCommand($buf));
			}
			usleep(3000000);
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
