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

        
        $mensagens = [
            'tipo_despesa_id.required' => 'O campo Tipo de Despesa é obrigatório.',
            'valor_despesa.required' => 'O campo Valor da Despesa é obrigatório.',
            'data_vencimento.required' => 'O campo Data de Vencimento é obrigatório.',
            'data_vencimento.date' => 'O campo Data de Vencimento deve ser uma data válida.',
        ];
        
        $request->validate([
            'tipo_despesa_id' => 'required',
            'valor_despesa' => 'required',
            'data_vencimento' => 'required|date', 
        ], $mensagens);
        
        $valorDespesa = $request->input('valor_despesa');

        $valorDespesa = str_replace('.', '', $valorDespesa);
        
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
