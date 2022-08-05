@extends('layouts.main')
<html>
 <head>
    @include('CRUD.linkscruds')
  
 </head>
 <body>
    @section('content')
    
  <div class="container" style="min-height: 60vh;">    
     <br />
     <h3 align="center" style="padding-top: 7rem;">CRUD Tabela Cartazes</h3>
     <br />
     <div align="right">
      <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm"><i class="fas fa-plus"></i></button>
     </div>
     <br />
     <span id="form_result1"></span>
   <div class="table-responsive">
    <table id="user_table" class="table table-bordered table-striped">
     <thead>
      <tr>
        <th >IDEvento</th>
        <th >IDArtista</th>
        <th >Local</th>
        <th >DataInicio</th>
        <th >Datafim</th>
        <th >HoraInicio</th>
        <th >HoraFim</th>
        <th width="10%">Ação</th>
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
         <form method="post" id="sample_form" class="form-horizontal">
          @csrf
          <div class="form-group">
            <label class="control-label col-md-4" >Evento : </label>
            <div class="col-md-8">
                <select name="ideventoc" id="ideventoc" class="form-control">
                    @foreach ($eventos as $evento)
                      <option value="{{ $evento->idevento}}">{{ $evento->evento }}</option>
                    @endforeach
                </select>
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-4" >Artista : </label>
            <div class="col-md-8">
                <select name="idartistac" id="idartistac" class="form-control">
                    @foreach ($artistas as $artista)
                      <option value="{{ $artista->idartista}}">{{ $artista->artista }}</option>
                    @endforeach
                </select>
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-4">Local : </label>
            <div class="col-md-8">
             <input type="text" name="local" id="local" class="form-control" autocomplete="off" />
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

                <br />
                <div class="form-group" align="center">
                 <input type="hidden" name="action" id="action" value="Add" />
                 <input type="hidden" name="hidden_id" id="hidden_id" />
                 <input type="hidden" name="hidden_id1" id="hidden_id1" />
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
   url: "{{ route('admin.Cartazes.index') }}",
  },
  columns:[
    {
    data: 'evento',
    name: 'evento'
   },
    {
    data: 'artista',
    name: 'artista'
   },
    {
    data: 'local',
    name: 'local'
   },
   {
    data: 'datainicio',
    name: 'datainicio'
   },
   {
    data: 'datafim',
    name: 'datafim'
   },
   {
    data: 'horainicio',
    name: 'horainicio'
   },
   {
    data: 'horafim',
    name: 'horafim'
   },  
   {
    data: 'action',
    name: 'action',
    orderable: false
   }
  ]
 });
 
    
 $('#create_record').click(function(){
  $('.modal-title').text('Adicionar novo registo');
  $('#action_button').val('Adicionar');
  $('#action').val('Add');
  $('#local').val('');
  $('#datainicio').val('');
  $('#horainicio').val('');
  $('#datafim').val('');
  $('#horafim').val('');
  $('#ideventoc').val($ ('#ideventoc option').eq(0).val());
  $('#idartistac').val($ ('#idartistac option').eq(0).val());
  $('#form_result').html('');

  $('#formModal').modal('show');
 });

 $('#sample_form').on('submit', function(event){
  event.preventDefault();
  var action_url = '';

  if($('#action').val() == 'Add')
  {
   action_url = "{{ route('admin.Cartazes.store') }}";
  }

  if($('#action').val() == 'Edit')
  {
    $('#formModal').modal('hide');
   action_url = "{{ route('admin.Cartazes.update') }}";
  }



  $.ajax({
   url: action_url,
   method:"POST",
   data:$(this).serialize(),
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
     window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
        });
     }, 6000);
    }
    if(data.success)
    {
     html = '<div class="alert alert-success">' + data.success + '</div>';
     $('#sample_form')[0].reset();
     $('#user_table').DataTable().ajax.reload();
     window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
        });
     }, 4000);
    }
    if(data.warning)
    {
     html = '<div class="alert alert-warning" id="success-alert">' + data.warning + '</div>';
     
     window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
        });
     }, 4000);
    }
    $('#form_result').html(html);
    if($('#action').val() == 'Edit'){
      $('#form_result1').html(html);
     }
   }
  });
 });





 $(document).on('click', '.edit', function(){
  var id = $(this).attr('id');
  var id1 = $(this).attr('value');
  $('#form_result').html('');
  $.ajax({
   url :"/admin/Cartazes/"+id+"/"+id1+"/edit",
   dataType:"json",
   success:function(data)
   {
    $('#local').val(data.result.local);
    $('#datainicio').val(data.result.datainicio);
    $('#horainicio').val(data.result.horainicio);
    $('#datafim').val(data.result.datafim);
    $('#horafim').val(data.result.horafim);

    $('#ideventoc').val(data.result.ideventoc);     
    $('#idartistac').val(data.result.idartistac);     
    
    $('#hidden_id').val(id);
    $('#hidden_id1').val(id1);
    $('.modal-title').text('Editar Registo');
    $('#action_button').val('Editar');
    $('#action').val('Edit');
    $('#formModal').modal('show');
   }
  })
 });









 var user_id;

 $(document).on('click', '.delete', function(){
  user_id = $(this).attr('id');
  user_id1 = $(this).attr('value');
  var user_name = $(this).attr('value');
  $('#confirmModal').modal('show');
  $('.modal-title').text('Confirmação');
  console.log(user_name);
 });

 
 $('#ok_button').click(function(){
  $.ajax({
   url:"/admin/Cartazes/destroy/"+user_id+"/"+user_id1,
   beforeSend:function(){
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