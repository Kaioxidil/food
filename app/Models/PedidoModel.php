<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pedidos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'usuario_id',
        'forma_pagamento_id',
        'valor_total',
        'status',
        'observacoes',
        'criado_em',
        'atualizado_em',
    ];

    protected $useTimestamps = false;

    // ------------------ NOVOS MÉTODOS PARA A DASHBOARD ------------------ //

    /**
     * Retorna o valor total de pedidos faturados no mês corrente.
     * @return float
     */
    public function valorPedidosDoMes(): float
    {
        return (float) $this->selectSum('valor_total')
                             ->where('status', 'finalizado') // Apenas pedidos finalizados
                             ->where('MONTH(criado_em)', date('m'))
                             ->where('YEAR(criado_em)', date('Y'))
                             ->first()['valor_total'] ?? 0.0;
    }

    /**
     * Retorna o total de pedidos realizados no mês corrente.
     * @return int
     */
    public function totalPedidosDoMes(): int
    {
        return $this->where('MONTH(criado_em)', date('m'))
                    ->where('YEAR(criado_em)', date('Y'))
                    ->countAllResults();
    }
    
    /**
     * Retorna as estatísticas de status dos pedidos do mês corrente para o gráfico.
     * @return array
     */
    public function getStatusPedidosParaGrafico(): array
    {
        return $this->select('status, COUNT(id) as total')
                    ->where('MONTH(criado_em)', date('m'))
                    ->where('YEAR(criado_em)', date('Y'))
                    ->groupBy('status')
                    ->orderBy('total', 'DESC')
                    ->findAll();
    }
    
    /**
     * Retorna o faturamento por dia dos últimos 30 dias para o gráfico de vendas.
     * @return array
     */
    public function getFaturamentoParaGrafico(): array
    {
        $trintaDiasAtras = date('Y-m-d', strtotime('-30 days'));

        return $this->select("DATE_FORMAT(criado_em, '%d/%m') as dia, SUM(valor_total) as faturamento")
                    ->where('status', 'finalizado')
                    ->where('criado_em >=', $trintaDiasAtras)
                    ->groupBy("DATE_FORMAT(criado_em, '%d/%m')")
                    ->orderBy("criado_em", 'ASC')
                    ->findAll();
    }
}
