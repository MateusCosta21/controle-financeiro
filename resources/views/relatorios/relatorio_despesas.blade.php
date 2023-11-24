@extends('layouts.inicial')

@section('relatorio-despesas')
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
                        <h6 class="m-0 font-weight-bold text-primary">Relatório de Despesas</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('relatorio.gerarRelatorioDespesas') }}" method="post">
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
                @if (isset($result) && count($result) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Categoria Despesa</th>
                                    <th>Valor Despesa</th>
                                    <th>Data Vencimento</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $despesa)
                                    <?php
                                    if ($despesa->pago == 'S') {
                                        $classeBadge = 'badge-success';
                                        $status = 'Pago';
                                    } else {
                                        $classeBadge = 'badge-danger';
                                        $status = 'Pendente Pagamento';
                                    }
                                    ?>
                                    <tr>
                                        <td>{{ $despesa->nome_despesa }}</td>
                                        <td>R$ {{ number_format($despesa->valor, 2, ',', '.') }}</td>
                                        <td>{{ date('d/m/Y', strtotime($despesa->data_vencimento)) }}</td>
                                        <td><span class="badge {{ $classeBadge }}">{{ $status }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                       
                        <div class="total-despesas text-primary">
                            Total das Despesas: {{ number_format($totalDespesas, 2, ',', '.') }}
                        </div>
                    </div>
                @else
                    <p>Nenhum resultado encontrado.</p>
                @endif
            </div>
        </div>
    </div>

@endsection
