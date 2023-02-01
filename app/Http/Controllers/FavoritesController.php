<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{

    /**
     * FavoritesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reply $reply)
    {
        // using a polymorphic relationship for favorites table
        Favorite::create([
            'user_id' => auth()->id(),
            'favorited_id' => $reply->id,
            'favorited_type' => get_class($reply)
        ]);
    }
}
