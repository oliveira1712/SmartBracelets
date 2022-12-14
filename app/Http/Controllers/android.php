<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class android extends Controller
{
    public function login(){         
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){             
            $user = Auth::user();             
            echo json_encode([$user]);         
        }     
    }

    public function registar(){
        if(!empty(request('email')) && !empty(request('name'))  && !empty(request('passeword')) ){
                $email=request('email');
                $name=request('name');
        $password=request('passeword');

                $utilizador = new User([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    ]);
                    $utilizador->save();
        }
    }
}
