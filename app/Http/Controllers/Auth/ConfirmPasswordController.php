<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use App\Models\admin\UserQuestion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;

    /**
     * Where to redirect users when the intended url fails.
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
        $this->middleware('auth');
    }
	
	/**
     * Display the password confirmation view.
     *
     * @return \Illuminate\Http\Response
     */
    public function showConfirmForm(Request $request)
    {
		$current_time = Carbon::now()->timestamp;
		$question_expires_at = strtotime(Auth::user()->question_expires_at);
		if (Auth::user()->is_question_verify == '1' && Auth::user()->question_expires_at != "" && $question_expires_at > $current_time) {
            $this->resetPasswordConfirmationTimeout($request);
            return redirect()->intended('student/dashboard');
		} else {
		    $get_security_question = UserQuestion::where(['student_id' => Auth::user()->id])->inRandomOrder()->first();
			return view('auth.passwords.confirm', compact('get_security_question'));
		}
    }
	
	/**
     * Confirm the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function confirm(Request $request)
    {
        $this->validate($request, [
            '__tokan__' => 'required',
            'ans' => 'required',
        ]);
        try {
            $get_user_ans = UserQuestion::where(['id' => $request->__tokan__, 'student_id' => Auth::user()->id, 'ans' => trim($request->ans)])->count();
            if ($get_user_ans > 0) {
                $data = User::find(Auth::user()->id);
                $data->update([
                    'is_question_verify' => '1',
                    'question_expires_at' => date('Y-m-d H:i:s', strtotime("+6 hours")),
                ]);
                $this->resetPasswordConfirmationTimeout($request);
				return $request->wantsJson() ? new Response('', 204) : redirect()->intended($this->redirectPath());
            } else {
                $request->session()->flash('message', ['status' => 0, 'text' => 'Security questions did not match.']);
            }
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 0, 'text' => $e->getMessage()]);
        }
		
        return redirect()->back();
    }
}
