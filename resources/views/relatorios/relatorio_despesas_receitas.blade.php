@extends('layouts.inicial')

@section('relatorio-receitas_despesas')

            <canvas id="graficoComparacao"></canvas>
    <script>
        var ctx = document.getElementById('graficoComparacao').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json(array_column($totaisMensais, 'mes')),
                datasets: [{
                    label: 'Despesas',
                    data: @json(array_column($totaisMensais, 'totalDespesas')),
                    labels: @json(array_column($totaisMensais, 'mes')),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }, {
                    label: 'Receitas',
                    data: @json(array_column($totaisMensais, 'totalReceitas')),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
