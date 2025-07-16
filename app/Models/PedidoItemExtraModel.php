<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoItemExtraModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pedidos_itens_extras';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pedido_item_id',
        'extra_id',
        'quantidade',
        'preco',
    ];

    protected $useTimestamps = false;
}
