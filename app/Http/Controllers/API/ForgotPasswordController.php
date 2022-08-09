<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;

use DB; 
use Carbon\Carbon;

class ForgotPasswordController extends BaseController
{
	/**
	 * Handle pasword forgot API request
	 * 
	 * @param ForgotPasswordRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function forgotPassword(Request $request) {
		$validator = Validator::make($request->all(), [
			'email' => 'required|email|exists:users'
		]);

		if($validator->fails()){
			return $this->sendError('Validation Error', $validator->errors());       
		}

		$token = Str::random(64);
		DB::table('password_resets')->insert([
			'email' => $request->email, 
			'token' => $token, 
			'created_at' => Carbon::now()
		]);

		try {
			$resetUrl = \Config::get('app.front_url').'/reset-password/' . $token . '?email=' . urlencode($request->email);
			Mail::send('emails.forgot-password', ['resetUrl' => $resetUrl], function($message) use($request){
				$message->to($request->email);
				$message->from(config('mail.from.address'), config('mail.from.name'));
				$message->subject('Reset Password');
			});
		} catch(\Exception $e) {
			return $this->sendError('Error', $e->getMessage());   
		}
		
		return $this->sendResponse('Success', 'Please check your inbox, We have e-mailed your password reset link!.');
	}

	/**
	 * Handle pasword reset API request
	 * 
	 * @param ResetPasswordRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function resetPassword(Request $request) {
		$validator = Validator::make($request->all(), [
			'email' => 'required|email|exists:users,email',
			'token' => 'required',
			'password' => 'required|min:8',
			'password_confirmation' => 'required|same:password'
		]);
   
		if($validator->fails()) {
			return $this->sendError('Validation Error', $validator->errors());       
		}

		$updatePassword = DB::table('password_resets')
			->where([
				'email' => $request->email,
				'token' => $request->token
			])->first();

		if(!$updatePassword) {
			return $this->sendError('Invalid Password Token', 'Invalid password reset token!');   
		}

		$user = User::where('email', $updatePassword->email)
					->update(['password' => bcrypt($request->password)]);

		DB::table('password_resets')->where(['email' => $updatePassword->email])->delete();

		return $this->sendResponse('Success', 'Your password has been changed!.');
	}
}
