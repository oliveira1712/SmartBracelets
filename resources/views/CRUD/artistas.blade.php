@extends('layouts.main')
<html>
 <head>
    @include('CRUD.linkscruds')
    
 </head>
 <body>
     @section('content')
         
     
  <div class="container" style="min-height: 60vh;">    
     <br />
     <h3 align="center" style="padding-top: 7rem;">CRUD Artistas</h3>
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
                <th >IDArtista</th>
                <th >Artista</th>
                <th >LinkArtista</th>
                <th >Tpartista</th>
                <th >Foto</th>
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
            <label class="control-label col-md-4" >Artista : </label>
            <div class="col-md-8">
             <input type="text" name="artista" id="artista" class="form-control" autocomplete="off" />
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-4">Link Artista : </label>
            <div class="col-md-8">
             <input type="text" name="linkartista" id="linkartista" class="form-control" autocomplete="off"/>
            </div>
           </div>

           <div class="form-group">
            <label class="control-label col-md-4">Tipo Artista:  </label>
            <div class="col-md-8">
              <select name="tpartistaid" id="tpartistaid" class="form-control">
                  @foreach ($tiposartistas as $tipoartista)
                    <option value="{{ $tipoartista->idtpartista}}">{{ $tipoartista->tipoartista }}</option>
                  @endforeach
              </select>
            </div>
           </div>

           

           <div class="form-group">
            <label class="control-label col-md-4">Imagem do Artista : </label>
            <div class="col-md-8">
             <input type="file" name="foto" id="foto" />
             <span id="store_image"></span>
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
   url: "{{ route('admin.Artistas.index') }}",
  },
  columns:[
    {
    data: 'idartista',
    name: 'idartista'
   },
    {
    data: 'artista',
    name: 'artista'
   },
    {
    data: 'linkartista',
    name: 'linkartista'
   },
   {
    data: 'tipoartista',
    name: 'tipoartista'
   },
   {
    data: 'foto',
    name: 'foto',
    render: function(data, type, full, meta){
     return "<img src={{ URL::to('/') }}/storage/imagens_artistas/" + data + " width='70' class='img-thumbnail fotoevento' />";
    },
    orderable: false
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
     $('#artista').val('');
     $('#linkartista').val('');
     $('#tpartistaid').val($ ('#tpartistaid option').eq(0).val());   
     $('#store_image').html("");
     $('#action').val("Add");
     $('#formModal').modal('show');
 });

 $('#sample_form').on('submit', function(event){
  event.preventDefault();
  if($('#action').val() == 'Add')
  {
   $.ajax({
    url:"{{ route('admin.Artistas.store') }}",
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
    url:"{{ route('admin.Artistas.update') }}",
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
    url:"/admin/Artistas/"+id+"/edit",
    dataType:"json",
    success:function(html){
        $('#artista').val(html.data.artista);
        $('#linkartista').val(html.data.linkartista);
        $('#tpartistaid').val(html.data.tpartistaid);      
        $('#store_image').html("<img src={{ URL::to('/') }}/storage/imagens_artistas/" + html.data.foto + " width='70' style='margin-top: 2.2rem;' class='img-thumbnail fotoevento' />");
        $('#store_image').append("<input type='hidden' name='hidden_image' value='"+html.data.foto+"' />");
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
   url:"/admin/Artistas/destroy/"+user_id,
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
</script>



@endsection

