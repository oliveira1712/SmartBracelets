<header id="headerlist">

    <div class="container">

        <nav class="nav" >

            <div class="menu-toggle">

                <i class="fas fa-bars"></i>

                <i class="fas fa-times"></i>

            </div>

            <a href="{{ url('/') }}" ><img src="{{ asset('storage/imgsHomePage/logo.png') }}" alt=""></a>

            <ul class="nav-list">

                <li class="nav-item">

                    <a href="{{ url('/') }}" id="home" class="nav-link active"><i class="fas fa-home"></i> Home</a>

                </li>

                <li class="nav-item">

                    <a href="#" id="eventos" class="nav-link eventossub"><i class="fas fa-columns"></i> Eventos &nbsp;<i class="fas fa-caret-down"></i></a>

                

                    <ul class="sub-menu">

                        

                        <li>

                        

                            <a href="{{ url('eventos/musica') }}" class="nav-link"><i class="fas fa-music"></i> Musica</a>

                            <a href="{{ url('eventos/teatro') }}" class="nav-link"><i class="fas fa-theater-masks"></i> Teatro</a>

                            <a href="{{ url('eventos/arte') }}" class="nav-link"><i class="fab fa-artstation"></i> Arte</a>

                            <a href="{{ url('eventos/desporto') }}" class="nav-link"><i class="fas fa-running"></i> Desporto</a>

                            <a href="{{ url('eventos/pesquisar') }}" class="nav-link"><i class="fas fa-search"></i> Pesquisar</a>

                        </li>

                    </ul>

                </li>

                

                

                <li class="nav-item">

                    <a href="{{ route('pulseirashistorico') }}" id="pulseiras" class="nav-link"><i class="fas fa-history"></i> Histórico</a>

                </li>



                <li class="nav-item">

                    <a href="{{ route('checkout') }}" id="bilhetes" class="nav-link"><i class="fas fa-money-check-alt"></i> CheckOut</a>

                </li>



                @if (Auth::check() && Auth::user()->tipoUserID == 3)

                    <li class="nav-item">

                        <a href="#" id="menusub" class="nav-link"

                            >CRUDS

                            <i class="icon ion-md-arrow-dropdown"></i>

                        </a>

                        <ul class="sub-menu">

                            <li>

                                <a href="#" class="nav-link" id="eventossublink"

                                    >Eventos

                                    <i class="icon ion-md-arrow-dropdown"></i>

                                </a>

                                <ul class="sub-menu" id="submenueventos">

                                    <li>

                                        <a href="{{ url('admin/Eventos') }}" class="nav-link">Evento</a>

                                    </li>







                                    





                                    <li>

                                        <a href="#" class="nav-link"

                                            >Produtos

                                            <i class="icon ion-md-arrow-dropdown"></i>

                                        </a>

                                        <ul class="sub-menu" id="submenuprodutos">

                                            <li>

                                                <a href="{{ url('admin/Produtos') }}" class="nav-link" >Produtos</a>

                                            </li>

                                            <li>

                                                <a href="{{ url('admin/PrecoProdutosEventos') }}" class="nav-link">Preco Produtos</a>

                                            </li>

                                        </ul>

                                    </>



                                    

                                    

                                    <li>

                                        <a href="#" class="nav-link"

                                            >Cartazes

                                            <i class="icon ion-md-arrow-dropdown"></i>

                                        </a>

                                        <ul class="sub-menu" id="submenucartaz">

                                            <li>

                                                <a href="{{ url('admin/Cartazes') }}" class="nav-link">Cartaz</a>

                                            </li>

                                            <li>

                                                <a href="{{ url('admin/Artistas') }}" class="nav-link">Artistas</a>

                                            </li>

                                            <li>

                                                <a href="{{ url('admin/TipoArtistas') }}" class="nav-link">Tipo Artistas</a>

                                            </li>

                                        </ul>

                                    </li>

                                    <li>

                                        <a href="#" class="nav-link"

                                            >Evento Promotor

                                            <i class="icon ion-md-arrow-dropdown"></i>

                                        </a>

                                        <ul class="sub-menu" id="submenueventopromotor">

                                            <li>

                                                <a href="{{ url('admin/EventosPromotores') }}" class="nav-link">Evento Promotor</a>

                                            </li>

                                            <li>

                                                <a href="{{ url('admin/Promotores') }}" class="nav-link">Promotores</a>

                                            </li>

                                            <li>

                                                <a href="{{ url('admin/TipoPromotores') }}" class="nav-link">Tipo Promotores</a>

                                            </li>

                                        </ul>

                                    </li>

                                    

                                    

                                    

                                </ul>

                            </li>



                            <li>

                                <a href="#" class="nav-link" id="eventossublink"

                                    >Users

                                    <i class="icon ion-md-arrow-dropdown"></i>

                                </a>

                                <ul class="sub-menu" id="submenuusers">

                                    <li>

                                        <a href="{{ url('admin/UserCrud') }}" class="nav-link">Users</a>

                                    </li>

                                   

                                    <li>

                                        <a href="{{ url('admin/UsersInfo') }}" class="nav-link">Users Info</a>

                                    </li>

                                    

                                    

                                </ul>

                            </li>
            

                        </ul>

                    </li>

                @endif

                

                @if (Auth::check())

                    <li class="nav-item">

                        

                        <a href="#" onclick='mostra_bilhetes();' id="triggercarrinho" class="nav-link"> <i class="fas fa-shopping-cart"></i> Cart <span id="cart_count"  style="background-color: #f8f9fa; border-radius: 10px; padding: 0px 9px 1px; color: #FFC107; transition: all .750s ease"></span></a>

                        <input type="hidden" name="iduser" id="iduser" value="{{Auth::user()->id}}">

                    </li>

                @endif

                

                @if (Auth::check())

                    @if (Auth::user()->tipoUserID != 3)

                        <li  style="width: 80px !important;">

                        </li>

                    @endif                   

                @endif

                @if (!Auth::check())                   

                    <li   style="width: 100px !important;">

                    </li>                    

                @endif

                @if (Auth::check())

                    @if (Auth::user()->tipoUserID == 3)

                        <li  style="width: 15px !important;">

                        </li> 

                    @endif

                    

                @endif

                    @guest

                    <li class="nav-item">

                        <a class="nav-link" id="login" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> {{ __('Login') }}</a>

                    </li>                        

                    @if (Route::has('register'))

                    <li class="nav-item">

                        <a class="nav-link" id="registar" href="{{ route('register') }}"><i class="fas fa-user-tie"></i> {{ __('Registar') }}</a>

                    </li> 

                    @endif

                    @else



                    <li class="nav-item">

                        <a href="#" id="username" class="nav-link avatarnome usernamesub">

                            <?php $avatar = Auth::user()->avatar?>

                            

                            <img src="{{ asset("storage/users_avatares/$avatar") }}" class="avatarpequeno">

                            {{ Auth::user()->name }} &nbsp;<i class="fas fa-caret-down"></i>

                            

                        </a>

                    

                        <ul class="sub-menu" style="margin-left: 3.5rem !important;">

                            

                            <li>

                            

                                <a href="{{ url('/perfil') }}" class="nav-link" id="perfil"><i class="fas fa-user"></i> Perfil</a>

                                @if (Auth::user()->tipoUserID != 1)

                                    <a class="nav-link" id="promover" href="{{ route('promotor.promoveeventos') }}"><i class="fas fa-ad"></i> Promover</a>

                                @endif

                        

                                    <a class="nav-link" href="{{ route('logout') }}"

                                        onclick="event.preventDefault();

                                                    document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> 

                                        {{ __('Logout') }}

                                    </a>

                                    

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">

                                        @csrf

                                    </form>

                                   

                            </li>

                        </ul>

                    </li>

                            



                            

                    @endguest

                



                



            </ul>            

        </nav>

    </div>

</header>