<?php

namespace App\Http\Controllers;

use App\Models\Receita;
use App\Models\TipoReceita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReceitaController extends Controller
{
    public function index()
    {
        $idUsuario = Auth::id();
        $tipoReceita = TipoReceita::where('id_usuario', $idUsuario)->get();
        return view('receitas.cadastrar',compact('tipoReceita'));
    }

    public function salvarNovaReceita(Request $request)
    {        
        $idUsuario = Auth::id();
        Receita::create([
            'tipo_receita_id' => $request->input('tipo_receita_id'),
            'valor_recebido' => $request->input('valor_recebido'),
            'data_entrada' => $request->input('data_entrada'),
            'id_usuario' => $idUsuario
         ]);
         
        return redirect('/cadastrar/receita')->with('success', 'Nova receita salva com sucesso');
    }
}
