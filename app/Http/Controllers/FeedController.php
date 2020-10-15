<?php

namespace Playlog\Http\Controllers;

use Playlog\Comment;

class FeedController extends Controller
{
    public function index()
	{
		$comments = Comment::with(['user', 'reactions'])
			->orderBy('updated_at', 'desc')
			->paginate('5');

		return view('feed', compact('comments'));
	}
}
