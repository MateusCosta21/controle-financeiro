<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\TipoReceita;
use Illuminate\Support\Facades\Auth;

class TipoReceitaController extends Controller
{
    public function salvarTipoReceita(Request $request)
    {
        $idUsuario = Auth::id();

        TipoReceita::create([
            'nome_receita' => $request->input('nome_receita'),
            'id_usuario' => $idUsuario
         ]);
         
        return redirect('/cadastrar/receita')->with('success', 'Tipo de Receita salvo com sucesso!');
    }
}
