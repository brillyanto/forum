<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters {

    protected $filters = ['by','popular'];

    public function by($username){

        $user = User::whereName($username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);

    }

    public function popular(){

        // works on json request without this line dont know why
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }

}

?>