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
    public function test_a_user_can_browse_threads()
    {
        $thread = factory(Thread::class)->create();
        $response = $this->get('/threads');
        $response->assertSee($thread->title);
    }
}
