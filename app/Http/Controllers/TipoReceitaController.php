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
        $nomeReceita = strtolower($request->input('nome_receita')); 
    
        $tipoReceitaExistente = TipoReceita::whereRaw('LOWER(nome_receita) = ?', [$nomeReceita])
            ->where('id_usuario', $idUsuario)
            ->first();
    
        if ($tipoReceitaExistente) {
            return redirect('/cadastrar/receita')->with('error', 'Tipo de receita já cadastrado para este usuário.');
        }
    
        TipoReceita::create([
            'nome_receita' => $request->input('nome_receita'),
            'id_usuario' => $idUsuario
        ]);
    
        return redirect('/cadastrar/receita')->with('success', 'Tipo de Receita salvo com sucesso!');
    }
}
