<?= $this->extend('layout/principal') ?>

<?= $this->section('titulo') ?> <?= esc($titulo) ?> <?= $this->endSection() ?>

<?= $this->section('estilos') ?>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                
                <h2 class="text-center"><?= esc($titulo) ?></h2>
                <hr>

                <?php if (empty($carrinho)): ?>
                    <div class="alert alert-info" role="alert">
                        Seu carrinho de compras está vazio.
                    </div>
                <?php else: ?>
                    
                    <h4>Resumo do Pedido</h4>
                    <ul class="list-group mb-4">
                        <?php foreach ($carrinho as $item): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?= esc($item['produto']->nome) ?></strong> (x<?= esc($item['quantidade']) ?>)
                                   <?php if (!empty($item['especificacao']?->medida_nome)): ?>
                                    <small class="d-block text-muted">
                                        Tamanho: <?= esc($item['especificacao']->medida_nome) ?>
                                    </small>
                                   <?php endif; ?>

                                    <?php if (!empty($item['extras'])): ?>
                                        <?php foreach ($item['extras'] as $extraInfo): ?>
                                            <small class="d-block text-muted">
                                                + <?= esc($extraInfo['extra']->nome) ?> (x<?= esc($extraInfo['quantidade']) ?>)
                                            </small>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                                <span>R$ <?= number_format($item['preco_total_item'], 2, ',', '.') ?></span>
                            </li>
                        <?php endforeach; ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center active">
                            <strong>Total</strong>
                            <strong>R$ <?= number_format($total, 2, ',', '.') ?></strong>
                        </li>
                    </ul>

                    <?= form_open(site_url('finalizar/enviar')) ?>
                        <div class="form-group">
                            <label for="forma_pagamento_id">Escolha a forma de pagamento</label>
                            <select class="form-control" name="forma_pagamento_id" id="forma_pagamento_id" required>
                                <option value="">Selecione...</option>
                                <?php foreach ($formas_pagamento as $forma): ?>
                                    <option value="<?= esc($forma->id) ?>"><?= esc($forma->nome) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label for="observacoes">Observações</label>
                            <textarea class="form-control" name="observacoes" id="observacoes" rows="3" placeholder="Ex: tirar a cebola, troco para R$ 50, etc."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg btn-block mt-4">
                            Finalizar e Enviar Pedido via WhatsApp
                        </button>
                    <?= form_close() ?>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <br>
    <br>
    <br>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->endSection() ?>