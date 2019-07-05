<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToThreadTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_subscribe_to_threads()
    {
        $this->withoutExceptionHandling();
        $user = factory('App\User')->create();
        $this->be($user);
        $thread = factory('App\Thread')->create();
        $this->post($thread->path() . '/subscriptions');

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply here'
        ]);
        // issue a notification to the user
        // $this->assertCount(1, $thread->subscriptions);
    }

    public function test_a_user_can_unsubscribe_from_thread(){
        $this->withoutExceptionHandling();
        $user = factory('App\User')->create();
        $this->be($user);
        $thread = factory('App\Thread')->create();
        $thread->subscribe();
        $this->delete($thread->path() . '/subscriptions');
        $this->assertCount(0, $thread->subscriptions);
    }

}
