<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table            = 'categorias';
    protected $returnType       = 'App\Entities\Categoria';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['nome', 'ativo', 'slug'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validation

      // Validações
    protected $validationRules = [
        'nome' => 'required|min_length[2]|is_unique[categorias.nome]|max_length[120]',
    ];

    protected $validationMessages = [
        'nome'  => [
            'required'   => 'O campo nome é obrigatório.',
            'min_length' => 'O tamanho mínimo é de 2 caracteres.',
            'max_length' => 'O tamanho máximo é de 120 caracteres.',
            'is_unique' => 'Essa categoria já existe!',
        ],
    ];

    // Eventos callback
    protected $beforeInsert = ['criaSlug'];
    protected $beforeUpdate = ['criaSlug'];

    protected function criaSlug(array $data)
    {
        if (isset($data['data']['nome'])) {
            $data['data']['slug'] = mb_url_title($data['data']['nome'], '-', TRUE );
        }

        return $data;
    }

    public function procurar($term)
    {
        if (null == $term) {
            return [];
        }

        return $this->select('id, nome')
            ->like('nome', $term)
            ->withDeleted(true)
            ->get()
            ->getResult();
    }

    public function desfazerExclusao(int $id)
    {
        return $this->protect(false)
            ->where('id', $id)
            ->set('deletado_em', null)
            ->update();
    }

}
