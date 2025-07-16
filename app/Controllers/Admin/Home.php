<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\PedidoItemModel; // Adicionar model de itens
use App\Models\PedidoItemExtraModel; // Adicionar model de extras

class Home extends BaseController
{
    private $pedidoModel;

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
    }

    public function index()
    {
        $data = [
            'titulo' => 'Painel Principal',
            'pedidos' => $this->pedidoModel
                ->select('pedidos.*, usuarios.nome AS cliente_nome')
                ->join('usuarios', 'usuarios.id = pedidos.usuario_id', 'left')
                ->orderBy('pedidos.criado_em', 'DESC')
                ->limit(10)
                ->findAll(),
        ];

        return view('Admin/Home/index', $data);
    }

    /**
     * Método para buscar os detalhes de um pedido via AJAX.
     * Retorna uma view com os detalhes formatados.
     */
    public function detalhes($pedidoId = null)
    {
        // Garante que a requisição seja via AJAX para segurança
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $pedido = $this->pedidoModel
            ->select('pedidos.*, usuarios.nome AS cliente_nome, formas_pagamento.nome AS forma_pagamento_nome')
            ->join('usuarios', 'usuarios.id = pedidos.usuario_id', 'left')
            ->join('formas_pagamento', 'formas_pagamento.id = pedidos.forma_pagamento_id', 'left')
            ->find($pedidoId);

        if (!$pedido) {
            return $this->response->setJSON(['error' => 'Pedido não encontrado.'])->setStatusCode(404);
        }

        // Busca os itens do pedido
        $pedidoItemModel = new PedidoItemModel();
        $pedido->itens = $pedidoItemModel
            ->select('pedido_itens.*, produtos.nome AS produto_nome, medidas.nome AS medida_nome')
            ->join('produtos', 'produtos.id = pedido_itens.produto_id')
            ->join('produto_especificacoes', 'produto_especificacoes.id = pedido_itens.especificacao_id', 'left')
            ->join('medidas', 'medidas.id = produto_especificacoes.medida_id', 'left')
            ->where('pedido_id', $pedidoId)
            ->findAll();
        
        // Busca os extras de cada item
        $pedidoItemExtraModel = new PedidoItemExtraModel();
        foreach ($pedido->itens as $item) {
            $item->extras = $pedidoItemExtraModel
                ->select('pedido_item_extras.*, extras.nome')
                ->join('extras', 'extras.id = pedido_item_extras.extra_id')
                ->where('pedido_item_id', $item->id)
                ->findAll();
        }

        $data = [
            'titulo' => 'Detalhes do Pedido ' . esc($pedido->id),
            'pedido' => $pedido,
        ];

        // Retorna a view parcial que criaremos no próximo passo
        return view('Admin/Home/_detalhes_pedido', $data);
    }
}