@extends('layouts.frontend.layer')
@section('title', 'login Security Question | Drive Safe school')
@section('content')

    <!-- signin-page-Start -->
    <div class="signin-page-area pd-top-120 pd-bottom-120">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-xl-6 col-lg-8 pt-4">
                    <!-- Message here -->
                    @if (!empty(Session::get('message')) && isset(Session::get('message')['status']) == '1')
                        <div class="control-group">
                            <div class="alert alert-success inline">
                                {{ Session::get('message')['text'] }}
                            </div>
                        </div>
                    @elseif (!empty(Session::get('message')) && isset(Session::get('message')['status']) == '0')
                        <div class="control-group">
                            <div class="alert alert-danger inline">
                                {{ Session::get('message')['text'] }}
                            </div>
                        </div>
                    @endif
                    <form method="POST" action="{{ url('student/set-security-question') }}" class="signin-inner">
                        @csrf
                        <input type="hidden" name="__tokan__" value="{{ $get_security_question->id }}">
                        <h3 class="LoginTitle">Security Question</h3>
                        @if ($errors->has('__tokan__'))
                            <strong>{{ $errors->first('__tokan__') }}</strong>
                        @endif
                        <div class="row">

                            <div class="col-12">
                                <div class="single-input-inner style-bg-border">
                                    <label for=""
                                        class="form-control">{{ $get_security_question->question }}</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="single-input-inner style-bg-border">
                                    <input type="text" name="ans" value="{{ old('ans') }}"
                                        class="@error('ans') is-invalid @enderror" placeholder="Answer" autofocus>
                                    @if ($errors->has('ans'))
                                        <strong>{{ $errors->first('ans') }}</strong>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12 mb-4">
                                <button class="btn btn-base btn-11 w-100">LOGIN</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- signin-page-end -->
    <Style>
        .invalid-feedback_login {
            width: 100%;
            margin-top: .25rem;
            font-size: 80%;
        }

        body .signin-inner {
            background: #f2f3f5;
            padding: 40px 40px 30px;
            border-radius: 7px;
            margin-top: 35px;
        }

        body .single-input-inner input {
            border-radius: 40px;
            padding: 0 18px;
            background: transparent;
            border-bottom: 1px solid #000;
            border-top: 0px;
            border-right: 0;
            border-left: 0px;
        }

        .btn:not(:disabled):not(.disabled) {
            border-radius: 40px;
        }

        h3.LoginTitle {
            border-bottom: 2px solid #000;
        }

        .form-control {
            background: transparent;
            border: transparent;
        }
    </Style>
@endsection
