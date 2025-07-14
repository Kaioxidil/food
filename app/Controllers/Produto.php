<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdutoModel;
use App\Models\ProdutoEspecificacaoModel;
use App\Models\ProdutoExtraModel;

class Produto extends BaseController
{
    private $produtoModel;
    private $produtoEspecificacaoModel;
    private $produtoExtraModel;

    public function __construct()
    {
        $this->produtoModel = new ProdutoModel();
        $this->produtoEspecificacaoModel = new ProdutoEspecificacaoModel();
        $this->produtoExtraModel = new ProdutoExtraModel();
    }

    public function detalhes(string $slug = null)
    {
        if (!$slug) {
            return redirect()->to(site_url('/'));
        }

        // Buscar o produto com o menor preço das especificações
        $produto = $this->produtoModel
            ->select([
                'produtos.*',
                'MIN(produtos_especificacoes.preco) AS preco'
            ])
            ->join('produtos_especificacoes', 'produtos_especificacoes.produto_id = produtos.id')
            ->where('produtos.slug', $slug)
            ->groupBy('produtos.id')
            ->first();

        if (!$produto) {
            return redirect()->to(site_url('/'));
        }

        /**
         * CORREÇÃO NESTE TRECHO:
         * A consulta anterior tentou usar a tabela 'especificacoes', que não existe no seu banco de dados.
         * Analisando o seu Model, a tabela correta para buscar a descrição é 'medidas'.
         * Agora, fazemos um JOIN com a tabela 'medidas' e pegamos a coluna 'nome' com o alias 'descricao'.
         */
        $especificacoes = $this->produtoEspecificacaoModel
            ->select('produtos_especificacoes.*, medidas.nome as descricao')
            ->join('medidas', 'medidas.id = produtos_especificacoes.medida_id')
            ->where('produtos_especificacoes.produto_id', $produto->id)
            ->findAll();

        /**
         * CORREÇÃO NESTE TRECHO:
         * A consulta anterior trazia apenas os IDs dos extras.
         * Agora, fazemos um JOIN com a tabela 'extras' para buscar o nome e o preço.
         */
        $extras = $this->produtoExtraModel
            ->select('produtos_extras.*, extras.nome, extras.preco')
            ->join('extras', 'extras.id = produtos_extras.extra_id')
            ->where('produtos_extras.produto_id', $produto->id)
            ->findAll();

        $data = [
            'titulo' => "Detalhes do Produto $produto->nome",
            'produto' => $produto,
            'especificacoes' => $especificacoes,
            'extras' => $extras,
        ];

        return view('Produto/detalhes', $data);
    }
}