<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadCreationTest extends TestCase
{
    protected $thread;

    public function setUp(){
        parent::setUp();
        $this->thread = factory('App\Thread')->make();
    }

    public function test_a_guest_cannot_create_a_thread(){

        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        
        $this->post('/threads', $this->thread->toArray())
        ->assertRedirect('/login');
    }


    public function test_authenticated_user_can_create_a_thread(){

        $this->actingAs(factory('App\User')->create());
        $this->post('/threads', $this->thread->toArray());
        $this->get('/threads')->assertSee($this->thread->title);
    }

    public function test_guest_cannot_see_create_thread_page(){

        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->get('/threads/create')
            ->assertSee('/login');
    }

}
