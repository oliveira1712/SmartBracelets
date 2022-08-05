<?php

namespace App\Http\Controllers;

use App\PrecoProdutosEventos;
use App\eventos;
use App\Produto;
use DB;
use Illuminate\Http\Request;
use DataTables;
use Validator;

class PrecoProdutosEventosController extends Controller
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
            $data = DB::select("SELECT produto_preco_evento.*,eventos.evento,produtos.produto 
            FROM `produto_preco_evento`,produtos,eventos
            WHERE produtoid = produtos.idproduto
            AND eventoid = eventos.idevento");
            
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" value="'.$data->produtoid.'" name="edit" id="'.$data->eventoid.'" class="edit btn btn-primary btn-sm nols"><i class="fas fa-pencil-alt"></i></button>';
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" value="'.$data->produtoid.'" name="edit" id="'.$data->eventoid.'" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            
        }
        
      
        $eventos = DB::table('eventos')
                    ->where('tpeventolugarid','2')
                    ->get();
        $produtos = Produto::all();
        return view('CRUD.precoprodutoseventos',[
            'eventos' => $eventos,
            'produtos' => $produtos,
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
                'preco'     =>  'required|numeric|between:0,10000.99',
                'eventoid'     =>  'required',
                'produtoid'    =>  'required'
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

            $form_data = array(
                'preco'        =>  $request->preco,
                'eventoid'         =>  $request->eventoid,
                'produtoid'        =>  $request->produtoid
            );

        try{
            PrecoProdutosEventos::create($form_data);

            return response()->json(['success' => 'Registo adicionado com sucesso.']);
        } catch(\Exception $e){
            if(strpos($e->getMessage(), '1062 Duplicate entry') !== false){
                return response()->json(['warning' => 'O preço desse produto para esse evento ja está associado']);
            } 
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PrecoProdutosEventos  $precoProdutosEventos
     * @return \Illuminate\Http\Response
     */
    public function show(PrecoProdutosEventos $precoProdutosEventos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PrecoProdutosEventos  $precoProdutosEventos
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$id1)
    {
        if(request()->ajax())
        {
            $data = PrecoProdutosEventos::where('eventoid', $id)->
            where('produtoid',$id1)->firstOrFail();
            return response()->json(['result' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PrecoProdutosEventos  $precoProdutosEventos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PrecoProdutosEventos $precoProdutosEventos)
    {
        $rules = array(
            'preco'     =>  'required|numeric|between:0,10000.99',
            'eventoid'     =>  'required',
            'produtoid'    =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'preco'        =>  $request->preco,
            'eventoid'         =>  $request->eventoid,
            'produtoid'        =>  $request->produtoid
        );
        
        try{
            
            PrecoProdutosEventos::where('eventoid', $request->hidden_id)
            ->where('produtoid',$request->hidden_id1)
            ->update($form_data);
        }catch(\Exception $e){
            if(strpos($e->getMessage(), '1062 Duplicate entry') !== false){
                return response()->json(['warning' => 'O preço desse produto para esse evento ja está associado']);
            } 
            
        }
        
        
        return response()->json(['success' => 'Informação atualizada com sucesso.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PrecoProdutosEventos  $precoProdutosEventos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$id1)
    {
        DB::delete('DELETE FROM produto_preco_evento WHERE eventoid = '.$id. ' AND produtoid = '.$id1);
    }
}
