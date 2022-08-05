@extends('layouts.main')
@section('content')
    <div class="container main animate-left" style="min-height: 60vh; margin-top: 10rem;"> {{-- Main Container --}}
        <h1 class="text-center mb-5" style="font-size: 2.3em !important;">Promover Eventos</h1>
        <div class="container select-eventos" style="display: flex; justify-content: center; ">
            <select name="eventos" id="eventosselect" class="custom-select sources" placeholder="Selecione um evento a promover" >
                <option value="0" selected>Selecione um evento a promover</option>
                @foreach ($eventos as $evento)
                    <option value="{{ $evento->idevento }}">{{ $evento->evento }}</option>
                @endforeach
              </select>
        </div>

        <div class="container select-promotores mt-5 " style="display: flex; justify-content: center;">
            <select name="promotores" id="promotoresselect" class="custom-select sources" placeholder="Selecione um promotor">
                <option value="0" selected>Selecione um promotor</option>
                @foreach ($promotores as $promotor)
                    <option value="{{ $promotor->idpromotor }}">{{ $promotor->promotor }}</option>
                @endforeach
              </select>
        </div>

        

        <div class="container text-descricao mt-5 animate-left" style="display: flex; justify-content: center;">
            <textarea name="" id="descricao" class="form-control" placeholder="Descriçao...." maxlength="250" cols="5" rows="3" style="width: 50%; font-size: 1.4em; z-index: -1 !important;"></textarea>
        </div>


        <div class="container btn-promoverevento mt-5 mb-5 animate-bottom" style="display: flex; justify-content: center;">
            <button class="btn-bubble-pe" style="--content: 'Promover evento!'; outline: none !important;">
                <div class="left-btn-bubble-pe"></div>
                  Promover Evento!
                <div class="right-btn-bubble-pe"></div>
              </button>
              
        </div>

        
    </div>
@endsection

@section('scripts')
    <script>
        $(document).on('click','.btn-bubble-pe',function(){
            var idevento = document.getElementById("eventosselect").value;
            var idpromotor = document.getElementById("promotoresselect").value;
            var descricao = document.getElementById("descricao").value;
            console.log("idevento = " + idevento + "  idpromotor = " + idpromotor);
            if((idevento==0 && idpromotor==0) || (idevento==0 && idpromotor!=0) || (idevento!=0 && idpromotor==0)){
                Swal.fire({
					type: 'info',
					customClass: 'swal-wide',
					title: '<h3>Campos a preencher</h3>',
					html: '<h2 >É necessario selecionar um evento e um promotor</h2>',
					timer: 3000
				});
            }else{
                $.ajax(            
                {
                    url:"{{ route('promotor.promovereventosajax') }}",
                    method:"POST",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        idevento:idevento,
                        idpromotor:idpromotor,
                        descricao:descricao
                        },
                        beforeSend: function(){
                                // Show image container
                                $("#loader").show();
                            },
                        
                    success:function(data){
                        //$('.table-body-ent-sai').html(data);
                        if(data==1){
                            Swal.fire({
                                type: 'success',
                                customClass: 'swal-wide',
                                title: '<h3>Sucesso</h3>',
                                html: '<h2 >Evento promovido com sucesso</h2>',
                                timer: 3000
                            });
                        }else{
                            Swal.fire({
                                type: 'warning',
                                customClass: 'swal-wide',
                                title: '<h3>Alerta!</h3>',
                                html: '<h2>O evento selecionado já está a ser promovido pelo promotor selecionado</h2>',
                                timer: 3000
                            });
                        }
                        $("#loader").hide();
                    }
                });
            } 
        });
    </script>
@endsection