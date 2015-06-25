<?php namespace App\Console\Commands;

use App\SmsActivity;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ResendPendingSms extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'sms:resend';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

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
		$smsActivities = \App\SmsActivity::where('status', 'PENDING')
			->whereRaw("(UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(created_at)) > 900")
			->get();

		foreach($smsActivities as $smsActivity) {
			$smsActivity->resend();
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}

}
