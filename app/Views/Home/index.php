<?php echo $this->extend('layout/principal'); ?>

<?php echo $this->section('titulo'); ?> 
    <?php echo $titulo; ?> 
<?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
<style>
.truncate-descricao {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    max-height: 3em;
    -webkit-line-clamp: 2;
    line-height: 1.5em;
}

.product-title {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-line-clamp: 2;
    line-height: 1.4em;
    max-height: 2.8em;
    word-wrap: break-word;
    word-break: break-word;
}

.product-title a {
    display: block;
    word-wrap: break-word;
    word-break: break-word;
}

.cat-name {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-line-clamp: 2;
    line-height: 1.3em;
    max-height: 2.6em;
    word-wrap: break-word;
    word-break: break-word;
    text-align: center;
}



/* Container do rótulo do produto */
.product-label {
    position: absolute; /* Posiciona o elemento de forma absoluta */
    bottom: 20px; /* Distância da parte inferior */
    left: 20px; /* Distância da esquerda */
}

/* Estilo do botão de categoria (o texto) */
.category-btn {
    background-color: rgba(200, 200, 200, 0.6);
    color: #fff; 
    padding: 8px 12px; 
    border-radius: 5px; 
    font-size: 0.9rem;
    font-weight: 500;
    text-transform: uppercase; 
}
</style>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?> 

<section class="browse-cat u-line section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header-left">
                    <h3 class="text-light-black header-title title">Categorias <span class="fs-14"><a href="restaurant.html">Ver mais</a></span></h3>
                </div>
            </div>
            <div class="col-12">
                <div class="category-slider swiper-container">
                    <div class="swiper-wrapper">
                        <?php foreach ($categoria as $cat): ?>
                            <div class="swiper-slide">
                                <a href="<?= site_url('Vizualizar') . '#category-' . $cat->id ?>" class="categories">
                                    <div class="icon text-custom-white bg-light-green">
                                        <?php if ($cat->imagem): ?>
                                            <img src="<?= site_url("home/imagemCategoria/" . $cat->imagem) ?>" 
                                                 class="rounded-circle" 
                                                 style="width: 125px; height: 125px; object-fit: cover;" 
                                                 alt="<?= esc($cat->nome) ?>">
                                        <?php else: ?>
                                            <img src="<?= site_url('admin/images/sem-foto.jpg') ?>" 
                                                 class="rounded-circle" 
                                                 style="width: 125px; height: 125px; object-fit: cover;" 
                                                 alt="Categoria sem imagem">
                                        <?php endif; ?>
                                    </div>
                                    <span class="text-light-black cat-name"><?= esc($cat->nome) ?></span>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ex-collection section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header-left">
                    <h3 class="text-light-black header-title title">Explore nossos produtos</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <?php if (!empty($produtos)): ?>
                <?php
                $count = 0;
                foreach ($produtos as $produto):
                    if ($produto->imagem && $count < 2):
                        $count++;
                ?>
                        <div class="col-md-6">
                            <div class="ex-collection-box mb-xl-20 position-relative overflow-hidden">
                                <a href="<?= site_url("produto/$produto->slug") ?>">
                                    <img src="<?= site_url('home/imagemProduto/' . $produto->imagem); ?>" class="img-fluid full-width" style="max-height: 200px; object-fit: cover;" alt="<?= esc($produto->nome); ?>">
                                    <div class="product-label">
                                        <span class="category-btn"><?= esc($produto->nome); ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                <?php
                    endif;
                endforeach;
                ?>
            <?php else: ?>
                <div class="col-12"></div>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-8">
                <div class="row">
                    <?php if (!empty($produtos)): ?>
                        <?php
                        $count = 0; 
                        foreach ($produtos as $produto):
                            if ($count >= 8) { break; }
                        ?>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="product-box mb-xl-20">
                                    <div class="product-img">
                                        <a href="<?= site_url("produto/$produto->slug") ?>">
                                            <?php
                                            $imagemPath = site_url('admin/images/sem-imagem.jpg'); 
                                            if ($produto->imagem && !empty($produto->imagem)) {
                                                $imagemPath = site_url('home/imagemProduto/' . $produto->imagem);
                                            }
                                            ?>
                                            <img src="<?= $imagemPath ?>" class="img-fluid full-width" alt="<?= esc($produto->nome) ?>">
                                        </a>
                                        <div class="overlay">
                                            <div class="product-tags padding-10">
                                                <?php if (!empty($produto->desconto)): ?>
                                                    <div class="custom-tag">
                                                        <span class="text-custom-white rectangle-tag bg-gradient-red">
                                                            <?= esc($produto->desconto) ?>%
                                                        </span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($produto->trending)): ?>
                                                    <span class="type-tag bg-gradient-green text-custom-white">Trending</span>
                                                <?php elseif (!empty($produto->novo)): ?>
                                                    <span class="type-tag bg-gradient-orange text-custom-white">NEW</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-caption">
                                        <div class="title-box">
                                            <h6 class="product-title">
                                                <a href="<?= site_url("produto/$produto->slug") ?>" class="text-light-black">
                                                    <?= esc($produto->nome) ?>
                                                </a>
                                            </h6>
                                        </div>
                                        <p class="text-light-white truncate-descricao">
                                            <?= esc($produto->descricao ?? $produto->categoria) ?>
                                        </p>
                                        <div class="product-details">
                                            <div class="price-time" style="display: flex; flex-direction: column; align-items: flex-start;">
                                                <span class="text-light-black time">~30–40 min</span>
                                                <?php if (isset($produto->preco)): ?>
                                                    <span class="text-light-white price">R$ <?= number_format($produto->preco, 2, ',', '.') ?></span>
                                                <?php endif; ?>
                                                <a href="<?= site_url("produto/$produto->slug") ?>" class="btn btn-sm mt-2" style="background-color: #dc3545; color: white; border-color: #dc3545;">Mais detalhes</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        $count++; 
                        endforeach;
                        ?>
                    <?php else: ?>
                        <div class="col-12 text-center">
                            <p>Nenhum produto encontrado no momento.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-12 text-center mt-4">
            <a href="<?= site_url('/Vizualizar') ?>" class="btn btn-outline-danger">
                <i class="fas fa-store"></i> Ver mais do estabelecimento
            </a>
        </div>

    </div>
</section>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<?php echo $this->endSection(); ?>