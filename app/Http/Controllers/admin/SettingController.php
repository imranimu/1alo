<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\DrSetting;
use Database\Seeders\DrSettingTableSeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;

class SettingController extends Controller
{
    public function setting()
    {
        $data = DrSetting::first();
        if ($data == "") :
            $SettingSeed = new DrSettingTableSeed();
            $SettingSeed->run();
        endif;
        return view('admin.setting.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'title' => 'required',
            'mobile_no' => 'required',
            'phone_no' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);

        try {
            $update = [
                'title' => $request->title,
                'mobile_no' => $request->mobile_no,
                'phone_no' => $request->phone_no,
                'email' => $request->email,
                'address' => $request->address,
                'facebook_link' => $request->facebook_link,
                'instagram_link' => $request->instagram_link,
                'pinterest_link' => $request->pinterest_link,
                'linkedin_link' => $request->linkedin_link,
                'twitter_link' => $request->twitter_link,
                'youtube_link' => $request->youtube_link,
                'updated_at' => date('Y-m-d h:i:s')
            ];

            $data = DrSetting::find($request->id);
            $result = $data->update($update);
            if ($result > 0) :
                $request->session()->flash('message', ['status' => 1, 'text' => 'Setting was successfully updated!']);
            else :
                $request->session()->flash('message', ['status' => 0, 'text' => 'Setting update failed!']);
            endif;
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 1, 'text' => $e->getMessage()]);
        }
        return redirect()->back();
    }
}
