<?php

namespace Playlog;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['content', 'photo_url', 'author_id', 'updated_at'];

    public $appends = [
    	'posted_on',
	];

	/**
	 * A comment belongs to a user
	 */
    public function user()
	{
		return $this->belongsTo(User::class, 'author_id');
	}

	/**
	 * A comment has many comment reactions (comments, weird but yes)
	 */
	public function reactions()
	{
		return $this->hasMany(CommentReaction::class);
	}

	/**
	 * @return string
	 */
	public function getPostedOnAttribute()
	{
		return Carbon::parse($this->attributes['created_at'])->diffForHumans();
	}
}
