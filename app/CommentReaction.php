<?php

namespace Playlog;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CommentReaction extends Model
{
    protected $fillable = ['content', 'author_id', 'comment_id', 'likes'];

	public $appends = [
		'posted_on',
	];

	/**
	 * A comment reaction belongs to a user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function user()
	{
		return $this->belongsTo(User::class, 'author_id');
	}

	/**
	 * A comment reaction belongs to a comment
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function comment()
	{
		return $this->belongsTo(Comment::class);
	}

	/**
	 * @return string
	 */
	public function getPostedOnAttribute()
	{
		return Carbon::parse($this->attributes['created_at'])->diffForHumans();
	}

	/**
	 * Get the total likes
	 */
	public function getLikes()
	{
		return $this->likes;
	}
}
