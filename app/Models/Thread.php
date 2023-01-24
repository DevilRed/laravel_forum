<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $guarded = [];// to specify those fields which are not mass assignable.

    public function replies()
    {
        return $this->hasMany(Reply::class);
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
