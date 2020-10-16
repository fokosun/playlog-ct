<?php

namespace Playlog\Services;

use Carbon\Carbon;
use Playlog\Comment;
use Illuminate\Http\Request;
use Playlog\CommentReaction;
use Playlog\Contracts\PlaylogServiceContract;

class CommentReactionService implements PlaylogServiceContract
{
	/**
	 * @inheritDoc
	 */
	public function store(Request $request)
	{
		$reaction = new CommentReaction([
			'author_id' => $request->get('author_id'),
			'comment_id' => $request->get('comment_id'),
			'content' => $request->get('new_comment')
		]);

		if (! $reaction->save()) {
			return false;
		}

		$root_comment = Comment::find($request->get('comment_id'));
		$root_comment->update(['updated_at' => Carbon::now()->toDateTimeString()]);

		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function delete(array $resources) {}
}