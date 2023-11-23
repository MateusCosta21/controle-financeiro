@extends('layouts.inicial')

@section('relatorio-despesas')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Receitas</h1>
        </div>
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Formulário de Receitas</h6>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="dataInicial">Data Inicial:</label>
                                <input type="date" class="form-control" id="dataInicial" name="dataInicial">
                            </div>
                            <div class="form-group">
                                <label for="dataFinal">Data Final:</label>
                                <input type="date" class="form-control" id="dataFinal" name="dataFinal">
                            </div>
                            <div class="form-group">
                                <label for="tipoDespesa">Tipo de Despesa:</label>
                                <select class="form-control" id="tipoDespesa" name="tipo_despesa_id">
                                    <option value="" selected disabled>Selecione</option>
                                    @foreach ($tipoDespesa as $despesa)
                                        <option value="{{ $despesa->id }}">{{ $despesa->nome_despesa }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Gerar Relatório</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
