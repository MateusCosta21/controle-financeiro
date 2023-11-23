<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\TipoDespesa;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    
    public function relatorioDespesas(Request $request)
    {
        $tipoDespesa = TipoDespesa::all();
        $dataInicial = $request->input('dataInicial');
        $dataFinal = $request->input('dataFinal');
        $tipoDespesaId = $request->input('tipo_despesa_id');

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
    public function relatorioReceitas(){
        return view('relatorios.relatorio_receitas');
    }


}
