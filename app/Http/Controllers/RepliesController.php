<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

class RepliesController extends Controller
{
    public function store(Thread $thread){
        
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => request('body'),
        ]);

        return redirect()->back();
    }
}
