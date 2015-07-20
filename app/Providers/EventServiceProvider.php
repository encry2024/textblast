<?php namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Queue;
use Log;
use App\SmsActivity;
use Illuminate\Support\Facades\DB;

class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'event.name' => [
			'',
		],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);

		Queue::failing(function($connection, $job, $data)
		{
			if (preg_match('/([0-9]+);s:/', $data['data']['command'], $matched)) {
				$smsActivityID = trim($matched[1]);
				$smsActivity = SmsActivity::findOrFail($smsActivityID);

				// update status to FAILED
				$smsActivity->status = 'FAILED';
				$smsActivity->save();

				Log::info('SMS Send Queue failed.. Sms Activity: ' . $smsActivityID);
			}

			DB::disconnect();
		});
		//
	}

}
