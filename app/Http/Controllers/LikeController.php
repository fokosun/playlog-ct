<?php

namespace Playlog\Http\Controllers;

use Playlog\CommentReaction;

class LikeController extends Controller
{
	/**
	 * Increase comment likes
	 *
	 * @param $comment_id
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function store($comment_id)
	{
		$comment = CommentReaction::findOrFail($comment_id);

		$comment->update(['likes' => $comment->getLikes() + 1]);

		return redirect()->back();
	}
}
