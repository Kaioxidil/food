<?= $this->extend('layout/principal') ?>

<?= $this->section('titulo') ?> <?= esc($titulo) ?> <?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="container mt-5 mb-5" style="min-height: 400px;">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            
            <h2 class="text-center"><?= esc($titulo) ?></h2>
            <hr>

            <?php if (empty($carrinho)): ?>
                <div class="alert alert-info" role="alert">
                    Seu carrinho de compras está vazio. <a href="<?= site_url('/') ?>">Voltar para o início</a>
                </div>
            <?php else: ?>
                
                <h4 class="mb-3">Resumo do Pedido</h4>
                <ul class="list-group mb-4">
                    <?php foreach ($carrinho as $item): ?>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong><?= esc($item['produto']->nome) ?></strong> (x<?= esc($item['quantidade']) ?>)
                                    <?php if (!empty($item['customizacao'])): ?>
                                        <small class="d-block text-danger"><strong>Obs:</strong> <?= esc($item['customizacao']) ?></small>
                                    <?php endif; ?>
                                </div>
                                <span class="text-nowrap">R$ <?= number_format($item['preco_total_item'], 2, ',', '.') ?></span>
                            </div>
                        </li>
                    <?php endforeach; ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span id="subtotal-valor">R$ <?= number_format($subtotal, 2, ',', '.') ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Taxa de Entrega</span>
                        <span id="taxa-entrega-valor">Aguardando endereço...</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between active">
                        <strong>Total do Pedido</strong>
                        <strong id="total-final-valor">R$ <?= number_format($total, 2, ',', '.') ?></strong>
                    </li>
                </ul>

                <?= form_open(site_url('finalizar/enviar')) ?>
                    
                    <h4 class="mb-3">Endereço de Entrega</h4>

                    <div class="form-group mb-3">
                        <label for="endereco_id">Selecione um endereço salvo</label>
                        <select class="form-control" name="endereco_id" id="endereco_id" required>
                            <option></option>
                            <?php foreach ($enderecos as $endereco): ?>
                                <option
                                    value="<?= esc($endereco->id) ?>"
                                    data-bairro-id="<?= esc($endereco->bairro) ?>" >
                                    <?= esc($endereco->logradouro) ?>, <?= esc($endereco->numero) ?> - <?= esc($endereco->bairro_nome) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <input type="hidden" name="bairro_id" id="bairro_id_hidden">
                    
                    <hr>
                    <h4 class="mb-3">Pagamento</h4>
                    
                    <div class="form-group">
                        <label for="forma_pagamento_id">Escolha a forma de pagamento</label>
                        <select class="form-control" name="forma_pagamento_id" id="forma_pagamento_id" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($formas_pagamento as $forma): ?>
                                <option value="<?= esc($forma->id) ?>"><?= esc($forma->nome) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mt-3" id="campo-observacoes" style="display: none;">
                        <label for="observacoes">Precisa de troco? Para quanto?</label>
                        <textarea class="form-control" name="observacoes" id="observacoes" rows="2" placeholder="Ex: Troco para R$ 100,00"></textarea>
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-success btn-lg">
                            Finalizar e Enviar Pedido via WhatsApp
                        </button>
                    </div>

                <?= form_close() ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    
    // Inicializa os selects
    $('#endereco_id').select2({
        placeholder: "-- Selecione um endereço --",
        allowClear: true,
        width: '100%'
    });
    
    $('#forma_pagamento_id').select2({
        placeholder: "-- Selecione uma forma de pagamento --",
        width: '100%'
    });

    // Mostra/esconde campo de troco
    $('#forma_pagamento_id').on('change', function() {
        const texto = $(this).find('option:selected').text().toLowerCase();
        $('#campo-observacoes').toggle(texto.includes('dinheiro'));
    });
    
    // Tabela de bairros com seus valores (para uso no JS)
    const bairrosData = {
        <?php foreach($bairros as $bairro): ?>
            "<?= esc($bairro->id) ?>": <?= esc($bairro->valor_entrega) ?>,
        <?php endforeach; ?>
    };

    const subtotal = parseFloat('<?= $subtotal; ?>');

    function formatarMoeda(valor) {
        return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    }

    // ✅ CORRIGIDO: Lógica para calcular a entrega quando um endereço é selecionado
    $('#endereco_id').on('change', function() {
        const option = $(this).find('option:selected');
        const bairroId = option.data('bairro-id');
        
        let taxaEntrega = 0;

        if (bairroId && bairrosData[bairroId] !== undefined) {
            taxaEntrega = parseFloat(bairrosData[bairroId]);
            $('#taxa-entrega-valor').text(formatarMoeda(taxaEntrega));
        } else {
            $('#taxa-entrega-valor').text('Aguardando endereço...');
        }
        
        const novoTotal = subtotal + taxaEntrega;
        $('#total-final-valor').text(formatarMoeda(novoTotal));
    });
});
</script>
<?= $this->endSection() ?>