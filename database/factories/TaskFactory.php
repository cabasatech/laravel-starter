<?php

use Faker\Generator as Faker;

$factory->define(
    App\Task::class, function (Faker $faker) {
        return [
            'subject' => $faker->word(3, true),
            'description' => $faker->sentence(3, true)
        ];
    }
);