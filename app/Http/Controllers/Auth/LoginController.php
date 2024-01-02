<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function show()
    {
        return view('auth.login');
    }
    /**
     * Override function
     *
     * Handle a login request to the application.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|Redirect
     */
    public function login(Request $request)
    {

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        //$credentials = $this->credentials($request);
        $credentials = $request->only('email', 'password');;
        $checkActivated = User::where('email', $request->email)->first();

        $checkActiveUser = 0;
        if ($checkActivated) {
            $checkActiveUser = $checkActivated->status;
        }

        if ($checkActiveUser == 1) {
            if ($this->guard()->attempt($credentials, $request->has('remember'))) {
                return $this->sendLoginResponse($request);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if (!$lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request, $checkActiveUser);
    }

    /**
     * Override function
     *
     * @param Request $request
     * @param $checkActivated
     * @return mixed
     */
    protected function sendFailedLoginResponse(Request $request, $checkActivated)
    {
        switch ($checkActivated) {
            case 0:
                return redirect()->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors([
                        'callback' => 'You must activate your account before logging in.',
                    ]);
                break;
            default:
                return redirect()->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors([
                        'callback' => trans('auth.failed'),
                    ]);
                break;
        }
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    public function logout(Request $request)
    {
		if (!blank(Auth::user())) {
			$request->session()->put('auth.password_confirmed_at', 1);
            $data = User::find(Auth::user()->id);
            $data->update(['is_question_verify' => '0', 'question_expires_at' => null]);
        }
        Auth::logout();
        $request->session()->forget('stock');
        $request->session()->forget('get_stock');
        $request->session()->forget('user_details');
        $request->session()->forget('getCourse');
        $request->session()->forget('cart');
		$request->session()->forget('getCertificateErrorMessage');
        return redirect('/');
    }
}
