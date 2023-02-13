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
}
