<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;
use App\Models\ProdutoModel;
use App\Models\UsuarioEnderecoModel; 
use App\Models\EmpresaModel;

class Home extends BaseController
{
    private $cart;
    private $categoriaModel;
    private $produtoModel;
    private $usuarioEnderecoModel; 
    private $autenticacao;        
    private $empresaModel; 

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
        $this->produtoModel = new ProdutoModel();
        $this->usuarioEnderecoModel = new UsuarioEnderecoModel(); 
        $this->autenticacao = service('autenticacao');  
        $this->empresaModel = new EmpresaModel();       
        
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
        
        $enderecoExibido = 'Endereço não informado';
        if ($this->autenticacao->estaLogado()) {
            $usuario = $this->autenticacao->pegaUsuarioLogado();
            $enderecoUsuario = $this->usuarioEnderecoModel->where('usuario_id', $usuario->id)->first();
            if ($enderecoUsuario) {
                $enderecoExibido = "{$enderecoUsuario->logradouro}, {$enderecoUsuario->numero} - {$enderecoUsuario->bairro}";
            }
        }

        // --- INÍCIO DA ALTERAÇÃO ---

        // 1. Busca os dados da primeira empresa encontrada no banco de dados.
        $empresa = $this->empresaModel->first();

        // 2. ADIÇÃO: Verificação de segurança.
        // Se nenhuma empresa for encontrada, exibimos uma página de erro 404.
        // Isso evita erros na view se a variável $empresa for nula.
        if (!$empresa) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Nenhuma empresa encontrada no sistema.');
        }

        // 3. Decodifica os horários de funcionamento.
        $horariosDecodificados = json_decode($empresa->horarios_funcionamento ?? '[]', true);

        // --- FIM DA ALTERAÇÃO ---

        $data = [
            'titulo'               => esc($empresa->nome),
            'empresa'              => $empresa, 
            'horarios'             => $horariosDecodificados,
            'categorias'           => $categorias,
            'produtosPorCategoria' => $produtosPorCategoria,
            'produtos'             => $produtosParaSlider, // Esta variável alimenta o slider de produtos
            'carrinho'             => $this->cart,
            'enderecoExibido'      => $enderecoExibido
        ];

        return view('View/index', $data);
    }

    public function imagem($imagem = null)
    {
        if (empty($imagem)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Supondo que as imagens da empresa ficam em 'uploads/empresa'
        $path = WRITEPATH . 'uploads/empresa/' . $imagem;

        if (file_exists($path)) {
            $this->response->setContentType(mime_content_type($path));
            readfile($path);
        } else {
            // Se a imagem não for encontrada, pode retornar um 404
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Imagem não encontrada.');
        }
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