<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BairroModel;
use App\Models\FormaPagamentoModel;
use App\Models\PedidoItemExtraModel;
use App\Models\PedidoItemModel;
use App\Models\PedidoModel;
use App\Models\UsuarioEnderecoModel;
use App\Services\CarrinhoService;

class Finalizar extends BaseController
{
    private const VALOR_ENTREGA_FIXO = 5.00; // <-- TAXA DE ENTREGA FIXA DEFINIDA AQUI

    private $formaPagamentoModel;
    private $bairroModel;
    private $usuarioEnderecoModel;
    private $session;
    private $autenticacao;
    private $carrinhoService;

    public function __construct()
    {
        $this->formaPagamentoModel = new FormaPagamentoModel();
        $this->bairroModel = new BairroModel();
        $this->usuarioEnderecoModel = new UsuarioEnderecoModel();
        $this->session = session();
        $this->autenticacao = service('autenticacao');
        $this->carrinhoService = new CarrinhoService();
    }

    public function index()
    {
        if (!$this->session->has('carrinho') || empty($this->session->get('carrinho'))) {
            return redirect()->to(site_url('/carrinho'))->with('info', 'Seu carrinho está vazio.');
        }

        $carrinhoData = $this->carrinhoService->getCarrinho();
        $totalComEntrega = $carrinhoData['total'] + self::VALOR_ENTREGA_FIXO; // Soma a taxa fixa

        $data = [
            'titulo'           => 'Finalizar Pedido',
            'carrinho'         => $carrinhoData['itens'],
            'subtotal'         => $carrinhoData['total'],
            'taxa_entrega'     => self::VALOR_ENTREGA_FIXO, // Passa a taxa para a view
            'total'            => $totalComEntrega, // Passa o total final para a view
            'formas_pagamento' => $this->formaPagamentoModel->where('ativo', true)->findAll(),
            'bairros'          => $this->bairroModel->where('ativo', true)->findAll(),
        ];

        if ($this->autenticacao->estaLogado()) {
            $data['enderecos'] = $this->usuarioEnderecoModel->where('usuario_id', $this->autenticacao->pegaUsuarioLogado()->id)->findAll();
        }

        return view('Finalizar/index', $data);
    }

    public function enviar()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        $regras = [
            'forma_pagamento_id' => ['label' => 'Forma de Pagamento', 'rules' => 'required|integer'],
            'bairro_id'          => ['label' => 'Bairro para Entrega', 'rules' => 'required|integer'],
            'endereco'           => ['label' => 'Endereço de Entrega', 'rules' => 'required|max_length[255]'],
        ];

        if (!$this->validate($regras)) {
            return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
        }

        $carrinhoData = $this->carrinhoService->getCarrinho();
        $bairro = $this->bairroModel->find($this->request->getPost('bairro_id')); // Bairro ainda é necessário para saber onde entregar
        
        $db = \Config\Database::connect();
        $db->transStart();

        $usuario = $this->autenticacao->pegaUsuarioLogado();
        $totalPedido = $carrinhoData['total'] + self::VALOR_ENTREGA_FIXO; // Usa a taxa fixa

        $pedidoData = [
            'usuario_id'         => $usuario->id ?? null,
            'forma_pagamento_id' => $this->request->getPost('forma_pagamento_id'),
            'bairro'             => $bairro->nome,
            'valor_entrega'      => self::VALOR_ENTREGA_FIXO, // Salva a taxa fixa
            'endereco'           => $this->request->getPost('endereco'),
            'observacoes'        => $this->request->getPost('observacoes'),
            'valor_produtos'     => $carrinhoData['total'],
            'valor_total'        => $totalPedido,
            'status'             => 'pendente',
            'criado_em'          => date('Y-m-d H:i:s'),
        ];
        
        $pedidoModel = new PedidoModel();
        $pedidoModel->insert($pedidoData);
        $pedidoId = $pedidoModel->getInsertID();

        $this->_insereItensDoPedido($pedidoId, $carrinhoData['itens']);
        $mensagem = $this->_montaMensagemWhatsApp($pedidoId, $carrinhoData, $pedidoData);
        
        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('erro', 'Não foi possível processar seu pedido.')->withInput();
        }

        $this->session->remove('carrinho');
        $numeroWhatsapp = '5544997249833';
        $urlWhatsapp = "https://wa.me/{$numeroWhatsapp}?text=" . rawurlencode($mensagem);

        return redirect()->to($urlWhatsapp);
    }
    
    private function _insereItensDoPedido(int $pedidoId, array $itens)
    {
        $pedidoItemModel = new PedidoItemModel();
        $pedidoItemExtraModel = new PedidoItemExtraModel();

        foreach ($itens as $item) {
            $precoUnitario = ($item['quantidade'] > 0) ? $item['preco_total_item'] / $item['quantidade'] : 0;
            $itemData = [
                'pedido_id'        => $pedidoId,
                'produto_id'       => $item['produto']->id,
                'especificacao_id' => $item['especificacao']->id ?? null,
                'quantidade'       => $item['quantidade'],
                'preco_unitario'   => $precoUnitario,
                'observacao'       => $item['customizacao'],
            ];
            $pedidoItemModel->insert($itemData);
            $pedidoItemId = $pedidoItemModel->getInsertID();

            if (!empty($item['extras'])) {
                foreach ($item['extras'] as $extraItem) {
                    $pedidoItemExtraModel->insert([
                        'pedido_item_id' => $pedidoItemId,
                        'extra_id'       => $extraItem['extra']->id,
                        'quantidade'     => $extraItem['quantidade'],
                        'preco'          => $extraItem['extra']->preco,
                    ]);
                }
            }
        }
    }

    private function _montaMensagemWhatsApp(int $pedidoId, array $carrinhoData, array $pedidoData): string
{
    // --- CABEÇALHO ---
    // Usamos emojis para dar um destaque inicial e festivo.
    $mensagem = "📦 *Novo Pedido Recebido!* 📦\n";
    $mensagem .= "🆔 *ID do Pedido:* {$pedidoId}\n";
    $mensagem .= "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

    // --- ITENS DO PEDIDO ---
    // Um cabeçalho para a seção de itens.
    $mensagem .= "🛒 *Itens do Pedido:*\n\n";

    foreach ($carrinhoData['itens'] as $item) {
        // Emoji de seta para indicar cada item principal.
        $mensagem .= "➡️ *{$item['produto']->nome}* (x{$item['quantidade']})\n";

        // Emoji de régua para o tamanho/especificação.
        if ($item['especificacao']) {
            $mensagem .= "   📏 *Tamanho:* {$item['especificacao']->medida_nome}\n";
        }
        
        // Emoji de estrelas para os extras.
        if (!empty($item['extras'])) {
            $mensagem .= "   ✨ *Extras:*\n";
            foreach ($item['extras'] as $extraInfo) {
                $mensagem .= "      • {$extraInfo['extra']->nome} (x{$extraInfo['quantidade']})\n";
            }
        }
        
        // Emoji de anotação para customizações.
        if (!empty($item['customizacao'])) {
            $mensagem .= "   📝 _Observação do item: {$item['customizacao']}_\n";
        }
        $mensagem .= "\n"; // Espaçamento entre os itens
    }

    $mensagem .= "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

    // --- RESUMO DA ENTREGA E CLIENTE ---
    $mensagem .= "📋 *Resumo da Entrega:*\n\n";

    // Busca o nome do usuário logado de forma segura.
    $nomeCliente = $this->autenticacao->pegaUsuarioLogado()->nome ?? 'Não informado';
    $mensagem .= "👤 *Cliente:* {$nomeCliente}\n";
    
    // Emojis de localização para endereço.
    $mensagem .= "📍 *Endereço:* " . esc($pedidoData['endereco']) . "\n";
    $mensagem .= "🏘️ *Bairro:* " . esc($pedidoData['bairro']) . "\n\n";

    // Emoji de balão de diálogo para observações gerais.
    if (!empty($pedidoData['observacoes'])) {
        $mensagem .= "💬 *Observações Gerais (Troco):* " . esc($pedidoData['observacoes']) . "\n\n";
    }

    // --- DETALHES FINANCEIROS ---
    $mensagem .= "💰 *Detalhes do Pagamento:*\n\n";

    $mensagem .= "   *Subtotal dos Produtos:* R$ " . number_format($carrinhoData['total'], 2, ',', '.') . "\n";
    $mensagem .= "   *Taxa de Entrega:* R$ " . number_format($pedidoData['valor_entrega'], 2, ',', '.') . "\n";
    $mensagem .= "   *Valor Total:* *R$ " . number_format($pedidoData['valor_total'], 2, ',', '.') . "*\n"; // Total em negrito

    // Busca a forma de pagamento
    $formaPagamento = $this->formaPagamentoModel->find($pedidoData['forma_pagamento_id']);
    $mensagem .= "💳 *Forma de Pagamento:* {$formaPagamento->nome}\n\n";
    

    // --- ENCERRAMENTO ---
    $mensagem .= "Agradecemos a preferência! 🙏";

    return $mensagem;
}
}