<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;

class ProfilesController extends Controller
{
    public function show(User $user){

        // $threads = $user->threads()->paginate(3);
        $activities = $user->activity()->with('subject')->get()->groupBy(function($activity){
            return $activity->created_at->format('Y-m-d');
        });

      //  dd($activities->toArray());

        return view('profiles.show', compact('user','activities'));

    }
}
