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

    public function test_a_thread_can_add_a_reply(){
        $thread = factory('App\Thread')->create();
        $thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $thread->replies);
    }

    public function test_a_thread_belongs_to_a_channel(){
        $thread = factory('App\Thread')->create();
        $this->assertInstanceOf('App\Channel',$thread->channel);
    }


}
