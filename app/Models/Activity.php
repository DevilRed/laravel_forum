<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Complete polymorphic relationship
     * an activity belongs to many "models"
     */
    public function subject()
    {
        return $this->morphTo();
    }

    public static function feed(User $user, $limit = 50)
    {
        return $user->activity()
            ->latest()
            ->with('subject')
            ->take($limit)
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
