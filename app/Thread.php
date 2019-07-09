<?php

namespace App;

use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\ThreadWasUpdated;

class Thread extends Model
{

    use RecordsActivity;

    protected $guarded = [];
    protected $with =['author','channel'];
    protected $appends = ['isSubscribedTo'];

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
        $reply = $this->replies()->create($reply);

        // prepare notifications for all the subscribers
        // Method 1
        // foreach($this->subscriptions as $subscription){
        //     // allow only for other users not for self
        //     if($subscription->user_id != $reply->user_id){
        //         $subscription->notify($reply);
        //     }
        // }

        // Method 2
        $this->subscriptions->filter(function ($sub) use ($reply){
            return $sub->user_id != $reply->user_id;
        })->each->notify($reply);

        return $reply;
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
        return $this;
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

    public function getIsSubscribedToAttribute(){
        return $this
        ->subscriptions()
        ->where(['user_id' => auth()->id()])
        ->exists();
    }

}
