<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadCreationTest extends TestCase
{

    use RefreshDatabase;

    protected $thread;

    public function setUp(){
        parent::setUp();
        $this->thread = factory('App\Thread')->make();
    }

    public function test_a_guest_cannot_create_a_thread(){

        $this->post('/threads', $this->thread->toArray())
             ->assertRedirect('/login');

        $this->get('/threads/create')
             ->assertSee('/login');

    }


    public function test_authenticated_user_can_create_a_thread(){

        

        $this->actingAs(factory('App\User')->create());

        $response = $this->post('/threads', $this->thread->toArray());
        
        $this->get($response->headers->get('Location')) // returns the location url 
            ->assertSee($this->thread->title)
            ->assertSee($this->thread->body);
    }

    public function test_guest_cannot_delete_a_thread(){
        //$this->withoutExceptionHandling();
        $thread = factory('App\Thread')->create();
        $response = $this->delete($thread->path());
        $response->assertRedirect('/login');
    }

    public function test_an_authenticated_user_can_delete_a_thread(){
        $this->withoutExceptionHandling();
        $this->actingAs(factory('App\User')->create());
        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->create(['thread_id' => $thread->id]);
        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(202);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }


    public function test_a_thread_requires_a_title(){

        //$this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());
        $this->publishThread(['title' => null])
        ->assertSessionHasErrors(['title']);
    }

    public function test_a_thread_requires_a_body(){
        $this->actingAs(factory('App\User')->create());
        $this->publishThread(['body' => null])
        ->assertSessionHasErrors(['body']);
    }

    public function test_a_thread_requires_a_valid_channel(){
        $this->actingAs(factory('App\User')->create());

        // created couple of channels
        // check if the given channel not in those channel ids

        factory('App\Channel', 2)->create();
        
        $this->publishThread(['channel_id' => null])
        ->assertSessionHasErrors(['channel_id']);

        $this->publishThread(['channel_id' => 999])
        ->assertSessionHasErrors(['channel_id']);
    }


    public function publishThread($overrides = []){

        $thread = factory('App\Thread')->make($overrides);
        $response = $this->post('/threads', $thread->toArray());
        
        return $response;
    }
   
}
