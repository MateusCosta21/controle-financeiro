<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Despesa;
use App\Models\TipoDespesa;
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

    public function edit($id)
    {

        $idUsuario = Auth::id();
        $tipoDespesa = TipoDespesa::where('id_usuario', $idUsuario)->get();
        $despesa = Despesa::where('id', $id)->first();

        return view('edit.editar_despesa', ['despesas' => $despesa, 'tipoDespesa' => $tipoDespesa]);
    }

    public function update(Request $request, $id)
    {

        $mensagens = [
            'tipo_despesa_id.required' => 'O campo Tipo de Despesa é obrigatório.',
            'valor_despesa.required' => 'O campo Valor da Despesa é obrigatório.',
        ];
        
        $request->validate([
            'tipo_despesa_id' => 'required',
            'valor_despesa' => 'required',
        ], $mensagens);
        

        $valorOriginal = $request->input('valor_despesa_original');
        $valorDespesa = $request->input('valor_despesa');
    
        if (!is_null($valorOriginal)) {
            $valorDespesa = str_replace('.', '', $valorOriginal);
            $valorDespesa = str_replace(',', '.', $valorDespesa);
        }
    
        $despesa = Despesa::find($id);
    
        if (!$despesa) {
            return redirect('/dashboard')->with('error', 'Despesa não encontrada');
        }
    
        $despesa->tipo_despesa_id = $request->input('tipo_despesa_id');
        $despesa->valor = $valorDespesa;

        $despesa->save();
    
        return redirect('/dashboard')->with('success', 'Despesa atualizada com sucesso');
    }

    public function softDelete($id)
    {
        $despesa = Despesa::find($id);
    
        if ($despesa) {
            $despesa->delete();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false, 'message' => 'Receita não encontrada'], 404);
    }
}
