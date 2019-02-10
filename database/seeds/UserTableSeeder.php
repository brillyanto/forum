<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)->create()->each(function($user){
            factory(App\Thread::class, 5)->create(['user_id' => $user->id])->each(function($thread){
                factory(App\Reply::class, 3)->create(['thread_id' => $thread->id]);
            });
        });
    }
}
