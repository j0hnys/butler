<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factory
|--------------------------------------------------------------------------
*/


$factory->define(App\Models\Definition::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomNumber(),
        'project_id' => function () {
             return factory(App\Models\Project::class)->create()->id;
        },
        'namespace' => $faker->word,
    ];
});

