@extends('layouts.main')

@section('links')
  @if (count($bilhetescheckout))
      <style>
        footer{
          margin-top: 3rem;
        }
      </style>
  @endif

@endsection



@section('content')

<!-- Modal -->
<div class="modal fade" id="changeNameModal" tabindex="-1" role="dialog" aria-labelledby="changeNameModal" aria-hidden="true" style="font-size: 1.3em;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changeNameModal" style="font-size: 1.5em;">Editar Nome da Pulseira</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 1.5em;">
          <span aria-hidden="true" style="font-size: 1.5em;">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="font-size: 1.4em;">
        <div class="form__group field">
          <div class="fancy-spinner" id="loader" style="display: none;">
            <div class="ring"></div>
            <div class="ring"></div>
            <div class="dot"></div>
          </div>
          <input type="input" class="form__field" placeholder="Nome Pulseira" name="nomepulseira" id='nomepulseira' autocomplete="off" required />
          <label for="nomepulseira" class="form__label">Nome Pulseira</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="gobackcheckout"><i class="fas fa-arrow-circle-left"></i></button>
        <button type="button" class="btn btn-primary" id="guardarnome" >Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <input type="hidden" id="nrpulseira" value="">
        <input type="hidden" id="eventoidvalor" value="">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="checkoutpulseirasModal" tabindex="-1" role="dialog" aria-labelledby="checkoutpulseirasModalLabel" aria-hidden="true" style="font-size: 1.3em;">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="checkoutpulseirasModalLabel" style="font-size: 1.5em;">Pulseiras</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 1.5em;">
          <span aria-hidden="true" style="font-size: 1.5em;">&times;</span>
        </button>
      </div>
      <div class="modal-body modalfontsize">
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">NrSerie</th>
              <th scope="col">Plafond</th>
              <th scope="col">NomePulseira</th>
              <th scope="col">Edit</th>
            </tr>
          </thead>
          <tbody class="bodytable">
            <div class="fancy-spinner" id="loader" style="display: none;">
              <div class="ring"></div>
              <div class="ring"></div>
              <div class="dot"></div>
            </div>
          </tbody>
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
<div class="container animate-left"><h1 style="text-align: center; margin-top: 10rem; font-size: 3em;">CheckOut</h1></div>

  <div class="container d-flex justify-content-center align-items-center animate-top" style="min-height: 50vh;">
    <div class="row checkoutdiv" align="center" style="justify-content: center;">
      <div class="fancy-spinner" id="loadercheckoutdiv" style="display: none;">
        <div class="ring"></div>
        <div class="ring"></div>
        <div class="dot"></div>
      </div>
    </div>
    
  </div>
  
@endsection


@section('scripts')
    <script>

    $(document).on('click', '#gobackcheckout', function(){ 
      $('#changeNameModal').modal("hide");
      $('#checkoutpulseirasModal').modal("show");
    });

     var eventoid = 0;
      $(document).on('click', '.verpulseirabtn', function(){ 
        //var button = $(event.relatedTarget) // Button that triggered the modal
        var idbotao = $(this).attr("id") // Extract info from data-* attributes
        console.log(idbotao);

        // ajax request

        eventoid = idbotao;
        
        $.ajax(
          
          {
            url:"{{ route('getPulseiras') }}",
            method:"POST",
            data:{
              "_token": "{{ csrf_token() }}",
              eventoid: eventoid
              },
              beforeSend: function(){
            // Show image container
            $("#loader").show();
          },
              
            success:function(data){
                $('.bodytable').html(data[0]);
                $('.paginationdiv').html(data[1]);
                $("#loader").hide();
            }
        });

        
      });


      $(document).on('click', '.pagination a', function(event){
          event.preventDefault(); 
          var page = $(this).attr('href').split('page=')[1];
          getPulseirasPaginacaoCheckOut(page);
      });

      function getPulseirasPaginacaoCheckOut(page)
      {
          $.ajax({
            url:"/eventos/getpulseiras/getPulseirasPaginacaoCheckOut?page="+page,
            data:{
              eventoid: eventoid
            },
            beforeSend: function(){
              // Show image container
              $("#loader").show();
            },
            success:function(data)
            {
              $('.bodytable').html(data[0]);
              $('.paginationdiv').html(data[1]);
              $("#loader").hide();
            }
          });
      }
      


      $('#changeNameModal').on('show.bs.modal', function (event) {
        $('#checkoutpulseirasModal').modal('hide');
        var button = $(event.relatedTarget) // Button that triggered the modal
        var idbotao = button.data('id') // Extract info from data-* attributes
        var ideventovalor = button.data('value');
        
        // ajax request
        var action = 'fetch_data';
        var pulseiraid = idbotao;
      
        $.ajax(
          
          {
            url:"{{ route('getNomePulseira') }}",
            method:"POST",
            data:{
              "_token": "{{ csrf_token() }}",
              action:action,
              pulseiraid: pulseiraid
              },
              beforeSend: function(){
            // Show image container
            $("#loader").show();
          },
              
            success:function(data){
              console.log(data);
                $('#nomepulseira').val(data);
                document.getElementById("nrpulseira").value = pulseiraid;
                document.getElementById("eventoidvalor").value = ideventovalor;
                $("#loader").hide();
            }
        });

       
      });

      $("#guardarnome").click(function(){
        var nomepulseira = document.getElementById("nomepulseira").value;
        var pulseiraid = document.getElementById("nrpulseira").value;
        var eventoid = document.getElementById("eventoidvalor").value;
        console.log("eventoidvalor " + eventoid);
        $.ajax(
          
          {
            url:"{{ route('changeNomePulseira') }}",
            method:"POST",
            data:{
              "_token": "{{ csrf_token() }}",
              pulseiraid: pulseiraid,
              nomepulseira:nomepulseira
              },
              beforeSend: function(){
            // Show image container
            $("#loader").show();
          },
              
            success:function(data){
                $('#changeNameModal').modal("hide");
                $('#checkoutpulseirasModal').modal("show");
                $("#loader").hide();
            }
        });


      
        $.ajax(
          
          {
            url:"{{ route('getPulseiras') }}",
            method:"POST",
            data:{
              "_token": "{{ csrf_token() }}",
              eventoid: eventoid
              },
              beforeSend: function(){
            // Show image container
            $("#loader").show();
          },
              
            success:function(data){
              console.log(data);
              $('.bodytable').html(data[0]);
              $('.paginationdiv').html(data[1]);
                $("#loader").hide();
            }
        });


      }); 




      
    </script>
    <script>




      mostra_bilhetes_checkout();
    function mostra_bilhetes_checkout()
    {
        
      var action = 'fetch_data';
      
      $.ajax(
        
        {
          url:"{{ route('getBilhetesCheckOut') }}",
          method:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            action:action
            },
            beforeSend: function(){
					// Show image container
					$("#loadercheckoutdiv").show();
				},
            
          success:function(data){
              $('.checkoutdiv').html(data);
              $("#loadercheckoutdiv").hide();
          }
      });
    }
    </script>



@endsection