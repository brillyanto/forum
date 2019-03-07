<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UserParticipationTest extends TestCase
{

    use RefreshDatabase;

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

    public function test_a_reply_requires_a_body(){
        $this->be($user = factory('App\User')->create());
        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make(['body' => null]);

        $this->post($thread->path().'/replies', $reply->toArray())
        ->assertSessionHasErrors('body');
        
        // $this->get($thread->path())
        //      ->assertSee($reply->body);




    }

}
