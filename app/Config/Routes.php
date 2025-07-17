<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('Vizualizar', 'Home::Vizualizar');
$routes->get('login', 'Login::novo', ['filter' => 'visitante']);
$routes->get('produto/(:segment)', 'Produto::detalhes/$1');
$routes->get('registro', 'Registro::novo');
$routes->post('registro/criar', 'Registro::criar');


$routes->group('carrinho', function ($routes) {
    // Rota para exibir a página do carrinho de compras.
    // Ex: www.seusite.com/carrinho
    $routes->get('/', 'Carrinho::index', ['as' => 'carrinho']);
    $routes->post('adicionar', 'Carrinho::adicionar', ['as' => 'carrinho.adicionar']);

    $routes->get('remover/(:any)', 'Carrinho::remover/$1', ['as' => 'carrinho.remover']);

});

$routes->get('/finalizar', 'Finalizar::index'); 
$routes->post('/finalizar/enviar', 'Finalizar::enviar');

$routes->group('admin', function($routes){
    $routes->add('formas', 'Admin\FormasPagamentos::index');
    $routes->add('formas/criar', 'Admin\FormasPagamentos::criar');
    $routes->post('formas/cadastrar', 'Admin\FormasPagamentos::cadastrar');
    
    $routes->add('formas/show/(:num)', 'Admin\FormasPagamentos::show/$1');
    $routes->add('formas/editar/(:num)', 'Admin\FormasPagamentos::editar/$1');
    $routes->post('formas/atualizar/(:num)', 'Admin\FormasPagamentos::atualizar/$1');

    $routes->add('formas/excluir/(:num)', 'Admin\FormasPagamentos::excluir/$1');
    $routes->post('formas/excluir/(:num)', 'Admin\FormasPagamentos::excluir/$1');

    $routes->get('formas/desfazerexclusao/(:num)', 'Admin\FormasPagamentos::desfazerExclusao/$1');

    $routes->get('formas/procurar', 'Admin\FormasPagamentos::procurar'); 

    $routes->get('relatorios/relatoriousuario/gerarpdf', 'Admin\Relatorios\RelatorioUsuario::gerarPdf');

    $routes->get('bairros', 'Admin\Bairros::index');
    $routes->get('bairros/sincronizar', 'Admin\Bairros::sincronizar');


});


$routes->group('admin', static function ($routes) {

    $routes->get('home/atualizar', 'Admin\Home::atualizarDashboard'); 
});






// Rotas da Conta do Usuário (requer login)
$routes->group('conta', ['filter' => 'login'], static function ($routes) {
    
    // ... outras rotas da conta podem vir aqui ...

    $routes->get('enderecos', 'EnderecoController::index', ['as' => 'conta.enderecos']);
    $routes->get('enderecos/criar', 'EnderecoController::criar', ['as' => 'enderecos.criar']);
    $routes->post('enderecos/cadastrar', 'EnderecoController::cadastrar', ['as' => 'enderecos.cadastrar']);
    $routes->get('enderecos/editar/(:num)', 'EnderecoController::editar/$1', ['as' => 'enderecos.editar']);
    $routes->post('enderecos/atualizar/(:num)', 'EnderecoController::atualizar/$1', ['as' => 'enderecos.atualizar']);
    $routes->post('enderecos/excluir/(:num)', 'EnderecoController::excluir/$1', ['as' => 'enderecos.excluir']);
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
