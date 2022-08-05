<?php

namespace App\Http\Controllers;

use App\Promotor;
use App\TipoPromotor;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use DB;

class PromotorController extends Controller
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
            $data = DB::select('SELECT promotores.*,tipopromotores.tipopromotor
            FROM promotores,tipopromotores
            WHERE promotores.tipopromotorid=tipopromotores.idtppromotor');
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->idpromotor.'" class="edit btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></button>';
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->idpromotor.'" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $tipopromotores = TipoPromotor::all();

        return view('CRUD.promotores',[
            'tipopromotores' => $tipopromotores,
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
            'promotor'    =>  'required',
            'tipopromotorid'    =>  'required',
            'descricao'     =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'promotor'        =>  $request->promotor,
            'tipopromotorid'        =>  $request->tipopromotorid,
            'descricao'         =>  $request->descricao
        );

        Promotor::create($form_data);

        return response()->json(['success' => 'Informação adicionada com sucesso.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Promotor  $promotor
     * @return \Illuminate\Http\Response
     */
    public function show(Promotor $promotor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Promotor  $promotor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Promotor::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Promotor  $promotor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promotor $promotor)
    {
        $rules = array(
            'promotor'    =>  'required',
            'tipopromotorid'    =>  'required',
            'descricao'     =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'promotor'        =>  $request->promotor,
            'tipopromotorid'        =>  $request->tipopromotorid,
            'descricao'         =>  $request->descricao
        );
        
        Promotor::whereidpromotor($request->hidden_id)->update($form_data);
        
        return response()->json(['success' => 'Informação atualizada com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Promotor  $promotor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Promotor::findOrFail($id);
        $data->delete();


        //Resetar o auto increment
        $total = Promotor::all();
        $query = 'ALTER TABLE promotores AUTO_INCREMENT = '.(count($total)+1);
        DB::statement($query);
    }
}
