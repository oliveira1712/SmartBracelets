

  
@extends('layouts.main')

@section('links')


	<link rel="stylesheet" href="{{ asset('css/tailselect/tail.select-default.css') }}">


<style>
  .button-limpar {
    background-color: #008CBA;
    border: none;
    color: white;
    padding: 6px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 10px;
    border-radius: 5px;
    cursor: pointer;
}

.button-limpar:hover {background: #007CBA;}


</style>

@endsection




@section('content')
  

<!-- Page Content -->
<div class="container" style="margin-top: 7.2rem; ">
  <h1 align="center" style="font-size: 3em !important;">Pesquisa de eventos</h1>
  <div class="row" style="font-size:1.5em;">      
      <div class="col-md-3">

        <div class="col-md-12" style="margin-bottom: 7rem; margin-top: 3rem;">
          <div class="searchbox ctrsearchbox" >
            <input type="text" class="common_selector nomeevento" id="nomeevento" name="nomeevento" placeholder="Nome do evento...">
            <div class="search"></div>
          </div>
      </div>
        
        <div class="list-group">
          <h3 style="font-size:1.52em;">Tipo de Evento</h3>
          <div {{--style="height: 180px; overflow-y: auto; overflow-x: hidden;"--}}>                
            @foreach ($tipoeventos as $tipoevento)
              <div class="list-group-item checkbox">
                <label><input type="checkbox" class="common_selector tipoevento" name="{{$tipoevento->tipoevento}}" value="{{$tipoevento->idtpevento}}"> {{$tipoevento->tipoevento}} </label>
              </div> 
            @endforeach                                               
          </div>
        </div>

        <br>
        <br>


        <div class="list-group">
          <h3 style="font-size:1.52em;">Zona</h3>
          <div>                
            @foreach ($zonas as $zona)
              <div class="list-group-item checkbox">
                <label><input type="checkbox" class="common_selector zona" name="{{$zona->zona}}" value="{{$zona->idzona}}"> {{$zona->zona}} </label>
              </div> 
            @endforeach                                                
          </div>
        </div>

        <br><br>

        <div class="form-group">
          <h3 style="font-size:1.52em;">Data Inicio&nbsp;<i class="fa fa-calendar"></i></h3>
          
          <div class="col-lg-9 ml-n4">
          <div class="input-group">
            <input class="form-control" id="datainicio" name="datainicio" placeholder="DD/MM/AAAA" type="text" autocomplete="off" readonly="" style="font-size: 0.8em;"/>
            <button type="button" name="cleandatainicio" id="cleandatainicio" class="button-limpar "><i class="fas fa-trash"></i></button>
          </div>
        </div>
              
        </div>


        
        <div class="form-group ">
          <h3 style="font-size:1.52em;">Data Fim&nbsp;<i class="fa fa-calendar"></i></h3>
          
          <div class="col-lg-9 ml-n4">
            <div class="input-group">
              <input class="form-control" id="datafim" name="datafim" placeholder="DD/MM/AAAA" type="text" autocomplete="off" readonly="" style="font-size: 0.8em;"/>
              <button type="button" name="cleandatafim" id="cleandatafim" class="button-limpar "><i class="fas fa-trash"></i></button>
            </div>            
          </div>
        </div>

        <div class="form-group ">
          <h3 style="font-size:1.52em;">Artistas</h3>
          
          <div class="col-lg-2 ml-n4">
            <select name="" id="select1" class="select" multiple style="width: 10px;">
              @foreach ($artistas as $artista)
                <option data-description="{{ $artista->tipoartista }}" value="{{ $artista->idartista }}"  >{{ $artista->artista }}</option> 
              @endforeach
                        
            </select>         
          </div>
        </div>
        
        <input type="checkbox" class="smartbracelets" id="smartbracelets"> SmartBracelets
        
      </div> <!-- ends col-md-3 -->

      
      
      <div class="col-md-9 align-self-center">
        <br />
          <div class="row filter_data" align="center" style="justify-content: center;">

            <div class="fancy-spinner" id="loader" style="display: none;">
              <div class="ring"></div>
              <div class="ring"></div>
              <div class="dot"></div>
            </div>
            
          </div>
      </div>
  </div>
</div>



@endsection


@section('scripts')

@if (!Auth::check())
    <script>
        $(document).on('click', '.evcomprar', function(){
			window.location = "/login";

		});
    </script>
@endif

<script>
  const navhome = document.querySelector('#home');
  const naveventos = document.querySelector('#eventos');
  navhome.classList.remove('active');
  naveventos.classList.add('active');
</script>

  <script src="{{ asset('js/tailselect/tail.select-full.min.js') }}"></script>
  <script src="{{ asset('js/tailselect/tail.select-pt_BR.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
<script>
  tail.select('#select1', {
  animate: true,
    search: true,
    descriptions: true,
    hideSelected: true,
    hideDisabled: true,
    width: "25rem",
    multiShowCount: false,
    locale: "pt_BR", 
    multiContainer: true
  });

  
   
  

  $(document).ready(function(){

    var datainicio=$('input[name="datainicio"]'); //our date input has the name "datainicio"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    datainicio.datepicker({
      format: 'yyyy/mm/dd',
      container: container,
      todayHighlight: true,
      autoclose: true,
      
      
    });  

    

    var datafim=$('input[name="datafim"]'); //our date input has the name "datafim"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    datafim.datepicker({
      format: 'yyyy/mm/dd',
      container: container,
      todayHighlight: true,
      autoclose: true,
      
    }); 




    filter_data();

    function filter_data()
    {
        
      var action = 'fetch_data';
      var smartbracelets = document.getElementById("smartbracelets").checked;   
      if(smartbracelets){
        smartbracelets = 1;
      }else{
        smartbracelets = 0;
      } 
      var tipoevento = get_filter('tipoevento');
      var zona = get_filter('zona');
      var datainicio = get_datas('datainicio');
      var datafim = get_datas('datafim');
      var nomeevento = document.getElementById('nomeevento').value;
      var idartistas = get_artistas();
      console.log("idartistas " + idartistas);
      
      $.ajax(
        
        {
          url:"{{ route('Pesquisar.getPesquisa') }}",
          method:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            action:action, 
            tipoevento:tipoevento, 
            zona:zona,
            nomeevento: nomeevento,
            datainicio: datainicio,
            smartbracelets: smartbracelets,
            idartistas: idartistas,
            datafim: datafim
            },
            beforeSend: function(){
					// Show image container
					$("#loader").show();
				},
            
          success:function(data){
              $('.filter_data').html(data);
              $("#loader").hide();
          }
      });
    }

    function get_filter(class_name)
    {
      var filter = [];
      $('.'+class_name+':checked').each(function(){
          filter.push($(this).val());
      });
      console.log("filtro" + filter);
      return filter;
    }

    $('.common_selector').click(function(){
      filter_data();
    });

    $('.smartbracelets').click(function(){
      filter_data();
    });
    
    $('#nomeevento').keyup(function(){
        filter_data();       
    });
    
    

    function get_artistas(){
      var sel = document.querySelector('select[multiple]');
      var array = [];
      for(var i = 0; i < sel.length; i++){
        var opt = sel.options[i]
          if(opt.selected){
          array.push(opt.value);
          }
        }
        return array;
    }

    var sel = document.querySelector('select[multiple]');
    sel.addEventListener("change", function(){
      filter_data(); 
    });
      

    function get_datas(auxdata){       
      var data = document.getElementById(auxdata).value;
      return data;        
    }


    $('#datainicio').datepicker().on('changeDate', function (ev) {
      filter_data();
    });
    

    $('#datafim').datepicker().on('changeDate', function (ev) {
      filter_data();
    }); 


    $('#cleandatainicio').click(function(){
      $('#datainicio').val('');
      filter_data();
    });


    $('#cleandatafim').click(function(){
      $('#datafim').val('');
      filter_data();
    });
  
  })
</script>



@endsection




