
@extends('layouts.main')
@section('links')
<script src="{{ asset('js/carouseljs/Jquery3.4.1.min.js') }}"></script>
@endsection
@section('content')



<div class="container" style="height: 100vh;">
  
  @if ($errors->any())
    <div class="alert alert-danger" style="margin-top: 15rem; margin-bottom: 5rem; font-size: 1.5em;">
      <a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  @if (session('error'))
    <div class="alert alert-danger" role="alert" style="margin-top: 15rem; font-size: 1.5em;">
      <a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
      {{ session('error')}}
    </div>
  @endif
  @if (session()->get('message'))
    <div class="alert alert-success" role="alert" style="margin-top: 15rem; font-size: 1.5em;">
      <a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
      <strong>SUCCESSO:</strong>&nbsp;{{ session()->get('message')}}
    </div>
  @endif
  @if (session('status'))
      <div class="alert alert-success" role="alert" style="margin-top: 15rem; font-size: 1.5em;">
          {{ session('status') }}
      </div>
  @endif

	<div class="wrapper">
		<div class="left">
			<img src="{{ asset("storage/users_avatares/$user->avatar") }}" alt="user" class="avatarimg">
			<h2 style="font-size: 2em;" >{{ $user->name }}</h2>
			 
		</div>
		<div class="right">
			<div class="info">
				<h3 style="font-size: 1.8em">Perfil</h3>
				<div class="info_data">
					 <div class="data">
						<h4 style="font-size: 1.4em">Email</h4>
						<p style="font-size: 1.3em">{{ $user->email }}</p>
					 </div>
					 
				</div>
            </div>
            
            
		  
		  <div class="projects">
				<h3 style="font-size: 1.8em">Permissoes</h3>
				<div class="projects_data">
          <div class="data">
              <h4 style="font-size: 1.4em">Tipo de utilizador</h4>
                <p style="font-size: 1.3em">{{ $tipouser[0]->Nome }}</p>
          </div>
				</div>
            </div>
            

            <form enctype="multipart/form-data" action="/perfilatualizafoto" method="POST">
                <h2 style="margin-bottom: 5px;">Trocar Foto</h2>
                <div class="file-upload-wrapper" data-text="Selecione a sua imagem!">
                    <input name="avatar" type="file" id="avatar" class="file-upload-field" required value="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                    
                </div>
                <button type="submit" id="submitfoto" disabled class="btn btn-primary" style=" height: 30px; margin-top: -80px; margin-left: 60%; cursor: not-allowed;" ><i class="fas fa-file-import"></i></button>                    
            </form>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" style="letter-spacing: 0 !important; font-weight: bold !important;" >
              Mudar Password
            </button>

		</div>
    </div>
    

    <!-- Button trigger modal -->

  
  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="font-size: 25px !important;">
    <div class="modal-dialog modal-dialog-centered" role="document" style="font-size: 25px !important;">
      <div class="modal-content" style="font-size: 25px !important;">
        <div class="modal-header" style="font-size: 25px !important;">
          <h5 class="modal-title" id="exampleModalLongTitle">Trocar Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 25px !important;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <div class="col-md-12">
          <form action="/mudarpassword" method="POST">
            @csrf

            <div class="wrap-input100 validate-input" data-validate = "Password is required">
              <input type="password" class="input100" id="current_password" required autocomplete="false" placeholder="Password Atual" name="current_password" style="margin-bottom: 5px;">
              <span class="focus-input100"></span>
              <span class="symbol-input100">
                <i class="fa fa-lock" aria-hidden="true"></i>
              </span>
            </div>
                        
            <!-- End Current Password Input -->
            <div class="wrap-input100 validate-input" data-validate = "Password is required">
              <input type="password" class="input100" id="new_password" name="new_password" required  autocomplete="false" placeholder="Nova Password" style="margin-bottom: 5px;">
              <span class="focus-input100"></span>
              <span class="symbol-input100">
                <i class="fa fa-lock" aria-hidden="true"></i>
              </span>
            </div>

            
            
            <!-- End New Password Input -->

            <div class="wrap-input100 validate-input" data-validate = "Password is required">
              <input type="password" class="input100" id="new_password_confirmation" required autocomplete="false" name="new_password_confirmation" placeholder="Confirmar Nova Password" style="margin-bottom: 5px;">
              <span class="focus-input100"></span>
              <span class="symbol-input100">
                <i class="fa fa-lock" aria-hidden="true"></i>
              </span>
            </div>
            
            <!-- End New Confirm Password Input -->
            
                      
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button class="btn btn-success" type="submit">Mudar Password</button>
        </form>
        </div>
      </div>
    </div>
  </div>

</div>


	
@endsection

@section('scripts')

<script src="{{ asset('js/bootstrap/bootstrap4.3.1.min.js') }}"  ></script>
    <script>
        
        $("form").on("change", ".file-upload-field", function(){ 
            $(this).parent(".file-upload-wrapper").attr("data-text",         $(this).val().replace(/.*(\/|\\)/, '') );
            document.getElementById("submitfoto").disabled = false;
            var element = document.getElementById('submitfoto');
            element.style.cursor = "pointer";
        });

        window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
        });
     }, 4000);
    </script>
	  
@endsection
