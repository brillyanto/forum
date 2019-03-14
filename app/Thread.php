<?php

namespace App;


use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];

    protected static function boot(){
        parent::boot();
        static::addGlobalScope('repliesCount', function($builder){
            $builder->withCount('replies');
        });
    }

    public function path(){
        return '/threads/'.$this->channel->slug.'/'.$this->id;
    }

    public function replies(){
        return $this->hasMany('App\Reply')->withCount('favorites');
    }

    public function author(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function addReply($reply){
        $this->replies()->create($reply);
    }

    public function channel(){
        return $this->belongsTo('App\Channel');
    }

    public function scopeFilter($query, ThreadFilters $filters){
        return $filters->apply($query);
    }

}
