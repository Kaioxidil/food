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
                            <span>R$ <?= number_format($subtotal, 2, ',', '.') ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Taxa de Entrega</span>
                            <span>R$ <?= number_format($taxa_entrega, 2, ',', '.') ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between active">
                            <strong>Total do Pedido</strong>
                            <strong>R$ <?= number_format($total, 2, ',', '.') ?></strong>
                        </li>
                    </ul>

                    <?= form_open(site_url('finalizar/enviar')) ?>
                        
                        <h4 class="mb-3">Endereço de Entrega</h4>

                        <?php if (isset($enderecos) && !empty($enderecos)): ?>
                            <div class="form-group mb-3">
                                <label for="endereco_salvo_id">Usar um endereço salvo</label>
                                <select class="form-control" id="endereco_salvo_id">
                                    <option value="">-- Selecione um endereço --</option>
                                    <?php foreach ($enderecos as $e): ?>
                                        <option value="<?= $e->id ?>" 
                                                data-logradouro="<?= esc($e->logradouro) ?>"
                                                data-numero="<?= esc($e->numero) ?>"
                                                data-bairro="<?= esc($e->bairro) ?>"
                                                data-complemento="<?= esc($e->complemento) ?>">
                                            <?= esc($e->titulo) ?> (<?= esc($e->logradouro) ?>, <?= esc($e->numero) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>

                        <div class="form-group mb-3">
                            <label for="endereco_completo">Endereço completo (Rua, Número, Complemento)</label>
                            <input type="text" class="form-control" name="endereco" id="endereco_completo" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="bairro_id">Bairro</label>
                            <select class="form-control" name="bairro_id" id="bairro_id" required>
                                <option value="">-- Selecione o bairro --</option>
                                <?php foreach ($bairros as $bairro): ?>
                                    <option value="<?= esc($bairro->id) ?>"><?= esc($bairro->nome) ?></option>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- LÓGICA PARA O CAMPO DE TROCO ---
    const formaPagamentoSelect = document.getElementById('forma_pagamento_id');
    if (formaPagamentoSelect) {
        formaPagamentoSelect.addEventListener('change', function() {
            const formaSelecionada = this.options[this.selectedIndex].text.toLowerCase();
            const campoObservacoes = document.getElementById('campo-observacoes');
            if (formaSelecionada.includes('dinheiro')) {
                campoObservacoes.style.display = 'block';
            } else {
                campoObservacoes.style.display = 'none';
                document.getElementById('observacoes').value = '';
            }
        });
    }

    // --- LÓGICA PARA PREENCHER O ENDEREÇO SALVO ---
    const enderecoSalvoSelect = document.getElementById('endereco_salvo_id');
    if (enderecoSalvoSelect) {
        enderecoSalvoSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (!selectedOption.value) return;

            const logradouro = selectedOption.dataset.logradouro;
            const numero = selectedOption.dataset.numero;
            const complemento = selectedOption.dataset.complemento;
            const bairroNome = selectedOption.dataset.bairro;

            let enderecoFormatado = `${logradouro}, ${numero}`;
            if (complemento) {
                enderecoFormatado += ` - ${complemento}`;
            }
            
            document.getElementById('endereco_completo').value = enderecoFormatado;
            
            const bairroSelect = document.getElementById('bairro_id');
            for (let i = 0; i < bairroSelect.options.length; i++) {
                if (bairroSelect.options[i].text.toLowerCase() === bairroNome.toLowerCase()) {
                    bairroSelect.selectedIndex = i;
                    break;
                }
            }
        });
    }
});
</script>
<?= $this->endSection() ?>