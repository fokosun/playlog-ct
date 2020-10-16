<?php

namespace Tests\Feature\Controllers;

use Playlog\User;
use Tests\TestCase;
use Illuminate\Http\Response;

class FeedControllerTest extends TestCase
{

	/**
	 * @test
	 */
	public function it_responds_with_401_if_there_is_no_user_session()
	{
		$this->json('GET', '/feed')->assertStatus(Response::HTTP_UNAUTHORIZED);
	}

	/**
	 * @test
	 */
	public function it_responds_with_200_if_there_is_a_user_session()
	{
		$user = factory(User::class)->create();
		$this->actingAs($user);

		$this->json('GET', '/feed')->assertStatus(Response::HTTP_OK);
	}

	/**
	 * @test
	 */
	public function it_has_the_comments_data()
	{
		$this->user = factory(User::class)->create();
		$this->actingAs($this->user);

		$this->json('GET', '/feed')->assertViewHas('comments');
	}
}