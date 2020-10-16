<?php

namespace Playlog\Http\Controllers;

use Playlog\Comment;
use Playlog\Services\FeedService;

class FeedController extends Controller
{
	/**
	 * Fetch all comments along with its relationships
	 *
	 * @param FeedService $service
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function index(FeedService $service)
	{
		$comments = $service->index(
			Comment::class,
			[
				'user',
				'reactions'
			], [
				'order_by' => 'updated_at',
				'order' => 'desc',
				'paginate' => 5
			]
		);

		return view('feed', compact('comments'));
	}
}
