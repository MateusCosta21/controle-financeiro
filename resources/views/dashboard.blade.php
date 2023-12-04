@extends('layouts.inicial')
@section('dashboard')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <button class="btn btn-warning" data-toggle="modal" data-target="#selectYearModal">
            <i class="fas fa-calendar"></i>
        </button>

        <div class="modal fade" id="selectYearModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Selecionar Ano</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Escolha o ano desejado:</p>
                        <select class="form-control" id="selectYear">
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <!-- Adicione mais opções conforme necessário -->
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="salvaAno()">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <div class="form-group mx-auto"> <!-- Add mx-auto class for horizontal centering -->
                <label for="selectMonth">Selecionar Mês:</label>
                <select class="form-control" id="selectMonth" onchange="loadData()">
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
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
        </div>
        <!-- Content Row -->
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Receitas</div>
                                <div id="receitasTotal" class="h5 mb-0 font-weight-bold text-gray-800"></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-md-4 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Despesas</div>
                                <div id="despesasTotal" class="h5 mb-0 font-weight-bold text-gray-800"></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-md-4 mb-4">
                <div class="card border-left-warning shadow h-100 py-2" id="saldoCard">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Saldo Atual</div>
                                <div id="saldoTotal" class="h5 mb-0 font-weight-bold text-gray-800"></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chevron-circle-up fa-2x" id="grafico"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" id="confirmarPagamentoModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <h6 class="m-0 font-weight-bold text-primary">Controle Despesas</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="dynamicContent"></div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Controle Receitas</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="dynamicContentReceitas"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalConfirmacaoDeletar" tabindex="-1" role="dialog"
            aria-labelledby="modalConfirmacaoDeletarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalConfirmacaoDeletarLabel">Confirmação de Exclusão</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Tem certeza que deseja deletar esta receita?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmarDeletar">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var table;

            function createReceitasTable(receitasData) {
                var token = document.head.querySelector('meta[name="csrf-token"]').content;
                var receitasTable = document.createElement('table');
                receitasTable.setAttribute('class', 'table table-bordered');
                receitasTable.setAttribute('id', 'receitasTable');

                var thead = receitasTable.createTHead();
                var headerRow = thead.insertRow();
                headerRow.innerHTML = '<th>Tipo de Receita</th><th>Valor Recebido</th><th>Data de Entrada</th><th>Ações</th>';

                var tbody = receitasTable.createTBody();

                receitasData.forEach(function(receita) {
                    var tr = tbody.insertRow();

                    var tipoReceitaCell = tr.insertCell(0);
                    tipoReceitaCell.appendChild(document.createTextNode(receita.nome_receita));

                    var valorRecebidoCell = tr.insertCell(1);
                    valorRecebidoCell.appendChild(document.createTextNode('R$ ' + receita.valor_recebido));

                    var dataEntradaCell = tr.insertCell(2);
                    dataEntradaCell.appendChild(document.createTextNode(receita.data_entrada));

                    var acoesCell = tr.insertCell(3);

                    // Contêiner para os botões
                    var botoesContainer = document.createElement('div');
                    botoesContainer.style.display = 'flex'; // Garante que os botões fiquem em linha
                    acoesCell.appendChild(botoesContainer);

                    // Botão Editar
                    var editarButton = document.createElement('button');
                    editarButton.className = 'btn btn-info';
                    var iconElementEditar = document.createElement('i');
                    iconElementEditar.className = 'fas fa-edit';
                    editarButton.appendChild(iconElementEditar);
                    editarButton.addEventListener('click', function() {
                        window.location.href = '/receita/edit/' + receita.id;
                    });
                    botoesContainer.appendChild(editarButton);

                    // Adiciona um espaçamento lateral
                    var espacamento = document.createElement('div');
                    espacamento.style.width = '10px'; // Defina a largura do espaçamento conforme necessário
                    botoesContainer.appendChild(espacamento);

                    // Botão Deletar
                    var deletarButton = document.createElement('button');
                    deletarButton.className = 'btn btn-danger ';
                    var iconElementDeletar = document.createElement('i');
                    iconElementDeletar.className = 'fas fa-trash';
                    deletarButton.appendChild(iconElementDeletar);
                    botoesContainer.appendChild(deletarButton);
                    deletarButton.addEventListener('click', function() {
                        $('#modalConfirmacaoDeletar').modal('show');

                        $('#confirmarDeletar').on('click', function() {
                            fetch('/receita/delete/' + receita.id, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': token,
                                        'Content-Type': 'application/json',
                                    },
                                })
                                .then(response => response.json())
                                .then(data => {
                                    alert("Receita deletada com sucesso");
                                    $('#modalConfirmacaoDeletar').modal('hide');
                                    window.location.reload();
                                })
                                .catch(error => console.error('Erro ao deletar receita:', error));
                        });
                    });
                    botoesContainer.appendChild(deletarButton);
                });

                return receitasTable;
            }

            function salvaAno() {
                var selectedYear = document.getElementById('selectYear').value;

                $.ajax({
                    type: 'POST',
                    url: '/salvaAno',
                    data: {
                        selectedYear: selectedYear,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        $('#selectYearModal').modal('hide');
                        loadData();
                    }
                });
            }

            function loadData() {
                var selectedMonth = document.getElementById("selectMonth").value;
                var url = '/getData/' + selectedMonth;
                var token = document.head.querySelector('meta[name="csrf-token"]').content;


                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        var somaValoresReceitas = data.data.soma_valores_receitas;
                        var somaValoresDespesas = data.data.soma_valores_despesas;
                        var saldoAtual = somaValoresReceitas - data.data.soma_valores_despesas_pagas;

                        somaValoresReceitas = somaValoresReceitas.toFixed(2);
                        somaValoresDespesas = somaValoresDespesas.toFixed(2);
                        saldoAtual = saldoAtual.toFixed(2);

                        $("#receitasTotal").text('R$ ' + somaValoresReceitas);
                        $("#despesasTotal").text('R$ ' + somaValoresDespesas);
                        $("#saldoTotal").text('R$ ' + saldoAtual);

                        var saldoCard = $("#saldoCard");
                        var grafico = $("#grafico");

                        saldoCard.removeClass("border-left-warning border-left-danger border-left-success");
                        grafico.removeClass("fas fa-chevron-circle-up fa-2x");

                        if (saldoAtual < 0) {
                            saldoCard.addClass("border-left-danger");
                            grafico.addClass("fas fa-chevron-circle-down fa-2x").css("color", "red");

                        } else if (saldoAtual === 0) {
                            saldoCard.addClass("border-left-gray");
                            grafico.addClass("fas fa-chevron-circle-up fa-2x").css("color", "gray");

                        } else {
                            saldoCard.addClass("border-left-success");
                            grafico.addClass("fas fa-chevron-circle-up fa-2x").css("color", "green");
                        }
                        if (!table) {
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
                            var tbody = table.tBodies[0];
                            tbody.innerHTML = '';
                        }

                        data.data.despesas.forEach(function(despesa) {
                            var tr = tbody.insertRow();

                            var tipoDespesaCell = tr.insertCell(0);
                            tipoDespesaCell.appendChild(document.createTextNode(despesa.nome_despesa));

                            var valorCell = tr.insertCell(1);
                            valorCell.appendChild(document.createTextNode('R$ ' + despesa.valor));

                            var dataVencimentoCell = tr.insertCell(2);
                            dataVencimentoCell.appendChild(document.createTextNode(despesa
                                .data_vencimento));

                            var pagarButtonCell = tr.insertCell(3);

                            if (despesa.pago === "S") {
                                pagarButtonCell.innerHTML =
                                    '<button class="btn btn-success btn-sm" disabled>Pago</button>';
                                tipoDespesaCell.style.textDecoration = 'line-through';
                                valorCell.style.textDecoration = 'line-through';
                                dataVencimentoCell.style.textDecoration = 'line-through';
                            } else {
                                var pagarButton = document.createElement('button');
                                pagarButton.setAttribute('class', 'btn btn-success btn-sm');
                                pagarButton.setAttribute('data-toggle', 'modal');
                                pagarButton.setAttribute('data-target', '#confirmarPagamentoModal');
                                pagarButton.setAttribute('data-id', despesa.id);
                                pagarButton.addEventListener('click', function() {
                                    idDespesaParaConfirmar = despesa.id;
                                });
                                pagarButton.appendChild(document.createTextNode('Pagar'));
                                pagarButtonCell.appendChild(pagarButton);

                                // Add Edit Button
                                var editarButton = document.createElement('button');
                                editarButton.setAttribute('class', 'btn btn-info btn-sm ml-1');
                                editarButton.setAttribute('data-toggle', 'modal');
                                editarButton.setAttribute('data-target', '#editarDespesaModal');
                                editarButton.setAttribute('data-id', despesa.id);
                                editarButton.addEventListener('click', function() {
                                    window.location.href = '/despesa/edit/' + despesa.id;
                                });
                                editarButton.innerHTML =
                                '<i class="fas fa-edit"></i>'; // Font Awesome icon
                                pagarButtonCell.appendChild(editarButton);

                                // Add Delete Button
                                var deletarButton = document.createElement('button');
                                deletarButton.setAttribute('class', 'btn btn-danger btn-sm ml-1');
                                deletarButton.setAttribute('data-id', despesa.id);
                                deletarButton.innerHTML = '<i class="fas fa-trash"></i>';
                                deletarButton.addEventListener('click', function() {
                                    $('#modalConfirmacaoDeletar').modal('show');

                                    $('#confirmarDeletar').on('click', function() {
                                        fetch('/despesa/delete/' + despesa.id, {
                                                method: 'DELETE',
                                                headers: {
                                                    'X-CSRF-TOKEN': token,
                                                    'Content-Type': 'application/json',
                                                },
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                alert("Despesa deletada com sucesso");
                                                $('#modalConfirmacaoDeletar').modal(
                                                    'hide');
                                                window.location.reload();
                                            })
                                            .catch(error => console.error(
                                                'Erro ao deletar despesa:', error));
                                    });
                                });
                                pagarButtonCell.appendChild(deletarButton);
                            }
                        });


                        table.setAttribute('class',
                            'table table-bordered text-center');
                        table.setAttribute('id', 'dataTable');
                        table.setAttribute('id', 'dataTable');

                        var dynamicContentDiv = document.getElementById("dynamicContent");
                        dynamicContentDiv.innerHTML = '';
                        dynamicContentDiv.appendChild(table);
                        var receitasData = data.data.receitas;

                        var receitasTable = createReceitasTable(receitasData);
                        var dynamicContentReceitasDiv = document.getElementById("dynamicContentReceitas");
                        dynamicContentReceitasDiv.innerHTML = ''; // Clear previous content
                        dynamicContentReceitasDiv.appendChild(receitasTable);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            function confirmarPagamento() {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                if (idDespesaParaConfirmar !== null) {
                    $.ajax({
                        url: '/confirmarPagamento/' + idDespesaParaConfirmar,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(response) {
                            alert("Pagamento confirmado");
                            loadData();

                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });

                    $('#confirmarPagamentoModal').modal('hide');

                    idDespesaParaConfirmar = null;
                }
            }

            window.addEventListener('load', function() {
                document.getElementById("selectMonth").value = "1";
                loadData();
            });
        </script>

        <!-- /.container-fluid -->
    @endsection
