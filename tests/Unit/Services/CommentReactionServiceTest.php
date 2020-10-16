<?php

namespace Tests\Unit\Services;

use Playlog\User;
use Tests\TestCase;
use Playlog\Comment;
use Illuminate\Http\Request;
use Playlog\Services\CommentReactionService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentReactionServiceTest extends TestCase
{
	use DatabaseMigrations, DatabaseTransactions;

	/**
	 * @test
	 */
	public function it_successfully_create_a_comment_reaction()
	{
		$user = factory(User::class)->create();
		$this->actingAs($user);

		$comment = factory(Comment::class)->create([
			'author_id' => $user->first()->getKey(),
			'content' => 'main comment'
		]);

		$request = new Request([
			'author_id' => $user->first()->getKey(),
			'comment_id' => $comment->first()->getKey(),
			'content' => 'lorem ipsum'
		]);

		$service = new CommentReactionService();

		$this->assertTrue($service->store($request));
	}
}