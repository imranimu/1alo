<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\LicenseImport;
use App\Models\admin\CourseLicense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Excel;

class LicenseController extends Controller
{
    public function index(Request $request)
    {
        $sql = CourseLicense::where('license_status', '0')->orderBy('id', 'desc');
        if (!empty($request->q)) {
            $sql->Where('license', 'LIKE', '%' . $request->q . '%');
        }
        $lists = 1;
        $perPage = 10;
        $records = $sql->paginate($perPage);
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('admin.license.index', compact('lists', 'serial', 'records'));
    }

    public function store_license(Request $request)
    {
        $this->validate($request, [
            'license' => 'required',
        ]);
        try {
            $insert = CourseLicense::create([
                'license' => $request->license,
                'created_by' => Auth::user()->id,
            ]);

            if ($insert) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'License add successfully']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'License add failed.']);
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
            $data = CourseLicense::find($request->id);
            if ($data != "") :
                $result = $data->delete();
                if ($result) :
                    return response()->json(['status' => 1, 'text' => 'License delete successfully']);
                else :
                    return response()->json(['status' => 0, 'text' => 'License delete failed.']);
                endif;
            else :
                return response()->json(['status' => 0, 'text' => 'Addon not found!']);
            endif;
        endif;
    }

    public function edit(Request $request)
    {
        $data = CourseLicense::findOrFail($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'license' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'errors' => $validator->errors()]);
        else :
            $updateData = [
                'license' => $request->license,
                'status' => $request->status,
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d h:i:s')
            ];

            $data = CourseLicense::find($request->id);
            $update = $data->update($updateData);

            if ($update) :
                return response()->json(['status' => 1, 'text' => 'License update successfully']);
            else :
                return response()->json(['status' => 0, 'text' => 'License update failed.']);
            endif;
        endif;
    }
	
	/**
     * @return \Illuminate\Support\Collection
     */
    public function import_license_number(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
            'file.*' => 'mimes:csv|max:2048',
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'errors' => $validator->errors()]);
        else :
            Excel::import(new LicenseImport, $request->file('file')->store('temp'));
            $request->session()->flash('message', ['status' => 1, 'text' => 'License add successfully']);
            return redirect()->back();
        endif;
    }
}
