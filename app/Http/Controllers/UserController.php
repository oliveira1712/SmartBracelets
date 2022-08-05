<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use Hash;
use Illuminate\Support\Facades\Storage;
use App\tipouser;
use Validator;
use Image;
use DB;

class UserController extends Controller
{
    public function perfil(){
        $tipouser = DB::select("SELECT * FROM tipousers WHERE idTipoUser = " . Auth::user()->tipoUserID);

        return view('perfil.perfil',[
            'user' => Auth::user(),
            'tipouser' => $tipouser,
        ]);
    }

    public function update_avatar(Request $request){
        //Manipular o ficheiro feito upload

        if($request->hasFile('avatar')){
          
            $avatar = $request->file('avatar');
            $rules = array(
              'avatar'     =>  'image|nullable|max:3999',
          );

          $error = Validator::make($request->all(), $rules);

          if($error->fails())
          {
            return back()->with('error', 'O avatar deve ser uma imagem');
          }
          // Get filename with the extension
          $filenameWithExt = $request->file('avatar')->getClientOriginalName();
          // Get just filename
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          // Get just ext
          $extension = $request->file('avatar')->getClientOriginalExtension();
          // Filename to store
          $fileNameToStore= $filename.'_'.time().'.'.$extension;
          // Upload Image
          $path = $request->file('avatar')->storeAs('public/users_avatares', $fileNameToStore);

            $user = Auth::user();
            if($user->avatar != 'default.svg'){
              Storage::delete('public/users_avatares/'. $user->avatar);
            }
            $user->avatar = $fileNameToStore;
            $user->save();
        }else{
            flash('Nao foi realizado o upload de uma imagem')->warning(); 
            return redirect('/perfil');
        }

        return redirect('/perfil');

    }


    //Mudar a pw do user autenticado

    public function changePassword(Request $request)
        {
          //Verifica se a pw atual é igual a pw da bd.
          if(!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return back()->with('error', 'A password atual está errada');
          }
          // Compara as novas password e ve se sao iguais
          if(strcmp($request->get('current_password'), $request->get('new_password')) == 0) {
            return back()->with('error', 'A password a ser trocada nao pode ser a mesma que a anterior');
          }
          if(strcmp($request->get('new_password_confirmation'), $request->get('new_password')) != 0) {
            return back()->with('error', 'A confirmação da nova password nao coincide');
          }
          //valida os campos.
          $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|string|min:8'
          ]);
          // Salva a nova password se nao entrar nos ifs.
          $user = Auth::user();
          $user->password = bcrypt($request->get('new_password'));
          $user->save();
          return back()->with('message', 'Password trocada com sucesso');
        }
}
