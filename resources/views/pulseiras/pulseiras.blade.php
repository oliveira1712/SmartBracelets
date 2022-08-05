@extends('layouts.main')

@section('content')

<div class="modal fade" id="mostrarPulseirasModal" tabindex="-1" role="dialog" aria-labelledby="mostrarPulseirasModalLabel" aria-hidden="true" style="font-size: 1.3em;">
    <div class="modal-dialog modal-md " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mostrarPulseirasModalLabel" style="font-size: 1.5em;">Pulseiras</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 1.5em;">
            <span aria-hidden="true" style="font-size: 1.5em;">&times;</span>
          </button>
        </div>
        <div class="modal-body modalfontsize">

            <table class="table table-borderless pulseirashistorico">
              <div class="fancy-spinner" id="loaderhistorico" style="display: none; margin: 0 auto;">
                <div class="ring"></div>
                <div class="ring"></div>
                <div class="dot"></div>
            </div>
                
              </table>
              <div class="paginationdiv" style="float: right;">

              </div>
          </div>
          
        <div class="modal-footer">
          
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        
        </div>
      </div>
    </div>
  </div>

<div class="realcontainersearch animate-top">   
  <div class="containersearch">
          <span class="spanpulseira"></span>
            <div class="centerpulseira">
              <div class="wrappulseira">
                  <div class="boxpulseira-1 box">
                      <i class="fas fa-ticket-alt"></i>
                      <i class="fas fa-ticket-alt"></i>
                  </div>
                  <div class="boxpulseira-2 box">
                      <i class="fas fa-ticket-alt"></i>
                      <i class="fas fa-ticket-alt"></i>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <form class="pulseiracontainer animate-bottom" action="{{ route('showpulseirashistorico') }}" method="POST" style="height: 10vh; margin-top: 14rem;"> 
    @csrf
    <input type="text" name="nrseriepulseira" id="nrseriepulseira" class="inputpulseira" placeholder="Nr serie da pulseira">
    <button type="button" class="verpulseira" data-toggle="modal" data-target="#mostrarPulseirasModal"><i class="fas fa-ticket-alt"></i></button>
    <button type="button" id="enviarpulseira" class="enviarpulseira"><i class="fas fa-paper-plane"></i></button>
  </form>
  
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#a2d9ff" fill-opacity="1" d="M0,256L48,240C96,224,192,192,288,165.3C384,139,480,117,576,138.7C672,160,768,224,864,234.7C960,245,1056,203,1152,176C1248,149,1344,139,1392,133.3L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
  </svg>
  
@endsection

@section('scripts')
    <script>
      

      $('#mostrarPulseirasModal').on('show.bs.modal', function (e) {
        
        $.ajax(
          
          {
            url:"{{ route('pulseirashistoricoget') }}",
            method:"POST",
            data:{
              "_token": "{{ csrf_token() }}"//,
              //eventoid: eventoid
              },
              beforeSend: function(){
            // Show image container
            $("#loader").show();
          },
              
            success:function(data){
                $('.pulseirashistorico').html(data[0]);
                $('.paginationdiv').html(data[1]);
                console.log(data[1]);
                $("#loader").hide();
            }
        });
      });

      $(document).on('click','.selpulseira',function(){
        $('#mostrarPulseirasModal').modal('hide')
        $('#nrseriepulseira').val($(this).val());
      });
      
      $(document).on('click','#enviarpulseira',function(){
         var txtinput = document.getElementById("nrseriepulseira").value;
         
         if(txtinput == ''){
            Swal.fire({
              type: 'info',
              customClass: 'swal-wide',
              title: '<h3>Preencher Nr Serie</h3>',
              html: '<h2 >É necessario selecionar uma pulseira!</h2>',
              timer: 3000
            });
         }else{
          document.getElementById("enviarpulseira").type = "submit";
         }
      });


      $(document).on('click', '.pagination a', function(event){
          event.preventDefault(); 
          var page = $(this).attr('href').split('page=')[1];
          getPulseirasPaginacao(page);
      });

      function getPulseirasPaginacao(page)
      {
          $.ajax({
            url:"/eventos/pulseirashistorico/getPulseirasPaginacao?page="+page,
            beforeSend: function(){
              // Show image container
              $("#loader").show();
            },
            success:function(data)
            {
              $('.pulseirashistorico').html(data[0]);
              $('.paginationdiv').html(data[1]);
              $("#loader").hide();
            }
          });
      }
    </script>
@endsection