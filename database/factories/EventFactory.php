<?php

/**
 * @var $factory Illuminate\Database\Eloquent\Factory
 */

$factory->define(\BrngyWiFi\Modules\Event\Models\Event::class, function (\Faker\Generator $faker) {
    return [
        'home_owner_id' => 2,
        'name' => $faker->word,
        'start' => $faker->dateTime,
        'status' => $faker->randomElement([0, 1]),
    ];
});
