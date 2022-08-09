<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;

use DB; 
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset emails and
	| includes a trait which assists in sending these notifications from
	| your application to your users. Feel free to explore this trait.
	|
	*/

	/**
     * Display forgot password page.
     * 
     * @return Renderable
     */
	public function showForgotPasswordForm() {
		$authClasses = [
            'class_1' => 'all-from',
        ];
		return view('pages.auth.forgot-password', compact('authClasses'));
	}

	/**
     * Handle pasword forgot request
     * 
     * @param ForgotPasswordRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
	public function forgotPassword(ForgotPasswordRequest $request) {
		$token = Str::random(64);
  
		DB::table('password_resets')->insert([
			'email' => $request->email, 
			'token' => $token, 
			'created_at' => Carbon::now()
		]);

		try {
			$resetUrl = \Config::get('app.url').'/reset-password/' . $token . '?email=' . urlencode($request->email);
			Mail::send('emails.forgot-password', ['resetUrl' => $resetUrl], function($message) use($request){
				$message->to($request->email);
				$message->from(config('mail.from.address'), config('mail.from.name'));
				$message->subject('Reset Password');
			});
		} catch(\Exception $e) {
			return back()->with('error', $e->getMessage());
		}
		
		return back()->with('success', 'We have e-mailed your password reset link!');
	}

	/**
     * Display reset password page.
     * 
     * @return Renderable
     */
	public function showResetPasswordForm($token) { 
		$authClasses = [
            'class_1' => '',
        ];

		$email = $request->query('email');
		return view('pages.auth.reset-password', ['token' => $token, 'email' => $email, 'authClasses' => $authClasses]);
	}

	/**
     * Handle pasword reset request
     * 
     * @param ResetPasswordRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
	public function resetPassword(ResetPasswordRequest $request) {
		$updatePassword = DB::table('password_resets')
			->where([
				'email' => $request->email,
				'token' => $request->token
			])->first();

		if(!$updatePassword) {
			return back()->withInput()->with('error', 'Invalid token!');
		}

		$user = User::where('email', $updatePassword->email)
					->update(['password' => bcrypt($request->password)]);

		DB::table('password_resets')->where(['email' => $updatePassword->email])->delete();

		return redirect('/login')->with('success', 'Your password has been changed!');
	}

	/**
     * Handle verify email request
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
	public function verifyEmail(Request $request): RedirectResponse
    {
        $user = User::find($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            return redirect(env('API_FRONT_URL') . '/login?status=verified');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect(env('API_FRONT_URL') . '/login?status=unverified');
    }
}
