<?php

namespace App\Http\Controllers;

use App\EventoPromotor;
use App\eventos;
use App\Promotor;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use DB;

class EventoPromotorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = DB::select('SELECT eventospromotores.*,eventos.evento,promotores.promotor 
            FROM eventospromotores,eventos,promotores
            WHERE eventospromotores.eventoid=eventos.idevento
            AND eventospromotores.promotorid=promotores.idpromotor');
            
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" value="'.$data->eventoid.'" name="edit" id="'.$data->promotorid.'" class="edit btn btn-primary btn-sm nols"><i class="fas fa-pencil-alt"></i></button>';
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" value="'.$data->eventoid.'" name="edit" id="'.$data->promotorid.'" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            
        }
        
        
        /* <input type="text" id="aux" name="aux" class="aux" value="'.$data->idartistac.'">*/
        $eventos = eventos::all();
        $promotores = Promotor::all();
        return view('CRUD.eventospromotores',[
            'eventos' => $eventos,
            'promotores' => $promotores,
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
        try{
            $rules = array(
                'eventoid'    =>  'required',
                'promotorid'     =>  'required'
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

            $form_data = array(
                'eventoid'        =>  $request->eventoid,
                'promotorid'         =>  $request->promotorid,
                'descricao'         =>  $request->descricao
            );

            EventoPromotor::create($form_data);

            return response()->json(['success' => 'Informação adicionada com sucesso.']);
        } catch(\Exception $e){
            if(strpos($e->getMessage(), '1062 Duplicate entry') !== false){
                return response()->json(['warning' => 'Esse promotor já está a promover esse evento. O seu registo nao foi inserido']);
            } 
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EventoPromotor  $eventoPromotor
     * @return \Illuminate\Http\Response
     */
    public function show(EventoPromotor $eventoPromotor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EventoPromotor  $eventoPromotor
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$id1)
    {
        if(request()->ajax())
        {
            $data = EventoPromotor::where('promotorid', $id)->
            where('eventoid',$id1)->firstOrFail();
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EventoPromotor  $eventoPromotor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventoPromotor $eventoPromotor)
    {
        $rules = array(
            'eventoid'    =>  'required',
            'promotorid'     =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'eventoid'        =>  $request->eventoid,
            'promotorid'         =>  $request->promotorid,
            'descricao'         =>  $request->descricao
        );
        
        try{
            EventoPromotor::where('promotorid', $request->hidden_id)
            ->where('eventoid',$request->hidden_id1)
            ->update($form_data);
        }catch(\Exception $e){
            if(strpos($e->getMessage(), '1062 Duplicate entry') !== false){
                return response()->json(['warning' => 'Esse promotor já está a promover esse evento. O seu registo nao foi alterado']);
            } 
            
        }
        
        
        return response()->json(['success' => 'Informação atualizada com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EventoPromotor  $eventoPromotor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$id1)
    {
        DB::delete('DELETE FROM eventospromotores WHERE promotorid = '.$id. ' AND eventoid = '.$id1);
    }
}
