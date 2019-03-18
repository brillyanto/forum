<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;

class ProfilesController extends Controller
{
    public function show(User $user){

        $threads = $user->threads()->paginate(3);
        return view('profiles.show', compact('user','threads'));

    }
}
