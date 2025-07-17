<?php echo $this->extend('layout/principalView'); ?>

<?php echo $this->section('titulo'); ?>
<?= esc($titulo ?? 'Meu Carrinho') ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
<style>
    /* Estilos para um carrinho de compras moderno e limpo */
    .cart-item {
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #eee;
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
    .cart-item-info {
        font-size: 0.95rem;
        color: #555;
        margin-bottom: 0.5rem;
    }
    
    /* Estilos da lista de Extras */
    .cart-item-extras {
        font-size: 0.9rem;
        margin-top: 1rem;
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 0.8rem 1rem;
    }
    .cart-item-extras strong {
        font-weight: 600;
        color: #333;
    }
    .cart-item-extras ul {
        list-style: none;
        padding: 0;
        margin: 0.5rem 0 0 0;
    }
    .cart-item-extras li {
        display: flex;
        justify-content: space-between;
        align-items: center; /* Alinha verticalmente */
        flex-wrap: wrap; /* Permite que os itens quebrem a linha */
        padding: 0.4rem 0;
        border-bottom: 1px solid #eee;
    }
    .cart-item-extras li:last-child {
        border-bottom: none;
    }
    .cart-item-extras .extra-name {
        color: #555;
        margin-right: 0.5rem; /* Espaço entre o nome e a quantidade */
    }
    .cart-item-extras .extra-qty {
        color: #777;
        font-size: 0.85rem;
    }
    .cart-item-extras .extra-price {
        font-weight: 600;
        color: #222;
    }
    
    .cart-item-customization {
        margin-top: 0.75rem;
        font-size: 0.9rem;
        color: #495057;
        background-color: #f8f9fa;
        border-left: 3px solid #6c757d;
        padding: 0.5rem 0.75rem;
        border-radius: 4px;
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

    /* --- INÍCIO DOS AJUSTES PARA CELULAR --- */
    @media (max-width: 767px) {
        .cart-item {
            flex-wrap: wrap; /* Permite que os blocos quebrem a linha */
            gap: 0.5rem; /* Reduz o espaço */
        }
        .cart-item-img img {
            width: 80px; /* Imagem um pouco menor */
            height: 80px;
        }
        .cart-item-details {
            /* Faz os detalhes ocuparem o espaço restante ao lado da imagem */
            flex-basis: calc(100% - 80px - 1rem); 
        }
        .cart-item-title {
            font-size: 1.1rem; /* Título um pouco menor */
        }
        .cart-item-price {
            /* Ocupa 100% da largura, movendo-o para uma nova linha */
            flex-basis: 100%; 
            min-width: auto;
            margin-top: 1rem;
            text-align: right; /* Mantém o alinhamento à direita */
        }

        /* Ajustes na lista de extras */
        .cart-item-extras li {
            justify-content: flex-start; /* Alinha tudo à esquerda para começar */
        }
        .extra-details {
            display: flex;
            flex-direction: column; /* Coloca nome e quantidade um sob o outro */
            align-items: flex-start;
            flex-basis: 70%; /* Ocupa 70% da largura */
        }
        .extra-price {
            flex-basis: 30%; /* Ocupa 30% da largura */
            text-align: right; /* Alinha o preço à direita */
        }
    }
    /* --- FIM DOS AJUSTES PARA CELULAR --- */

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
                                
                                <div class="cart-item-info">

                                    <?php 
                        
                                    if (!empty($item['especificacao']) && is_object($item['especificacao']) && property_exists($item['especificacao'], 'descricao')) : 
                                    ?>
                                    
                                        <span><strong>Tamanho:</strong> <?= esc($item['especificacao']->descricao) ?></span><br>

                                    <?php endif; ?>

                                    <span><strong>Quantidade:</strong> <?= esc($item['quantidade']) ?></span>
                                </div>
                                
                                <?php if (!empty($item['extras'])): ?>
                                <div class="cart-item-extras">
                                    <strong>Extras:</strong>
                                    <ul>
                                        <?php foreach ($item['extras'] as $extraItem): ?>
                                            <li>
                                                <div class="extra-details">
                                                    <span class="extra-name">
                                                        <?= esc($extraItem['extra']->nome) ?>
                                                    </span>
                                                    <span class="extra-qty">
                                                        (x<?= esc($extraItem['quantidade']) ?>)
                                                    </span>
                                                </div>
                                                <span class="extra-price">
                                                    R$ <?= number_format($extraItem['extra']->preco * $extraItem['quantidade'], 2, ',', '.') ?>
                                                </span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php endif; ?>

                                <?php if (!empty($item['customizacao'])): ?>
                                    <div class="cart-item-customization">
                                        <strong>Observações:</strong> <?= esc($item['customizacao']) ?>
                                    </div>
                                <?php endif; ?>
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