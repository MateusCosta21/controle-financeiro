<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\Receita;
use Illuminate\Http\Request;
use App\Models\TipoDespesa;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class Dashboard extends Controller
{
    public function getData($month)
    {
        $idUsuario = Auth::id();
        $receitas = Receita::whereRaw("EXTRACT(MONTH FROM data_Entrada) = ?", [$month])
            ->where('id_usuario', $idUsuario)
            ->get();

        $despesas = Despesa::whereRaw("EXTRACT(MONTH FROM data_vencimento) = ?", [$month])
            ->where('id_usuario', $idUsuario)
            ->get();

        $despesasComNomes = $despesas->map(function ($despesa) {
            $nomeDespesa = $despesa->tipoDespesa->nome_despesa;
            $despesa->nome_despesa = $nomeDespesa;
            // Formata a data para dd/mm/aaaa
            $despesa->data_vencimento = \Carbon\Carbon::parse($despesa->data_vencimento)->format('d/m/Y');
            return $despesa;
        });
        $somaValoresReceitas = $receitas->sum('valor_recebido');
        $somaValoresDespesas = $despesas->sum('valor');

        $result = [
            'receitas' => $receitas,
            'despesas' => $despesasComNomes,
            'soma_valores_receitas' => $somaValoresReceitas,
            'soma_valores_despesas' => $somaValoresDespesas,
        ];

        return response()->json(['data' => $result]);
    }
}
