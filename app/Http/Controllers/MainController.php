<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operacoes;
use Illuminate\Http\Request;


class MainController extends Controller
{
    public function index()
    {
        $id = session('user.id');
        $notas = User::find($id)->notas()->whereNull('deleted_at')->get()->toArray();

        return view('home', ['notas' => $notas]);
    }

    public function newNote()
    {
        //retorna minha view de notas novas

        return view('newNote');
    }

    public function newNoteSubmit(Request $request)
    {
        //validação 
        $request->validate(
            [
                    'text_title' => 'required|min:3|max:200',
                    'text_note' => 'required|min:3|max:3000'
            ],
            [
                  'text_title.required' => 'O título é obrigatório!',
                  'text_title.min' => 'O título deve ter pelo memos :min caracteres!',
                  'text_title.max' => 'O título deve ter no maximo :max caracteres!',
                  'text_note.required' => 'A nota é obrigatória!',
                  'text_note.min' => 'A nota deve ter pelo memos :min caracteres!',
                  'text_note.max' => 'A nota deve ter no maximo :max caracteres!'
            ] 
               );

            //agora vamos buscar o id 

            $id = session('user.id');

            //criando uma nova nota

            $nota = new Note();
            $nota->user_id = $id;
            $nota->title = $request->text_title;
            $nota->text = $request->text_note;
            $nota->save();
            
            //depois de buscar por id criar e salvar uma nava nota vamos redirecionar

            return redirect()->route('home');
    }

    public function editNote($id)
    {
       $id = Operacoes::decryptId($id);

       if($id === null){
            return redirect()->route('home'); 
       }

       //buscando a nota
        $nota = Note::find($id);

       //mostrando a view

       return view('editNote', ['nota' => $nota]);
    }


    public function editNoteSubmit(Request $request)
    {
        //validações dos dados
        $request->validate(
            [
                    'text_title' => 'required|min:3|max:200',
                    'text_note' => 'required|min:3|max:3000'
            ],
            [
                  'text_title.required' => 'O título é obrigatório!',
                  'text_title.min' => 'O título deve ter pelo memos :min caracteres!',
                  'text_title.max' => 'O título deve ter no maximo :max caracteres!',
                  'text_note.required' => 'A nota é obrigatória!',
                  'text_note.min' => 'A nota deve ter pelo memos :min caracteres!',
                  'text_note.max' => 'A nota deve ter no maximo :max caracteres!'
            ] 
               );

        //verificar se o notaId existe
        
        if($request->notaId == null){
            return redirect()->route('home');
        }

        //decriptação

        $id = Operacoes::decryptId($request->notaId);

        if($id === null){
            return redirect()->route('home'); 
       }

        //carregar os dados da nota = notaId

        $nota = Note::find($id);

        //update da nota
        $nota->title = $request->text_title;
        $nota->text = $request->text_note;
        $nota->save();

        //redirect para a home
        return redirect()->route('home');

    }

    public function deleteNote($id)
    {
        $id = Operacoes::decryptId($id);

        if($id === null){
            return redirect()->route('home'); 
        }
       
        $nota = Note::find($id);

        //confirmação de deleção

        return view('deleteNote', ['nota' =>$nota]);

    }

    public function deleteNoteConfirm($id)
    {
        //desencriptar
        $id = Operacoes::decryptId($id);

        if($id === null){
            return redirect()->route('home'); 
        }

        // carregar nota

        $nota = Note::find($id);

        //3. usando a função soft delete

        $nota->delete();

        //redirecionar
        return redirect()->route('home');

    }


}
