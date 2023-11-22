@extends('layouts.inicial')

@section('receitas')
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
                        <form action="{{route('cadastrar.nova_receita')}}" method="post">
                            @csrf
                            <!-- Tipo de Receita (Select) -->
                            <div class="form-group">
                                <label for="tipoReceita">Tipo Receita</label>
                                <div class="input-group">
                                    <select class="form-control" id="tipoDespesa" name="tipo_receita_id">
                                        <option value="" selected disabled>Selecione</option>
                                        @foreach ($tipoReceita as $receita)
                                            <option value="{{ $receita->id }}">{{ $receita->nome_receita }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#modalNovoTipoReceita"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <!-- Valor da Receita -->
                            <div class="form-group">
                                <label for="valorReceita">Valor da Receita</label>
                                <input type="text" class="form-control" id="valorReceita" name="valor_recebido"
                                    placeholder="Informe o valor">
                            </div>
                            <!-- Data de Vencimento -->
                            <div class="form-group">
                                <label for="data_entrada">Data de Entrada</label>
                                <input type="date" class="form-control" id="dataEntrada" name="data_entrada">
                            </div>
                            <!-- Botão de Envio -->
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Novo Tipo de Receita -->
    <div class="modal fade" id="modalNovoTipoReceita" tabindex="-1" role="dialog"
        aria-labelledby="modalNovoTipoReceitaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNovoTipoReceitaLabel">Novo Tipo de Receita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('cadastrar.tipo_receita') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="Tipo">Tipo Receita</label>
                            <input type="text" class="form-control" id="nome_receita" name="nome_receita"
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