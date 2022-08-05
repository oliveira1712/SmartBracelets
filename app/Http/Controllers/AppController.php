<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\mailPrimeiro;

class AppController extends Controller
{
    public function index(){
        //apresentar a view inicial da aplicacao
        return view('teste');
    }

    public function enviarPrimeiroEmail(){
        //enviar o primeiro email
        Mail::to('gafoliveira2002@gmail.com')->send(new mailPrimeiro());

        return 'OK';
    }
}
