<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\admin\Guideline;
use Illuminate\Http\Request;

class GuidelineController extends Controller
{
    public function getGuidlineLists(Request $request)
    {
        return response()->json(['status' => false, 'data' => Guideline::where(['status' => '1'])->get()]);
    }
}
