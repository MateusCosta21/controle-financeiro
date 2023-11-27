<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\Receita;
use App\Models\TipoDespesa;
use App\Models\TipoReceita;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;





class RelatorioController extends Controller
{

    public function relatorioDespesas(Request $request)
    {
        $tipoDespesa = TipoDespesa::all();
        $dataInicial = Carbon::parse($request->input('dataInicial'));
        $dataFinal = Carbon::parse($request->input('dataFinal'));
        $tipoDespesaId = $request->input('tipo_despesa_id');
        $idUsuario = Auth::id();



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
            ->whereBetween('data_vencimento', [$dataInicial, $dataFinal])
            ->where('id_usuario', $idUsuario);

        if ($tipoDespesaId !== null) {
            $despesas->where('tipo_despesa_id', $tipoDespesaId);
        }

        $result = $despesas->get();
        $totalDespesas = $result->sum('valor');

        return view('relatorios.relatorio_despesas', compact('result', 'tipoDespesa', 'totalDespesas', 'dataInicial', 'dataFinal'));
    }
    public function relatorioReceitas(Request $request)
    {
        $idUsuario = Auth::id();
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
            ->whereBetween('data_entrada', [$dataInicial, $dataFinal])
            ->where('id_usuario', $idUsuario);

        if ($tipoReceitaId !== null) {
            $receitas->where('tipo_despesa_id', $tipoReceitaId);
        }

        $result = $receitas->get();
        $totalReceitas = $result->sum('valor_recebido');


        return view('relatorios.relatorio_receitas', compact('result', 'tipoReceita', 'totalReceitas'));
    }
    public function relatorioDespesasReceitas(Request $request)
    {
        $idUsuario = Auth::id();
        $anoAtual = session('selectedYear');


        // Calcule os totais para cada mês do ano
        $totaisMensais = [];
        for ($mes = 1; $mes <= 12; $mes++) {
            $totalDespesas = Despesa::where('id_usuario', $idUsuario)
                ->whereRaw('CAST(valor AS NUMERIC) IS NOT NULL')
                ->whereYear('data_vencimento', '=', $anoAtual)
                ->whereMonth('data_vencimento', '=', $mes)
                ->sum(DB::raw('CAST(valor AS NUMERIC)'));
    
            $totalReceitas = Receita::where('id_usuario', $idUsuario)
                ->whereRaw('CAST(valor_recebido AS NUMERIC) IS NOT NULL')
                ->whereYear('data_entrada', '=', $anoAtual)
                ->whereMonth('data_entrada', '=', $mes)
                ->sum(DB::raw('CAST(valor_recebido AS NUMERIC)'));
    
            $totaisMensais[] = [
                'mes' => ucfirst(Carbon::createFromFormat('!m', $mes)->locale('pt_BR')->monthName),
                'totalDespesas' => $totalDespesas,
                'totalReceitas' => $totalReceitas,
            ];
        }
    
        return view('relatorios.relatorio_despesas_receitas', compact('totaisMensais', 'anoAtual'));
    }
    
}
