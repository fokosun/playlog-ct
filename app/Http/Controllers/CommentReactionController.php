<?php

namespace Playlog\Http\Controllers;

use Carbon\Carbon;
use Playlog\Comment;
use Illuminate\Http\Request;
use Playlog\CommentReaction;
use Playlog\Http\Requests\CreateCommentRequest;

class CommentReactionController extends Controller
{
	/**
	 * Create a new comment reaction (comment to a user comment)
	 *
	 * @param CreateCommentRequest $request
	 *
	 * @param $author_id
	 * @param $comment_id
	 *
	 * @return \Illuminate\Http\RedirectResponse
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
