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
        $this->usuarioEnderecoModel = new UsuarioEnderecoModel();
        $this->pedidoItemModel = new PedidoItemModel();         
        $this->pedidoItemExtraModel = new PedidoItemExtraModel();
        $this->bairroModel = new BairroModel(); 
    }

    public function index()
    {
        $filtros = [
            'busca'  => $this->request->getGet('busca') ?? '',
            'status' => $this->request->getGet('status') ?? '',
        ];

        $entregadores = $this->entregadorModel->where('ativo', true)->findAll();

        $data = [
            'titulo'            => 'Pedidos Realizados',
            'pedidos'           => $this->pedidoModel->recuperaPedidosPaginados($filtros, 10),
            'pager'             => $this->pedidoModel->pager,
            'filtros'           => $filtros,
            'statusDisponiveis' => ['pendente', 'em_preparacao', 'saiu_para_entrega', 'entregue', 'cancelado'],
            'entregadores'      => $entregadores,
        ];

        return view('Admin/Pedidos/index', $data);
    }

    /**
     * CORREÇÃO COMPLETA:
     * Busca todos os dados necessários para a impressão: Endereço, Itens e Extras.
     */
     public function getDadosImpressao()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $pedidoId = $this->request->getGet('pedido_id');
        $pedido = $this->pedidoModel->find($pedidoId);

        if (!$pedido) {
            return $this->response->setJSON(['erro' => 'Pedido não localizado.'])->setStatusCode(404);
        }

        $endereco = null;
        $debug_message = '';

        if ($pedido->endereco_id) {
            $endereco = $this->usuarioEnderecoModel->find($pedido->endereco_id);

            if ($endereco) {
                // --- INÍCIO DA CORREÇÃO DO BAIRRO ---
                
                // Verificamos se existe um bairro associado ao endereço
                if (isset($endereco->bairro) && !empty($endereco->bairro)) {
                    
                    // Usamos o BairroModel para buscar o bairro pelo ID (que está em $endereco->bairro)
                    $bairroDoEndereco = $this->bairroModel->find($endereco->bairro);

                    // Se encontrarmos o bairro, substituímos o ID pelo nome
                    if ($bairroDoEndereco) {
                        $endereco->bairro = $bairroDoEndereco->nome;
                    } else {
                        // Caso não encontre (ex: bairro foi excluído), exibimos uma mensagem de erro
                        $endereco->bairro = "Bairro ID {$endereco->bairro} não encontrado";
                    }
                }
                
                // --- FIM DA CORREÇÃO DO BAIRRO ---

            } else {
                $debug_message = "Erro: O pedido está associado ao ID de endereço '{$pedido->endereco_id}', mas este ID não foi encontrado no banco de dados de endereços.";
            }

        } else {
            $debug_message = 'Atenção: Este pedido não possui um endereço de entrega associado a ele.';
        }

        // Busca os itens (lógica existente)
        $itens = $this->pedidoItemModel->recuperaItensDoPedidoParaImpressao($pedidoId);
        foreach ($itens as $key => $item) {
            $extras = $this->pedidoItemExtraModel->recuperaExtrasDoItem($item['id']);
            if ($extras) {
                $itens[$key]['extras'] = $extras;
            }
        }
        
        // Retorna um JSON com todos os dados, agora com o nome do bairro
        return $this->response->setJSON([
            'itens'    => $itens,
            'endereco' => $endereco,
            'debug'    => $debug_message
        ]);
    }

    public function atualizarStatus()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $id = $this->request->getPost('id');
        $novoStatus = $this->request->getPost('status');

        if (!in_array($novoStatus, $this->statusDisponiveis)) {
            return $this->response->setJSON(['erro' => 'Status inválido.'])->setStatusCode(400);
        }

        $pedido = $this->pedidoModel->find($id);

        if (!$pedido) {
            return $this->response->setJSON(['erro' => 'Pedido não encontrado.'])->setStatusCode(404);
        }

        $pedido->status = $novoStatus;

        if ($this->pedidoModel->save($pedido)) {
            
            // CORREÇÃO: Usamos o método da Entity para gerar o badge
            return $this->response->setJSON([
                'sucesso' => 'Status atualizado com sucesso!',
                'badge'   => $pedido->getStatusBadge() // Agora chama a Entity!
            ]);
        }
        
        return $this->response->setJSON([
            'erro' => 'Não foi possível atualizar o status. Tente novamente.',
            'badge' => $pedido->getStatusBadge() // Consistência até no erro
        ])->setStatusCode(500);
    }

    public function associarEntregador()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $pedidoId = $this->request->getPost('pedido_id');
        $entregadorId = $this->request->getPost('entregador_id');

        $pedido = $this->pedidoModel->find($pedidoId);

        if (!$pedido) {
            return $this->response->setJSON(['erro' => 'Pedido não encontrado.'])->setStatusCode(404);
        }

        $pedido->entregador_id = $entregadorId;

        if ($this->pedidoModel->save($pedido)) {
            return $this->response->setJSON(['sucesso' => 'Entregador associado com sucesso!']);
        }

        return $this->response->setJSON(['erro' => 'Não foi possível associar o entregador.'])->setStatusCode(500);
    }
    
    private function getBadgeHtml(string $status): string
    {
        $badgeCores = [
            'pendente'        => 'badge-warning',
            'em_preparacao'   => 'badge-primary',
            'saiu_para_entrega' => 'badge-info',
            'entregue'        => 'badge-success',
            'cancelado'       => 'badge-danger',
        ];
        
        $classe = $badgeCores[$status] ?? 'badge-secondary';
        $texto = ucfirst(str_replace('_', ' ', $status));

        return '<span class="badge ' . $classe . '">' . $texto . '</span>';
    }

     public function atualizarTabela()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $filtros = [
            'busca'  => $this->request->getGet('busca') ?? '',
            'status' => $this->request->getGet('status') ?? '',
        ];

        $data = [
            'pedidos'           => $this->pedidoModel->recuperaPedidosPaginados($filtros, 10),
            'statusDisponiveis' => $this->statusDisponiveis,
            'entregadores'      => $this->entregadorModel->where('ativo', true)->findAll(),
        ];

        // Renderiza apenas a view parcial com o corpo da tabela
        return view('Admin/Pedidos/_tabela_pedidos', $data);
    }
}