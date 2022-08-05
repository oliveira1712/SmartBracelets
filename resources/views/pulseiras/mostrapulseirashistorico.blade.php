@extends('layouts.main')
@section('content')
    <div class="container cabecalhocontainer text-center ">
        <div class="row">
            <div class="col-md-3 col-6 mt-2">
                <h2>Nome</h2>
                <h3 class="margininfopulseira">{{ $pulseira[0]->nomepulseira }}</h3>
            </div>
            <div class="col-md-3 col-6 mt-2">
                <h2>Plafond</h2>   
                <h3 class="margininfopulseira">{{ $pulseira[0]->plafond }}€</h3>            
            </div>
            <div class="col-md-3 col-6 mt-2">
                <h2>NR Serie</h2>
                <h3 class="margininfopulseira">{{ $pulseira[0]->nrseriepulseira }}</h3>
            </div>

            <div class="col-md-3 col-6 mt-2">
                <h2>Estado</h2>
                @if ($pulseira[0]->estadopulseiraid == 2)
                    <h3 style="color: red;" class="margininfopulseira">{{ $pulseira[0]->estadopulseira }}</h3>
                @else 
                    <h3 style="color: green;" class="margininfopulseira">{{ $pulseira[0]->estadopulseira }}</h3>
                @endif
            </div>
        </div>

    </div>
    <div class="container d-flex justify-content-center " style="margin-top: 2%; margin-bottom: 2%;">
        <select name="eventosuser" id="eventosuser" data-menu style="min-width: 300px">   
            <option id="0">Selecione um evento</option>                
            @foreach ($eventosuser as $eventouser)                  
                <option id="{{ $eventouser->eventoid }}" >{{ $eventouser->evento }}</option>                  
            @endforeach
        </select> 
        
        
        
    </div>


        <!-- Modal -->
<div class="modal fade" id="modalHistoricoEntradasSaidas" tabindex="-1" role="dialog" aria-labelledby="modalHistoricoEntradasSaidaslabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalHistoricoEntradasSaidastitle" style="font-size: 1.5em;">Historico Entradas/Saidas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 1.5em;">
            <span aria-hidden="true" style="font-size: 1.5em;">&times;</span>
          </button>
        </div>
        <div class="modal-body" style=" font-size: 1.5em;"> 
            <div class="container" style="display: flex; justify-content: space-evenly;">
                <label for="" style="margin-right: -9rem;">Entrada</label>
                <input type="checkbox" class="checkboxentsai" id="entradacheckbox" checked>
                <label for="" style="margin-right: -9rem;">Saida</label>
                <input type="checkbox" class="checkboxentsai" id="saidacheckbox" checked>
            </div>   
            
            <div class="table-responsive-sm">     
                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Estado</th>
                        <th scope="col">Evento</th>
                        <th scope="col">Hora</th>
                    </tr>
                    </thead>
                    <tbody class="table-body-ent-sai">
                        <div class="fancy-spinner" id="loaderhistoricoentsai" style="display: none; margin: 0 auto;">
                            <div class="ring"></div>
                            <div class="ring"></div>
                            <div class="dot"></div>
                        </div>
                    </tbody>
                </table>
                <div class="paginationdiventsai" style="float: right;">

                </div>
            </div>  
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

    <div class="container d-flex justify-content-center btnhistea" style="margin-top: 5%; margin-bottom: 2%;">
        <a aria-label='Entrada/Saida' class='h-button centered link-e-s' data-text='Historico' href='#' data-toggle="modal" data-target="#modalHistoricoEntradasSaidas">
            <span>E</span>
            <span>n</span>
            <span>t</span>
            <span>r</span>
            <span>a</span>
            <span>d</span>
            <span>a</span>
            <span>s</span>
            <span>/</span>
            <span>S</span>
            <span>a</span>
            <span>i</span>
            <span>d</span>
            <span>a</span>
            <span>s</span>
        </a>                   
    </div>
    


    <div class="container" style="font-size: 1.5em; min-height: 60vh; margin-top: 12rem;">
        <div class="table-produtos">
            <div class="header-produtos">Histórico de produtos</div>
            
            <table cellspacing="0" class="real-table-produtos">
                
               
                <div class="fancy-spinner" id="loaderhistorico" style="display: none; margin: 0 auto;">
                    <div class="ring"></div>
                    <div class="ring"></div>
                    <div class="dot"></div>
                </div>

               
            </table>
          </div>
          <div class="paginationdiv" style="float: right;">
          </div>
    </div>
    
    <input type="hidden" id="nrseriepulseira" value="{{ $nrseriepulseira }}"> 
@endsection

@section('scripts')

    <script>
       atualizahistorico();       
        
       function atualizahistorico(){
        var nrseriepulseira = document.getElementById("nrseriepulseira").value;
        var eventoid = $('#eventosuser').find(":selected").attr('id');
        console.log("eventoid " + eventoid);
            $.ajax(            
                {
                url:"{{ route('atualizahistoricopulseiras') }}",
                method:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    nrseriepulseira:nrseriepulseira,
                    eventoid:eventoid,
                    },
                    beforeSend: function(){
                            // Show image container
                            $("#loaderhistorico").show();
                        },
                    
                success:function(data){
                    $('.real-table-produtos').html(data[0]);
                    $('.paginationdiv').html(data[1]);
                    $("#loaderhistorico").hide();
                }
            });
       }


       $(document).on('click', '.paginationdiv .pagination a', function(event){
          event.preventDefault(); 
          var page = $(this).attr('href').split('page=')[1];
          getHistoricoProdutosPaginacao(page);
      });

      function getHistoricoProdutosPaginacao(page)
      {
        var nrseriepulseira = document.getElementById("nrseriepulseira").value;
        var eventoid = $('#eventosuser').find(":selected").attr('id');
          $.ajax({
            url:"/eventos/atualizahistoricopulseiras/getHistoricoPaginacao?page="+page,
            data:{
                nrseriepulseira:nrseriepulseira,
                eventoid:eventoid
            },
            beforeSend: function(){
              // Show image container
              $("#loaderhistorico").show();
            },
            success:function(data)
            {
              $('.real-table-produtos').html(data[0]);
              $('.paginationdiv').html(data[1]);
              $("#loaderhistorico").hide();
            }
          });
      }


       function showHistoricoEntradasSaidas(){
        var nrseriepulseira = document.getElementById("nrseriepulseira").value;
        var eventoid = $('#eventosuser').find(":selected").attr('id');
        var entradacheckbox = document.getElementById("entradacheckbox").checked;
        var saidacheckbox = document.getElementById("saidacheckbox").checked;
        if(entradacheckbox){
            entradacheckbox = 1;
        }else{
            entradacheckbox = 0;
        }
        if(saidacheckbox){
            saidacheckbox = 1;
        }else{
            saidacheckbox = 0;
        }
        
        console.log("eventoid " + eventoid);
            $.ajax(            
                {
                url:"{{ route('historicoEntradaSaida') }}",
                method:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    nrseriepulseira:nrseriepulseira,
                    eventoid:eventoid,
                    entradacheckbox:entradacheckbox,
                    saidacheckbox:saidacheckbox
                    },
                    beforeSend: function(){
                            // Show image container
                            $("#loaderhistoricoentsai").show();
                        },
                    
                success:function(data){
                    $('.table-body-ent-sai').html(data[0]);
                    $('.paginationdiventsai').html(data[1]);
                    $("#loaderhistoricoentsai").hide();
                }
            });
       }


       $(document).on('click', '.paginationdiventsai .pagination a', function(event){
           event.preventDefault(); 
           var page = $(this).attr('href').split('page=')[1]; 
           getHistoricoEntSaiPulseiraPaginacao(page); 
        
      });

      function getHistoricoEntSaiPulseiraPaginacao(page){
        var nrseriepulseira = document.getElementById("nrseriepulseira").value;
        var eventoid = $('#eventosuser').find(":selected").attr('id');
        var entradacheckbox = document.getElementById("entradacheckbox").checked;
        var saidacheckbox = document.getElementById("saidacheckbox").checked;
        if(entradacheckbox){
            entradacheckbox = 1;
        }else{
            entradacheckbox = 0;
        }
        if(saidacheckbox){
            saidacheckbox = 1;
        }else{
            saidacheckbox = 0;
        }
        
        console.log("eventoid " + eventoid);
            $.ajax(            
                {
                url:"/eventos/historicoentradasaidapaginacao?page="+page,
                data:{
                    "_token": "{{ csrf_token() }}",
                    nrseriepulseira:nrseriepulseira,
                    eventoid:eventoid,
                    entradacheckbox:entradacheckbox,
                    saidacheckbox:saidacheckbox
                    },
                    beforeSend: function(){
                            // Show image container
                            $("#loaderhistoricoentsai").show();
                        },
                    
                success:function(data){
                    $('.table-body-ent-sai').html(data[0]);
                    $('.paginationdiventsai').html(data[1]);
                    $("#loaderhistoricoentsai").hide();
                }
            });
      }

       $('#modalHistoricoEntradasSaidas').on('show.bs.modal', function (e) {
            showHistoricoEntradasSaidas();
        });

        $(document).on('change', '#entradacheckbox', function() {
            var entradacheckbox = document.getElementById("entradacheckbox").checked;
            var saidacheckbox = document.getElementById("saidacheckbox").checked;
            if(!entradacheckbox && !saidacheckbox){
                alert("Pelo menos uma checkbox deve estar preenchida");
                $("#entradacheckbox").prop("checked", true);
            }
            
            showHistoricoEntradasSaidas()
        });

        $(document).on('change', '#saidacheckbox', function() {
            var entradacheckbox = document.getElementById("entradacheckbox").checked;
            var saidacheckbox = document.getElementById("saidacheckbox").checked;
            if(!entradacheckbox && !saidacheckbox){
                alert("Pelo menos uma checkbox deve estar preenchida");
                $("#saidacheckbox").prop("checked", true);
            }
            
            showHistoricoEntradasSaidas()
        });

        $(document).on("click", ".select-menu > ul > li", function(e) {
            atualizahistorico(); 
        });

    </script>
@endsection