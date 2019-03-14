<?php

namespace estoque\Http\Controllers;

//use Illuminate\Http\Request;
use Auth;
use Request;

class LoginController extends Controller
{
    public function login()
    {
        $credenciais = Request::only('email', 'password');

        if(Auth::attempt($credenciais)) {
            return "Usuário ".Auth::user()->name." logado com sucesso";
        }

        return "As credenciais não são válidas";
    }
}
