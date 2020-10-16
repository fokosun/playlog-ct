<?php

namespace Tests\Feature\Controllers;

use Playlog\User;
use Tests\TestCase;
use Playlog\Comment;
use Playlog\CommentReaction;
use Illuminate\Http\Response;

class LikeControllerTest extends TestCase
{
	protected User $user;

	public function setUp(): void
	{
		parent::setUp(); // TODO: Change the autogenerated stub

		$this->user = factory(User::class)->create();
	}

	/**
	 * @test
	 */
	public function it_responds_with_a_401_if_the_user_is_not_authenticated()
	{
		$user = factory(User::class)->create();

		$comment = factory(Comment::class)->create([
			'author_id' => $user->first()->getKey(),
			'content' => 'sample content'
		]);

		$reaction = factory(CommentReaction::class)->create([
			'author_id' => $user->first()->getKey(),
			'comment_id' => $comment->first()->getKey(),
			'content' => 'reaction to a comment'
		]);

		$this->json('POST', '/likes', [
			'reaction_id' => $reaction->first()->getkey()
		])->assertStatus(Response::HTTP_UNAUTHORIZED);
	}

	/**
	 * @test
	 */
	public function it_responds_with_a_422_if_the_comment_reaction_does_not_exist()
	{
		$this->actingAs($this->user);
		$this->json('POST', '/likes', [
			'reaction_id' => 0
		])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
	}

	/**
	 * @test
	 */
	public function it_can_increment_the_comment_reaction_likes_by_one()
	{
		$user = factory(User::class)->create();

		$comment = factory(Comment::class)->create([
			'author_id' => $user->first()->getKey(),
			'content' => 'sample content'
		]);

		$reaction = factory(CommentReaction::class)->create([
			'author_id' => $user->first()->getKey(),
			'comment_id' => $comment->first()->getKey(),
			'content' => 'reaction to a comment'
		]);

		$this->assertSame(0, $reaction->first()->getLikes());

		$this->actingAs($user);

		$this->json('POST', '/likes', [
			'reaction_id' => $reaction->first()->getkey()
		]);

		$this->assertSame(1, $reaction->first()->getLikes());
	}
}
