<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Thread;
use App\Channel;

class ReadThreadsTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    protected $thread;

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
        $response = $this->get('/threads/'.$this->thread->channel->id.'/'.$this->thread->id);
        $response->assertSee($this->thread->title);
    }

    public function test_a_thread_can_have_a_reply(){

        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    public function test_view_all_threads_by_its_channel_slug(){

        $channel = factory(\App\Channel::class)->create();
        $threadInChannel = factory(\App\Thread::class)->create(['channel_id' => $channel->id]);
        $threadNotInChannel = factory(\App\Thread::class)->create();
        
        $this->get("/threads/{$channel->slug}")
        ->assertSee($threadInChannel->title)
        ->assertDontSee($threadNotInChannel->title);
        
    }


    public function test_an_user_can_view_thread_by_username(){
        $user = factory(\App\User::class)->create(['name' => 'John Doe']);
        $threadByJohnDoe = factory(\App\Thread::class)->create(['user_id' => $user->id]);
        $threadNotByJohnDoe = factory(\App\Thread::class)->create();
        $this->get('/threads/?by='.$user->name)
        ->assertSee($threadByJohnDoe->title)
        ->assertDontSee($threadNotByJohnDoe->title);
    }


}
