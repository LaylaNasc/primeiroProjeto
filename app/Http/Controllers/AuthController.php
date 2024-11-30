<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
      return view('login');
    }

    public function loginSubmit(Request $request)
    {
       //validação do form
       $request->validate(
    [
            'text_username' => 'required|email',
            'text_password' => 'required|min:6|max:16'
    ],
    [
          'text_username.required' => 'O username é obrigatorio!', 
          'text_username.email' => 'Email deve ser um email válido!', 
          'text_password.required' => 'A senha é obrigatória!',
          'text_password.min' => 'A senha deve ter pelo memos :min caracteres!',
          'text_password.max' => 'A senha deve ter no maximo :max caracteres!'
    ] 
       );

       // get user input
       $username = $request->input('text_username');
       $password = $request->input('text_password');
       
       echo 'OK';
    }
      
    public function logout()
    {
        echo 'logout';
    }
}
