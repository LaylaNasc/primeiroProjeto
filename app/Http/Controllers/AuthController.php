<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
       
      // verificar se o usuário esta no bd
      $user = User::where('username', $username)
                    ->where('deleted_at', NULL)
                    ->first();

        if(!$user){
            return redirect()->back()->withInput()->with('loginError', 'Usuário ou senha incorretos.');
        }
        // verificando a senha
        if(!password_verify($password, $user->password)){
            return redirect()->back()->withInput()->with('loginError', 'Usuário ou senha incorretos.');
        }

        //update last login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        //login do usuário
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);

        echo 'Login efetuado com sucesso!';
                 
    }
      
    public function logout()
    {
        //logout
        session()->forget('user');
        return redirect()->to('/login');
    }
}
