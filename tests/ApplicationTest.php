<?php

namespace Tests;

use Playlog\User;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApplicationTest extends TestCase
{
	use DatabaseTransactions, DatabaseMigrations;

	/**
	 * @test
	 */
	public function a_guest_is_redirected_to_the_login_page()
	{
		$this->json('GET', '/')
			->assertRedirect('/login')
			->assertStatus(Response::HTTP_FOUND);
	}

	/**
	 * @test
	 */
	public function a_guest_can_see_the_login_form()
	{
		$this->json('GET', '/login')
			->assertSee('username')
			->assertSee('password')
			->assertSee('login')
			->assertStatus(Response::HTTP_OK);
	}

	/**
	 * @test
	 */
	public function a_guest_can_see_the_register_page()
	{
		$this->json('GET', '/register')
			->assertSee('username')
			->assertSee('password')
			->assertSee('password_confirmation')
			->assertSee('register')
			->assertStatus(Response::HTTP_OK);
	}

	/**
	 * @test
	 */
	public function an_authenticated_user_is_always_redirected_to_the_feed_page_from_the_home_page()
	{
		$user = factory(User::class)->create();
		$this->actingAs($user);
		$this->json('GET', '/')
			->assertRedirect('/feed')
			->assertStatus(Response::HTTP_FOUND);
	}

	/**
	 * @test
	 */
	public function a_user_is_redirected_to_feed_page_after_successful_authentication()
	{
		$credentials = [
			'username' => 'cherry',
			'password' => 'pumpkin123'
		];

		$this->json('POST', '/register', $credentials);
		$this->json('POST', '/login', $credentials)->assertRedirect('/feed');
	}

	/**
	 * @test
	 */
	public function a_guest_does_not_have_authorization_to_see_the_feed_page()
	{
		$this->json('GET', '/feed')->assertStatus(Response::HTTP_UNAUTHORIZED);
	}
}
