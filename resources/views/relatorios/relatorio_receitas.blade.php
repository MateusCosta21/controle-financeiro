@extends('layouts.inicial')

@section('relatorio-receitas')
    <div class="container-fluid">
        <!-- Page Heading -->
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Relatório de Receitas</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('relatorio.gerarRelatorioReceitas') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="dataInicial">Data Inicial:</label>
                                <input type="date" class="form-control" id="dataInicial" name="dataInicial">
                            </div>
                            <div class="form-group">
                                <label for="dataFinal">Data Final:</label>
                                <input type="date" class="form-control" id="dataFinal" name="dataFinal">
                            </div>
                            <div class="form-group">
                                <label for="tipoReceita">Tipo de receita:</label>
                                <select class="form-control" id="tipoReceita" name="tipo_receita_id">
                                    <option value="" selected disabled>Selecione</option>
                                    @foreach ($tipoReceita as $receita)
                                        <option value="{{ $receita->id }}">{{ $receita->nome_receita }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Gerar Relatório</button>
                        </form>
                    </div>
                </div>
                @if (isset($result) && count($result) > 0)
                <h5 class="text-center"> Relatório de Receitas de {{ $dataInicial->format('d/m/Y') }} a {{ $dataFinal->format('d/m/Y') }} </h5><br>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Categoria receita</th>
                                    <th>Valor receita</th>
                                    <th>Data Entrada</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $receita)
                                    <tr>
                                        <td>{{ $receita->nome_receita }}</td>
                                        <td>R$ {{ number_format($receita->valor_recebido, 2, ',', '.') }}</td>
                                        <td>{{ date('d/m/Y', strtotime($receita->data_entrada)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                       
                        <div class="total-receitas text-primary">
                            Total das receitas: R${{ number_format($totalReceitas, 2, ',', '.') }}
                        </div>
                    </div>
                @else
                    <p>Nenhum resultado encontrado.</p>
                @endif
            </div>
        </div>
    </div>

@endsection
