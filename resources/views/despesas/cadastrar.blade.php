@extends('layouts.inicial')

@section('despesas')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Despesas</h1>
        </div>
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Formulário de Despesas</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cadastrar.nova_despesa') }}" method="post">
                            @csrf
                            <!-- Tipo de Despesa (Select) -->
                            <div class="form-group">
                                <label for="tipoDespesa">Tipo de Despesa</label>
                                <div class="input-group">
                                    <select class="form-control" id="tipoDespesa" name="tipo_despesa_id">
                                        <option value="" selected disabled>Selecione</option>
                                        @foreach ($tipoDespesa as $despesa)
                                            <option value="{{ $despesa->id }}">{{ $despesa->nome_despesa }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#modalNovoTipoDespesa"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <!-- Valor da Despesa -->
                            <div class="form-group">
                                <label for="valorDespesa">Valor da Despesa</label>
                                <input type="text" class="form-control" id="valorDespesa" name="valor_despesa"
                                    placeholder="Informe o valor">
                            </div>

                            <!-- Data de Vencimento -->
                            <div class="form-group">
                                <label for="dataVencimento">Data de Vencimento</label>
                                <input type="date" class="form-control" id="dataVencimento" name="data_vencimento">
                            </div>
                            <!-- Botão de Envio -->
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Novo Tipo de Despesa -->
    <div class="modal fade" id="modalNovoTipoDespesa" tabindex="-1" role="dialog"
        aria-labelledby="modalNovoTipoDespesaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNovoTipoDespesaLabel">Novo Tipo de Despesa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('cadastrar.tipo_despesa') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="Tipo">Tipo Despesa</label>
                            <input type="text" class="form-control" id="nome_despesa" name="nome_despesa"
                                placeholder="Informe o tipo">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
