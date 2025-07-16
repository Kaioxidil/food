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
}
