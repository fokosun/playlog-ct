<?php

namespace Playlog\Services;

use Carbon\Carbon;
use Playlog\Comment;
use Playlog\CommentReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Playlog\Contracts\PlaylogServiceContract;
use Illuminate\Validation\UnauthorizedException;

class CommentReactionService implements PlaylogServiceContract
{
	/**
	 * @inheritDoc
	 */
	public function store(Request $request)
	{
		if ((int) $request->get('author_id') !== Auth::user()->id) {
			throw new UnauthorizedException('You are not authorized to perform this action.');
		}

		$reaction = new CommentReaction([
			'author_id' => $request->get('author_id'),
			'comment_id' => $request->get('comment_id'),
			'content' => $request->get('comment')
		]);

		if (! $reaction->save()) {
			return false;
		}

		//if current active user is the one adding the comment reaction bubble it up in the feed page
		if ((int) $request->get('author_id') == Auth::user()->id) {
			$root_comment = Comment::find($request->get('comment_id'));
			$root_comment->update(['updated_at' => Carbon::now()->toDateTimeString()]);
		}

		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function delete(array $resources) {}
}