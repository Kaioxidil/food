<?php echo $this->extend('layout/principalView'); ?>

<?php echo $this->section('titulo'); ?> 
    <?php echo $titulo; ?> 
<?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
    <style>
        /* Seus estilos existentes */
        html, body {
            scroll-behavior: smooth;
            height: auto;
            min-height: 100vh;
        }

        .truncate-descricao {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            max-height: 3em;
        }

        .restaurent-menu ul.nav-pills {
            overflow-x: auto;
            white-space: nowrap;
            flex-wrap: nowrap;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 5px;
        }

        .restaurent-menu ul.nav-pills::-webkit-scrollbar {
            height: 8px;
        }

        .restaurent-menu ul.nav-pills::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 4px;
        }

        .restaurent-menu ul.nav-pills::-webkit-scrollbar-track {
            background-color: #f1f1f1;
        }

        .main-content-wrapper {
            display: flex;
            justify-content: center;
        }

        .restaurent-meals .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
        }
        
        @media (min-width: 992px) {
             .content-after-sticky-menu {
                 padding-top: 0; 
            }
        }

        

        .restaurent-meals .card-header {
            background-color: #f8f8f8;
            border-bottom: 1px solid #e0e0e0;
            padding: 15px 20px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .restaurent-meals .card-body.no-padding {
            padding: 20px;
        }

        .restaurent-product-list {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .restaurent-product-list:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

         .restaurent-product-detail {
            display: block; 
            padding: 0 0 10px; 
        }

        @media (max-width: 575.98px) {
            .restaurent-product-detail {
                display: block; 
            }
        }

        .restaurent-product-left {
            width: 100%; 
            margin-top: 10px; 
        }

        .restaurent-product-img {
            flex-shrink: 0; 
            width: 100%; 
            height: 180px; 
            border-radius: 8px 8px 0 0; 
            overflow: hidden;
            margin-bottom: 15px; 
        }

        .restaurent-product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
        }

        .restaurent-product-list {
            background-color: #fff; 
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            margin-bottom: 20px; 
            padding-bottom: 0; 
            border-bottom: none; 
            overflow: hidden; 
        }

        .restaurent-product-list .restaurent-product-left {
            padding: 0 15px 15px; 
        }

        .truncate-descricao {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            -webkit-line-clamp: 3; 
            max-height: 4.2em; 
        }

        .restaurent-product-title-box {
            margin-bottom: 10px; 
        }

        .restaurent-product-title h6 {
            margin-bottom: 5px; 
        }

        .restaurent-tags-price {
            display: block; 
            text-align: right; 
            margin-top: 15px; 
        }

        .restaurent-product-price h6 {
            margin-top: 5px; 
            font-size: 1.3em; 
        }

        .restaurent-product-title-box .restaurent-product-rating {
            margin-top: 5px; 
            display: flex; 
            align-items: center;
            gap: 5px;
        }

        .restaurent-product-title-box .restaurent-product-rating .ratings {
            margin-right: 5px; 
        }

        .restaurent-product-left > .text-light-black.time { 
            display: block; 
            margin-bottom: 10px; 
            font-size: 0.9em;
            color: #666;
        }

        .restaurent-product-caption-box {
            margin-bottom: 10px; 
        }

        .restaurent-product-label {
            margin-bottom: 10px; 
            justify-content: flex-start; 
        }

        .restaurent-product-img {
            position: relative; 
        }

        .restaurent-product-img .circle-tag {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(255,255,255,0.8); 
            border-radius: 50%;
            width: 30px; 
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .restaurent-product-img .circle-tag img {
            width: 18px; 
            height: 18px;
            object-fit: contain;
        }

        /* Estilos para o Modal */
        #produtoModal .modal-header {
            border-bottom: none;
        }
        #produtoModal .modal-body {
            padding-top: 0;
        }
        #produtoModal .modal-body img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        #produtoModal .modal-title {
            font-size: 1.8em;
            font-weight: 700;
        }
        #produtoModal .modal-price {
            font-size: 1.5em;
            color: #28a745; /* Verde Bootstrap */
            font-weight: 600;
        }
        #produtoModal .modal-description {
            margin-top: 10px;
            color: #555;
        }
        #produtoModal .modal-tags {
            margin-top: 15px;
        }
        #produtoModal .modal-tags .square-tag {
            margin-right: 5px;
            margin-bottom: 5px;
        }
    </style>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?> 

<div class="page-banner p-relative smoothscroll" id="menu">
    <img src="<?php echo site_url('web/') ?>assets/img/banner.jpg" class="img-fluid full-width" alt="banner">
    <div class="overlay-2">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="back-btn">
                        <button type="button" class="text-light-green"> <i class="fas fa-chevron-left"></i>
                        </button>
                    </div>
                </div>
                <div class="col-6">
                    <div class="tag-share"> <span class="text-light-green share-tag">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="restaurent-details u-line">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading padding-tb-10">
                    <h3 class="text-light-black title fw-700 no-margin"><?= esc($restaurante->nome); ?></h3>
                    <p class="text-light-black sub-title no-margin"><?= esc($restaurante->endereco); ?> <span><a href="<?= site_url('checkout/endereco'); ?>" class="text-success">Mudar localização</a></span>
                    </p>
                    <div class="head-rating">
                        <div class="rating"> 
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span class="fs-16 text-<?= ($restaurante->avaliacao ?? 0) >= $i ? 'yellow' : 'dark-white'; ?>">
                                    <i class="fas fa-star"></i>
                                </span>
                            <?php endfor; ?>
                            <span class="text-light-black fs-12 rate-data"><?= esc($restaurante->total_avaliacoes ?? '0'); ?> avaliações</span>
                        </div>
                        <div class="product-review">
                            <div class="restaurent-details-mob">
                                <a href="#"> <span class="text-light-black"><i class="fas fa-info-circle"></i></span>
                                        <span class="text-dark-white">info</span>
                                </a>
                            </div>
                            <div class="restaurent-details-mob">
                                <a href="#"> <span class="text-light-black"><i class="fas fa-info-circle"></i></span>
                                        <span class="text-dark-white">info</span>
                                </a>
                            </div>
                            <div class="restaurent-details-mob">
                                <a href="#"> <span class="text-light-black"><i class="fas fa-info-circle"></i></span>
                                        <span class="text-dark-white">info</span>
                                </a>
                            </div>
                            <div class="restaurent-details-mob">
                                <a href="#"> <span class="text-light-black"><i class="fas fa-info-circle"></i></span>
                                        <span class="text-dark-white">info</span>
                                </a>
                            </div>
                            <h6 class="text-light-black no-margin"><?= esc($restaurante->percent_comida_boa ?? '0'); ?><span class="fs-14">% A comida estava boa</span></h6>
                            <h6 class="text-light-black no-margin"><?= esc($restaurante->percent_entrega_pontual ?? '0'); ?><span class="fs-14">% A entrega foi pontual</span></h6>
                            <h6 class="text-light-black no-margin"><?= esc($restaurante->percent_pedido_preciso ?? '0'); ?><span class="fs-14">% Pedido preciso</span></h6>
                        </div>
                    </div>
                </div>
                    <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="restaurent-menu">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"> 
                                        <a class="nav-link text-light-white fw-700" data-toggle="collapse" href="#aboutcollapse">Sobre</a>
                                    </li>
                                    <?php foreach ($categorias as $cat): ?>
                                    <li class="nav-item"> 
                                        <a class="nav-link text-light-white fw-700" href="#category-<?= $cat->id; ?>"><?= esc($cat->nome); ?></a>
                                    </li>
                                <?php endforeach; ?>
                                    <li class="nav-item"> 
                                        <a class="nav-link text-light-white fw-700" data-toggle="collapse" href="#reviewcollapse">Avaliações</a>
                                    </li>
                                    <li class="nav-item"> 
                                        <a class="nav-link text-light-white fw-700" data-toggle="collapse" href="#mapgallerycollapse">Mapa & Galeria</a>
                                    </li>
                                </ul>
                            
                            </div>
                        </div>
                    </div>
                </div>
</div>
                <div class="restaurent-logo">
                    <img src="<?php echo site_url('web/') ?>assets/img/logo-4.jpg" class="img-fluid" alt="Logo do Restaurante">
                </div>
            </div>
        </div>
    </div>
</section>



<div class="container main-content-wrapper">
    <div class="row w-100"> 
        <div class="row"> 
            
            <div id="accordion" class="content-after-sticky-menu">
                <section class="section-padding restaurent-about collapse" id="aboutcollapse" data-parent="#accordion"> 
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="text-light-black fw-700 title"><?= esc($restaurante->nome); ?></h3>
                                <p class="text-light-green no-margin"><?= esc($restaurante->tipo_culinaria ?? 'Culinária Variada'); ?></p>
                                <p class="text-light-white no-margin"><?= esc($restaurante->descricao ?? 'Sem descrição disponível.'); ?></p> 
                                <?php 
                                    $preco_medio = $restaurante->preco_medio ?? 3;
                                    for ($i = 1; $i <= 5; $i++): 
                                ?>
                                    <span class="text-<?= $preco_medio >= $i ? 'success' : 'dark-white'; ?> fs-16">$</span>
                                <?php endfor; ?>
                                <ul class="about-restaurent">
                                    <li> <i class="fas fa-map-marker-alt"></i>
                                        <span>
                                            <a href="#" class="text-light-white">
                                                <?= esc($restaurante->endereco ?? 'Endereço não informado'); ?><br>
                                                <?= esc($restaurante->cidade ?? 'Cidade não informada'); ?>, <?= esc($restaurante->estado ?? 'Estado não informado'); ?>, <?= esc($restaurante->cep ?? 'CEP não informado'); ?>
                                            </a>
                                        </span>
                                    </li>
                                    <li> <i class="fas fa-phone-alt"></i>
                                        <span><a href="tel:<?= esc($restaurante->telefone ?? ''); ?>" class="text-light-white"><?= esc($restaurante->telefone ?? 'Telefone não informado'); ?></a></span>
                                    </li>
                                    <li> <i class="far fa-envelope"></i>
                                        <span><a href="mailto:<?= esc($restaurante->email ?? ''); ?>" class="text-light-white"><?= esc($restaurante->email ?? 'Email não informado'); ?></a></span>
                                    </li>
                                </ul>
                                <ul class="social-media pt-2">
                                    <?php if (!empty($restaurante->facebook)): ?>
                                        <li> <a href="<?= esc($restaurante->facebook); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                    <?php endif; ?>
                                    <?php if (!empty($restaurante->twitter)): ?>
                                        <li> <a href="<?= esc($restaurante->twitter); ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                    <?php endif; ?>
                                    <?php if (!empty($restaurante->instagram)): ?>
                                        <li> <a href="<?= esc($restaurante->instagram); ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                    <?php endif; ?>
                                    <?php if (!empty($restaurante->pinterest)): ?>
                                        <li> <a href="<?= esc($restaurante->pinterest); ?>" target="_blank"><i class="fab fa-pinterest-p"></i></a></li>
                                    <?php endif; ?>
                                    <?php if (!empty($restaurante->youtube)): ?>
                                        <li> <a href="<?= esc($restaurante->youtube); ?>" target="_blank"><i class="fab fa-youtube"></i></a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <div class="restaurent-schdule">
                                    <div class="card">
                                        <div class="card-header text-light-white fw-700 fs-16">Horários</div>
                                        <div class="card-body">
                                            <?php 
                                                $horarios = $restaurante->horarios ?? [
                                                    'monday' => '7:00am - 10:59pm',
                                                    'tuesday' => '7:00am - 10:00pm',
                                                    'wednesday' => '7:00am - 10:00pm',
                                                    'thursday' => '7:00am - 10:00pm',
                                                    'friday' => '7:00am - 10:00pm',
                                                    'saturday' => '7:00am - 10:00pm',
                                                    'sunday' => '7:00am - 10:00pm',
                                                ];
                                            ?>
                                            <?php foreach ($horarios as $day => $time): ?>
                                                <div class="schedule-box">
                                                    <div class="day text-light-black"><?= ucfirst($day); ?></div>
                                                    <div class="time text-light-black">Entrega: <?= $time; ?></div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="map-gallery-sec section-padding bg-light-theme collapse" id="mapgallerycollapse" data-parent="#accordion">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="main-box">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <iframe id="locmap" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509374!2d144.95373631550474!3d-37.81627917975179!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf5727e43d9b4b0a4!2sMelbourne%20VIC%2C%20Australia!5e0!3m2!1sen!2sin!4v1614798365636!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="gallery-box padding-10">
                                                <ul class="gallery-img">
                                                    <?php 
                                                        $galeria_imagens = $restaurante->galeria ?? [
                                                            site_url('web/assets/img/gallery/img-1.jpg'),
                                                            site_url('web/assets/img/gallery/img-2.jpg'),
                                                            site_url('web/assets/img/gallery/img-3.jpg'),
                                                            site_url('web/assets/img/gallery/img-4.jpg'),
                                                            site_url('web/assets/img/gallery/img-5.jpg'),
                                                            site_url('web/assets/img/gallery/img-6.jpg'),
                                                        ];
                                                    ?>
                                                    <?php foreach ($galeria_imagens as $img_src): ?>
                                                        <li>
                                                            <a class="image-popup" href="<?= esc($img_src); ?>" title="Imagem do Restaurante">
                                                                <img src="<?= esc($img_src); ?>" class="img-fluid full-width" alt="Imagem do Restaurante" />
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="section-padding restaurent-review collapse" id="reviewcollapse" data-parent="#accordion">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="section-header-left">
                                    <h3 class="text-light-black header-title title">Avaliações para <?= esc($restaurante->nome); ?></h3>
                                </div>
                                <div class="restaurent-rating mb-xl-20">
                                    <div class="star"> 
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <span class="text-<?= ($restaurante->avaliacao_media ?? 0) >= $i ? 'yellow' : 'dark-white'; ?> fs-16">
                                                <i class="fas fa-star"></i>
                                            </span>
                                        <?php endfor; ?>
                                    </div> <span class="fs-12 text-light-black"><?= esc($restaurante->total_avaliacoes ?? '0'); ?> Avaliações</span>
                                </div>
                                <p class="text-light-black mb-xl-20">Aqui está o que as pessoas estão dizendo:</p>
                                <ul>
                                    <li>
                                        <h6 class="text-light-black mb-1"><?= esc($restaurante->percent_comida_boa ?? '0'); ?>%</h6>
                                        <span class="text-light-black fs-12 fw-400">A comida estava boa</span>
                                    </li>
                                    <li>
                                        <h6 class="text-light-black mb-1"><?= esc($restaurante->percent_entrega_pontual ?? '0'); ?>%</h6>
                                        <span class="text-light-black fs-12 fw-400">A entrega foi pontual</span>
                                    </li>
                                    <li>
                                        <h6 class="text-light-black mb-1"><?= esc($restaurante->percent_pedido_preciso ?? '0'); ?>%</h6>
                                        <span class="text-light-black fs-12 fw-400">O pedido estava preciso</span>
                                    </li>
                                </ul>
                                <div class="u-line"></div>
                            </div>
                            <div class="col-md-12">
                                <?php 
                                    $avaliacoes = $restaurante->avaliacoes ?? [
                                        (object)['usuario' => 'Sarra', 'local' => 'New York, (NY)', 'tipo_usuario' => 'Top Reviewer', 'data' => 'Sep 20, 2019', 'estrelas' => 5, 'comentario' => 'Delivery was fast and friendly. Food was not great especially the salad. Will not be ordering from again. Too many options to settle for this place.', 'itens_pedidos' => ['Coffee', 'Pizza', 'Noodles', 'Burger']],
                                        (object)['usuario' => 'João', 'local' => 'São Paulo, (SP)', 'tipo_usuario' => 'Regular', 'data' => 'Oct 15, 2024', 'estrelas' => 4, 'comentario' => 'Boa comida, entrega um pouco demorada mas valeu a pena.', 'itens_pedidos' => ['Sanduíche', 'Batata Frita']],
                                        (object)['usuario' => 'Maria', 'local' => 'Rio de Janeiro, (RJ)', 'tipo_usuario' => 'Foodie', 'data' => 'Nov 01, 2024', 'estrelas' => 5, 'comentario' => 'Pizza sensacional! Virei cliente.', 'itens_pedidos' => ['Pizza de Calabresa']],
                                    ];
                                ?>
                                <?php if (!empty($avaliacoes)): ?>
                                    <?php foreach ($avaliacoes as $avaliacao): ?>
                                        <div class="review-box">
                                            <div class="review-user">
                                                <div class="review-user-img">
                                                    <img src="<?php echo site_url('web/') ?>assets/img/blog-details/40x40/user-1.png" class="rounded-circle" alt="Foto do usuário">
                                                    <div class="reviewer-name">
                                                        <p class="text-light-black fw-600"><?= esc($avaliacao->usuario); ?> <small class="text-light-white fw-500"><?= esc($avaliacao->local); ?></small>
                                                        </p> 
                                                        <?php if (!empty($avaliacao->tipo_usuario)): ?>
                                                            <i class="fas fa-trophy text-black"></i><span class="text-light-black"><?= esc($avaliacao->tipo_usuario); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="review-date"> <span class="text-light-white"><?= esc($avaliacao->data); ?></span>
                                                </div>
                                            </div>
                                            <div class="ratings"> 
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <span class="text-<?= ($avaliacao->estrelas ?? 0) >= $i ? 'yellow' : 'dark-white'; ?> fs-16">
                                                        <i class="fas fa-star<?= ($avaliacao->estrelas > ($i - 1) && $avaliacao->estrelas < $i) ? '-half-alt' : ''; ?>"></i>
                                                    </span>
                                                <?php endfor; ?>
                                                <span class="ml-2 text-light-white">há 2 dias </span> </div>
                                            <p class="text-light-black"><?= esc($avaliacao->comentario); ?></p> 
                                            <?php if (!empty($avaliacao->itens_pedidos)): ?>
                                                <span class="text-light-white fs-12 food-order"><?= esc($avaliacao->usuario); ?> pediu:</span>
                                                <ul class="food">
                                                    <?php foreach ($avaliacao->itens_pedidos as $item): ?>
                                                        <li>
                                                            <button class="add-pro bg-gradient-red"><?= esc($item); ?> <span class="close">+</span></button>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center">
                                        <p class="text-light-black">Este restaurante ainda não possui avaliações. Seja o primeiro a avaliar!</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-12">
                                <div class="review-img">
                                    <img src="<?php echo site_url('web/') ?>assets/img/review-footer.png" class="img-fluid" alt="#">
                                    <div class="review-text">
                                        <h2 class="text-light-white mb-2 fw-600">Seja um dos primeiros a avaliar</h2>
                                        <p class="text-light-white">Peça agora e escreva uma avaliação para dar a outros a sua opinião.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

<section class="section-padding restaurent-meals">
    <div class="container-fluid">
        <div class="row">
            <?php if (!empty($produtosPorCategoria)): ?>
                <?php foreach ($produtosPorCategoria as $id_categoria => $data_categoria): ?>
                    <div class="col-lg-12 restaurent-meal-head mb-md-40 collapse show" id="category-<?= esc($id_categoria); ?>">
                        <div class="card">
                            <div class="card-header">
                                <div class="section-header-left">
                                    <h3 class="text-light-black header-title">
                                        <?= esc($data_categoria['categoria']->nome); ?>
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body no-padding">
                                <div class="row">
                                    <?php foreach ($data_categoria['produtos'] as $produto): ?>
                                        <div class="col-lg-12">
                                            <div class="restaurent-product-list">
                                                <a class="restaurent-product-detail" href="<?= site_url("produto/$produto->slug") ?>">
                                                    <div class="restaurent-product-left">
                                                        <div class="restaurent-product-title-box">
                                                            <div class="restaurent-product-box">
                                                                <div class="restaurent-product-title">
                                                                    <h6 class="mb-2">
                                                                        <span class="text-light-black fw-600"><?= esc($produto->nome); ?></span>
                                                                    </h6>
                                                                </div>
                                                                <div class="restaurent-product-label">
                                                                    <?php if (!empty($produto->label_personalizada)): ?>
                                                                        <span class="rectangle-tag bg-gradient-red text-custom-white"><?= esc($produto->label_personalizada); ?></span>
                                                                    <?php endif; ?>
                                                                    <?php if (!empty($produto->tipo_combo)): ?>
                                                                        <span class="rectangle-tag bg-dark text-custom-white"><?= esc($produto->tipo_combo); ?></span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <div class="restaurent-product-rating">
                                                                <div class="ratings">
                                                                    <?php 
                                                                        $estrelas = $produto->avaliacao_media ?? 0;
                                                                        for ($i = 1; $i <= 5; $i++): 
                                                                    ?>
                                                                        <span class="text-<?= $estrelas >= $i ? 'yellow' : 'dark-white'; ?>">
                                                                            <i class="fas fa-star<?= ($estrelas > ($i - 1) && $estrelas < $i) ? '-half-alt' : ''; ?>"></i>
                                                                        </span>
                                                                    <?php endfor; ?>
                                                                </div>
                                                                <div class="rating-text">
                                                                    <p class="text-light-white fs-12 title"><?= esc($produto->total_avaliacoes ?? '0'); ?> avaliações</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="text-light-black time">~30–40 min</span>
                                                        <div class="restaurent-product-caption-box">
                                                            <span class="text-light-white truncate-descricao"><?= esc($produto->descricao); ?></span>
                                                        </div>
                                                        <div class="restaurent-tags-price">
                                                            <div class="restaurent-tags">
                                                                <?php if (!empty($produto->tags)): ?>
                                                                    <?php foreach ($produto->tags as $tag_icon => $tag_alt): ?>
                                                                        <span class="text-custom-white square-tag">
                                                                            <img src="<?= site_url('web/') ?>assets/img/svg/<?= esc($tag_icon); ?>.svg" alt="<?= esc($tag_alt); ?>">
                                                                        </span>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </div>
                                                            <span class="circle-tag">
                                                                <img src="<?= site_url('web/') ?>assets/img/svg/010-heart.svg" alt="Favoritar">
                                                            </span>
                                                            <div class="restaurent-product-price">
                                                            <h6 class="text-success fw-600 no-margin">
                                                                <?php if (isset($produto->preco) && is_numeric($produto->preco)): ?>
                                                                    <span class="text-light-white price">R$ <?= number_format($produto->preco, 2, ',', '.') ?></span>
                                                                <?php else: ?>
                                                                    <span class="text-danger">Preço sob consulta</span>
                                                                <?php endif; ?>
                                                            </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="restaurent-product-img">
                                                        <?php 
                                                            $imagemPath = site_url('admin/images/sem-imagem.jpg');
                                                            if (!empty($produto->imagem)) {
                                                                $imagemPath = site_url('home/imagemProduto/' . $produto->imagem);
                                                            }
                                                        ?>
                                                        <img src="<?= $imagemPath; ?>" class="img-fluid" alt="<?= esc($produto->nome); ?>">
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-lg-12 text-center">
                    <p class="text-light-black">Nenhuma categoria com produtos disponível.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>


        </div> 

       




        
    </div> 
</div> 
<div class="restaurent-address u-line">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="address-details">
                    <div class="address">
                        <div class="delivery-address"> 
                            <a href="order-details.html" class="text-light-black">Entrega, O mais rápido possível (45–55m)</a> <div class="delivery-type"> <span class="text-success fs-12 fw-500">Sem mínimo</span><span class="text-light-white">, Frete Grátis</span> </div>
                        </div>
                        <div class="change-address"> <a href="<?= site_url('checkout/endereco'); ?>" class="fw-500">Mudar</a>
                        </div>
                    </div>
                    <p class="text-light-white no-margin"><?= esc($restaurante->observacoes_entrega ?? 'Informações adicionais sobre a entrega.'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="produtoModal" tabindex="-1" role="dialog" aria-labelledby="produtoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="produtoModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img id="modalProdutoImagem" src="" alt="Imagem do Produto">
        <p id="modalProdutoDescricao" class="modal-description"></p>
        <p id="modalProdutoPreco" class="modal-price"></p>
        <div id="modalProdutoTags" class="modal-tags"></div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-success">Adicionar ao Carrinho</button>
      </div>
    </div>
  </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<script>
    $(document).ready(function() {
 
        $('a[data-toggle="collapse"]').on('click', function(e) {
            e.preventDefault(); 
 
            var targetId = $(this).attr('href'); 
            var $targetCollapse = $(targetId);
 
            setTimeout(function() {
                var offset = $('.restaurent-menu').outerHeight() + 20; 
                $('html, body').animate({
                    scrollTop: $targetCollapse.offset().top - offset
                }, 800);
            }, 150); 
        });
 
 
        if (typeof Swiper !== 'undefined') {
            new Swiper('.advertisement-slider', {
                loop: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
 
            new Swiper('.category-slider', {
                slidesPerView: 'auto',
                spaceBetween: 15,
                freeMode: true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        }
 
        // A PARTIR DAQUI, O SCRIPT DO MODAL FOI REMOVIDO
    });
</script>
<?php echo $this->endSection(); ?>