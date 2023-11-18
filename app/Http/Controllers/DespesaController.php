<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Despesa;

class DespesaController extends Controller
{
    public function salvarNovaDespesa(Request $request)
    {        

        Despesa::create([
            'tipo_despesa_id' => $request->input('tipo_despesa_id'),
            'valor' => $request->input('valor_despesa'),
            'data_vencimento' => $request->input('data_vencimento')
         ]);
         
        return redirect('/cadastrar')->with('success', 'Tipo de despesa salvo com sucesso!');
    }
}
