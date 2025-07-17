<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?> <?php echo $titulo; ?> <?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
<style>
    .card-icon {
        font-size: 3rem;
        opacity: 0.3;
    }
</style>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?> 

<div class="main-panel">
    <div class="content-wrapper">
        
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-header">
                        <h4>📋 Últimos Pedidos Realizados</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Cliente</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>
                                <tbody id="tabela-pedidos-body">
                                    </tbody>
                            </table>
                        </div>
                        <div class="mt-4 text-center">
                            <a href="<?php echo site_url('admin/pedidos'); ?>" class="btn btn-primary">Ver todos os pedidos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="card-title text-md-center text-xl-left">Faturamento no Mês</p>
                            <h3 id="faturamento-mes" class="font-weight-bold text-success">R$ <?php echo number_format($valorPedidosMes, 2, ',', '.'); ?></h3>
                            <p class="mb-0 text-muted">Total de vendas finalizadas.</p>
                        </div>
                        <i class="fas fa-dollar-sign card-icon text-success"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="card-title text-md-center text-xl-left">Pedidos no Mês</p>
                            <h3 id="total-pedidos-mes" class="font-weight-bold text-primary"><?php echo $totalPedidosMes; ?></h3>
                            <p class="mb-0 text-muted">Todos os status incluídos.</p>
                        </div>
                        <i class="fas fa-box-open card-icon text-primary"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="card-title text-md-center text-xl-left">Clientes Ativos</p>
                            <h3 id="total-clientes-ativos" class="font-weight-bold text-info"><?php echo $totalClientesAtivos; ?></h3>
                            <p class="mb-0 text-muted">Total de usuários cadastrados.</p>
                        </div>
                        <i class="fas fa-users card-icon text-info"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">📈 Faturamento nos Últimos 30 Dias</h4>
                        <canvas id="vendasChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">📊 Status dos Pedidos (Mês)</h4>
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<div class="modal fade" id="modalPedido" tabindex="-1" role="dialog" aria-labelledby="modalPedidoLabel" aria-hidden="true">
    </div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {

    // --- Inicialização dos Gráficos ---
    // Instanciamos os gráficos uma vez, com dados vazios. Eles serão preenchidos pelo AJAX.
    
    // Gráfico de Status (Pizza)
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: [], // Vazio inicialmente
            datasets: [{
                label: 'Total de Pedidos',
                data: [], // Vazio inicialmente
                backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#6c757d', '#17a2b8', '#007bff'],
                hoverOffset: 4
            }]
        },
        options: { responsive: true, legend: { position: 'top' } }
    });

    // Gráfico de Faturamento (Barras)
    const vendasCtx = document.getElementById('vendasChart').getContext('2d');
    const vendasChart = new Chart(vendasCtx, {
        type: 'bar',
        data: {
            labels: [], // Vazio inicialmente
            datasets: [{
                label: 'Faturamento Diário',
                data: [], // Vazio inicialmente
                backgroundColor: 'rgba(40, 167, 69, 0.7)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) { return 'R$ ' + value.toLocaleString('pt-BR'); }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y);
                        }
                    }
                }
            }
        }
    });


    // --- Função Principal de Atualização ---
    function atualizarDashboard() {
        
        $.ajax({
            url: "<?php echo site_url('admin/home/atualizarDashboard'); ?>",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                
                // 1. Atualiza os KPIs (os cards no topo)
                $('#faturamento-mes').text('R$ ' + data.valorPedidosMes);
                $('#total-pedidos-mes').text(data.totalPedidosMes);
                $('#total-clientes-ativos').text(data.totalClientesAtivos);

                // 2. Atualiza a tabela de últimos pedidos
                const tabelaBody = $('#tabela-pedidos-body');
                tabelaBody.empty(); // Limpa a tabela antes de adicionar os novos dados

                if (data.pedidos.length > 0) {
                    data.pedidos.forEach(function(pedido) {
                        // Formata a data para um formato mais legível
                        const dataPedido = new Date(pedido.criado_em);
                        const dataFormatada = dataPedido.toLocaleDateString('pt-BR') + ' ' + dataPedido.toLocaleTimeString('pt-BR');

                        const linhaTabela = `
                            <tr>
                                <td>${pedido.codigo}</td>
                                <td>${pedido.cliente_nome}</td>
                                <td>R$ ${parseFloat(pedido.valor_pedido).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</td>
                                <td>${pedido.status}</td> <td>${dataFormatada}</td>
                            </tr>
                        `;
                        tabelaBody.append(linhaTabela);
                    });
                } else {
                    tabelaBody.append('<tr><td colspan="5">Nenhum pedido encontrado.</td></tr>');
                }

                // 3. Atualiza o Gráfico de Status
                statusChart.data.labels = data.statusPedidos.map(item => item.status.charAt(0).toUpperCase() + item.status.slice(1));
                statusChart.data.datasets[0].data = data.statusPedidos.map(item => item.total);
                statusChart.update();

                // 4. Atualiza o Gráfico de Faturamento
                vendasChart.data.labels = data.faturamento.map(item => item.dia);
                vendasChart.data.datasets[0].data = data.faturamento.map(item => item.faturamento);
                vendasChart.update();

            },
            error: function(xhr, status, error) {
                console.error("Erro ao atualizar o dashboard:", error);
            }
        });
    }

    // --- Execução ---
    // Chama a função pela primeira vez para carregar os dados iniciais
    atualizarDashboard(); 
    
    // Configura um intervalo para chamar a função a cada 15 segundos (15000 milissegundos)
    setInterval(atualizarDashboard, 15000); 

});
</script>

<?php echo $this->endSection(); ?>