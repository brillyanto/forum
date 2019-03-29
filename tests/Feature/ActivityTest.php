<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use App\Activity;

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

    public function test_it_fetches_a_feed_for_any_user(){
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $thread = factory('App\Thread', 2)->create(['user_id' => $user->id]);

        // for test it this line is not requried
        //$thread_old = factory('App\Thread')->create(['user_id' => $user->id, 'created_at' => Carbon::now()->subWeek() ]);

        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        $feed = Activity::feed($user);

        //dd($feed->toArray());

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }

}
