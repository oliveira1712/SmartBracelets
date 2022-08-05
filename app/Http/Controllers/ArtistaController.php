<?php

namespace App\Http\Controllers;

use App\Artista;
use App\tipoartista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Validator;
use DB;

class ArtistaController extends Controller
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
            $data = DB::select('SELECT artistas.*,tipoartistas.tipoartista
            FROM artistas,tipoartistas
            WHERE artistas.tpartistaid=tipoartistas.idtpartista
            ORDER BY artistas.tpartistaid ASC');
            
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->idartista.'" class="edit btn btn-primary btn-sm nols"><i class="fas fa-pencil-alt"></i></button>';
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->idartista.'" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            
        }
        
        $tiposartistas = tipoartista::all();

        return view('CRUD.artistas',[
            'tiposartistas' => $tiposartistas,
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
            'artista'    =>  'required',
            'linkartista'     =>  'required',
            'tpartistaid'     =>  'required',            
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
            $path = $request->file('foto')->storeAs('public/imagens_artistas', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        $form_data = array(
            'artista'        =>  $request->artista,
            'linkartista'         =>  $request->linkartista,
            'tpartistaid'         =>  $request->tpartistaid,
            'foto'             =>  $fileNameToStore
        );

        Artista::create($form_data);

        return response()->json(['success' => 'Registo criado com sucesso.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Artista  $artista
     * @return \Illuminate\Http\Response
     */
    public function show(Artista $artista)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Artista  $artista
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Artista::findOrFail($id);
        
            return response()->json(['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Artista  $artista
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Artista $artista)
    {
        $query = 'SELECT * FROM Artistas WHERE idartista='.$request->hidden_id;
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
            $path = $request->file('foto')->storeAs('public/imagens_artistas', $fileNameToStore);
        }

        if($request->hasFile('foto'))
        {
            $rules = array(
                'artista'    =>  'required',
                'linkartista'     =>  'required',
                'tpartistaid'     =>  'required',            
                'foto'         =>  'required|image|max:2048'
            );
            $error = Validator::make($request->all(), $rules);
            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

            if($auxfoto[0]->foto!= 'noimage.png'){
                Storage::delete('public/imagens_artistas/'.$auxfoto[0]->foto);
            }
            $foto = $fileNameToStore;
        }
        else
        {
            $rules = array(
                'artista'    =>  'required',
                'linkartista'     =>  'required',
                'tpartistaid'     =>  'required'
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
                       
            $foto = $auxfoto[0]->foto;
        }

        $form_data = array(
            'artista'       =>   $request->artista,
            'linkartista'        =>   $request->linkartista,
            'tpartistaid'        =>   $request->tpartistaid,
            'foto'            =>   $foto
        
        );

        Artista::whereidartista($request->hidden_id)->update($form_data);
        
        
        return response()->json(['success' => 'Registo atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Artista  $artista
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = 'SELECT * FROM Artistas WHERE idartista='.$id;
        $auxfoto = DB::select($query); 
        if($auxfoto[0]->foto!= 'noimage.png'){
            Storage::delete('public/imagens_artistas/'.$auxfoto[0]->foto);
        }
        DB::delete('DELETE FROM Artistas WHERE idartista = '.$id);

        //Resetar o auto increment
        $total = Artista::all();
        $query = 'ALTER TABLE artistas AUTO_INCREMENT = '.(count($total)+1);
        DB::statement($query);
    }
}
