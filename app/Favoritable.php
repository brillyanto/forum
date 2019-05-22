<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

trait Favoritable{

    public function favorites(){
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite(){
        $attributes = ['user_id' => auth()->id()];
        if(!$this->favorites()->where('user_id', auth()->id())->exists())
        $this->favorites()->create($attributes);
    }

    public function unfavorite(){
        $attributes = ['user_id' => auth()->id()];

       // $this->favorites()->where($attributes)->delete(); // this will not fire the model events on favorite model

        // $this->favorites()->where($attributes)->get()->each(function($favorite){
        //     $favorite->delete();
        // });
            
        $this->favorites()->where($attributes)->get()->each->delete(); // alternate method to fire model events

    }

    public function isFavorited(){
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getIsFavoritedAttribute(){ // $reply->isFavorited
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute(){
        return $this->favorites->count();
    }

}