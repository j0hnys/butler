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
        'project_id' => function () {
             return factory(App\Models\Project::class)->create()->id;
        },
        'definition_id' => function () {
             return factory(App\Models\Definition::class)->create()->id;
        },
        'name' => $faker->name,
        'functionality_data' => $faker->text,
        'request_data' => $faker->text,
        'response_data' => $faker->text,
        'db_table_name' => $faker->word,
        'parent_id' => $faker->randomNumber(),
        'type' => $faker->word,
    ];
});

