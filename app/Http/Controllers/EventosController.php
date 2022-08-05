<?php

namespace App\Http\Controllers;

use App\eventos;
use App\tipoevento;
use App\Zona;
use App\Classificacao;
use App\TipoEventosLugar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Validator;
use DB;

class EventosController extends Controller
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
            $data = DB::select('SELECT eventos.*, tipoeventos.tipoevento, classificacoes.classificacao, zonas.zona, tipoeventoslugares.tipolugarevento, estadoeventos.estadoevento
            FROM eventos,tipoeventos,classificacoes,zonas,tipoeventoslugares,estadoeventos
            WHERE eventos.tpeventoid=tipoeventos.idtpevento
            AND eventos.classificacaoid=classificacoes.idclassificacao
            AND eventos.zonaid=zonas.idzona
            AND eventos.tpeventolugarid = tipoeventoslugares.idtpeventolugar
            AND eventos.estadoeventoid = estadoeventos.idestadoevento;');
            
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->idevento.'" class="edit btn btn-primary btn-sm nols"><i class="fas fa-pencil-alt"></i></button>';
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->idevento.'" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $tipoeventos = tipoevento::all();
        $classificacoes = classificacao::all();
        $zonas = zona::all();
        $tipoeventoslugar = TipoEventosLugar::all();
        $estadoseventos = DB::table('estadoeventos')->get();
        return view('CRUD.eventos',[
            'tipoeventos' => $tipoeventos,
            'classificacoes' => $classificacoes,   
            'zonas' => $zonas,         
            'tipoeventoslugar' => $tipoeventoslugar,         
            'estadoseventos' => $estadoseventos,         
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
        if($request->tpeventolugarid==1){
            $rules = array(
                'evento'    =>  'required',
                'local'     =>  'required',
                'latitude'     =>  'required',
                'longitude'     =>  'required',
                'datainicio'    =>  'required',
                'horainicio'    =>  'required',
                'datafim'     =>  'required',
                'preco'     =>  'required|numeric|between:0,10000.99',
                'horafim'     =>  'required',
                'lotacao'     =>  'required',           
                'estadoeventoid'     =>  'required',           
                'tipoeventoid'    =>  'required', // nome do input field
                'classificacaoid'    =>  'required', //nome do input field nao do campo da bd
                'zonaid'     =>  'required',  //nome do input field nao do campo da bd
                'tpeventolugarid'     =>  'required',  //nome do input field nao do campo da bd
                'linkcompra'     =>  'required',  //nome do input field nao do campo da bd
                'fotocartaz'         =>  'image|max:2048',
                'foto'         =>  'required|image|max:2048'
            );
        }else{
            $rules = array(
                'evento'    =>  'required',
                'local'     =>  'required',
                'latitude'     =>  'required',
                'longitude'     =>  'required',
                'datainicio'    =>  'required',
                'preco'     =>  'required|numeric|between:0,10000.99',
                'horainicio'    =>  'required',
                'datafim'     =>  'required',
                'horafim'     =>  'required',
                'lotacao'     =>  'required',    
                'estadoeventoid'     =>  'required',        
                'tipoeventoid'    =>  'required', // nome do input field
                'classificacaoid'    =>  'required', //nome do input field nao do campo da bd
                'zonaid'     =>  'required',  //nome do input field nao do campo da bd
                'tpeventolugarid'     =>  'required',  //nome do input field nao do campo da bd
                'fotocartaz'         =>  'image|max:2048',
                'foto'         =>  'required|image|max:2048'
            );
        }
        

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
            $fileNameToStore=time().'.'.$extension;
            // Upload Image
            $path = $request->file('foto')->storeAs('public/imagens_eventos', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        if($request->hasFile('fotocartaz')){
            // Get filename with the extension
            $filenameWithExt = $request->file('fotocartaz')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('fotocartaz')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStoreCartaz= time().'.'.$extension;
            // Upload Image
            $path = $request->file('fotocartaz')->storeAs('public/imagens_eventos', $fileNameToStoreCartaz);
        } else {
            $fileNameToStoreCartaz = null;
        }

        $form_data = array(
            'evento'        =>  $request->evento,
            'local'         =>  $request->local,
            'latitude'         =>  $request->latitude,
            'longitude'         =>  $request->longitude,
            'datainicio'        =>  $request->datainicio,
            'horainicio'        =>  $request->horainicio,
            'datafim'         =>  $request->datafim,
            'horafim'         =>  $request->horafim,
            'preco'         =>  $request->preco,
            'lotacao'         =>  $request->lotacao,
            'zonaid'         =>  $request->zonaid,
            'estadoeventoid'         =>  $request->estadoeventoid,
            'tpeventoid'        =>  $request->tipoeventoid,
            'classificacaoid'        =>  $request->classificacaoid,
            'tpeventolugarid'        =>  $request->tpeventolugarid,
            'linkcompra'        =>  $request->linkcompra,
            'fotocartaz'        =>  $fileNameToStoreCartaz,
            'foto'             =>  $fileNameToStore
        );

        eventos::create($form_data);

        return response()->json(['success' => 'Registo criado com sucesso.']);
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\eventos  $eventos
     * @return \Illuminate\Http\Response
     */
    public function show(eventos $eventos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\eventos  $eventos
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = eventos::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\eventos  $eventos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, eventos $eventos)
    {
        $query = 'SELECT * FROM Eventos WHERE idevento='.$request->hidden_id;
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
            $path = $request->file('foto')->storeAs('public/imagens_eventos', $fileNameToStore);
        }


        if($request->hasFile('fotocartaz')){
            // Get filename with the extension
            $filenameWithExt = $request->file('fotocartaz')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('fotocartaz')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStoreCartaz= time().'.'.$extension;
            // Upload Image
            $path = $request->file('fotocartaz')->storeAs('public/imagens_eventos', $fileNameToStoreCartaz);
        }
        

        if($request->hasFile('foto'))
        {
            if($request->tpeventolugarid==1){
                $rules = array(
                    'evento'    =>  'required',
                    'local'     =>  'required',
                    'latitude'     =>  'required',
                    'longitude'     =>  'required',
                    'datainicio'    =>  'required',
                    'horainicio'    =>  'required',
                    'datafim'     =>  'required',
                    'horafim'     =>  'required',
                    'preco'     =>  'required|numeric|between:0,10000.99',
                    'lotacao'     =>  'required',
                    'foto'         =>  'image|max:2048',
                    'tipoeventoid'    =>  'required',
                    'estadoeventoid'     =>  'required', 
                    'classificacaoid'    =>  'required',
                    'linkcompra'    =>  'required',
                    'tpeventolugarid'     =>  'required',  //nome do input field nao do campo da bd
                    'zonaid'    =>  'required'
                );
            }else{
                $rules = array(
                    'evento'    =>  'required',
                    'local'     =>  'required',
                    'latitude'     =>  'required',
                    'longitude'     =>  'required',
                    'datainicio'    =>  'required',
                    'preco'     =>  'required|numeric|between:0,10000.99',
                    'horainicio'    =>  'required',
                    'datafim'     =>  'required',
                    'horafim'     =>  'required',
                    'lotacao'     =>  'required',
                    'estadoeventoid'     =>  'required', 
                    'foto'         =>  'image|max:2048',
                    'tipoeventoid'    =>  'required',
                    'classificacaoid'    =>  'required',
                    
                    'tpeventolugarid'     =>  'required',  //nome do input field nao do campo da bd
                    'zonaid'    =>  'required'
                );
            }
            $error = Validator::make($request->all(), $rules);
            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

            if($auxfoto[0]->foto!= 'noimage.png'){
                Storage::delete('public/imagens_eventos/'.$auxfoto[0]->foto);
            }

            $foto = $fileNameToStore;

            
        }        
        else
        {
            if($request->tpeventolugarid==1){
                $rules = array(
                    'evento'    =>  'required',
                    'local'     =>  'required',
                    'latitude'     =>  'required',
                    'longitude'     =>  'required',
                    'datainicio'    =>  'required',
                    'horainicio'    =>  'required',
                    'datafim'     =>  'required',
                    'horafim'    =>  'required',
                    'lotacao'     =>  'required',
                    'estadoeventoid'     =>  'required', 
                    'preco'     =>  'required|numeric|between:0,10000.99',
                    'tipoeventoid'    =>  'required',               
                    'classificacaoid'    =>  'required',
                    'linkcompra'    =>  'required',
                    'tpeventolugarid'     =>  'required',  //nome do input field nao do campo da bd
                    'zonaid'    =>  'required'
                );
            }else{
                $rules = array(
                    'evento'    =>  'required',
                    'local'     =>  'required',
                    'latitude'     =>  'required',
                    'longitude'     =>  'required',
                    'datainicio'    =>  'required',
                    'horainicio'    =>  'required',
                    'datafim'     =>  'required',
                    'horafim'    =>  'required',
                    'estadoeventoid'     =>  'required', 
                    'lotacao'     =>  'required',
                    'tipoeventoid'    =>  'required',
                    'preco'     =>  'required|numeric|between:0,10000.99',               
                    'classificacaoid'    =>  'required',
                    'tpeventolugarid'     =>  'required',  //nome do input field nao do campo da bd
                    'zonaid'    =>  'required'
                );
            }
            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
                       
            $foto = $auxfoto[0]->foto;
        }



        if ($request->hasFile('fotocartaz')) {
            if($request->tpeventolugarid==1){
                $rules = array(
                    'evento'    =>  'required',
                    'local'     =>  'required',
                    'latitude'     =>  'required',
                    'longitude'     =>  'required',
                    'datainicio'    =>  'required',
                    'horainicio'    =>  'required',
                    'datafim'     =>  'required',
                    'estadoeventoid'     =>  'required', 
                    'horafim'     =>  'required',
                    'preco'     =>  'required|numeric|between:0,10000.99',
                    'lotacao'     =>  'required',
                    'fotocartaz'         =>  'image|max:2048',
                    'tipoeventoid'    =>  'required',
                    'classificacaoid'    =>  'required',
                    'linkcompra'    =>  'required',
                    'tpeventolugarid'     =>  'required',  //nome do input field nao do campo da bd
                    'zonaid'    =>  'required'
                );
            }else{
                $rules = array(
                    'evento'    =>  'required',
                    'local'     =>  'required',
                    'latitude'     =>  'required',
                    'longitude'     =>  'required',
                    'datainicio'    =>  'required',
                    'horainicio'    =>  'required',
                    'preco'     =>  'required|numeric|between:0,10000.99',
                    'datafim'     =>  'required',
                    'horafim'     =>  'required',
                    'estadoeventoid'     =>  'required', 
                    'lotacao'     =>  'required',
                    'fotocartaz'         =>  'image|max:2048',
                    'tipoeventoid'    =>  'required',
                    'classificacaoid'    =>  'required',
                    'tpeventolugarid'     =>  'required',  //nome do input field nao do campo da bd
                    'zonaid'    =>  'required'
                );
            }
            $error = Validator::make($request->all(), $rules);
            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }


            if($auxfoto[0]->fotocartaz!= 'null'){
                Storage::delete('public/imagens_eventos/'.$auxfoto[0]->fotocartaz);
            }
            //pq foi carregado para mudar a foto
            $fotocartaz = $fileNameToStoreCartaz;
        }
        else
        {
            if($request->tpeventolugarid==1){
                $rules = array(
                    'evento'    =>  'required',
                    'local'     =>  'required',
                    'latitude'     =>  'required',
                    'longitude'     =>  'required',
                    'datainicio'    =>  'required',
                    'horainicio'    =>  'required',
                    'estadoeventoid'     =>  'required', 
                    'datafim'     =>  'required',
                    'preco'     =>  'required|numeric|between:0,10000.99',
                    'horafim'    =>  'required',
                    'lotacao'     =>  'required',
                    'tipoeventoid'    =>  'required',               
                    'classificacaoid'    =>  'required',
                    'linkcompra'    =>  'required',
                    'tpeventolugarid'     =>  'required',  //nome do input field nao do campo da bd
                    'zonaid'    =>  'required'
                );
            }else{
                $rules = array(
                    'evento'    =>  'required',
                    'local'     =>  'required',
                    'latitude'     =>  'required',
                    'longitude'     =>  'required',
                    'datainicio'    =>  'required',
                    'estadoeventoid'     =>  'required', 
                    'horainicio'    =>  'required',
                    'datafim'     =>  'required',
                    'preco'     =>  'required|numeric|between:0,10000.99',
                    'horafim'    =>  'required',
                    'lotacao'     =>  'required',
                    'tipoeventoid'    =>  'required',               
                    'classificacaoid'    =>  'required',
                    'tpeventolugarid'     =>  'required',  //nome do input field nao do campo da bd
                    'zonaid'    =>  'required'
                );
            }
            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
            //pq n foi carregado para mudar a foto           
            $fotocartaz = $auxfoto[0]->fotocartaz;
        }


        $form_data = array(
            'evento'       =>   $request->evento,
            'local'        =>   $request->local,
            'latitude'        =>   $request->latitude,
            'longitude'        =>   $request->longitude,
            'datainicio'       =>   $request->datainicio,
            'horainicio'       =>   $request->horainicio,
            'datafim'        =>   $request->datafim,
            'horafim'       =>   $request->horafim,
            'lotacao'       =>   $request->lotacao,
            'preco'       =>   $request->preco,
            'foto'            =>   $foto,
            'fotocartaz'            =>   $fotocartaz,
            'estadoeventoid'            =>   $request->estadoeventoid,
            'tpeventoid'        =>   $request->tipoeventoid,
            'classificacaoid'        =>   $request->classificacaoid,
            'tpeventolugarid'        =>  $request->tpeventolugarid,
            'linkcompra'        =>  $request->linkcompra,
            'zonaid'        =>   $request->zonaid,
        );

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        eventos::whereidevento($request->hidden_id)->update($form_data);
        
        
        return response()->json(['success' => 'Registo atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\eventos  $eventos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = 'SELECT * FROM Eventos WHERE idevento='.$id;
        $auxfoto = DB::select($query); 
        if($auxfoto[0]->foto!= 'noimage.png'){
            Storage::delete('public/imagens_eventos/'.$auxfoto[0]->foto);
        }
        if($auxfoto[0]->fotocartaz!= 'noimage.png' || $auxfoto[0]->fotocartaz!= null){
            Storage::delete('public/imagens_eventos/'.$auxfoto[0]->fotocartaz);
        }
        DB::delete('DELETE FROM Eventos WHERE idevento = '.$id);


        //Resetar o auto increment
        $total = eventos::all();
        $query = 'ALTER TABLE eventos AUTO_INCREMENT = '.(count($total)+1);
        DB::statement($query);
    }


    
}
