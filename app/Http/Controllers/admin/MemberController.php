<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function student_lists(Request $request)
    {
        $sql = User::where('is_role', '=', 2)->orderBy('id', 'desc');

        if (!empty($request->q)) {
            $sql->Where('first_name', 'LIKE', '%' . $request->q . '%')
                ->orWhere('last_name', 'LIKE', '%' . $request->q . '%')
                ->orWhere('username', 'LIKE', '%' . $request->q . '%')
                ->orWhere('email', 'LIKE', '%' . $request->q . '%');
        }

        $lists = 1;
        $perPage = 20;
        $records = $sql->paginate($perPage);
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('admin.users.student', compact('lists', 'serial', 'records'));
    }

    public function admin_lists(Request $request)
    {
        $sql = User::whereIn('is_role', [1, 4, 5])->orderBy('id', 'desc');

        if (!empty($request->q)) {
            $sql->Where('first_name', 'LIKE', '%' . $request->q . '%')
                ->orWhere('last_name', 'LIKE', '%' . $request->q . '%')
                ->orWhere('username', 'LIKE', '%' . $request->q . '%')
                ->orWhere('email', 'LIKE', '%' . $request->q . '%');
        }

        $lists = 1;
        $perPage = 20;
        $records = $sql->paginate($perPage);
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('admin.users.admin', compact('lists', 'serial', 'records'));
    }

    public function edit_student(Request $request, $id)
    {
        $getUserInfo  = user::where('id', $id)->first();
        return view('admin.users.edit_student_details', compact('getUserInfo'));
    }

    public function update_student(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
			'mobile_no' => 'required',
            'email' => 'required',
			'dob' => 'required',
            'gender' => 'required',
			'address1' => 'required',
            'postcode' => 'required',
            'city_town' => 'required',
            'country' => 'required',
        ]);

        $user = User::findOrFail($id);
        try {
            $update = $user->fill([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile_no' => $request->mobile_no,
                'address1' => $request->address1,
                'address2' => $request->address2,
                'city_town' => $request->city_town,
                'postcode' => $request->postcode,
                'country' => $request->country,
				'dob' => $request->dob,
                'gender' => $request->gender,
                'status' => $request->status,
            ])->save();

            if ($update > 0) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Profile has been updated']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Profile update failed']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 0,  'text' => $e->getMessage()]);
        }

        return redirect()->back();
    }

    public function change_user_password(Request $request, $id)
    {
        $is_type = 1;
        $action_url = 'admin/user-password/' . $id . '/update';
        return view('admin.users.change_password', compact('action_url', 'is_type'));
    }

    public function user_password_update(Request $request, $id)
    {
        $this->validate($request, [
            'new_password' => 'required|min:6',
            'confirm_password' => 'required_with:new_password|same:new_password|min:6'
        ]);

        $user = User::findOrFail($id);
        if (!Hash::check($request->confirm_password, $user->password)) :
            $update = $user->fill([
                'password' => Hash::make($request->confirm_password)
            ])->save();

            if ($update > 0) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Password has been updated', 'new_pass' => '', 'confirm_pass' => '']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Password update failed', 'current_pass' => $request->current_Password, 'new_pass' => $request->new_password, 'confirm_pass' => $request->confirm_password]);
            endif;
        else :
            $request->session()->flash('message', ['status' => 0,  'text' => 'Current Password does not match', 'current_pass' => $request->current_Password, 'new_pass' => $request->new_password, 'confirm_pass' => $request->confirm_password]);
        endif;
        return redirect()->back();
    }

    public function edit_admin(Request $request, $id)
    {
        $getUserInfo  = user::where('id', $id)->first();
        return view('admin.users.edit_admin_details', compact('getUserInfo'));
    }

    public function update_user(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'email' => 'required',
			'dob' => 'required',
            'gender' => 'required',
            'address1' => 'required',
            'postcode' => 'required',
            'city_town' => 'required',
            'country' => 'required',
			'mobile_no' => 'required',
        ]);

        $user = User::findOrFail($id);
        try {
            $update = $user->fill([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile_no' => $request->mobile_no,
                'address1' => $request->address1,
                'address2' => $request->address2,
                'city_town' => $request->city_town,
                'postcode' => $request->postcode,
                'country' => $request->country,
				'dob' => $request->dob,
                'gender' => $request->gender,
                'status' => $request->status,
            ])->save();

            if ($update > 0) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Profile has been updated']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Profile update failed']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 0,  'text' => $e->getMessage()]);
        }

        return redirect()->back();
    }

    public function add_user(Request $request)
    {
        return view('admin.users.add_user');
    }

    public function store_user(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
        ]);

        try {
            $insert = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile_no' => $request->mobile_no,
                'address1' => $request->address1,
                'address2' => $request->address2,
                'city_town' => $request->city_town,
                'postcode' => $request->postcode,
                'country' => $request->country,
                'is_role' => '1',
                'password' => Hash::make($request->password),
                'status' => $request->status,
            ]);

            if ($insert) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'User has been created']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'User create failed']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 0,  'text' => $e->getMessage()]);
        }

        return redirect()->back();
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
