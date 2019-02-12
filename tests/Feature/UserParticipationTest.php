<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UserParticipationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_authenticated_user_can_post_reply_to_a_thread()
    {
        $this->be($user = factory('App\User')->create());
        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make();

        $this->post($thread->path().'/replies', $reply->toArray());
        
        $this->get($thread->path())
             ->assertSee($reply->body);

    }
}
