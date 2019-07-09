<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;
    
    public function setUp(){
        parent::setUp();
        $this->be(factory('App\User')->create());
    }

    function test_a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply(){

        
        $thread = factory('App\Thread')->create();

        $thread->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        // reply created by self shoud not get notifications
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply here'
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        // reply created by somebody else should get notifications
        $thread->addReply([
            'user_id' => factory('App\User')->create()->id,
            'body' => 'Some reply here'
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);

    }

    function test_a_user_can_mark_as_read_a_notification(){
        
        
        $thread = factory('App\Thread')->create();

        $thread->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        // reply created by somebody else should get notifications
        $thread->addReply([
            'user_id' => factory('App\User')->create()->id,
            'body' => 'Some reply here'
        ]);

        $this->assertCount(1, auth()->user()->unreadNotifications);

        $notificationId = auth()->user()->unreadNotifications->first()->id;

        $this->delete('/profiles/'.auth()->user()->name.'/notifications/'.$notificationId );

        $this->assertCount(0, auth()->user()->fresh()->unreadNotifications);

    }

    function test_a_user_can_fetch_their_unread_notifications(){
        
        $thread = factory('App\Thread')->create();
        $thread->subscribe();
        // reply created by somebody else should get notifications
        $thread->addReply([
            'user_id' => factory('App\User')->create()->id,
            'body' => 'Some reply here'
        ]);
        $response = $this->getJson("/profiles/{auth()->user()->name}/notifications")->json();
        $this->assertCount(1, $response);
    }

}
