@extends('layouts.main')
<html>
 <head>
    @include('CRUD.linkscruds')

 </head>
 <body>
    @section('content')
  <div class="container" style="min-height: 60vh;">    
     <br />
     <h3 align="center" style="padding-top: 7rem;">CRUD Tabela Promotores</h3>
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
            <th width="20%">idPromotor</th>
            <th width="20%">Promotor</th>
            <th width="20%">Descricao</th>
            <th width="20%">tipopromotor</th>
            <th width="20%">Action</th>
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
            <label class="control-label col-md-4" >Promotor : </label>
            <div class="col-md-8">
             <input type="text" name="promotor" id="promotor" class="form-control" autocomplete="off" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Descricao : </label>
            <div class="col-md-8">
             <input type="text" name="descricao" id="descricao" class="form-control" autocomplete="off" />
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-4">Tipo Promotor:  </label>
            <div class="col-md-8">
              <select name="tipopromotorid" id="tipopromotorid" class="form-control">
                  @foreach ($tipopromotores as $tipopromotor)
                    <option value="{{ $tipopromotor->idtppromotor}}">{{ $tipopromotor->tipopromotor }}</option>
                  @endforeach
              </select>
            </div>
           </div>

                <br />
                <div class="form-group" align="center">
                 <input type="hidden" name="action" id="action" value="Add" />
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
  ajax: {
   url: "{{ route('admin.Promotores.index') }}",
  },
  columns: [
    {
    data: 'idpromotor',
    name: 'idpromotor'
   },
   {
    data: 'promotor',
    name: 'promotor'
   },
   {
    data: 'descricao',
    name: 'descricao'
   },
   {
    data: 'tipopromotor',
    name: 'tipopromotor'
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
  $('#promotor').val('');
  $('#descricao').val('');
  $('#tipopromotorid').val($ ('#tipopromotorid option').eq(0).val());  
  $('#form_result').html('');

  $('#formModal').modal('show');
 });

 $('#sample_form').on('submit', function(event){
  event.preventDefault();
  var action_url = '';

  if($('#action').val() == 'Add')
  {
   action_url = "{{ route('admin.Promotores.store') }}";
  }

  if($('#action').val() == 'Edit')
  {
    $('#formModal').modal('hide');
   action_url = "{{ route('admin.Promotores.update') }}";
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
     window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
        });
     }, 3000);
     $('#sample_form')[0].reset();
     $('#user_table').DataTable().ajax.reload();
    }
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
        });
     }, 4000);
    $('#form_result').html(html);
    if($('#action').val() == 'Edit'){
      $('#form_result1').html(html);
     }
   }
  });
 });






 $(document).on('click', '.edit', function(){
  var id = $(this).attr('id');
  $('#form_result').html('');
  
  $.ajax({
      
   url :"/admin/Promotores/"+id+"/edit",
   dataType:"json",
   success:function(data)
   {
       
    $('#promotor').val(data.result.promotor);
    $('#tipopromotorid').val(data.result.tipopromotorid);      
    $('#descricao').val(data.result.descricao);
    $('#hidden_id').val(id);
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
  $('#confirmModal').modal('show');
  $('.modal-title').text('Confirmação');
 });

 $('#ok_button').click(function(){
  $.ajax({
   url:"/admin/Promotores/destroy/"+user_id,
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
</script>
@endsection