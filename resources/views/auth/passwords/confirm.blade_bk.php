@extends('layouts.frontend.layer')
@section('title', 'Confirm | Drive Safe school')

@section('content')
	<!-- breadcrumb start -->
    <div class="breadcrumb-area" style="background-image:url('{{ asset('assets/frontend/img/other/3.png') }}')">
        <div class="container">
            <div class="breadcrumb-inner">
                <div class="section-title mb-0">
                    <h2 class="page-title">{{ __('Confirm Password') }}</h2>
                    <ul class="page-list">
                        <li><a href="index.html">Reset</a></li>
                        <li>{{ __('Confirm Password') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb end -->
	
	<div class="signin-page-area pd-top-120 pd-bottom-120">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">{{ __('Confirm Password') }}</div>

						<div class="card-body">
							{{ __('Please confirm your password before continuing.') }}

							<form method="POST" action="{{ route('password.confirm') }}">
								@csrf

								<div class="row mb-3">
									<label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

									<div class="col-md-6">
										<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

										@error('password')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
								</div>

								<div class="row mb-0">
									<div class="col-md-8 offset-md-4">
										<button type="submit" class="btn btn-primary">
											{{ __('Confirm Password') }}
										</button>

										@if (Route::has('password.request'))
											<a class="btn btn-link" href="{{ route('password.request') }}">
												{{ __('Forgot Your Password?') }}
											</a>
										@endif
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
