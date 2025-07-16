<?php echo $this->extend('layout/principalView'); ?>

<?php echo $this->section('titulo'); ?>
<?= esc($titulo ?? 'Meu Carrinho') ?>
<?php echo $this->endSection(); ?>


<?php echo $this->section('estilos'); ?>
<style>
    .cart-item {
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #eee;
        transition: all 0.3s;
    }
    
    .cart-item-img img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .cart-item-details {
        flex: 1;
    }
    .cart-item-title {
        font-weight: 600;
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
    }
    .cart-item-spec, .cart-item-extra, .cart-item-qty {
        font-size: 0.95rem;
        color: #555;
    }
    .cart-item-extra ul {
        padding-left: 18px;
        margin-top: 4px;
        margin-bottom: 0;
    }
    .cart-item-price {
        min-width: 120px;
        text-align: right;
    }
    .cart-item-price div {
        font-size: 1.2rem;
        font-weight: 600;
        color: #222;
    }
    .cart-item-price .btn {
        margin-top: 0.5rem;
    }
    .cart-summary-card {
        border: 1px solid #eee;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .cart-total {
        font-size: 1.6rem;
        font-weight: 700;
    }
    .btn-finalizar {
        background-color: #28a745;
        border-color: #28a745;
        color: #fff;
        transition: 0.3s;
    }
    .btn-finalizar:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
</style>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?>
<br><br><br>
<section class="section-padding">
    <div class="container">
        <h1 class="mb-4"><?= esc($titulo) ?></h1>

        <?php if (empty($carrinho)): ?>
            <div class="alert alert-info text-center" role="alert">
                Seu carrinho de compras está vazio.
                <a href="<?= site_url('/') ?>" class="alert-link">Comece a comprar!</a>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-8">
                    <?php foreach ($carrinho as $key => $item): ?>
                        <div class="cart-item">
                            <div class="cart-item-img">
                                <img src="<?= $item['produto']->imagem ? site_url('home/imagemProduto/' . $item['produto']->imagem) : site_url('admin/images/sem-imagem.jpg') ?>" alt="<?= esc($item['produto']->nome) ?>">
                            </div>
                            <div class="cart-item-details">
                                <div class="cart-item-title"><?= esc($item['produto']->nome) ?></div>
                                <?php if ($item['especificacao']): ?>
                                    <div class="cart-item-spec"><strong>Tamanho:</strong> <?= esc($item['especificacao']->descricao) ?></div>
                                <?php endif; ?>
                                <?php if (!empty($item['extras'])): ?>
                                <div class="cart-item-extra">
                                    <strong>Extras:</strong>
                                    <ul>
                                        <?php foreach ($item['extras'] as $extraItem): ?>
                                            <li>
                                                <?= esc($extraItem['extra']->nome) ?> (x<?= esc($extraItem['quantidade']) ?>) —
                                                R$ <?= number_format($extraItem['extra']->preco * $extraItem['quantidade'], 2, ',', '.') ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                                <div class="cart-item-qty">Quantidade: <?= esc($item['quantidade']) ?></div>
                            </div>
                            <div class="cart-item-price">
                                <div>R$ <?= number_format($item['preco_total_item'], 2, ',', '.') ?></div>
                                <a href="<?= site_url(route_to('carrinho.remover', $key)) ?>" class="btn btn-sm btn-outline-danger">Remover</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="col-lg-4">
                    <div class="card cart-summary-card">
                        <div class="card-body">
                            <h5 class="card-title">Resumo do Pedido</h5>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span>R$ <?= number_format($total, 2, ',', '.') ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Taxa de Entrega</span>
                                <span>A calcular</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between cart-total mb-4">
                                <span>Total</span>
                                <span>R$ <?= number_format($total, 2, ',', '.') ?></span>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="<?= site_url('/finalizar') ?>" class="btn btn-finalizar btn-lg">Finalizar Compra</a>
                                <a href="<?= site_url('/Vizualizar') ?>" class="btn btn-outline-secondary mt-2">Continuar Comprando</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<?php echo $this->endSection(); ?>
