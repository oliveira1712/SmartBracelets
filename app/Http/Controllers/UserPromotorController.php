<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Promotor;

class UserPromotorController extends Controller
{
    public function index(){

        $eventos = DB::table('eventos')
                ->where('tpeventolugarid','2')
                ->get();

        $promotores = Promotor::all();

        return view('promotor.promovereventos',[
            'eventos' => $eventos,
            'promotores' => $promotores,          
        ]);
    }

    public function promoverEvento(Request $request){

        $idevento = $request->idevento;
        $idpromotor = $request->idpromotor;
        $descricao = $request->descricao;

        $eventopromotor = DB::table('eventospromotores')
                ->where('eventoid',$idevento)
                ->where('promotorid',$idpromotor)
                ->get();

        if(count($eventopromotor)>0){
            return 0;
        }else{
            DB::table('eventospromotores')->insert([
                [
                    'eventoid' => $idevento,
                    'promotorid'=> $idpromotor,
                    'descricao' => $descricao
                    
                ]
            ]);
            return 1;
        }

    }
}
