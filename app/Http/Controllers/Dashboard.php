<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\Receita;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function getData($month) {
        $receitas = Receita::whereRaw("EXTRACT(MONTH FROM data_Entrada) = ?", [$month])->get();
        $despesas = Despesa::whereRaw("EXTRACT(MONTH FROM data_vencimento) = ?", [$month])->get();

        $somaValoresReceitas = $receitas->sum('valor_recebido');
        $somaValoresDespesas = $despesas->sum('valor');

        $result = [
            'receitas' => $receitas,
            'despesas' => $despesas,
            'soma_valores_receitas' => $somaValoresReceitas,
            'soma_valores_despesas' => $somaValoresDespesas,
        ];
        return response()->json(['data' => $result]);
    }
}
