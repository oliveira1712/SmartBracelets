<?php

namespace App\Http\Controllers;

use App\UserCrud;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use DB;
use App\tipouser;
use Hash;
use App\User;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UserCrudController extends Controller
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
            $data = DB::select('SELECT * FROM users,tipousers WHERE users.tipoUserID = tipousers.idTipoUser');
            
            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm nols"><i class="fas fa-pencil-alt"></i></button>';
                        $button .= '&nbsp;&nbsp;&nbsp;<button type="button" name="edit" id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            
        }
        
        $tipousers = tipouser::all();

        return view('CRUD.usercrud',[
            'tipousers' => $tipousers,
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
            'name'    =>  'required',
            'email'     =>  'required|email',
            'password'     =>  'required|min:8',            
            'tipoUserID'     =>  'required'
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
            $path = $request->file('foto')->storeAs('public/users_avatares/', $fileNameToStore);
        } else {
            $fileNameToStore = 'default.svg';
        }

        $form_data = array(
            'name'        =>  $request->name,
            'email'         =>  $request->email,
            'tipoUserID'         =>  $request->tipoUserID,
            'password'         =>  Hash::make($request->password),
            'avatar'             =>  $fileNameToStore
        );

        UserCrud::create($form_data);

        return response()->json(['success' => 'Registo criado com sucesso.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserCrud  $userCrud
     * @return \Illuminate\Http\Response
     */
    public function show(UserCrud $userCrud)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserCrud  $userCrud
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {       
        if(request()->ajax())
        {
            $data = UserCrud::findOrFail($id);
        
            return response()->json(['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserCrud  $userCrud
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserCrud $userCrud)
    {
        $query = 'SELECT * FROM users WHERE id='.$request->hidden_id;
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
            $path = $request->file('foto')->storeAs('public/users_avatares', $fileNameToStore);
        }

        if($request->hasFile('foto'))
        {
            $rules = array(
                'name'    =>  'required',
                'email'     =>  'required|email',
                'password'     =>  'required|min:8',            
                'tipoUserID'     =>  'required'
            );
            $error = Validator::make($request->all(), $rules);
            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }

            if($auxfoto[0]->avatar!= 'default.svg'){
                Storage::delete('public/users_avatares/'.$auxfoto[0]->avatar);
            }
            $foto = $fileNameToStore;
        }
        else
        {
            $rules = array(
                'name'    =>  'required',
                'email'     =>  'required|email',
                'password'     =>  'required|min:8',            
                'tipoUserID'     =>  'required'
            );

            $error = Validator::make($request->all(), $rules);

            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
                       
            $foto = $auxfoto[0]->avatar;
        }

        if(strcmp($auxfoto[0]->password, $request->password) == 0){
            $form_data = array(
                'name'        =>  $request->name,
                'email'         =>  $request->email,
                'tipoUserID'         =>  $request->tipoUserID,
                'avatar'             =>  $foto,
                'updated_at'             =>  date("Y-m-d h:i:s")
            );

        }else{
            $form_data = array(
                'name'        =>  $request->name,
                'email'         =>  $request->email,
                'tipoUserID'         =>  $request->tipoUserID,
                'password'         =>  Hash::make($request->password),
                'avatar'             =>  $foto,
                'updated_at'             =>  date("Y-m-d h:i:s")
            );
        }

        

        UserCrud::whereid($request->hidden_id)->update($form_data);
        
        
        return response()->json(['success' => 'Registo atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserCrud  $userCrud
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = 'SELECT * FROM users WHERE id='.$id;
        $auxfoto = DB::select($query); 
        if($auxfoto[0]->avatar!= 'default.svg'){
            Storage::delete('public/users_avatares/'.$auxfoto[0]->avatar);
        }
        DB::delete('DELETE FROM users WHERE id = '.$id);

        //Resetar o auto increment
        $total = UserCrud::all();
        $query = 'ALTER TABLE users AUTO_INCREMENT = '.(count($total)+1);
        DB::statement($query);
    }
}
