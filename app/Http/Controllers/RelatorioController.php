<?php

namespace App\Http\Controllers;

use App\Models\TipoDespesa;

use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    
    public function relatorioDespesas(){
        $tipoDespesa = TipoDespesa::all();
        return view('relatorios.relatorio_despesas',compact('tipoDespesa'));
    }
    public function relatorioReceitas(){
        return view('relatorios.relatorio_receitas');
    }
}
