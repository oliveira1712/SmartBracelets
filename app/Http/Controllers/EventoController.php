<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evento;
use App\Artista;
use DB;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventosmusica = Evento::where('TpEventoID','1')->get();
        $eventosteatro = Evento::where('TpEventoID','2')->get();
        $eventosarte = Evento::where('TpEventoID','3')->get();
        $eventosdesporto = Evento::where('TpEventoID','4')->get();
        

        if (\Request::is('eventos/musica')) { 
            return view('eventos.tipoeventos',[
                'eventos' => $eventosmusica,               
            ]);
        }

        if (\Request::is('eventos/teatro')) { 
            return view('eventos.tipoeventos',[
                'eventos' => $eventosteatro,               
            ]);
        }

        if (\Request::is('eventos/arte')) { 
            return view('eventos.tipoeventos',[
                'eventos' => $eventosarte,               
            ]);
        }

        if (\Request::is('eventos/desporto')) { 
            return view('eventos.tipoeventos',[
                'eventos' => $eventosdesporto,               
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function historicoArtista(Request $request){
        $eventoid = $request->eventoid;
        $artistaid = $request->idartista;


        $historicoartista = DB::table('cartazes')
                            ->where('ideventoc',  $eventoid)
                            ->where('idartistac', $artistaid)
                            ->get();
                            
                            $datainicio=date_create($historicoartista[0]->datainicio);
                            $datafim=date_create($historicoartista[0]->datafim);
        $output = '
        <div class="container-dadosinicio" style="display: flex; justify-content: space-evenly;">      
        <div class="card text-white bg-dark mb-3" style="background: #2E383C !important; width: 120px;">
          <div class="card-header text-center">Data Inicio <i class="fas fa-calendar-alt"></i></div>
          <div class="card-body">
            <p class="card-text text-center">'. date_format($datainicio,"d/m/Y") .'</p>
          </div>
        </div>

        <div class="card text-white bg-dark mb-3" style="background: #2E383C !important; width: 120px;">
          <div class="card-header text-center">Hora Inicio <i class="fas fa-clock"></i></div>
          <div class="card-body">
            <p class="card-text text-center">'.$historicoartista[0]->horainicio.'</p>
          </div>
        </div>
      </div>

      <div class="container-dadosfim" style="display: flex; justify-content: space-evenly;">
      <div class="card text-white bg-dark mb-3" style="background: #2E383C !important; width: 120px;">
        <div class="card-header text-center">Data Fim <i class="fas fa-calendar-alt"></i></div>
        <div class="card-body">
          <p class="card-text text-center">'.   date_format($datafim,"d/m/Y").'</p>
        </div>
      </div>

      <div class="card text-white bg-dark mb-3" style="background: #2E383C !important; width: 120px;">
        <div class="card-header text-center">Hora Fim <i class="fas fa-clock"></i></div>
        <div class="card-body">
          <p class="card-text text-center">'.$historicoartista[0]->horafim.'</p>
        </div>
      </div>

      </div>

      <div class="container" style="display:flex; justify-content: center;">
        <div class="card text-white bg-dark mb-3" style="background: #2E383C !important; width: 320px;">
        <div class="card-header text-center">Local de Atuação <i class="fas fa-map-marked"></i></div>
        <div class="card-body">
            <p class="card-text text-center">'.$historicoartista[0]->local.'</p>
        </div>
        </div>
      </div>
        ';



        return $output;
    }

    public function getDetalhes($idevento = null)
    {
        //$detalhesevento = DB::table('Eventos')->where('idevento',$idevento)->get();
        $detalhesevento = DB::select('SELECT eventos.*,tipoeventos.tipoevento,classificacoes.classificacao,zonas.zona
        FROM eventos,tipoeventos,classificacoes,zonas
        WHERE eventos.tpeventoid=tipoeventos.idtpevento
        AND eventos.classificacaoid=classificacoes.idclassificacao
        AND zonas.idzona=eventos.zonaid
        AND eventos.idevento='.$idevento.'
        ORDER BY eventos.idevento ASC');


        $querypromotor = "SELECT * FROM eventospromotores,promotores WHERE eventospromotores.promotorid = promotores.idpromotor AND eventoid = $idevento ";

        $promotor = DB::select($querypromotor);

        

        $cartazes = DB::select('SELECT * FROM Cartazes WHERE ideventoc='.$idevento); //vai dar todos os artistas que estao em determinado evento
        $artistas = Artista::all();

        return view('eventos.detalheseventos',[
            'detalhesevento' => $detalhesevento,
            'cartazes' => $cartazes,
            'artista' => $artistas,
            'idevento' => $idevento,
            'promotor' => $promotor,
        ]);
            
    }
}
