<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoDespesa;
use Illuminate\Support\Facades\Auth;

class ContasController extends Controller
{
      public function index()
    {
        $idUsuario = Auth::id();
        $tipoDespesa = TipoDespesa::where('id_usuario', $idUsuario)->get();
        return view('despesas.cadastrar', compact('tipoDespesa'));
    }

  
}
