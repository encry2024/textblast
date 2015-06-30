<?php namespace App;

use ReflectionClass;

trait RecordsActivity {

	protected static function bootRecordsActivity() {
		foreach (static::getModelEvents() as $event) {
			static::event(function($model) use $event) {
				$model->addActivity($event);
			}
		}
	}

	protected function addActivity($event) {
		Activity::create([

		])
	}
}