<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use App\Models\Receita;
use Illuminate\Http\Request;
use App\Models\TipoDespesa;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;




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

        $somaValoresDespesasPagas = Despesa::whereRaw("EXTRACT(MONTH FROM data_vencimento) = ? AND pago = 'S'", [$month])
            ->where('id_usuario', $idUsuario)
            ->select(DB::raw('SUM(CAST(valor AS numeric)) as total_valor'))
            ->first()
            ->total_valor ?? 0;

        $despesasComNomes = $despesas->map(function ($despesa) {
            $nomeDespesa = $despesa->tipoDespesa->nome_despesa;
            $despesa->nome_despesa = $nomeDespesa;
            $despesa->data_vencimento = Carbon::parse($despesa->data_vencimento)->format('d/m/Y');
            return $despesa;
        });
        $somaValoresReceitas = $receitas->sum('valor_recebido');
        $somaValoresDespesas = $despesas->sum('valor');

        $result = [
            'receitas' => $receitas,
            'despesas' => $despesasComNomes,
            'soma_valores_receitas' => $somaValoresReceitas,
            'soma_valores_despesas' => $somaValoresDespesas,
            'soma_valores_despesas_pagas' => $somaValoresDespesasPagas,

        ];

        return response()->json(['data' => $result]);
    }

    public function confirmarPagamento($idDespesa)
    {
        $result = Despesa::where('id', $idDespesa)
            ->update(['pago' => 'S']);

        return response()->json(['data' => $result]);
    }


    public function disconnect()
    {
        Auth::logout();
        return redirect()->route('/'); 
    }
}
