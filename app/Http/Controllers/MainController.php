<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $id = session('user.id');
        $notas = User::find($id)->notas()->get()->toArray();


        //primeiro vou dar uma show views
        return view('home', ['notas' => $notas]);
    }

    public function newNote()
    {
        echo "My notes!";
    }
}
