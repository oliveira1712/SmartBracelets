@extends('layouts.main')

@section('links')
	<!--===============================================================================================-->
	
    
	<link href="{{ asset('css/login/login.css') }}" rel="stylesheet">
	<!--===============================================================================================-->

	
@endsection

@section('content')
	




	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100" style="height: 500px;">
				<div class="login100-pic" >
					<img src="{{ asset("storage/imgsExtra/imglogin.png") }}" alt="IMG" style="bottom:86px;">
				</div>

				<form class="login100-form validate-form" method="POST" action="{{ route('login') }}" >

					@csrf
					<span class="login100-form-title" style="margin-bottom: 2rem;">
						Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
					
						<input id="email" type="email" class="input100 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
						
						@error('email')
							<span class="invalid-feedback" role="alert" style="font-size: 1.4em; padding-left: 2%;">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input id="password" type="password" class="input100 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

						@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="margin-left: 3%;">

					<label class="form-check-label" for="remember" style="font-size: 1.3em;">
						{{ __('Lembrar-me') }}
					</label>
					
					<div class="container-login100-form-btn">						
						<button type="submit" class="login100-form-btn">
							{{ __('Login') }}
						</button>
					</div>
					
					

					@if (Route::has('password.request'))
						<div class="text-center p-t-12">
							<span class="txt1">
								Esqueceu-se da
							</span>
							<a class="txt2 a2" href="{{ route('password.request') }}">
								Password?
							</a>
						</div>
                    @endif

					
				</form>
			</>
		</div>
	</div>
	
@endsection



