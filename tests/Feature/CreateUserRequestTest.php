<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;

class CreateUserRequestTest extends TestCase
{
    /**
     * @test
     */
    public function it_responds_with_422_if_the_username_and_password_are_not_given()
    {
    	$response = $this->json('POST', '/register', []);
    	$decoded = json_decode($response->getContent(), true);

    	$this->assertArrayHasKey('username', $decoded);
    	$this->assertSame('The username field is required.', $decoded["username"][0]);

		$this->assertArrayHasKey('password', $decoded);
		$this->assertSame('The password field is required.', $decoded["password"][0]);

		$this->assertSame($response->getStatusCode(), Response::HTTP_UNPROCESSABLE_ENTITY);
    }

	/**
	 * @test
	 */
	public function it_responds_with_422_if_the_username_is_not_given()
	{
		$response = $this->json('POST', '/register', [
			'password' => 'iamatleastsixcharacterslong'
		]);

		$decoded = json_decode($response->getContent(), true);

		$this->assertArrayHasKey('username', $decoded);
		$this->assertSame('The username field is required.', $decoded["username"][0]);
		$this->assertArrayNotHasKey('password', $decoded);

		$this->assertSame($response->getStatusCode(), Response::HTTP_UNPROCESSABLE_ENTITY);
	}

	/**
	 * @test
	 */
	public function it_responds_with_422_if_the_password_is_not_given()
	{
		$response = $this->json('POST', '/register', [
			'username' => 'pumpkin'
		]);

		$decoded = json_decode($response->getContent(), true);

		$this->assertArrayHasKey('password', $decoded);
		$this->assertSame('The password field is required.', $decoded["password"][0]);
		$this->assertArrayNotHasKey('username', $decoded);

		$this->assertSame($response->getStatusCode(), Response::HTTP_UNPROCESSABLE_ENTITY);
	}

	/**
	 * @test
	 */
	public function it_responds_with_422_if_the_password_length_is_less_than_six_characters()
	{
		$response = $this->json('POST', '/register', [
			'username' => 'pumpkin',
			'password' => 'less'
		]);

		$decoded = json_decode($response->getContent(), true);

		$this->assertArrayHasKey('password', $decoded);
		$this->assertSame('The password must be at least 6 characters.', $decoded["password"][0]);
		$this->assertArrayNotHasKey('username', $decoded);

		$this->assertSame($response->getStatusCode(), Response::HTTP_UNPROCESSABLE_ENTITY);
	}

	/**
	 * @test
	 */
	public function it_responds_with_200_if_validation_passes()
	{
		$response = $this->json('POST', '/register', [
			'username' => 'pumpkin',
			'password' => 'goodpassword'
		]);

		$this->assertSame($response->getStatusCode(), Response::HTTP_OK);
	}
}
