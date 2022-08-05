<?php

namespace App\Http\Controllers;

use App\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Validator;
use DB;


class ProdutoController extends Controller
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
            $data = Produto::all();
            
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->idproduto.'" class="edit btn btn-primary btn-sm nols"><i class="fas fa-pencil-alt"></i></button>';
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->idproduto.'" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            
        }

        return view('CRUD.produtos',[

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
            'produto'    =>  'required',           
            'foto'         =>  'required|image|max:2048'
        );

        

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

       

        if($request->hasFile('foto')){
            // Get filename with the extension
            $filenameWithExt = $request->file('foto')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('foto')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= time().'.'.$extension;
            // Upload Image
            $path = $request->file('foto')->storeAs('public/imagens_produtos', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        $form_data = array(
            'produto'        =>  $request->produto,
            'descricao'        =>  $request->descricao,
            'foto'             =>  $fileNameToStore
        );

        Produto::create($form_data);

        return response()->json(['success' => 'Registo criado com sucesso.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show(Produto $produto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Produto::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produto $produto)
    {
        $query = 'SELECT * FROM produtos WHERE idproduto='.$request->hidden_id;
        $auxfoto = DB::select($query); 

        if($request->hasFile('foto')){
            // Get filename with the extension
            $filenameWithExt = $request->file('foto')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('foto')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= time().'.'.$extension;
            // Upload Image
            $path = $request->file('foto')->storeAs('public/imagens_produtos', $fileNameToStore);
        }

        if($request->hasFile('foto'))
        {
            $rules = array(
                'produto'    =>  'required',           
                'foto'         =>  'required|image|max:2048'
            );
            $error = Validator::make($request->all(), $rules);
            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

            if($auxfoto[0]->foto!= 'noimage.png'){
                Storage::delete('public/imagens_produtos/'.$auxfoto[0]->foto);
            }
            $foto = $fileNameToStore;
        }
        else
        {
            $rules = array(
                'produto'    =>  'required'
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
                       
            $foto = $auxfoto[0]->foto;
        }

        $form_data = array(
            'produto'       =>   $request->produto,
            'descricao'        =>   $request->descricao,
            'foto'            =>   $foto
        
        );

        Produto::whereidproduto($request->hidden_id)->update($form_data);
        
        
        return response()->json(['success' => 'Registo atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = 'SELECT * FROM Produtos WHERE idproduto='.$id;
        $auxfoto = DB::select($query); 
        if($auxfoto[0]->foto!= 'noimage.png'){
            Storage::delete('public/imagens_produtos/'.$auxfoto[0]->foto);
        }
        DB::delete('DELETE FROM Produtos WHERE idproduto = '.$id);

        //Resetar o auto increment
        $total = Produto::all();
        $query = 'ALTER TABLE produtos AUTO_INCREMENT = '.(count($total)+1);
        DB::statement($query);
    }
}
