<?php echo $this->extend('layout/principalView'); ?>

<?php echo $this->section('titulo'); ?>
    <?= esc($titulo) ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
<style>
.produto-detalhes-img {
    width: 100%;
    max-height: 500px;
    object-fit: cover;
    border-radius: 16px;
}
.produto-preco {
    font-size: 1.8rem;
    font-weight: bold;
    color: #dc3545;
}
.produto-descricao {
    font-size: 1.1rem;
    line-height: 1.6;
}
.btn-comprar {
    background-color: #28a745;
    color: #fff;
    padding: 12px 30px;
    border-radius: 30px;
    font-size: 1.1rem;
    transition: background-color 0.3s;
}
.btn-comprar:hover {
    background-color: #218838;
}
</style>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?>

<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <img src="<?= $produto->imagem ? site_url('home/imagemProduto/' . $produto->imagem) : site_url('admin/images/sem-imagem.jpg') ?>" 
                     alt="<?= esc($produto->nome) ?>" 
                     class="produto-detalhes-img">
            </div>
            <div class="col-lg-6">
                <h1 class="mb-3"><?= esc($produto->nome) ?></h1>
                <?php if (isset($produto->preco)): ?>
                    <p class="produto-preco">R$ <?= number_format($produto->preco, 2, ',', '.') ?></p>
                <?php endif; ?>
                <p class="produto-descricao"><?= esc($produto->descricao) ?></p>

                <a href="#" class="btn btn-comprar mt-3"><i class="fas fa-shopping-cart"></i> Adicionar ao carrinho</a>
                <a href="<?= site_url('/Vizualizar') ?>" class="btn btn-outline-secondary mt-3">Voltar para a loja</a>
            </div>
        </div>

        <?php if (!empty($produto->categoria)): ?>
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-4">Categoria: <?= esc($produto->categoria) ?></h3>
                    <p>Veja mais produtos semelhantes em nossa <a href="<?= site_url('/Vizualizar#category-' . $produto->categoria_id) ?>" class="text-danger">página de categorias</a>.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<?php echo $this->endSection(); ?>
