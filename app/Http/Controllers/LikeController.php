<?php

namespace Playlog\Http\Controllers;

use Playlog\CommentReaction;
use Playlog\Http\Requests\CommentLikesRequest;

class LikeController extends Controller
{
	/**
	 * Increase comment likes
	 *
	 * @param CommentLikesRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function store(CommentLikesRequest $request)
	{
		$reaction = CommentReaction::find((int) $request->get('reaction_id'));

		if ($true = $reaction->update(['likes' => $reaction->getLikes() + 1])) {
			return response()->json([
				'updated' => true,
				'likes_total' => $reaction->getLikes()
			]);
		}
	}
}
