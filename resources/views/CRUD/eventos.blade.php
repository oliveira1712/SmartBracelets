@extends('layouts.main')

  
    @include('CRUD.linkscruds')
    
    
     @section('content')
         
     
  <div class="container" style="width: 100%; min-height: 60vh;">    
     <br />
     <h3 align="center" style="padding-top: 7rem;">CRUD Eventos</h3>
     <br />
     <div align="right">
      <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm"><i class="fas fa-plus"></i></button>
     </div>
     <br />
     <span id="form_result1"></span>
   <div class="table-responsive">
    <table class="table table-bordered table-striped" id="user_table">
           <thead>
            <tr>
                <th >ID</th>
                <th >Evento</th>
                <th >Local</th>
                <th >Latitude</th>
                <th >Longitude</th>
                <th >DataInicio</th>
                <th >HoraInicio</th>
                <th >DataFim</th>
                <th >HoraFim</th>
                <th >Lotação</th>
                <th>Preco</th>
                <th>FotoEvento</th>
                <th>FotoCartaz</th>
                <th>Zona</th>
                <th >TipoEvento</th>
                <th> Classificacao </th>
                <th> EstadoEvento </th>
                <th >TipoLugar</th>
                <th >LinkCompra</th>
                <th >Ação</th>
            </tr>
           </thead>
       </table>
   </div>
   <br />
   <br />
  </div>
 </body>
</html>

<div id="formModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Adicionar novo registo</h4>
        </div>
        <div class="modal-body">
         <span id="form_result"></span>
         <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
          @csrf

          <div class="form-group">
            <label class="control-label col-md-4" >Evento : </label>
            <div class="col-md-8">
             <input type="text" name="evento" id="evento" class="form-control" autocomplete="off" />
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-4">Local : </label>
            <div class="col-md-8">
             <input type="text" name="local" id="local" class="form-control" autocomplete="off"/>
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-4">Latitude : </label>
            <div class="col-md-8">
             <input type="text" name="latitude" id="latitude" class="form-control" autocomplete="off"/>
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-4">Longitude : </label>
            <div class="col-md-8">
             <input type="text" name="longitude" id="longitude" class="form-control" autocomplete="off"/>
            </div>
           </div>
           

           <div class="form-group ">
            <label class="control-label col-md-4">Data Inicio : </label>
                
                </label>
                <div class="col-sm-8">
                <div class="input-group">
                <div class="input-group-addon">
                <i class="fa fa-calendar">
                </i>
                </div>
                <input class="form-control" id="datainicio" name="datainicio" placeholder="DD/MM/AAAA" type="text" autocomplete="off" readonly=""/>
                </div>
                </div>
           </div>

           <div class="form-group ">
            <label class="control-label col-md-4">Hora Inicio : </label>
                
                </label>
                <div class="col-sm-8">
                <div class="input-group">
                <div class="input-group-addon">
                    <i class="fas fa-clock"></i>
                </i>
                </div>
                <input type="text" class="form-control horainicio" id="horainicio" name="horainicio" data-placement="bottom" data-align="top" data-autoclose="true" readonly="">

                </div>
                </div>
           </div>



           <div class="form-group ">
            <label class="control-label col-md-4">Data Fim : </label>
                
                </label>
                <div class="col-sm-8">
                <div class="input-group">
                <div class="input-group-addon">
                <i class="fa fa-calendar">
                </i>
                </div>
                <input class="form-control" id="datafim" name="datafim" placeholder="DD/MM/AAAA" type="text" autocomplete="off" readonly=""/>
                </div>
                </div>
           </div>


           <div class="form-group ">
            <label class="control-label col-md-4">Hora Fim : </label>
                
                </label>
                <div class="col-sm-8">
                <div class="input-group">
                <div class="input-group-addon">
                    <i class="fas fa-clock"></i>
                </i>
                </div>
                <input type="text" class="form-control horafim" id="horafim" name="horafim" data-placement="bottom" data-align="top" data-autoclose="true" readonly="">

                </div>
                </div>
           </div>
           

           <div class="form-group">
            <label class="control-label col-md-4">Lotação : </label>
            <div class="col-md-8">
             <input type="text" name="lotacao" id="lotacao" class="form-control" autocomplete="off"/>
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-4">Preço : </label>
            <div class="col-md-8">
             <input type="text" name="preco" id="preco" class="form-control" autocomplete="off"/>
            </div>
           </div>
         

           <div class="form-group">
            <label class="control-label col-md-4">Tipo de evento : </label>
            <div class="col-md-8">
              <select name="tipoeventoid" id="tipoeventoid" class="form-control">
                  @foreach ($tipoeventos as $tipoevento)
                    <option value="{{ $tipoevento->idtpevento}}">{{ $tipoevento->tipoevento }}</option>
                  @endforeach
              </select>
            </div>
           </div>


           <div class="form-group">
            <label class="control-label col-md-4">Classificacao : </label>
            <div class="col-md-8">
              <select name="classificacaoid" id="classificacaoid" class="form-control">
                  @foreach ($classificacoes as $classificacao)
                    <option value="{{ $classificacao->idclassificacao}}">{{ $classificacao->descricao }}</option>
                  @endforeach
              </select>
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-4">Estado Evento : </label>
            <div class="col-md-8">
              <select name="estadoeventoid" id="estadoeventoid" class="form-control">
                  @foreach ($estadoseventos as $estadoevento)
                    <option value="{{ $estadoevento->idestadoevento}}">{{ $estadoevento->estadoevento }}</option>
                  @endforeach
              </select>
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-4">Zona : </label>
            <div class="col-md-8">
              <select name="zonaid" id="zonaid" class="form-control">
                  @foreach ($zonas as $zona)
                    <option value="{{ $zona->idzona}}">{{ $zona->zona }}</option>
                  @endforeach
              </select>
            </div>
           </div>          
                      

           <div class="form-group">
            <label class="control-label col-md-4">Foto do evento : </label>
            <div class="col-md-8">
             <input type="file" name="foto" id="foto" />
             <span id="store_image"></span>
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-4">Cartaz : </label>
            <div class="col-md-8">
             <input type="file" name="fotocartaz" id="fotocartaz" />
             <span id="store_imagecartaz"></span>
            </div>
           </div>


           

           <div class="form-group">
            <label class="control-label col-md-4">Tipo de evento lugar : </label>
            <div class="col-md-8">
              <select name="tpeventolugarid" id="tpeventolugarid" class="form-control">
                  @foreach ($tipoeventoslugar as $tipoeventolugar)
                    <option value="{{ $tipoeventolugar->idtpeventolugar}}">{{ $tipoeventolugar->tipolugarevento }}</option>
                  @endforeach
              </select>
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-4">LinkCompra : </label>
            <div class="col-md-8">
             <input type="text" name="linkcompra" id="linkcompra" class="form-control" autocomplete="off"/>
            </div>
           </div>

           <br />
           <div class="form-group" align="center">
            <input type="hidden" name="action" id="action" />
            <input type="hidden" name="hidden_id" id="hidden_id" />
            <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
           </div>

         </form>
        </div>
     </div>
    </div>
</div>




<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmação</h2>
            </div>
            <div class="modal-body">
                <h4 align="center" style="margin:0;">Tem a certeza que pretende eliminar este registo?</h4>
            </div>
            <div class="modal-footer">
             <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">Eliminar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(function(){

 $('#user_table').DataTable({
  processing: true,
  serverSide: true,
  "language": {
        "sEmptyTable":   "Não foi encontrado nenhum registo",
        "sLoadingRecords": "A carregar...",
        "sProcessing":   "A processar...",
        "sLengthMenu":   "Mostrar _MENU_ registos",
        "sZeroRecords":  "Não foram encontrados resultados",
        "sInfo":         "Mostrando de _START_ até _END_ de _TOTAL_ registos",
        "sInfoEmpty":    "Mostrando de 0 até 0 de 0 registos",
        "sInfoFiltered": "(filtrado de _MAX_ registos no total)",
        "sInfoPostFix":  "",
        "sSearch":       "Procurar:",
        "sUrl":          "",
        "oPaginate": {
            "sFirst":    "Primeiro",
            "sPrevious": "Anterior",
            "sNext":     "Seguinte",
            "sLast":     "Último"
        },
        "oAria": {
            "sSortAscending":  ": Ordenar colunas de forma ascendente",
            "sSortDescending": ": Ordenar colunas de forma descendente"
        }
    },
  ajax:{
   url: "{{ route('admin.Eventos.index') }}",
  },
  columns:[
    {
    data: 'idevento',
    name: 'idevento'
   },
    {
    data: 'evento',
    name: 'evento'
   },
   {
    data: 'local',
    name: 'local'
   },
   {
    data: 'latitude',
    name: 'latitude'
   },
   {
    data: 'longitude',
    name: 'longitude'
   },
   {
    data: 'datainicio',
    name: 'datainicio',
   },
   {
    data: 'horainicio',
    name: 'horainicio'
   },
   {
    data: 'datafim',
    name: 'datafim'
   },
   {
    data: 'horafim',
    name: 'horafim'
   },
   {
    data: 'lotacao',
    name: 'lotacao'
   },
   {
    data: 'preco',
    name: 'preco'
   },
   
   {
    data: 'foto',
    name: 'foto',
    render: function(data, type, full, meta){
     return "<img src={{ URL::to('/') }}/storage/imagens_eventos/" + data + " width='70' class='img-thumbnail fotoevento' />";
    },
    orderable: false
   },
   {
    data: 'fotocartaz',
    name: 'fotocartaz',
    render: function(data, type, full, meta){
        if(data!=null)
            return "<img src={{ URL::to('/') }}/storage/imagens_eventos/" + data + " width='100' class='img-thumbnail fotoevento' />";
        else
            return '';
    },
    orderable: false
   },
   {
    data: 'zona',
    name: 'zona'
   },
   {
    data: 'tipoevento',
    name: 'tipoevento'
   },
   {
    data: 'classificacao',
    name: 'classificacao'
   },
   {
    data: 'estadoevento',
    name: 'estadoevento'
   },
   {
    data: 'tipolugarevento',
    name: 'tipolugarevento'
   },
   
   {
    data: 'linkcompra',
    name: 'linkcompra'
   },
   {
    data: 'action',
    name: 'action',
    orderable: false
   }
  ]
  
 });


 $('#create_record').click(function(){
  $('.modal-title').text("Adicionar novo registo");
     $('#action_button').val("Adicionar");
     $('#evento').val('');
     $('#local').val('');
     $('#latitude').val('');
     $('#longitude').val('');
     $('#datainicio').val('');
     $('#horainicio').val('');
     $('#datafim').val('');
     $('#horafim').val('');
     $('#preco').val('');
     $('#estadoeventoid').val($ ('#estadoeventoid option').eq(0).val());
     $('#lotacao').val('');
     $('#tpeventolugarid').val('');
     $('#linkcompra').val('');
     $('#tipoeventoid').val($ ('#tipoeventoid option').eq(0).val());
     $('#classificacaoid').val($ ('#classificacaoid option').eq(0).val());
     $('#tpeventolugarid').val($ ('#tpeventolugarid option').eq(0).val());
     $('#zonaid').val($ ('#zonaid option').eq(0).val());
     $('#store_image').html("");
     $('#store_imagecartaz').html("");
     $('#action').val("Add");
     $('#formModal').modal('show');
 });

 $('#sample_form').on('submit', function(event){
  event.preventDefault();
  if($('#action').val() == 'Add')
  {
   $.ajax({
    url:"{{ route('admin.Eventos.store') }}",
    method:"POST",
    data: new FormData(this),
    contentType: false,
    cache:false,
    processData: false,
    dataType:"json",
    success:function(data)
    {          
     var html = '';
     if(data.errors)
     {
      html = '<div class="alert alert-danger">';
      for(var count = 0; count < data.errors.length; count++)
      {
       html += '<p>' + data.errors[count] + '</p>';
      }
      html += '</div>';
     }
     if(data.success)
     {
      html = '<div class="alert alert-success">' + data.success + '</div>';
      $('#sample_form')[0].reset();
      $('#user_table').DataTable().ajax.reload();
     }
     window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
        });
     }, 4000);
     $('#form_result').html(html);
    }
   })
  }


  if($('#action').val() == "Edit")
  {
    $('#formModal').modal('hide');
   $.ajax({
    url:"{{ route('admin.Eventos.update') }}",
    method:"POST",
    data:new FormData(this),
    contentType: false,
    cache: false,
    processData: false,
    dataType:"json",
    success:function(data)
    {
     var html = '';
     if(data.errors)
     {
      html = '<div class="alert alert-danger">';
      for(var count = 0; count < data.errors.length; count++)
      {
       html += '<p>' + data.errors[count] + '</p>';
      }
      html += '</div>';
     }
     if(data.success)
     {
      html = '<div class="alert alert-success">' + data.success + '</div>';
      $('#sample_form')[0].reset();
      $('#store_image').html('');
      $('#user_table').DataTable().ajax.reload();
     }
     window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
        });
     }, 4000);
     $('#form_result').html(html);
     $('#form_result').html('');
     if($('#action').val() == 'Edit'){
      $('#form_result1').html(html);
     }
    }
   });
  }
 });

    $(document).on('click', '.edit', function(){       
    var id = $(this).attr('id');
    $('#form_result').html('');
    $.ajax({
    url:"/admin/Eventos/"+id+"/edit",
    dataType:"json",
    success:function(html){
        console.log(html);
        $('#evento').val(html.data.evento);
        $('#local').val(html.data.local);
        $('#latitude').val(html.data.latitude);
        $('#longitude').val(html.data.longitude);
        $('#datainicio').val(html.data.datainicio);
        $('#horainicio').val(html.data.horainicio);
        $('#datafim').val(html.data.datafim);
        $('#horafim').val(html.data.horafim);
        $('#preco').val(html.data.preco);
        $('#lotacao').val(html.data.lotacao);
        
        $('#estadoeventoid').val(html.data.estadoeventoid);
        $('#linkcompra').val(html.data.linkcompra);
        $('#tipoeventoid').val(html.data.tpeventoid);
        $('#classificacaoid').val(html.data.classificacaoid);
        $('#tpeventolugarid').val(html.data.tpeventolugarid);
        $('#zonaid').val(html.data.zonaid);
        
        $('#store_image').html("<img src={{ URL::to('/') }}/storage/imagens_eventos/" + html.data.foto + " width='70' style='margin-top: 2.2rem;' class='img-thumbnail fotoevento' />");
        $('#store_image').append("<input type='hidden' name='hidden_image' value='"+html.data.foto+"' />");
        if(html.data.fotocartaz!=null){
            $('#store_imagecartaz').html("<img src={{ URL::to('/') }}/storage/imagens_eventos/" + html.data.fotocartaz + " width='100' style='margin-top: 2.2rem;' class='img-thumbnail fotoevento' />");
            $('#store_imagecartaz').append("<input type='hidden' name='hidden_imagecartaz' value='"+html.data.fotocartaz+"' />");
        }
        else{
            $('#store_imagecartaz').html("");
            $('#store_imagecartaz').append("");
        }
        $('#hidden_id').val(id);
        $('.modal-title').text("Editar registo");
        $('#action_button').val("Editar");
        $('#action').val("Edit");
        $('#formModal').modal('show');
    }
    })
    });

 
 var user_id;

 $(document).on('click', '.delete', function(){
  user_id = $(this).attr('id');
  $('#confirmModal').modal('show');
 });

 $('#ok_button').click(function(){
  $.ajax({
   url:"/admin/Eventos/destroy/"+user_id,
   beforeSend:function(){
    $('.modal-title').text("Confirmação");
    $('#ok_button').text('Eliminar');
   },
   success:function(data)
   {
    setTimeout(function(){
     $('#confirmModal').modal('hide');
     $('#user_table').DataTable().ajax.reload();
    }, 1);
   }
  })
 });


});



	$(document).ready(function(){
		var date_input=$('input[name="datainicio"]'); //our date input has the name "datainicio"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'yyyy/mm/dd',
			container: container,
			todayHighlight: true,
			autoclose: true,
		})

        var date_input=$('input[name="datafim"]'); //our date input has the name "datafim"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
            format: 'yyyy/mm/dd',
			container: container,
			todayHighlight: true,
			autoclose: true,
		})
	})



    $('.horainicio').clockpicker();
    $('.horafim').clockpicker();
</script>

@endsection

