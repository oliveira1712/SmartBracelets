<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('homepage');

Route::get('/eventos', function () {
    return view('tpeventos');
});

Route::get('/teste', function () {
    return view('teste');
});


Route::get('/teste1', function () {
    return view('teste1');
});

Route::prefix('eventos')->group(function (){
    Route::resource('musica', 'EventoController');
    Route::resource('teatro', 'EventoController');
    Route::resource('arte', 'EventoController');
    Route::resource('desporto', 'EventoController');
    Route::get('detalhes/{idevento}', 'EventoController@getDetalhes');
    Route::post('historicoartista', 'EventoController@historicoArtista')->name('historicoartistas');
    Route::post('historicoentradasaida', 'PulseiraController@showHistoricoEntradasSaidas')->name('historicoEntradaSaida');
    Route::get('historicoentradasaidapaginacao', 'PulseiraController@showHistoricoEntradasSaidasPaginacao');
    Route::resource('pesquisar', 'PesquisaeventosController'); //vai automaticamente ao index do controller
    Route::post('pesquisar/getpesquisa', 'PesquisaeventosController@getPesquisa')->name('Pesquisar.getPesquisa');
    Route::post('comprarbilhete', 'ManipularBilheteController@buyTicket')->name('Bilhete.buyTicket');
    Route::post('getbilhetes', 'ManipularBilheteController@getBilhetes')->name('Bilhete.getBilhetes');
    Route::post('removerbilhete', 'ManipularBilheteController@removeTicket')->name('Bilhete.removeTicket');
    Route::post('removerbilhetes', 'ManipularBilheteController@removeTickets')->name('Bilhete.removeTickets');
    Route::post('contarbilhetes', 'ManipularBilheteController@countTickets')->name('Bilhete.countTickets');
    

});


Route::get('logina', 'android@login')->name('logina');

Route::get('registara', 'android@registar')->name('registara');





Route::get('/home', 'HomeController@index')->name('home'); //quando está logado

Route::middleware(['auth','adminauthenticated'])->group(function () { //  aplica os middlewares aos routes abaixo
    Route::prefix('admin')->group(function (){ // coloca admin/nomepagina
        Route::name('admin.')->group(function (){ //coloca admin. no nome da rota

            Route::group(['middleware' => ['web']], function() {
                Route::resource('tipoUser', 'tipoUserController');
                Route::post('tipoUser/update', 'tipoUserController@update')->name('tipoUser.update');    
                Route::get('tipoUser/destroy/{id}', 'tipoUserController@destroy');
                
                Route::resource('Eventos', 'EventosController');
                Route::post('Eventos/update', 'EventosController@update')->name('Eventos.update');    
                Route::get('Eventos/destroy/{id}', 'EventosController@destroy');                 
                 

                Route::resource('Artistas', 'ArtistaController');
                Route::post('Artistas/update', 'ArtistaController@update')->name('Artistas.update');    
                Route::get('Artistas/destroy/{id}', 'ArtistaController@destroy');  
                
                Route::resource('Cartazes', 'CartazController');
                Route::post('Cartazes/update', 'CartazController@update')->name('Cartazes.update');    
                Route::get('Cartazes/{id}/{id1}/edit', 'CartazController@edit');  
                Route::get('Cartazes/destroy/{id}/{id1}', 'CartazController@destroy');  


                Route::resource('TipoPromotores', 'TipoPromotorController');
                Route::post('TipoPromotores/update', 'TipoPromotorController@update')->name('TipoPromotores.update');    
                Route::get('TipoPromotores/destroy/{id}', 'TipoPromotorController@destroy');   
                

                Route::resource('Promotores', 'PromotorController');
                Route::post('Promotores/update', 'PromotorController@update')->name('Promotores.update');    
                Route::get('Promotores/destroy/{id}', 'PromotorController@destroy');  
                
                Route::resource('TipoArtistas', 'tipoArtistaController');
                Route::post('TipoArtistas/update', 'tipoArtistaController@update')->name('TipoArtistas.update');    
                Route::get('TipoArtistas/destroy/{id}', 'tipoArtistaController@destroy'); 

                Route::resource('EventosPromotores', 'EventoPromotorController');
                Route::post('EventosPromotores/update', 'EventoPromotorController@update')->name('EventosPromotores.update');    
                Route::get('EventosPromotores/{id}/{id1}/edit', 'EventoPromotorController@edit');  
                Route::get('EventosPromotores/destroy/{id}/{id1}', 'EventoPromotorController@destroy');  

                Route::resource('Produtos', 'ProdutoController');
                Route::post('Produtos/update', 'ProdutoController@update')->name('Produtos.update');    
                Route::get('Produtos/destroy/{id}', 'ProdutoController@destroy');  

                

                Route::resource('UserCrud', 'UserCrudController');
                Route::post('UserCrud/update', 'UserCrudController@update')->name('UserCrud.update');    
                Route::get('UserCrud/destroy/{id}', 'UserCrudController@destroy'); 
                
                Route::resource('PrecoProdutosEventos', 'PrecoProdutosEventosController');
                Route::post('PrecoProdutosEventos/update', 'PrecoProdutosEventosController@update')->name('PrecoProdutosEventos.update');    
                Route::get('PrecoProdutosEventos/{id}/{id1}/edit', 'PrecoProdutosEventosController@edit');  
                Route::get('PrecoProdutosEventos/destroy/{id}/{id1}', 'PrecoProdutosEventosController@destroy');  

                Route::resource('UsersInfo', 'UsersInfoController');
                Route::get('UsersInfoPaginacao', 'UsersInfoController@users_info_paginacao');

            });
                        
        });                  
    });   
});


Route::middleware(['auth','adminpromotorauthenticated'])->group(function () { //  aplica os middlewares aos routes abaixo
    Route::prefix('promotor')->group(function (){ // coloca admin/nomepagina
        Route::name('promotor.')->group(function (){ //coloca admin. no nome da rota
            Route::get('promovereventos', 'UserPromotorController@index')->name('promoveeventos');
            Route::post('promoveeventosajax', 'UserPromotorController@promoverEvento')->name('promovereventosajax');            
        });                  
    });   
});

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});


Route::middleware(['auth'])->group(function () { 
    Route::get('perfil', 'UserController@perfil')->name('perfil');
    Route::post('perfilatualizafoto', 'UserController@update_avatar')->name('atualizaavatar');
    // Change Password
    Route::post('/mudarpassword', 'UserController@changePassword')->name('mudarpassword');
    Route::resource('/comprarbilhete', 'ComprarBilheteController');
    //checkout
    Route::get('eventos/checkout','ManipularBilheteController@indexcheckout')->name('checkout');
    Route::post('eventos/checkoutajax','ManipularBilheteController@getBilhetesCheckOut')->name('getBilhetesCheckOut');
    Route::get('eventos/realizarcheckoutbilhetes','ManipularBilheteController@checkoutbilhetes')->name('checkoutbilhetes');
    Route::post('eventos/getpulseiras','ManipularBilheteController@getPulseiras')->name('getPulseiras');
    Route::get('eventos/getpulseiras/getPulseirasPaginacaoCheckOut','ManipularBilheteController@getPulseirasPaginacaoCheckOut');
    Route::post('eventos/getNomePulseira','ManipularBilheteController@getNomePulseira')->name('getNomePulseira');
    Route::post('eventos/changeNomePulseira','ManipularBilheteController@changeNomePulseira')->name('changeNomePulseira');

    Route::get('eventos/pulseiras','PulseiraController@index')->name('pulseirashistorico');
    Route::post('eventos/pulseirashistorico','PulseiraController@getPulseirasHistorico')->name('pulseirashistoricoget');
    Route::get('eventos/pulseirashistorico/getPulseirasPaginacao','PulseiraController@getPulseirasPaginacao');
    

    Route::post('eventos/mostrahistoricopulseiras','PulseiraController@showpulseirashistorico')->name('showpulseirashistorico');
    Route::post('eventos/pulseiraexpira','PulseiraController@eventoacabapulseira')->name('eventoexpirapulseira');
    Route::post('eventos/atualizahistoricopulseiras','PulseiraController@atualizahistoricopulseiras')->name('atualizahistoricopulseiras');
    Route::get('eventos/atualizahistoricopulseiras/getHistoricoPaginacao','PulseiraController@getHistoricoPulseirasPaginacao');
});

Route::get("/primeiro",'AppController@enviarPrimeiroEmail');

Auth::routes();



