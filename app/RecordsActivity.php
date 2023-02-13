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
        static::created(function($thread) {
            $thread->recordActivity('created');
        });
    }

    protected function getActivityType($event)
    {
        return $event . '_' . strtolower((new \ReflectionClass($this))->getShortName());// dynamically add the word thread
    }

    protected function recordActivity($event)
    {
        Activity::create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
            'subject_id' => $this->id,
            'subject_type' => get_class($this)
        ]);
    }
}
