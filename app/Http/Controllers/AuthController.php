<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Display login page.
     * 
     * @return Renderable
     */
    public function showLoginForm ()
    {
        $authClasses = [
            'class_1' => 'all-from',
        ];
        return view('pages.auth.login', compact('authClasses'));
    }

    /**
     * Handle account login request
     * 
     * @param LoginRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if(!Auth::validate($credentials)) {
            return redirect()->to('login')->withErrors(trans('auth.failed'));
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        return $this->authenticated($credentials, $user);
    }

    /**
     * Handle response after user authenticated
     * 
     * @param Request $request
     * @param Auth $user
     * 
     * @return \Illuminate\Http\Response
     */
    protected function authenticated($credentials, $user) 
    {
        return redirect()->intended();
    }

    /**
     * Display register page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showRegisterForm()
    {
        $authClasses = [
            'class_1' => 'all-from',
        ];

        return view('pages.auth.register', compact('authClasses'));
    }

    /**
     * Handle account registration request
     * 
     * @param RegisterRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request) 
    {
        $user = User::create($request->validated());

        auth()->login($user);

        return redirect('/')->with('success', "Account successfully registered.");
    }

    /**
     * Handle account logout request
     * 
     * @param RegisterRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request) 
    {
        Session::flush();
        Auth::logout();

        return redirect('/login')->with('success', "Account successfully registered.");
    }
}
