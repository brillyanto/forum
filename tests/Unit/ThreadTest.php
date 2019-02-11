<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_thread_have_many_replies()
    {
        $thread = factory('App\Thread')->create();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $thread->replies);
    }

    public function test_a_thread_has_a_owner(){
        $thread = factory('App\Thread')->create();
        $this->assertInstanceOf('App\User', $thread->author);
    }

}
