<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoDespesa;

class ContasController extends Controller
{
      public function index()
    {
        $tipoDespesa = TipoDespesa::all();
        return view('despesas.cadastrar', compact('tipoDespesa'));
    }

  
}
