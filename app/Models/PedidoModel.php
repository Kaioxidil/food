<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table            = 'pedidos';
    protected $primaryKey       = 'id';
    protected $returnType       = \App\Entities\Pedido::class;
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'usuario_id',
        'entregador_id', // Importante ter este campo aqui
        'codigo',
        'forma_pagamento_id',
        'status',
        'observacoes',
        'valor_entrega',
        'valor_total',
        'endereco_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';


    // ------------------ MÉTODO CORRIGIDO PARA A DASHBOARD ------------------ //

    /**
     * [CORRIGIDO] Recupera os últimos 10 pedidos com todos os dados necessários para o dashboard.
     */
    public function recuperaUltimosPedidosParaDashboard(): array
    {
        // A mágica acontece aqui! Adicionamos o JOIN com 'formas_pagamento'
        // e selecionamos o seu nome, exatamente como na outra função.
        return $this->select([
                        'pedidos.*', // Usamos pedidos.* para garantir todos os campos do pedido
                        'usuarios.nome AS cliente_nome',
                        'formas_pagamento.nome AS forma_pagamento_nome', // CAMPO ADICIONADO
                    ])
                    ->join('usuarios', 'usuarios.id = pedidos.usuario_id', 'left')
                    ->join('formas_pagamento', 'formas_pagamento.id = pedidos.forma_pagamento_id', 'left') // JOIN ADICIONADO
                    ->orderBy('pedidos.id', 'DESC')
                    ->limit(10)
                    ->findAll();
    }


    /**
     * Recupera os pedidos para a view principal com filtros e paginação.
     */
     public function recuperaPedidosPaginados(array $filtros, int $perPage = 10): array
    {
        $builder = $this->select([
            'pedidos.*',
            'usuarios.nome AS cliente_nome',
            'formas_pagamento.nome AS forma_pagamento_nome', // ADICIONADO: Seleciona o nome da forma de pagamento
        ])
        ->join('usuarios', 'usuarios.id = pedidos.usuario_id')
        ->join('formas_pagamento', 'formas_pagamento.id = pedidos.forma_pagamento_id'); // ADICIONADO: Faz a junção com a tabela de formas de pagamento

        if (!empty($filtros['busca'])) {
            $builder->like('pedidos.id', $filtros['busca']);
        }

        if (!empty($filtros['status'])) {
            $builder->where('pedidos.status', $filtros['status']);
        }

        return $builder->orderBy('pedidos.id', 'DESC')->paginate($perPage);
    }
    
    /**
     * Retorna o valor total de pedidos faturados no mês corrente.
     * Considera o status 'entregue' como faturado.
     */
    public function valorPedidosDoMes(): float
    {
        $primeiroDiaDoMes = date('Y-m-01 00:00:00');
        $ultimoDiaDoMes   = date('Y-m-t 23:59:59');

        $resultado = $this->selectSum('valor_total')
                          ->where('status', 'entregue') // Mudei para 'entregue', que é um status mais comum para faturamento. Ajuste se o seu for 'finalizado'.
                          ->where('criado_em >=', $primeiroDiaDoMes)
                          ->where('criado_em <=', $ultimoDiaDoMes)
                          ->get()->getRow();

        return (float) ($resultado->valor_total ?? 0.0);
    }

    /**
     * Retorna o faturamento por dia dos últimos 30 dias para o gráfico.
     * Considera o status 'entregue' como faturado.
     */
    public function getFaturamentoParaGrafico(): array
    {
        $trintaDiasAtras = date('Y-m-d 00:00:00', strtotime('-30 days'));

        $db = \Config\Database::connect();
        return $db->query(
            "SELECT DATE_FORMAT(criado_em, '%d/%m') as dia, SUM(valor_total) as faturamento 
             FROM pedidos 
             WHERE status = 'entregue' AND criado_em >= ? 
             GROUP BY dia 
             ORDER BY criado_em ASC",
            [$trintaDiasAtras]
        )->getResultObject();
    }


    // --- Demais métodos do seu model (totalPedidosDoMes, getStatusPedidosParaGrafico) podem continuar como estão ---
    
    public function totalPedidosDoMes(): int
    {
        $primeiroDiaDoMes = date('Y-m-01 00:00:00');
        $ultimoDiaDoMes   = date('Y-m-t 23:59:59');

        return $this->where('criado_em >=', $primeiroDiaDoMes)
                    ->where('criado_em <=', $ultimoDiaDoMes)
                    ->countAllResults();
    }
    
    public function getStatusPedidosParaGrafico(): array
    {
        $primeiroDiaDoMes = date('Y-m-01 00:00:00');
        $ultimoDiaDoMes   = date('Y-m-t 23:59:59');

        return $this->select('status, COUNT(id) as total')
                    ->where('criado_em >=', $primeiroDiaDoMes)
                    ->where('criado_em <=', $ultimoDiaDoMes)
                    ->groupBy('status')
                    ->orderBy('total', 'DESC')
                    ->findAll();
    }
}