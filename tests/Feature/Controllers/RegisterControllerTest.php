<?php

namespace Tests\Feature\Controllers;

use Playlog\User;
use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterControllerTest extends TestCase
{
	use DatabaseMigrations, DatabaseTransactions;

	/**
	 * @test
	 */
	public function it_responds_with_422_if_the_username_and_password_are_not_given()
	{
		$this->json('POST', '/register', [])
			->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
			->assertJsonValidationErrors([
				'username', 'password'
			]);
	}

	/**
	 * @test
	 */
	public function it_responds_with_422_if_the_username_is_not_given()
	{
		$this->json('POST', '/register', ['password' => '123456789'])
			->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
			->assertJsonValidationErrors(['username']);
	}

	/**
	 * @test
	 */
	public function it_responds_with_422_if_the_password_is_not_given()
	{
		$this->json('POST', '/register', ['username' => 'sally'])
			->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
			->assertJsonValidationErrors(['password']);
	}

	/**
	 * @test
	 */
	public function it_responds_with_422_if_the_password_is_less_than_six_characters()
	{
		$this->json('POST', '/register', ['username' => 'pumpkin', 'password' => 'less'])
			->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
			->assertJsonValidationErrors(['password']);
	}

	/**
	 * @test
	 */
	public function it_responds_with_200_if_validation_passes()
	{
		$this->json('POST', '/register', ['username' => 'violet', 'password' => 'morethansixchars'])
			->assertStatus(Response::HTTP_FOUND);
	}

	/**
	 * @test
	 */
	public function it_creates_a_new_user_in_the_database()
	{
		$this->json('POST', '/register', ['username' => 'green', 'password' => 'morethansixchars']);

		$this->assertDatabaseHas('users', ['username' => 'green']);
	}
}
