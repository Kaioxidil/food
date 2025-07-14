<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\ProdutoModel;

class Home extends BaseController
{
    private $categoriaModel;
    private $produtoModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
        $this->produtoModel = new ProdutoModel();
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
        foreach ($categorias as $categoria) {
            $produtos = $this->produtoModel
                // Removemos o select('*') pois o Model já define o que é selecionado em BuscaProdutosPublicHome()
                // Aqui, você deve usar um método que traga os produtos de uma categoria específica.
                // Como você já tem a categoria, podemos buscar direto:
                ->select([
                    'produtos.id',
                    'produtos.nome',
                    'produtos.slug',
                    'produtos.descricao',
                    'produtos.ingredientes',
                    'produtos.ativo',
                    'produtos.imagem',
                    'MIN(produtos_especificacoes.preco) AS preco', // Garante que o preço venha aqui
                ])
                ->join('produtos_especificacoes', 'produtos_especificacoes.produto_id = produtos.id')
                ->where('produtos.categoria_id', $categoria->id)
                ->where('produtos.ativo', true)
                ->groupBy('produtos.id, produtos.nome, produtos.slug, produtos.descricao, produtos.ingredientes, produtos.ativo, produtos.imagem') // Agrupa pelas colunas do produto
                ->orderBy('produtos.nome', 'ASC')
                ->findAll();

            // Atenção: Removi a correção do foreach ($produtos as &$produto)
            // pois o $casts no Model e o AS preco no selectMin já farão o trabalho.
            // Mantenha as atribuições abaixo APENAS SE elas não vierem do seu banco de dados
            // ou se forem realmente dados dummy para testes.
            // foreach ($produtos as &$produto) {
            //     $produto->tags = [
            //         '005-chili' => 'Picante',
            //         '006-ketchup' => 'Com Ketchup'
            //     ];
            //     $produto->label_personalizada = 'Novo!'; 
            //     $produto->tipo_combo = 'Combo Família'; 
            //     $produto->avaliacao_media = 4.5; 
            //     $produto->total_avaliacoes = 25; 
            // }
            // unset($produto);

            if (!empty($produtos)) {
                $produtosPorCategoria[$categoria->id] = [
                    'categoria' => $categoria,
                    'produtos'  => $produtos
                ];
            }
        }

        // Dados de restaurante (mantidos como dummy data)
        $restaurante = (object) [
            'nome'                => 'Hamburgada',
            'endereco'            => 'Rua Exemplo, 123 - Centro',
            'avaliacao'           => 4,
            'total_avaliacoes'    => 100,
            'tipo_culinaria'      => 'Diversa',
            'descricao'           => 'Uma descrição incrível do restaurante.',
            'telefone'            => '(00) 0000-0000',
            'email'               => 'contato@restaurante.com',
            'facebook'            => 'https://facebook.com/hamburgada',
            'instagram'           => 'https://instagram.com/hamburgada',
            'pinterest'           => '',
            'youtube'             => '',
            'observacoes_entrega' => 'Entrega disponível para toda a cidade. Consulte as taxas de entrega para sua região.',
            'percent_comida_boa'  => 90,
            'percent_entrega_pontual' => 95,
            'percent_pedido_preciso'  => 88,
            'preco_medio'         => 3, // Adicionado para a seção 'Sobre'
            'horarios'            => [
                'monday' => '7:00am - 10:59pm',
                'tuesday' => '7:00am - 10:00pm',
                'wednesday' => '7:00am - 10:00pm',
                'thursday' => '7:00am - 10:00pm',
                'friday' => '7:00am - 10:00pm',
                'saturday' => '7:00am - 10:00pm',
                'sunday' => '7:00am - 10:00pm',
            ],
            'galeria' => [
                site_url('web/assets/img/gallery/img-1.jpg'),
                site_url('web/assets/img/gallery/img-2.jpg'),
                site_url('web/assets/img/gallery/img-3.jpg'),
                site_url('web/assets/img/gallery/img-4.jpg'),
                site_url('web/assets/img/gallery/img-5.jpg'),
                site_url('web/assets/img/gallery/img-6.jpg'),
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
        ];

        return view('View/index', $data);
    }

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