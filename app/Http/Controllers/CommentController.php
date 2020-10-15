<?php

namespace Playlog\Http\Controllers;

use Playlog\User;
use Playlog\Comment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Playlog\Http\Requests\CreateCommentRequest;

class CommentController extends Controller
{
	/**
	 * Create new comment
	 *
	 * @param CreateCommentRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function store(CreateCommentRequest $request)
	{
		$comment = new Comment([
			'author_id' => Auth::user()->id,
			'content' => $request->get('content'),
			'photo_url' => $request->get('photo_url')
		]);

		if (! $comment->save()) {
			Log::info('error', [
				'user' => Auth::user()->id,
				'error' => 'Failed to create new comment.'
			]);

			return redirect()->back()->withErrors(['error' => 'There was an error processing this request. Please try again.']);
		}

		return redirect()->back();
	}

	/**
	 * Delete a comment
	 *
	 * @param Comment $comment
	 * @param User $user
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function delete(Comment $comment, User $user)
	{
		if (! $comment->user()->get()->first() === $user) {

			Log::info('error', [
				'user' => $user->id,
				'error' => 'The given resource does not belong to this user.'
			]);

			return redirect()->back()->withErrors(['error' => 'Forbidden. You are not authorized to perform this action.']);
		}

		$comment->delete();

		return redirect()->back();
	}
}
