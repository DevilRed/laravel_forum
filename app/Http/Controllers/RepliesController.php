<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function store(Thread $thread)
    {
        $thread->addReply([
            'body' => \request('body'),
            'user_id' => auth()->id()// get auth user id
        ]);

        return redirect()->back();// previous url
        // return redirect()->to($thread->path());// previous url
    }
}
