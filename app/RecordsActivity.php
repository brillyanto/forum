<?php

namespace App;

trait RecordsActivity{

    protected static function bootRecordsActivity(){

        // skip recording activities for guests
        if(auth()->guest()) return;

        foreach(static::getActivitiesToRecord() as $event){
            static::$event(function($model) use ($event){
                $model->recordActivity($event);
            });
        }
    }

    protected static function getActivitiesToRecord(){
        return ['created', 'deleted'];
    }

    protected function recordActivity($event){

        $this->activity()->create([
            'user_id' => auth()->id(),
            'type'  => $event.'_'. class_basename($this),
        ]);
        // Activity::create([
        //     'subject_id' => $this->id,
        //     'subject_type' => get_class($this)
        // ]);
    }

    public function activity(){
        return $this->morphMany('App\Activity', 'subject');
    }

}