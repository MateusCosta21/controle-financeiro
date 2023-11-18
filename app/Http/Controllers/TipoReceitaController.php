<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\TipoReceita;

class TipoReceitaController extends Controller
{
    public function salvarTipoReceita(Request $request)
    {
        TipoReceita::create([
            'nome_receita' => $request->input('nome_receita'),
         ]);
         
        return redirect('/cadastrar/receita')->with('success', 'Tipo de Receita salvo com sucesso!');
    }
}
