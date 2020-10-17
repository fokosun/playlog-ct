<?php

use Playlog\User;
use Playlog\Comment;
use Playlog\CommentReaction;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$min = 1;
    	$max = 50;

        $users = factory(User::class, $max)->create();

        foreach ($users as $user) {
        	//15 each
			factory(Comment::class)->create([
				'author_id' => $user->getKey()
			]);
		}

        $comments = Comment::all();

        foreach ($comments as $comment) {
        	factory(CommentReaction::class)->create([
        		'author_id' => rand($min, $max),
				'comment_id' => $comment->id
			]);
		}
    }
}
