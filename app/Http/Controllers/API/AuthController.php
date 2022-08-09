<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class AuthController extends BaseController
{
	 /**
	 * Handle register API request
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function register(Request $request)
	{	
		$validator = Validator::make($request->all(), [
			'email' => 'required|email:rfc,dns|unique:users,email',
			'username' => 'required|unique:users,username',
			'password' => 'required|min:8',
			'password_confirmation' => 'required|same:password'
		]);
   
		if($validator->fails()) {
			return $this->sendError('Validation Error', $validator->errors());       
		}
		
		// --
		// Save user
		$input = $request->all();
		$user = User::create($input);

		// --
		// Send verify mail
		event(new Registered($user));

		$success['name'] =  $user->firstname;
   
		return $this->sendResponse($success, 'User register successfully.');
	}
   
	/**
	 * Handle login API request
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function login(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => 'required',
			'password' => 'required'
		]);

		$login_type = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL ) 
			? 'email' 
			: 'username';

			$request->merge([
			   $login_type => $request->input('email')
			]);

		if (Auth::attempt($request->only($login_type, 'password'))) {
			$user = Auth::user(); 
			$success['token'] =  $user->createToken('KeyCMA')->plainTextToken; 
			$success['name'] =  $login_type;
			
			// --
			// Logout from other devices
			Auth::logoutOtherDevices($request->input('password'));
			return $this->sendResponse($success, 'User login successfully.');
		} else { 
			return $this->sendError('Unauthorised', ['error' => 'Unauthorised']);
		} 
	}

	 /**
	 * Handle logout API request
	 * 
	 * @param RegisterRequest $request
	 * 
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request) 
	{
		$request->user()->currentAccessToken()->delete();

		return $this->sendResponse("success", 'User logout successfully.');
	}
}