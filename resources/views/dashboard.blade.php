@extends('layouts.inicial')
@section('dashboard')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <div class="form-group">
                <label for="selectMonth">Selecionar Mês:</label>
                <select class="form-control" id="selectMonth" onchange="loadData()">
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="2">Março</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>
            </div>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Gerar Relatório
            </a>
        </div>
        <!-- Content Row -->
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Receitas</div>
                                <div id="receitasTotal" class="h5 mb-0 font-weight-bold text-gray-800">R$40,000</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Despesas</div>
                                <div id="despesasTotal" class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending Requests</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmarPagamentoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmar Pagamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente confirmar o pagamento desta conta?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="confirmarPagamento()">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Controle Contas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="dynamicContent"></div>
            </div>
        </div>

        <script>
            var table; // Mova a declaração da variável table para fora da função

            function loadData() {
                var selectedMonth = document.getElementById("selectMonth").value;
                var url = '/getData/' + selectedMonth;

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        var somaValoresReceitas = data.data.soma_valores_receitas;
                        var somaValoresDespesas = data.data.soma_valores_despesas;
                        document.getElementById("receitasTotal").innerHTML = '$' + somaValoresReceitas;
                        document.getElementById("despesasTotal").innerHTML = '$' + somaValoresDespesas;

                        // Verifique se a tabela já existe
                        if (!table) {
                            // Se não existir, crie uma nova tabela
                            table = document.createElement('table');
                            table.setAttribute('class', 'table table-bordered');
                            table.setAttribute('id', 'dataTable');
                            var thead = table.createTHead();
                            var headerRow = thead.insertRow();
                            headerRow.innerHTML =
                                '<th>Tipo de Despesa</th><th>Valor</th><th>Data de Vencimento</th><th>Pagar</th>';
                            table.appendChild(thead);

                            var tbody = table.createTBody();
                        } else {
                            // Se a tabela já existir, limpe o corpo
                            var tbody = table.tBodies[0];
                            tbody.innerHTML = '';
                        }

                        // Adicione as linhas da tabela com os dados das despesas
                        data.data.despesas.forEach(function(despesa) {
                            var tr = tbody.insertRow();

                            var tipoDespesaCell = tr.insertCell(0);
                            tipoDespesaCell.appendChild(document.createTextNode(despesa.nome_despesa));

                            var valorCell = tr.insertCell(1);
                            valorCell.appendChild(document.createTextNode(despesa.valor));

                            var dataVencimentoCell = tr.insertCell(2);
                            dataVencimentoCell.appendChild(document.createTextNode(despesa
                                .data_vencimento));

                            // Adicione a coluna de checkbox para cada despesa
                            var pagarButtonCell = tr.insertCell(3);
                            var pagarButton = document.createElement('button');
                            pagarButton.setAttribute('class',
                            'btn btn-success btn-sm'); // Remova a classe btn-block
                            pagarButton.setAttribute('data-toggle', 'modal');
                            pagarButton.setAttribute('data-target', '#confirmarPagamentoModal');
                            pagarButton.setAttribute('data-id', despesa
                            .id); // Substitua 'id' pelo nome correto do identificador da despesa
                            pagarButton.appendChild(document.createTextNode('Pagar'));
                            pagarButtonCell.appendChild(pagarButton);
                        });

                        // Defina as mesmas classes para a tabela dinâmica
                        table.setAttribute('class', 'table table-bordered text-center'); // Adicione a classe text-center
                        table.setAttribute('id', 'dataTable');
                        table.setAttribute('id', 'dataTable');

                        // Substitua o conteúdo da div "dynamicContent" pela tabela
                        var dynamicContentDiv = document.getElementById("dynamicContent");
                        dynamicContentDiv.innerHTML = '';
                        dynamicContentDiv.appendChild(table);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            function confirmarPagamento() {
                // Fechar o modal após a confirmação
                $('#confirmarPagamentoModal').modal('hide');
            }
        </script>

        <!-- /.container-fluid -->
    @endsection
