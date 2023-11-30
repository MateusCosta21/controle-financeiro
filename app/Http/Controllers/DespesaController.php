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

        $request->validate([
            'tipo_despesa_id' => 'required',
            'valor_despesa' => 'required',
            'data_vencimento' => 'required|date', 
        ]);

        $valorDespesa = $request->input('valor_despesa');

        // Remover pontos como separadores de milhares
        $valorDespesa = str_replace('.', '', $valorDespesa);
        
        // Substituir vírgulas por pontos para garantir o formato numérico adequado
        $valorDespesa = str_replace(',', '.', $valorDespesa);

        

        Despesa::create([
            'tipo_despesa_id' => $request->input('tipo_despesa_id'),
            'valor' => $valorDespesa,
            'data_vencimento' => $request->input('data_vencimento'),
            'id_usuario' => $idUsuario
         ]);
         
        return redirect('/cadastrar')->with('success', 'Despesa Cadastrada com sucesso');
    }
}
