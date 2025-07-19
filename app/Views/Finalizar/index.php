<?= $this->extend('layout/principal') ?>

<?= $this->section('titulo') ?> <?= esc($titulo) ?> <?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="container mt-5 mb-5">
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
                        <span id="taxa-entrega-valor">R$ <?= number_format($taxa_entrega, 2, ',', '.') ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between active">
                        <strong>Total do Pedido</strong>
                        <strong id="total-final-valor">R$ <?= number_format($total, 2, ',', '.') ?></strong>
                    </li>
                </ul>

                <?= form_open(site_url('finalizar/enviar')) ?>
                    
                    <h4 class="mb-3">Endereço de Entrega</h4>

                    <?php if (isset($enderecos) && !empty($enderecos)): ?>
                        <div class="form-group mb-3">
                            <label for="endereco_id">Usar um endereço salvo</label>
                            <select class="form-control" name="endereco_id" id="endereco_id">
                                <option value=""></option>
                                <?php foreach ($enderecos as $endereco): ?>
                                    <option
                                        value="<?= esc($endereco->id) ?>"
                                        data-logradouro="<?= esc($endereco->logradouro) ?>"
                                        data-numero="<?= esc($endereco->numero) ?>"
                                        data-complemento="<?= esc($endereco->complemento) ?>"
                                        data-bairro="<?= esc($endereco->bairro) ?>" >
                                        <?= esc($endereco->logradouro) ?>, <?= esc($endereco->numero) ?> - <?= esc($endereco->bairro) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <div class="form-group mb-3">
                        <label for="endereco_completo">Endereço completo (Rua, Número, Complemento)</label>
                        <input type="text" class="form-control" id="endereco_completo" value="<?= old('endereco') ?>" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="bairro_id">Bairro</label>
                        <select class="form-control" name="bairro_id" id="bairro_id" required>
                            <option value="">-- Selecione o bairro --</option>
                            <?php foreach ($bairros as $bairro): ?>
                                <option value="<?= esc($bairro->id) ?>" data-valor="<?= esc($bairro->valor_entrega) ?>">
                                    <?= esc($bairro->nome) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

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
    
    // ✅ ALTERAÇÃO 2: O seletor do JavaScript agora aponta para #endereco_id
    $('#endereco_id').select2({
        placeholder: "-- Selecione um endereço salvo --",
        allowClear: true,
        width: '100%'
    });
    
    $('#bairro_id').select2({
        placeholder: "-- Selecione o bairro --",
        allowClear: true,
        width: '100%'
    });

    $('#forma_pagamento_id').on('change', function() {
        const texto = $(this).find('option:selected').text().toLowerCase();
        if (texto.includes('dinheiro')) {
            $('#campo-observacoes').show();
        } else {
            $('#campo-observacoes').hide();
            $('#observacoes').val('');
        }
    });

    // ✅ ALTERAÇÃO 3: O seletor do JavaScript agora aponta para #endereco_id
    $('#endereco_id').on('change', function() {
        const option = $(this).find('option:selected');
        if (!option.val()) {
            $('#endereco_completo').val('');
            $('#bairro_id').val('').trigger('change');
            return;
        };

        let endereco = option.data('logradouro') + ', ' + option.data('numero');
        if (option.data('complemento')) {
            endereco += ' - ' + option.data('complemento');
        }
        $('#endereco_completo').val(endereco);

        const bairroNome = option.data('bairro').toLowerCase().trim();
        $('#bairro_id option').each(function() {
            if ($(this).text().toLowerCase().trim() === bairroNome) {
                $('#bairro_id').val($(this).val()).trigger('change');
                return false;
            }
        });
    });

    const subtotal = parseFloat('<?= $subtotal; ?>');

    function formatarMoeda(valor) {
        return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    }

    $('#bairro_id').on('change', function() {
        const option = $(this).find('option:selected');
        const taxaEntrega = parseFloat(option.data('valor')) || 0;
        const novoTotal = subtotal + taxaEntrega;
        
        $('#taxa-entrega-valor').text(formatarMoeda(taxaEntrega));
        $('#total-final-valor').text(formatarMoeda(novoTotal));
    });

});
</script>
<?= $this->endSection() ?>