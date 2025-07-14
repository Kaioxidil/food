<?php echo $this->extend('layout/principalView'); ?>

<?php echo $this->section('titulo'); ?>
<?= esc($titulo) ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
<style>
/* Estilos Gerais do Produto */
.produto-detalhes-img {
    width: 100%;
    border-radius: 16px;
    object-fit: cover;
    max-height: 500px;
}
.produto-info h2 {
    font-weight: bold;
    color: #333;
}
.produto-preco {
    font-size: 2.2rem;
    font-weight: bold;
    color: #28a745;
    margin-top: 10px;
}
.produto-descricao {
    font-size: 1rem;
    line-height: 1.6;
    color: #555;
}

/* Estilos de Botões e Acordeão */
.accordion-button:not(.collapsed) {
    color: #dc3545;
    font-weight: bold;
}
.accordion-button {
    font-size: 1.1rem;
    font-weight: bold;
}
.btn-adicionar {
    background-color: #3c6303;
    color: #fff;
    border: none;
    padding: 12px;
    border-radius: 8px;
    font-weight: bold;
    font-size: 1.1rem;
    width: 100%;
    margin-top: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}
.btn-adicionar:hover {
    background-color: #2e4d02;
}

/* Estilos para o Controle de Quantidade Principal */
.qtd-control {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 1rem;
    margin-bottom: 1rem;
}
.qtd-btn {
    width: 40px;
    height: 40px;
    border: 1px solid #ddd;
    border-radius: 50%;
    background-color: #fff;
    font-size: 1.5rem;
    font-weight: 300;
    color: #555;
    cursor: pointer;
    transition: background-color 0.3s;
}
.qtd-btn:hover {
    background-color: #f0f0f0;
}
.qtd-display {
    min-width: 40px;
    text-align: center;
    font-size: 1.5rem;
    font-weight: bold;
    margin: 0 15px;
}

/* Estilos para a Seção de Especificações */
.form-check {
    padding-left: 2.5em;
    margin-bottom: 1rem;
}
.form-check-input[type="radio"] {
    display: none;
}
.form-check-label {
    position: relative;
    cursor: pointer;
    padding-left: 10px;
}
.form-check-label::before {
    content: '';
    position: absolute;
    left: -2em;
    top: 50%;
    transform: translateY(-50%);
    width: 1.2em;
    height: 1.2em;
    border-radius: 50%;
    border: 2px solid #ccc;
    background-color: #fff;
}
.form-check-input[type="radio"]:checked + .form-check-label::before {
    border-color: #28a745;
    background-color: #28a745;
}
.form-check-input[type="radio"]:checked + .form-check-label::after {
    content: '';
    position: absolute;
    left: -1.3em;
    top: 50%;
    transform: translateY(-50%);
    width: 0.6em;
    height: 0.6em;
    border-radius: 50%;
    background-color: #fff;
}

/* Estilos para os Extras (Cartões e Botões) */
.extra-card {
    background-color: #f9f9f9;
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: border-color 0.3s;
}
.extra-card:has(input[type="checkbox"]:checked) {
    border-color: #28a745;
    box-shadow: 0 0 5px rgba(40, 167, 69, 0.2);
}

.extra-info {
    display: flex;
    align-items: center;
}
.extra-info input[type="checkbox"] {
    display: none;
}
.extra-label {
    position: relative;
    cursor: pointer;
    padding-left: 30px;
    font-weight: bold;
    color: #333;
}
.extra-label::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    border: 2px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
}
.extra-info input[type="checkbox"]:checked + .extra-label::before {
    background-color: #28a745;
    border-color: #28a745;
}
.extra-info input[type="checkbox"]:checked + .extra-label::after {
    content: '\2713'; /* Símbolo de check */
    position: absolute;
    left: 3px;
    top: 50%;
    transform: translateY(-50%);
    color: #fff;
    font-size: 1.2em;
}

.extra-price {
    font-weight: normal;
    color: #555;
    margin-left: 10px;
}

.extra-qtd-control {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}
.extra-qtd-control .qtd-btn {
    width: 30px;
    height: 30px;
    font-size: 1.2rem;
}
.extra-qtd-control .qtd-display {
    min-width: 30px;
    font-size: 1.2rem;
}

/* Media Queries para Responsividade */
@media (max-width: 768px) {
    .row {
        flex-direction: column;
    }
    .col-lg-6 {
        width: 100%;
    }
    .produto-detalhes-img {
        max-height: 300px;
        margin-bottom: 1.5rem;
    }
    .back-btn {
        top: 20px;
        left: 20px;
    }
    .tag-share {
        top: 20px;
        right: 20px;
    }
    .page-banner {
        height: auto;
    }
    .section-padding {
        padding: 1.5rem 0;
    }
    .container {
        padding: 0 1rem;
    }
    .qtd-control {
        flex-wrap: wrap;
        justify-content: center;
    }
}
</style>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?>

<br>
<br>
<br>


<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <img src="<?= $produto->imagem ? site_url('home/imagemProduto/' . $produto->imagem) : site_url('admin/images/sem-imagem.jpg') ?>" 
                    alt="<?= esc($produto->nome) ?>" 
                    class="produto-detalhes-img">
            </div>
            <div class="col-lg-6 produto-info">
                <h2><?= esc($produto->nome) ?></h2>
                <hr>
                <p class="produto-descricao"><?= esc($produto->descricao) ?></p>
                <hr>

                <?php if (isset($produto->preco)): ?>
                    <p class="produto-preco" id="preco-base">R$ <?= number_format($produto->preco ?? 0, 2, ',', '.') ?></p>
                <?php endif; ?>

                <hr>

                <div class="accordion mt-4" id="accordionDetalhes">
                    <?php if (!empty($produto->ingredientes)): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingIngredientes">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIngredientes" aria-expanded="true" aria-controls="collapseIngredientes">
                                    Ingredientes
                                </button>
                            </h2>
                            <div id="collapseIngredientes" class="accordion-collapse collapse show" aria-labelledby="headingIngredientes" data-bs-parent="#accordionDetalhes">
                                <div class="accordion-body">
                                    <?= $produto->ingredientes ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($extras)): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingExtras">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExtras" aria-expanded="false" aria-controls="collapseExtras">
                                    Extras
                                </button>
                            </h2>
                            <div id="collapseExtras" class="accordion-collapse collapse" aria-labelledby="headingExtras" data-bs-parent="#accordionDetalhes">
                                <div class="accordion-body">
                                    <form id="form-extras">
                                        <?php foreach ($extras as $extra): ?>
                                            <div class="extra-card">
                                                <div class="extra-info">
                                                    <input type="checkbox" name="extra_id[]"
                                                        id="extra-<?= $extra->id ?>"
                                                        value="<?= $extra->id ?>"
                                                        data-preco="<?= $extra->preco ?>"
                                                        data-nome="<?= esc($extra->nome) ?>">
                                                    <label class="extra-label" for="extra-<?= $extra->id ?>">
                                                        <?= esc($extra->nome) ?> <span class="extra-price">— R$ <?= number_format($extra->preco, 2, ',', '.') ?></span>
                                                    </label>
                                                </div>
                                                <div class="extra-qtd-control">
                                                    <button class="qtd-btn" type="button" onclick="alterarExtraQtd(this, -1)">-</button>
                                                    <span class="qtd-display" id="extra-qtd-<?= $extra->id ?>">0</span>
                                                    <button class="qtd-btn" type="button" onclick="alterarExtraQtd(this, 1)">+</button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($especificacoes)): ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingEspecificacoes">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEspecificacoes" aria-expanded="false" aria-controls="collapseEspecificacoes">
                                    Especificações
                                </button>
                            </h2>
                           <div id="collapseEspecificacoes" class="accordion-collapse collapse" aria-labelledby="headingEspecificacoes" data-bs-parent="#accordionDetalhes">
                            <div class="accordion-body">
                                <form id="form-especificacoes">
                                    <?php foreach ($especificacoes as $i => $esp): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" 
                                                 name="especificacao_id" 
                                                 id="esp<?= $esp->id ?>" 
                                                 value="<?= $esp->id ?>" 
                                                 data-preco="<?= $esp->preco ?>"
                                                 <?= ($i === 0 ? 'checked' : '') ?>>
                                            <label class="form-check-label" for="esp<?= $esp->id ?>">
                                                <?= esc($esp->descricao) ?> — R$ <?= number_format($esp->preco, 2, ',', '.') ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </form>
                            </div>
                        </div>
                        </div>
                    <?php endif; ?>
                </div>

                <hr>

                <div class="qtd-control">
                    <button class="qtd-btn" onclick="alterarQtd(-1)">-</button>
                    <span class="qtd-display" id="qtd">1</span>
                    <button class="qtd-btn" onclick="alterarQtd(1)">+</button>
                </div>

                <button class="btn-adicionar" onclick="adicionarCarrinho()">
                    Adicionar • <span id="preco-final">R$ <?= number_format($produto->preco ?? 0, 2, ',', '.') ?></span>
                </button>

                <div class="mt-3">
                    <p><strong>Slug:</strong> <?= esc($produto->slug) ?></p>
                    <?php if (isset($produto->quantidade)): ?>
                        <p><strong>Quantidade disponível:</strong> <?= esc($produto->quantidade) ?></p>
                    <?php endif; ?>
                </div>

                <a href="<?= previous_url() ?>" class="btn btn-outline-secondary mt-3">Voltar para a loja</a>
            </div>
        </div>

        <?php if (!empty($produto->categoria)): ?>
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-3">Categoria: <?= esc($produto->categoria) ?></h3>
                    <p>Veja mais produtos semelhantes em nossa <a href="<?= site_url('/Vizualizar#category-' . $produto->categoria_id) ?>" class="text-danger">página de categorias</a>.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<script>
let qtd = 1;

function alterarQtd(change) {
    qtd += change;
    if (qtd < 1) qtd = 1;
    document.getElementById('qtd').innerText = qtd;
    atualizarPreco();
}

function alterarExtraQtd(button, change) {
    const extraItem = button.closest('.extra-card');
    const extraCheckbox = extraItem.querySelector('input[type="checkbox"]');
    const extraQtdDisplay = extraItem.querySelector('.qtd-display');
    
    let extraQtd = parseInt(extraQtdDisplay.innerText);
    extraQtd += change;

    if (extraQtd < 0) {
        extraQtd = 0;
    }

    if (extraQtd === 0) {
        extraCheckbox.checked = false;
    } else {
        extraCheckbox.checked = true;
    }

    extraQtdDisplay.innerText = extraQtd;
    atualizarPreco();
}

function atualizarPreco() {
    let precoTotal = 0;

    const espRadio = document.querySelector('input[name="especificacao_id"]:checked');
    if (espRadio) {
        precoTotal = parseFloat(espRadio.getAttribute('data-preco'));
    } else {
        const precoBaseText = document.getElementById('preco-base').innerText;
        precoTotal = parseFloat(precoBaseText.replace('R$ ', '').replace('.', '').replace(',', '.'));
    }

    const checkedExtras = document.querySelectorAll('#form-extras input[type="checkbox"]:checked');
    checkedExtras.forEach(extra => {
        const extraPreco = parseFloat(extra.getAttribute('data-preco'));
        const extraQtd = parseInt(document.getElementById(`extra-qtd-${extra.value}`).innerText);
        precoTotal += extraPreco * extraQtd;
    });

    const precoFinal = precoTotal * qtd;
    document.getElementById('preco-final').innerText = 'R$ ' + precoFinal.toFixed(2).replace('.', ',');
}

document.addEventListener('DOMContentLoaded', () => {
    const formEsp = document.getElementById('form-especificacoes');
    if (formEsp) {
        formEsp.addEventListener('change', atualizarPreco);
    }
    
    const formExtras = document.getElementById('form-extras');
    if (formExtras) {
        formExtras.addEventListener('change', atualizarPreco);
    }

    atualizarPreco();
});

function adicionarCarrinho() {
    const espRadio = document.querySelector('input[name="especificacao_id"]:checked');
    const especificacaoId = espRadio ? espRadio.value : null;

    const extrasSelecionados = [];
    document.querySelectorAll('#form-extras input[type="checkbox"]:checked').forEach(extra => {
        const extraQtd = parseInt(document.getElementById(`extra-qtd-${extra.value}`).innerText);
        extrasSelecionados.push({
            id: extra.value,
            quantidade: extraQtd,
        });
    });

    alert(`Produto adicionado ao carrinho!\nQuantidade do produto: ${qtd}\nEspecificação ID: ${especificacaoId}\nExtras: ${JSON.stringify(extrasSelecionados, null, 2)}`);
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $this->endSection(); ?>