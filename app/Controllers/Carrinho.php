<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdutoModel;
use App\Models\ProdutoEspecificacaoModel;
use App\Models\ProdutoExtraModel;
use App\Models\ExtraModel;
use App\Services\CarrinhoService;

class Carrinho extends BaseController
{
    private $produtoModel;
    private $produtoEspecificacaoModel;
    private $produtoExtraModel;
    private $extraModel;
    private $session;
    private $autenticacao;

    public function __construct()
    {
        // Instancia os models e serviços necessários
        $this->produtoModel = new ProdutoModel();
        $this->produtoEspecificacaoModel = new ProdutoEspecificacaoModel();
        $this->produtoExtraModel = new ProdutoExtraModel();
        $this->extraModel = new ExtraModel();
        
        // Inicia o serviço de sessão e um serviço de autenticação personalizado
        $this->session = session();
        $this->autenticacao = service('autenticacao');
    }

    /**
     * Exibe a página do carrinho de compras com todos os itens.
     */
    public function index()
    {
        $carrinho = $this->session->get('carrinho') ?? [];

        $itensDetalhados = [];
        $total = 0;

        foreach ($carrinho as $key => $item) {
            $produto = $this->produtoModel->find($item['produto_id']);
            if (!$produto) {
                continue; 
            }

            $especificacao = null;
            // O preço inicial é o do produto base, que será sobreposto pelo preço da especificação se houver uma.
            $precoItem = $produto->preco; 

            if (!empty($item['especificacao_id'])) {
                // ALTERAÇÃO 1: Usando o método do model para uma busca mais limpa e centralizada.
                $especificacao = $this->produtoEspecificacaoModel->getEspecificacaoComDescricao($item['especificacao_id']);
                
                if ($especificacao) {
                    $precoItem = $especificacao->preco; // Preço da especificação sobrepõe-se
                }
            }
            
            $extrasDetalhados = [];
            if (!empty($item['extras']) && is_array($item['extras'])) {
                foreach ($item['extras'] as $extraId => $quantidadeExtra) {
                    $extra = $this->extraModel->find($extraId); 

                    if ($extra) { 
                        $extrasDetalhados[] = [
                            'extra' => $extra,
                            'quantidade' => $quantidadeExtra,
                        ];
                        // Soma o preço dos extras ao preço do item
                        $precoItem += $extra->preco * $quantidadeExtra; 
                    }
                }
            }

            // Adiciona o item com todos os detalhes ao array final
            $itensDetalhados[$key] = [
                'produto'         => $produto,
                'quantidade'      => $item['quantidade'],
                'especificacao'   => $especificacao,
                'extras'          => $extrasDetalhados,
                'customizacao'    => $item['customizacao'] ?? null, // ALTERAÇÃO 2: Passa a customização para a view.
                'preco_total_item' => $precoItem * $item['quantidade'],
            ];
            
            $total += $itensDetalhados[$key]['preco_total_item'];
        }

        return view('Carrinho/index', [
            'titulo'   => 'Meu Carrinho de Compras',
            'carrinho' => $itensDetalhados,
            'total'    => $total,
        ]);
    }

    /**
     * Adiciona um item ao carrinho.
     */
    public function adicionar()
    {
        if (!$this->autenticacao->estaLogado()) {
            return redirect()->to(site_url('login'))->with('info', 'Faça login para adicionar itens ao carrinho.');
        }

        if ($this->request->getMethod() !== 'post') {
            return redirect()->back()->with('erro', 'Método inválido.');
        }

        $dados = $this->request->getPost();
        $produtoId = $dados['produto_id'] ?? null;
        $quantidadeProduto = (int) ($dados['quantidade_produto'] ?? 1);
        $especificacaoId = $dados['especificacao_id'] ?? null;
        $customizacao = $dados['customizacao'] ?? null; // ALTERAÇÃO 3: Captura a observação do formulário.
        
        $extras = $dados['extras_quantidade'] ?? [];
        $extras = array_filter($extras, function($qtd) {
            return (int)$qtd > 0;
        });

        if (!$produtoId) {
            return redirect()->back()->with('erro', 'Produto inválido.');
        }

        $carrinho = $this->session->get('carrinho') ?? [];
        
        // Cria uma chave única para o item no carrinho
        $itemKey = $produtoId;
        if ($especificacaoId) {
            $itemKey .= '_esp_' . $especificacaoId;
        }
        if (!empty($extras)) {
            ksort($extras);
            $extrasKey = http_build_query($extras);
            $itemKey .= '_ext_' . $extrasKey;
        }
        // ALTERAÇÃO 4: Adiciona a customização à chave para diferenciar itens.
        if (!empty($customizacao)) {
            $itemKey .= '_obs_' . md5($customizacao);
        }

        if (isset($carrinho[$itemKey])) {
            $carrinho[$itemKey]['quantidade'] += $quantidadeProduto;
        } else {
            $carrinho[$itemKey] = [
                'produto_id'       => $produtoId,
                'quantidade'       => $quantidadeProduto,
                'especificacao_id' => $especificacaoId,
                'extras'           => $extras,
                'customizacao'     => $customizacao, // ALTERAÇÃO 5: Salva a customização na sessão.
            ];
        }

        $this->session->set('carrinho', $carrinho);
        return redirect()->to(site_url('carrinho'))->with('sucesso', 'Produto adicionado ao carrinho!');
    }

    /**
     * Remove um item do carrinho usando sua chave única.
     */
    public function remover($itemKey = null)
    {
        if (!$itemKey) {
            return redirect()->back()->with('erro', 'Item inválido para remoção.');
        }

        $carrinho = $this->session->get('carrinho') ?? [];

        if (isset($carrinho[$itemKey])) {
            unset($carrinho[$itemKey]);
            $this->session->set('carrinho', $carrinho);
            return redirect()->back()->with('sucesso', 'Item removido com sucesso.');
        }

        return redirect()->back()->with('erro', 'Item não encontrado no carrinho.');
    }
}