<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => '1',
        'titulo' => $faker->name,
        'contenido' => $faker->text(10)
    ];
});
