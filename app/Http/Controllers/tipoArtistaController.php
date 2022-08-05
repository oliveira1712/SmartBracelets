<?php

namespace App\Http\Controllers;

use App\tipoartista;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use DB;

class tipoArtistaController extends Controller
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
            $data = tipoartista::all();
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->idtpartista.'" class="edit btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></button>';
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->idtpartista.'" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('CRUD.tipoartistas');
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
            'tipoartista'    =>  'required',
            'descricao'     =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tipoartista'        =>  $request->tipoartista,
            'descricao'         =>  $request->descricao
        );

        tipoartista::create($form_data);

        return response()->json(['success' => 'Informação adicionada com sucesso.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tipoartista  $tipoartista
     * @return \Illuminate\Http\Response
     */
    public function show(tipoartista $tipoartista)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tipoartista  $tipoartista
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = tipoartista::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tipoartista  $tipoartista
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tipoartista $tipoartista)
    {
        $rules = array(
            'tipoartista'        =>  'required',
            'descricao'         =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tipoartista'    =>  $request->tipoartista,
            'descricao'     =>  $request->descricao
        );
        
        tipoartista::whereidtpartista($request->hidden_id)->update($form_data);
        
        return response()->json(['success' => 'Informação atualizada com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tipoartista  $tipoartista
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = tipoartista::findOrFail($id);
        $data->delete();

        //Resetar o auto increment
        $total = tipoartista::all();
        $query = 'ALTER TABLE tipoartistas AUTO_INCREMENT = '.(count($total)+1);
        DB::statement($query);
    }
}
