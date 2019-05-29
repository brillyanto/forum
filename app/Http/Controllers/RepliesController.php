<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Reply;

class RepliesController extends Controller
{

    public function __construct(){
         $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread){
        return $thread->replies()->paginate(5);
    }

    public function store(Request $request, $channel_slug, Thread $thread){
        
        $this->validate($request, [
            'body' => 'required'
        ]);

        $reply = $thread->addReply([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        if($request->expectsJson()){
            return $reply->load('owner');
        }

        return redirect()->back()->with('flash', 'Your reply has been created!');
    }

    public function destroy(Reply $reply){
        // if($reply->user_id != auth()->id()) 
        // return response([], 403);
        $this->authorize('update', $reply);
        $reply->delete();
        if(request()->expectsJson()){
            return response(['status' => 'Reply Deleted']);
        }
    }

    public function update(Reply $reply){
        $this->authorize('update', $reply);
        $reply->update(['body' => request('body')]);
    }

}
