<?php

namespace Playlog\Http\Controllers\Auth;

use Playlog\User;
use Playlog\Http\Controllers\Controller;
use Playlog\Http\Requests\CreateUserRequest;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

	/**
	 * @param CreateUserRequest $request
	 * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
	 */
    public function register(CreateUserRequest $request)
	{
		$user = $this->create($request->all());

		$this->guard()->login($user);

		return $this->registered($request, $user) ?: redirect($this->redirectPath());
	}

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Playlog\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
