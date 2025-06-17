<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $returnType       = 'object';
    protected $primaryKey       = 'id';

    protected $allowedFields    = ['nome', 'email', 'senha'];

    protected $useSoftDeletes   = true;
    protected $useTimestamps    = true;

    protected $createdField     = 'criado_em';
    protected $updatedField     = 'atualizado_em';
    protected $deletedField     = 'deletado_em';
}
