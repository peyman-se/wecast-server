<?php

use Illuminate\Database\Seeder;

class ChannelSubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 600; $i++) {
            $userId = random_int(1, 20);
            $channelId = random_int(1, 50);
            $user = \App\User::find($userId);
            $user->subscriptions()->attach($channelId);
        }

//        factory(App\ChannelSubscription::class, 300)->create();
    }
}
