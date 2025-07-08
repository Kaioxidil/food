<?php

namespace App\Models;

use CodeIgniter\Model;

class BairroModel extends Model
{
    protected $table            = 'bairros';
    protected $returnType       = 'App\Entities\Bairro';
    protected $useSoftDeletes   = true;

    protected $allowedFields    = ['nome', 'slug', 'valor_entrega', 'ativo'];

    // Datas
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Regras de validação
    protected $validationRules = [
        'nome'          => 'required|min_length[2]|max_length[120]|is_unique[bairros.nome]',
        'valor_entrega' => 'required|decimal',
        'cep'           => 'required|exact_length[8]',
    ];

    protected $validationMessages = [
        'nome' => [
            'required'   => 'O campo nome é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 2 caracteres.',
            'max_length' => 'O nome pode ter no máximo 120 caracteres.',
            'is_unique'  => 'Esse bairro já existe!',
        ],
        'valor_entrega' => [
            'required' => 'O valor de entrega é obrigatório.',
            'decimal'  => 'Informe um valor válido com ponto (ex: 5.00).',
        ],

        'cep' => [
            'required' => 'O CEP é obrigatório.',
             'exact_length' => 'O CEP deve ter 8 caracteres.',
        ],
    ];

    // Callbacks
    protected $beforeInsert = ['criaSlug'];
    protected $beforeUpdate = ['criaSlug'];

    protected function criaSlug(array $data)
    {
        if (isset($data['data']['nome'])) {
            $data['data']['slug'] = mb_url_title($data['data']['nome'], '-', true);
        }

        return $data;
    }
}
