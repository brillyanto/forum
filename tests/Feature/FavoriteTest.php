<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Favorite;
use App\Reply;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_favorite_reply(){

        $reply = factory('App\Reply')->create();
        $this->post('/replies/'.$reply->id.'/favorite')
        ->assertRedirect('/login');
    }

    public function test_user_can_favorite_a_reply(){

        $this->withoutExceptionHandling();

        $this->actingAs(factory('App\User')->create());

        $reply = factory(Reply::class)->create();

        $this->post('replies/'.$reply->id.'/favorite');

        $this->assertCount(1, $reply->favorites);

    }

    public function test_user_cannot_favorite_on_a_reply_more_than_once(){

        $this->actingAs(factory('App\User')->create());

        $reply = factory(Reply::class)->create();

        $this->post('replies/'.$reply->id.'/favorite');

        $this->post('replies/'.$reply->id.'/favorite');

        $this->assertCount(1, $reply->favorites);
    }

}


