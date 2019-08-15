<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factory
|--------------------------------------------------------------------------
*/


$factory->define(App\Models\Project::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomNumber(),
        'name' => $faker->name,
        'root_folder' => $faker->word,
        'relative_schemas_folder' => $faker->word,
    ];
});

