<?php

namespace Playlog\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
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
		if ($request->get('author_id') !== Auth::user()->id) {
			throw new UnauthorizedException('You are not authorized to perform this action.');
		}

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