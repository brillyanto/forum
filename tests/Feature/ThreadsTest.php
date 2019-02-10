<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Thread;

class ThreadsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_view_all_threads()
    {
        $thread = factory(Thread::class)->create();
        $response = $this->get('/threads');
        $response->assertSee($thread->title);
    }

    public function test_a_user_can_view_single_thread(){
        $thread = Thread::find(1);
        $response = $this->get('/threads/'.$thread->id);
        $response->assertSee($thread->title);
    }
}
