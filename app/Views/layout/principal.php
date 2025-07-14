<!DOCTYPE html>
<html lang="pt-br">


<!-- munchbox/homepage-2.html  05 Dec 2019 10:14:51 GMT -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="keywords" content="#">
    <meta name="description" content="#">
    <title>SeuDelivery | <?php echo $this->renderSection('titulo'); ?></title>
    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo site_url('web/') ?>assets/favicon.png" type="image/x-icon">
    <!-- Bootstrap -->
    <link href="<?php echo site_url('web/') ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fontawesome -->
    <link href="<?php echo site_url('web/') ?>assets/css/font-awesome.css" rel="stylesheet">
    <!-- Flaticons -->
    <link href="<?php echo site_url('web/') ?>assets/css/font/flaticon.css" rel="stylesheet">
    <!-- Swiper Slider -->
    <link href="<?php echo site_url('web/') ?>assets/css/swiper.min.css" rel="stylesheet">
    <!-- Range Slider -->
    <link href="<?php echo site_url('web/') ?>assets/css/ion.rangeSlider.min.css" rel="stylesheet">
    <!-- magnific popup -->
    <link href="<?php echo site_url('web/') ?>assets/css/magnific-popup.css" rel="stylesheet">
    <!-- Nice Select -->
    <link href="<?php echo site_url('web/') ?>assets/css/nice-select.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="<?php echo site_url('web/') ?>assets/css/style.css" rel="stylesheet">
    <!-- Custom Responsive -->
    <link href="<?php echo site_url('web/') ?>assets/css/responsive.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&amp;display=swap" rel="stylesheet">
    <!-- place -->

    <?php $this->renderSection('estilos'); ?>

</head>

<body>
    <!-- Navigation -->
    <div class="header">
    <header class="full-width">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mainNavCol">
                    <div class="logo mainNavCol">
                        <a href="<?php echo site_url('home') ?>">
                            <img src="<?php echo site_url('web/') ?>assets/logo-mini.svg" class="img-fluid" alt="Logo">
                        </a>
                    </div>
                    <div class="main-search mainNavCol">
                        <form class="main-search search-form full-width">
                            <div class="row">
                                <div class="col-lg-6 col-md-5">
                                    <a href="#" class="delivery-add p-relative"> <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                                        <span class="address">Terra Roxa - Paraná</span>
                                    </a>
                                    <div class="location-picker">
                                        <input type="text" class="form-control" placeholder="Enter a new address">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-7">
                                    <div class="search-box padding-10">
                                        <input type="text" class="form-control" placeholder="Pizza, Burger, Chinese">
                                    </div>
                                </div>
                                </div>
                        </form>
                    </div>
                    <div class="right-side fw-700 mainNavCol">
                        <div class="gem-points">
                            <a href="#"> <i class="fas fa-concierge-bell"></i>
                                <span>Minhas Ordens</span>
                            </a>
                        </div>
                        <div class="catring parent-megamenu">
                            <a href="#"> <span>Ver Mais <i class="fas fa-caret-down"></i></span>
                                <i class="fas fa-bars"></i>
                            </a>
                            <div class="megamenu">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-5">
                                                <div class="ex-collection-box h-100">
                                                    <a href="#">
                                                        <img src="<?php echo site_url('web/') ?>assets/img/nav-1.jpg" class="img-fluid full-width h-100" alt="image">
                                                    </a>
                                                    <div class="category-type overlay padding-15"> <a href="restaurant.html" class="category-btn">Mais votados</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-md-7">
                                                <div class="row">
                                                    <div class="col-lg-3 col-sm-6">
                                                        <div class="menu-style">
                                                            <div class="menu-title">
                                                                <h6 class="cat-name"><a href="#" class="text-light-black">Páginas iniciais</a></h6>
                                                            </div>
                                                            <ul>
                                                                <li><a href="index-2.html" class="text-light-white fw-500">Página de destino</a>
                                                                </li>
                                                                <li><a href="homepage-1.html" class="text-light-white fw-500">Página inicial 1</a>
                                                                </li>
                                                                <li class="active"><a href="homepage-2.html" class="text-light-white fw-500">Página inicial 2</a>
                                                                </li>
                                                                <li><a href="homepage-3.html" class="text-light-white fw-500">Página inicial 3</a>
                                                                </li>
                                                                <li><a href="homepage-4.html" class="text-light-white fw-500">Página inicial 4</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-6">
                                                        <div class="menu-style">
                                                            <div class="menu-title">
                                                                <h6 class="cat-name"><a href="#" class="text-light-black">Páginas internas</a></h6>
                                                            </div>
                                                            <ul>
                                                                <li><a href="blog.html" class="text-light-white fw-500">Visualização em grade do blog</a>
                                                                </li>
                                                                <li><a href="blog-style-2.html" class="text-light-white fw-500">Visualização em grade do blog 2</a>
                                                                </li>
                                                                <li><a href="blog-details.html" class="text-light-white fw-500">Detalhes do blog</a>
                                                                </li>
                                                                <li><a href="ex-deals.html" class="text-light-white fw-500">Ofertas</a>
                                                                </li>
                                                                <li><a href="about.html" class="text-light-white fw-500">Sobre nós</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-6">
                                                        <div class="menu-style">
                                                            <div class="menu-title">
                                                                <h6 class="cat-name"><a href="#" class="text-light-black">Páginas relacionadas</a></h6>
                                                            </div>
                                                            <ul>
                                                                <li><a href="restaurant.html" class="text-light-white fw-500">Restaurante</a>
                                                                <li><a href="restaurant-style-1.html" class="text-light-white fw-500">Restaurante 1</a>
                                                                </li>
                                                                <li><a href="restaurant-style-2.html" class="text-light-white fw-500">Restaurante 2</a>
                                                                </li>
                                                                <li><a href="add-restaurant.html" class="text-light-white fw-500">Adicionar restaurante</a>
                                                                </li>
                                                                <li><a href="list-view.html" class="text-light-white fw-500">Visualização em lista</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-6">
                                                        <div class="menu-style">
                                                            <div class="menu-title">
                                                                <h6 class="cat-name"><a href="#" class="text-light-black">Páginas adicionais</a></h6>
                                                            </div>
                                                            <ul>
                                                                <li><a href="login.html" class="text-light-white fw-500">Login</a>
                                                                </li>
                                                                <li><a href="register.html" class="text-light-white fw-500">Registrar</a>
                                                                </li>
                                                                <li><a href="checkout.html" class="text-light-white fw-500">Finalizar compra</a>
                                                                </li>
                                                                <li><a href="order-details.html" class="text-light-white fw-500">Detalhes do pedido</a>
                                                                </li>
                                                                <li><a href="geo-locator.html" class="text-light-white fw-500">Localizador geográfico</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mobile-search">
                            <a href="#" data-toggle="modal" data-target="#search-box"> <i class="fas fa-search"></i>
                            </a>
                        </div>
                        <div class="user-details p-relative">
                            <a href="#" class="text-light-white fw-500">
                                <img src="<?php echo site_url('web/') ?>assets/img/user-1.png" class="rounded-circle" alt="userimg"> <span>Olá, Visitante</span>
                            </a>
                            <div class="user-dropdown">
                                <ul>
                                    <li>
                                        <a href="order-details.html">
                                            <div class="icon"><i class="flaticon-rewind"></i>
                                            </div> <span class="details">Pedidos Anteriores</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="order-details.html">
                                            <div class="icon"><i class="flaticon-takeaway"></i>
                                            </div> <span class="details">Próximos Pedidos</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="icon"><i class="flaticon-breadbox"></i>
                                            </div> <span class="details">Salvos</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="icon"><i class="flaticon-gift"></i>
                                            </div> <span class="details">Cartões de presente</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="icon"><i class="flaticon-refer"></i>
                                            </div> <span class="details">Indique um amigo</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="icon"><i class="flaticon-diamond"></i>
                                            </div> <span class="details">Vantagens</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="icon"><i class="flaticon-user"></i>
                                            </div> <span class="details">Conta</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="icon"><i class="flaticon-board-games-with-roles"></i>
                                            </div> <span class="details">Ajuda</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="user-footer"> <span class="text-light-black">Não é o Jhon?</span> <a href="#">Sair</a>
                                </div>
                            </div>
                        </div>
                        <div class="cart-btn notification-btn">
                            <a href="#" class="text-light-green fw-700"> <i class="fas fa-bell"></i>
                                <span class="user-alert-notification"></span>
                            </a>
                            <div class="notification-dropdown">
                                <div class="product-detail">
                                    <a href="#">
                                        <div class="img-box">
                                            <img src="<?php echo site_url('web/') ?>assets/img/shop-1.png" class="rounded" alt="image">
                                        </div>
                                        <div class="product-about">
                                            <p class="text-light-black">Lil Johnny’s</p>
                                            <p class="text-light-white">Spicy Maxican Grill</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="rating-box">
                                    <p class="text-light-black">Como foi seu último pedido?</p> <span class="text-dark-white"><i class="fas fa-star"></i></span>
                                    <span class="text-dark-white"><i class="fas fa-star"></i></span>
                                    <span class="text-dark-white"><i class="fas fa-star"></i></span>
                                    <span class="text-dark-white"><i class="fas fa-star"></i></span>
                                    <span class="text-dark-white"><i class="fas fa-star"></i></span>
                                    <cite class="text-light-white">Pedido há 2 dias</cite>
                                </div>
                            </div>
                        </div>
                        <div class="cart-btn cart-dropdown">
                            <a href="#" class="text-light-green fw-700"> <i class="fas fa-shopping-bag"></i>
                                <span class="user-alert-cart">3</span>
                            </a>
                            <div class="cart-detail-box">
                                <div class="card">
                                    <div class="card-header padding-15">Seu Pedido</div>
                                    <div class="card-body no-padding">
                                        <div class="cat-product-box">
                                            <div class="cat-product">
                                                <div class="cat-name">
                                                    <a href="#">
                                                        <p class="text-light-green"><span class="text-dark-white">1</span> Frango Chilli</p> <span class="text-light-white">pequeno, frango chilli</span>
                                                    </a>
                                                </div>
                                                <div class="delete-btn">
                                                    <a href="#" class="text-dark-white"> <i class="far fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                                <div class="price"> <a href="#" class="text-dark-white fw-500">
                                                    $2.25
                                                </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cat-product-box">
                                            <div class="cat-product">
                                                <div class="cat-name">
                                                    <a href="#">
                                                        <p class="text-light-green"><span class="text-dark-white">1</span> Queijo carregado</p> <span class="text-light-white">pequeno, frango chilli</span>
                                                    </a>
                                                </div>
                                                <div class="delete-btn">
                                                    <a href="#" class="text-dark-white"> <i class="far fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                                <div class="price"> <a href="#" class="text-dark-white fw-500">
                                                    $2.25
                                                </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cat-product-box">
                                            <div class="cat-product">
                                                <div class="cat-name">
                                                    <a href="#">
                                                        <p class="text-light-green"><span class="text-dark-white">1</span> Frango Tortia</p> <span class="text-light-white">pequeno, frango chilli</span>
                                                    </a>
                                                </div>
                                                <div class="delete-btn">
                                                    <a href="#" class="text-dark-white"> <i class="far fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                                <div class="price"> <a href="#" class="text-dark-white fw-500">
                                                    $2.25
                                                </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-total">
                                            <div class="total-price border-0"> <span class="text-dark-white fw-700">Subtotal dos itens:</span>
                                                <span class="text-dark-white fw-700">$9.99</span>
                                            </div>
                                            <div class="empty-bag padding-15"> <a href="#">Esvaziar sacola</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer padding-15"> <a href="checkout.html" class="btn-first green-btn text-custom-white full-width fw-500">Continuar para o checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                </div>
                <div class="col-sm-12 mobile-search">
                    <div class="mobile-address">
                        <a href="#" class="delivery-add" data-toggle="modal" data-target="#address-box"> <span class="address">Terra Roxa - Paraná</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

</div>
<br>
<br>
<br>


   
        <?php $this->renderSection('conteudo'); ?>

    
    <footer class="section-padding bg-light-theme pt-0 u-line">
        <div class="u-line instagram-slider swiper-container">
            <ul class="hm-list hm-instagram swiper-wrapper">
                <li class="swiper-slide">
                    <a href="#"><img src="<?php echo site_url('web/') ?>assets/img/restaurants/250x200/insta-3.jpg" alt="instagram"></a>
                </li>
                <li class="swiper-slide">
                    <a href="#"><img src="<?php echo site_url('web/') ?>assets/img/restaurants/250x200/insta-1.jpg" alt="instagram"></a>
                </li>
                <li class="swiper-slide">
                    <a href="#"><img src="<?php echo site_url('web/') ?>assets/img/restaurants/250x200/insta-2.jpg" alt="instagram"></a>
                </li>
                <li class="swiper-slide">
                    <a href="#"><img src="<?php echo site_url('web/') ?>assets/img/restaurants/250x200/insta-4.jpg" alt="instagram"></a>
                </li>
                <li class="swiper-slide">
                    <a href="#"><img src="<?php echo site_url('web/') ?>assets/img/restaurants/250x200/insta-5.jpg" alt="instagram"></a>
                </li>
                <li class="swiper-slide">
                    <a href="#"><img src="<?php echo site_url('web/') ?>assets/img/restaurants/250x200/insta-6.jpg" alt="instagram"></a>
                </li>
                <li class="swiper-slide">
                    <a href="#"><img src="<?php echo site_url('web/') ?>assets/img/restaurants/250x200/insta-7.jpg" alt="instagram"></a>
                </li>
                <li class="swiper-slide">
                    <a href="#"><img src="<?php echo site_url('web/') ?>assets/img/restaurants/250x200/insta-8.jpg" alt="instagram"></a>
                </li>
            </ul>
        </div>



        <div class="container-fluid">
    <div class="row">
        <div class="col-xl col-lg-4 col-md-4 col-sm-6">
            <div class="footer-contact">
                <h6 class="text-light-black">Precisa de Ajuda?</h6>
                <ul>
                    <li class="fw-600"><span class="text-light-white">Ligue para Nós</span> <a href="tel:" class="text-light-black">+(347) 123 456 789</a>
                    </li>
                    <li class="fw-600"><span class="text-light-white">Envie um Email</span> <a href="mailto:" class="text-light-black">demo@domain.com</a>
                    </li>
                    <li class="fw-600"><span class="text-light-white">Siga-nos no Twitter</span> <a href="#" class="text-light-black">@munchbox</a>
                    </li>
                    <li class="fw-600"><span class="text-light-white">Siga-nos no Instagram</span> <a href="#" class="text-light-black">@munchbox</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-xl col-lg-4 col-md-4 col-sm-6">
            <div class="footer-links">
                <h6 class="text-light-black">Conheça-nos</h6>
                <ul>
                    <li><a href="#" class="text-light-white fw-600">Sobre Nós</a>
                    </li>
                    <li><a href="#" class="text-light-white fw-600">Blog</a>
                    </li>
                    <li><a href="#" class="text-light-white fw-600">Redes Sociais</a>
                    </li>
                    <li><a href="#" class="text-light-white fw-600">Munchbox</a>
                    </li>
                    <li><a href="#" class="text-light-white fw-600">Benefícios</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-xl col-lg-4 col-md-4 col-sm-6">
            <div class="footer-links">
                <h6 class="text-light-black">Podemos Ajudar Você</h6>
                <ul>
                    <li><a href="#" class="text-light-white fw-600">Detalhes da Conta</a>
                    </li>
                    <li><a href="#" class="text-light-white fw-600">Histórico de Pedidos</a>
                    </li>
                    <li><a href="#" class="text-light-white fw-600">Encontrar Restaurante</a>
                    </li>
                    <li><a href="#" class="text-light-white fw-600">Login</a>
                    </li>
                    <li><a href="#" class="text-light-white fw-600">Rastrear Pedido</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-xl col-lg-4 col-md-4 col-sm-6">
            <div class="footer-links">
                <h6 class="text-light-black">Fazendo Negócios</h6>
                <ul>
                    <li><a href="#" class="text-light-white fw-600">Sugira uma Ideia</a>
                    </li>
                    <li><a href="#" class="text-light-white fw-600">Seja um Restaurante Parceiro</a>
                    </li>
                    <li><a href="#" class="text-light-white fw-600">Criar uma Conta</a>
                    </li>
                    <li><a href="<?php echo site_url('login/') ?>" class="text-light-white fw-600">Administrador</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-xl col-lg-4 col-md-4 col-sm-6">
            <div class="footer-contact">
                <h6 class="text-light-black">Newsletter</h6>
                <form class="subscribe_form">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-submit" name="email" placeholder="Digite seu email">
                        <span class="input-group-btn">
                            <button class="btn btn-second btn-submit" type="button"><i class="fas fa-paper-plane"></i></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12">
            <div class="ft-social-media">
                <h6 class="text-center text-light-black">Siga-nos</h6>
                <ul>
                    <li> <a href="#"><i class="fab fa-facebook-f"></i></a>
                    </li>
                    <li> <a href="#"><i class="fab fa-twitter"></i></a>
                    </li>
                    <li> <a href="#"><i class="fab fa-instagram"></i></a>
                    </li>
                    <li> <a href="#"><i class="fab fa-pinterest-p"></i></a>
                    </li>
                    <li> <a href="#"><i class="fab fa-youtube"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


    </footer>

   <div class="copyright">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 text-center align-self-center">
                <p class="text-light-black mb-0">© <?php echo date("Y"); ?> SeuDeliveryBR. Todos os direitos reservados.</p>
            </div>
            <div class="col-lg-12 text-center align-self-center mt-2">
                <a href="http://seudeliverybr.com.br" target="_blank" class="text-light-black">seudeliverybr.com.br</a>
            </div>
        </div>
    </div>
</div>
    <!-- footer -->
    <!-- modal-boxes -->
    <div class="modal fade" id="address-box">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title fw-700">Change Address</h4>
                </div>
                <div class="modal-body">
                    <div class="location-picker">
                        <input type="text" class="form-control" placeholder="Enter a new address">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="search-box">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="search-box p-relative full-width">
                        <input type="text" class="form-control" placeholder="Pizza, Burger, Chinese">
                    </div>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>



    <!-- Place all Scripts Here -->
    <!-- jQuery -->
    <script src="<?php echo site_url('web/') ?>assets/js/jquery.min.js"></script>
    <!-- Popper -->
    <script src="<?php echo site_url('web/') ?>assets/js/popper.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo site_url('web/') ?>assets/js/bootstrap.min.js"></script>
    <!-- Range Slider -->
    <script src="<?php echo site_url('web/') ?>assets/js/ion.rangeSlider.min.js"></script>
    <!-- Swiper Slider -->
    <script src="<?php echo site_url('web/') ?>assets/js/swiper.min.js"></script>
    <!-- Nice Select -->
    <script src="<?php echo site_url('web/') ?>assets/js/jquery.nice-select.min.js"></script>
    <!-- magnific popup -->
    <script src="<?php echo site_url('web/') ?>assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnd9JwZvXty-1gHZihMoFhJtCXmHfeRQg"></script>
    <!-- sticky sidebar -->
    <script src="<?php echo site_url('web/') ?>assets/js/sticksy.js"></script>
    <!-- Munch Box Js -->
    <script src="<?php echo site_url('web/') ?>assets/js/munchbox.js"></script>
    <!-- /Place all Scripts Here -->

    <?php $this->renderSection('scripts'); ?>
</body>


<!-- munchbox/homepage-2.html  05 Dec 2019 10:15:14 GMT -->
</html>