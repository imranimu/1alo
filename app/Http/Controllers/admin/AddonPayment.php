<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\AddonAmount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddonPayment extends Controller
{
    public function index(Request $request)
    {
        $sql = AddonAmount::orderBy('id', 'desc');
        if (!empty($request->q)) {
            $sql->Where('name', 'LIKE', '%' . $request->q . '%');
        }
        $lists = 1;
        $perPage = 10;
        $records = $sql->paginate($perPage);
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('admin.addon.index', compact('lists', 'serial', 'records'));
    }

    public function store_addon(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'amount' => 'required',
            'is_addons' => 'required',
        ]);
        try {
            $insert = AddonAmount::create([
                'name' => $request->title,
                'amount' => $request->amount,
                'is_type' => $request->is_addons,
                'created_by' => Auth::user()->id,
            ]);

            if ($insert) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Addon add successfully']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Addon add failed.']);
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
            $data = AddonAmount::find($request->id);
            if ($data != "") :
                $image = $data->image;
                $result = $data->delete();
                if ($result) :
                    return response()->json(['status' => 1, 'text' => 'Addon delete successfully']);
                else :
                    return response()->json(['status' => 0, 'text' => 'Addon delete failed.']);
                endif;
            else :
                return response()->json(['status' => 0, 'text' => 'Addon not found!']);
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
                $checkNav = AddonAmount::where(['sort' => $request->sortVal])->get();
            endif;

            if (count($checkNav) == 0) :
                $data = AddonAmount::find($request->id);
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

    public function edit(Request $request)
    {
        $data = AddonAmount::findOrFail($request->id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'title' => 'required',
            'amount' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) :
            return response()->json(['status' => 2, 'errors' => $validator->errors()]);
        else :
            $updateData = [
                'name' => $request->title,
                'amount' => $request->amount,
                'status' => $request->status,
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d h:i:s')
            ];

            $data = AddonAmount::find($request->id);
            $update = $data->update($updateData);

            if ($update) :
                return response()->json(['status' => 1, 'text' => 'Addon update successfully']);
            else :
                return response()->json(['status' => 0, 'text' => 'Addon update failed.']);
            endif;
        endif;
    }
}
