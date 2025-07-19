<?= $this->extend('Admin/layout/principal'); ?>

<?= $this->section('titulo'); ?><?= $titulo; ?><?= $this->endSection(); ?>

<?= $this->section('estilos'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<style>
    /* Estilos gerais da página */
    .navbar { z-index: 1040 !important; }
    #toast-container { z-index: 1060 !important; }
    .modal { z-index: 1050 !important; }

    /* --- [CORRIGIDO] Estilos para a comanda de impressão --- */
    .cupom-impressao {
        font-family: 'Courier New', Courier, monospace;
        color: #000;
        /* Largura fixa de impressora térmica */
        width: 80mm; 
        max-width: 80mm;
        /* Altura máxima para evitar segunda página */
        height: 160mm;
        max-height: 160mm; 
        overflow: hidden; /* Corta o conteúdo que exceder a altura */
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
    .cupom-impressao .itens-lista li { display: flex; justify-content: space-between; margin-bottom: 3px; }
    .cupom-impressao .itens-lista .item-principal { font-weight: bold; }
    .cupom-impressao .itens-lista .extras-lista { list-style: none; padding-left: 15px; font-size: 11px; margin: 0; }
    .cupom-impressao .total-final { font-size: 16px; font-weight: bold; text-align: right; margin-top: 8px; }
    .cupom-impressao .footer { text-align: center; margin-top: 10px; font-size: 11px; }

    /* Alertas toastr */
    .toast-info { background-color: #007bff !important; color: white; }
    .toast-success { background-color: #28a745 !important; color: white; }
    .toast-warning { background-color: #ffc107 !important; color: black; }
    .toast-error { background-color: #dc3545 !important; color: white; }

    /* --- [CORRIGIDO] Estilos para a impressão --- */
    @media print {
        body, body * { visibility: hidden; }
        .modal-dialog { max-width: 80mm !important; margin: 0 !important; }
        #modalCupom, #modalCupom * { visibility: visible; }
        #modalCupom {
            position: absolute; left: 0; top: 0; width: 100%; height: auto;
            border: none !important; box-shadow: none !important; overflow: visible !important;
        }
        .modal-content { border: none !important; box-shadow: none !important; }
        .modal-body { padding: 0 !important; } /* Remove padding extra na impressão */
        .modal-header, .modal-footer { display: none !important; }
    }

    
</style>
<?= $this->endSection(); ?>


<?= $this->section('conteudo'); ?>
<div class="main">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?= $titulo; ?></h4>

                        <form action="<?= site_url('admin/pedidos'); ?>" method="get" class="mb-4">
                            <div class="form-row">
                                <div class="col-md-8">
                                    <input type="text" name="busca" class="form-control" placeholder="Pesquisar por código do pedido" value="<?= esc($filtros['busca']); ?>">
                                </div>
                                <div class="col-md-2">
                                    <select name="status" class="form-control">
                                        <option value="">Todos os status</option>
                                        <?php foreach ($statusDisponiveis as $status): ?>
                                            <option value="<?= $status; ?>" <?= ($status == $filtros['status']) ? 'selected' : ''; ?>>
                                                <?= ucfirst(str_replace('_', ' ', $status)); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
                                </div>
                            </div>
                            <?php if (!empty($filtros['busca']) || !empty($filtros['status'])): ?>
                                <a href="<?= site_url('admin/pedidos'); ?>" class="btn btn-outline-secondary btn-sm mt-2">Limpar filtros</a>
                            <?php endif; ?>
                        </form>
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

                        <div class="mt-4">
                            <?= $pager->links(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCupom" tabindex="-1" role="dialog" aria-labelledby="modalCupomLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCupomLabel">Cupom do Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="conteudoCupom">
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="window.print();">Imprimir</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>


<?= $this->section('scripts'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(function () {

    let podeAtualizar = true;

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
            beforeSend: function() { podeAtualizar = false; },
            success: function(response) {
                if (handleAjaxResponse(response)) {
                    if (novoStatus === 'em_preparacao' || novoStatus === 'saiu_para_entrega') {
                        selectStatus.closest('tr').find('.imprimir-cupom').trigger('click');
                    }
                }
            },
            error: function() { exibirAlerta('error', 'Não foi possível se conectar ao servidor.'); },
            complete: function() { podeAtualizar = true; }
        });
    });

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
            beforeSend: function() { podeAtualizar = false; },
            success: function(response) { handleAjaxResponse(response); },
            error: function() { exibirAlerta('error', 'Não foi possível se conectar ao servidor.'); },
            complete: function() { podeAtualizar = true; }
        });
    });

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
                $('#conteudoCupom').html('<p class="text-center">Aguarde...</p>');
                $('#modalCupom').modal('show');
            },
            success: function(response) {
                const id = botao.data('id');
                const cliente = botao.data('cliente');
                const valorTotal = botao.data('valor');
                const dataPedido = new Date(botao.data('data')).toLocaleString('pt-BR');
                const linhaTR = botao.closest('tr');
                const status = linhaTR.find('.select-status').val();
                const entregadorNome = linhaTR.find('.select-entregador option:selected').text().trim();
                const entregadorId = linhaTR.find('.select-entregador').val();
                
                if ((status === 'saiu_para_entrega' || status === 'entregue') && !entregadorId) {
                    exibirAlerta('warning', 'Selecione um entregador para imprimir a comanda de entrega.');
                    $('#modalCupom').modal('hide');
                    return;
                }

                let htmlItens = '';
                if (response.itens && response.itens.length > 0) {
                    response.itens.forEach(function(item) {
                        htmlItens += `<li class="item-principal"><span>${item.quantidade}x ${item.produto_nome} ${item.medida_nome ? `(${item.medida_nome})` : ''}</span></li>`;
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
                let htmlFinal = `
                    <div class="cupom-impressao">
                        <div class="header"><h5>Nome da Sua Empresa</h5><p>Rua Exemplo, 123 - Bairro</p><p>Telefone: (99) 99999-9999</p></div>
                        <div class="titulo-secao">${ehEntrega ? 'Comprovante de Entrega' : 'Pedido para Cozinha'}</div>
                        <div class="info-pedido"><p><strong>Pedido:</strong> #${id}</p><p><strong>Data:</strong> ${dataPedido}</p><p><strong>Cliente:</strong> ${cliente}</p></div>`;

                if (ehEntrega) {
                    htmlFinal += `<div class="titulo-secao">Dados da Entrega</div>`;
                    if (response.endereco) {
                        htmlFinal += `<div class="info-entrega"><p><strong>Entregador:</strong> ${entregadorNome}</p><p><strong>Endereço:</strong> ${response.endereco.logradouro}, ${response.endereco.numero}</p><p><strong>Bairro:</strong> ${response.endereco.bairro}</p>${response.endereco.complemento ? `<p><strong>Compl.:</strong> ${response.endereco.complemento}</p>` : ''}${response.endereco.referencia ? `<p><strong>Ref.:</strong> ${response.endereco.referencia}</p>` : ''}</div>`;
                    } else {
                        htmlFinal += `<div class="info-entrega"><p style="color: red; font-weight: bold;">${response.debug || 'Endereço não localizado para este pedido.'}</p></div>`;
                    }
                }

                htmlFinal += `
                        <div class="titulo-secao">Itens do Pedido</div>
                        <ul class="itens-lista">${htmlItens}</ul>
                        <div class="titulo-secao">Total</div>
                        <p class="total-final">R$ ${valorTotal}</p>
                        ${ehEntrega ? `<div class="footer"><p>Obrigado pela preferência!</p></div>` : ''}
                    </div>
                `;
                
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
                    $(this).off('hidden.bs.modal');
                });
            }
        });
    });

    function atualizarTabelaPedidos() {
        if (!podeAtualizar) { return; }
        const urlParams = new URLSearchParams(window.location.search);
        const busca = urlParams.get('busca') || '';
        const status = urlParams.get('status') || '';
        $.ajax({
            type: 'GET',
            url: '<?= site_url('admin/pedidos/atualizartabela'); ?>',
            data: { busca: busca, status: status },
            success: function(response) { $('#tabela-pedidos-body').html(response); },
            error: function() { console.log("Erro ao atualizar a tabela de pedidos."); }
        });
    }

    setInterval(atualizarTabelaPedidos, 5000);
});
</script>
<?= $this->endSection(); ?>