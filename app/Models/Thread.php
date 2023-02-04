<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $guarded = [];// to specify those fields which are not mass assignable.

    /**
     * laravel trigger this automatically like construct
     */
    protected static function boot()
    {
        parent::boot();
        // add global query scope so that is gonna be available in all thread queries
        // for all thread queries include replyCount
        static::addGlobalScope('replyCount', function($builder) {
            $builder->withCount('replies');
        });
    }

    public function replies()
    {
        return $this->hasMany(Reply::class)
            ->withCount('favorites')// include count of relation
            ->with('owner');
    }
    // custom getter: replyCount
    public function getReplyCountAttribute()
    {
        return $this->replies()->count();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function addReply($reply)
    {
        // use the reply relationship
        $this->replies()->create($reply);
    }

    /**
     * Query scope to accept a set of filters
     * @param $query
     * @param $filters
     */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
