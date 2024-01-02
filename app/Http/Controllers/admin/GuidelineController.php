<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Guideline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GuidelineController extends Controller
{
    public function index(Request $request)
    {
        $sql = Guideline::orderBy('id', 'desc');
        if (!empty($request->q)) {
            $sql->Where('title', 'LIKE', '%' . $request->q . '%');
        }
        $lists = 1;
        $perPage = 10;
        $records = $sql->paginate($perPage)->withQueryString();
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('admin.guideline.index', compact('lists', 'serial', 'records'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);
        try {
            $insert = Guideline::create([
                'title' => $request->title,
                'description' => $request->description,
                'created_by' => Auth::user()->id,
            ]);

            if ($insert) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Guideline add successfully']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Guideline add failed.']);
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
            $data = Guideline::find($request->id);
            if ($data != "") :
                $result = $data->delete();
                if ($result) :
                    return response()->json(['status' => 1, 'text' => 'Guideline delete successfully']);
                else :
                    return response()->json(['status' => 0, 'text' => 'Guideline delete failed.']);
                endif;
            else :
                return response()->json(['status' => 0, 'text' => 'Guideline not found!']);
            endif;
        endif;
    }

    public function edit(Request $request)
    {
        $data = Guideline::findOrFail($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'errors' => $validator->errors()]);
        else :
            $updateData = [
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d h:i:s')
            ];

            $data = Guideline::find($request->id);
            $update = $data->update($updateData);

            if ($update) :
                return response()->json(['status' => 1, 'text' => 'Guideline update successfully']);
            else :
                return response()->json(['status' => 0, 'text' => 'Guideline update failed.']);
            endif;
        endif;
    }

    public function sort(Request $request)
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
                $checkNav = Guideline::where(['sort' => $request->sortVal])->get();
            endif;

            if (count($checkNav) == 0) :
                $data = Guideline::find($request->id);
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
}
