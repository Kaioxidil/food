<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?> <?php echo $titulo; ?> <?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
    /* Estilos gerais da página */
    .navbar { z-index: 1040 !important; }
    #toast-container { z-index: 1060 !important; }
    .modal { z-index: 1050 !important; }

    /* Estilos para a comanda de impressão - Mantidos caso ainda sejam usados em outro lugar */
    .cupom-impressao {
        font-family: 'Courier New', Courier, monospace;
        color: #000;
        width: 80mm; 
        max-width: 80mm;
        margin: 0 auto;
        display: block;
    }
    .cupom-impressao .header { text-align: center; margin-bottom: 10px; }
    .cupom-impressao .header h5 { font-size: 16px; font-weight: bold; margin: 0; }
    .cupom-impressao .header p { font-size: 12px; margin: 2px 0; }
    .cupom-impressao .titulo-secao {
        text-transform: uppercase;
        font-weight: bold;
        border-top: 1px dashed #000;
        border-bottom: 1px dashed #000;
        padding: 4px 0;
        margin: 8px 0;
        text-align: center;
        font-size: 14px;
    }
    .cupom-impressao .info-pedido p,
    .cupom-impressao .info-entrega p {
        margin: 2px 0;
        font-size: 12px;
    }
    .cupom-impressao .info-pedido strong,
    .cupom-impressao .info-entrega strong {
        min-width: 70px;
        display: inline-block;
    }
    .cupom-impressao .itens-lista { list-style: none; padding: 0; font-size: 12px; }
    .cupom-impressao .itens-lista li { margin-bottom: 3px; }
    .cupom-impressao .itens-lista .item-principal { font-weight: bold; }
    .cupom-impressao .itens-lista .extras-lista { list-style: none; padding-left: 15px; font-size: 11px; margin: 0; }
    .cupom-impressao .total-final { font-size: 16px; font-weight: bold; text-align: right; margin-top: 8px; }
    .cupom-impressao .footer { text-align: center; margin-top: 10px; font-size: 11px; }

    /* Estilos para a impressão */
    @media print {
        body, body * { visibility: hidden; }
        .modal-dialog { max-width: 80mm !important; margin: 0 !important; }
        #modalCupom, #modalCupom * { visibility: visible; }
        #modalCupom {
            position: absolute; left: 0; top: 0; width: 100%; height: auto;
            border: none !important; box-shadow: none !important; overflow: visible !important;
        }
        .modal-content { border: none !important; box-shadow: none !important; }
        .modal-body { padding: 0 !important; }
        .modal-header, .modal-footer { display: none !important; }
    }

    /* Alertas toastr */
    .toast-info { background-color: #007bff !important; color: white; }
    .toast-success { background-color: #28a745 !important; color: white; }
    .toast-warning { background-color: #ffc107 !important; color: black; }
    .toast-error { background-color: #dc3545 !important; color: white; }
</style>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?> 

<div class="row">
    <div class="content-wrapper">
        
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="card-title text-md-center text-xl-left">Faturamento no Mês</p>
                            <h3 id="faturamento-mes" class="font-weight-bold text-success">R$ <?php echo number_format($valorPedidosMes, 2, ',', '.'); ?></h3>
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
                        </div>
                        <i class="fas fa-users card-icon text-info"></i>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card"><div class="card-body"><h4 class="card-title">📈 Faturamento nos Últimos 30 Dias</h4><canvas id="vendasChart"></canvas></div></div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card"><div class="card-body"><h4 class="card-title">📊 Status dos Pedidos (Mês)</h4><canvas id="statusChart"></canvas></div></div>
            </div>
        </div>

        </div>
</div>

<div class="modal fade" id="modalCupom" tabindex="-1" role="dialog" aria-labelledby="modalCupomLabel" aria-hidden="true">
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(function () {
    // A flag pode ser removida se não houver mais modais que interrompam a atualização.
    // Ou mantida para futuras expansões. Por segurança, vamos mantê-la e simplificar seu uso.
    let podeAtualizar = true; 

    // --- INICIALIZAÇÃO E ATUALIZAÇÃO DO DASHBOARD ---

    // Gráfico de Vendas
    const vendasCtx = document.getElementById('vendasChart').getContext('2d');
    const vendasChart = new Chart(vendasCtx, { 
        type: 'bar', 
        data: { 
            labels: [], 
            datasets: [{ 
                label: 'Faturamento Diário', 
                data: [], 
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
                        callback: function(value) { return 'R$ ' + value.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); } 
                    } 
                } 
            }, 
            plugins: { 
                tooltip: { 
                    callbacks: { 
                        label: function(context) { return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y); } 
                    } 
                } 
            } 
        } 
    });

    // Gráfico de Status
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, { 
        type: 'doughnut', 
        data: { 
            labels: [], 
            datasets: [{ 
                data: [], 
                backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#6c757d', '#17a2b8', '#007bff'], 
                hoverOffset: 4 
            }] 
        }, 
        options: { 
            responsive: true, 
            plugins: {
                legend: { 
                    position: 'top' 
                } 
            }
        } 
    });

    // Função principal de atualização do Dashboard
    function atualizarDashboard() {
        if (!podeAtualizar) { 
            return; 
        }
        
        $.ajax({
            url: "<?php echo site_url('admin/home/atualizarDashboard'); ?>",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // Atualiza os cards
                $('#faturamento-mes').text('R$ ' + data.valorPedidosMes);
                $('#total-pedidos-mes').text(data.totalPedidosMes);
                $('#total-clientes-ativos').text(data.totalClientesAtivos);

                // A linha abaixo de atualização da tabela foi removida
                // $('#tabela-pedidos-body').html(data.tabela_html);

                // Atualiza o gráfico de status
                statusChart.data.labels = data.statusPedidos.map(item => item.status.charAt(0).toUpperCase() + item.status.slice(1).replace(/_/g, ' '));
                statusChart.data.datasets[0].data = data.statusPedidos.map(item => item.total);
                statusChart.update();

                // Atualiza o gráfico de faturamento
                vendasChart.data.labels = data.faturamento.map(item => item.dia);
                vendasChart.data.datasets[0].data = data.faturamento.map(item => item.faturamento);
                vendasChart.update();
            },
            error: function(xhr, status, error) {
                console.error("Erro ao atualizar o dashboard:", error);
                toastr.error('Erro ao carregar dados do dashboard. Tente novamente mais tarde.', 'Erro!');
            }
        });
    }

    // Chama a função pela primeira vez para carregar os dados iniciais
    atualizarDashboard();

    // Atualiza o dashboard a cada 5 segundos
    setInterval(atualizarDashboard, 5000); 

    // Removemos o evento de clique para os botões de ação da tabela
    // $(document).on('click', '.btn-modal-pedido', function(e){...});

    // Se a modalCupom não for mais usada, esta parte pode ser removida também.
    // Se ela for usada por outra funcionalidade, mantenha.
    $('#modalCupom').on('hidden.bs.modal', function () {
        podeAtualizar = true; // Retoma a atualização quando a modal é fechada
        // atualizarDashboard(); // Opcional: força uma atualização ao fechar a modal
    });


    // Configurações globais do Toastr
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

});
</script>

<?php echo $this->endSection(); ?>