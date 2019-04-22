<?php

namespace App;

trait RecordsActivity{

    protected static function bootRecordsActivity(){

        // skip recording activities for guests
        if(auth()->guest()) { return; } 
       
        foreach(static::getActivitiesToRecord() as $event){
            static::$event(function($model) use ($event){
                $model->recordActivity($event);
            });
        }

        static::deleting(function($model){
            $model->activity()->delete();
        });
        
    }

    protected static function getActivitiesToRecord(){
        return ['created'];
    }

    protected function recordActivity($event){

        // dump('recording activity : '. $event.'_'.class_basename($this));
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type'  => $event.'_'. strtolower(class_basename($this)),
        ]);

        // Activity::create([
        //     'user_id' => auth()->id(),
        //     'type'  => $event.'_'. strtolower(class_basename($this)),
        //     'subject_id' => $this->id,
        //     'subject_type' => get_class($this)
        // ]);

    }

    public function activity(){
        return $this->morphMany('App\Activity', 'subject');
    }

}