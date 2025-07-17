<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\UsuarioModel;

class Home extends BaseController
{
    private $pedidoModel;
    private $usuarioModel;

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        $data = [
            'titulo' => 'Painel Principal',
            // KPIs para os cards
            'valorPedidosMes' => $this->pedidoModel->valorPedidosDoMes(),
            'totalPedidosMes' => $this->pedidoModel->totalPedidosDoMes(),
            'totalClientesAtivos' => $this->usuarioModel->where('ativo', true)->countAllResults(),
        ];

        return view('Admin/Home/index', $data);
    }
    
    /**
     * Novo método para responder às requisições AJAX do dashboard.
     * Retorna todos os dados dinâmicos em formato JSON.
     */
    public function atualizarDashboard()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $data = [
            // KPIs
            'valorPedidosMes' => number_format($this->pedidoModel->valorPedidosDoMes(), 2, ',', '.'),
            'totalPedidosMes' => $this->pedidoModel->totalPedidosDoMes(),
            'totalClientesAtivos' => $this->usuarioModel->where('ativo', true)->countAllResults(),
            
            // Dados para os gráficos
            'statusPedidos' => $this->pedidoModel->getStatusPedidosParaGrafico(),
            'faturamento'   => $this->pedidoModel->getFaturamentoParaGrafico(),

            // Tabela de últimos pedidos
            'pedidos' => $this->pedidoModel
                ->select('pedidos.codigo, pedidos.valor_pedido, pedidos.status, pedidos.criado_em, usuarios.nome AS cliente_nome')
                ->join('usuarios', 'usuarios.id = pedidos.usuario_id', 'left')
                ->orderBy('pedidos.criado_em', 'DESC')
                ->limit(10)
                ->findAll(),
        ];
        
        // Retorna os dados como JSON
        return $this->response->setJSON($data);
    }

    // O seu método detalhes($pedidoId) continua aqui, sem alterações...
}