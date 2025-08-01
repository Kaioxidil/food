<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdutoModel;
use App\Models\UsuarioModel;
use App\Models\PedidoModel;
use App\Models\PedidoItemModel;
use App\Models\ProdutoEspecificacaoModel;
use App\Models\ProdutoExtraModel;
use CodeIgniter\API\ResponseTrait;

class PdvController extends BaseController
{
    use ResponseTrait;

    protected $produtoModel;
    protected $usuarioModel;
    protected $pedidoModel;
    protected $pedidoItemModel;
    protected $produtoEspecificacaoModel;
    protected $produtoExtraModel;

    public function __construct()
    {
        $this->produtoModel = new ProdutoModel();
        $this->usuarioModel = new UsuarioModel();
        $this->pedidoModel = new PedidoModel();
        $this->pedidoItemModel = new PedidoItemModel();
        $this->produtoEspecificacaoModel = new ProdutoEspecificacaoModel();
        $this->produtoExtraModel = new ProdutoExtraModel();
    }

    /**
     * Exibe a página principal do PDV com a lista de produtos.
     */
    public function index()
    {
        $data = [
            'titulo' => 'PDV - Ponto de Venda',
            'produtos' => $this->produtoModel->BuscaProdutosPdv(),
        ];

        return view('Admin/Pdv/index', $data);
    }
    
    /**
     * Busca clientes com base em um termo de pesquisa (nome ou CPF).
     * Retorna um JSON com os resultados.
     */
    public function buscarUsuarios()
    {
        $termo = $this->request->getPost('termo');
        if (empty($termo) || strlen($termo) < 3) {
            return $this->response->setJSON([]);
        }

        $usuarios = $this->usuarioModel
            ->select('id, nome, cpf')
            ->like('nome', $termo)
            ->orLike('cpf', $termo)
            ->findAll(10);

        return $this->response->setJSON($usuarios);
    }

    /**
     * Busca as opções (especificações e extras) de um produto.
     * Retorna um JSON com todos os dados necessários para o modal da view.
     */
    public function buscarOpcoes(int $produto_id)
    {
        if (!$produto_id) {
            return $this->response->setJSON(['error' => 'ID do produto não fornecido.']);
        }

        $produto = $this->produtoModel->select('id, nome, preco_minimo')->find($produto_id);
        
        if (!$produto) {
            return $this->response->setJSON(['error' => 'Produto não encontrado.']);
        }

        $especificacoes = $this->produtoEspecificacaoModel
            ->select('produtos_especificacoes.*, medidas.nome as medida')
            ->join('medidas', 'medidas.id = produtos_especificacoes.medida_id')
            ->where('produtos_especificacoes.produto_id', $produto_id)
            ->findAll();

        $extras = $this->produtoExtraModel
            ->select('extras.id, extras.nome, extras.preco')
            ->join('extras', 'extras.id = produtos_extras.extra_id')
            ->where('produtos_extras.produto_id', $produto_id)
            ->findAll();

        $response = [
            'produto' => $produto,
            'especificacoes' => $especificacoes,
            'extras' => $extras,
        ];

        return $this->response->setJSON($response);
    }

    /**
     * Salva a venda e os itens do carrinho no banco de dados.
     * A view envia os dados como JSON.
     */
    public function salvarVenda()
    {
        $requestData = $this->request->getJSON();
    
        if (!$requestData) {
            return $this->fail('Dados da requisição inválidos.', 400);
        }
    
        if (empty($requestData->itens)) {
            return $this->fail('Não há itens no carrinho para finalizar a venda.', 400);
        }
    
        $pedidoData = [
            'usuario_id' => ($requestData->usuario_id === '0' || empty($requestData->usuario_id)) ? null : (int) $requestData->usuario_id,
            'status' => 'venda balcao',
            'valor_total' => (float) $requestData->valor_total,
            'valor_entrega' => 0.00,
        ];
    
        if (!$pedidoId = $this->pedidoModel->insert($pedidoData)) {
            return $this->fail('Falha ao salvar o pedido.', 500);
        }
    
        $itensParaSalvar = [];
        foreach ($requestData->itens as $item) {
            $itensParaSalvar[] = [
                'pedido_id' => $pedidoId,
                'produto_id' => (int) $item->produto_id,
                'produto_especificacao_id' => null, // Não estamos passando a especificação id, então fica nulo
                'quantidade' => (int) $item->quantidade,
                'preco_unitario' => (float) $item->preco, // O preço aqui já é o preço final do item (com extras e especificações)
                'produto_nome' => $item->nome,
            ];
        }
    
        if (!$this->pedidoItemModel->insertBatch($itensParaSalvar)) {
            return $this->fail('Erro ao salvar os itens do pedido.', 500);
        }
    
        return $this->respondCreated(['pedido_id' => $pedidoId, 'message' => 'Venda finalizada com sucesso!']);
    }
}