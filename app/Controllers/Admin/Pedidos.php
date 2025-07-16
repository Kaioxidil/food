<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PedidoModel;

class Pedidos extends BaseController
{
    public function index()
    {
        $pedidoModel = new PedidoModel();

        /**
         * Documentação da Consulta:
         * 1. selecionamos todos os campos de 'pedidos' e o nome do cliente da tabela 'usuarios'.
         * 2. Usamos LEFT JOIN para a tabela 'usuarios' para que, se um pedido não tiver um usuário_id (anônimo), ele ainda seja listado.
         * - Renomeamos 'usuarios.nome' para 'cliente_nome' para evitar conflitos.
         * 3. Usamos LEFT JOIN para a tabela 'forma_pagamento' para garantir que pedidos sem forma de pagamento também apareçam.
         * 4. Ordenamos os resultados pelos pedidos mais recentes.
         */
        $pedidos = $pedidoModel
            ->select('pedidos.*, usuarios.nome AS cliente_nome, forma_pagamento.nome AS forma_pagamento_nome')
            ->join('usuarios', 'usuarios.id = pedidos.usuario_id', 'left')
            ->join('forma_pagamento', 'forma_pagamento.id = pedidos.forma_pagamento_id', 'left')
            ->orderBy('pedidos.criado_em', 'DESC')
            ->findAll();

        $data = [
            'titulo' => 'Pedidos Realizados',
            'pedidos' => $pedidos
        ];

        return view('Admin/Pedidos/index', $data);
    }
}