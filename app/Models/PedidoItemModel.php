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
}
