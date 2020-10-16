<?php

namespace Tests\Feature\Controllers;

use Playlog\Comment;
use Playlog\User;
use Tests\TestCase;
use Illuminate\Http\Response;

class CommentControllerTest extends TestCase
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
	public function it_responds_with_a_422_if_the_comment_content_is_not_given()
	{
		$this->actingAs($this->user);

		$this->json('POST', '/comments', [])
			->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
			->assertJsonValidationErrors([
				'content', 'author_id'
			]);
	}

	/**
	 * @test
	 */
	public function it_responds_with_a_422_if_the_author_id_is_not_given()
	{
		$this->actingAs($this->user);

		$this->json('POST', '/comments', ['content' => 'lorem ipsum'])
			->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
			->assertJsonValidationErrors([
				'author_id'
			]);
	}

	/**
	 * @test
	 */
	public function it_responds_with_a_422_if_the_given_author_does_not_exist()
	{
		$this->actingAs($this->user);

		$this->json('POST', '/comments', ['content' => 'lorem ipsum', 'author_id' => 0])
			->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
			->assertJsonValidationErrors([
				'author_id'
			]);
	}

	/**
	 * @test
	 */
	public function it_successfully_creates_a_comment_when_a_picture_is_not_uploaded()
	{
		$this->actingAs($this->user);

		$this->json('POST', '/comments', ['content' => 'lorem ipsum', 'author_id' => $this->user->getKey()])
			->assertStatus(Response::HTTP_FOUND);

		$this->assertDatabaseHas('comments', ['content' => 'lorem ipsum', 'author_id' => $this->user->getKey()]);

		$newest_comment = Comment::all()->last();
		$this->assertNull($newest_comment->photo_url);
	}

	/**
	 * @test
	 */
	public function it_can_delete_a_comment()
	{
		$this->actingAs($this->user);

		$this->json('POST', '/comments', ['content' => 'lorem ipsum', 'author_id' => $this->user->getKey()]);
		$comment = Comment::all()->last();

		$this->json('DELETE', '/comments/' . $comment->getKey() . '/' . $this->user->getKey());

		$this->assertDatabaseMissing('comments', [
			'id' => $comment->getKey(),
			'content' => 'lorem ipsum',
			'author_id' => $this->user->getKey()
		]);
	}
}