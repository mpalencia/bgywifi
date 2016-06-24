<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
 */

$factory->define(BrngyWiFi\Modules\User\Models\User::class, function (Faker\Generator $faker) {
    return
        [
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'username' => $faker->userName,
        'password' => $faker->password,
        'address' => $faker->address,
        'contact_no' => $faker->phoneNumber,
        'remember_token' => str_random(10),
    ];
});

$factory->define(BrngyWiFi\Modules\Event\Models\Event::class, function (\Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'home_owner_id' => 2,
        'ref_category_id' => $faker->numberBetween(1, 5),
        'start' => $faker->dateTime,
        'end' => date('Y-m-d'),
        'status' => $faker->randomElement([0, 1]),
    ];
});

$factory->define(BrngyWiFi\Modules\GuestList\Models\GuestList::class, function (\Faker\Generator $faker) {
    return [
        'home_owner_id' => $faker->numberBetween(1, 2),
        'guest_name' => $faker->name,
    ];
});
