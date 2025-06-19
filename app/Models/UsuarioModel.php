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

    protected $validationRules = [
        'nome'     => 'required|max_length[120]|alpha_numeric_space|min_length[4]',
        'email'        => 'required|max_length[254]|valid_email|is_unique[usuarios.email]',
        'cpf'        => 'required|exact_length[14]|is_unique[usuarios.cpf]',
        'password'     => 'required|min_length[6]',
        'password_confirm' => 'required_with[password]|matches[password]',
    ];
    protected $validationMessages = [
        'email' => [
            'required' => 'O E-mail é obrigatório.',
            'is_unique' => 'Desculpe, esse email já está em uso.',
        ],
        'cpf' => [
            'required' => 'O CPF é obrigatório.',
            'is_unique' => 'Desculpe, esse CPF já está em uso.',
        ],
        'nome' => [
            'required' => 'O Nome é obrigatório.',
        ],
    ];

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
