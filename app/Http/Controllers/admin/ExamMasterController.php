<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Course;
use App\Models\admin\CoursesModule;
use App\Models\admin\ExamMaster;
use App\Models\admin\QuestionMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Image;

class ExamMasterController extends Controller
{
    public function index(Request $request)
    {
        $getCourses = Course::where('status', '1')->get();
        $sql = ExamMaster::with('get_course', 'get_module')->orderBy('id', 'asc');
        if (!empty($request->q)) {
            $sql->Where('courses_id', 'LIKE', '%' . $request->q . '%')
                ->orWhere('module_id', 'LIKE', '%' . $request->q . '%')
                ->orWhere('title', 'LIKE', '%' . $request->q . '%')
                ->orWhere('status', 'LIKE', '%' . $request->q . '%');
        }

        $lists = 1;
        $perPage = 20;
        $records = $sql->paginate($perPage);
		//return $records;
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('admin.question.exam_courses', compact('lists', 'serial', 'records', 'getCourses'));
    }

    public function get_module(Request $request)
    {
        $getModule = CoursesModule::where('status', '1')->where('courses_id', $request->id)->get();
        return response()->Json($getModule);
    }

    public function store_exam(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'exam_courses' => 'required',
            'exam_module' => 'required',
        ]);
        try {
            $insert = ExamMaster::create([
                'courses_id' => $request->exam_courses,
                'module_id' => $request->exam_module,
                'title' => $request->title,
                'created_by' => Auth::user()->id,
            ]);

            if ($insert) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Exam has been created']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Exam create failed']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 0,  'text' => $e->getMessage()]);
        }
        return redirect()->back();
    }

    public function exam_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'text' => $validator->errors()]);
        else :
            $data = ExamMaster::find($request->id);
            if ($data != "") :
                $result = $data->delete();
                if ($result) :
                    return response()->json(['status' => 1, 'text' => 'Exam delete successfully']);
                else :
                    return response()->json(['status' => 0, 'text' => 'Exam delete failed.']);
                endif;
            else :
                return response()->json(['status' => 0, 'text' => 'Exam delete failed.']);
            endif;
        endif;
    }

    public function edit_exam(Request $request, $id)
    {
        $getExam = ExamMaster::where('id', $id)->with('get_course', 'get_module')->first();
        $getCourses = Course::where('status', '1')->get();
        $getModule = CoursesModule::where('status', '1')->where('courses_id', $getExam->courses_id)->get();
        return view('admin.question.edit_exam_courses', compact('getExam', 'getCourses', 'getModule', 'id'));
    }

    public function update_exam(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'title' => 'required',
            'exam_courses' => 'required',
            'exam_module' => 'required',
            'status' => 'required',
        ]);

        try {
            $data = ExamMaster::find($request->id);
            $update = [
                'courses_id' => $request->exam_courses,
                'module_id' => $request->exam_module,
                'title' => $request->title,
                'status' => $request->status,
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d h:i:s')
            ];

            $result = $data->update($update);
            if ($result) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Exam update successfully']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Exam update failed.']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
        }
        return redirect()->back();
    }

    public function question_show(Request $request, $id)
    {
        $sql = QuestionMaster::where('exam_id', $id)->orderBy('id', 'asc');
        if (!empty($request->q)) {
            $sql->Where('exam_id', 'LIKE', '%' . $request->q . '%')
                ->orWhere('question', 'LIKE', '%' . $request->q . '%')
                ->orWhere('ans', 'LIKE', '%' . $request->q . '%')
                ->orWhere('status', 'LIKE', '%' . $request->q . '%');
        }

        $lists = 1;
        $perPage = 20;
        $records = $sql->paginate($perPage);
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('admin.question.exam_question', compact('lists', 'serial', 'records', 'id'));
    }

    public function store_question(Request $request)
    {
        $this->validate($request, [
            'exam_id' => 'required',
            'question' => 'required',
            'option_1' => 'required',
            'option_2' => 'required',
            'ans' => 'required',
			'image.*' => 'mimes:jpeg,jpg,png|max:5000'
        ]);
        try {
			$fileName = '';
            if ($request->hasFile('image')) :
                $image = $request->file('image');
                $fileName  = 'question_' . Auth::user()->id . time() . '.' . $image->extension();
                $img = image::make($image->getRealPath());
                $img->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->stream(); // <-- Key point
                $dir = public_path('storage/app/public/image/question/');

                if (!file_exists($dir) && !is_dir($dir)) :
                    mkdir($dir, 0777, true);
                endif;

                Storage::disk('public')->put('image/question/' . $fileName, $img);
            endif;
			
            $ans = $request->option_4;
            if ($request->ans == 'option_1') {
                $ans = $request->option_1;
            } elseif ($request->ans == 'option_2') {
                $ans = $request->option_2;
            } elseif ($request->ans == 'option_3') {
                $ans = $request->option_3;
            }

            $options = json_encode(['option_1' => $request->option_1, 'option_2' => $request->option_2, 'option_3' => $request->option_3, 'option_4' => $request->option_4]);

            $insert = QuestionMaster::create([
                'exam_id' => $request->exam_id,
                'question' => $request->question,
                'ans' => $ans,
                'options' => $options,
				'file' => $fileName,
                'created_by' => Auth::user()->id,
            ]);

            if ($insert) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Question has been created']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Question create failed']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 0,  'text' => $e->getMessage()]);
        }
        return redirect()->back();
    }

    public function edit_question(Request $request, $id)
    {
        $getQuestion = QuestionMaster::where('id', $id)->first();
        return view('admin.question.edit_question_courses', compact('getQuestion', 'id'));
    }

    public function update_question(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'question' => 'required',
            'option_1' => 'required',
            'option_2' => 'required',
            'ans' => 'required',
			'image.*' => 'mimes:jpeg,jpg,png|max:5000'
        ]);
        try {
			$fileName = '';
            $data = QuestionMaster::find($request->id);
            if ($request->hasFile('image')) :
                if (!empty($data) && $data->file != "") :
                    if (File::exists('storage/image/question/' . $data->file)) :
                        File::delete('storage/image/question/' . $data->file);
                    endif;
                endif;

                $image = $request->file('image');
                $fileName   = 'question_' . Auth::user()->id . time() . '.' . $image->extension();;
                $img = image::make($image->getRealPath());
                $img->resize(800, 600, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->stream(); // <-- Key point
                $dir = public_path('storage/app/public/image/question/');

                if (!file_exists($dir) && !is_dir($dir)) :
                    mkdir($dir, 0777, true);
                endif;

                Storage::disk('public')->put('image/question/' . $fileName, $img);
            endif;
			
            $ans = $request->option_4;
            if ($request->ans == 'option_1') {
                $ans = $request->option_1;
            } elseif ($request->ans == 'option_2') {
                $ans = $request->option_2;
            } elseif ($request->ans == 'option_3') {
                $ans = $request->option_3;
            }

            $options = json_encode(['option_1' => $request->option_1, 'option_2' => $request->option_2, 'option_3' => $request->option_3, 'option_4' => $request->option_4]);

            $data = QuestionMaster::find($request->id);
            $update = [
                'question' => $request->question,
                'ans' => $ans,
                'options' => $options,
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d h:i:s')
            ];
			
			if ($fileName != "") :
                $update['file'] = $fileName;
            endif;
			
            $result = $data->update($update);
            if ($result) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Question update has been created']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Question update failed']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 0,  'text' => $e->getMessage()]);
        }
        return redirect()->back();
    }
	
	public function set_random_limit_number(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'limit_val' => 'required',
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'text' => $validator->errors()]);
        else :
			$data = ExamMaster::find($request->id);
			$update = $data->update(['limit_number' => $request->limit_val]);

			if ($update) :
				return response()->json(['status' => 1, 'text' => 'Sort ' . $request->limit_val . ' update successfully']);
			else :
				return response()->json(['status' => 0, 'text' => 'Sort ' . $request->limit_val . ' update failed.']);
			endif;
        endif;
    }
	
	public function question_destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'text' => $validator->errors()]);
        else :
            $data = QuestionMaster::find($request->id);
            if ($data != "") :
                $result = $data->delete();
                if ($result) :
                    return response()->json(['status' => 1, 'text' => 'Question delete successfully']);
                else :
                    return response()->json(['status' => 0, 'text' => 'Question delete failed.']);
                endif;
            else :
                return response()->json(['status' => 0, 'text' => 'Question delete failed.']);
            endif;
        endif;
    }
}
