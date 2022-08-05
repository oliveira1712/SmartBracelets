@extends('layouts.main')    
    @section('links')
        <link rel="stylesheet" href="{{ asset('css/carouselcss/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/carouselcss/owl.theme.default.min.css') }}">
    @endsection
    
    @section('content')
        
        @include('eventos.seccoes_eventos.seccaotipoeventos')
        
    @endsection
    
    @section('scripts')
        
        <script src="{{ asset('js/carouseljs/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('js/carouseljs/owlcarousel.js') }}"></script>

        
    @endsection