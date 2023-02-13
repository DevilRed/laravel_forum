<?php

namespace App\Models;

use App\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    use RecordsActivity;

    protected $guarded = [];// to specify those fields which are not mass assignable.
    // eager load relationship for all model queries
    protected $with = ['creator', 'channel'];

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
        return $this->hasMany(Reply::class);
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
