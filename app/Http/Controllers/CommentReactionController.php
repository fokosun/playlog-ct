<?php

namespace Playlog\Http\Controllers;

use Playlog\Http\Requests\CommentReactionStoreRequest;
use Playlog\Services\CommentReactionService;

class CommentReactionController extends Controller
{
	/**
	 * Create a new comment reaction (comment to a user comment)
	 *
	 * @param CommentReactionStoreRequest $request
	 * @param CommentReactionService $service
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function store(CommentReactionStoreRequest $request, CommentReactionService $service)
	{
		if (! $service->store($request)) {
			return redirect()->back()->withErrors('There was ab error processing this request. Please try again');
		}

		return redirect('/feed');
	}
}
