<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $returnType       = 'App\Entities\Usuario';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nome', 'email', 'senha'];
    protected $useSoftDeletes   = true;
    protected $useTimestamps    = true;
    protected $createdField     = 'criado_em';
    protected $updatedField     = 'atualizado_em';
    protected $deletedField     = 'deletado_em';

    /**
     * @uso Controller usuarios no método procurar com o autocomplete
     * @param string $term
     * @return array  usuarios
     */

    public function procurar($term){

    if ($term === null) {
        return [];
    }

    return $this->select('id, nome')
        ->like('nome', $term)
        ->orLike('email', $term)
        ->orLike('cpf', $term)
        ->where('deletado_em', null)
        ->findAll();
}
}
