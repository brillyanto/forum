<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;

class FavoritesController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function store(Reply $reply){

        // \DB::table('favorites')->updateOrInsert([
        //     'user_id' => Auth()->id(),
        //     'favorited_id' => $reply->id,
        //     'favorited_type' => get_class($reply),
        // ]);

        $reply->favorite();

        
        
    }
    
}
