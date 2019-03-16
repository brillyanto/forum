<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Filters\ThreadFilters;
use App\Thread;
use App\Channel;
use App\User;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['store','create']);
    }

    public function index(Channel $channel, ThreadFilters $filters)
    {
        
       $threads = $this->getThreads($channel, $filters);
       if(request()->wantsJson()){
           return $threads;
       }

        return view('forum.index', compact('threads'));

    }

    public function show($channel_id, Thread $thread){

         return view('forum.show', [
             'thread' => $thread,
             'replies' => $thread->replies()->paginate(20)
         ]);
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


    protected function getThreads(Channel $channel, ThreadFilters $filters){

        $threads = Thread::with('channel')->latest()->filter($filters);

        if($channel->exists) {
            $threads->whereChannelId($channel->id);
        } 
        
        return $threads->get();
    }

}
