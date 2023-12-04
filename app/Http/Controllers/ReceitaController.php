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
        return view('receitas.cadastrar', compact('tipoReceita'));
    }

    public function salvarNovaReceita(Request $request)
    {
        $mensagens = [
            'tipo_receita_id.required' => 'O campo Tipo de Receita é obrigatório.',
            'valor_recebido.required' => 'O campo Valor Recebido é obrigatório.',
            'data_entrada.required' => 'O campo Data de Entrada é obrigatório.',
            'data_entrada.date' => 'O campo Data de Entrada deve ser uma data válida.',
        ];

        $request->validate([
            'tipo_receita_id' => 'required',
            'valor_recebido' => 'required',
            'data_entrada' => 'required|date',
        ], $mensagens);

        $valorReceita = $request->input('valor_recebido');

        $valorReceita = str_replace('.', '', $valorReceita);

        $valorReceita = str_replace(',', '.', $valorReceita);
        $idUsuario = Auth::id();

        Receita::create([
            'tipo_receita_id' => $request->input('tipo_receita_id'),
            'valor_recebido' => $valorReceita,
            'data_entrada' => $request->input('data_entrada'),
            'id_usuario' => $idUsuario
        ]);

        return redirect('/cadastrar/receita')->with('success', 'Nova receita salva com sucesso');
    }

    public function edit($id)
    {

        $idUsuario = Auth::id();
        $tipoReceita = TipoReceita::where('id_usuario', $idUsuario)->get();
        $receitas = Receita::where('id', $id)->first();

        return view('edit.editar_receita', ['receitas' => $receitas, 'tipoReceita' => $tipoReceita]);
    }

    public function update(Request $request, $id)
    {

        $mensagens = [
            'tipo_receita_id.required' => 'O campo Tipo de Receita é obrigatório.',
            'valor_recebido.required' => 'O campo Valor Recebido é obrigatório.',
        ];
    
        $request->validate([
            'tipo_receita_id' => 'required',
            'valor_recebido' => 'required',
        ], $mensagens);
    
        $valorReceita = $request->input('valor_recebido');
        $valorReceita = str_replace('.', '', $valorReceita);
        $valorReceita = str_replace(',', '.', $valorReceita);    
    
        $receita = Receita::find($id);
    
        if (!$receita) {
            return redirect('/dashboard')->with('error', 'Receita não encontrada');
        }
    
        $receita->tipo_receita_id = $request->input('tipo_receita_id');
        $receita->valor_recebido = $valorReceita;

        $receita->save();
    
        return redirect('/dashboard')->with('success', 'Receita atualizada com sucesso');
    }
}
