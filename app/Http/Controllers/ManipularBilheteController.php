<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pulseira;
use DB;
use Auth;
use Redirect;
use DateTime;

class ManipularBilheteController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('eventos.comprarbilhete',[
            
        ]);
    }

    public function indexcheckout()
    {
        $userid = Auth::user()->id;

        $querybilhetescheckout = "SELECT bilhetes.*, COUNT(idbilhete) as nrbilhetes, eventos.evento, eventos.foto
        FROM bilhetes,eventos
        WHERE userid=$userid
        AND bilhetes.eventoid=eventos.idevento
        AND bilhetes.estadobilheteid=1
        GROUP BY bilhetes.eventoid ASC";

        $bilhetescheckout = DB::select($querybilhetescheckout);
        
        return view('shopcart.checkout',[
            'bilhetescheckout' => $bilhetescheckout,
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

    public function getPulseiras(Request $request){
        $eventoid = $request->eventoid;
        $userid = Auth::user()->id;
                
        $pulseirasbilhetes = DB::table('bilhetes')
                                ->where('userid',$userid)
                                ->where('eventoid',$eventoid)
                                ->paginate(5);
        
        $output = '';

        foreach($pulseirasbilhetes as $pulseirabilhete){

            $querypulseira = "SELECT * FROM pulseiras WHERE idpulseira = $pulseirabilhete->pulseiraid";
            $pulseira = DB::select($querypulseira);

            $output .= '<tr>
            <th scope="row">'.$pulseira[0]->nrseriepulseira.'</th>
            <td>'.$pulseira[0]->plafond.'€</td>
            <td>'.$pulseira[0]->nomepulseira.'</td>
            <td><button class="btn btn-primary btneditarnome" id='.$pulseira[0]->idpulseira.' data-toggle="modal" data-target="#changeNameModal" data-value="'.$pulseirabilhete->eventoid.'" data-id="'.$pulseira[0]->idpulseira.'">
			<i class="fas fa-user-edit"></i>
		</button></td>
            <!--<td>'.$pulseira[0]->descricao.'</td>-->
          </tr>';
          
        }

        $paginacao = '<div id="paginationsv">'.$pulseirasbilhetes->links().'</div>';

        return [$output,$paginacao];
    

    }

    public function getPulseirasPaginacaoCheckOut(Request $request){
        $eventoid = $request->eventoid;
        $userid = Auth::user()->id;
                
        $pulseirasbilhetes = DB::table('bilhetes')
                                ->where('userid',$userid)
                                ->where('eventoid',$eventoid)
                                ->paginate(5);
        
        $output = '';

        foreach($pulseirasbilhetes as $pulseirabilhete){

            $querypulseira = "SELECT * FROM pulseiras WHERE idpulseira = $pulseirabilhete->pulseiraid";
            $pulseira = DB::select($querypulseira);

            $output .= '<tr>
            <th scope="row">'.$pulseira[0]->nrseriepulseira.'</th>
            <td>'.$pulseira[0]->plafond.'€</td>
            <td>'.$pulseira[0]->nomepulseira.'</td>
            <td><button class="btn btn-primary btneditarnome" id='.$pulseira[0]->idpulseira.' data-toggle="modal" data-target="#changeNameModal" data-value="'.$pulseirabilhete->eventoid.'" data-id="'.$pulseira[0]->idpulseira.'">
			<i class="fas fa-user-edit"></i>
		</button></td>
            <!--<td>'.$pulseira[0]->descricao.'</td>-->
          </tr>';
          
        }

        $paginacao = '<div id="paginationsv">'.$pulseirasbilhetes->links().'</div>';

        return [$output,$paginacao];
    }

    
    public function buyTicket(Request $request){
        $userid = $request->iduser;
        $eventoid = $request->idevento;

        $pulseiras = Pulseira::where('estadopulseiraid','1')
                    ->whereNotIn('idpulseira',[DB::raw("SELECT pulseiraid FROM bilhetes")])
                    ->get();

        $username = Auth::user()->name;

        if(count($pulseiras)>0){
            $pulseira = $pulseiras->last();
        }
        else{
           return 0;
        }
        echo($pulseira->idpulseira);
        
        try{
            DB::table('bilhetes')->insert([
                [
                    'eventoid'=> $eventoid,
                    'userid'=> $userid,
                    'pulseiraid'=> $pulseira->idpulseira,                   
                ]
            ]);
            DB::update("UPDATE pulseiras SET estadopulseiraid=2 WHERE idpulseira=". $pulseira->idpulseira);
            DB::update("UPDATE pulseiras 
            SET nomepulseira= 'Pulseira$username$pulseira->idpulseira' WHERE idpulseira=". $pulseira->idpulseira);
        }catch(\Exception $e){
            echo $e->getMessage();
        }

    }


    public function removeTicket(Request $request){
        $userid = $request->iduser;
        $eventoid = $request->idevento;              
        $pulseiraid = $request->idpulseira;

        $bilhete = DB::table('bilhetes')
                    ->where('userid',$userid)
                    ->where('eventoid',$eventoid)
                    ->where('pulseiraid',$pulseiraid)
                    ->get();
        

        try{
            if($bilhete[0]->estadobilheteid!=1){
                DB::delete("DELETE FROM bilhetes WHERE eventoid = ".$eventoid." AND userid = ".$userid. " AND pulseiraid = ".$pulseiraid);
                DB::update("UPDATE pulseiras SET estadopulseiraid=1 WHERE idpulseira=". $pulseiraid);
                DB::update("UPDATE pulseiras SET nomepulseira= null WHERE idpulseira=". $pulseiraid);
                //Resetar o auto increment
                $total = DB::select("SELECT * FROM bilhetes");
                $query = 'ALTER TABLE bilhetes AUTO_INCREMENT = '.(count($total)+1);
                DB::statement($query);
            }
        }catch(\Exception $e){
            echo $e->getMessage();
        }

    }

    public function removeTickets(Request $request){
        $userid = $request->iduser;
        $eventoid = $request->idevento;              
        try{
            $bilheteseventouser = DB::select("SELECT * FROM bilhetes WHERE eventoid = ".$eventoid." AND userid = ".$userid." AND estadobilheteid != 1");
            foreach($bilheteseventouser as $bilheteeventouser){
                DB::update("UPDATE pulseiras SET estadopulseiraid=1 WHERE idpulseira=". $bilheteeventouser->pulseiraid);
                DB::update("UPDATE pulseiras SET nomepulseira= null WHERE idpulseira=". $bilheteeventouser->pulseiraid);
            }
            DB::delete("DELETE FROM bilhetes WHERE eventoid = ".$eventoid." AND userid = ".$userid." AND estadobilheteid != 1");

            //Resetar o auto increment
            $total = DB::select("SELECT * FROM bilhetes");
            $query = 'ALTER TABLE bilhetes AUTO_INCREMENT = '.(count($total)+1);
            DB::statement($query);
            
        }catch(\Exception $e){
            echo $e->getMessage();
        }

    }

    public function countTickets(Request $request){
        $userid = $request->iduser;
        $bilhetesuser = DB::select("SELECT * FROM bilhetes WHERE userid = ".$userid." AND estadobilheteid != 1");

        return count($bilhetesuser);
    }

    public function getBilhetesCheckOut(Request $request){
        $userid = Auth::user()->id;

        $querybilhetescheckout = "SELECT bilhetes.*, COUNT(idbilhete) as nrbilhetes, eventos.*
        FROM bilhetes,eventos
        WHERE userid=$userid
        AND bilhetes.eventoid=eventos.idevento
        AND bilhetes.estadobilheteid=1
        GROUP BY bilhetes.eventoid ASC";

        $querybilhetes = "SELECT bilhetes.*, COUNT(idbilhete) as nrbilhetes, eventos.*
        FROM bilhetes,eventos
        WHERE userid=$userid
        AND bilhetes.eventoid=eventos.idevento
        GROUP BY bilhetes.eventoid ASC";

      

        $querybilhetescheckoutverifica = "SELECT *
        FROM bilhetes
        WHERE userid = $userid
        AND estadobilheteid = 2";


        $bilhetescheckout = DB::select($querybilhetescheckout);
        $bilhetes = DB::select($querybilhetes);
        
        $bilhetescheckoutverifica = DB::select($querybilhetescheckoutverifica);
        $output = '';

        if (!$bilhetescheckout && !$bilhetes){
            $output .= '<div class="col-md-12 col-12" >
            
                <div class="alert alert-info" role="alert" style="font-size: 2em; text-align: center;">
                Ainda não comprou bilhetes!
                <br>
                <i class="fas fa-ticket-alt sembilhetes"></i>
                <i class="fas fa-ticket-alt sembilhetes"></i>
                <i class="fas fa-ticket-alt sembilhetes"></i>
                </div>
            </div>
            </div>';
        }
        elseif (!$bilhetescheckout && $bilhetes ){
            $output .= '<div class="col-md-12 col-12">
            <div class="alert alert-primary" role="alert" style="font-size: 2em; text-align: center;">
                Ainda não fez o checkout dos bilhetes!
                <br>
                <i class="fas fa-ticket-alt sembilhetes"></i>
                <i class="fas fa-ticket-alt sembilhetes"></i>
                <i class="fas fa-ticket-alt sembilhetes"></i>
            </div>
            </div>
            </div>';
        }

        if ($bilhetescheckout){
            if(count($bilhetescheckoutverifica)){
               $output .= ' <div class="col-md-12 col-12">
                <div class="alert alert-warning" role="alert" style="font-size: 2em; text-align: center;">
                    Ainda não fez o checkout de todos bilhetes!
                    <br>
                    <i class="fas fa-ticket-alt sembilhetes"></i>
                    <i class="fas fa-ticket-alt sembilhetes"></i>
                    <i class="fas fa-ticket-alt sembilhetes"></i>
                </div>
                </div>
                </div>';
            }
           
                
                    foreach ($bilhetescheckout as $bilhetecheckout){
                    
                        if (count($bilhetescheckout)==2){
                           $output .= ' <div class="col-md-6 col-12 ">';
                        }else if(count($bilhetescheckout)>2 ){
                            $output .= ' <div class="col-md-4 col-12 ">';
                        }
                        else{
                            $output .= ' <div class="col-md-12 col-12 ">';
                        }
                        
                        $output .= '<div class="card-checkout">
                            <img src="/storage/imagens_eventos/'.$bilhetecheckout->foto.'" alt="">
                            <h2 class="my-3" style="font-size: 1.7em;">'. $bilhetecheckout->evento .'</h2>
                            
                            <div class="actions" style="text-align: center;">
                            <p class="actions__like txtstyle" >Preço <i class="fas fa-euro-sign"></i> <br> <span style="color: #c59d5f;"> '.$bilhetecheckout->preco.'</span> </p>
                            <p class="actions__trade txtstyle"  >Quantidade <i class="fas fa-balance-scale"></i> <br> <span style="color: #c59d5f;"> '. $bilhetecheckout->nrbilhetes .' </span></p>
                            <p class="actions__cancel txtstyle"  >Total <i class="fas fa-euro-sign"></i><i class="fas fa-euro-sign"></i> <br> <span style="color: #c59d5f;"> '. $bilhetecheckout->preco * $bilhetecheckout->nrbilhetes .' </span> </p>
                            </div>
                            <div class="buttonsblob">
			<button class="blob-btn verpulseirabtn" id='.$bilhetecheckout->eventoid.' data-toggle="modal" data-target="#checkoutpulseirasModal" data-id="'.$bilhetecheckout->eventoid.'">
				Ver pulseiras
				<span class="blob-btn__inner">
					<span class="blob-btn__blobs">
						<span class="blob-btn__blob"></span>
						<span class="blob-btn__blob"></span>
						<span class="blob-btn__blob"></span>
						<span class="blob-btn__blob"></span>
					</span>
				</span>
			</button>
			<br />

			<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="1" height="1">
				<defs>
					<filter id="goo">
						<feGaussianBlur
							in="SourceGraphic"
							result="blur"
							stdDeviation="10"
						></feGaussianBlur>
						<feColorMatrix
							in="blur"
							mode="matrix"
							values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 21 -7"
							result="goo"
						></feColorMatrix>
						<feBlend in2="goo" in="SourceGraphic" result="mix"></feBlend>
					</filter>
				</defs>
			</svg>
		</div>'; 
                            
                 
        
        $output .= '</div>        
        </div>';               

                      
        }
                
            
        }

        return $output;
    }

    public function getBilhetes(Request $request){
        
        $userid = $request->iduser;

        $querybilhetes = "SELECT bilhetes.*, COUNT(idbilhete) as nrbilhetes, eventos.evento, eventos.preco
        FROM bilhetes,eventos
        WHERE userid=$userid
        AND bilhetes.eventoid=eventos.idevento
        AND bilhetes.estadobilheteid != 1
        GROUP BY bilhetes.eventoid ASC";
        
        $bilhetes = DB::select($querybilhetes);
        // Para ir buscar os bilhetes
        
        $output = '<h2 class="cartfontstyle">Cart <i class="fas fa-cart-arrow-down"></i></h2>
		<ul class="cd-cart-items" id="itemscarrinho">';
        $total = 0;
        if($bilhetes){
            foreach($bilhetes as $bilhete){
            
                $querynomeevento = DB::select("SELECT evento,foto,preco FROM eventos WHERE idevento = ". $bilhete->eventoid);
                $nomeevento = $querynomeevento[0]->evento;
                
                

                $output .= '<li class="aumentaletra lishopcart styleshopcart" id="lievnt'.$bilhete->eventoid.'">
                <div class="container contshopcart" style="flex-direction: column;">
                    <div class="row" style="margin-left: 1%;">
                    <div class="col-md-6 widthcrudbts">
                        <img src="/storage/imagens_eventos/'.$querynomeevento[0]->foto.'" alt="" style="border-radius: 50%; width: 50px; height: 50px; margin-bottom: 1%;">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <button type="button" id="'.$bilhete->eventoid.'" name="'.$bilhete->pulseiraid.'" class="btn bg-light border rounded-circle plusbtn retirar"><i class="fas fa-minus maismenos"></i></button>
                    <input type="text" disabled class="form-control text-align-center qtd" name="qtd'.$bilhete->idbilhete.'" id="qtd'.$bilhete->idbilhete.'" value="'.$bilhete->nrbilhetes.'">
                    <button type="button" id="'.$bilhete->eventoid.'" class="btn bg-light border rounded-circle minusbtn adicionar"><i class="fas fa-plus maismenos"></i></button> 
                    <p style="margin-left: 5px;">'.$bilhete->evento.'</p>
                    
                    
                    <div class="cd-price" style="margin-left: 5px;">'.$bilhete->preco.'€</div>
                    </div>
                    
                </div>
                <a href="#0" id="'.$bilhete->eventoid.'" class="cd-item-remove cd-img-replace removerbilhetes">Remove</a>
                
            </li>';

                $total = $total + ( $querynomeevento[0]->preco * $bilhete->nrbilhetes);
                        
            }
            
            
            $output .= '</ul> 

            <div class="cd-cart-total ">
                <p class="totalinclet" >Total <span>'.$total.' €</span></p>
            </div>
            
            <a href="/eventos/realizarcheckoutbilhetes" class="checkout-btn" style="font-size: 1.7em;">Checkout</a>
            
            ';
        }else{
            $output .= '
            <hr>
            <br>
            <h2 style="text-align: center; font-size: 1.5em;" >Sem itens no carrinho</h2>
            <br>
            <br>
            <br>
            <br>
            
            <img style="" src="/storage/imgsExtra/carrinhocomprasvazio.jpg" alt="Card image cap">
            
            ';
            
            
        }

        return $output;
    }

    public function checkoutbilhetes(Request $request){
        $userid = Auth::user()->id;

        DB::update("UPDATE bilhetes SET estadobilheteid = 1 WHERE userid = ".$userid);
        
        return Redirect::action('ManipularBilheteController@indexcheckout');
    }

    public function getNomePulseira(Request $request){
        $pulseiraid = $request->pulseiraid;

        $nome = DB::select("SELECT * FROM pulseiras WHERE idpulseira = " . $pulseiraid);

        return $nome[0]->nomepulseira;
    }


    public function changeNomePulseira(Request $request){
        $pulseiraid = $request->pulseiraid;
        $nomepulseira = $request->nomepulseira;
        $nome = DB::update("UPDATE pulseiras SET nomepulseira = '$nomepulseira' WHERE idpulseira = $pulseiraid" );

    }
}
