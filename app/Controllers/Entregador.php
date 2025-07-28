<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EntregadorModel;
use App\Models\PedidoModel;
use CodeIgniter\API\ResponseTrait;

class Entregador extends BaseController
{
    use ResponseTrait;

    private $entregadorModel;
    private $pedidoModel;

    public function __construct()
    {
        $this->entregadorModel = new EntregadorModel();
        $this->pedidoModel = new PedidoModel();
    }

    public function login()
    {
        if (session()->get('entregador_logado')) {
            return redirect()->to(site_url('entregador/painel'));
        }
        return view('entregador/login', ['titulo' => 'Login do Entregador']);
    }

    public function autenticar()
    {
        $rules = [
            'nome' => 'required|min_length[4]',
            'cpf'  => 'required|exact_length[14]|validaCpf',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $entregador = $this->entregadorModel->where('cpf', $this->request->getPost('cpf'))->first();

        if ($entregador && $entregador->nome === $this->request->getPost('nome')) {
            session()->set([
                'entregador_logado' => true,
                'entregador_id'     => $entregador->id,
                'entregador_nome'   => $entregador->nome,
            ]);
            return redirect()->to(site_url('entregador/painel'))->with('sucesso', 'Bem-vindo(a), ' . $entregador->nome . '!');
        }
        
        return redirect()->back()->withInput()->with('error', 'Nome ou CPF inválidos.');
    }
    
    public function painel()
    {
        if (!session()->get('entregador_logado')) {
            return redirect()->to(site_url('entregador/login'))->with('info', 'Por favor, faça login para acessar o painel.');
        }

        $agent = $this->request->getUserAgent();
        if (!$agent->isMobile()) {
            // Se você quer que seja acessível apenas via mobile, mantenha isso.
            // Caso contrário, remova ou ajuste a mensagem de erro.
            return view('errors/html/error_403_mobile_only');
        }

        $data = [
            'titulo'            => 'Painel do Entregador',
            'entregador_nome'   => session()->get('entregador_nome'),
        ];

        return view('entregador/painel', $data);
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('entregador/login'))->with('info', 'Você foi desconectado(a).');
    }


    // ------------------ MÉTODOS AJAX PARA O PAINEL ------------------ //

    public function atualizarPedidos()
    {
        // Garante que só requisições AJAX de entregadores logados cheguem aqui
        if (!$this->request->isAJAX() || !session()->get('entregador_logado')) {
            return $this->failUnauthorized('Acesso negado.');
        }

        // Obtém o ID do entregador da sessão
        $entregadorId = session()->get('entregador_id');
        
        // Recupera os pedidos que pertencem a este entregador
        $data['pedidos'] = $this->pedidoModel->recuperaPedidosParaEntregador($entregadorId);

        // Retorna a view parcial com os pedidos para ser inserida no DOM
        return view('entregador/_tabela_pedidos', $data);
    }
    
    public function detalhesPedidoModal(int $pedido_id)
    {
        if (!$this->request->isAJAX() || !session()->get('entregador_logado')) {
            return $this->failUnauthorized('Acesso negado.');
        }

        $pedido = $this->pedidoModel->recuperaDetalhesDoPedidoParaEntregador($pedido_id, session()->get('entregador_id'));
        
        if (!$pedido) {
            return $this->failNotFound('Pedido não encontrado ou não atribuído a você.');
        }

        // Retorna a view parcial do modal de detalhes
        return view('entregador/detalhes_pedido_modal', ['pedido' => $pedido]);
    }

    public function mapaRotaModal(int $pedido_id)
    {
        if (!$this->request->isAJAX() || !session()->get('entregador_logado')) {
            return $this->failUnauthorized('Acesso negado.');
        }

        $pedido = $this->pedidoModel->recuperaDetalhesDoPedidoParaEntregador($pedido_id, session()->get('entregador_id'));

        if (!$pedido || !$pedido->logradouro) {
            return $this->failNotFound('Endereço do pedido não encontrado.');
        }

        // Retorna a view parcial do modal do mapa
        return view('entregador/mapa_rota_modal', ['pedido' => $pedido]);
    }

    /**
     * Método para alterar o status do pedido via POST (AJAX).
     * Recebe o ID do pedido e o novo status.
     */
    public function mudarStatusPedido()
    {
        // Garante que a requisição é um POST e que o entregador está logado
        if (!$this->request->isAJAX() || $this->request->getMethod() !== 'post' || !session()->get('entregador_logado')) {
            return $this->failUnauthorized('Ação não permitida.');
        }

        $pedidoId = $this->request->getPost('pedido_id');
        $novoStatus = $this->request->getPost('novo_status');
        $entregadorId = session()->get('entregador_id');

        if (empty($pedidoId) || empty($novoStatus)) {
            return $this->failValidationErrors('Dados do pedido ou novo status inválidos.');
        }

        // Tenta atualizar o status do pedido usando o Model
        $success = $this->pedidoModel->atualizarStatusDoPedido($pedidoId, $novoStatus, $entregadorId);

        if ($success) {
            // Se foi sucesso, retorna uma resposta JSON para o JS
            return $this->respondUpdated(['message' => 'Status do pedido atualizado com sucesso!', 'status_atualizado' => $novoStatus]);
        } else {
            // Se falhou (pedido não encontrado, status inválido, transição inválida)
            return $this->failForbidden('Não foi possível atualizar o status do pedido. Verifique o status atual ou se o pedido lhe pertence.');
        }
    }
}