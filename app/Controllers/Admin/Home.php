<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\UsuarioModel;
use App\Models\EntregadorModel; // Adicionado

class Home extends BaseController
{
    private $pedidoModel;
    private $usuarioModel;
    private $entregadorModel; // Adicionado

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->usuarioModel = new UsuarioModel();
        $this->entregadorModel = new EntregadorModel(); // Adicionado
    }

    /**
     * Exibe a página principal do Dashboard com os dados iniciais.
     */
    public function index()
    {
        $data = [
            'titulo'              => 'Painel Principal',
            'valorPedidosMes'     => $this->pedidoModel->valorPedidosDoMes(),
            'totalPedidosMes'     => $this->pedidoModel->totalPedidosDoMes(),
            'totalClientesAtivos' => $this->usuarioModel->recuperaTotalClientesAtivos(),
            
            // --- DADOS PARA A TABELA DE PEDIDOS (CARGA INICIAL) ---
            'pedidos'             => $this->pedidoModel->recuperaUltimosPedidosParaDashboard(),
            'entregadores'        => $this->entregadorModel->where('ativo', true)->findAll(),
            'statusDisponiveis'   => ['pendente', 'em_preparacao', 'saiu_para_entrega', 'entregue', 'cancelado'],
        ];

        return view('Admin/Home/index', $data);
    }
    
    /**
     * Responde às requisições AJAX do dashboard com todos os dados atualizados.
     */
    public function atualizarDashboard()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }
        
        // Dados para a tabela
        $pedidos = $this->pedidoModel->recuperaUltimosPedidosParaDashboard();
        $entregadores = $this->entregadorModel->where('ativo', true)->findAll();
        $statusDisponiveis = ['pendente', 'em_preparacao', 'saiu_para_entrega', 'entregue', 'cancelado'];

        // Renderiza o HTML da tabela usando a view parcial
        $tabelaHtml = view('Admin/Pedidos/_tabela_pedidos', [
            'pedidos' => $pedidos,
            'entregadores' => $entregadores,
            'statusDisponiveis' => $statusDisponiveis
        ]);

        // Monta o array de dados para a resposta JSON
        $data = [
            'valorPedidosMes'   => number_format($this->pedidoModel->valorPedidosDoMes(), 2, ',', '.'),
            'totalPedidosMes'   => $this->pedidoModel->totalPedidosDoMes(),
            'totalClientesAtivos' => $this->usuarioModel->recuperaTotalClientesAtivos(),
            'statusPedidos'     => $this->pedidoModel->getStatusPedidosParaGrafico(),
            'faturamento'       => $this->pedidoModel->getFaturamentoParaGrafico(),
            'tabela_html'       => $tabelaHtml, // Envia o HTML pronto da tabela
            'token'             => csrf_hash(),
        ];
        
        return $this->response->setJSON($data);
    }
}