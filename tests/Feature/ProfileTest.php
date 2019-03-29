<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Thread;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_has_a_profile_page(){

        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        //$thread = factory(Thread::class)->create(['user_id' => $user->id]);

        $this->get('/profiles/'.$user->name)
        ->assertSee($user->name);

    }

    public function test_a_user_profiles_have_its_associated_threads(){
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $thread = factory(Thread::class)->create(['user_id' => $user->id]);
        $this->get('/profiles/'.$user->name)
        ->assertSee($thread->title);
        
    }

}
