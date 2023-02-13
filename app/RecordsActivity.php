<?php
namespace App;

use App\Models\Activity;
use App\Models\Thread;

trait RecordsActivity {
    // for any trait used in laravel, there is an initialization method, the method should be  "boot[TraitName]"
    protected static function bootRecordsActivity() {
        // model events
        /**
         * whenever a thread is created in database, as part of that
         * create a new record in Activities table
         */
        static::created(function($model) {
            $model->recordActivity('created');
        });
    }

    protected function getActivityType($event)
    {
        // dynamically add the word thread
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }

    protected function recordActivity($event)
    {
        // use polymorphic relationship
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    // define polymorphic relationship, so that columns "subject_" are populated by laravel
    public function activity() {
        // a model has many activities
        return $this->morphMany(Activity::class, 'subject');
    }
}
