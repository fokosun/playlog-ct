<?php

namespace Playlog\Services;

use Playlog\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\UnauthorizedException;
use Playlog\Contracts\PlaylogServiceContract;

class CommentService implements PlaylogServiceContract
{
	/**
	 * @var Comment
	 */
	protected Comment $comment;

	/**
	 * Create a new comment
	 *
	 * @param Request $request
	 * @return bool|mixed
	 */
	public function store(Request $request)
	{
		$this->comment = new Comment([
			'author_id' => Auth::user()->id,
			'content' => $request->get('content'),
			'photo_url' => $request->get('photo_url')
		]);

		return $this->comment->save();
	}

	/**
	 * Delete a given resource
	 *
	 * @param $resources
	 *
	 * @return void
	 * @throws \Exception
	 */
	public function delete($resources)
	{
		$comment = $user = null;

		if ($resources['comment'] instanceof Model) {
			$comment = $resources['comment'];
		}

		if ($resources['user'] instanceof Model) {
			$user = $resources['user'];
		}

		if ((!$comment instanceof Model) || (!$user instanceof Model)) {
			throw new ModelNotFoundException();
		}

		if (! $comment->user()->get()->first() === $user) {
			throw new UnauthorizedException('The resource to be deleted does not belong to this user.');
		}

		if ($comment->photo_url || Storage::disk('public')->exists($comment->photo_url)) {
			Storage::disk('public')->delete($comment->photo_url); //delete the image to declutter storage
		}

		$comment->delete();
	}

	/**
	 * Get the comment instance
	 *
	 * @return Comment
	 */
	public function getComment()
	{
		return $this->comment;
	}
}