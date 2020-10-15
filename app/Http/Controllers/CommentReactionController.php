<?php

namespace Playlog\Http\Controllers;

use Illuminate\Http\Request;
use Playlog\CommentReaction;

class CommentReactionController extends Controller
{
	/**
	 * @param Request $request
	 * @param $author_id
	 * @param $comment_id
	 */
    public function store(Request $request, $author_id, $comment_id)
	{
		$reaction = new CommentReaction([
			'author_id' => $author_id,
			'comment_id' => $comment_id,
			'content' => $request->get('new_comment')
		]);

		if (! $reaction->save()) {
			return redirect()->back()->withErrors('There was ab error processing this request. Please try again');
		}

		return redirect()->back();
	}
}
