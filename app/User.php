<?php

namespace Playlog;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

//	/**
//	 * A User has many reactions to comments
//	 *
//	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
//	 */
//    public function reactions()
//	{
//		return $this->hasMany(CommentReaction::class, 'author_id');
//	}

	/**
	 * A user has many comments
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function comment()
	{
		return $this->hasMany(Comment::class);
	}
}
