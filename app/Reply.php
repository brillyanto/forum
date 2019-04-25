<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    use Favoritable, RecordsActivity;

    protected $guarded = [];
    protected $with = ['favorites'];

    protected static function boot(){
        parent::boot();
        static::deleting(function($reply){
            $reply->favorites->each->delete(); // this triggers the delete model event on Favorites model
            // $reply->favorites()->delete(); // this does not triggers the model events on Favorites model
        });
    }

    public function owner(){
       return $this->belongsTo(User::class, 'user_id');
    }

    public function thread(){
        return $this->belongsTo(Thread::class);
    }
   
    public function path(){
        return $this->thread->path()."#reply-{$this->id}";
    }

}
