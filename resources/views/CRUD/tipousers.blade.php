@extends('layouts.main')
<html>
 <head>
    @include('CRUD.linkscruds')

 </head>
 <body>
    @section('content')
  <div class="container" style="height: 60vh;">    
     <br />
     <h3 align="center" style="padding-top: 7rem;">CRUD Tabela TipoUsers</h3>
     <br />
     <div align="right">
      <button type="button" name="create_record" id="create_record" class="btn btn-success btn-sm"><i class="fas fa-plus"></i></button>
     </div>
     <br />
   <div class="table-responsive">
    <table id="user_table" class="table table-bordered table-striped">
     <thead>
      <tr>
            <th width="15%">idTipoUser</th>
            <th width="35%">Nome</th>
            <th width="30%">Descricao</th>
            <th width="30%">Action</th>
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
            <label class="control-label col-md-4" >Nome : </label>
            <div class="col-md-8">
             <input type="text" name="Nome" id="Nome" class="form-control" autocomplete="off" />
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4">Descricao : </label>
            <div class="col-md-8">
             <input type="text" name="Descricao" id="Descricao" class="form-control" autocomplete="off" />
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
  ajax: {
   url: "{{ route('admin.tipoUser.index') }}",
  },
  columns: [
    {
    data: 'idTipoUser',
    name: 'idTipoUser'
   },
   {
    data: 'Nome',
    name: 'Nome'
   },
   {
    data: 'Descricao',
    name: 'Descricao'
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
  $('#Nome').val('');
  $('#Descricao').val('');
  $('#form_result').html('');

  $('#formModal').modal('show');
 });

 $('#sample_form').on('submit', function(event){
  event.preventDefault();
  var action_url = '';

  if($('#action').val() == 'Add')
  {
   action_url = "{{ route('admin.tipoUser.store') }}";
  }

  if($('#action').val() == 'Edit')
  {
    $('#formModal').modal('hide');
   action_url = "{{ route('admin.tipoUser.update') }}";
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
    }
    if(data.success)
    {
     html = '<div class="alert alert-success">' + data.success + '</div>';
     $('#sample_form')[0].reset();
     $('#user_table').DataTable().ajax.reload();
    }
    $('#form_result').html(html);
   }
  });
 });






 $(document).on('click', '.edit', function(){
  var id = $(this).attr('id');
  $('#form_result').html('');
  $.ajax({
   url :"/admin/tipoUser/"+id+"/edit",
   dataType:"json",
   success:function(data)
   {
       console.log(data.result.nome);
    $('#Nome').val(data.result.Nome);
    $('#Descricao').val(data.result.Descricao);
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
   url:"/admin/tipoUser/destroy/"+user_id,
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