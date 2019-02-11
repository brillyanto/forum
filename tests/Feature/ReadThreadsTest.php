<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Thread;

class ReadThreadsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    private $thread;

    public function setUp(){
        parent::setUp();
        $this->thread = factory(Thread::class)->create();
    }

    public function test_a_user_can_view_all_threads()
    {       
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);
    }

    public function test_a_user_can_view_single_thread(){
        $response = $this->get('/threads/'.$this->thread->id);
        $response->assertSee($this->thread->title);
    }

    public function test_a_thread_have_a_reply(){

        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);
            
        $this->get('/threads/'.$this->thread->id)
            ->assertSee($reply->body);

    }
}
