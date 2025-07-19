<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioEnderecoModel extends Model
{
    protected $table            = 'usuarios_enderecos';
    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\UsuarioEndereco';
    

    protected $useSoftDeletes   = false; 
    
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
    

}