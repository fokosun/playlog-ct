<?php

namespace Playlog\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Playlog\Comment;
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

		$root_comment = Comment::find($comment_id);

		$root_comment->update(['updated_at' => Carbon::now()->toDateTimeString()]);

		return redirect()->back();
	}
}
