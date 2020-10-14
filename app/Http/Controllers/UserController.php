<?php

namespace Playlog\Http\Controllers;

use Playlog\Http\Requests\CreateUserRequest;

class UserController extends Controller
{
	/**
	 * Display registration form
	 */
	public function getRegister()
	{
		return view('auth/register');
	}

	/**
	 * Display login form
	 */
	public function getLogin()
	{
		return view('auth/login');
	}

    public function store(CreateUserRequest $request){}
}
