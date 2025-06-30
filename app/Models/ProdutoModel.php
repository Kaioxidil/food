<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table            = 'produtos';
    protected $returnType       = 'App\Entities\Produto';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'categoria_id',
        'nome',
        'slug',
        'descricao',
        'ingredientes',
        'ativo',
        'imagem',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

        // Validações
    protected $validationRules = [
        'nome' => 'required|min_length[4]|is_unique[produtos.nome]|max_length[120]',
        'ingredientes' => 'required|min_length[10]|max_length[1000]',
        'categoria_id' => 'required|integer',
    ];

    protected $validationMessages = [
        'nome'  => [
            'required'   => 'O campo nome é obrigatório.',
            'min_length' => 'O tamanho mínimo é de 4 caracteres.',
            'max_length' => 'O tamanho máximo é de 120 caracteres.',
            'is_unique' => 'Esse nome já existe!',
        ],
        'ingredientes' => [
            'required'   => 'O campo ingredientes é obrigatório.',
            'min_length' => 'O tamanho mínimo é de 10 caracteres.',
            'max_length' => 'O tamanho máximo é de 1000 caracteres.',
        ],
        'categoria_id' => [
            'required'   => 'O campo categoria é obrigatório.',
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
