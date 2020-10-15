<?php

namespace Playlog\Http\Controllers;

use Playlog\Comment;
use Illuminate\Support\Facades\Auth;
use Playlog\Http\Requests\CreateCommentRequest;

class CommentController extends Controller
{
    public function store(CreateCommentRequest $request)
	{
		$comment = new Comment([
			'author_id' => Auth::user()->id,
			'content' => $request->get('content'),
			'photo_url' => $request->get('photo_url')
		]);

		if (! $comment->save()) {
			return redirect()->back()->withErrors(['error' => 'There was an error processing this request. Please try again.']);
		}

		return redirect()->back();
	}
}
