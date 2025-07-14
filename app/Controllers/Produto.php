<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdutoModel;

class Produto extends BaseController
{
    private $produtoModel;

    public function __construct()
    {
        $this->produtoModel = new ProdutoModel();
    }

    public function detalhes(string $slug = null)
    {
        // Verifica se slug está vazio ou se não encontrou o produto
        if (!$slug || !($produto = $this->produtoModel->where('slug', $slug)->first())) {
            return redirect()->to(site_url('/'));
        }

        $data = [
            'titulo' => "Detalhes do Produto $produto->nome",
            'produto' => $produto,
        ];

        return view('Produto/detalhes', $data);
    }
}
