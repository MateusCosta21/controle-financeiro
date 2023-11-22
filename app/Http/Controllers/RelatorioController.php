<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    
    public function relatorioDespesas(){
        return view('relatorios.relatorio_despesas');
    }
    public function relatorioReceitas(){
        return view('relatorios.relatorio_receitas');
    }
}
