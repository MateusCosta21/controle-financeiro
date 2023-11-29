<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoDespesa;
use Illuminate\Support\Facades\Auth;

class TipoDespesaController extends Controller
{

    public function salvarTipoDespesa(Request $request)
    {   
        $idUsuario = Auth::id();
        TipoDespesa::create([
            'nome_despesa' => $request->input('nome_despesa'),
            'id_usuario' => $idUsuario
         ]);
         
        return redirect('/cadastrar')->with('success', 'Tipo de despesa salvo com sucesso!');
    }
}
