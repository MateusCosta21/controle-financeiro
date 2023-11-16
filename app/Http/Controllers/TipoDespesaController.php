<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoDespesa;

class TipoDespesaController extends Controller
{

    public function salvarTipoDespesa(Request $request)
    {
        TipoDespesa::create([
            'nome_despesa' => $request->input('nome_despesa'),
         ]);
         
        return redirect('/cadastrar')->with('success', 'Tipo de despesa salvo com sucesso!');
    }
}
