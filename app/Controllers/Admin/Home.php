<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\UsuarioModel;
use App\Models\EntregadorModel;

class Home extends BaseController
{
    private $pedidoModel;
    private $usuarioModel;
    private $entregadorModel;

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->usuarioModel = new UsuarioModel();
        $this->entregadorModel = new EntregadorModel();
    }

    /**
     * Exibe a página principal do Dashboard com os dados iniciais.
     * Continuamos buscando os dados aqui para a primeira carga da página.
     */
    public function index()
    {
        $data = [
            'titulo'              => 'Painel Principal',
            'valorPedidosMes'     => $this->pedidoModel->valorPedidosDoMes(),
            'totalPedidosMes'     => $this->pedidoModel->totalPedidosDoMes(),
            'totalClientesAtivos' => $this->usuarioModel->recuperaTotalClientesAtivos(),
            // Não precisamos mais de 'pedidos', 'entregadores', 'statusDisponiveis'
            // diretamente para a tabela na carga inicial, pois ela não existirá.
        ];

        return view('Admin/Home/index', $data);
    }
    
    /**
     * Responde às requisições AJAX do dashboard com os dados atualizados para gráficos e cards.
     */
    public function atualizarDashboard()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }
        
        // Removemos a lógica de preparação de dados para a tabela.
        // A _tabela_pedidos.php não será mais incluída ou renderizada.

        // Monta o array de dados para a resposta JSON
        $data = [
            'valorPedidosMes'     => number_format($this->pedidoModel->valorPedidosDoMes(), 2, ',', '.'),
            'totalPedidosMes'     => $this->pedidoModel->totalPedidosDoMes(),
            'totalClientesAtivos' => $this->usuarioModel->recuperaTotalClientesAtivos(),
            'statusPedidos'       => $this->pedidoModel->getStatusPedidosParaGrafico(),
            'faturamento'         => $this->pedidoModel->getFaturamentoParaGrafico(),
            'token'               => csrf_hash(), // Importante para segurança
        ];
        
        return $this->response->setJSON($data);
    }
}