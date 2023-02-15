<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Activity;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        // get user activities with eager loading, grouping by date and paginating by 50
        return view('profiles.show',[
            'profileUser' => $user,
            'activities' => Activity::feed($user)
        ]);
    }
}
