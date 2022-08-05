<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use DateTime;

class PulseiraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pulseiras.pulseiras',[
            /* 'tiposartistas' => $tiposartistas, */
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

    public function showpulseirashistorico(Request $request)
    {
        //dd($request->all());

        //para saber o id da pulseira

        $pulseira = DB::table('pulseiras')
                            ->where('nrseriepulseira',$request->nrseriepulseira)
                            ->join('estadopulseiras','estadopulseiras.idestadopulseira','=','pulseiras.estadopulseiraid')
                            ->get();
        
        
        $userid = Auth::user()->id;
        $queryeventosuser = "SELECT *
        FROM bilhetes,eventos
        WHERE bilhetes.eventoid = eventos.idevento
        AND userid=$userid
        AND pulseiraid = ".$pulseira[0]->idpulseira."
        GROUP BY bilhetes.eventoid;
        ";

        $eventosuser = DB::select($queryeventosuser);

                 
          

        return view('pulseiras.mostrapulseirashistorico',[
             'eventosuser' => $eventosuser, 
             'pulseira' => $pulseira, 
             'nrseriepulseira' => $request->nrseriepulseira, 
        ]);
    }

    public function showHistoricoEntradasSaidas(Request $request){
        $eventoid = $request->eventoid;
        $nrseriepulseira = $request->nrseriepulseira;
        $entradacheckbox = $request->entradacheckbox;
        $saidacheckbox = $request->saidacheckbox;
        $pulseira = DB::table('pulseiras')
                            ->where('nrseriepulseira',$nrseriepulseira)
                            ->get();
        

        if($eventoid!=0 && $entradacheckbox==1 && $saidacheckbox==1){
            $historicoEntradaSaida = DB::table('pulseiraslogs')
            ->where('pulseiraid',$pulseira[0]->idpulseira)
            ->where('eventoid',$eventoid)
            ->join('estadoslogpulseiras','estadoslogpulseiras.idestadopulseiralog','=','pulseiraslogs.estadopulseiralogid')
            ->join('eventos','eventos.idevento','=','pulseiraslogs.eventoid')
            ->paginate(5);
        }
        if($eventoid!=0 && $entradacheckbox==1 && $saidacheckbox==0){
            $historicoEntradaSaida = DB::table('pulseiraslogs')
            ->where('pulseiraid',$pulseira[0]->idpulseira)
            ->where('eventoid',$eventoid)
            ->where('estadopulseiralogid','1')
            ->join('estadoslogpulseiras','estadoslogpulseiras.idestadopulseiralog','=','pulseiraslogs.estadopulseiralogid')
            ->join('eventos','eventos.idevento','=','pulseiraslogs.eventoid')
            ->paginate(5);
        }
        if($eventoid!=0 && $entradacheckbox==0 && $saidacheckbox==1){
            $historicoEntradaSaida = DB::table('pulseiraslogs')
            ->where('pulseiraid',$pulseira[0]->idpulseira)
            ->where('eventoid',$eventoid)
            ->where('estadopulseiralogid','2')
            ->join('estadoslogpulseiras','estadoslogpulseiras.idestadopulseiralog','=','pulseiraslogs.estadopulseiralogid')
            ->join('eventos','eventos.idevento','=','pulseiraslogs.eventoid')
            ->paginate(5);
        }
        if($eventoid==0 && $entradacheckbox==1 && $saidacheckbox==1){
            $historicoEntradaSaida = DB::table('pulseiraslogs')
            ->where('pulseiraid',$pulseira[0]->idpulseira)
            ->join('estadoslogpulseiras','estadoslogpulseiras.idestadopulseiralog','=','pulseiraslogs.estadopulseiralogid')
            ->join('eventos','eventos.idevento','=','pulseiraslogs.eventoid')
            ->paginate(5);
        }

        if($eventoid==0 && $entradacheckbox==1 && $saidacheckbox==0){
            $historicoEntradaSaida = DB::table('pulseiraslogs')
            ->where('pulseiraid',$pulseira[0]->idpulseira)
            ->where('estadopulseiralogid','1')
            ->join('estadoslogpulseiras','estadoslogpulseiras.idestadopulseiralog','=','pulseiraslogs.estadopulseiralogid')
            ->join('eventos','eventos.idevento','=','pulseiraslogs.eventoid')
            ->paginate(5);
        } 

        if($eventoid==0 && $entradacheckbox==0 && $saidacheckbox==1){
            $historicoEntradaSaida = DB::table('pulseiraslogs')
            ->where('pulseiraid',$pulseira[0]->idpulseira)
            ->where('estadopulseiralogid','2')
            ->join('estadoslogpulseiras','estadoslogpulseiras.idestadopulseiralog','=','pulseiraslogs.estadopulseiralogid')
            ->join('eventos','eventos.idevento','=','pulseiraslogs.eventoid')
            ->paginate(5);
        }
        
        $output = '';

        foreach($historicoEntradaSaida as $historicoentsai){
            $output .= '
                <tr>
                ';

                if($historicoentsai->estadopulseiralogid == 1){
                    $output .= '<td><b>'.$historicoentsai->estadopulseiralog.' <i class="fas fa-sign-in-alt" style="transform: rotate(180deg)"></i> </b></td>
                    <td>'.$historicoentsai->evento.'</td>';
                }else{
                    $output .= '<td><b>'.$historicoentsai->estadopulseiralog.' <i class="fas fa-sign-in-alt"></i> </b></td>
                    <td>'.$historicoentsai->evento.'</td>';
                }
                
                    

                    if($historicoentsai->estadopulseiralogid == 1){
                        $output .= '<td>'.$historicoentsai->entrada_at.'</td>';
                    }else{
                        $output .= '<td>'.$historicoentsai->saida_at.'</td>';
                    }
                       
                    
                $output .= '</tr>';    
                            
        }

       $paginacao = '<div id="paginationsv">'.$historicoEntradaSaida->links().'</div>';
        
        return [$output,$paginacao]; 
        

    }


    public function showHistoricoEntradasSaidasPaginacao(Request $request){
        $eventoid = $request->eventoid;
        $nrseriepulseira = $request->nrseriepulseira;
        $entradacheckbox = $request->entradacheckbox;
        $saidacheckbox = $request->saidacheckbox;
        $pulseira = DB::table('pulseiras')
                            ->where('nrseriepulseira',$nrseriepulseira)
                            ->get();
        

        if($eventoid!=0 && $entradacheckbox==1 && $saidacheckbox==1){
            $historicoEntradaSaida = DB::table('pulseiraslogs')
            ->where('pulseiraid',$pulseira[0]->idpulseira)
            ->where('eventoid',$eventoid)
            ->join('estadoslogpulseiras','estadoslogpulseiras.idestadopulseiralog','=','pulseiraslogs.estadopulseiralogid')
            ->join('eventos','eventos.idevento','=','pulseiraslogs.eventoid')
            ->paginate(5);
        }
        if($eventoid!=0 && $entradacheckbox==1 && $saidacheckbox==0){
            $historicoEntradaSaida = DB::table('pulseiraslogs')
            ->where('pulseiraid',$pulseira[0]->idpulseira)
            ->where('eventoid',$eventoid)
            ->where('estadopulseiralogid','1')
            ->join('estadoslogpulseiras','estadoslogpulseiras.idestadopulseiralog','=','pulseiraslogs.estadopulseiralogid')
            ->join('eventos','eventos.idevento','=','pulseiraslogs.eventoid')
            ->paginate(5);
        }
        if($eventoid!=0 && $entradacheckbox==0 && $saidacheckbox==1){
            $historicoEntradaSaida = DB::table('pulseiraslogs')
            ->where('pulseiraid',$pulseira[0]->idpulseira)
            ->where('eventoid',$eventoid)
            ->where('estadopulseiralogid','2')
            ->join('estadoslogpulseiras','estadoslogpulseiras.idestadopulseiralog','=','pulseiraslogs.estadopulseiralogid')
            ->join('eventos','eventos.idevento','=','pulseiraslogs.eventoid')
            ->paginate(5);
        }
        if($eventoid==0 && $entradacheckbox==1 && $saidacheckbox==1){
            $historicoEntradaSaida = DB::table('pulseiraslogs')
            ->where('pulseiraid',$pulseira[0]->idpulseira)
            ->join('estadoslogpulseiras','estadoslogpulseiras.idestadopulseiralog','=','pulseiraslogs.estadopulseiralogid')
            ->join('eventos','eventos.idevento','=','pulseiraslogs.eventoid')
            ->paginate(5);
        }

        if($eventoid==0 && $entradacheckbox==1 && $saidacheckbox==0){
            $historicoEntradaSaida = DB::table('pulseiraslogs')
            ->where('pulseiraid',$pulseira[0]->idpulseira)
            ->where('estadopulseiralogid','1')
            ->join('estadoslogpulseiras','estadoslogpulseiras.idestadopulseiralog','=','pulseiraslogs.estadopulseiralogid')
            ->join('eventos','eventos.idevento','=','pulseiraslogs.eventoid')
            ->paginate(5);
        } 

        if($eventoid==0 && $entradacheckbox==0 && $saidacheckbox==1){
            $historicoEntradaSaida = DB::table('pulseiraslogs')
            ->where('pulseiraid',$pulseira[0]->idpulseira)
            ->where('estadopulseiralogid','2')
            ->join('estadoslogpulseiras','estadoslogpulseiras.idestadopulseiralog','=','pulseiraslogs.estadopulseiralogid')
            ->join('eventos','eventos.idevento','=','pulseiraslogs.eventoid')
            ->paginate(5);
        }
        
        $output = '';

        foreach($historicoEntradaSaida as $historicoentsai){
            $output .= '
                <tr>
                ';

                if($historicoentsai->estadopulseiralogid == 1){
                    $output .= '<td><b>'.$historicoentsai->estadopulseiralog.' <i class="fas fa-sign-in-alt" style="transform: rotate(180deg)"></i> </b></td>
                    <td>'.$historicoentsai->evento.'</td>';
                }else{
                    $output .= '<td><b>'.$historicoentsai->estadopulseiralog.' <i class="fas fa-sign-in-alt"></i> </b></td>
                    <td>'.$historicoentsai->evento.'</td>';
                }
                
                    

                    if($historicoentsai->estadopulseiralogid == 1){
                        $output .= '<td>'.$historicoentsai->entrada_at.'</td>';
                    }else{
                        $output .= '<td>'.$historicoentsai->saida_at.'</td>';
                    }
                       
                    
                $output .= '</tr>';    
                            
        }

       $paginacao = '<div id="paginationsv">'.$historicoEntradaSaida->links().'</div>';
        
        return [$output,$paginacao]; 
        

    }

    public function atualizahistoricopulseiras(Request $request){
        
        $pulseira = DB::table('pulseiras')
                            ->where('nrseriepulseira',$request->nrseriepulseira)
                            ->get();
        
        
        $userid = Auth::user()->id;

        $eventoid = $request->eventoid;

        if($eventoid!=0){
            $historicocompras = DB::table('compra_produtos')                                          
            ->join('compras','compras.idcompra','=','compra_produtos.compraid')                     
            ->join('produtos','produtos.idproduto','=','compra_produtos.produtoid')           
            ->select('compra_produtos.*','compras.*','produtos.produto','produtos.foto',DB::raw('sum(quantidade) as qtdtotal'))              
            ->whereIn('compraid',[DB::raw("SELECT idcompra FROM compras WHERE pulseiraid = ".$pulseira[0]->idpulseira." AND eventoid = ".$eventoid."")])
            ->orderBy('compras.datacompra','DESC')
            ->groupBy('compra_produtos.produtoid')            
            ->paginate(5);  
        }else{
            $historicocompras = DB::table('compra_produtos')                                          
            ->join('compras','compras.idcompra','=','compra_produtos.compraid')                     
            ->join('produtos','produtos.idproduto','=','compra_produtos.produtoid')       
            ->select('compra_produtos.*','compras.*','produtos.produto','produtos.foto',DB::raw('sum(quantidade) as qtdtotal'))                          
            ->whereIn('compraid',[DB::raw("SELECT idcompra FROM compras WHERE pulseiraid = ".$pulseira[0]->idpulseira."")])
            ->orderBy('compras.datacompra','DESC')
            ->groupBy('compra_produtos.produtoid')           
            ->paginate(5); 
        }

    $output = '';      
    if(count($historicocompras)>0){
            $output .= '<tr class="trprodutos centerhistoricopulseiras" >
            <th width="230">Foto</th>
            <th width="230">Produto</th>
            <th width="230">Qtd</th>
            <th width="230">Preco</th>
            <th width="230">Data</th>
        </tr>';

        
            foreach($historicocompras as $historicocompra){
                $preco = DB::table('produto_preco_evento')
                            ->where('produtoid',$historicocompra->produtoid)
                            ->where('eventoid',$historicocompra->eventoid)
                            ->get();
                $output .= ' <tr class="trprodutos">
                <td class="tdprodutos"><img src="/storage/imagens_produtos/'.$historicocompra->foto.'" alt="" /></td>
                <td class="tdprodutos">'.$historicocompra->produto.'</td>
                <td class="tdprodutos">'.$historicocompra->qtdtotal.'</td>
                <td class="tdprodutos">'.$preco[0]->preco.'€</td>
                <td class="tdprodutos tddata">'.$historicocompra->datacompra.'</td>
            </tr>';
            }
        }else{
            $output .= '<tr style="text-align: center;"><td><h3>Não tem historico de compras</h3></td></tr>';
        }

        $paginacao = '<div id="paginationsv">'.$historicocompras->links().'</div>';

        return [$output,$paginacao];
       
    }

    public function getHistoricoPulseirasPaginacao(Request $request){
        $pulseira = DB::table('pulseiras')
                            ->where('nrseriepulseira',$request->nrseriepulseira)
                            ->get();
        
        
        $userid = Auth::user()->id;

        $eventoid = $request->eventoid;

        if($eventoid!=0){
            $historicocompras = DB::table('compra_produtos')                                          
            ->join('compras','compras.idcompra','=','compra_produtos.compraid')                     
            ->join('produtos','produtos.idproduto','=','compra_produtos.produtoid')           
            ->select('compra_produtos.*','compras.*','produtos.produto','produtos.foto',DB::raw('sum(quantidade) as qtdtotal'))              
            ->whereIn('compraid',[DB::raw("SELECT idcompra FROM compras WHERE pulseiraid = ".$pulseira[0]->idpulseira." AND eventoid = ".$eventoid."")])
            ->groupBy('compra_produtos.produtoid')
            ->paginate(5);  
        }else{
            $historicocompras = DB::table('compra_produtos')                                          
            ->join('compras','compras.idcompra','=','compra_produtos.compraid')                     
            ->join('produtos','produtos.idproduto','=','compra_produtos.produtoid')       
            ->select('compra_produtos.*','compras.*','produtos.produto','produtos.foto',DB::raw('sum(quantidade) as qtdtotal'))                          
            ->whereIn('compraid',[DB::raw("SELECT idcompra FROM compras WHERE pulseiraid = ".$pulseira[0]->idpulseira."")])
            ->groupBy('compra_produtos.produtoid')
            ->paginate(5); 
        }

    $output = '';      
    if(count($historicocompras)>0){
            $output .= '<tr class="trprodutos centerhistoricopulseiras" >
            <th width="230">Foto</th>
            <th width="230">Produto</th>
            <th width="230">Qtd</th>
            <th width="230">Preco</th>
            <th width="230">Data</th>
        </tr>';

        
            foreach($historicocompras as $historicocompra){
                $preco = DB::table('produto_preco_evento')
                            ->where('produtoid',$historicocompra->produtoid)
                            ->where('eventoid',$historicocompra->eventoid)
                            ->get();
                $output .= ' <tr class="trprodutos">
                <td class="tdprodutos"><img src="/storage/imagens_produtos/'.$historicocompra->foto.'" alt="" /></td>
                <td class="tdprodutos">'.$historicocompra->produto.'</td>
                <td class="tdprodutos">'.$historicocompra->qtdtotal.'</td>
                <td class="tdprodutos">'.$preco[0]->preco.'€</td>
                <td class="tdprodutos tddata">'.$historicocompra->datacompra.'</td>
            </tr>';
            }
        }else{
            $output .= '<tr style="text-align: center;"><td><h3>Não tem historico de compras</h3></td></tr>';
        }

        $paginacao = '<div id="paginationsv">'.$historicocompras->links().'</div>';

        return [$output,$paginacao];
    }

    public function getPulseirasHistorico(Request $request){
        $userid = Auth::user()->id;


        $pulseirashistorico = DB::table('bilhetes')
                            ->join('eventos','eventos.idevento','=','bilhetes.eventoid')
                            ->join('pulseiras','pulseiras.idpulseira','=','bilhetes.pulseiraid')
                            ->where('bilhetes.userid',$userid)
                            ->where('bilhetes.estadobilheteid','1')
                            ->paginate(5);

        $output = '';

        if(count($pulseirashistorico)>0){  
            $output .= '<thead>
            <tr>
              <th scope="col">Nome Pulseira</th>
              <th scope="col">Nr Serie</th>
              <th scope="col">Plafond</th>
            
            </tr>
          </thead><tbody>';      
            foreach($pulseirashistorico as $pulseirahistorico){
                $output .= '<tr>
                <td>'.$pulseirahistorico->nomepulseira.'</td>
                <td>'.$pulseirahistorico->nrseriepulseira.'</td>
                <td>'.$pulseirahistorico->plafond.' €</td>
                <td style="text-align: center;"><button id="'.$pulseirahistorico->idbilhete.'" value="'.$pulseirahistorico->nrseriepulseira.'" class="btn btn-info selpulseira"><i class="fas fa-hand-pointer"></i></button></td>
            </tr>
            ';
            }
            
            $output .= '</tbody>';
            
        }else{
            $output .= '<h5 style="text-align: center;">Não tem pulseiras</h5>';
        }

        $paginacao = '<div id="paginationsv">'.$pulseirashistorico->links().'</div>';

        return [$output,$paginacao];
       
    }

    public function eventoacabapulseira(){
        $userid = Auth::user()->id;

        $eventosuser = DB::table('bilhetes')
                        ->where('userid',$userid)
                        ->groupby('eventoid')
                        ->get();
        
        foreach($eventosuser as $eventouser){
            $pulseiraseventouser = DB::table('bilhetes')
                            ->join('eventos','eventos.idevento','=','bilhetes.eventoid')
                            ->where('userid',$userid)
                            ->where('eventoid',$eventouser->eventoid)
                            ->get();
                           
            foreach($pulseiraseventouser as $pulseiraeventouser){
            
                $dateatual = new DateTime(date("Y/m/d")); 
                $datefimevento = new DateTime($pulseiraeventouser->datafim);  
                
                if($dateatual > $datefimevento){
                    DB::table('pulseiras')
                        ->where('idpulseira', $pulseiraeventouser->pulseiraid)
                        ->update(['estadopulseiraid' => "1"]);
                }
            }
        }
    }

    function getPulseirasPaginacao(Request $request){
        $userid = Auth::user()->id;


        $pulseirashistorico = DB::table('bilhetes')
                            ->join('eventos','eventos.idevento','=','bilhetes.eventoid')
                            ->join('pulseiras','pulseiras.idpulseira','=','bilhetes.pulseiraid')
                            ->where('bilhetes.userid',$userid)
                            ->where('bilhetes.estadobilheteid','1')
                            ->paginate(5);

        $output = '';

        if(count($pulseirashistorico)>0){  
            $output .= '<thead>
            <tr>
              <th scope="col">Nome Pulseira</th>
              <th scope="col">Nr Serie</th>
              <th scope="col">Plafond</th>
            
            </tr>
          </thead><tbody>';      
            foreach($pulseirashistorico as $pulseirahistorico){
                $output .= '<tr>
                <td>'.$pulseirahistorico->nomepulseira.'</td>
                <td>'.$pulseirahistorico->nrseriepulseira.'</td>
                <td>'.$pulseirahistorico->plafond.' €</td>
                <td style="text-align: center;"><button id="'.$pulseirahistorico->idbilhete.'" value="'.$pulseirahistorico->nrseriepulseira.'" class="btn btn-info selpulseira"><i class="fas fa-hand-pointer"></i></button></td>
            </tr>
            ';
            }
            
            $output .= '</tbody>';
            
        }else{
            $output .= '<h5 style="text-align: center;">Não tem pulseiras</h5>';
        }

       /*  $output .= $pulseirashistorico->links(); */
        $paginacao = '<div id="paginationsv">'.$pulseirashistorico->links().'</div>';

        return [$output,$paginacao];
    }
}
