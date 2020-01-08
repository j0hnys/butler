<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factory
|--------------------------------------------------------------------------
*/


$factory->define(App\Models\Test::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomNumber(),
        'project_id' => $faker->randomNumber(),
        'definition_id' => $faker->randomNumber(),
        'entity_id' => $faker->randomNumber(),
        'name' => $faker->name,
        'type' => $faker->word,
        'functionality_data' => $faker->text,
        'request_data' => $faker->text,
        'response_data' => $faker->text,
    ];
});

