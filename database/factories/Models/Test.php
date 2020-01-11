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
        'project_id' => function () {
             return factory(App\Models\Project::class)->create()->id;
        },
        'definition_id' => function () {
             return factory(App\Models\Definition::class)->create()->id;
        },
        'entity_id' => function () {
             return factory(App\Models\Entity::class)->create()->id;
        },
        'name' => $faker->name,
        'type' => $faker->word,
        'functionality_data' => $faker->text,
        'request_data' => $faker->text,
        'response_data' => $faker->text,
        'parent_id' => $faker->randomNumber(),
    ];
});

