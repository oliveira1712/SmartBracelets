<?php

namespace App\Http\Controllers;

use App\PrecoEvento;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use DB;

class PrecoEventoController extends Controller
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
            $data = DB::select("SELECT * FROM precoeventos, eventos WHERE precoeventos.eventoid = eventos.idevento");
            
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->eventoid.'" class="edit btn btn-primary btn-sm nols"><i class="fas fa-pencil-alt"></i></button>';
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->eventoid.'" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            
        }

        $eventossm = DB::table('eventos')
                    ->get();
        
        return view('CRUD.precoeventos',[
            'eventossm' => $eventossm,
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
        $rules = array(
            'eventoid'    =>  'required',
            'preco'     =>  'required|numeric|between:0,10000.99'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'eventoid'        =>  $request->eventoid,
            'preco'         =>  $request->preco
        );

        try{
            PrecoEvento::create($form_data);
        }catch(\Exception $e){
            if(strpos($e->getMessage(), '1062 Duplicate entry') !== false){
                return response()->json(['warning' => 'O preço para esse evento já esta associado!']);
            } 
        }
        

        return response()->json(['success' => 'Informação adicionada com sucesso.']);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PrecoEvento  $precoEvento
     * @return \Illuminate\Http\Response
     */
    public function show(PrecoEvento $precoEvento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PrecoEvento  $precoEvento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = PrecoEvento::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PrecoEvento  $precoEvento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PrecoEvento $precoEvento)
    {
        $rules = array(
            'eventoid'    =>  'required',
            'preco'     =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'eventoid'        =>  $request->eventoid,
            'preco'         =>  $request->preco
        );
        
        try{
            PrecoEvento::whereeventoid($request->hidden_id)->update($form_data);
        }catch(\Exception $e){
            if(strpos($e->getMessage(), '1062 Duplicate entry') !== false){
                return response()->json(['warning' => 'O preço para esse evento já esta associado!']);
            } 
        }

        
        
        return response()->json(['success' => 'Informação atualizada com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PrecoEvento  $precoEvento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = PrecoEvento::findOrFail($id);
        $data->delete();

        //Resetar o auto increment
        $total = PrecoEvento::all();
        $query = 'ALTER TABLE precoeventos AUTO_INCREMENT = '.(count($total)+1);
        DB::statement($query);
    }
}
