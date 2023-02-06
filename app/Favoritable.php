<?php
namespace App;

use App\Models\Favorite;

trait Favoritable
{
    /**
     * Set polymorphic relationship for favorites
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        // name param in morphMany should be the same prefix used in polymorphic table
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * using a polymorphic relationship for favorites table
     * eloquent will handle the favorited prefixed columns, so just add the remain data
     */
    public function favorite()
    {
        // prevent user favorite same reply more than once
        // if logged user doesn't have a row with the reply
        $attributes = ['user_id' => auth()->id()];
        if(!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    public function isFavorited()
    {
        // use the favorites eager loaded globally
        // !! cast result to boolean
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    // add custom attribute
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
