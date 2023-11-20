<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\Receita;
use Illuminate\Http\Request;
Use App\Models\TipoDespesa;

class Dashboard extends Controller
{
    public function getData($month) {
        $receitas = Receita::whereRaw("EXTRACT(MONTH FROM data_Entrada) = ?", [$month])->get();
        $despesas = Despesa::whereRaw("EXTRACT(MONTH FROM data_vencimento) = ?", [$month])->get();
        $despesasComNomes = $despesas->map(function ($despesa) {
        $nomeDespesa = $despesa->tipoDespesa->nome_despesa;
    
            // Adiciona o nome_despesa aos atributos da despesa
            $despesa->nome_despesa = $nomeDespesa;

            return $despesa;
        });
    
        $somaValoresReceitas = $receitas->sum('valor_recebido');
        $somaValoresDespesas = $despesas->sum('valor');
    
        $result = [
            'receitas' => $receitas,
            'despesas' => $despesasComNomes, // Use o array com os nomes adicionados
            'soma_valores_receitas' => $somaValoresReceitas,
            'soma_valores_despesas' => $somaValoresDespesas,
        ];
    
        return response()->json(['data' => $result]);
        
    }
}
