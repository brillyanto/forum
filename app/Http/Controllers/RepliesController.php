<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Reply;

class RepliesController extends Controller
{

    public function __construct(){
         $this->middleware('auth');
    }

    public function store(Request $request, $channel_slug, Thread $thread){
        
        $this->validate($request, [
            'body' => 'required'
        ]);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return redirect()->back()->with('flash', 'Your reply has been created!');
    }

    public function destroy(Reply $reply){
        // if($reply->user_id != auth()->id()) 
        // return response([], 403);
        
        $this->authorize('update', $reply);
        
        $reply->delete();
        return back();
    }

    public function update(Reply $reply){

        $this->authorize('update', $reply);

        $reply->update(['body' => request('body')]);
    }

}
