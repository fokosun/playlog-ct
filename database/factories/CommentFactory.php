<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Playlog\Comment;
use Playlog\Model;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'content' => $faker->paragraph,
		'author_id' => 1
    ];
});
