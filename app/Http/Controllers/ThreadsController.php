<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['store','create']);
    }

    public function index()
    {
        $threads = Thread::latest()->get();
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
