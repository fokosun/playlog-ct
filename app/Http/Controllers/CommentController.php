<?php

namespace Playlog\Http\Controllers;

use Playlog\User;
use Playlog\Comment;
use Playlog\Services\CommentService;
use Illuminate\Support\Facades\Auth;
use Playlog\Services\PhotoUploadService;
use Playlog\Http\Requests\CommentStoreRequest;

class CommentController extends Controller
{
	/**
	 * Create new comment
	 *
	 * @param CommentStoreRequest $request
	 * @param PhotoUploadService $uploadService
	 * @param CommentService $service
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function store(CommentStoreRequest $request, PhotoUploadService $uploadService, CommentService $service)
	{
		$request->merge(['author_id' => Auth::user()->id]);

		if (! $service->store($request->only(['author_id', 'content']))) {
			return redirect()->back()->withErrors(['error' => 'There was an error processing this request. Please try again.']);
		}

		if ($request->file('photo')) {
			$request->merge(['resource_photo_path' => 'photo_url']);
			$uploadService->upload($service->getComment(), $request);
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
