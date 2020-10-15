<?php

namespace Playlog\Http\Controllers;

use Playlog\Comment;
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
			return redirect()->back()->withErrors(['error' => 'There was an error processing this request. Please try again.']);
		}

		return redirect()->back();
	}

	/**
	 * Delete a comment
	 *
	 * @param Comment $comment
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function delete(Comment $comment)
	{
		$comment->delete();

		return redirect()->back();
	}
}
