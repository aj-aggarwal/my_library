<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
	/**
	 * Register a new User
	 */
    public function register(RegisterRequest $request)
    {
	    $input = $request->all();
		// password hash before save
	    $input['password'] = Hash::make($input['password']);
	    $input['remember_token'] = Str::random(10);

	    $user = User::create($input);

	    return response(["message" => trans('messages.registered_successfully')], 200);
	}

	/**
	 * Login User
	 */
	public function login(Request $request)
	{
		$request->validate([
	        'email' => 'required|string|email',
	        'password' => 'required', 
	    ]);

		//Check if user exists with given email..
		$user = User::where('email', $request->email)->first();
		
		if (!$user) {
			// User not found..
			return response(["message" => trans('messages.invalid_credentials')], 422);
		}

		// Match password
		if (Hash::check($request->password, $user->password)) {
			// Generate Access token
			$token = $user->createToken(config('constants.personal_grant_client'))->accessToken;
			$response = ['token' => $token];

			return response($response, 200);
		} else {
			// Password not matched..
			return response(["message" => trans('messages.invalid_credentials')], 422);
		}
	}

	/**
	 * Logout the user
	 */
	public function logout(Request $request) 
	{
		// Revoke Access Token
		$token = $request->user()->token();
		$token->revoke();

		return response(['message' => trans('messages.logout_success')], 200);
	}
}
