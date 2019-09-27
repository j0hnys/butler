<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factory
|--------------------------------------------------------------------------
*/


$factory->define(App\Models\View::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomNumber(),
        'project_id' => function () {
             return factory(App\Models\Project::class)->create()->id;
        },
        'entity_id' => function () {
             return factory(App\Models\Entity::class)->create()->id;
        },
        'definition_id' => function () {
             return factory(App\Models\Definition::class)->create()->id;
        },
        'name' => $faker->name,
        'type' => $faker->word,
        'presentation_data' => $faker->text,
        'vista_resource_folder_name' => $faker->word,
    ];
});

