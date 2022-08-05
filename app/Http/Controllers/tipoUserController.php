<?php

namespace App\Http\Controllers;

use App\tipouser;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use DB;

class tipoUserController extends Controller
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
            $data = tipouser::all();
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->idTipoUser.'" class="edit btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></button>';
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->idTipoUser.'" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('CRUD.tipousers');
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
            'Nome'    =>  'required',
            'Descricao'     =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Nome'        =>  $request->Nome,
            'Descricao'         =>  $request->Descricao
        );

        tipouser::create($form_data);

        return response()->json(['success' => 'Informação adicionada com sucesso.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tipouser  $tipouser
     * @return \Illuminate\Http\Response
     */
    public function show(tipouser $tipouser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tipouser  $tipouser
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = tipouser::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tipouser  $tipouser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tipouser $tipouser)
    {
        
        $rules = array(
            'Nome'        =>  'required',
            'Descricao'         =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'Nome'    =>  $request->Nome,
            'Descricao'     =>  $request->Descricao
        );
        
        tipouser::whereidtipouser($request->hidden_id)->update($form_data);
        
        return response()->json(['success' => 'Informação atualizada com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tipouser  $tipouser
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = tipouser::findOrFail($id);
        $data->delete();

        //Resetar o auto increment
        $total = tipouser::all();
        $query = 'ALTER TABLE tipousers AUTO_INCREMENT = '.(count($total)+1);
        DB::statement($query);
    }
}
