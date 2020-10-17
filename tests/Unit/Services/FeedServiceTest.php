<?php

namespace Tests\Unit\Services;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Playlog\CommentReaction;
use Playlog\User;
use Tests\TestCase;
use Playlog\Comment;
use Playlog\Services\FeedService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class FeedServiceTest extends TestCase
{
	use DatabaseMigrations, DatabaseTransactions;

	/**
	 * @test
	 */
	public function it_returns_an_instance_of_eloquent_collection_if_pagination_is_not_given()
	{
		//create users
		$users = factory(User::class, 2)->create();

		//create comments
		factory(Comment::class, 2)->create([
			'content' => 'lorem lorem ipsum',
			'author_id' => $users->first()->id
		]);

		factory(Comment::class, 3)->create([
			'content' => 'lorem lorem ipsum ipsum dolores i swear iono what that means',
			'author_id' => $users->last()->id
		]);

		$service = new FeedService();
		$comments = $service->get(Comment::class, ['user', 'reactions'], ['order_by' => 'updated_at', 'order' => 'desc']);

		$this->assertInstanceOf(Collection::class, $comments);
	}

	/**
	 * @test
	 */
	public function it_returns_an_instance_of_paginator_if_pagination_is_given()
	{
		//create users
		$users = factory(User::class, 2)->create();

		//create comments
		factory(Comment::class, 2)->create([
			'content' => 'lorem lorem ipsum',
			'author_id' => $users->first()->id
		]);

		factory(Comment::class, 3)->create([
			'content' => 'lorem lorem ipsum ipsum dolores i swear iono what that means',
			'author_id' => $users->last()->id
		]);

		$service = new FeedService();
		$comments = $service->get(Comment::class,
			[
				'user',
				'reactions'
			], [
				'order_by' => 'updated_at',
				'order' => 'desc',
				'paginate' => 1
			]
		);

		$this->assertInstanceOf(LengthAwarePaginator::class, $comments);
	}

	/**
	 * Default order: created_at, asc
	 * @test
	 */
	public function it_returns_the_comments_collection_in_the_default_order()
	{
		//create users
		$users = factory(User::class, 2)->create();

		//create comments
		factory(Comment::class, 2)->create([
			'content' => 'lorem lorem ipsum',
			'author_id' => $users->first()->id
		]);

		factory(Comment::class, 3)->create([
			'content' => 'lorem lorem ipsum ipsum dolores i swear iono what that means',
			'author_id' => $users->last()->id
		]);

		$original = Comment::all();

		$service = new FeedService();
		$default_order_feed = $service->get(Comment::class);

		$this->assertSame($default_order_feed->first()->getKey(), $original->first()->getKey());
		$this->assertSame($default_order_feed->last()->getKey(), $original->last()->getKey());
	}

	/**
	 * @test
	 */
	public function it_returns_the_comments_with_the_given_relationships()
	{
		//create users
		$users = factory(User::class, 2)->create();

		//create comments
		factory(Comment::class, 2)->create([
			'content' => 'lorem lorem ipsum',
			'author_id' => $users->first()->id
		]);

		factory(Comment::class, 3)->create([
			'content' => 'lorem lorem ipsum ipsum dolores i swear iono what that means',
			'author_id' => $users->last()->id
		]);

		$service = new FeedService();
		$default_order_feed = $service->get(Comment::class, ['user']);

		$this->assertInstanceOf(User::class, $default_order_feed->first()->user);
	}

	/**
	 * Like Twitter feed, status are reordered with the one with the most recent activity at the top
	 * The feed service orders the collection in the given order
	 * To achieve the twitter way, pass the order_by as updated_at date and the order desc
	 * To see the effect, add a comment reaction to an existing comment, this updates the
	 * updated_at date of the original comment
	 *
	 * @test
	 */
	public function it_returns_the_comments_in_chronological_order_when_an_update_occurs()
	{
		//create users
		$users = factory(User::class, 2)->create();

		//create comments
		factory(Comment::class, 2)->create([
			'content' => 'lorem lorem ipsum',
			'author_id' => $users->first()->id
		]);

		factory(Comment::class, 3)->create([
			'content' => 'lorem lorem ipsum ipsum dolores i swear iono what that means',
			'author_id' => $users->last()->id
		]);

		$beforeReaction = Comment::all();

		$user = factory(User::class)->create();
		$this->actingAs($user);

		factory(CommentReaction::class)->create([
			'content' => 'reply to a comment.',
			'author_id' => $user->id,
			'comment_id' => $beforeReaction->last()->getKey(),
			'likes' => 0
		]);

		$beforeReaction->last()->updated_at = '2020-01-01 00:00:00';
		//harcoded date since objects are run within the same minute does not show any diff
		//to prove that the feedservice actually does the sorting, the order is set to asc because
		//of this backdated date

		$beforeReaction->last()->save();

		$feedService = new FeedService();

		$chrono_order_feed = $feedService->get(Comment::class, ['user'], [
				'order_by' => 'updated_at',
				'order' => 'asc'
			]
		);

		$this->assertSame($chrono_order_feed->first()->getKey(), $beforeReaction->last()->getKey());
	}
}