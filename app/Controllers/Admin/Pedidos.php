<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\EntregadorModel;
use App\Models\UsuarioEnderecoModel; 
use App\Models\PedidoItemModel; 
use App\Models\PedidoItemExtraModel; 
use App\Models\BairroModel; 

class Pedidos extends BaseController
{
    private $pedidoModel;
    private $entregadorModel;
    private $usuarioEnderecoModel; 
    private $pedidoItemModel; 
    private $pedidoItemExtraModel; 
    private $bairroModel; 
    
    private $statusDisponiveis = [
        'pendente', 'em_preparacao', 'saiu_para_entrega', 'entregue', 'cancelado'
    ];

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->entregadorModel = new EntregadorModel();
        $this->usuarioEnderecoModel = new UsuarioEnderecoModel(); // Manter ou remover conforme necessidade
        $this->pedidoItemModel = new PedidoItemModel(); // Manter ou remover conforme necessidade
        $this->pedidoItemExtraModel = new PedidoItemExtraModel(); // Manter ou remover conforme necessidade
        $this->bairroModel = new BairroModel(); // Manter ou remover conforme necessidade
    }

    public function index()
    {
        $filtros = [
            'busca'  => $this->request->getGet('busca') ?? '',
            'status' => $this->request->getGet('status') ?? '',
        ];

        // Busca os pedidos paginados
        $pedidos = $this->pedidoModel->recuperaPedidosPaginados($filtros, 10);
        
        // Carregar dados de impressão para cada pedido
        if (!empty($pedidos)) {
            foreach ($pedidos as $key => $pedido) {
                $detalhes_impressao = $this->pedidoModel->recuperaPedidoParaImpressao($pedido->id);
                
                if ($detalhes_impressao) {
                    $pedidos[$key]->itens_impressao = $detalhes_impressao->itens_impressao;
                    $pedidos[$key]->endereco_impressao = $detalhes_impressao->endereco_impressao;
                    // Ensure observation data is included
                    $pedidos[$key]->observacoes = $detalhes_impressao->observacoes ?? '';
                    $pedidos[$key]->forma_pagamento_nome = $detalhes_impressao->forma_pagamento_nome ?? '';
                    
                    // Company info
                    $pedidos[$key]->empresa_nome = $detalhes_impressao->empresa_nome ?? 'Nome da Empresa';
                    $pedidos[$key]->empresa_endereco = $detalhes_impressao->empresa_endereco ?? 'Endereço da Empresa';
                    $pedidos[$key]->empresa_telefone = $detalhes_impressao->empresa_telefone ?? '(00) 00000-0000';
                }
            }
        }

        $data = [
            'titulo'            => 'Pedidos Realizados',
            'pedidos'           => $pedidos,
            'pager'             => $this->pedidoModel->pager,
            'filtros'           => $filtros,
            'statusDisponiveis' => $this->statusDisponiveis,
            'entregadores'      => $this->entregadorModel->where('ativo', true)->findAll(),
        ];

        return view('Admin/Pedidos/index', $data);
    }
    
    public function processarAcao()
    {
        if (strtolower($this->request->getMethod()) !== 'post') {
            return redirect()->back()->with('atencao', 'Ação não permitida.');
        }

        // Recebemos os dados de um único pedido aqui
        $pedidoId = $this->request->getPost('pedido_id');
        $status = $this->request->getPost('status');
        $entregadorId = $this->request->getPost('entregador_id');

        if (empty($pedidoId) || empty($status)) {
            return redirect()->back()->with('atencao', 'Dados inválidos para atualização.');
        }

        if (in_array($status, ['saiu_para_entrega', 'entregue']) && empty($entregadorId)) {
            return redirect()->back()->with('atencao', 'Para o status "Saiu para entrega" ou "Entregue", é obrigatório selecionar um entregador.');
        }
        
        // Busca o pedido original para comparar o status
        $pedidoOriginal = $this->pedidoModel->find($pedidoId);
        if (!$pedidoOriginal) {
            return redirect()->back()->with('atencao', 'Pedido não encontrado para atualização.');
        }

        $dadosPedido = [
            'id' => $pedidoId,
            'status' => $status,
            'entregador_id' => !empty($entregadorId) ? $entregadorId : null,
        ];

        if ($this->pedidoModel->save($dadosPedido)) {
            // A lógica de impressão agora dispara se o status MUDOU para um dos designados
            if ($status !== $pedidoOriginal->status && ($status === 'em_preparacao' || ($status === 'saiu_para_entrega' && !empty($entregadorId)))) {
                session()->setFlashdata('imprimir_cupom', $pedidoId);
            }
            return redirect()->to('admin/pedidos' . '?' . http_build_query($this->request->getGet()))->with('sucesso', 'Pedido atualizado com sucesso!');
        } else {
            return redirect()->back()->with('atencao', 'Não foi possível atualizar o pedido.');
        }
    }

    
}