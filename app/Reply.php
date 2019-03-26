<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    use Favoritable, RecordsActivity;

    protected $guarded = [];
    protected $with = ['favorites'];

    public function owner(){
       return $this->belongsTo(User::class, 'user_id');
    }
   
}
