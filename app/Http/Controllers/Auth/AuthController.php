<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Lang;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    // Implement auth actions manually to avoid missing framework traits

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $username = 'username';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'username.required'    => 'Username dibutuhkan.',            
            'password.required'    => 'Password dibutuhkan.',
            
        ];

        return Validator::make($data, [
            //'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ],$messages);
    }

    protected function validateLogin(Request $request)
    {
         $messages = [
            'username.required'    => 'Username dibutuhkan.',            
            'password.required'    => 'Password dibutuhkan.',
            
        ];

        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ],$messages);
    }

    protected function getFailedLoginMessage()
    {
        /*return Lang::has('auth.failed')
                ? Lang::get('auth.failed')
                : 'These credentials do not match our records.';*/
        return Lang::has('auth.failed')
                ? Lang::get('auth.failed')
                : 'Kombinasi Username dan Password tidak tepat.'; 
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function loginUsername()
    {
        return $this->username;
    }

    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login attempt
    public function login(Request $request)
    {
        $this->validateLogin($request);

        $credentials = [$this->username => $request->{$this->username}, 'password' => $request->password];

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return redirect()->intended($this->redirectTo);
        }

        return redirect()->back()
            ->withInput($request->only($this->username, 'remember'))
            ->withErrors([$this->username => $this->getFailedLoginMessage()]);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect($this->redirectTo);
    }

    // Show registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = $this->create($request->all());

        Auth::login($user);

        return redirect($this->redirectTo);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
