<?php namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
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
		$model = strtolower(class_basename($this));

		if ($event == "created") {
			$activity = new Activity();
			$activity->subject_id = $this->id;
			$activity->subject_type = get_class($this);
			$activity->name = $this->getActivityName($this, $event);
			$activity->user_id = Auth::guest()?0:Auth::user()->id;

			if ($model == "recipientnumber") {
				$activity->old_value = $this->phone_number;
			} else if ($model == "sms") {
				$activity->old_value = "SMS #" . $this->id;
			} else {
				$activity->old_value = $this->name;
			}


			$activity->save();
		} else if ($event == "updates") {
			if ($model == "recipient") {
				$activity = new Activity();

				$activity->subject_id = $this->id;
				$activity->subject_type = get_class($this);
				$activity->name = $this->getActivityName($this, $event);
				$activity->old_value = class_basename($this);
				$activity->new_value = Input::get('name');
				$activity->user_id = Auth::guest()?0:Auth::user()->id;
				$activity->save();

				$this->name = Input::get('name');
				$this->save();
			} else if ($model == "recipientnumber") {
				$activity = new Activity();

				$activity->subject_id = $this->id;
				$activity->subject_type = get_class($this);
				$activity->name = $this->getActivityName($this, $event);
				$activity->old_value = $this->phone_number;
				$activity->new_value = Input::get('phone_number');
				$activity->user_id = Auth::guest()?0:Auth::user()->id;
				$activity->save();

				$this->phone_number = Input::get('phone_number');
				$this->save();
			}
		} else if ($event == "deleted") {
			$activity = new Activity();
			$activity->subject_id = $this->id;
			$activity->subject_type = get_class($this);
			$activity->name = $this->getActivityName($this, $event);
			$activity->user_id = Auth::guest()?0:Auth::user()->id;

			if ($model == "recipientnumber") {
				$activity->old_value = $this->phone_number;
			} else {
				$activity->old_value = $this->name;
			}

			$activity->save();
		}
	}

	protected function getActivityName($model, $action) {
		$name = strtolower(class_basename($model));

		return "{$action}_{$name}";
	}

	protected static function getModelEvents()
	{
		if (isset(static::$recordEvents)) {
			return static::$recordEvents;
		}

		return ['created', 'updated', 'deleted'];
	}
}