<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

class ThreadsController extends Controller
{
    public function index()
    {
        $threads = Thread::latest()->get();
        return view('forum.index', compact('threads'));
    }
}
