@extends('layouts.main')

@section('links') 

  <style>

      .clock{

        zoom: 0.7;

        -moz-transform: scale(0.7);

      }



      .imgartista{

        width: 276px !important;

        height: 364px;

      }



      .flip-clock-wrapper ul.flip li a div div.inn

      {

        /* Para mudar a cor do flipclock */

      }







      @media only screen and (max-width: 600px) {

        .imgartista{

          width: 100% !important;

          height: 324px;

        }



        .clock{

          zoom: 0.5;

          -moz-transform: scale(0.5);

        }

      }



      #map{

        height: 800px;

        width: 100%;

      }



      

    </style>





  <link rel="stylesheet" href="{{ asset('css/carouselcss/owl.carousel.min.css') }}">

  <link rel="stylesheet" href="{{ asset('css/carouselcss/owl.theme.default.min.css') }}">

  <script src="{{ asset('js/carouseljs/owl.carousel.min.js') }}"></script>

  <script src="{{ asset('js/carouseljs/owlcarousel.js') }}"></script>

  <script type="text/javascript" src="{{ asset('js/geopoint/geopoint.js') }}"></script>

  <link rel="stylesheet" href="{{ asset('css/flipclock/flipclock.css') }}">

	<script src="{{ asset('js/flipclock/flipclock.js') }}"></script>	      

        

@endsection

@section('content')

  



    <?php 

    

        if($detalhesevento[0]->fotocartaz != null){

          $foto = $detalhesevento[0]->fotocartaz;

        }

        else{

          $foto = $detalhesevento[0]->foto;

        }



    ?>





    

      <!-- Resolver o padding que n deixa que o xs seja 6 com a media query-->



    <div class="container" style="margin-top: 7.2rem;">

      <div class="row mb-2 titulo">

        <div class="col-md-12 text-center" style="font-size: 1.2em;">

          <h3 class="fancytext">{{ $detalhesevento[0]->evento }} - {{ $detalhesevento[0]->tipoevento }}</h3>

        </div>

      </div>

      <div class="row ">

        <div class="col-md-12" align="center">

          <?php 

    

              if($detalhesevento[0]->fotocartaz != null){

                $foto = $detalhesevento[0]->fotocartaz;?>

                <img src="{{ asset("storage/imagens_eventos/$foto") }}" class="imgeventocartaz" alt="post-1" style="box-shadow: 0 15px 20px rgba(0, 0, 0, 0.2);">

              <?php }

              else{

                $foto = $detalhesevento[0]->foto;?>

                <img src="{{ asset("storage/imagens_eventos/$foto") }}" class="imgevento" alt="post-1" style="box-shadow: 0 15px 20px rgba(0, 0, 0, 0.2);">

              <?php } ?>



          



          

        </div>

        

      </div>

      



      

    

      <div class="row ml-12 mt-4 mx-auto " align="center">



        <div class="col-6 col-sm-4 col-md-4 col-lg-3 mx-auto">

          <div class="card text-white bg-dark mb-3 mycard " style="background: #2E383C !important;">

            <div class="card-header text-center">Data Inicio <i class="far fa-calendar-alt"></i></div>

            <div class="card-body">

              <p class="card-text text-center">

                @php

                    $datainicio=date_create($detalhesevento[0]->datainicio);

                    echo date_format($datainicio,"d/m/Y");

                @endphp   

                

              </p>

            </div>

          </div>

        </div>

        <div class="col-6 col-sm-4 col-md-4 col-lg-3 mx-auto">

          <div class="card text-white bg-dark mb-3 mycard" style="background: #2E383C !important;">

            <div class="card-header text-center">Data Fim <i class="far fa-calendar-alt"></i></div>

            <div class="card-body">

              <p class="card-text text-center">

                @php

                    $datafim=date_create($detalhesevento[0]->datafim);

                    echo date_format($datafim,"d/m/Y");

                @endphp 

                

                </p>

            </div>

          </div>

        </div>







          <div class="col-6 col-sm-4 col-md-4 col-lg-3 mx-auto">

            <div class="card text-white bg-dark mb-3 mycard" style="background: #2E383C !important;">

              <div class="card-header text-center">Hora Inicio <i class="far fa-clock"></i></div>

              <div class="card-body">

                <p class="card-text text-center">{{ $detalhesevento[0]->horainicio }}</p>

              </div>

            </div>

          </div>

          <div class="col-6 col-sm-4 col-md-4 col-lg-3 mx-auto">

            <div class="card text-white bg-dark mb-3 mycard" style="background: #2E383C !important;">

              <div class="card-header text-center">Hora Fim <i class="far fa-clock"></i></div>

              <div class="card-body">

                <p class="card-text text-center">{{ $detalhesevento[0]->horafim }}</p>

              </div>

            </div>

          </div>        

        



        <div class="col-6 col-sm-4 col-md-4 col-lg-3 mx-auto">

          <div class="card text-white bg-dark mb-3 mycard" style="background: #2E383C !important;">

            <div class="card-header text-center">Duração <i class="fas fa-clock"></i></div>

              <?php

                  // Create two new DateTime-objects...

                  

                  //Hora do evento "normal"   

                  $horainicio = $detalhesevento[0]->horainicio;

                  $horafim = $detalhesevento[0]->horafim;



                  //hora do evento convertido em timestamp

                  $horainicioaux = strtotime($detalhesevento[0]->horainicio);

                  $horafimaux = strtotime($detalhesevento[0]->horafim);





                  //hora convertido em timestamp para se for meia noite

                  $meianoite = strtotime('00:00:00');                



                  if($horainicioaux==$meianoite){

                    $horainicio='23:59:00';

                  }

                  if($horafimaux==$meianoite){

                    $horafim='23:59:00';

                  }



                  $datainicio = $detalhesevento[0]->datainicio.'T'.$horainicio;

                  $datafim = $detalhesevento[0]->datafim.'T'.$horafim;



                  $data1 = new DateTime($datainicio);

                  $data2 = new DateTime($datafim);



                  // The diff-methods returns a new DateInterval-object...

                  $diff = $data2->diff($data1);                



                  $meses = $diff->m;

                  $dias = $diff->d;

                  $horas = $diff->h;

                  $minutos = $diff->i;



                  if((strtotime($detalhesevento[0]->horainicio)==$meianoite) || (strtotime($detalhesevento[0]->horafim)==$meianoite) ){

                    $minutos = $diff->i+1;

                  }



                  if((strtotime($detalhesevento[0]->horainicio)==$meianoite) && (strtotime($detalhesevento[0]->horafim)==$meianoite) ){

                    $minutos = $diff->i;

                  }

                  $duracao=0;

                  if(($meses)==0 && ($dias)>0 && ($horas)>0 && ($minutos)>0){

                    $duracao = $dias.'D '.$horas.'H '.$minutos.'Min';

                  }



                  if(($meses)==0 && ($dias)==0 && ($horas)>0 && ($minutos)>0){

                    $duracao = $horas.'H '.$minutos.'Min';

                  }



                  if(($meses)==0 && ($dias)>0 && ($horas)==0 && ($minutos)>0){

                    $duracao = $dias.'D '.$minutos.'Min';

                  }



                  if(($meses)==0 && ($dias)>0 && ($horas)>0 && ($minutos)==0){

                    $duracao = $dias.'D '.$horas.'H ';

                  }



                  if(($meses)==0 && ($dias)>0 && ($horas)==0 && ($minutos)==0){

                    $duracao = $dias.'D ';

                  }



                  if(($meses)==0 && ($dias)==0 && ($horas)>0 && ($minutos)==0){

                    $duracao = $horas.'H ';

                  }



                  if(($meses)==0 && ($dias)==0 && ($horas)==0 && ($minutos)>0){

                    $duracao = $minutos.'Min';

                  }

                  

                  if(($meses)>0 && ($dias)>0){

                    $duracao = $meses.'M '.$dias.'D';

                  }



                  if(($meses)>0 && ($dias)==0){

                    $duracao = $meses.'M ';

                  }

                

              ?>

            <div class="card-body">

              <p class="card-text text-center"><?php echo $duracao; ?></p>

            </div>

          </div>

        </div>



        <div class="col-6 col-sm-4 col-md-4 col-lg-3 mx-auto">

          <div class="card text-white bg-dark mb-3 mycard" style="background: #2E383C !important;">

            <div class="card-header text-center">Classificação</div>

            <div class="card-body">

              <p class="card-text text-center">{{ $detalhesevento[0]->classificacao }}</p>

            </div>

          </div>

        </div>





        <div class="col-6 col-sm-4 col-md-4 col-lg-3 mx-auto">

          <div class="card text-white bg-dark mb-3 mycard" style="background: #2E383C !important;">

            <div class="card-header text-center">Zona <i class="fas fa-globe"></i></div>

            <div class="card-body">

              <p class="card-text text-center">{{ $detalhesevento[0]->zona }}</p>

            </div>

          </div>

        </div>



        <div class="col-6 col-sm-4 col-md-4 col-lg-3 mx-auto px-n5" >

          <div class="card text-white bg-dark mb-3 mycard" style="background: #2E383C !important;">

            <div class="card-header text-center">Lotação <i class="fas fa-user"></i></div>

            <div class="card-body">

              <p class="card-text text-center">{{ $detalhesevento[0]->lotacao }}</p>

            </div>

          </div>

        </div> 



        



        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mx-auto ">

          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">

            Local

          </button>

        </div> 



      

        @php
          $datetime = new DateTime();
          $timezone = new DateTimeZone('Europe/Lisbon');
          $datetime->setTimezone($timezone);

          $horaatual =  $datetime->format('H:i:s');

          if(strtotime($detalhesevento[0]->horafim) == strtotime("00:00:00")){
            $horafimevento = "23:59:00";
          }else{
            $horafimevento = $detalhesevento[0]->horafim;
          }

        @endphp

          @if ($detalhesevento[0]->estadoeventoid == 2)
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-5 mx-auto " >

            <h1 >O evento está cancelado!</h1>

          </div>

          @else 
          @if ( strtotime(date("Y/m/d")) > strtotime($detalhesevento[0]->datafim) ) 

          <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-5 mx-auto " >

            <h1 >O evento ja acabou!</h1>

          </div>

        @endif



        @if ( strtotime(date("Y/m/d")) == strtotime($detalhesevento[0]->datainicio) && strtotime($horaatual) < strtotime($detalhesevento[0]->horainicio) ) 

          <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-5 mx-auto " >

              <h1 >O evento começa hoje às {{ $detalhesevento[0]->horainicio }}!</h1>

          </div>

        @endif 

        @if ( strtotime(date("Y/m/d")) >= strtotime($detalhesevento[0]->datainicio) && strtotime($horaatual) >= strtotime($detalhesevento[0]->horainicio) && strtotime($horaatual) <= strtotime($detalhesevento[0]->horafim) && strtotime(date("Y/m/d")) <= strtotime($detalhesevento[0]->datafim) ) 

          <div class="col-12 col-sm-12 col-md-12 col-lg-12 mt-5 mx-auto " >

              <h1 >O evento está a decorrer!</h1>

          </div>

        @endif
          @endif

        

        

        <div class="clock" class="clockstyles"  style="display: flex; justify-content: center; margin:2em; font-size: 2em !important; font-weight: bold; "></div>

       

       

        

        <input type="hidden" id="datainiciocalc" value="{{$detalhesevento[0]->datainicio}}">



        

      </div>

    </div>



     <!-- Modal -->

  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" >

      <div class="modal-content">

        <div class="modal-header" style="font-size: 2em;">

          <h5 class="modal-title" id="exampleModalCenterTitle">Localização</h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 1.2em;">

            <span aria-hidden="true" >&times;</span>

          </button>

        </div>

        <div class="modal-body">

            <div id="map"></div>

            <input type="hidden" name="latitude" id="latitude" value="{{$detalhesevento[0]->latitude}}">

            <input type="hidden" name="longitude" id="longitude" value="{{$detalhesevento[0]->longitude}}">

            <input type="hidden" name="localevento" id="localevento" value="{{$detalhesevento[0]->local}}">

                     

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        </div>

      </div>

    </div>

  </div>



    <!-- Modal -->

<div class="modal fade" id="modalHorariosArtistas" tabindex="-1" role="dialog" aria-labelledby="modalHorariosArtistaslabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="modalHorariosArtistastitle" style="font-size: 1.5em;">Horarios Artista</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 1.5em;">

          <span aria-hidden="true" style="font-size: 1.5em;">&times;</span>

        </button>

      </div>

      <div class="modal-body historicoartistasclass" style=" font-size: 1.5em;">

          

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>

    </div>

  </div>

</div>          

              

    <div class="container">

      

      <div class="row mb-2 titulo">

      <div class="col-md-12 text-center">

      @if (count($cartazes)!=0)   

        @if (count($cartazes)>3)

        <h1 style="font-size: 1.4em; margin-bottom: 4rem;" class="">Artistas</h1>  

        @else

        <h1 style="font-size: 1.4em; margin-bottom: 2.5rem;" class="">Artistas</h1>  

        @endif                               

                                           

      @else

        <h1 style="font-size: 1.2em; margin-bottom: 2.5rem; visibility: hidden;" class="">Sem Artistas</h1> 

      @endif

          </div>

        </div>

      </div>

    



    @if (count($cartazes)>=1 && count($cartazes)<4)

    <div class="container d-flex justify-content-center h-100 ">

      <div class="row justify-content-center align-self-center">

        @foreach ($cartazes as $cartaz)

        <?php 

            $nrartista = $cartaz->idartistac;

            $fotoartista = $artista[$nrartista-1]->foto;

        ?>

            @if (count($cartazes)==1)

              <div class="col-lg-12 col-8 mb-5 text-center">

                <div class="card" style="box-shadow: 0 15px 20px rgba(0, 0, 0, 0.2);">

                  <img class="card-img-top imgartista" src="{{ asset("storage/imagens_artistas/$fotoartista") }}" style="max-height: 384px;" alt="Card image cap">

                  <div class="card-body my-auto" >

                    <h2 class="mb-3">{{$artista[$nrartista-1]->artista}}</h2>

                    <button onclick="window.open('{{$artista[$nrartista-1]->linkartista}}','_blank')" id="infoartista" class="fill cpointer" style="font-size: 12px !important; margin-top: -5px !important; font-weight: 600;">Sobre o Artista</button>

                    <button data-toggle="modal" data-target="#modalHorariosArtistas" data-nrartista="{{ $nrartista }}" id="infoartista" class="fill cpointer" style="font-size: 12px !important; margin-top: -5px !important; font-weight: 600;">Horario</button>

                  </div>                          

                </div>  

              </div>

            

            @endif



            @if (count($cartazes)==2)

              <div class="col-lg-6 col-8 mb-5 text-center">

                <div class="card" style="box-shadow: 0 15px 20px rgba(0, 0, 0, 0.2);">

                  <img class="card-img-top imgartista" src="{{ asset("storage/imagens_artistas/$fotoartista") }}" style="max-height: 384px;" alt="Card image cap">

                  <div class="card-body my-auto" >

                    <h2 class="mb-3">{{$artista[$nrartista-1]->artista}}</h2>

                    <button onclick="window.open('{{$artista[$nrartista-1]->linkartista}}','_blank')" id="infoartista" class="fill cpointer" style="font-size: 12px !important; margin-top: -5px !important; font-weight: 600;">Sobre o Artista</button>

                    <button data-toggle="modal" data-target="#modalHorariosArtistas" data-nrartista="{{ $nrartista }}" id="infoartista" class="fill cpointer" style="font-size: 12px !important; margin-top: -5px !important; font-weight: 600;">Horario</button>

                  </div>                          

                </div>  

              </div>

            

            @endif



            @if (count($cartazes)==3)

              <div class="col-lg-4 col-8 mb-5 text-center">

                <div class="card" style="box-shadow: 0 15px 20px rgba(0, 0, 0, 0.2);">

                  <img class="card-img-top imgartista" src="{{ asset("storage/imagens_artistas/$fotoartista") }}" style="max-height: 384px;" alt="Card image cap">

                  <div class="card-body my-auto" >

                    <h2 class="mb-3">{{$artista[$nrartista-1]->artista}}</h2>

                    <button onclick="window.open('{{$artista[$nrartista-1]->linkartista}}','_blank')" id="infoartista" class="fill cpointer" style="font-size: 12px !important; margin-top: -5px !important; font-weight: 600;">Sobre o Artista</button>

                    <button data-toggle="modal" data-target="#modalHorariosArtistas" data-nrartista="{{ $nrartista }}" id="infoartista" class="fill cpointer" style="font-size: 12px !important; margin-top: -5px !important; font-weight: 600;">Horario</button>

                  </div>                          

                </div>  

              </div>

            

            @endif

            

              

        @endforeach   

      </div>

    </div>                         

    @endif







    @if (count($cartazes)>=4)

    <section style="margin-top: -10rem;">   

      <div class="blog " align="center" >

          <div class="container">

              <div class="owl-carousel owl-theme blog-post">

        <?php $i = 0; ?>        

        @foreach ($cartazes as $cartaz)

                

                <?php $i++; ?>

                <?php if($i>4){ $i=1; }?>

                <?php 

                  $nrartista = $cartaz->idartistac;

                  $fotoartista = $artista[$nrartista-1]->foto;

                ?>

                <?php if($i==1){ ?>

                    <div class="blog-content" data-aos="fade-right" data-aos-delay="200">

                        <img src="{{ asset("storage/imagens_artistas/$fotoartista") }}" style="max-height: 384px;" alt="post-1">

                        <div class="card-body my-auto" >

                          <h2 style="color: #515151" class="mb-3">{{$artista[$nrartista-1]->artista}}</h2>

                          <button onclick="window.open('{{$artista[$nrartista-1]->linkartista}}','_blank')" id="infoartista" class="fill cpointer" style="font-size: 12px !important; margin-top: -5px !important; font-weight: 600;">Sobre o Artista</button>

                          <button data-toggle="modal" data-target="#modalHorariosArtistas" data-nrartista="{{ $nrartista }}" id="infoartista" class="fill cpointer" style="font-size: 12px !important; margin-top: -5px !important; font-weight: 600;">Horario</button>

                        </div>

                    </div>

                <?php } ?>

                <?php if($i==2){ ?>

                    <div class="blog-content" data-aos="fade-in" data-aos-delay="200">

                        <img src="{{ asset("storage/imagens_artistas/$fotoartista") }}" style="max-height: 384px;" alt="post-1">

                        <div class="card-body my-auto" >

                          <h2 style="color: #515151" class="mb-3">{{$artista[$nrartista-1]->artista}}</h2>

                          <button onclick="window.open('{{$artista[$nrartista-1]->linkartista}}','_blank')" id="infoartista" class="fill cpointer" style="font-size: 12px !important; margin-top: -5px !important; font-weight: 600;">Sobre o Artista</button>

                          <button data-toggle="modal" data-target="#modalHorariosArtistas" data-nrartista="{{ $nrartista }}" id="infoartista" class="fill cpointer" style="font-size: 12px !important; margin-top: -5px !important; font-weight: 600;">Horario</button>

                        </div>

                    </div>

                <?php } ?>

                <?php if($i==3){?>

                    <div class="blog-content" data-aos="fade-left" data-aos-delay="200">

                        <img src="{{ asset("storage/imagens_artistas/$fotoartista") }}" style="max-height: 384px;" alt="post-1">

                        <div class="card-body my-auto" >

                          <h2 style="color: #515151" class="mb-3">{{$artista[$nrartista-1]->artista}}</h2>

                          <button onclick="window.open('{{$artista[$nrartista-1]->linkartista}}','_blank')" id="infoartista" class="fill cpointer" style="font-size: 12px !important; margin-top: -5px !important; font-weight: 600;">Sobre o Artista</button>

                          <button data-toggle="modal" data-target="#modalHorariosArtistas" data-nrartista="{{ $nrartista }}" id="infoartista" class="fill cpointer" style="font-size: 12px !important; margin-top: -5px !important; font-weight: 600;">Horario</button>

                        </div>

                    </div>

                <?php } ?>

                <?php if($i==4){?>

                    <div class="blog-content" data-aos="fade-right" data-aos-delay="200">

                        <img src="{{ asset("storage/imagens_artistas/$fotoartista") }}" style="max-height: 384px;" alt="post-1">

                        <div class="card-body my-auto" >

                          <h2 style="color: #515151" class="mb-3">{{$artista[$nrartista-1]->artista}}</h2>

                          <button onclick="window.open('{{$artista[$nrartista-1]->linkartista}}','_blank')" id="infoartista" class="fill cpointer" style="font-size: 12px !important; margin-top: -5px !important; font-weight: 600;">Sobre o Artista</button>

                          <button data-toggle="modal" data-target="#modalHorariosArtistas" data-nrartista="{{ $nrartista }}" id="infoartista" class="fill cpointer" style="font-size: 12px !important; margin-top: -5px !important; font-weight: 600;">Horario</button>

                        </div>

                    </div>

                <?php } ?>

                

        @endforeach

            </div>



            <div class="owl-navigation" >                       

                <span class="owl-nav-prev"><i class="fas fa-long-arrow-alt-left"></i></span>

                <span class="owl-nav-next"><i class="fas fa-long-arrow-alt-right"></i></span>

            </div>

          </div>

      </div>

      

      

      

    </section>                           

    @endif

    

  
    
    
    @if ($detalhesevento[0]->estadoeventoid==1 && !(strtotime(date('Y-m-d')) > strtotime($detalhesevento[0]->datafim)) && !(strtotime(date('Y-m-d')) == strtotime($detalhesevento[0]->datafim) && strtotime($horaatual) > strtotime($horafimevento)) && !(strtotime(date('Y-m-d')) ==  strtotime($detalhesevento[0]->datainicio) && strtotime($detalhesevento[0]->datainicio) == strtotime($detalhesevento[0]->datafim) && strtotime($horaatual) >= strtotime($detalhesevento[0]->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
        @if ($detalhesevento[0]->tpeventolugarid==2)
        <div class="container  d-flex justify-content-center">

          <div class="row">
  
            <div class="col-lg-12">
  
              <div class="flipbutton" style="margin-bottom: 5rem;">
  
                <a class="detcomprar" tplugarevento="{{ $detalhesevento[0]->tpeventolugarid }}" onclick="comprar_bilhete({{$detalhesevento[0]->idevento}}); conta_nrbilhetes();" >
  
                  <div class="front">Comprar</div>
  
                  <div class="back">Bilhete</div>
  
                </a>
  
              </div>
  
            </div>
  
          </div>
  
        </div>
        @else
        <div class="container  d-flex justify-content-center">

          <div class="row">
  
            <div class="col-lg-12">
  
              <div class="flipbutton" style="margin-bottom: 5rem;">
  
                <a class="detcomprar" tplugarevento="{{ $detalhesevento[0]->tpeventolugarid }}"  onclick='location.href = {!! json_encode($detalhesevento[0]->linkcompra) !!};'>
  
                  <div class="front">Comprar</div>
  
                  <div class="back">Bilhete</div>
  
                </a>
  
              </div>
  
            </div>
  
          </div>
  
        </div>
        @endif
    @endif
    @if (($detalhesevento[0]->estadoeventoid==2) || (strtotime(date('Y-m-d')) > strtotime($detalhesevento[0]->datafim)) || (strtotime(date('Y-m-d')) == strtotime($detalhesevento[0]->datafim) && strtotime($horaatual) > strtotime($horafimevento)) || (strtotime(date('Y-m-d')) ==  strtotime($detalhesevento[0]->datainicio) && strtotime($detalhesevento[0]->datainicio) == strtotime($detalhesevento[0]->datafim) && strtotime($horaatual) >= strtotime($detalhesevento[0]->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)))
        @if ($detalhesevento[0]->tpeventolugarid==2)
        <div class="container  d-flex justify-content-center">

          <div class="row">
  
            <div class="col-lg-12">
  
              <div class="flipbutton" style="margin-bottom: 5rem;">
  
                <a class="detcomprar" style="cursor: not-allowed; pointer-events: none; " tplugarevento="{{ $detalhesevento[0]->tpeventolugarid }}" onclick="comprar_bilhete({{$detalhesevento[0]->idevento}}); conta_nrbilhetes();" >
  
                  <div class="front">Comprar</div>
  
                  <div class="back">Bilhete</div>
  
                </a>
  
              </div>
  
            </div>
  
          </div>
  
        </div>
        @else
        <div class="container  d-flex justify-content-center">

          <div class="row">
  
            <div class="col-lg-12">
  
              <div class="flipbutton" style="margin-bottom: 5rem;">
  
                <a class="detcomprar" style="cursor: not-allowed; pointer-events: none; " tplugarevento="{{ $detalhesevento[0]->tpeventolugarid }}"  onclick='location.href = {!! json_encode($detalhesevento[0]->linkcompra) !!};'>
  
                  <div class="front">Comprar</div>
  
                  <div class="back">Bilhete</div>
  
                </a>
  
              </div>
  
            </div>
  
          </div>
  
        </div>
        @endif
    @endif





    <input type="hidden" name="idevento" id="idevento" value="{{ $idevento }}">

    

    <div class="container d-flex" style="padding-left: 15%;">

      <div class="row" style="width: 100%;">

        @if ($promotor)

        <div class="col-md-6 col-6 mb-5">

          @if (count($promotor)==1)

            <h1 style="font-size: 3em;">Promotor</h1>

          @else

            <h1 style="font-size: 3em;">Promotores</h1>

          @endif

          

          <ul style="font-size: 2em;">

          

            @foreach ($promotor as $promotor)

              <li><i class="fas fa-check" style="color: green; font-size: .8em;"></i> {{ $promotor->promotor }}</li>

            @endforeach

            

              

            </ul>

          @endif

          

        </div>

    

          <div class="col-md-6 col-6 col-md-offset-6">

            <h1 style="font-size: 3em;">Preço</h1>

            <ul style="font-size: 2em;">

              <li><i class="fas fa-euro-sign" style="color: gold; font-size: .8em;"></i> {{ $detalhesevento[0]->preco }} euros</li>

            </ul>

          </div>

        

        



      </div>

    </div>



    

    @if (!Auth::check())

    <script>

        $(document).on('click', '.detcomprar', function(){

			    window.location = "/login";



		    });

    </script>

    @endif



    <script>

               

      var isnumlat = document.getElementById('latitude').value;

      var isnumlng = document.getElementById('longitude').value;



    

      

      

      if(!isnumlat.match(/[a-z]/i) && !isnumlng.match(/[a-z]/i)){ //verifica se apenas contém numeros

        var latitude = parseFloat(document.getElementById('latitude').value);

        var longitude = parseFloat(document.getElementById('longitude').value);

        if(!document.getElementById('longitude').value.includes("-")){                      

            longitude = "-".concat(longitude);

            longitude = parseFloat(longitude); //converte para float

        }              

      }

      else{// se tiver letras ou seja se forem coords gps, convertemos para decimais

        var substrlatitude = document.getElementById('latitude').value.substring(0,10);  //apenas vai buscar o que interessa das coords

        substrlatitude = substrlatitude.replace("º","°"); //troca o º por ° caso contrario n funciona

        

        var substrlongitude = document.getElementById('longitude').value.substring(0,10); //apenas vai buscar o que interessa das coords

        substrlongitude = substrlongitude.replace("º","°"); //troca o º por ° caso contrario n funciona

        

        

        var lon = ""+substrlongitude+"\"";

        var lat = ""+substrlatitude+"\"";



        var point = new GeoPoint(lon, lat); //libraria que converte coords gps para decimais

        

        var longitude = point.getLonDec(); 

        var latitude = point.getLatDec(); 

        longitude = "-".concat(longitude); //mete o - na longitude

        longitude = parseFloat(longitude); //converte para float

        

      }



        function initMap(){

          



            //Map options

            

            var options = {

                zoom: 8,

                center:{lat:latitude,lng:longitude}

            }

            //New map

            var map = new google.maps.Map(document.getElementById('map'),options);

            /*

            //Add marker

            var marker = new google.maps.Marker({

                position: {lat:42.4668,lng:-70.9495},

                map:map,

                icon:'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'

            });



            var infoWindow = new google.maps.InfoWindow({

                content: '<h1>Lynn Ma</h1>'

            });



            marker.addListener('click',function(){

                infoWindow.open(map,marker);

            });*/



            // Array of markers

            var markers = [

                {

                    coords:{lat:latitude,lng:longitude},

                    //iconImage: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',

                    content: '<h3>'+ document.getElementById('localevento').value +'</h3>'

                },

                

            ];



            // Loop through markers

            for(var i=0; i< markers.length;i++){

                //Add marker

                addMarker(markers[i]);

            }



            



            //add marker function

            function addMarker(props){

                var marker = new google.maps.Marker({

                    position: props.coords,

                    map:map,

                    //icon: props.iconImage

                });



                //check for custom icon

                if(props.iconImage){

                    //set icon image

                    marker.setIcon(props.iconImage);

                }



                //check content

                if(props.content){

                    var infoWindow = new google.maps.InfoWindow({

                        content: props.content

                    });



                    marker.addListener('click',function(){

                        infoWindow.open(map,marker);

                    });

                }

            }

        }

    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTUc9s3_kFPADG8C54V5fO-fV1HgPpvJk&callback=initMap"

        async defer></script>



    <script>

      const text = document.querySelector(".fancytext");

      const strText = text.textContent;

      const splitText = strText.split("");

      

      text.textContent = "";

      for(let i=0; i<splitText.length; i++){

        text.innerHTML += "<span class='notfadetextdeteevento'>" + splitText[i] + "</span>";

      }



      setTimeout(() => {

        let char = 0;

        let timer = setInterval(onTick,100);

        

        function onTick(){

          const span = text.querySelectorAll('span')[char];

          span.classList.add('fadetextdetevento');

          char++;

          if(char === splitText.length){

            complete();

            return;

          }

        }



        function complete(){

          clearInterval(timer);

          timer = null;

        }

      }, 1000);



      



    </script>



    <script>

      const navhome = document.querySelector('#home');

      const naveventos = document.querySelector('#eventos');

      navhome.classList.remove('active');

      naveventos.classList.add('active');

  </script>





  <script type="text/javascript">

    var clock;



    $(document).ready(function() {



      // Grab the current date

      var currentDate = new Date();



      // Set some date in the future. In this case, it's always Jan 1

      var futureDate  = new Date(""+document.getElementById('datainiciocalc').value+"");

      console.log(""+document.getElementById('datainiciocalc').value+"");



      // Calculate the difference in seconds between the future and current date

      var diff = futureDate.getTime() / 1000 - currentDate.getTime() / 1000;

      console.log(diff);

      // Instantiate a coutdown FlipClock

      if(diff>=0){

        clock = $('.clock').FlipClock(diff, {

          clockFace: 'DailyCounter',

          countdown: true,

          language:'pt',

        });

      }

      else{

        

      }

    });

  </script>

@endsection







@section('scripts')

    <script>


      $('#modalHorariosArtistas').on('show.bs.modal', function (e) {

        eventoid = document.getElementById("idevento").value;

        var button = $(e.relatedTarget) // Button that triggered the modal

        var idartista = button.data('nrartista') // Extract info from data-* attributes



        $.ajax(

          

          {

            url:"{{ route('historicoartistas') }}",

            method:"POST",

            data:{

              "_token": "{{ csrf_token() }}",

              eventoid: eventoid,

              idartista: idartista

              },

              beforeSend: function(){

            // Show image container

            $("#loader").show();

          },

              

            success:function(data){

                $('.historicoartistasclass').html(data);

                $("#loader").hide();

            }

        });

      });



    </script>

    

@endsection