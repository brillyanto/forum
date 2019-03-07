<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Reply;

class UserTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_has_owner()
    {
        $reply = factory(Reply::class)->create();
        $this->assertInstanceOf('App\User', $reply->owner);
    }
}
