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

        // $this->get($this->thread->path())
        //     ->assertSee($reply->body);

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);

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

    public function test_an_user_can_filter_thread_by_popularity(){
        //factory(App\Reply::class, 3)->create(['thread_id' => $thread->id]);

        $threadWithTwoReplies = factory('App\Thread')->create();
        factory('App\Reply', 2)->create(['thread_id' => $threadWithTwoReplies->id]);

        $threadWithoutReplies = $this->thread;

        $threadWithThreeReplies = factory('App\Thread')->create();
        factory('App\Reply', 3)->create(['thread_id' => $threadWithThreeReplies->id]);

        $response = $this->getJson('/threads?popular=1')->json();
       // dd(array_column($response, 'replies_count'));
        $this->assertEquals([3,2,0], array_column($response, 'replies_count'));

    }

    function test_a_user_can_filter_threads_by_those_that_are_unanswered(){
        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->create(['thread_id' => $thread->id]);
        $response = $this->getJson('/threads?unanswered=1')->json();
        $this->assertCount(1, $response);
    }

    function test_a_user_can_request_all_replies_for_a_given_thread(){
        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply',3)->create(['thread_id' => $thread->id]);
        $response = $this->getJson($thread->path(). '/replies')->json();
        // dd($response);
        $this->assertEquals(3, $response['total']);
    }

}