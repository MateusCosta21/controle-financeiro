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
        $year = session('selectedYear');
        if($year == ''){
            $selectedYear = date('Y');
            session(['selectedYear' => $selectedYear]);
            $year = session('selectedYear');
        }
        $idUsuario = Auth::id();
        $receitas = Receita::whereYear('data_entrada', '=', $year)
            ->whereMonth('data_entrada', '=', $month)
            ->where('id_usuario', $idUsuario)
            ->get();
    
        $despesas = Despesa::whereYear('data_vencimento', '=', $year)
            ->whereMonth('data_vencimento', '=', $month)
            ->where('id_usuario', $idUsuario)
            ->get();
    
        $somaValoresDespesasPagas = Despesa::whereYear('data_vencimento', '=', $year)
            ->whereMonth('data_vencimento', '=', $month)
            ->where('pago', 'S')
            ->where('id_usuario', $idUsuario)
            ->sum('valor'); // Adjusted to use sum directly without casting
    
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
        return redirect()->route('login');
    }


    public function salvaAno(Request $request)
    {
        $selectedYear = $request->input('selectedYear');

        session(['selectedYear' => $selectedYear]);

        return response()->json(['success' => true]);
    }
}
