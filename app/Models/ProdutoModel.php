<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table          = 'produtos';
    protected $returnType     = 'App\Entities\Produto';
    protected $useSoftDeletes = true;
    protected $allowedFields  = [
        'categoria_id',
        'nome',
        'slug',
        'descricao',
        'ingredientes',
        'ativo',
        'imagem',
        'preco', // Adicionado 'preco' aqui, se ele for uma coluna direta na tabela 'produtos'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validações
    protected $validationRules = [
        'nome'         => 'required|min_length[4]|is_unique[produtos.nome,id,{id}]|max_length[120]',
        'ingredientes' => 'required|min_length[10]|max_length[1000]',
        'categoria_id' => 'required|integer',
        // Se 'preco' for uma coluna direta em 'produtos', adicione uma validação aqui também:
        // 'preco'        => 'required|numeric|greater_than[0]', 
    ];

    protected $validationMessages = [
        'nome'         => [
            'required'   => 'O campo nome é obrigatório.',
            'min_length' => 'O tamanho mínimo é de 4 caracteres.',
            'max_length' => 'O tamanho máximo é de 120 caracteres.',
            'is_unique'  => 'Esse nome já existe!',
        ],
        'ingredientes' => [
            'required'   => 'O campo ingredientes é obrigatório.',
            'min_length' => 'O tamanho mínimo é de 10 caracteres.',
            'max_length' => 'O tamanho máximo é de 1000 caracteres.',
        ],
        'categoria_id' => [
            'required'   => 'O campo categoria é obrigatório.',
        ],
        // Se 'preco' for uma coluna direta em 'produtos':
        // 'preco'        => [
        //     'required'     => 'O campo preço é obrigatório.',
        //     'numeric'      => 'O preço deve ser um número.',
        //     'greater_than' => 'O preço deve ser maior que zero.',
        // ],
    ];

    // Adicionado para garantir que o 'preco' seja sempre tratado como float
    protected $casts = [
        'preco' => 'float', 
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

    public function BuscaProdutosPublicHome()
    {
        return $this->select([
            'produtos.id',
            'produtos.nome',
            'produtos.slug',
            'produtos.descricao',
            'produtos.ingredientes',
            'produtos.ativo',
            'produtos.imagem',
            // Seleciona o menor preço das especificações e dá um alias de 'preco'
            'MIN(produtos_especificacoes.preco) AS preco', 
            'categorias.id AS categoria_id',
            'categorias.nome AS categoria',
            'categorias.slug AS categoria_slug',
            // Adicione aqui outros campos de avaliação, tags, etc. se existirem no seu banco de dados
            // Exemplo:
            // 'AVG(avaliacoes.estrelas) AS avaliacao_media', 
            // 'COUNT(avaliacoes.id) AS total_avaliacoes',
        ])
        ->join('categorias', 'categorias.id = produtos.categoria_id')
        ->join('produtos_especificacoes', 'produtos_especificacoes.produto_id = produtos.id')
        ->where('produtos.ativo', true)
        ->groupBy('produtos.id, produtos.nome, produtos.slug, produtos.descricao, produtos.ingredientes, produtos.ativo, produtos.imagem, categorias.id, categorias.nome, categorias.slug') // Agrupa por todas as colunas não agregadas
        ->orderBy('categorias.nome', 'ASC')
        ->orderBy('produtos.nome', 'ASC') // Adicionado para ordenar produtos dentro da categoria
        ->findAll();
    }


    public function BuscaProdutosPdv()
    {
        return $this->select([
            'produtos.id',
            'produtos.nome',
            'produtos.slug',
            'produtos.descricao',
            'produtos.ingredientes',
            'produtos.ativo',
            'produtos.imagem',
            'MIN(produtos_especificacoes.preco) AS preco_minimo',
        ])
        ->join('produtos_especificacoes', 'produtos_especificacoes.produto_id = produtos.id')
        ->where('produtos.ativo', true)
        ->groupBy('produtos.id, produtos.nome, produtos.slug, produtos.descricao, produtos.ingredientes', 'produtos.ativo', 'produtos.imagem')
        ->orderBy('produtos.nome', 'ASC')
        ->findAll();
    }
}