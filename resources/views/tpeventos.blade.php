@extends('layouts.main')
@section('content')


  
  
<div class="wrapper_Cardboxex_tpeventos">
  <h1 class="headline centereventos">Eventos</h1> 
<div class="box boxmusica">
    <div class="imgBx">
      <a href="eventos/musica"><img src="{{ asset('storage/imgsHomePage/eventoconcerto.jpg') }}" alt=""></a>
    </div>
    <div class="content">
      <h2>Eventos de Musica</h2>
    </div>
  </div>

  <div class="box boxteatro">
    <div class="imgBx">
      <a href="eventos/teatro"><img src="{{ asset('storage/imgsHomePage/eventoteatro.jpg') }}" alt=""></a>
    </div>
    <div class="content">
      <h2>Eventos de Teatro</h2>
    </div>
  </div>

  <div class="box boxarte">
    <div class="imgBx">
      <a href="eventos/arte"><img src="{{ asset('storage/imgsHomePage/eventoarte.jpg') }}" alt=""></a>
    </div>
    <div class="content">
      <h2>Eventos de Arte</h2>
    </div>
  </div>

  <div class="box boxdesporto">
    <div class="imgBx">
      <a href="eventos/desporto"><img src="{{ asset('storage/imgsTipoEventos/maratona.jpg') }}" alt="" ></a>
    </div>
    <div class="content">
      <h2>Eventos de Desporto</h2>
    </div>
  </div>
</div>
@endsection