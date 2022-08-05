<?php

namespace App\Http\Controllers;

use App\TipoPromotor;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use DB;

class TipoPromotorController extends Controller
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
            $data = TipoPromotor::all();
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->idtppromotor.'" class="edit btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></button>';
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->idtppromotor.'" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('CRUD.tipopromotores');
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
            'tipopromotor'    =>  'required',
            'descricao'     =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tipopromotor'        =>  $request->tipopromotor,
            'descricao'         =>  $request->descricao
        );

        TipoPromotor::create($form_data);

        return response()->json(['success' => 'Informação adicionada com sucesso.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TipoPromotor  $tipoPromotor
     * @return \Illuminate\Http\Response
     */
    public function show(TipoPromotor $tipoPromotor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TipoPromotor  $tipoPromotor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = TipoPromotor::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoPromotor  $tipoPromotor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoPromotor $tipoPromotor)
    {
        $rules = array(
            'tipopromotor'        =>  'required',
            'descricao'         =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tipopromotor'    =>  $request->tipopromotor,
            'descricao'     =>  $request->descricao
        );
        
        TipoPromotor::whereidtppromotor($request->hidden_id)->update($form_data);
        
        return response()->json(['success' => 'Informação atualizada com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoPromotor  $tipoPromotor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = TipoPromotor::findOrFail($id);
        $data->delete();

        //Resetar o auto increment
        $total = TipoPromotor::all();
        $query = 'ALTER TABLE tipopromotores AUTO_INCREMENT = '.(count($total)+1);
        DB::statement($query);
    }
}
