<?php

/*
 * 20 users,
 * 50 channels,
 * 1000 medias,
 *
 */

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '123456',
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Channel::class, function (Faker\Generator $faker) {
    return [
        'user_id' => random_int(1, 20),
        'title'    => $faker->word,
        'description' => $faker->text(100),
        'cover' => $faker->imageUrl(400, 400)
    ];
});

$factory->define(App\Media::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
        'media' => $faker->url,
        'body' => $faker->sentence(50),
        'cover' => $faker->imageUrl(400, 400),
        'channel_id' => random_int(1,50),
    ];
});

//$factory->define(App\ChannelSubscription::class, function (Faker\Generator $faker) {
//    return [
//        'user_id' => random_int(1, 20),
//        'channel_id' => random_int(1, 50)
//    ];
//});
