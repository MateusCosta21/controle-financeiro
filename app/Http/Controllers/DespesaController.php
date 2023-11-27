<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Despesa;
use Illuminate\Support\Facades\Auth;

class DespesaController extends Controller
{
    public function salvarNovaDespesa(Request $request)
    {        

        $idUsuario = Auth::id();

        Despesa::create([
            'tipo_despesa_id' => $request->input('tipo_despesa_id'),
            'valor' => $request->input('valor_despesa'),
            'data_vencimento' => $request->input('data_vencimento'),
            'id_usuario' => $idUsuario
         ]);
         
        return redirect('/cadastrar')->with('success', 'Despesa Cadastrada com sucesso');
    }
}
