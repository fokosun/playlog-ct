<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Playlog\CommentReaction;
use Playlog\Model;

$factory->define(CommentReaction::class, function (Faker $faker) {
    return [
        'content' => $faker->paragraph,
		'author_id' => 1,
		'comment_id' => 1
    ];
});
