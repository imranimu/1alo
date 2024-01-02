@extends('layouts.frontend.layer')
@section('title', 'Courses Purchase | Drive Safe')
@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-area" style="background-image:url('{{ asset('assets/frontend/img/other/3.png') }}')">
        <div class="container">
            <div class="breadcrumb-inner">
                <div class="section-title mb-0">
                    <h2 class="page-title">Purchasing Summary</h2>
                    <ul class="page-list">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>Purchasing Summary</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!-- course area start -->
    <div class="course-area pd-top-120 pd-bottom-120">
        <div class="container">
            <div class="row">
                <div class="col-md-8 order-2 order-md-1">
                    <div class="control-group">
                        @if (!empty(Session::get('message')) && Session::get('message')['status'] == '0')
                            <div class="control-group">
                                <div class="alert alert-danger inline">
                                    {{ Session::get('message')['text'] }}
                                </div>
                            </div>
                        @endif
                    </div>
                    <h4 class="mb-3">Let's get started! Please tell us your name and email: </h4>
                    <hr class="separator-aqua">

                    <form class="needs-validation" action="{{ route('student.course-payment-validation') }}"
                        id="checkoutForm" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" id="student_name" class="form-control mb-3"
                                    placeholder="STUDENT FIRST NAME" value="{{ old('student_name') }}" name="student_name"
                                    required="">
                                @if ($errors->has('student_name'))
                                    <strong>{{ $errors->first('student_name') }}</strong>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="student_email" class="form-control mb-3"
                                    placeholder="STUDENT EMAIL" name="student_email" value="{{ old('student_email') }}"
                                    onchange="studentEmailCheck(this.value)" required="">
                                <span id="error"></span>
                                @if ($errors->has('student_email'))
                                    <strong>{{ $errors->first('student_email') }}</strong>
                                @endif
                            </div>
							<div class="col-md-12">
                                <input type="password" id="student_password" class="form-control mb-3"
                                    placeholder="STUDENT PASSWORD" name="student_password"
                                    value="{{ old('student_password') }}" minlength="6" maxlength="10" autocomplete="off" required="">
                                <span id="error"></span>
                                @if ($errors->has('student_password'))
                                    <strong>{{ $errors->first('student_password') }}</strong>
                                @endif
                            </div>
							
							<div class="col-md-12">
                                <select name="question[q1]" id="question[q1]" class="form-control mb-3">
                                    <option value="">Select Question-1</option>
                                    @if (!blank($getSecurityQuestion))
                                        @foreach ($getSecurityQuestion as $val)
                                            @if ($val->is_type == 1)
                                                <option value="{{ $val->id }}"
                                                    {{ $val->id == old('question.q1') ? 'selected' : '' }}>
                                                    {{ $val->question }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('question.q1'))
                                    <strong>The question-1 field is required.</strong>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <input type="text" id="question[a1]" name="question[a1]" class="form-control mb-3"
                                    placeholder="Answer" value="{{ old('question.a1') }}">
                                <span id="error"></span>
                                @if ($errors->has('question.a1'))
                                    <strong>The Answer-1 field is required.</strong>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <select name="question[q2]" id="question[q2]" class="form-control mb-3">
                                    <option value="">Select Question-2</option>
                                    @if (!blank($getSecurityQuestion))
                                        @foreach ($getSecurityQuestion as $val)
                                            @if ($val->is_type == 2)
                                                <option value="{{ $val->id }}"
                                                    {{ $val->id == old('question.q2') ? 'selected' : '' }}>
													{{ $val->question }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('question.q2'))
                                    <strong>The question-2 field is required.</strong>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <input type="text" id="question[a2]" name="question[a2]" class="form-control mb-3"
                                    placeholder="Answer" value="{{ old('question.a2') }}">
                                <span id="error"></span>
                                @if ($errors->has('question.a2'))
                                    <strong>The Answer-2 field is required.</strong>
                                @endif
                            </div>
							
							
                            @php
                                $parent_onclick = old('parent_email') != '' ? 'parentEmail(0)' : 'parentEmail(1)';
                                $parent_text = old('parent_email') != '' ? 'Nevermind, I\'m a Student' : 'Wait, I\'m a parent!';
                                $parent_display = old('parent_email') != '' ? 'block' : 'none';
                            @endphp
                            <div class="col-md-12 text-right mb-3">
                                <a href="javascript:void(0)" id="im_parent"
                                    onclick="{{ $parent_onclick }}">{{ $parent_text }}</a>
                            </div>
                            <div class="col-md-12" id="parent_box" style="display: {{ $parent_display }}">
                                <p>As a parent, you are purchasing a course for your student, whose email you provided in
                                    the field above. If you'd like, you may enter your own email below to track your
                                    student's progress.</p>
                                <input type="email" id="parent_email" class="form-control mb-3"
                                    placeholder="PARENT (YOUR) EMAIL" name="parent_email"
                                    value="{{ old('parent_email') }}">
                                @if ($errors->has('parent_email'))
                                    <strong>{{ $errors->first('parent_email') }}</strong>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <button type="submit" id="submit" class="btn btn-primary w-100">
                                    STEP 1 <i class='fa fa-arrow-right' aria-hidden='true'></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 mb-4 order-1 order-md-2 ">
                    <h4 style="margin-bottom: 16px;">Summary</h4>
                    <hr class="separator-aqua">

                    <span style="color: #404652; font-size:30px; position: relative;">
                        Shopping Cart <span class="badge badge-secondary badge-pill"
                            style="font-size: 12px; position: absolute; top: 12px; margin-left: 8px; padding-right: 8px;">1</span>
                    </span>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-condensed mt-3">

                            <h5>1. {{ $getCourse['title'] }}</h5>

                            <h5 class="text-muted" style="display:inline-block; text-align:right;">
                                ${{ $getCourse['price'] }} </h5>

                        </li>
                        <li class="list-group-item d-flex justify-content-between" id="cartItem">
                            <div style="font-size:24px;">Total</div>
                            <div id="totalPrice" style="font-size:24px;">
                                <strong>${{ $getCourse['price'] }} </strong>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- course area end -->
    <script>
        function parentEmail(value) {
            if (value == 1) {
                $('#im_parent').html('Nevermind, I\'m a Student');
                $('#im_parent').attr('onclick', 'parentEmail(0)');
                $('#parent_box').show();
            } else {
                $('#parent_email').val('');
                $('#im_parent').html('Wait, I\'m a parent!');
                $('#im_parent').attr('onclick', 'parentEmail(1)');
                $('#parent_box').hide();
            }
        }

        function studentEmailCheck(email) {
            if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
                $('#error').html("You have entered an invalid email address!");
                return false;
            } else {
                $('#error').html("");
                $.ajax({
                    type: "POST",
                    url: '{{ url('student/email-check') }}',
                    data: {
                        "email": email,
                        '_token': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response == true) {
                            $('#error').html("<b>The student email has already been taken.</b>");
                        } else {
                            $('#error').html("");
                        }
                    }
                });
            }
        }
    </script>
@endsection
