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

        //primeiro vou dar uma show views
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
       //busca a nota
        $nota = Note::find($id);

       //mostra a view

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

        //decryptação

        $id = Operacoes::decryptId($request->notaId);

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
        $nota = Note::find($id);

        //confirmaçãon de deleção

        return view('deleteNote', ['nota' =>$nota]);

    }

    public function deleteNoteConfirm($id)
    {
        //desencryptar
        $id = Operacoes::decryptId($id);

        // carregar nota

        $nota = Note::find($id);

        //deleção mais onde não guardo os dados no bd

        //$nota->delete();

        //deleção onde os dados mesmo excluidos pelo usuário ficam guardados no banco a exclusão lógica
        $nota->deleted_at = date('Y:m:d H:i:s');
        $nota->save();
        //redirecionar

        return redirect()->route('home');

    }


}
