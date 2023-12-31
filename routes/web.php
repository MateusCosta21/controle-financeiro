<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContasController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\ReceitaController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\TipoDespesaController;
use App\Http\Controllers\TipoReceitaController;
use App\Models\Despesa;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/cadastrar', [ContasController::class, 'index'])->name('cadastrar.index');
    Route::post('/novo_tipo', [TipoDespesaController::class, 'salvarTipoDespesa'])->name('cadastrar.tipo_despesa');
    Route::post('/nova_despesa', [DespesaController::class, 'salvarNovaDespesa'])->name('cadastrar.nova_despesa');
    Route::get('/cadastrar/receita', [ReceitaController::class, 'index'])->name('cadastrar.receita');
    Route::post('/novo_tipo_receita', [TipoReceitaController::class, 'salvarTipoReceita'])->name('cadastrar.tipo_receita');
    Route::post('/nova_receita', [ReceitaController::class, 'salvarNovaReceita'])->name('cadastrar.nova_receita');
    Route::get('/getData/{mes}', [Dashboard::class, 'getData'])->name('dashboard.mes');
    Route::post('/salvaAno', [Dashboard::class, 'salvaAno'])->name('salvaAno');

    Route::post('/confirmarPagamento/{idDespesa}', [Dashboard::class, 'confirmarPagamento'])->name('dashboard.confirmaPagamento');
    Route::get('/relatorio_despesas', [RelatorioController::class, 'relatorioDespesas'])->name('relatorio.despesas');
    Route::get('/relatorio_receitas', [RelatorioController::class, 'relatorioReceitas'])->name('relatorio.receitas');
    Route::get('/relatorio_despesas_receita', [RelatorioController::class, 'relatorioDespesasReceitas'])->name('relatorio.despesas_receitas');
    Route::POST('/relatorio_despesas_receita', [RelatorioController::class, 'relatorioDespesasReceitas'])->name('relatorio.despesas_receitas');

    Route::post('/gerar_relatorio_despesas', [RelatorioController::class, 'relatorioDespesas'])->name('relatorio.gerarRelatorioDespesas');
    Route::post('/gerar_relatorio_receita', [RelatorioController::class, 'relatorioReceitas'])->name('relatorio.gerarRelatorioReceitas');
    Route::post('/disconnect', [Dashboard::class, 'disconnect'])->name('disconnect');

    Route::get('/receita/edit/{id}', [ReceitaController::class, 'edit'])->name('receita.edit');
    Route::put('/receita/update/{id}', [ReceitaController::class, 'update'])->name('receita.update');
    Route::delete('/receita/delete/{id}', [ReceitaController::class, 'softDelete'])->name('receita.softDelete');


    Route::get('/despesa/edit/{id}', [DespesaController::class, 'edit'])->name('despesa.edit');
    Route::put('/despesa/update/{id}', [DespesaController::class, 'update'])->name('despesa.update');
    Route::delete('/despesa/delete/{id}', [DespesaController::class, 'softDelete'])->name('despesa.softDelete');









});



require __DIR__.'/auth.php';
