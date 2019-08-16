<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factory
|--------------------------------------------------------------------------
*/


$factory->define(App\Models\Entity::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomNumber(),
        'project_id' => $faker->randomNumber(),
        'definition_id' => $faker->randomNumber(),
        'name' => $faker->name,
    ];
});

