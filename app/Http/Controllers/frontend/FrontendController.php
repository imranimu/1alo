<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\admin\AddonPayment;
use App\Http\Controllers\Controller;
use App\Models\admin\AddonAmount;
use App\Models\admin\Course;
use App\Models\admin\CourseAddonPurchase;
use App\Models\admin\CoursePurchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\FuncCall;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Exception\ApiErrorException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Stripe;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        return view('frontend.home.index');
    }

    public function about_us(Request $request)
    {
        return view('frontend.about.index');
    }

    public function courses(Request $request)
    {
        $sql = Course::orderBy('id', 'desc');
        if (!empty($request->q)) {
            $sql->Where('title', 'LIKE', '%' . $request->q . '%')
                ->orWhere('slug', 'LIKE', '%' . $request->q . '%');
        }

        $lists = 1;
        $perPage = 10;
        $records = $sql->paginate($perPage);
        $serial = (!empty($input['page'])) ? (($perPage * ($input['page'] - 1)) + 1) : 1;
        return view('frontend.courses.index', compact('lists', 'serial', 'records'));
    }

    public function team(Request $request)
    {
        return view('frontend.team.index');
    }

    public function contact_us(Request $request)
    {
        return view('frontend.contact_us.index');
    }

    public function courses_details(Request $request, $slug)
    {
        $getCourse = Course::where('slug', $slug)->where('status', '1')->first();
        if (blank($getCourse) || $slug == "") :
            abort(404);
        endif;
        Session::put('getCourse', ['course_id' => $getCourse->id, 'title' => $getCourse->title, 'price' => $getCourse->price]);
        return view('frontend.courses.details', compact('getCourse'));
    }

    public function course_purchase(Request $request)
    {
        $getCourse = Session::get('getCourse');
        if ($getCourse == "") {
            return redirect('courses');
        }

        if (Auth::user()) {
            $getCourse = Session::get('getCourse');
            Session::put('getCourse', [
                'course_id' => $getCourse['course_id'],
                'title' => $getCourse['title'],
                'price' => $getCourse['price'],
                'student_name' => Auth::user()->first_name,
                'student_email' => Auth::user()->email,
                'parent_email' => Auth::user()->parent_email,
            ]);
            return redirect('student/course-checkout');
        } else {
            return view('frontend.courses.course_purchase', compact('getCourse'));
        }
    }

    public function email_check(Request $request)
    {
        $response = User::where(['email' => $request->email, 'status' => '1'])->exists();
        if ($response > 0) {
            return true;
        }
        return false;
    }

    public function course_payment_validation(Request $request)
    {
        $arr = [
            'student_name' => 'required',
            'student_email' => 'required|unique:users,email',
        ];

        if ($request->parent_email != "") {
            $arr['parent_email'] = 'required';
        }

        $this->validate($request,  $arr);
        try {
            $getCourse = Session::get('getCourse');
            Session::put('getCourse', [
                'course_id' => $getCourse['course_id'],
                'title' => $getCourse['title'],
                'price' => $getCourse['price'],
                'student_name' => Auth::user() != "" ? Auth::user()->first_name : $request->student_name,
                'student_email' => Auth::user() != "" ? Auth::user()->email : $request->student_email,
                'parent_email' => Auth::user() != "" ? Auth::user()->parent_email : $request->parent_email,
            ]);
            return redirect('student/course-checkout');
        } catch (\Exception $e) {
            $request->session()->flash('message', ['status' => 0, 'text' => $e->getMessage()]);
            return redirect()->back();
        }
    }

    public function courses_checkout(Request $request)
    {
        $getCourse = Session::get('getCourse');
        if ($getCourse == "") {
            return redirect('courses');
        }
        $getAddonLists = AddonAmount::where('status', '1')->get();
        return view('frontend.courses.courses_checkout', compact('getCourse', 'getAddonLists'));
    }

    public function stripe_card_payment(Request $request)
    {
        $getCourse = Session::get('getCourse');
        $cart = Session::get('cart');
        if ($getCourse == "") {
            return redirect('courses');
        }

        $student_id = !blank(Auth::user()) ? Auth::user()->id : 0;
        if (blank(Auth::user())) {
            $arr = [
                'first_name' => $getCourse['student_name'],
                'email' => $getCourse['student_email'],
                'parent_email' => $getCourse['parent_email'],
                'is_role' => '2',
                'password' => bcrypt(123456),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $user_insert = User::create($arr);
            $student_id = $user_insert->id;
            Auth::loginUsingId($user_insert->id, TRUE);
        } else {
            $student_id = Auth::user()->id;
        }

        $price = 0;
        if ($cart != "") {
            foreach ($cart as $val) {
                $price += $val['price'];
            }
        }

        $courseInsert = CoursePurchase::create([
            'student_id' => $student_id,
            'course_id' => $getCourse['course_id'],
            'total_amount' => $getCourse['price'],
            'grand_amount' => $price > 0 ? ($price + $getCourse['price']) : $getCourse['price'],
        ]);

        if ($courseInsert) {
            if ($cart != "") {
                foreach ($cart as $val) {
                    CourseAddonPurchase::create([
                        'course_purchase_id' => $courseInsert->id,
                        'addon_id' => $val['id'],
                        'name' => $val['name'],
                        'amount' => $val['price'],
                    ]);
                }
            }
            $stripe_order_id = $courseInsert->id;
            return view('frontend.payment.stripe_from', compact('stripe_order_id'));
        }
        return redirect('courses');
    }

    public function payment_init()
    {
        //return 54545;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $input = file_get_contents('php://input');
            $request = json_decode($input);
        }

        $order_id = $request->stripe_order_id;
        $data = CoursePurchase::find($order_id);
        //$order_id = 452131;
        $grand_total = ($data->grand_amount * 100);

        // Set API key
        $stripe = new Stripe\StripeClient(env('STRIPE_SECRET'));
        $response = array(
            'status' => 0,
            'error' => array(
                'message' => 'Invalid Request!'
            )
        );

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode($response);
            exit;
        }

        if (!empty($request->createCheckoutSession)) {
            // Convert product price to cent
            $stripeAmount = round($grand_total, 2);

            // Create new Checkout Session for the order
            try {
                $checkout_session = $stripe->checkout->sessions->create([
                    'line_items' => [[
                        'price_data' => [
                            'product_data' => [
                                'name' => 'Total Amount', // product name
                                'metadata' => [
                                    'pro_id' => $order_id //product ID
                                ]
                            ],
                            'unit_amount' => $stripeAmount, // amount
                            'currency' => 'USD',
                        ],
                        'quantity' => 1
                    ]],
                    'mode' => 'payment',
                    'success_url' => url('payment/card-payment-response/' . '{CHECKOUT_SESSION_ID}/' . $order_id),
                    'cancel_url' => url('payment/failed/' . $order_id),
                ]);
            } catch (\Exception $e) {
                $api_error = $e->getMessage();
            }

            if (empty($api_error) && $checkout_session) {
                $response = array(
                    'status' => 1,
                    'transaction_id' => '',
                    'message' => 'Checkout Session created successfully!',
                    'sessionId' => $checkout_session->id
                );
            } else {
                $response = array(
                    'status' => 0,
                    'transaction_id' => 4454546,
                    'error' => array(
                        'message' => 'Checkout Session creation failed! ' . $api_error
                    )
                );
            }
        }

        // Return response
        echo json_encode($response);
    }

    public function card_payment_response(Request $request, $CHECKOUT_SESSION_ID, $id)
    {
        $session_id = $CHECKOUT_SESSION_ID; //$this->uri->segment(2);
        $order_id = $id; //$this->uri->segment(3);

        // Order Details
        if ($session_id != "") {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            // Fetch the Checkout Session to display the JSON result on the success page
            try {
                $checkout_session = $stripe->checkout->sessions->retrieve($session_id);
            } catch (\Exception $e) {
                $api_error = $e->getMessage();
            }

            if (empty($api_error) && $checkout_session) {
                // Get customer details
                $customer_details = $checkout_session->customer_details;

                // Retrieve the details of a PaymentIntent
                try {
                    $paymentIntent = $stripe->paymentIntents->retrieve($checkout_session->payment_intent);
                } catch (\Stripe\Exception\ApiErrorException $e) {
                    $api_error = $e->getMessage();
                }

                if (empty($api_error) && $paymentIntent) {
                    // Check whether the payment was successful
                    if (!empty($paymentIntent) && $paymentIntent->status == 'succeeded') {
                        $update = CoursePurchase::find($request->id);
                        $update->update(['payment_status' => '1', 'transaction_id' => $paymentIntent->id, 'stripe_response' => json_encode($paymentIntent)]);
                        return redirect('payment/success/' . $paymentIntent->id . '/' . $request->id);
                    } else {
                        return redirect('payment/failed/' . $request->id);
                    }
                } else {
                    return redirect('payment/failed/' . $request->id);
                }
            } else {
                return redirect('payment/failed/' . $request->id);
            }
        } else {
            return redirect('payment/failed/' . $request->id);
        }
    }

    public function course_cart(Request $request)
    {
        $html = '';
        $getCourse = Session::get('getCourse');
        $cart = Session::get('cart', []);
        if ($request->option == 1) {
            $getAddOns = AddonAmount::where('id', $request->val)->first();
            if (!blank($getAddOns)) {
                $cart[$request->val] = [
                    "id" => $getAddOns->id,
                    "name" => $getAddOns->name,
                    "price" => $getAddOns->amount,
                ];
                Session::put('cart', $cart);
            }
        } else {
            $cart = Session::get('cart');
            if (isset($cart[$request->val])) {
                unset($cart[$request->val]);
                Session::put('cart', $cart);
            }
        }
        if (!blank($cart)) {
            $price = $getCourse['price'];
            $html .= '<li class="list-group-item d-flex justify-content-between lh-condensed mt-3">' .
                '<h5>1. ' . $getCourse['title'] . '</h5>' .
                '<h5 class="text-muted" style="display:inline-block; text-align:right;">$' . $getCourse['price'] . '</h5>' .
                '</li>';
            $count = 2;
            foreach ($cart as $val) {
                $price += $val['price'];
                $html .= '<li class="list-group-item d-flex justify-content-between lh-condensed mt-3">' .
                    '<h5>' . $count . '. ' . $val['name'] . '</h5>' .
                    '<h5 class="text-muted" style="display:inline-block; text-align:right;">$' . $val['price'] . '</h5>' .
                    '</li>';
                $count++;
            }
            $html .= '<li class="list-group-item d-flex justify-content-between" id="cartItem">' .
                '<div style="font-size:24px;">Total</div>' .
                '<div id="totalPrice" style="font-size:24px;">' .
                '<strong>$' . number_format($price, 2) . '</strong>' .
                '</div>' .
                '</li>';
        } else {
            $html .= '<li class="list-group-item d-flex justify-content-between lh-condensed mt-3">' .
                '<h5>1. ' . $getCourse['title'] . '</h5>' .
                '<h5 class="text-muted" style="display:inline-block; text-align:right;">$' . $getCourse['price'] . '</h5>' .
                '</li>' .
                '<li class="list-group-item d-flex justify-content-between" id="cartItem">' .
                '<div style="font-size:24px;">Total</div>' .
                '<div id="totalPrice" style="font-size:24px;">' .
                '<strong>$' . number_format($getCourse['price'], 2) . '</strong>' .
                '</div>' .
                '</li>';
        }
        return $html;
    }

    public function success(Request $request, $transaction_id, $id)
    {
        $paymentData = CoursePurchase::where(['transaction_id' => $transaction_id, 'id' => $id, 'payment_status' => '1'])->with('get_user')->first();
        $getCourse = Session::get('getCourse');
        $cart = Session::get('cart');
        if (blank($paymentData) || blank($getCourse) || blank($cart)) {
            return redirect('courses');
        }
        return view('frontend.payment.success', compact('paymentData'));
    }

    public function failed(Request $request, $id)
    {
        $paymentData = CoursePurchase::where(['id' => $id])->with('get_user')->first();
        $getCourse = Session::get('getCourse');
        $cart = Session::get('cart');
        if (blank($paymentData) || blank($getCourse) || blank($cart)) {
            return redirect('courses');
        }
        return view('frontend.payment.failed', compact('paymentData'));
    }
        
    public function faqs(Request $request)
    {
        
        return view('frontend.faqs.faqs');
    }

    public function emailSend(Request $request)
    {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.example.com'; //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'user@example.com'; // sender username
            $mail->Password = '**********'; // sender password
            $mail->SMTPSecure = 'tls';  // encryption - ssl/tls
            $mail->Port = 587; // port - 587/465

            $mail->setFrom('sender@example.com', 'SenderName');
            $mail->addAddress($request->emailRecipient);
            $mail->addCC($request->emailCc);
            $mail->addBCC($request->emailBcc);

            $mail->addReplyTo('sender@example.com', 'SenderReplyName');

            if (isset($_FILES['emailAttachments'])) {
                for ($i = 0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
                    $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
                }
            }


            $mail->isHTML(true); // Set email content format to HTML

            $mail->Subject = $request->emailSubject;
            $mail->Body    = $request->emailBody;

            // $mail->AltBody = plain text version of email body;

            if (!$mail->send()) {
                return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
            } else {
                return back()->with("success", "Email has been sent.");
            }
        } catch (Exception $e) {
            return back()->with('error', 'Message could not be sent.');
        }
    }
}
