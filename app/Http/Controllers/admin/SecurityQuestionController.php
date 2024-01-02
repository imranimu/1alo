<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\LoginQuestion;
use App\Models\admin\SecurityQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SecurityQuestionController extends Controller
{
    public function index(Request $request)
    {
        $sql = SecurityQuestion::orderBy('id', 'desc');
        if (!empty($request->q)) {
            $sql->Where('question', 'LIKE', '%' . $request->q . '%');
        }
        $lists = 1;
        $perPage = 10;
        $records = $sql->paginate($perPage);
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('admin.security_question.index', compact('lists', 'serial', 'records'));
    }

    public function store_question(Request $request)
    {
        $this->validate($request, [
            'question' => 'required',
            'is_type' => 'required',
        ]);
        try {
            $insert = SecurityQuestion::create([
                'question' => $request->question,
				'is_type' => $request->is_type,
                'created_by' => Auth::user()->id,
            ]);

            if ($insert) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Security question add successfully']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Security question add failed.']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 0, 'text' => $e->getMessage()]);
        }
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'text' => $validator->errors()]);
        else :
            $data = SecurityQuestion::find($request->id);
            if ($data != "") :
                $image = $data->image;
                $result = $data->delete();
                if ($result) :
                    return response()->json(['status' => 1, 'text' => 'Security question delete successfully']);
                else :
                    return response()->json(['status' => 0, 'text' => 'Security question delete failed.']);
                endif;
            else :
                return response()->json(['status' => 0, 'text' => 'Security question not found!']);
            endif;
        endif;
    }

    public function edit(Request $request)
    {
        $data = SecurityQuestion::findOrFail($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'question' => 'required',
			'is_type' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'errors' => $validator->errors()]);
        else :
            $updateData = [
                'question' => $request->question,
                'is_type' => $request->is_type,
                'status' => $request->status,
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d h:i:s')
            ];

            $data = SecurityQuestion::find($request->id);
            $update = $data->update($updateData);

            if ($update) :
                return response()->json(['status' => 1, 'text' => 'Security question update successfully']);
            else :
                return response()->json(['status' => 0, 'text' => 'Security question update failed.']);
            endif;
        endif;
    }
}
