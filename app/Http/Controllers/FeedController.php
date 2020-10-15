<?php

namespace Playlog\Http\Controllers;

use Playlog\Comment;

class FeedController extends Controller
{
    public function index()
	{
		$comments = Comment::with(['user', 'reactions'])->orderBy('updated_at', 'desc')->get();
//		$f = $comments->first();
//		dd($f->reactions->first()->posted_on);

		return view('feed', compact('comments'));
	}
}
