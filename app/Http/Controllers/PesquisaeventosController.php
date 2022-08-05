<?php

namespace App\Http\Controllers;

use App\eventos;
use App\tipoevento;
use App\Zona;
use Illuminate\Http\Request;
use DB;
use DateTime;

class PesquisaeventosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventos = eventos::all();
        $tipoeventos = tipoevento::all();
        $zonas = zona::all();
        $artistas = DB::select("SELECT artistas.*,tipoartistas.tipoartista
        FROM artistas,tipoartistas
        WHERE artistas.tpartistaid=tipoartistas.idtpartista");

        return view('eventos.pesquisaeventos',[
            'eventos' => $eventos,
            'tipoeventos' => $tipoeventos,
            'zonas' => $zonas,
            'artistas' => $artistas,
        ]);
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
     * @param  \App\eventos  $eventos
     * @return \Illuminate\Http\Response
     */
    public function show(eventos $eventos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\eventos  $eventos
     * @return \Illuminate\Http\Response
     */
    public function edit(eventos $eventos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\eventos  $eventos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, eventos $eventos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\eventos  $eventos
     * @return \Illuminate\Http\Response
     */
    public function destroy(eventos $eventos)
    {
        //
    }

    public function getPesquisa(Request $request){
        
            
        $datetime = new \DateTime();
        $timezone = new \DateTimeZone('Europe/Lisbon');
        $datetime->setTimezone($timezone);

        $horaatual =  $datetime->format('H:i:s');

        

        $query = "
            SELECT * FROM eventos WHERE evento like '%".$request->nomeevento."%'
        ";   

        if($request->idartistas!=null){
            $filtro_idartistas = implode("','", $request->idartistas);
            $queryaux1 = "SELECT *
            FROM cartazes
            WHERE idartistac IN('".$filtro_idartistas."')";
            $eventosartistas = DB::select($queryaux1);
            $filtro_eventosartistas = "";
            $c=0;
            $eventosparticipantes = array();
            foreach($eventosartistas as $eventosartista){
                $c++;
                if($c!=count($eventosartistas)){
                    $filtro_eventosartistas .= $eventosartista->ideventoc.',';
                }
                else{
                    $filtro_eventosartistas .= $eventosartista->ideventoc;
                }                               
            }
            $query .= "
                AND idevento IN(".$filtro_eventosartistas.")
            ";
        }


        if($request->tipoevento!=null){
            $filtro_tipoevento = implode("','", $request->tipoevento);
            $query .= "
                AND tpeventoid IN('".$filtro_tipoevento."')
            ";
        }

        if($request->zona!=null){
            $filtro_zona = implode("','", $request->zona);
            $query .= "
                AND zonaid IN('".$filtro_zona."')
            ";
        }



        if($request->datainicio!=null && $request->datafim!=null){
            $query .= "
                AND datainicio>='".$request->datainicio."' 
                AND (datafim >='".$request->datainicio."' AND datafim<='".$request->datafim."')
            ";
        }

        if($request->datainicio!=null && $request->datafim==null){
            $query .= "
                AND datainicio>='".$request->datainicio."' 
                
            ";
        }

        if($request->datainicio==null && $request->datafim!=null){
            $query .= "
                AND datafim<='".$request->datafim."' 
                
            ";
        }

        if($request->smartbracelets == 1){
            $query .= "
                AND eventos.tpeventolugarid = 2
            ";
        }


        $exquery = DB::select($query);
        $nrregistos = count($exquery);     
        $output = '';
        if($nrregistos>0){           
            foreach($exquery as $resultado){

                if(strtotime($resultado->horafim) == strtotime("00:00:00")){
                    $horafimevento = "23:59:00";
                }else{
                    $horafimevento = $resultado->horafim;
                }

                $output .= '                
                    <div class="col-6 col-sm-6 col-lg-4 col-md-6 mb-5 text-center">
                    ';

                    if( ($resultado->estadoeventoid ==2) || (strtotime(date('Y-m-d')) > strtotime($resultado->datafim)) || (strtotime(date('Y-m-d')) == strtotime($resultado->datafim) && strtotime($horaatual) > strtotime($horafimevento)) || (strtotime($horaatual) < strtotime($resultado->horainicio) && strtotime(date('Y-m-d')) ==  strtotime($resultado->datainicio)) || (strtotime(date('Y-m-d')) >=  strtotime($resultado->datainicio) && strtotime(date('Y-m-d')) <=  strtotime($resultado->datafim) && strtotime($resultado->datainicio) != strtotime($resultado->datafim)) || (strtotime(date('Y-m-d')) ==  strtotime($resultado->datainicio) && strtotime($resultado->datainicio) == strtotime($resultado->datafim) && strtotime($horaatual) >= strtotime($resultado->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)) || ((strtotime(date('Y-m-d')) >=  strtotime(date('Y-m-d',(strtotime ( '-7 day' , strtotime ( $resultado->datainicio) ) )))) && (strtotime(date('Y-m-d')) < strtotime($resultado->datainicio)))  ){
                        $output .= '<div class="card cardpesquisa cardpesqheight">';
                    }else{
                        $output .= '<div class="card cardpesquisa cardpesqnheight">';
                    }
                        

                    $output .= '
                        <img class="card-img-top" src="/storage/imagens_eventos/'.$resultado->foto.'" alt="Card image cap">
                        <div class="card-title mx-auto">

                            <div class="container d-flex justify-content-center align-items-center my-2" style="height: 40px;">';    
                            
                            if($resultado->tpeventolugarid==2){
                                $output .= '<h4 class="txteventoaprov">'.$resultado->evento.'</h4>';
                            }else{
                                $output .= '<h4>'.$resultado->evento.'</h4>';
                            }
                            
                            
                            
                            
                            $output .= '</div>
                            
                        
                        
                            
                            <button class="btneventos" onclick=window.location.href="/eventos/detalhes/'.$resultado->idevento.'" ><span>Detalhes</span></button>
                            
                            ';
                            if($resultado->estadoeventoid == 1 && !(strtotime(date('Y-m-d')) > strtotime($resultado->datafim)) && !(strtotime(date('Y-m-d')) == strtotime($resultado->datafim) && strtotime($horaatual) > strtotime($horafimevento)) && !(strtotime(date('Y-m-d')) ==  strtotime($resultado->datainicio) && strtotime($resultado->datainicio) == strtotime($resultado->datafim) && strtotime($horaatual) >= strtotime($resultado->horainicio) && strtotime($horaatual) <= strtotime($horafimevento))){
                                if($resultado->tpeventolugarid==2){
                                    $output .= '<button class="btneventos evcomprar" id="'.$resultado->idevento.'" ><span>Comprar</span></button>' ;
                                }else{
                                    $output .= '<button class="btneventos evcomprar" onclick=window.location.href="'.$resultado->linkcompra.'" ><span>Comprar</span></button>';
                                }
                            }
                            if(($resultado->estadoeventoid==2) || (strtotime(date('Y-m-d')) > strtotime($resultado->datafim)) || (strtotime(date('Y-m-d')) == strtotime($resultado->datafim) && strtotime($horaatual) > strtotime($horafimevento)) || (strtotime(date('Y-m-d')) ==  strtotime($resultado->datainicio) && strtotime($resultado->datainicio) == strtotime($resultado->datafim) && strtotime($horaatual) >= strtotime($resultado->horainicio) && strtotime($horaatual) <= strtotime($horafimevento))){
                                if($resultado->tpeventolugarid==2){
                                    $output .= '<button class="btneventos evcomprar" disabled id="'.$resultado->idevento.'" style="cursor: not-allowed;" ><span>Comprar</span></button>' ;
                                }else{
                                    $output .= '<button class="btneventos evcomprar" disabled onclick=window.location.href="'.$resultado->linkcompra.'" style="cursor: not-allowed;" ><span>Comprar</span></button>';
                                }
                            }
                            
                            if($resultado->estadoeventoid ==1){
                                if(strtotime(date('Y-m-d')) > strtotime($resultado->datafim)){
                                    $output .= '<div class="div-info-tmp-evento d-flex justify-content-center mt-2" style="margin-bottom: -2rem;">
                                        <div class="rainbow-terminado" >
                                            <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                        </div>  
                                    </div>';
                                }

                                if(strtotime(date('Y-m-d')) == strtotime($resultado->datafim) && strtotime($horaatual) > strtotime($horafimevento)){
                                    $output .= '<div class="div-info-tmp-evento d-flex justify-content-center mt-2" style="margin-bottom: -2rem;">
                                        <div class="rainbow-terminado" >
                                            <p style="font-weight: bold; color: #515151; margin-top: -6%;">Terminado!</p>
                                        </div>  
                                    </div>';
                                }

                                if(strtotime($horaatual) < strtotime($resultado->horainicio) && strtotime(date('Y-m-d')) ==  strtotime($resultado->datainicio)){
                                    $output .= '<div class="div-info-tmp-evento d-flex justify-content-center mt-2" style="margin-bottom: -2rem;">
                                    <div class="rainbow-breve" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                    </div> 
                                </div>';
                                }

                                if(strtotime(date('Y-m-d')) >=  strtotime($resultado->datainicio) && strtotime(date('Y-m-d')) <=  strtotime($resultado->datafim) && strtotime($resultado->datainicio) != strtotime($resultado->datafim)){
                                    $output .= '<div class="div-info-tmp-evento d-flex justify-content-center mt-2" style="margin-bottom: -2rem;">
                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div>   
                                </div>';
                                }

                                if(strtotime(date('Y-m-d')) ==  strtotime($resultado->datainicio) && strtotime($resultado->datainicio) == strtotime($resultado->datafim) && strtotime($horaatual) >= strtotime($resultado->horainicio) && strtotime($horaatual) <= strtotime($horafimevento)){
                                    $output .= '<div class="div-info-tmp-evento d-flex justify-content-center mt-2" style="margin-bottom: -2rem;">
                                    <div class="rainbow-decorrer" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">A decorrer!</p>
                                                    </div>   
                                </div>';
                                }


                                if((strtotime(date('Y-m-d')) >=  strtotime(date('Y-m-d',(strtotime ( '-7 day' , strtotime ( $resultado->datainicio) ) )))) && (strtotime(date('Y-m-d')) < strtotime($resultado->datainicio))){
                                    $output .= '<div class="div-info-tmp-evento d-flex justify-content-center mt-2" style="margin-bottom: -2rem;">
                                    <div class="rainbow-breve" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Em breve!</p>
                                                    </div> 
                                </div>';
                                }
                            }else{
                                $output .= '<div class="div-info-tmp-evento d-flex justify-content-center mt-2" style="margin-bottom: -2rem;">
                                    <div class="rainbow-cancelado" >
                                                        <p style="font-weight: bold; color: #515151; margin-top: -6%;">Cancelado!</p>
                                                    </div> 
                                </div>';
                            }
                            
                            $output .='
                            </div>                          
                        </div>  
                    </div>   ';                                 
                
            }
        }
        else{
            $output = '<h3>Sem eventos com os filtros que procurou</h3>';
        }

        return $output;
    }
}
