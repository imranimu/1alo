<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(['status' => true, 'data' => auth('api')->user()]);
    }

    public function userUpdate(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:40',
            'mobile_no' => 'required|string|min:15',
            'dob' => 'required',
            'gender' => 'required|string|min:10',
            'address1' => 'required|string|min:150',
            'postcode' => 'required|string|min:10',
            'city_town' => 'required|string|min:30',
            'country' => 'required|string|min:30',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors(), 'message' => 'Some field is required'], 200);
        }
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
            $id = auth('api')->user()->id;
            $data = User::find($id);
            $result = $data->update($update);
            if ($result > 0) {
                return response()->json(['status' => true, 'message' => 'User details was successfully updated!', 'error' => ''], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'User details update failed!', 'error' => ''], 200);
            }
        } catch(\Expiration $e) {
            return response()->json(['status' => false, 'error' => $e->getMessage(), 'message' => 'Expiration error'], 200);
        }
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_Password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required_with:new_password|same:new_password|min:8'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors(), 'message' => 'Some field is required'], 200);
        }
        $id = auth('api')->user()->id;
        $user = User::findOrFail($id);
        if (!Hash::check($request->current_Password, $user->password)) {
            $update = $user->update(['password' => Hash::make($request->confirm_password)]);
            if ($update > 0) {
                return response()->json(['status' => true, 'message' => 'Password has been updated'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Password update failed'], 200);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Current Password does not match'], 200);
        }
    }
}
