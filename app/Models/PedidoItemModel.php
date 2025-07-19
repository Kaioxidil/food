<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoItemModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pedidos_itens';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pedido_id',
        'produto_id',
        'especificacao_id',
        'quantidade',
        'preco_unitario',
        'preco_extras',
        'subtotal',
    ];

    protected $useTimestamps = false;


     /**
     * Recupera os itens de um pedido com os nomes dos produtos e medidas.
     *
     * @param integer $pedido_id ID do pedido.
     * @return array
     */
    public function recuperaItensDoPedidoParaImpressao(int $pedido_id): array
    {
        return $this->select([
                'pedidos_itens.id', // ID do item para buscar os extras
                'pedidos_itens.quantidade',
                'produtos.nome AS produto_nome',
                'medidas.nome AS medida_nome',
            ])
            ->join('produtos', 'produtos.id = pedidos_itens.produto_id')
            ->join('produtos_especificacoes', 'produtos_especificacoes.id = pedidos_itens.especificacao_id')
            ->join('medidas', 'medidas.id = produtos_especificacoes.medida_id')
            ->where('pedidos_itens.pedido_id', $pedido_id)
            ->findAll();
    }
}
