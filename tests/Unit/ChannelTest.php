<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Channel;
use App\Thread;

class ChannelTest extends TestCase
{

    use RefreshDatabase;

    public function test_a_channel_contains_many_threads(){
        $channel = factory('App\Channel')->create();
        $thread = factory(Thread::class)->create(['channel_id' => $channel->id]);
        $this->assertTrue($channel->threads->contains($thread));
    }

}
