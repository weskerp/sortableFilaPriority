<?php

namespace App\Http\Controllers;

use App\Processo;
use Illuminate\Http\Request;

class FilaController extends Controller
{
    public function index()
    {
        $itens = Processo::orderby('cod')->get();
        return view('fila', compact('itens'));
    }

    public function atualizarOrdem(Request $request)
    {
        $itens = Processo::get();
        $dados = $request->input('data.cardProperties');
        $dados2 = [];
        $status = [];
        foreach ($itens as $item) {
            foreach ($dados as $dado){
                if($item->cod == (int)$dado['id'] && !in_array($item['id'], $status)){
                    $status[] = $item['id'];
                    $item->cod  = (int)$dado['newId'];
                    $item->ant  = (int)$dado['newId'] - 1;
                    $item->prox = (int)$dado['newId'] + 1;
                    $dados2[] = ['cod'=>$item->cod, $dado];
                    $item->save();
                }
            }
        }
        
        return response()->json([$dados2]);
    }
}
