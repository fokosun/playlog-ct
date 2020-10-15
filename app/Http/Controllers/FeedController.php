<?php

namespace Playlog\Http\Controllers;

use Playlog\Comment;

class FeedController extends Controller
{
	/**
	 * Fetch all comments along with its relationships
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
	 */
    public function index()
	{
		$comments = Comment::with(['user', 'reactions'])
			->orderByDesc('updated_at')
			->paginate('5');

		return view('feed', compact('comments'));
	}
}
