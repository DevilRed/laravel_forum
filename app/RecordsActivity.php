<?php
namespace App;

use App\Models\Activity;
use App\Models\Thread;

trait RecordsActivity {

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
