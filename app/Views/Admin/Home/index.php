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

    /* Estilos para a comanda de impressão */
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

<div class="main">
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
                                        <th>Data</th>
                                        <th>Status</th>
                                        <th>Entregador</th>
                                        <th>Valor Total</th>
                                        <th>Pagamento</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="tabela-pedidos-body">
                                    <?= $this->include('Admin/Pedidos/_tabela_pedidos'); ?>
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
    // Flag para controlar a atualização automática
    let podeAtualizar = true;

    // --- FUNÇÕES AUXILIARES ---
    function exibirAlerta(tipo, mensagem) {
        toastr.options.timeOut = 3500;
        toastr.options.closeButton = true;
        toastr.options.progressBar = true;
        toastr[tipo](mensagem);
    }
    
    function handleAjaxResponse(response) {
        if (response.sucesso) {
            exibirAlerta('success', response.sucesso);
            return true;
        }
        if (response.erro) {
            exibirAlerta('error', response.erro);
            return false;
        }
        exibirAlerta('error', 'Ocorreu um erro desconhecido.');
        return false;
    }

    // --- INTERAÇÕES DA TABELA DE PEDIDOS ---

    // Mudar Status do Pedido
    $(document).on('change', '.select-status', function() {
        const selectStatus = $(this);
        const novoStatus = selectStatus.val();
        const pedidoId = selectStatus.data('pedido-id');

        $.ajax({
            type: 'POST',
            url: '<?= site_url('admin/pedidos/atualizarstatus'); ?>',
            data: {
                '<?= csrf_token(); ?>': '<?= csrf_hash(); ?>',
                id: pedidoId,
                status: novoStatus
            },
            dataType: 'json',
            beforeSend: () => { podeAtualizar = false; },
            success: (response) => {
                if (handleAjaxResponse(response)) {
                    if (novoStatus === 'em_preparacao' || novoStatus === 'saiu_para_entrega') {
                        selectStatus.closest('tr').find('.imprimir-cupom').trigger('click');
                    }
                }
            },
            error: () => { exibirAlerta('error', 'Não foi possível se conectar ao servidor.'); },
            complete: () => { podeAtualizar = true; }
        });
    });

    // Associar Entregador
    $(document).on('change', '.select-entregador', function() {
        const entregadorId = $(this).val();
        const pedidoId = $(this).data('pedido-id');
        $.ajax({
            type: 'POST',
            url: '<?= site_url('admin/pedidos/associarEntregador'); ?>',
            data: {
                '<?= csrf_token(); ?>': '<?= csrf_hash(); ?>',
                'pedido_id': pedidoId,
                'entregador_id': entregadorId
            },
            dataType: 'json',
            beforeSend: () => { podeAtualizar = false; },
            success: (response) => { handleAjaxResponse(response); },
            error: () => { exibirAlerta('error', 'Não foi possível se conectar ao servidor.'); },
            complete: () => { podeAtualizar = true; }
        });
    });

    // --- [CORRIGIDO] Imprimir Cupom ---
    // Este bloco agora contém a lógica completa para criar o HTML do cupom.
    $(document).on('click', '.imprimir-cupom', function() {
        const botao = $(this);
        const urlDados = botao.data('url-dados');

        $.ajax({
            type: 'GET',
            url: urlDados,
            dataType: 'json',
            beforeSend: function() {
                podeAtualizar = false;
                exibirAlerta('info', 'Buscando dados do pedido...');
                const modalHtml = `
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Cupom do Pedido</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body" id="conteudoCupom"><p class="text-center">Aguarde...</p></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button type="button" class="btn btn-primary" onclick="window.print()">Imprimir</button>
                            </div>
                        </div>
                    </div>`;
                $('#modalCupom').html(modalHtml).modal('show');
            },
            success: function(response) {
                const id = botao.data('id');
                const cliente = botao.data('cliente');
                const valorTotal = parseFloat(botao.data('valor')).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                const dataPedido = new Date(botao.data('data')).toLocaleString('pt-BR');
                const linhaTR = botao.closest('tr');
                const status = linhaTR.find('.select-status').val();
                const entregadorNome = linhaTR.find('.select-entregador option:selected').text().trim();
                const entregadorId = linhaTR.find('.select-entregador').val();
                const formaPagamento = linhaTR.find('.forma-pagamento').text().trim();

                if ((status === 'saiu_para_entrega' || status === 'entregue') && !entregadorId) {
                    exibirAlerta('warning', 'Selecione um entregador para imprimir a comanda.');
                    $('#modalCupom').modal('hide');
                    return;
                }

                let htmlItens = '';
                if (response.itens && response.itens.length > 0) {
                    response.itens.forEach(function(item) {
                        htmlItens += `<li class="item-principal">${item.quantidade}x ${item.produto_nome} ${item.medida_nome ? `(${item.medida_nome})` : ''}</li>`;
                        if (item.extras && item.extras.length > 0) {
                            htmlItens += '<ul class="extras-lista">';
                            item.extras.forEach(function(extra) { htmlItens += `<li>&nbsp;&nbsp;+ ${extra.nome}</li>`; });
                            htmlItens += '</ul>';
                        }
                    });
                } else {
                    htmlItens = '<li>Nenhum item encontrado.</li>';
                }

                const ehEntrega = (status === 'saiu_para_entrega' || status === 'entregue');
                const tituloCupom = ehEntrega ? 'COMANDA DE ENTREGA' : 'PEDIDO PARA COZINHA';
                
                let htmlEndereco = '';
                if (ehEntrega && response.endereco) {
                    htmlEndereco = `
                        <div class="titulo-secao">Dados de Entrega</div>
                        <div class="info-entrega">
                            <p><strong>CLIENTE:</strong> ${cliente}</p>
                            <p><strong>ENDEREÇO:</strong> ${response.endereco.logradouro || ''}, ${response.endereco.numero || ''}</p>
                            <p><strong>BAIRRO:</strong> ${response.endereco.bairro || ''}</p>
                            <p><strong>ENTREGADOR:</strong> ${entregadorNome}</p>
                        </div>`;
                }
                
                const htmlFinal = `
                    <div class="cupom-impressao">
                        <div class="header">
                            <h5>Seu Delivery</h5>
                            <p>CNPJ: XX.XXX.XXX/0001-XX</p>
                        </div>
                        <div class="titulo-secao">${tituloCupom}</div>
                        <div class="info-pedido">
                            <p><strong>CÓDIGO:</strong> ${id}</p>
                            <p><strong>DATA:</strong> ${dataPedido}</p>
                        </div>
                        ${htmlEndereco}
                        <div class="titulo-secao">Itens do Pedido</div>
                        <ul class="itens-lista">${htmlItens}</ul>
                        <div class="titulo-secao">Total</div>
                        <div class="info-pedido">
                            <p><strong>PAGAMENTO:</strong> ${formaPagamento}</p>
                            <p class="total-final"><strong>VALOR:</strong> ${valorTotal}</p>
                        </div>
                        <div class="footer"><p>Obrigado pela preferência!</p></div>
                    </div>`;
                
                $('#conteudoCupom').html(htmlFinal);
            },
            error: function(xhr) {
                const erroMsg = xhr.responseJSON ? xhr.responseJSON.erro : 'Não foi possível buscar os dados do pedido.';
                exibirAlerta('error', erroMsg);
                $('#modalCupom').modal('hide');
            },
            complete: function() {
                $('#modalCupom').on('hidden.bs.modal', function() {
                    podeAtualizar = true;
                    $(this).off('hidden.bs.modal').empty();
                });
            }
        });
    });

    // --- INICIALIZAÇÃO E ATUALIZAÇÃO DO DASHBOARD ---

    // Gráfico de Vendas
    const vendasCtx = document.getElementById('vendasChart').getContext('2d');
    const vendasChart = new Chart(vendasCtx, { type: 'bar', data: { labels: [], datasets: [{ label: 'Faturamento Diário', data: [], backgroundColor: 'rgba(40, 167, 69, 0.7)', borderColor: 'rgba(40, 167, 69, 1)', borderWidth: 1 }] }, options: { responsive: true, scales: { y: { beginAtZero: true, ticks: { callback: function(value) { return 'R$ ' + value.toLocaleString('pt-BR'); } } } }, plugins: { tooltip: { callbacks: { label: function(context) { return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y); } } } } } });

    // Gráfico de Status
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, { type: 'doughnut', data: { labels: [], datasets: [{ data: [], backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#6c757d', '#17a2b8', '#007bff'], hoverOffset: 4 }] }, options: { responsive: true, legend: { position: 'top' } } });

    // Função principal de atualização do Dashboard
    function atualizarDashboard() {
        if (!podeAtualizar) { return; }
        
        $.ajax({
            url: "<?php echo site_url('admin/home/atualizarDashboard'); ?>",
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // Atualiza os cards
                $('#faturamento-mes').text('R$ ' + data.valorPedidosMes);
                $('#total-pedidos-mes').text(data.totalPedidosMes);
                $('#total-clientes-ativos').text(data.totalClientesAtivos);

                // Atualiza a tabela de pedidos
                $('#tabela-pedidos-body').html(data.tabela_html);

                // Atualiza o gráfico de status
                statusChart.data.labels = data.statusPedidos.map(item => item.status.charAt(0).toUpperCase() + item.status.slice(1).replace('_', ' '));
                statusChart.data.datasets[0].data = data.statusPedidos.map(item => item.total);
                statusChart.update();

                // Atualiza o gráfico de faturamento
                vendasChart.data.labels = data.faturamento.map(item => item.dia);
                vendasChart.data.datasets[0].data = data.faturamento.map(item => item.faturamento);
                vendasChart.update();
            },
            error: function(xhr, status, error) {
                console.error("Erro ao atualizar o dashboard:", error);
            }
        });
    }

    // Inicia a atualização periódica a cada 8 segundos
    setInterval(atualizarDashboard, 8000); 
});
</script>

<?php echo $this->endSection(); ?>