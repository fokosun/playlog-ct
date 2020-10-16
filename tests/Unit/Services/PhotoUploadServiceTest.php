<?php

namespace Tests\Unit\Services;

use Playlog\User;
use Tests\TestCase;
use Playlog\Comment;
use Illuminate\Http\Request;
use Playlog\Jobs\PhotoUploadJob;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Playlog\Services\PhotoUploadService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PhotoUploadServiceTest extends TestCase
{
	use DatabaseMigrations, DatabaseTransactions;

	protected User $user;

	public function setUp(): void
	{
		parent::setUp(); // TODO: Change the autogenerated stub

		$this->user = factory(User::class)->create();

		Queue::fake();
	}

	/**
	 * @test
	 */
	public function it_does_not_dispatched_the_photo_upload_job_if_the_request_is_missing_the_file()
	{
		$this->actingAs($this->user);

		$comment = factory(Comment::class)->create([
			'author_id' => $this->user->first()->getKey(),
			'content' => 'lorem ipsum'
		]);

		$service = new PhotoUploadService();
		$service->upload($comment->first(), new Request());

		Queue::assertNotPushed(PhotoUploadJob::class);
	}

	/**
	 * @todo revisit this
	 * @test
	 */
	public function it_dispatches_the_photo_upload_job_if_the_request_contains_a_file()
	{
		$this->actingAs($this->user);

		$comment = factory(Comment::class)->create([
			'author_id' => $this->user->first()->getKey(),
			'content' => 'lorem ipsum'
		]);

		$service = new PhotoUploadService();

		$request = new Request();
		$request->files->set('photo', UploadedFile::fake()->image('avatar.jpg'));

		$service->upload($comment->first(), $request);

		Queue::assertPushed(PhotoUploadJob::class);
	}
}
