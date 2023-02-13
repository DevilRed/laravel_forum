<?php

namespace App\Models;

use App\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Favoritable;

class Reply extends Model
{
    use HasFactory;
    use Favoritable;
    use RecordsActivity;

    protected $guarded = [];// opposite of $fillable, specify fields which are not mass assignable
    // always eager load relationship for every single query
    protected $with = ['owner', 'favorites'];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
