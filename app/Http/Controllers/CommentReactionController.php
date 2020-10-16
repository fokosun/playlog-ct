<?php

namespace Playlog\Http\Controllers;

use Illuminate\Http\Request;
use Playlog\Services\CommentReactionService;

class CommentReactionController extends Controller
{
	/**
	 * Create a new comment reaction (comment to a user comment)
	 *
	 * @param Request $request
	 *
	 * @param $author_id
	 * @param $comment_id
	 * @param CommentReactionService $service
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function store(Request $request, $author_id, $comment_id, CommentReactionService $service)
	{
		$request->merge([
			'author_id' => $author_id,
			'comment_id' => $comment_id
		]);

		if (! $service->store($request)) {
			return redirect()->back()->withErrors('There was ab error processing this request. Please try again');
		}

		return redirect('/');
	}
}
