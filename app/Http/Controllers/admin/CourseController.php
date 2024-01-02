<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Course;
use App\Models\admin\CourseAddonPurchase;
use App\Models\admin\CourseLesson;
use App\Models\admin\CourseModuleHistorie;
use App\Models\admin\CoursePurchase;
use App\Models\admin\CoursesModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Image;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        return view('admin/courses/index');
    }

    public function store_course(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:courses,title',
            'slug' => 'required|unique:courses,slug',
            'level' => 'required',
            'duration' => 'required',
            'price' => 'required',
            'status' => 'required',
            'image' => 'required',
            'image.*' => 'mimes:jpeg,jpg,png|max:2048'
        ]);
        try {
            $fileName = '';
            if ($request->hasFile('image')) :
                $image = $request->file('image');
                $fileName   = 'course_' . Auth::user()->id . time() . '.' . $image->extension();
                $img = image::make($image->getRealPath());
                $img->resize(770, 420, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->stream(); // <-- Key point
                $dir = public_path('storage/app/public/image/course/');

                if (!file_exists($dir) && !is_dir($dir)) :
                    mkdir($dir, 0777, true);
                endif;

                Storage::disk('public')->put('image/course/' . $fileName, $img);

                $thum_img = image::make($image->getRealPath());
                $thum_img->resize(350, 255, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $thum_img->stream(); // <-- Key point
                $thum_dir = public_path('storage/app/public/image/course/thumbnail/');

                if (!file_exists($thum_dir) && !is_dir($thum_dir)) :
                    mkdir($thum_dir, 0777, true);
                endif;

                Storage::disk('public')->put('image/course/thumbnail/' . $fileName, $thum_img);
            endif;

            $insert = Course::create([
                'title' => ucwords($request->title),
                'slug' => strtolower($request->slug),
                'description' => $request->description,
                'discussions' => $request->discussion,
                'course_level' => $request->level,
                'course_duration' => $request->duration,
                'price' => $request->price,
                'image' => $fileName,
                'status' => $request->status,
                'created_by' => Auth::user()->id,
            ]);

            if ($insert) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Course add successfully']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Course add failed.']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 0, 'text' => $e->getMessage()]);
        }
        return redirect()->back();
    }

    public function show_course(Request $request)
    {
        $sql = Course::orderBy('id', 'desc');
        if (!empty($request->q)) {
            $sql->Where('title', 'LIKE', '%' . $request->q . '%')
                ->orWhere('slug', 'LIKE', '%' . $request->q . '%');
        }

        $lists = 1;
        $perPage = 10;
        $records = $sql->paginate($perPage);
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('admin.courses.course_show', compact('lists', 'serial', 'records'));
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
                $check_exists = Course::where('sort', $request->sort_val)->exists();
                if ($check_exists && $status) {
                    $arr = ['status' => 0, 'text' => 'sort value ' . $request->sort_val . ' already exists.'];
                } else {
                    $data = Course::find($request->id);
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

    public function edit_course(Request $request, $id)
    {
        $get_course = Course::where('id', $id)->first();
        return view('admin/courses/edit_course', compact('get_course', 'id'));
    }

    public function update_course(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|unique:courses,title,' . $id,
            'slug' => 'required|unique:courses,slug,' . $id,
            'level' => 'required',
            'duration' => 'required',
            'price' => 'required',
            'status' => 'required',
            'image.*' => 'mimes:jpeg,jpg,png|max:2048'
        ]);

        try {
            $fileName = '';
            $data = Course::find($request->id);
            if ($request->hasFile('image')) :
                if (!empty($data) && $data->image != "") :
                    if (File::exists('storage/image/course/' . $data->image)) :
                        File::delete('storage/image/course/' . $data->image);
                    endif;

                    if (File::exists('storage/image/course/thumbnail/' . $data->image)) :
                        File::delete('storage/image/course/thumbnail/' . $data->image);
                    endif;
                endif;

                $image = $request->file('image');
                $fileName   = 'course_' . Auth::user()->id . time() . '.' . $image->extension();;
                $img = image::make($image->getRealPath());
                $img->resize(770, 420, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->stream(); // <-- Key point
                $dir = public_path('storage/app/public/image/course/');

                if (!file_exists($dir) && !is_dir($dir)) :
                    mkdir($dir, 0777, true);
                endif;

                Storage::disk('public')->put('image/course/' . $fileName, $img);

                $thum_img = image::make($image->getRealPath());
                $thum_img->resize(350, 255, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $thum_img->stream(); // <-- Key point
                $thum_dir = public_path('storage/app/public/image/course/thumbnail/');

                if (!file_exists($thum_dir) && !is_dir($thum_dir)) :
                    mkdir($thum_dir, 0777, true);
                endif;

                Storage::disk('public')->put('image/course/thumbnail/' . $fileName, $thum_img);

            endif;

            $update = [
                'title' => ucwords($request->title),
                'slug' => strtolower($request->slug),
                'description' => $request->description,
                'discussions' => $request->discussion,
                'course_level' => $request->level,
                'course_duration' => $request->duration,
                'price' => $request->price,
                'status' => $request->status,
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d h:i:s')
            ];

            if ($fileName != "") :
                $update['image'] = $fileName;
            endif;

            $result = $data->update($update);
            if ($result) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Course update successfully']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Course update failed.']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
        }
        return redirect()->back();
    }

    public function destroy_course(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'text' => $validator->errors()]);
        else :
            $data = Course::find($request->id);
            if ($data != "") :
                $image = $data->image;
                $result = $data->delete();
                if ($result) :
                    return response()->json(['status' => 1, 'text' => 'Course delete successfully']);
                else :
                    return response()->json(['status' => 0, 'text' => 'Course delete failed.']);
                endif;
            else :
                return response()->json(['status' => 0, 'text' => 'Course delete failed.']);
            endif;
        endif;
    }

    public function course_lesson_add(Request $request, $courses_id, $id)
    {
        $get_course = Course::where('id', $courses_id)->first();
        $get_course_module = CoursesModule::where(['courses_id' => $courses_id, 'id' => $id])->get();
        $get_course_lesson = CourseLesson::where(['course_id' => $courses_id, 'module_id' =>  $id])->orderBy('id', 'asc')->get();
        $module_id = $id;
        return view('admin/courses/course_lesson_add', compact('id', 'get_course', 'get_course_lesson', 'get_course_module', 'courses_id', 'module_id'));
    }

    public function store_course_lesson(Request $request)
    {
        $arr = [
            'id' => 'required',
			'courses_module_id' => 'required',
            'title' => 'required',
            'lesson_type' => 'required',
            'status' => 'required',
        ];

        if ($request->hasFile('file')) :
            $arr['file'] = 'required';
            $arr['file.*'] = 'mimes:mp4,mp3|max:300048';
        endif;

        if ($request->hasFile('file_pdf_text')) :
            $arr['file_pdf_text'] = 'required';
            $arr['file_pdf_text.*'] = 'mimes:pdf,jpeg,jpg,png|max:6048';
        endif;

        $this->validate($request, $arr);
        try {
            $dir = public_path('storage/app/public/files/' . $request->id . '/');
            if (!file_exists($dir) && !is_dir($dir)) :
                mkdir($dir, 0777, true);
            endif;

            $fileName = '';
            if ($request->hasFile('file_pdf_text')) :
                $file = $request->file('file_pdf_text');
                $fileName   = 'course_lesson_' . rand(0, 10) . time() . '.' . $file->extension();
                Storage::disk('local')->putFileAs('public/files/' . $request->id, $file, $fileName);
            endif;

            $mediaFileName = '';
            if ($request->hasFile('file')) :
                $videoFile = $request->file('file');
                $mediaFileName   = 'course_lesson_' . rand(0, 10) . time() . '.' . $videoFile->extension();
                Storage::disk('local')->putFileAs('public/files/' . $request->id, $videoFile, $mediaFileName);
            endif;

            $insert = CourseLesson::create([
                'course_id' => $request->courses_id,
                'module_id' => $request->courses_module_id,
                'title' => $request->title,
                'lesson_type' => strtolower($request->lesson_type),
                'video' => strtolower($request->lesson_type) == 'video' ? $mediaFileName : null,
                'audio' => strtolower($request->lesson_type) == 'audio' ? $mediaFileName : null,
                'text_pdf' => $fileName,
                'status' => $request->status,
                'created_by' => Auth::user()->id,
            ]);

            if ($insert) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Course lesson add successfully']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Course lesson add failed.']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 0, 'text' => $e->getMessage()]);
        }
        return redirect()->back();
    }

    public function update_course_lesson(Request $request, $id)
    {
        $arr = [
            'edit_id' . $id => 'required',
			'edit_module_id' . $id => 'required',
            'edit_title' . $id => 'required',
            'edit_lesson_type' . $id => 'required',
            'edit_status' . $id => 'required',
        ];

        if ($request->hasFile('edit_file')) :
            $arr['edit_file' . $id] = 'required';
            $arr['edit_file' . $id . '.*'] = 'mimes:mp4,mp3|max:300048';
        endif;

        if ($request->hasFile('edit_file_pdf_text' . $id)) :
            $arr['edit_file_pdf_text' . $id] = 'required';
            $arr['edit_file_pdf_text' . $id . '.*'] = 'mimes:pdf,jpeg,jpg,png|max:6048';
        endif;

        $this->validate($request, $arr);
        try {
            $edit_title = 'edit_title' . $id;
            $edit_lesson_type = 'edit_lesson_type' . $id;
            $edit_status = 'edit_status' . $id;
			$edit_module_id = 'edit_module_id' . $id;
            $module_id = $request->$edit_module_id;

            $dir = public_path('storage/app/public/files/' . $module_id . '/');
            if (!file_exists($dir) && !is_dir($dir)) :
                mkdir($dir, 0777, true);
            endif;

            $fileName = '';
            $data = CourseLesson::find($id);
            if ($request->hasFile('edit_file_pdf_text' . $id)) :
                if (!empty($data) && $data->text_pdf != "") :
                    if (File::exists('storage/app/public/files/' . $module_id . '/' . $data->text_pdf)) :
                        File::delete('storage/app/public/files/' . $module_id . '/' . $data->text_pdf);
                    endif;
                endif;

                $file = $request->file('edit_file_pdf_text' . $id);
                $fileName   = 'course_lesson_' . rand(0, 10) . time() . '.' . $file->extension();
                Storage::disk('local')->putFileAs('public/files/' . $module_id, $file, $fileName);
            endif;

            $mediaFileName = '';
            if ($request->hasFile('edit_file' . $id)) :
                if ($request->$edit_lesson_type == 'video') :
                    if (!empty($data) && $data->video != "") :
                        if (File::exists('storage/app/public/files/' . $module_id . '/' . $data->video)) :
                            File::delete('storage/app/public/files/' . $module_id . '/' . $data->video);
                        endif;
                    endif;
                elseif ($request->$edit_lesson_type == 'audio') :
                    if (!empty($data) && $data->audio != "") :
                        if (File::exists('storage/app/public/files/' . $module_id . '/' . $data->audio)) :
                            File::delete('storage/app/public/files/' . $module_id . '/' . $data->audio);
                        endif;
                    endif;
                endif;

                $videoFile = $request->file('edit_file' . $id);
                $mediaFileName   = 'course_lesson_' . rand(0, 10) . time() . '.' . $videoFile->extension();
                Storage::disk('local')->putFileAs('public/files/' . $module_id, $videoFile, $mediaFileName);
            endif;

            $update = [
                'title' => ucwords($request->$edit_title),
                'lesson_type' => strtolower($request->$edit_lesson_type),
                'status' => $request->$edit_status,
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d h:i:s')
            ];

            if ($mediaFileName != "") {
                if (strtolower($request->$edit_lesson_type) == 'video') {
                    $update['video'] = strtolower($request->$edit_lesson_type) == 'video' ? $mediaFileName : null;
					$update['audio'] = null;
                }

                if (strtolower($request->$edit_lesson_type) == 'audio') {
                    $update['audio'] = strtolower($request->$edit_lesson_type) == 'audio' ? $mediaFileName : null;
					$update['video'] = null;
                }
            }

            if ($fileName != "") {
				if (strtolower($request->edit_lesson_type) == 'pdf') {
					$update['video'] = null;
					$update['audio'] = null;
				}
				$update['text_pdf'] = $fileName;
            }

            $update = $data->update($update);
            if ($update) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Course lesson updated successfully']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Course lesson update failed.']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 0, 'text' => $e->getMessage()]);
        }
        return redirect()->back();
    }

    public function destroy_course_lesson(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'text' => $validator->errors()]);
        else :
            $data = CourseLesson::find($request->id);
            if ($data != "") :
                $image = $data->image;
                $result = $data->delete();
                if ($result) :
                    return response()->json(['status' => 1, 'text' => 'Course lesson delete successfully']);
                else :
                    return response()->json(['status' => 0, 'text' => 'Course lesson delete failed.']);
                endif;
            else :
                return response()->json(['status' => 0, 'text' => 'Course lesson delete failed.']);
            endif;
        endif;
    }
	
	public function payment_show(Request $request)
    {
        $sql = CoursePurchase::with('get_user', 'get_course', 'get_addons')->orderBy('id', 'desc');
        if (!empty($request->q)) {
            $sql->Where('title', 'LIKE', '%' . $request->q . '%')
                ->orWhere('slug', 'LIKE', '%' . $request->q . '%');
        }

        $lists = 1;
        $perPage = 10;
        $records = $sql->paginate($perPage);
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('admin.payment.payment_show', compact('lists', 'serial', 'records'));
    }

    public function get_addons_history(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 2, 'text' => $validator->errors()]);
        } else {
            $get_addons = CourseAddonPurchase::where('course_purchase_id', $request->id)->get();
            if (!blank($get_addons)) {
                return response()->json(['status' => 1, 'data' => $get_addons]);
            } else {
                return response()->json(['status' => 0, 'text' => 'Data not found!']);
            }
        }
    }
	
    public function course_module_add(Request $request, $id)
    {
        $sql = CoursesModule::where('courses_id', $id)->orderBy('id', 'asc');
        if (!empty($request->q)) {
            $sql->Where('name', 'LIKE', '%' . $request->q . '%');
        }
        $lists = 1;
        $perPage = 10;
        $records = $sql->paginate($perPage);
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('admin.courses.course_module', compact('lists', 'serial', 'records', 'id'));
    }

    public function store_course_module(Request $request)
    {
        $this->validate($request, [
            'courses_id' => 'required',
            'name' => 'required',
        ]);
        try {
            $insert = CoursesModule::create([
                'name' => $request->name,
                'description' => $request->description,
                'duration' => $request->duration,
                'courses_id' => $request->courses_id,
                'created_by' => Auth::user()->id,
            ]);
            if ($insert) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Courses Module add successfully']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Courses Module add failed.']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 0, 'text' => $e->getMessage()]);
        }
        return redirect()->back();
    }

    public function courses_module_edit(Request $request)
    {
        $data = CoursesModule::findOrFail($request->id);
        return response()->json($data);
    }

    public function courses_module_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'errors' => $validator->errors()]);
        else :
            $updateData = [
                'name' => $request->name,
				'description' => $request->description,
                'duration' => $request->duration,
                'status' => $request->status,
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d h:i:s')
            ];

            $data = CoursesModule::find($request->id);
            $update = $data->update($updateData);

            if ($update) :
                return response()->json(['status' => 1, 'text' => 'Courses module update successfully']);
            else :
                return response()->json(['status' => 0, 'text' => 'Courses module update failed.']);
            endif;
        endif;
    }

    public function destroy_course_module(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'courses_id' => 'required',
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'text' => $validator->errors()]);
        else :
            $data = CoursesModule::find($request->id);
            if ($data != "") :
                $result = $data->delete();
                if ($result) :
					CourseLesson::where(['course_id' => $request->courses_id, 'module_id' => $request->id])->delete();
                    return response()->json(['status' => 1, 'text' => 'Course Module delete successfully']);
                else :
                    return response()->json(['status' => 0, 'text' => 'Course Module delete failed.']);
                endif;
            else :
                return response()->json(['status' => 0, 'text' => 'Course Module delete failed.']);
            endif;
        endif;
    }

    public function set_module_sort(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'sortVal' => 'required',
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'text' => $validator->errors()]);
        else :

            if ($request->sortVal == 0) :
                $checkNav = [];
            else :
                $checkNav = CoursesModule::where(['sort' => $request->sortVal])->get();
            endif;

            if (count($checkNav) == 0) :
                $data = CoursesModule::find($request->id);
                $update = $data->update(['sort' => $request->sortVal]);

                if ($update) :
                    return response()->json(['status' => 1, 'text' => 'Sort ' . $request->sortVal . ' update successfully']);
                else :
                    return response()->json(['status' => 0, 'text' => 'Sort ' . $request->sortVal . ' update failed.']);
                endif;
            else :
                return response()->json(['status' => 0, 'text' => 'This Sort ' . $request->sortVal . ' already exists.']);
            endif;
        endif;
    }

      // public function upload(Request $request)
    // {
    //     // create the file receiver
    //     $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

    //     // check if the upload is success, throw exception or return response you need
    //     if ($receiver->isUploaded() === false) {
    //         throw new UploadMissingFileException();
    //     }

    //     // receive the file
    //     $save = $receiver->receive();

    //     // check if the upload has finished (in chunk mode it will send smaller files)
    //     if ($save->isFinished()) {
    //         // save the file and return any response you need, current example uses `move` function. If you are
    //         // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
    //         return $this->saveFile($save->getFile());
    //     }

    //     // we are in chunk mode, lets send the current progress
    //     /** @var AbstractHandler $handler */
    //     $handler = $save->handler();

    //     return response()->json([
    //         "done" => $handler->getPercentageDone(),
    //         'status' => true
    //     ]);
    // }
	
	public function course_preview(Request $request)
    {
        $sql = Course::selectRaw('courses.id, courses.slug, courses.course_level, courses.course_duration, courses.price, courses.status, courses.created_at, courses.title, courses.image, courses_modules.id as module_id')
            ->orderBy('courses.id', 'desc')
            ->leftjoin('courses_modules', function ($q) {
                $q->on('courses.id', 'courses_modules.courses_id');
            })
            ->GroupBy('courses_modules.courses_id');

        $lists = 1;
        $perPage = 10;
        $records = $sql->paginate($perPage);
        // return $records;
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('admin.courses.course_preview', compact('lists', 'serial', 'records'));
    }

    public function courses(Request $request, $id, $module_id, $lession_id = 0, $forward = 0)
    {
		$getCourses = Course::where(['id' => $id, 'status' => '1'])->first();
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
        $lession_complete =  $getModuleHistory[0]->complete_lession != "" ? count(json_decode($getModuleHistory[0]->complete_lession, true)) : 0;
        $getCourseLession = CourseLesson::where(['course_id' => $id, 'module_id' => $module_id, 'id' => $lession_id])->first();
        $course_id = $id;
        $next_record = CourseLesson::where('id', '>', $lession_id)->where(['course_id' => $id, 'module_id' => $module_id])->orderBy('id')->first();
        if (($forward == 1 || $forward == 2) && ($lession_id > 0 || $lession_id == 0)) :
            self::update_module_history_next($course_id, $module_id, $forward, $lession_id);
        endif;
		$lession_status = 0;
        if ($getModuleHistory[0]->complete_lession != "") :
            $lession_status = in_array($lession_id, json_decode($getModuleHistory[0]->complete_lession, true));
        endif;
        $previous_record = CourseLesson::where('id', '<', $lession_id)->where(['course_id' => $id, 'module_id' => $module_id])->orderBy('id', 'desc')->first();
        return view('admin.courses.courses_start', compact('getModuleHistory', 'getCoursesModule', 'getCourseLession', 'course_id', 'module_id', 'lession_id', 'next_record', 'previous_record', 'forward', 'lession_complete', 'getCourses', 'lession_status'));
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
        return $insert;
    }

    private function getCourseModule($id, $module_id)
    {
        // $getModule = CourseModuleHistorie::where(['courses_id' => $id, 'status' => '1', 'created_by' => Auth::user()->id])->get();
        // $arr = [];
        // if (!blank($getModule)) :
            // foreach ($getModule as $val) :
                // $arr[] = $val->module_id;
                // if ($val->module_status == '1') :
                    // $next_module_record = CoursesModule::where('id', '>', $val->module_id)->where(['courses_id' => $id])->orderBy('id')->first();
                    // if (!blank($next_module_record)) :
                        // $getCourseLessons = CourseLesson::where(['course_id' => $id, 'module_id' => $next_module_record->id, 'status' => '1'])->get();
                        // if (!blank($getCourseLessons)) :
                            // $arr[] = $next_module_record->id;
                        // endif;
                    // endif;
                // endif;
            // endforeach;
        // endif;
        //if (!blank($arr)) :
            $getCourseModule = CoursesModule::where(['courses_id' => $id, 'status' => '1'])->orderBy('id')->get();
            return $getCourseModule;
        //endif;
    }

    private function update_module_history_next($course_id, $module_id, $forward, $lession_id)
    {
        $getTotalLessionFinished = CourseModuleHistorie::where(['courses_id' => $course_id, 'module_id' => $module_id, 'status' => '1', 'created_by' => Auth::user()->id])->first();
        $completeLession = $getTotalLessionFinished->complete_lession != "" ? json_decode($getTotalLessionFinished->complete_lession, true) : [];
        if ($forward == 2 && $lession_id > 0 && $getTotalLessionFinished->ongoing_lession != $lession_id && $getTotalLessionFinished->ongoing_lession != "") :
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
        elseif ($forward == 2 && $lession_id == 0 && $getTotalLessionFinished->ongoing_lession != "") :
            $completeLession[] = $getTotalLessionFinished->ongoing_lession;
            unset($completeLession[null]);
            $data = CourseModuleHistorie::find($getTotalLessionFinished->id);
            $data->update(['module_status' => '1', 'complete_lession' => json_encode(array_unique($completeLession)), 'ongoing_lession' => null]);
        endif;

        $data = CourseModuleHistorie::find($getTotalLessionFinished->id);
        if ($lession_id > 0) :
            $data->update(['ongoing_lession' => $lession_id]);
        endif;
    }

    public function course_module_change(Request $request)
    {
        $next_record = CourseLesson::where(['course_id' => $request->courses_id, 'module_id' => $request->module_id, 'status' => '1'])->orderBy('id')->first();
        return redirect('admin/course/preview/' . $request->courses_id . '/' . $request->module_id . '/' . $next_record->id . '/2');
    }
}
