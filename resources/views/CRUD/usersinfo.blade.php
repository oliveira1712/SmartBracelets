@extends('layouts.main')
@section('content')
    <div class="container" style="margin-top: 8rem; min-height: 60vh; font-size: 1.6em;">
        <h1 class="text-center my-5">Informações de utilizadores</h1>

        <div class="table-responsive">
            
              
            @include('CRUD.tableusersinfo')
            
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on('click', '.pagination a', function(event){
          event.preventDefault(); 
          var page = $(this).attr('href').split('page=')[1];
          getUsersInfoPaginacao(page);
      });

      function getUsersInfoPaginacao(page)
      {
          $.ajax({
            url:"/admin/UsersInfoPaginacao?page="+page,
            
            success:function(data)
            {
              $('.table-responsive').html(data);
             
            }
          });
      }
    </script>
@endsection