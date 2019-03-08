<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Channel;
use App\User;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['store','create']);
    }

    public function index(Channel $channel = null)
    {

        if($channel) {
            $threads = Thread::whereChannelId($channel->id);
            //return view('forum.index', compact('threads'));
        } else{
            $threads = Thread::latest();
            //return view('forum.index', compact('threads'));
        }
        
        $name = request()->query('by', null);
        if($name){
            $user = User::where('name', $name)->firstOrFail();
            $threads->where('user_id', $user->id);
        }

        $threads = $threads->get();

        return view('forum.index', compact('threads'));

    }

    public function show($channel_id, Thread $thread){
        return view('forum.show', compact('thread'));
    }
    
    public function store(Request $request){
        
        $this->validate($request,[
             'title' => 'required',
             'body'  => 'required',
             'channel_id' => 'required|exists:channels,id'
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => $request->channel_id,
            'title' => $request->title,
            'body' => $request->body
        ]);

        return redirect($thread->path());

    }

    public function create(){
        return view('forum.create');
    }


}
