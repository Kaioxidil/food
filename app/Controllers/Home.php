<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;
use App\Models\ProdutoModel;
use App\Models\UsuarioEnderecoModel; // Adicionado

class Home extends BaseController
{
    private $cart;
    private $categoriaModel;
    private $produtoModel;
    private $usuarioEnderecoModel; // Adicionado
    private $autenticacao;         // Adicionado

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
        $this->produtoModel = new ProdutoModel();
        $this->usuarioEnderecoModel = new UsuarioEnderecoModel(); // Adicionado
        $this->autenticacao = service('autenticacao');         // Adicionado
        
        $this->cart = \Config\Services::cart();
    }

    public function index()
    {
        $data = [
            'titulo'    => 'Seja Bem-vindo(a)!',
            'categoria' => $this->categoriaModel->BuscaCategoriasPublicHome(),
            'produtos'  => $this->produtoModel->BuscaProdutosPublicHome(),
        ];
        return view('Home/index', $data);
    }

    public function Vizualizar()
    {
        $categorias = $this->categoriaModel->orderBy('nome', 'ASC')->findAll();
        $produtosPorCategoria = [];
        $produtosParaSlider = []; 
        
        foreach ($categorias as $categoria) {
            $produtos = $this->produtoModel
                ->select([
                    'produtos.id', 'produtos.nome', 'produtos.slug', 'produtos.descricao',
                    'produtos.ingredientes', 'produtos.ativo', 'produtos.imagem',
                    'MIN(produtos_especificacoes.preco) AS preco',
                ])
                ->join('produtos_especificacoes', 'produtos_especificacoes.produto_id = produtos.id')
                ->where('produtos.categoria_id', $categoria->id)
                ->where('produtos.ativo', true)
                ->groupBy('produtos.id, produtos.nome, produtos.slug, produtos.descricao, produtos.ingredientes, produtos.ativo, produtos.imagem')
                ->orderBy('produtos.nome', 'ASC')
                ->findAll();

            if (!empty($produtos)) {
                $produtosPorCategoria[$categoria->id] = [
                    'categoria' => $categoria,
                    'produtos'  => $produtos
                ];
                $produtosParaSlider = array_merge($produtosParaSlider, $produtos);
            }
        }

        // --- INÍCIO DA LÓGICA PARA BUSCAR O ENDEREÇO DO USUÁRIO ---
        
        $enderecoExibido = 'Rua Exemplo, 123 - Centro'; // Endereço padrão

        if ($this->autenticacao->estaLogado()) {
            $usuario = $this->autenticacao->pegaUsuarioLogado();
            
            // Busca o primeiro endereço do usuário
            $enderecoUsuario = $this->usuarioEnderecoModel->where('usuario_id', $usuario->id)->first();
            
            if ($enderecoUsuario) {
                // Formata o endereço para exibição
                $enderecoExibido = "{$enderecoUsuario->logradouro}, {$enderecoUsuario->numero} - {$enderecoUsuario->bairro}";
            }
        }
        
        // --- FIM DA LÓGICA ---


        // Dados de restaurante (mantidos como dummy data)
        $restaurante = (object) [
            'nome'                    => 'Hamburgada',
            'endereco'                => $enderecoExibido, // <-- AQUI USAMOS A VARIÁVEL COM O ENDEREÇO
            'avaliacao'               => 4,
            'total_avaliacoes'        => 100,
            'tipo_culinaria'          => 'Diversa',
            'descricao'               => 'Uma descrição incrível do restaurante.',
            'telefone'                => '(00) 0000-0000',
            'email'                   => 'contato@restaurante.com',
            'facebook'                => 'https://facebook.com/hamburgada',
            'instagram'               => 'https://instagram.com/hamburgada',
            'pinterest'               => '',
            'youtube'                 => '',
            'observacoes_entrega'     => 'Entrega disponível para toda a cidade. Consulte as taxas de entrega para sua região.',
            'percent_comida_boa'      => 90,
            'percent_entrega_pontual' => 95,
            'percent_pedido_preciso'  => 88,
            'preco_medio'             => 3,
            'horarios'                => [
                'monday' => '7:00am - 10:59pm', 'tuesday' => '7:00am - 10:00pm', 'wednesday' => '7:00am - 10:00pm',
                'thursday' => '7:00am - 10:00pm', 'friday' => '7:00am - 10:00pm', 'saturday' => '7:00am - 10:00pm', 'sunday' => '7:00am - 10:00pm',
            ],
            'galeria' => [
                site_url('web/assets/img/gallery/img-1.jpg'), site_url('web/assets/img/gallery/img-2.jpg'),
                site_url('web/assets/img/gallery/img-3.jpg'), site_url('web/assets/img/gallery/img-4.jpg'),
                site_url('web/assets/img/gallery/img-5.jpg'), site_url('web/assets/img/gallery/img-6.jpg'),
            ],
            'avaliacoes' => [
                (object)['usuario' => 'Sarra', 'local' => 'New York, (NY)', 'tipo_usuario' => 'Top Reviewer', 'data' => 'Sep 20, 2019', 'estrelas' => 5, 'comentario' => 'Delivery was fast and friendly. Food was not great especially the salad. Will not be ordering from again. Too many options to settle for this place.', 'itens_pedidos' => ['Coffee', 'Pizza', 'Noodles', 'Burger']],
                (object)['usuario' => 'João', 'local' => 'São Paulo, (SP)', 'tipo_usuario' => 'Regular', 'data' => 'Oct 15, 2024', 'estrelas' => 4, 'comentario' => 'Boa comida, entrega um pouco demorada mas valeu a pena.', 'itens_pedidos' => ['Sanduíche', 'Batata Frita']],
                (object)['usuario' => 'Maria', 'local' => 'Rio de Janeiro, (RJ)', 'tipo_usuario' => 'Foodie', 'data' => 'Nov 01, 2024', 'estrelas' => 5, 'comentario' => 'Pizza sensacional! Virei cliente.', 'itens_pedidos' => ['Pizza de Calabresa']],
            ],
        ];

        $data = [
            'titulo'               => esc($restaurante->nome),
            'restaurante'          => $restaurante,
            'categorias'           => $categorias,
            'produtosPorCategoria' => $produtosPorCategoria,
            'produtos'             => $produtosParaSlider,
            'carrinho'             => $this->cart,
        ];

        return view('View/index', $data);
    }
    
    // ... O restante dos métodos (imagemCategoria, imagemProduto) continua o mesmo ...
    public function imagemCategoria($imagem = null)
    {
        if (empty($imagem)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $path = WRITEPATH . 'uploads/categorias/' . $imagem;

        if (!file_exists($path)) {
            $path = FCPATH . 'admin/images/sem-imagem.jpg'; 
            if (!file_exists($path)) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Imagem padrão não encontrada.');
            }
        }

        $this->response->setContentType(mime_content_type($path));
        readfile($path);
    }

    public function imagemProduto($imagem = null)
    {
        if (empty($imagem)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $path = WRITEPATH . 'uploads/produtos/' . $imagem;

        if (!file_exists($path)) {
            $path = FCPATH . 'admin/images/sem-imagem.jpg'; 
            if (!file_exists($path)) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Imagem padrão não encontrada.');
            }
        }

        $this->response->setContentType(mime_content_type($path));
        readfile($path);
    }
}