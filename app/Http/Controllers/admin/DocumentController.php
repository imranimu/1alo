<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Course;
use App\Models\admin\CourseDocument;
use App\Models\admin\CoursePurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $getCourse = Course::where('status', '1')->get();
        $sql = CourseDocument::orderBy('id', 'desc');
        if (!empty($request->q)) {
            $sql->Where('course_id', 'LIKE', '%' . $request->q . '%')
                ->orWhere('title', 'LIKE', '%' . $request->q . '%')
                ->orWhere('file', 'LIKE', '%' . $request->q . '%');
        }

        $lists = 1;
        $perPage = 20;
        $records = $sql->paginate($perPage);
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('admin.document.index', compact('lists', 'serial', 'records', 'getCourse'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required',
            'title' => 'required',
            'file_upload' => 'required',
            'file_upload.*' => 'mimes:jpeg,jpg,png,pdf|max:3072',
            'status' => 'required',
        ]);

        try {
            $fileName = '';
            if ($request->hasFile('file_upload')) :
                $file = $request->file('file_upload');
                $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $file_name = str_replace(' ', '_', $file_name);
                $fileName = strtolower($file_name . '_' . strtotime(date('Y-m-d')) . time()) . '.' . $file->extension();

                $dir = public_path('storage/app/public/document/');
                if (!file_exists($dir) && !is_dir($dir)) :
                    mkdir($dir, 0777, true);
                endif;
                Storage::disk('public')->put('document/' . $fileName, File::get($file));
            endif;

            $insert = CourseDocument::create([
                'course_id' => $request->course_id,
                'title' => $request->title,
                'file' => $fileName,
                'status' => $request->status,
                'created_by' => Auth::user()->id,
            ]);

            if ($insert) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Document uploaded successfully']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Document upload failed.']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 0,  'text' => $e->getMessage()]);
        }
        return redirect()->back();
    }

    public function set_sort(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'sort_val' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 2, 'errors' => $validator->errors()]);
        } else {
            try {
                $status = true;
                if ($request->sort_val == 0) {
                    $status = false;
                }
                $check_exists = CourseDocument::where('sort', $request->sort_val)->exists();
                if ($check_exists && $status) {
                    $arr = ['status' => 0, 'text' => 'sort value ' . $request->sort_val . ' already exists.'];
                } else {
                    $data = CourseDocument::find($request->id);
                    $update = $data->update(['sort' => $request->sort_val]);

                    if ($update) {
                        $arr = ['status' => 1, 'text' => 'Sort value update successfully.'];
                    } else {
                        $arr = ['status' => 0, 'text' => 'Sort value update failed.'];
                    }
                }
                return response()->json($arr);
            } catch (\Exception $e) {
                return response()->json(['status' => 2, 'text' => $e->getMessage()]);
            }
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'text' => $validator->errors()]);
        else :
            $delete = CourseDocument::find($request->id)->delete();
            if ($delete) :
                return response()->json(['status' => 1, 'text' => 'Document delete successfully']);
            else :
                return response()->json(['status' => 0, 'text' => 'Document delete failed.']);
            endif;
        endif;
    }
	
	public function document_show(Request $request)
    {
        $getCourses = CoursePurchase::select('course_id')->where(['student_id' => Auth::user()->id, 'status' => '1'])->get();
        $arr = [];
        if (!blank($getCourses)) {
            foreach ($getCourses as $val) {
                $arr[] = $val->course_id;
            }
        }
        $sql = CourseDocument::where(['course_id' => '0', 'status' => '1'])->orderBy('id', 'desc');
        if (!empty($request->q)) {
            $sql->Where('course_id', 'LIKE', '%' . $request->q . '%')
                ->orWhere('title', 'LIKE', '%' . $request->q . '%')
                ->orWhere('file', 'LIKE', '%' . $request->q . '%');
        }

        if (!blank($arr)) {
            $sql->orWhereIn('course_id', $arr);
        }

        $lists = 1;
        $perPage = 20;
        $records = $sql->paginate($perPage);
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('student.document.index', compact('lists', 'serial', 'records'));
    }
}
