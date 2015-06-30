<?php namespace App;

use Illuminate\Support\Facades\Auth;
use ReflectionClass;


trait RecordsActivity {

	protected static function bootRecordsActivity() {

		foreach (static::getModelEvents() as $event) {
			static::$event(function($model) use ($event) {
				$model->recordActivity($event);
			});
		}
	}

	public function recordActivity($event)
	{
		$activity = new Activity();
		$activity->subject_id = $this->id;
		$activity->subject_type = get_class($this);
		$activity->name = $this->getActivityName($this, $event);
		$activity->user_id = Auth::user()->id;
		$activity->save();
	}

	protected function getActivityName($model, $action) {
		$name = strtolower(class_basename($model));

		return "{$action} {$name}";
	}

	protected static function getModelEvents()
	{
		if (isset(static::$recordEvents)) {
			return static::$recordEvents;
		}

		return ['created', 'updated', 'deleted'];
	}
}