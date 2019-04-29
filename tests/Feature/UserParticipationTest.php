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
        // ->assertSee($reply->body);
    }

    public function test_unauthorized_users_cannot_delete_replies(){
        // $this->withoutExceptionHandling();
        $reply = factory('App\Reply')->create();
        $this->delete("/replies/{$reply->id}")
        ->assertRedirect('login');

        $user = factory('App\User')->create();
        $this->be($user);
        $this->delete("/replies/{$reply->id}")
        ->assertStatus(403);
    }

    public function test_authenticated_users_can_delete_their_replies(){
        $user = factory('App\User')->create();
        $this->be($user);
        $reply = factory('App\Reply')->create(['user_id' => auth()->id()]);
        $this->delete("replies/{$reply->id}");
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    public function test_unauthorized_users_cannot_update_replies(){
        $reply = factory('App\Reply')->create();
        $this->delete("/replies/{$reply->id}")
        ->assertRedirect('login');

        $user = factory('App\User')->create();
        $this->be($user);
        $this->patch("/replies/{$reply->id}",['body' => "test"])
        ->assertStatus(403);
    }


    public function test_authorized_users_can_update_their_replies(){

        $this->withoutExceptionHandling();

        $user = factory('App\User')->create();
        $this->be($user);

        $reply = factory('App\Reply')->create(['user_id' => auth()->id()]);

        $updatedReply = 'You have changed!';
        $this->patch("/replies/{$reply->id}", ['body' => $updatedReply]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply ]);
    }

}
