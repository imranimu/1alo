<?php

use App\Http\Controllers\admin\AddonPayment;
use App\Http\Controllers\admin\CourseController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\DocumentController;
use App\Http\Controllers\admin\ExamMasterController;
use App\Http\Controllers\admin\LicenseController;
use App\Http\Controllers\admin\MemberController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\frontend\FrontendController;
use App\Http\Controllers\frontend\PaymentController;
use App\Http\Controllers\student\CourseCertificatesController;
use App\Http\Controllers\admin\CertificatesController;
use App\Http\Controllers\admin\GuidelineController;
use App\Http\Controllers\admin\SecurityQuestionController;
use App\Http\Controllers\student\DashboardController as StudentDashboardController;
use App\Http\Controllers\student\ProfileController as StudentProfileController;
use App\Http\Controllers\student\CoursesController as StudentCoursesController;
use App\Http\Controllers\student\StudentExamController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [FrontendController::class, 'index']);
Route::get('/about-us', [FrontendController::class, 'about_us'])->name('about-us');
Route::get('/courses', [FrontendController::class, 'courses'])->name('courses');
Route::get('/team', [FrontendController::class, 'team'])->name('team');
Route::get('/contact-us', [FrontendController::class, 'contact_us'])->name('contact-us');
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/faqs', [FrontendController::class, 'faqs'])->name('faqs');

Route::post('student/email-check', [PaymentController::class, 'email_check'])->name('student.email-check');

//payment
Route::post('payment/stripe-card-payment', [PaymentController::class, 'stripe_card_payment'])->name('payment.stripe-card-payment');
Route::post('payment/payment-init', [PaymentController::class, 'payment_init'])->name('payment.payment-init');
Route::post('student/course-payment-validation', [PaymentController::class, 'course_payment_validation'])->name('student.course-payment-validation');
Route::get('student/course-checkout', [PaymentController::class, 'courses_checkout'])->name('payment.course-checkout');
Route::post('payment/cart', [PaymentController::class, 'course_cart'])->name('payment.cart');
Route::get('payment/card-payment-response/{CHECKOUT_SESSION_ID}/{id}', [PaymentController::class, 'card_payment_response']);
Route::get('payment/success/{transaction_id}/{id}', [PaymentController::class, 'success']);
Route::get('payment/failed/{id}', [PaymentController::class, 'failed']);

//course
Route::get('/courses/purchase', [PaymentController::class, 'course_purchase'])->name('courses.purchase');
Route::get('/courses/{slug}', [PaymentController::class, 'courses_details'])->name('courses.{slug}');


Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/login', [LoginController::class, 'show']);
Auth::routes(['register' => false, 'verify' => false]);

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('update');
    Route::get('/change-password', [ProfileController::class, 'change_password'])->name('change_password');
    Route::put('/update-password/{id}/update', [ProfileController::class, 'update_password'])->name('update_password');

    //setting
    Route::get('/setting', [SettingController::class, 'setting'])->name('setting');
    Route::post('/setting/update', [SettingController::class, 'update'])->name('setting.update');

    //addon
    Route::get('addon/add-addon', [AddonPayment::class, 'index'])->name('addon.add-addon');
    Route::post('addon/store-addon', [AddonPayment::class, 'store_addon'])->name('addon.store-addon');
    Route::post('addon/sort', [AddonPayment::class, 'sort'])->name('addon.sort');
    Route::post('addon/destroy', [AddonPayment::class, 'destroy'])->name('addon.destroy');
    Route::post('addon/edit', [AddonPayment::class, 'edit'])->name('addon.edit');
    Route::post('addon/update', [AddonPayment::class, 'update'])->name('addon.update');

    //courses
    Route::get('/course/course-createe', [CourseController::class, 'index'])->name('course.course-createe');
    Route::post('/course/store-course', [CourseController::class, 'store_course'])->name('course.store-course');
    Route::get('/course/course-lists', [CourseController::class, 'show_course'])->name('course.course-lists');
    Route::post('/course/set-sort', [CourseController::class, 'set_sort'])->name('course.set-sort');
    Route::get('/course/{id}/edit', [CourseController::class, 'edit_course'])->name('course.{id}.edit');
    Route::post('/course/{id}/update', [CourseController::class, 'update_course'])->name('course.{id}.update');
    Route::post('/course/destroy-course', [CourseController::class, 'destroy_course'])->name('course.destroy-course');
	Route::get('/course/{courses_id}/{id}/course-lesson-add', [CourseController::class, 'course_lesson_add']);
    Route::post('course/destroy-course-lesson', [CourseController::class, 'destroy_course_lesson'])->name('addon.destroy-course-lesson');
	
	//Course Module
    Route::get('/course/{id}/course-module-add', [CourseController::class, 'course_module_add'])->name('course.{id}.course-module-add');
    Route::post('/course/store-course-module', [CourseController::class, 'store_course_module'])->name('addon.store-course-module');
    Route::post('/course/courses-module-edit', [CourseController::class, 'courses_module_edit']);
    Route::post('/course/courses-module-update', [CourseController::class, 'courses_module_update']);
    Route::post('/course/destroy-course-module', [CourseController::class, 'destroy_course_module'])->name('course.destroy-course-module');
    Route::post('/course/set-module-sort', [CourseController::class, 'set_module_sort'])->name('course.set-module-sort');

    //course lesson
    Route::post('/course/store-course-lesson', [CourseController::class, 'store_course_lesson'])->name('course.store-course-lesson');
    Route::post('/course/{id}/update-course-lesson', [CourseController::class, 'update_course_lesson']);
	
	//payment list
    Route::get('/payment/show', [CourseController::class, 'payment_show'])->name('payment.show');
    Route::post('/payment/get-addons-history', [CourseController::class, 'get_addons_history'])->name('payment.get-addons-history');
	
	//user all members
    Route::get('/admin-show', [MemberController::class, 'admin_lists'])->name('admin-show');
    Route::get('/user/{id}/edit', [MemberController::class, 'edit_admin'])->name('user.{id}.edit');
    Route::put('/user/{id}/update', [MemberController::class, 'update_user'])->name('user.{id}.update');
    Route::get('/user/add-user', [MemberController::class, 'add_user'])->name('user.add-user');
    Route::post('/user/store-user', [MemberController::class, 'store_user'])->name('user.store-user');

    //student
    Route::get('/student-show', [MemberController::class, 'student_lists'])->name('student-show');
    Route::get('/student/{id}/edit', [MemberController::class, 'edit_student'])->name('student.{id}.edit');
    Route::put('/student/{id}/update', [MemberController::class, 'update_student'])->name('student.{id}.update');
    Route::get('/user/{id}/password', [MemberController::class, 'change_user_password']);
    Route::put('/user-password/{id}/update', [MemberController::class, 'user_password_update']);
	
	//Exam Master
    Route::get('/question/exam-show', [ExamMasterController::class, 'index'])->name('question.exam-show');
    Route::post('/question/get-module', [ExamMasterController::class, 'get_module'])->name('question.get-module');
    Route::post('/question/store-exam', [ExamMasterController::class, 'store_exam'])->name('question.store-exam');
    Route::post('/question/exam-delete', [ExamMasterController::class, 'exam_delete'])->name('question.exam-delete');
    Route::get('/question/exam/{id}/edit', [ExamMasterController::class, 'edit_exam'])->name('question.exam.{id}.edit');
    Route::post('/question/update-exam', [ExamMasterController::class, 'update_exam'])->name('question.update-exam');
    Route::post('/question/set-limit-number', [ExamMasterController::class, 'set_random_limit_number'])->name('question.set-limit-number');

    //question
    Route::get('/question/show/{id}', [ExamMasterController::class, 'question_show'])->name('question.exam-show.{id}');
    Route::post('/question/store-question', [ExamMasterController::class, 'store_question'])->name('question.store-question');
    Route::get('/question/{id}/edit', [ExamMasterController::class, 'edit_question'])->name('question.{id}.edit');
    Route::post('/question/update', [ExamMasterController::class, 'update_question'])->name('question.update');
	Route::post('/question/question-destroy', [ExamMasterController::class, 'question_destroy'])->name('question.question-destroy');
	
	//doument
    Route::get('/document/show', [DocumentController::class, 'index'])->name('document.show');
    Route::post('/document/store', [DocumentController::class, 'store'])->name('document.store');
    Route::post('/document/set-sort', [DocumentController::class, 'set_sort'])->name('document.set-sort');
    Route::post('/document/destroy', [DocumentController::class, 'destroy'])->name('document.destroy');
	
	//courses preview
    Route::get('/course/course-preview', [CourseController::class, 'course_preview'])->name('course.course-preview');
    Route::get('/course/preview/{id}/{module_id}/{lession_id}/{forward}', [CourseController::class, 'courses']);
    Route::post('/course/preview/course-module-change', [CourseController::class, 'course_module_change'])->name('course.course-module-change');
	
	//License
    Route::get('license/add-license', [LicenseController::class, 'index'])->name('license.add-license');
    Route::post('license/store-license', [LicenseController::class, 'store_license'])->name('license.store-license');
    Route::post('license/destroy', [LicenseController::class, 'destroy'])->name('license.destroy');
    Route::post('license/edit', [LicenseController::class, 'edit'])->name('license.edit');
    Route::post('license/update', [LicenseController::class, 'update'])->name('license.update');
	Route::post('license/import-license-number', [LicenseController::class, 'import_license_number'])->name('license.import-license-number');
	
	//report
	Route::get('/report', [ProfileController::class, 'report'])->name('report');
    Route::get('/report/{course_id}/{student_id}/download', [ProfileController::class, 'report_download']);
	
	//generate certificate
	Route::get('/certificate', [CertificatesController::class, 'show'])->name('show');
    Route::get('/get-certificate/{id}/{student_id}/download', [CertificatesController::class, 'index'])->name('get-certificate.{id}.download');
	
	//Security Question
    Route::get('security/add-question', [SecurityQuestionController::class, 'index'])->name('security.add-question');
    Route::post('security/store-question', [SecurityQuestionController::class, 'store_question'])->name('security.store-question');
    Route::post('security/destroy', [SecurityQuestionController::class, 'destroy'])->name('security.destroy');
    Route::post('security/edit', [SecurityQuestionController::class, 'edit'])->name('security.edit');
    Route::post('security/update', [SecurityQuestionController::class, 'update'])->name('security.update');
	
	//Guideline
    Route::get('guide/show', [GuidelineController::class, 'index'])->name('guide.show');
    Route::post('guide/store', [GuidelineController::class, 'store'])->name('guide.store');
    Route::post('guide/destroy', [GuidelineController::class, 'destroy'])->name('guide.destroy');
    Route::post('guide/edit', [GuidelineController::class, 'edit'])->name('guide.edit');
    Route::post('guide/update', [GuidelineController::class, 'update'])->name('guide.update');
    Route::post('guide/sort', [GuidelineController::class, 'sort'])->name('guide.sort');
});

Route::group(['as' => 'student.', 'prefix' => 'student', 'namespace' => 'student', 'middleware' => ['auth', 'student', 'password.confirm']], function () {
	//security question
    Route::get('/login-security-question', [StudentDashboardController::class, 'login_security_question'])->name('login-security-question');
    Route::post('/set-security-question', [StudentDashboardController::class, 'set_security_question'])->name('set-security-question');
	
    //Dashboard
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [StudentProfileController::class, 'profile'])->name('profile');    
    Route::get('/summary', [StudentDashboardController::class, 'summary'])->name('summary');
    Route::get('/questions', [StudentDashboardController::class, 'questions'])->name('questions');
    Route::get('/quiz', [StudentExamController::class, 'index'])->name('quiz');
	Route::get('/guideline', [StudentDashboardController::class, 'guideline'])->name('guideline');
	
	//course
	Route::get('/course-lists', [StudentCoursesController::class, 'courses_list'])->name('course-lists');
    Route::get('/course/{id}/{module_id}/{lession_id}/{forward}', [StudentCoursesController::class, 'courses']);
	Route::post('/course/course-module-change', [StudentCoursesController::class, 'course_module_change'])->name('course.course-module-change');
	Route::post('/get-course-lesson-percentage', [StudentCoursesController::class, 'getCourseLessonPercentage'])->name('get-course-lesson-percentage');

    //change password
    Route::get('/change-password', [StudentProfileController::class, 'change_password'])->name('change-password');
    Route::post('/update-password/{id}/update', [StudentProfileController::class, 'update_password']);

    //address modify
    Route::get('/modify-address', [StudentProfileController::class, 'modify_address'])->name('modify-address');
    Route::post('/address/{id}/update', [StudentProfileController::class, 'update']);
	
	//exam
    Route::get('/join-exam/{id}', [StudentExamController::class, 'join_exam'])->name('join-exam.{id}');
    Route::post('/store-exam', [StudentExamController::class, 'store_exam'])->name('store-exam');
	Route::get('/view-result/{id}', [StudentExamController::class, 'view_result'])->name('view-result.{id}');
	
	//doument
	Route::get('/certificate', [CourseCertificatesController::class, 'show'])->name('show');
    Route::get('/document', [DocumentController::class, 'document_show'])->name('document');
	Route::get('/report', [CourseCertificatesController::class, 'report'])->name('report');
    Route::get('/report/{course_id}/download', [CourseCertificatesController::class, 'report_download']);
	
	//payment details
	Route::post('/payment/get-payment-history', [StudentCoursesController::class, 'get_payment_history'])->name('payment.get-payment-history');
	
	//generate certificate
    Route::get('/get-certificate/{id}/download', [CourseCertificatesController::class, 'index'])->name('get-certificate.{id}.download');
    Route::get('/get-certificate-c2', [CourseCertificatesController::class, 'certificate_c2'])->name('get-certificate-c2');

    //test certificate create
    Route::get('/set-student-certificate', [StudentExamController::class, 'set_student_certificate'])->name('set-student-certificate');
});
