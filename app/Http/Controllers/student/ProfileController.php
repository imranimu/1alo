<?php

namespace App\Http\Controllers\student;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Image;

class ProfileController extends Controller
{
	public function profile()
    {
        return view('student.profile.profile');
    }
	
    public function modify_address()
    {
        $action_url = 'student/address/' . Auth::user()->id . '/update';
        return view('student.profile.index', compact('action_url'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::find($id);
        return view('admin.profile.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'mobile_no' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'address1' => 'required',
            'postcode' => 'required',
            'city_town' => 'required',
            'country' => 'required',
        ]);
        try {
            $update = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile_no' => $request->mobile_no,
                'address1' => $request->address1,
                'address2' => $request->address2,
                'city_town' => $request->city_town,
                'postcode' => $request->postcode,
                'country' => $request->country,
				'dob' => $request->dob,
                'gender' => $request->gender,
                'updated_at' => date('Y-m-d h:i:s')
            ];

            $data = User::find($id);
            $result = $data->update($update);
            if ($result > 0) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'User details successfully updated!']);
            else :
                $request->session()->flash('message', ['status' => 0, 'text' => 'User details update failed!']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
        }
        return redirect()->back();
    }

    public function change_password()
    {
        $action_url = 'student/update-password/' . Auth::user()->id . '/update';
        return view('student.password.index', compact('action_url'));
    }

    public function update_password(Request $request, $id)
    {
        $this->validate($request, [
            'current_Password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required_with:new_password|same:new_password|min:8'
        ]);

        $user = User::findOrFail($id);
        if (!Hash::check($request->confirm_password, $user->password)) :
            $update = $user->fill([
                'password' => Hash::make($request->confirm_password)
            ])->save();

            if ($update > 0) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Password has been updated', 'current_pass' => '', 'new_pass' => '', 'confirm_pass' => '']);
            else :
                $request->session()->flash('message', ['status' => 0,  'text' => 'Password update failed', 'current_pass' => $request->current_Password, 'new_pass' => $request->new_password, 'confirm_pass' => $request->confirm_password]);
            endif;
        else :
            $request->session()->flash('message', ['status' => 0,  'text' => 'Current Password does not match', 'current_pass' => $request->current_Password, 'new_pass' => $request->new_password, 'confirm_pass' => $request->confirm_password]);
        endif;
        return redirect()->back();
    }
}
