<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioEnderecoModel extends Model
{
    protected $table            = 'usuarios_enderecos';
    protected $primaryKey       = 'id';
    // ✅ CORREÇÃO APLICADA AQUI
    protected $returnType       = \App\Entities\UsuarioEndereco::class;
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'usuario_id',
        'titulo',
        'cep',
        'logradouro',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'complemento',
        'referencia',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';
}