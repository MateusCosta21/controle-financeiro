<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\Receita;
use App\Models\TipoDespesa;
use App\Models\TipoReceita;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{

    public function relatorioDespesas(Request $request)
    {
        $tipoDespesa = TipoDespesa::all();
        $dataInicial = $request->input('dataInicial');
        $dataFinal = $request->input('dataFinal');
        $tipoDespesaId = $request->input('tipo_despesa_id');


        if ($request->isMethod('post')) {
            $mensagens = [
                'dataInicial.required' => 'O campo Data Inicial é obrigatório.',
                'dataInicial.date' => 'O campo Data Inicial deve ser uma data válida.',
                'dataFinal.required' => 'O campo Data Final é obrigatório.',
                'dataFinal.date' => 'O campo Data Final deve ser uma data válida.',
                'dataFinal.after_or_equal' => 'O campo Data Final deve ser posterior ou igual à Data Inicial.',
            ];

            $request->validate([
                'dataInicial' => 'required|date',
                'dataFinal' => 'required|date|after_or_equal:dataInicial',
            ], $mensagens);
        }

        $despesas = Despesa::select('despesas.*', 'tipo_despesas.nome_despesa')
            ->join('tipo_despesas', 'despesas.tipo_despesa_id', '=', 'tipo_despesas.id')
            ->whereBetween('data_vencimento', [$dataInicial, $dataFinal]);

        if ($tipoDespesaId !== null) {
            $despesas->where('tipo_despesa_id', $tipoDespesaId);
        }

        $result = $despesas->get();
        $totalDespesas = $result->sum('valor');


        return view('relatorios.relatorio_despesas', compact('result', 'tipoDespesa', 'totalDespesas'));
    }
    public function relatorioReceitas(Request $request)
    {
        $tipoReceita = TipoReceita::all();
        $dataInicial = $request->input('dataInicial');
        $dataFinal = $request->input('dataFinal');
        $tipoReceitaId = $request->input('tipo_receita_id');


        if ($request->isMethod('post')) {
            $mensagens = [
                'dataInicial.required' => 'O campo Data Inicial é obrigatório.',
                'dataInicial.date' => 'O campo Data Inicial deve ser uma data válida.',
                'dataFinal.required' => 'O campo Data Final é obrigatório.',
                'dataFinal.date' => 'O campo Data Final deve ser uma data válida.',
                'dataFinal.after_or_equal' => 'O campo Data Final deve ser posterior ou igual à Data Inicial.',
            ];

            $request->validate([
                'dataInicial' => 'required|date',
                'dataFinal' => 'required|date|after_or_equal:dataInicial',
            ], $mensagens);
        }

        $receitas = Receita::select('receitas.*', 'tipo_receitas.nome_receita')
            ->join('tipo_receitas', 'receitas.tipo_receita_id', '=', 'tipo_receita_id')
            ->whereBetween('data_entrada', [$dataInicial, $dataFinal]);

        if ($tipoReceitaId !== null) {
            $receitas->where('tipo_despesa_id', $tipoReceitaId);
        }

        $result = $receitas->get();
        $totalReceitas = $result->sum('valor_recebido');


        return view('relatorios.relatorio_receitas', compact('result', 'tipoReceita', 'totalReceitas'));
    }
}
