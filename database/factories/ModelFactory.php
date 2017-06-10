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

//$factory->define(App\User::class, function (Faker\Generator $faker) {
//    return [
//        'username'       => $faker->userName . $faker->userName,
//        'email'          => $faker->userName . $faker->email,
//        'password'       => '123456',
//        'first_name'     => $faker->firstName,
//        'family_name'    => $faker->lastName,
//        'avatar'         => 'https://www.gravatar.com/avatar/' . md5(str_random(10)),
//        'gender'         => $faker->numberBetween(1, 3),
//        'birthday'       => $faker->dateTimeThisCentury,
//        'bio'            => $faker->text,
//        'phone'          => $faker->phoneNumber,
//        'settings'       => json_encode(['a' => 10, 'b' => 'ccccc', 'd' => true]),
//        'google_id'      => $faker->numberBetween(1000000000000, 9999999999999),
//        'facebook_id'    => $faker->numberBetween(1000000000000, 9999999999999),
//        'remember_token' => str_random(10),
//    ];
//});

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
