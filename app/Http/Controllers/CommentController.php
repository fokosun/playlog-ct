<?php

namespace Playlog\Http\Controllers;

use Playlog\User;
use Playlog\Comment;
use Playlog\Services\CommentService;
use Playlog\Services\PhotoUploadService;
use Playlog\Http\Requests\CreateCommentRequest;

class CommentController extends Controller
{
	/**
	 * Create new comment
	 *
	 * @param CreateCommentRequest $request
	 * @param PhotoUploadService $uploadService
	 * @param CommentService $service
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function store(CreateCommentRequest $request, PhotoUploadService $uploadService, CommentService $service)
	{
		if (! $service->store($request)) {
			return redirect()->back()->withErrors(['error' => 'There was an error processing this request. Please try again.']);
		}

		if ($request->file('photo')) {
			$uploadService->upload($service->getComment(), $request, ['resource_photo_path' => 'photo_url']);
		}

		return redirect('/');
	}

	/**
	 * Delete a comment
	 *
	 * @param Comment $comment
	 * @param User $user
	 * @param CommentService $service
	 *
	 * @throws \Exception
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function delete(Comment $comment, User $user, CommentService $service)
	{
		$service->delete(['comment' => $comment, 'user' => $user]);

		return redirect('/');
	}
}
