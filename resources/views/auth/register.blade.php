@extends('layouts.main')

@section('links')
	<!--===============================================================================================-->
	
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
	<link href="{{ asset('css/login/login.css') }}" rel="stylesheet">
	<!--===============================================================================================-->

	
@endsection

@section('content')
	




	
	<div class="limiter">
		<div class="container-login100" >
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt >
					<img src="{{ asset("storage/imgsExtra/imglogin.png") }}" alt="IMG" style="bottom:106px;">
				</div>

				<form class="login100-form validate-form" method="POST" action="{{ route('register') }}" >

					@csrf
					<span class="login100-form-title">
						Registo
                    </span>
                    
                    <!--Nome-->
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
					
						<input id="name" type="text" maxlength="10" class="input100 @error('name') is-invalid @enderror" name="name" placeholder="Nome" value="{{ old('name') }}" required autocomplete="name" style="margin-top: 2rem !important;">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					
						<span class="focus-input100"></span>
						<span class="symbol-input100">
                            
                            <i class="fas fa-user-circle" aria-hidden="true"></i>
						</span>
                    </div>
                    
                    <!--Email-->
                    <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
					
						<input id="email" type="email" class="input100 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">

						@error('email')
							<span class="invalid-feedback" role="alert" style="font-size: 1.2em; padding-left: 2%;">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

                    <!--Password-->
					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input id="password" type="password" minlength="8" class="input100 @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">

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
                    
                    <!--Confirmar Password-->

                    <div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input id="password-confirm"  type="password" minlength="8" class="input100" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                    </div>

                    

					
					<div class="container-login100-form-btn">						
						<button type="submit" class="login100-form-btn">
							{{ __('Registar-se') }}
						</button>
					</div>
					
					

					@if (Route::has('password.request'))
						<div class="text-center p-t-12">
							<span class="txt1">
								Já tem conta? Faça
							</span>
							<a class="txt2 a2" href="{{ route('login') }}">
								login
							</a>
						</div>
                    @endif

					
				</form>
			</div>
		</div>
	</div>
	
@endsection