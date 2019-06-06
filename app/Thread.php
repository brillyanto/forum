<?php

namespace App;

use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    use RecordsActivity;

    protected $guarded = [];
    protected $with =['author','channel'];

    protected static function boot(){
        parent::boot();

        // initial approach
        // static::addGlobalScope('repliesCount', function($builder){
        //     $builder->withCount('replies');
        // });

        

        static::deleting(function($thread){
            //$thread->replies()->delete(); // this doesnot trigger the deleting model event on reply model
            // $thread->replies->each(function($reply){
            //     $reply->delete(); // this line trigger deleting model even on reply model, registered using recordsactivity trait
            // });
            $thread->replies->each->delete();
        });
        
    }

    public function path(){
        return '/threads/'.$this->channel->slug.'/'.$this->id;
    }

    public function replies(){
        return $this->hasMany('App\Reply')->with('owner');
    }

    public function author(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function addReply($reply){
       return $this->replies()->create($reply);
    }

    public function channel(){
        return $this->belongsTo('App\Channel');
    }

    public function scopeFilter($query, ThreadFilters $filters){
        return $filters->apply($query);
    }

    public function subscribe($userId = null){
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);
    }

    public function unsubscribe($userId = null){
        $this
        ->subscriptions()
        ->where(['user_id' => $userId ?: auth()->id()])
        ->delete();
    }

    public function subscriptions(){
        return $this->hasMany(ThreadSubscription::class);
    }



}
