<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\admin\CourseModuleHistorie;
use App\Models\admin\CoursePurchase;
use App\Models\admin\Guideline;
use App\Models\admin\UserQuestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('student.dashboard.index');
    }
	
	 public function quiz()
    {
        return view('student.dashboard.quiz');
    }
	
	public function summary(Request $request)
    {
		$start_date = date('Y-m-d', strtotime(Auth::user()->created_at));
        $end_date = date('Y-m-d', strtotime(Auth::user()->expires_at));
        $date1 = date_create($start_date);
        $date2 = date_create($end_date);
        $diff = date_diff($date1, $date2);
        $diff_day_number =  $diff->format("%a days");
		$getTotalCourseModule = CoursePurchase::selectRaw('SUM(total_module) as total_module')->where(['student_id' => Auth::user()->id, 'payment_status' => '1', 'status' => '1'])->groupBy('student_id')->first();
        $getTotalModuleComplete = CourseModuleHistorie::selectRaw('SUM(total_lession) as total_lession')->where(['created_by' => Auth::user()->id, 'status' => '1'])->groupBy('created_by')->first();
        return view('student.dashboard.summary', compact('diff_day_number', 'getTotalCourseModule', 'getTotalModuleComplete'));
    }
	
	public function questions(Request $request)
    {
        return 444;
    }
	
	public function login_security_question(Request $request)
    {
        $get_security_question = UserQuestion::where(['student_id' => Auth::user()->id])->inRandomOrder()->first();
        return view('auth.login_security_question', compact('get_security_question'));
    }

    public function set_security_question(Request $request)
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
                return redirect('login');
            } else {
                $request->session()->flash('message', ['status' => 0, 'text' => 'Security questions did not match.']);
            }
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 0, 'text' => $e->getMessage()]);
        }
        return redirect()->back();
    }
	
	public function guideline(Request $request)
    {
        $get_guideline = Guideline::where('status', '1')->get();
        return view('student.dashboard.guideline', compact('get_guideline'));
    }
}
