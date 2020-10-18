<?php

namespace Tests\Unit\Services;

use Playlog\User;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;
use Tests\TestCase;
use Playlog\Comment;
use Illuminate\Http\Request;
use Playlog\Jobs\PhotoUploadJob;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Playlog\Services\PhotoUploadService;

class PhotoUploadServiceTest extends TestCase
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
	public function it_does_not_dispatch_the_photo_upload_job_if_the_request_is_missing_the_file()
	{
		Queue::fake();

		$this->actingAs($this->user);

		$comment = factory(Comment::class)->create([
			'author_id' => $this->user->first()->getKey(),
			'content' => 'lorem ipsum'
		]);

		$service = new PhotoUploadService();
		$service->upload($comment->first(), new Request());

		Queue::assertNotPushed(PhotoUploadJob::class, function ($job) {
			return $job->photo instanceof UploadedFile;
		});
	}

	/**
	 * @test
	 */
	public function it_successfully_uploads_the_image()
	{
		$this->actingAs($this->user);

		$comment = factory(Comment::class)->create([
			'author_id' => $this->user->first()->getKey(),
			'content' => 'lorem ipsum'
		]);

		$this->assertNull($comment->photo_url);

		$service = new PhotoUploadService();

		$request = new Request();
		$request->files->set('photo', UploadedFile::fake()->image('avatar.png'));
		$request->merge(['resource_photo_path' => 'photo_url']);

		$service->upload($comment->first(), $request);
		$comment = Comment::find($comment->first()->getKey());

		$this->assertNotNull($comment->photo_url);

		Storage::disk('public')->delete($comment->photo_url); //cleanup
	}
}
