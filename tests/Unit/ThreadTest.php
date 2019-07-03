<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    function test_a_thread_have_many_replies()
    {
        $thread = factory('App\Thread')->create();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $thread->replies);
    }

    function test_a_thread_has_a_owner(){
        $thread = factory('App\Thread')->create();
        $this->assertInstanceOf('App\User', $thread->author);
    }

    function test_a_thread_can_add_a_reply(){
        $thread = factory('App\Thread')->create();
        $thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $thread->replies);
    }

    function test_a_thread_belongs_to_a_channel(){
        $thread = factory('App\Thread')->create();
        $this->assertInstanceOf('App\Channel',$thread->channel);
    }

    function test_a_thread_can_be_subscribed_to(){
        $thread = factory('App\Thread')->create();
        $user_id = 1;
        $thread->subscribe($user_id);
        // subscriptions is a relationship
        $subscribers = $thread->subscriptions()->where('user_id', $user_id)->count();
        $this->assertEquals(1, $subscribers);
    }

    function test_a_thread_can_be_unsubscribed_from(){
        $thread = create('App\Thread');
        $user_id = 1;
        $thread->subscribe($user_id);
        $thread->unsubscribe($user_id);
        $this->assertCount(0, $thread->subscriptions);

    }

}
