<?php

namespace App\Http\Controllers;

use App\Processo;
use Illuminate\Http\Request;

class FilaController extends Controller
{
    public function index()
    {
        // Lógica para buscar itens no banco de dados
        $itens = Processo::get();
        return view('fila', compact('itens'));
    }
}
