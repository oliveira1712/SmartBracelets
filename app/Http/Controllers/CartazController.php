<?php

namespace App\Http\Controllers;

use App\Cartaz;
use App\Artista;
use App\eventos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Validator;
use DB;


class CartazController extends Controller
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
            $data = DB::select("SELECT cartazes.*,eventos.evento,artistas.artista
            FROM cartazes,eventos,artistas
            WHERE cartazes.ideventoc=eventos.idevento
            AND cartazes.idartistac=artistas.idartista");
            
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" value="'.$data->idartistac.'" name="edit" id="'.$data->ideventoc.'" class="edit btn btn-primary btn-sm nols"><i class="fas fa-pencil-alt"></i></button>';
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" value="'.$data->idartistac.'" name="edit" id="'.$data->ideventoc.'" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            
        }
        
        
        /* <input type="text" id="aux" name="aux" class="aux" value="'.$data->idartistac.'">*/
        $eventos = eventos::all();
        $artistas = Artista::all();
        return view('CRUD.cartazes',[
            'eventos' => $eventos,
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
        try{
            $rules = array(
                'ideventoc'    =>  'required',
                'idartistac'     =>  'required',
                'local'    =>  'required',
                'datainicio'     =>  'required',
                'datafim'     =>  'required',
                'horainicio'     =>  'required',
                'horafim'     =>  'required'
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

            $form_data = array(
                'ideventoc'        =>  $request->ideventoc,
                'idartistac'         =>  $request->idartistac,
                'local'        =>  $request->local,
                'datainicio'         =>  $request->datainicio,
                'datafim'        =>  $request->datafim,
                'horainicio'         =>  $request->horainicio,
                'horafim'         =>  $request->horafim
            );

            Cartaz::create($form_data);

            return response()->json(['success' => 'Informação adicionada com sucesso.']);
        } catch(\Exception $e){
            if(strpos($e->getMessage(), '1062 Duplicate entry') !== false){
                return response()->json(['warning' => 'Esse cartaz já existe. O seu cartaz nao foi inserido']);
            } 
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cartaz  $cartaz
     * @return \Illuminate\Http\Response
     */
    public function show(Cartaz $cartaz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cartaz  $cartaz
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$id1)
    {
        if(request()->ajax())
        {
            $data = Cartaz::where('ideventoc', $id)->
            where('idartistac',$id1)->firstOrFail();
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cartaz  $cartaz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cartaz $cartaz)
    {
        $rules = array(
            'ideventoc'    =>  'required',
            'idartistac'     =>  'required',
            'local'    =>  'required',
            'datainicio'     =>  'required',
            'datafim'     =>  'required',
            'horainicio'     =>  'required',
            'horafim'     =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'ideventoc'        =>  $request->ideventoc,
            'idartistac'         =>  $request->idartistac,
            'local'        =>  $request->local,
            'datainicio'         =>  $request->datainicio,
            'datafim'        =>  $request->datafim,
            'horainicio'         =>  $request->horainicio,
            'horafim'         =>  $request->horafim
        );
        
        try{
            
            Cartaz::where('ideventoc', $request->hidden_id)
            ->where('idartistac',$request->hidden_id1)
            ->update($form_data);
        }catch(\Exception $e){
            if(strpos($e->getMessage(), '1062 Duplicate entry') !== false){
                return response()->json(['warning' => 'Esse cartaz já existe. O seu cartaz nao foi alterado']);
            } 
            
        }
        
        
        return response()->json(['success' => 'Informação atualizada com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cartaz  $cartaz
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$id1)
    {
        DB::delete('DELETE FROM Cartazes WHERE ideventoc = '.$id. ' AND idartistac = '.$id1);
    }
}
