<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FormaPagamentoModel;
use App\Models\ProdutoModel;
use App\Models\ProdutoEspecificacaoModel;
use App\Models\ExtraModel;

class Finalizar extends BaseController
{
    private $formaPagamentoModel;
    private $produtoModel;
    private $produtoEspecificacaoModel;
    private $extraModel;
    private $session;

    public function __construct()
    {
        $this->formaPagamentoModel = new FormaPagamentoModel();
        $this->produtoModel = new ProdutoModel();
        $this->produtoEspecificacaoModel = new ProdutoEspecificacaoModel();
        $this->extraModel = new ExtraModel();
        $this->session = session();
    }

    /**
     * Exibe a página de finalização do pedido.
     */
    public function index()
    {
        $carrinho = $this->session->get('carrinho');

        if (empty($carrinho)) {
            return redirect()->to(site_url('/'))->with('info', 'Seu carrinho está vazio.');
        }

        $itensDetalhados = [];
        $total = 0;

        foreach ($carrinho as $key => $item) {
            $produto = $this->produtoModel->find($item['produto_id']);
            if (!$produto) {
                continue;
            }

            $precoItem = $produto->preco;
            $especificacao = null;

            if (!empty($item['especificacao_id'])) {
                $especificacao = $this->produtoEspecificacaoModel->getEspecificacaoComDescricao($item['especificacao_id']);
                if ($especificacao) {
                    $precoItem = $especificacao->preco;
                }
            }

            $extrasDetalhados = [];
            if (!empty($item['extras'])) {
                foreach ($item['extras'] as $extraId => $quantidadeExtra) {
                    $extra = $this->extraModel->find($extraId);
                    if ($extra) {
                        $extrasDetalhados[] = ['extra' => $extra, 'quantidade' => $quantidadeExtra];
                        $precoItem += $extra->preco * $quantidadeExtra;
                    }
                }
            }

            $itensDetalhados[$key] = [
                'produto'          => $produto,
                'quantidade'       => $item['quantidade'],
                'especificacao'    => $especificacao,
                'extras'           => $extrasDetalhados,
                'preco_total_item' => $precoItem * $item['quantidade'],
            ];

            $total += $itensDetalhados[$key]['preco_total_item'];
        }

        $formasPagamento = $this->formaPagamentoModel->where('ativo', true)->findAll();

        return view('Finalizar/index', [
            'titulo'           => 'Finalizar Pedido',
            'carrinho'         => $itensDetalhados,
            'total'            => $total,
            'formas_pagamento' => $formasPagamento,
        ]);
    }

    /**
     * Envia o pedido via WhatsApp. (MÉTODO CORRIGIDO)
     */
    public function enviar()
{
    if ($this->request->getMethod() !== 'post') {
        return redirect()->back();
    }

    $carrinho = $this->session->get('carrinho');

    if (empty($carrinho)) {
        return redirect()->to(site_url('/'))->with('info', 'Seu carrinho expirou. Por favor, tente novamente.');
    }

    // Validação do formulário
    $validation = $this->validate([
        'forma_pagamento_id' => 'required',
        // Adicionamos uma regra simples para a observação
        'observacoes' => 'max_length[500]' 
    ]);

    if (!$validation) {
        return redirect()->back()->with('errors', $this->validator->getErrors());
    }
    
    // Captura os dados do POST
    $formaPagamentoId = $this->request->getPost('forma_pagamento_id');
    $observacoes = $this->request->getPost('observacoes'); // <-- CAPTURANDO A OBSERVAÇÃO

    $formaPagamento = $this->formaPagamentoModel->find($formaPagamentoId);
    if (!$formaPagamento) {
        return redirect()->back()->with('erro', 'Forma de pagamento inválida.');
    }

    // Models
    $pedidoModel = new \App\Models\PedidoModel();
    $pedidoItemModel = new \App\Models\PedidoItemModel();
    $pedidoItemExtraModel = new \App\Models\PedidoItemExtraModel();

    $db = \Config\Database::connect();
    $db->transStart();

    // Service de autenticação
    $autenticacao = service('autenticacao');
    $usuario = $autenticacao->pegaUsuarioLogado();
    $usuarioId = $usuario ? $usuario->id : null;

    $totalPedido = 0;

    $pedidoData = [
        'usuario_id'         => $usuarioId,
        'forma_pagamento_id' => $formaPagamentoId,
        'observacoes'        => $observacoes, // <-- SALVANDO A OBSERVAÇÃO NO BANCO
        'valor_total'        => 0, // provisório
        'status'             => 'pendente',
        'criado_em'          => date('Y-m-d H:i:s'),
    ];

    $pedidoModel->insert($pedidoData);
    $pedidoId = $pedidoModel->getInsertID();

    $mensagem = "Olá! Gostaria de fazer o seguinte pedido:\n\n";

    foreach ($carrinho as $item) {
        $produto = $this->produtoModel->find($item['produto_id']);
        if (!$produto) {
            continue;
        }

        $precoUnitario = (float) $produto->preco;
        $tamanho = 'Padrão';
        $especificacaoId = null;

        if (!empty($item['especificacao_id'])) {
            $especificacao = $this->produtoEspecificacaoModel->getEspecificacaoComDescricao($item['especificacao_id']);
            if ($especificacao && isset($especificacao->medida_nome)) {
                $precoUnitario = (float) $especificacao->preco;
                $tamanho = $especificacao->medida_nome;
                $especificacaoId = $item['especificacao_id'];
            }
        }

        $precoTotalExtras = 0;
        if (!empty($item['extras'])) {
            foreach ($item['extras'] as $extraId => $quantidadeExtra) {
                $extra = $this->extraModel->find($extraId);
                if ($extra) {
                    $precoTotalExtras += (float) $extra->preco * $quantidadeExtra;
                }
            }
        }

        $subtotal = ($precoUnitario + $precoTotalExtras) * $item['quantidade'];
        $totalPedido += $subtotal;

        // Insere item do pedido
        $pedidoItemData = [
            'pedido_id'        => $pedidoId,
            'produto_id'       => $item['produto_id'],
            'especificacao_id' => $especificacaoId,
            'quantidade'       => $item['quantidade'],
            'preco_unitario'   => $precoUnitario,
            'preco_extras'     => $precoTotalExtras,
            'subtotal'         => $subtotal,
        ];

        $pedidoItemModel->insert($pedidoItemData);
        $pedidoItemId = $pedidoItemModel->getInsertID();

        // Insere extras do item
        if (!empty($item['extras'])) {
            foreach ($item['extras'] as $extraId => $quantidadeExtra) {
                $extra = $this->extraModel->find($extraId);
                if ($extra) {
                    $pedidoItemExtraModel->insert([
                        'pedido_item_id' => $pedidoItemId,
                        'extra_id'       => $extraId,
                        'quantidade'     => $quantidadeExtra,
                        'preco'          => $extra->preco,
                    ]);
                }
            }
        }
        
        // Monta mensagem do item
        $mensagem .= "➡️ *Produto:* {$produto->nome}\n";
        $mensagem .= "   - *Tamanho:* {$tamanho}\n";
        $mensagem .= "   - *Quantidade:* {$item['quantidade']}\n";
        if (!empty($item['extras'])) {
            $mensagem .= "   - *Extras:*\n";
            foreach ($item['extras'] as $extraId => $quantidadeExtra) {
                $extra = $this->extraModel->find($extraId);
                if ($extra) {
                    $mensagem .= "     • {$extra->nome} (x{$quantidadeExtra})\n";
                }
            }
        }
        $mensagem .= "\n"; // Adiciona uma linha em branco para separar os itens
    }

    // Atualiza total do pedido
    $pedidoModel->update($pedidoId, ['valor_total' => $totalPedido]);

    $db->transComplete();

    $mensagem .= "----------------------------------\n";
    // <-- ADICIONANDO OBSERVAÇÃO NA MENSAGEM WHATSAPP -->
    if (!empty($observacoes)) {
        $mensagem .= "*Observações:* " . esc($observacoes) . "\n\n";
    }
    // <-- FIM DA ADIÇÃO -->
    $mensagem .= "*Forma de Pagamento:* {$formaPagamento->nome}\n";
    $mensagem .= "*Total do Pedido:* R$ " . number_format($totalPedido, 2, ',', '.') . "\n";
    if ($usuario && $usuario->nome) {
        $mensagem .= "*Cliente:* " . esc($usuario->nome) . "\n";
    }
    $mensagem .= "\nObrigado(a)!";

    // Remove carrinho
    $this->session->remove('carrinho');

    $numeroWhatsapp = '5544997249833'; // Substitua pelo número correto, se necessário
    $textoCodificado = rawurlencode($mensagem);
    $urlWhatsapp = "https://wa.me/{$numeroWhatsapp}?text={$textoCodificado}";

    return redirect()->to($urlWhatsapp);
}

}