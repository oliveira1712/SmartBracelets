<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--<title>{{ config('app.name', 'SmartBracelets') }}</title>--}}
    <title>SmartBracelets</title>
    <!-- Scripts -->
    
    <link rel="icon" href="{{ asset('storage/imgsHomePage/logo.png') }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    <!--Font awesome CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <!--Scroll reveal CDN-->
    <script src="{{ asset('js/scrollreveal/scrollreveal.js') }}"></script>
    <!-- Styles -->
    <link rel="stylesheet" href="https://unpkg.com/simplebar@latest/dist/simplebar.css"/>
    <script src="{{ asset('js/sweetalert/sweetalert.all.js') }}"></script>
    

    @if (Request::is('admin/Eventos') || Request::is('admin/Artistas') || Request::is('admin/UserCrud') || Request::is('admin/Produtos') || Request::is('admin/PrecoProdutosEventos') || Request::is('admin/PrecoEventos') || Request::is('admin/Cartazes') || Request::is('admin/tipoUser') || Request::is('admin/TipoPromotores') || Request::is('admin/Promotores') || Request::is('admin/TipoArtistas') || Request::is('admin/Promotores') || Request::is('admin/EventosPromotores'))
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <script src="{{ asset('js/carouseljs/Jquery3.4.1.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap/bootstrap4.3.1.min.js') }}"  ></script>
    @endif
    
    @yield('links')
    <link href="{{ asset('css/shopcart/style.css') }}" rel="stylesheet">
</head>
<body>
    
    @include('inc.spinnerwrapper') 
    
    
    @include('inc.navbar')
    @if(str_contains(url()->current(), '/admin'))
        <script>
            const navhome = document.querySelector('#home');
            const naveventos = document.querySelector('#menusub');
            navhome.classList.remove('active');
            naveventos.classList.add('active');
        </script>     
    @endif
    @if (Request::is('/') || Request::is('home') || Request::is('login') || Request::is('register'))
        <script>
            // mudar a cor do nav ao fazer scroll
            window.addEventListener('scroll', function () {
                let header = document.querySelector('header');
                let windowPosition = window.scrollY > 850;
                header.classList.toggle('backgroundnav', windowPosition);
            })
            //para a class active
            const header = document.querySelector('header');
            header.classList.remove('backgroundnav');
        </script>
    @else 
        <script>
            const header = document.querySelector('header');
            header.classList.add('backgroundnav');
        </script>  
    @endif
        
       

        @if (Request::is('eventos/pulseiras'))
            <script>
                const navhome = document.querySelector('#home');
                const naveventos = document.querySelector('#pulseiras');
                navhome.classList.remove('active');
                naveventos.classList.add('active');
            </script>
        @endif  
        
        @if (Request::is('eventos/checkout'))
            <script>
                const navhome = document.querySelector('#home');
                const naveventos = document.querySelector('#bilhetes');
                navhome.classList.remove('active');
                naveventos.classList.add('active');
            </script>
        @endif  
        
        @if (Request::is('promotor/promovereventos'))
            <script>
                const navhome = document.querySelector('#home');
                const naveventos = document.querySelector('#promover');
                navhome.classList.remove('active');
                naveventos.classList.add('activesub');
            </script>
        @endif 

        @if (Request::is('perfil'))
            <script>
                const navhome = document.querySelector('#home');
                const naveventos = document.querySelector('#perfil');
                navhome.classList.remove('active');
                naveventos.classList.add('active');
            </script>
        @endif
    

    @if (Request::is('login'))
        <script>
            const navhome = document.querySelector('#home');
            const naveventos = document.querySelector('#login');
            navhome.classList.remove('active');
            naveventos.classList.add('active');
        </script>
    @endif

    @if (Request::is('register'))
        <script>
            const navhome = document.querySelector('#home');
            const naveventos = document.querySelector('#registar');
            navhome.classList.remove('active');
            naveventos.classList.add('active');
        </script>
    @endif

    @if (Request::is('eventos/musica') || Request::is('eventos/teatro') || Request::is('eventos/arte') || Request::is('eventos/desporto'))
    <script>
        console.log("teste");
        const navhome = document.querySelector('#home');
        const naveventos = document.querySelector('#eventos');
        navhome.classList.remove('active');
        naveventos.classList.add('active');
    </script>
@endif


    @yield('content')
    @include('inc.footer')

    @if (Auth::check())
        @include('shopcart.shopcartitems')
    @endif
</body>
<script src="{{ asset('js/main.js') }}"></script>

@if (Auth::check())
<script src="{{ asset('js/shopcart/main.js') }}"></script>

    <script>
        $(window).on("load", function () {
            conta_nrbilhetes();
        });

        $(document).ready(function () {
            $.ajax(        
                {
                url:"{{ route('eventoexpirapulseira') }}",
                method:"POST",
                data:{
                    "_token": "{{ csrf_token() }}"
                    },
                    beforeSend: function(){
                            // Show image container
                            
                    },
                    
                success:function(data){
                    
                }
            });
        });

    </script>

    
@endif


@yield('scripts')
</html>