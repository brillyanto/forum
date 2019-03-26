<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_records_activity_when_a_thread_is_created(){

        $user = factory('App\User')->create();
        $this->actingAs($user);

        $thread = factory('App\Thread')->create();

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id'=> auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread'
        ]);

        $activity = \App\Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);

    }


    public function test_it_records_activity_when_a_reply_is_created(){
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $reply = factory('App\Reply')->create();

        $this->assertEquals(2, \App\Activity::count());
    }


}
