<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\admin\CourseActivitie;
use App\Models\admin\CourseLesson;
use App\Models\admin\CourseModuleHistorie;
use App\Models\admin\CoursePurchase;
use App\Models\admin\CoursesModule;
use App\Models\admin\ExamMaster;
use App\Models\admin\StudentExam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CoursesController extends Controller
{
    public function courses(Request $request, $id, $module_id, $lession_id = 0, $forward = 0)
    {
        $getcoursesLists = CoursePurchase::where(['student_id' => Auth::user()->id, 'payment_status' => '1', 'status' => '1', 'course_id' => $id])->whereRaw('stripe_response !=""')->get();
        if (blank($getcoursesLists)) :
            abort(404);
        endif;

        $getModuleHistoryCheck = CourseModuleHistorie::where(['courses_id' => $id, 'module_id' => $module_id, 'status' => '1', 'created_by' => Auth::user()->id])->exists();
        if ($getModuleHistoryCheck == 0) :
            self::store_module_history($id, $module_id);
        endif;
        $getModuleHistory = CourseModuleHistorie::selectRaw('course_module_histories.courses_id, course_module_histories.module_id, course_module_histories.total_lession, course_module_histories.complete_lession, course_module_histories.examination_status, course_module_histories.status, course_module_histories.created_at, course_module_histories.module_status, courses_modules.name')
            ->where(['course_module_histories.courses_id' => $id, 'course_module_histories.module_id' => $module_id, 'course_module_histories.status' => '1', 'course_module_histories.created_by' => Auth::user()->id])
            ->leftjoin('courses_modules', function ($q) {
                $q->on('course_module_histories.module_id', 'courses_modules.id');
            })
            ->get();
		$getCoursesModule = self::getCourseModule($id, $module_id);
        $lession_complete =  $getModuleHistory[0]->complete_lession != "" ? count(json_decode($getModuleHistory[0]->complete_lession)) : 0;
        $getCourseLession = CourseLesson::where(['course_id' => $id, 'module_id' => $module_id, 'id' => $lession_id])->first();
        $course_id = $id;
        $next_record = CourseLesson::where('id', '>', $lession_id)->where(['course_id' => $id, 'module_id' => $module_id])->orderBy('id')->first();
        if (($forward == 1 || $forward == 2) && ($lession_id > 0 || $lession_id == 0)) :
            self::update_module_history_next($course_id, $module_id, $forward, $lession_id);
        endif;
		$lession_status = 0;
        if ($getModuleHistory[0]->complete_lession != "") :
            $lession_status = in_array($lession_id, json_decode($getModuleHistory[0]->complete_lession));
        endif;
        $previous_record = CourseLesson::where('id', '<', $lession_id)->where(['course_id' => $id, 'module_id' => $module_id])->orderBy('id', 'desc')->first();
        return view('student.courses.index', compact('getModuleHistory', 'getCoursesModule', 'getCourseLession', 'course_id', 'module_id', 'lession_id', 'next_record', 'previous_record', 'forward', 'lession_complete', 'lession_status'));
    }
	
	private function getCourseModule($id, $module_id)
    {
        $getModule = CourseModuleHistorie::where(['courses_id' => $id, 'status' => '1' , 'created_by' => Auth::user()->id])->get();
        $arr = [];
        if (!blank($getModule)) :
            foreach ($getModule as $val) :
                $arr[] = $val->module_id;
                if ($val->module_status == '1') :
                    $next_module_record = CoursesModule::where('id', '>', $val->module_id)->where(['courses_id' => $id])->orderBy('id')->first();
                    if (!blank($next_module_record)) : 
                        $getCourseLessons = CourseLesson::where(['course_id' => $id, 'module_id' => $next_module_record->id, 'status' => '1'])->get();
                        if (!blank($getCourseLessons)) :
                            $arr[] = $next_module_record->id;
                        endif;
                    endif;
                endif;
            endforeach;
        endif;
        if (!blank($arr)) :
            $getCourseModule = CoursesModule::whereIn('id',$arr)->where('courses_id', $id)->orderBy('id')->get();
            return $getCourseModule;
        endif;
    }

    private function store_module_history($course_id, $module_id)
    {
        $getTotalLession = CourseLesson::where(['course_id' => $course_id, 'module_id' => $module_id, 'status' => '1'])->count();
        $insert = CourseModuleHistorie::create([
            'courses_id' => $course_id,
            'module_id' => $module_id,
            'total_lession' => $getTotalLession,
            'created_by' => Auth::user()->id,
        ]);
		
		$getCourseActivities = CourseActivitie::where(['student_id' => Auth::user()->id, 'courses_id' => $course_id, 'module_id' => $module_id, 'status' => '1'])->exists();
        if (!$getCourseActivities) :
            self::store_course_activities($course_id, $module_id, '', 1);
        endif;
		
        return $insert;
    }

    private function update_module_history_next($course_id, $module_id, $forward, $lession_id)
    {
        $getTotalLessionFinished = CourseModuleHistorie::where(['courses_id' => $course_id, 'module_id' => $module_id, 'status' => '1', 'created_by' => Auth::user()->id])->first();
        $completeLession = $getTotalLessionFinished->complete_lession != "" ? json_decode($getTotalLessionFinished->complete_lession) : [];
        if ($forward == 2 && $lession_id > 0 && $getTotalLessionFinished->ongoing_lession != $lession_id && $getTotalLessionFinished->ongoing_lession !="") :
            if (!in_array($lession_id, $completeLession)) :
                $completeLession[] = $getTotalLessionFinished->ongoing_lession;
                $data = CourseModuleHistorie::find($getTotalLessionFinished->id);
                $data->update(['complete_lession' => json_encode(array_unique($completeLession))]);
            endif;
        elseif ($forward == 1 && $lession_id > 0) :
            if (in_array($lession_id, $completeLession)) :
                unset($completeLession[$lession_id]);
                $data = CourseModuleHistorie::find($getTotalLessionFinished->id);
                $data->update(['complete_lession' => json_encode(array_unique($completeLession))]);
            endif;
        elseif ($forward == 2 && $lession_id == 0 && $getTotalLessionFinished->ongoing_lession !="") :
            $completeLession[] = $getTotalLessionFinished->ongoing_lession;
            unset($completeLession[null]);
            $data = CourseModuleHistorie::find($getTotalLessionFinished->id);
            $data->update(['module_status' => '1', 'complete_lession' => json_encode(array_unique($completeLession)), 'ongoing_lession' => null]);
			$getExamMaster = ExamMaster::where(['courses_id' => $course_id, 'module_id' => $module_id, 'status' => '1'])->first();
			if (!blank($getExamMaster)) :
                $studentExam = StudentExam::where(['student_id' => Auth::user()->id, 'exam_id' => $getExamMaster->id, 'status' => '1'])->exists();
                if (!$studentExam) :
                    StudentExam::create([
                        'student_id' => Auth::user()->id,
						'courses_id' => $course_id,
                        'module_id' => $module_id,
                        'exam_id' => $getExamMaster->id,
                        'created_by' => Auth::user()->id,
                    ]);
                endif;
            endif;
			
			$getCourseActivities = CourseActivitie::where(['student_id' => Auth::user()->id, 'courses_id' => $course_id, 'module_id' => $module_id, 'status' => '1'])->first();
            if (!blank($getCourseActivities)) :
                self::store_course_activities($course_id, $module_id, $getCourseActivities, 2);
            endif;
        endif;

        $data = CourseModuleHistorie::find($getTotalLessionFinished->id);
        if ($lession_id > 0) :
            $data->update(['ongoing_lession' => $lession_id]);
        endif;
    }

    public function courses_list(Request $request)
    {
        $sql = CoursePurchase::selectRaw('course_purchases.id, course_purchases.student_id, course_purchases.course_id, course_purchases.total_amount, course_purchases.grand_amount, course_purchases.transaction_id, course_purchases.payment_status, course_purchases.total_module, course_purchases.status, course_purchases.stripe_response, course_purchases.created_at, courses.title, courses.image, courses_modules.id as module_id')->where(['course_purchases.student_id' => Auth::user()->id, 'course_purchases.payment_status' => '1', 'course_purchases.status' => '1'])
            ->whereRaw('stripe_response !=""')
            ->leftjoin('courses', function ($q) {
                $q->on('course_purchases.course_id', 'courses.id');
            })
            ->leftjoin('courses_modules', function ($q) {
                $q->on('courses.id', 'courses_modules.courses_id');
            })
            ->with('get_user')
            ->GroupBy('courses_modules.courses_id');

        $lists = 1;
        $perPage = 10;
        $records = $sql->paginate($perPage);
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('student.courses.courses_list', compact('lists', 'serial', 'records'));
    }
	
	public function course_module_change(Request $request)
	{
        $next_record = CourseLesson::where(['course_id' => $request->courses_id, 'module_id' => $request->module_id, 'status' => '1'])->orderBy('id')->first();
		return redirect('student/course/'.$request->courses_id.'/'.$request->module_id.'/'.$next_record->id.'/2');
	}
	
	public function get_payment_history(Request $request)
	{
		$getCoursesDetails = CoursePurchase::where(['status' => '1', 'payment_status' => '1', 'id' => $request->id, 'student_id' => Auth::user()->id])->with('get_addons', 'get_course')->first();
		return response()->json($getCoursesDetails);
	}
	
	private function store_course_activities($courses_id, $module_id, $getCourseActivities, $is_type)
    {
        if ($is_type == 1) :
            CourseActivitie::create([
                'student_id' => Auth::user()->id,
                'courses_id' => $courses_id,
                'module_id' => $module_id,
                'start_date_time' => date('Y-m-d h:i:s'),
                'created_by' => Auth::user()->id
            ]);
        else :
            if (!blank($getCourseActivities)) :
                if ($getCourseActivities->end_date_time == "") :
                    $data = CourseActivitie::find($getCourseActivities->id);
                    $data->update(['end_date_time' => date('Y-m-d h:i:s'), 'completed_date' => date('Y-m-d h:i:s')]);
                endif;
            endif;
        endif;
    }
	
	public function getCourseLessonPercentage(Request $request)
    {
        $getModuleHistory = CourseModuleHistorie::selectRaw('course_module_histories.courses_id, course_module_histories.module_id, course_module_histories.total_lession, course_module_histories.complete_lession, course_module_histories.examination_status, course_module_histories.status, course_module_histories.created_at, course_module_histories.module_status, courses_modules.name')
            ->where(['course_module_histories.courses_id' => $request->course_id, 'course_module_histories.module_id' => $request->module_id, 'course_module_histories.status' => '1', 'course_module_histories.created_by' => Auth::user()->id])
            ->leftjoin('courses_modules', function ($q) {
                $q->on('course_module_histories.module_id', 'courses_modules.id');
            })
            ->first();

        $lession_complete =  isset($getModuleHistory) && $getModuleHistory->complete_lession != "" ? count(json_decode($getModuleHistory->complete_lession)) : 0;

        $playerson = (int) preg_replace('/[^0-9]/', '', $lession_complete);
        $maxplayers = (int) preg_replace('/[^0-9]/', '', $getModuleHistory->total_lession);
        $percentage = ($playerson / $maxplayers) * 100;
        $percentage = number_format($percentage, 2);
        return $percentage;
    }
}
