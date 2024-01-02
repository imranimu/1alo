<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\admin\CourseController;
use App\Http\Controllers\Controller;
use App\Models\admin\CourseActivitie;
use App\Models\admin\CourseCertificate;
use App\Models\admin\CoursePurchase;
use App\Models\admin\CoursesModule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use setasign\Fpdi\Fpdi;
use PDF;

class CertificatesController extends Controller
{

    public function show(Request $request)
    {
        $sql = CourseCertificate::where(['status' => '1'])->with('get_user')->orderBy('id', 'asc');
        if (!empty($request->q)) {
            $sql->Where('student_id', 'LIKE', '%' . $request->q . '%');
        }

        $lists = 1;
        $perPage = 30;
        $records = $sql->paginate($perPage);
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('admin.certificate.index', compact('lists', 'serial', 'records'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(Request $request, $id, $student_id)
    {
        $getCertificateInfo = CourseCertificate::where(['id' => $id, 'status' => '1', 'created_by' => $student_id])->with('get_license')->first(); 
		$getUser = User::where(['id' => $student_id, 'status' => '1'])->first();
        if ($getUser->first_name =='' || $getUser->dob =='' || $getUser->gender =='') {
            Session::put('getCertificateErrorMessage', [
                'status' => 0,
                'type' => 1,
                'message' => 'This user profile is not 100% complete. That\'s why we are not possible to download certificate.',
            ]);
            return redirect('admin/certificate');
        }

        if (blank($getCertificateInfo)) {
            Session::put('getCertificateErrorMessage', [
                'status' => 0,
                'type' => 2,
                'message' => 'We are detecting the wrong certificate request for your user/account. please try the correct certificate download again.',
            ]);
            return redirect('admin/certificate');
        }
		
		$outputFilePath = '';
        if ($getCertificateInfo->is_type == 'C1' && $getCertificateInfo->student_id == $student_id) {
			$fileName = "Certificate-".$getCertificateInfo->is_type.".pdf";
            $filePath = public_path("cc1.pdf");
            $outputFilePath = public_path($fileName);
            $this->fillPDFFile($filePath, $outputFilePath, $getCertificateInfo, $getUser);
        } elseif ($getCertificateInfo->is_type == 'C2' && $getCertificateInfo->student_id == $student_id) {
            $fileName = "Certificate-".$getCertificateInfo->is_type.".pdf";
            $filePath = public_path("cc2.pdf");
            $outputFilePath = public_path($fileName);
            $this->fillPDFFileC2($filePath, $outputFilePath, $getCertificateInfo, $getUser);
        }

        return response()->file($outputFilePath);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
	 public function fillPDFFile($file, $outputFilePath, $getCertificateInfo, $getUser)
    {
        $fpdi = new FPDI;
        $count = $fpdi->setSourceFile($file);

        for ($i = 1; $i <= $count; $i++) {

            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);

            //top section
            $fpdi->SetFont("helvetica", "", 15);
            $fpdi->SetTextColor(0, 0, 0);

            // $parent_left = 17;
            // $parent_top = 37.4;
            // $parent_text = "x";
            // $fpdi->Text($parent_left, $parent_top, $parent_text);

            // $transfer_left = 17;
            // $transfer_top = 43;
            // $transfer_text = "x";
            // $fpdi->Text($transfer_left, $transfer_top, $transfer_text);

            $fpdi->SetFont("helvetica", "", 10);
            $lastname_left = 28;
            $lastname_top = 75;
            $lastname_text = $getUser->last_name != "" ? $getUser->last_name : '';
            $fpdi->Text($lastname_left, $lastname_top, $lastname_text);

            $fpdi->SetFont("helvetica", "", 10);
            $first_left = 68;
            $first_top = 75;
            $first_text = $getUser->first_name != "" ? $getUser->first_name : '';
            $fpdi->Text($first_left, $first_top, $first_text);

            $fpdi->SetFont("helvetica", "", 10);
            $dob_month_left = 138;
            $dob_month_top = 75;
            $dob_month_text = $getUser->dob != "" ? date('m', strtotime($getUser->dob)) : 0;
            $fpdi->Text($dob_month_left, $dob_month_top, $dob_month_text);

            $fpdi->SetFont("helvetica", "", 10);
            $dob_day_left = 146;
            $dob_day_top = 75;
            $dob_day_text = $getUser->dob != "" ? date('d', strtotime($getUser->dob)) : 0;
            $fpdi->Text($dob_day_left, $dob_day_top, $dob_day_text);

            $fpdi->SetFont("helvetica", "", 10);
            $dob_year_left = 155;
            $dob_year_top = 75;
            $dob_year_text = $getUser->dob != "" ? date('Y', strtotime($getUser->dob)) : 0;
            $fpdi->Text($dob_year_left, $dob_year_top, $dob_year_text);

            if ($getUser->gender == 'male') {
                $fpdi->SetFont("helvetica", "", 14);
                $male_left = 173.2;
                $male_top = 75.6;
                $male_text = "x";
                $fpdi->Text($male_left, $male_top, $male_text);
            }

            if ($getUser->gender == 'female') {
                $fpdi->SetFont("helvetica", "", 14);
                $female_left = 188.4;
                $female_top = 75.6;
                $female_text = "x";
                $fpdi->Text($female_left, $female_top, $female_text);
            }

            $fpdi->SetFont("helvetica", 'B', 14);
            $fpdi->SetTextColor(255,0,0);
            $license_left = 176;
            $license_top = 33;
            $license_text = !blank($getCertificateInfo->get_license) != "" ? $getCertificateInfo->get_license->license : '';
            $fpdi->Text($license_left, $license_top, $license_text);

            $fpdi->SetFont("helvetica", "", 12);
            $fpdi->SetTextColor(0,0,0);
            $date_issued_left = 162;
            $date_issued_top = 132;
            $date_issued_text = $getCertificateInfo->created_at != "" ? date('d/m/Y', strtotime($getCertificateInfo->created_at)) : '';
            $fpdi->Text($date_issued_left, $date_issued_top, $date_issued_text);

            //bottom section
            // $fpdi->SetFont("helvetica", "", 10);
            // $parent_bottom_left = 17;
            // $parent_bottom_top = 168;
            // $parent_bottom_text = "32";
            // $fpdi->Text($parent_bottom_left, $parent_bottom_top, $parent_bottom_text);

            // $fpdi->SetFont("helvetica", "", 10);
            // $has_passed_bottom_left = 50;
            // $has_passed_bottom_top = 176;
            // $has_passed_bottom_text = "Drive Safe Driving School";
            // $fpdi->Text($has_passed_bottom_left, $has_passed_bottom_top, $has_passed_bottom_text);

            // $fpdi->SetFont("helvetica", "", 10);
            // $road_rules_left = 145;
            // $road_rules_top = 168;
            // $road_rules_text = "x";
            // $fpdi->Text($road_rules_left, $road_rules_top, $road_rules_text);

            // $fpdi->SetFont("helvetica", "", 10);
            // $road_signs_left = 172;
            // $road_signs_top = 168;
            // $road_signs_text = "x";
            // $fpdi->Text($road_signs_left, $road_signs_top, $road_signs_text);
        }

        return $fpdi->Output($outputFilePath, 'F');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
	 public function fillPDFFileC2($file, $outputFilePath, $getCertificateInfo, $getUser)
    {
        $fpdi = new FPDI;
        $count = $fpdi->setSourceFile($file);

        for ($i = 1; $i <= $count; $i++) {

            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);

            //top section
            $fpdi->SetFont("helvetica", "", 15);
            $fpdi->SetTextColor(0, 0, 0);

            // $parent_left = 17;
            // $parent_top = 42.7;
            // $parent_text = "x";
            // $fpdi->Text($parent_left, $parent_top, $parent_text);

            // $transfer_left = 17;
            // $transfer_top = 42.7;
            // $transfer_text = "x";
            // $fpdi->Text($transfer_left, $transfer_top, $transfer_text);

            $fpdi->SetFont("helvetica", "", 10);
            $lastname_left = 28;
            $lastname_top = 69.7;
            $lastname_text = $getUser->last_name != "" ? $getUser->last_name : '';
            $fpdi->Text($lastname_left, $lastname_top, $lastname_text);

            $fpdi->SetFont("helvetica", "", 10);
            $first_left = 68;
            $first_top = 69.7;
            $first_text = $getUser->first_name != "" ? $getUser->first_name : '';
            $fpdi->Text($first_left, $first_top, $first_text);

            $fpdi->SetFont("helvetica", "", 10);
            $dob_month_left = 136.8;
            $dob_month_top = 69.7;
            $dob_month_text = $getUser->dob != "" ? date('m', strtotime($getUser->dob)) : 0;
            $fpdi->Text($dob_month_left, $dob_month_top, $dob_month_text);

            $fpdi->SetFont("helvetica", "", 10);
            $dob_day_left = 145;
            $dob_day_top = 69.7;
            $dob_day_text = $getUser->dob != "" ? date('d', strtotime($getUser->dob)) : 0;
            $fpdi->Text($dob_day_left, $dob_day_top, $dob_day_text);

            $fpdi->SetFont("helvetica", "", 10);
            $dob_year_left = 153.8;
            $dob_year_top = 69.7;
            $dob_year_text = $getUser->dob != "" ? date('Y', strtotime($getUser->dob)) : 0;
            $fpdi->Text($dob_year_left, $dob_year_top, $dob_year_text);

            if ($getUser->gender == 'male') {
                $fpdi->SetFont("helvetica", "", 14);
                $male_left = 172.4;
                $male_top = 69.9;
                $male_text = "x";
                $fpdi->Text($male_left, $male_top, $male_text);
            }

            if ($getUser->gender == 'female') {
                $fpdi->SetFont("helvetica", "", 14);
                $female_left = 187.5;
                $female_top = 69.9;
                $female_text = "x";
                $fpdi->Text($female_left, $female_top, $female_text);
            }

            // $fpdi->SetFont("helvetica", "", 15);
            // $has_passed_left = 17.5;
            // $has_passed_top = 82;
            // $has_passed_text = 'x';
            // $fpdi->Text($has_passed_left, $has_passed_top, $has_passed_text);

            // $fpdi->SetFont("helvetica", "", 10);
            // $road_signs_left = 137;
            // $road_signs_top = 81.8;
            // $road_signs_text = '90';
            // $fpdi->Text($road_signs_left, $road_signs_top, $road_signs_text);

            // $fpdi->SetFont("helvetica", "", 10);
            // $road_rule_left = 170;
            // $road_rule_top = 81.8;
            // $road_rule_text = '80';
            // $fpdi->Text($road_rule_left, $road_rule_top, $road_rule_text);

            $fpdi->SetFont("helvetica", "B", 12);
            $fpdi->SetTextColor(255,0,0);
            $license_left = 176;
            $license_top = 33;
            $license_text = !blank($getCertificateInfo->get_license) != "" ? $getCertificateInfo->get_license->license : '';
            $fpdi->Text($license_left, $license_top, $license_text);

            $fpdi->SetFont("helvetica", '', 12);
            $fpdi->SetTextColor(0,0,0);
            $date_issued_left = 162;
            $date_issued_top = 107.9;
            $date_issued_text = $getCertificateInfo->created_at != "" ? date('d/m/Y', strtotime($getCertificateInfo->created_at)) : '';
            $fpdi->Text($date_issued_left, $date_issued_top, $date_issued_text);

            //bottom section
            $fpdi->SetFont("helvetica", "", 10);
            $class_room_bottom_left = 8.5;
            $class_room_bottom_top = 182;
            $class_room_bottom_text = "32";
            $fpdi->Text($class_room_bottom_left, $class_room_bottom_top, $class_room_bottom_text);

            $fpdi->SetFont("helvetica", "", 10);
            $simulator_bottom_left = 150;
            $simulator_bottom_top = 182.5;
            $simulator_bottom_text = "x";
            $fpdi->Text($simulator_bottom_left, $simulator_bottom_top, $simulator_bottom_text);

            $fpdi->SetFont("helvetica", "", 10);
            $multi_car_bottom_left = 180;
            $multi_car_bottom_top = 182.5;
            $multi_car_bottom_text = "x";
            $fpdi->Text($multi_car_bottom_left, $multi_car_bottom_top, $multi_car_bottom_text);

            // $fpdi->SetFont("helvetica", "", 10);
            // $transferring_bottom_left = 50;
            // $transferring_bottom_top = 190;
            // $transferring_bottom_text = "Drive Safe Driving School";
            // $fpdi->Text($transferring_bottom_left, $transferring_bottom_top, $transferring_bottom_text);
        }

        return $fpdi->Output($outputFilePath, 'F');
    }
	
}
