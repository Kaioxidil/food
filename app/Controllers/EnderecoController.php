<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioEnderecoModel;
use App\Models\BairroModel; // Importa o model BairroModel

class EnderecoController extends BaseController
{
    private $usuarioEnderecoModel;
    private $bairroModel;
    private $autenticacao;
    private $usuarioLogado;

    public function __construct()
    {
        $this->usuarioEnderecoModel = new UsuarioEnderecoModel();
        $this->bairroModel = new BairroModel();  // Instancia BairroModel
        $this->autenticacao = service('autenticacao');

        $this->usuarioLogado = $this->autenticacao->pegaUsuarioLogado();
    }

    /**
     * Lista todos os endereços do usuário logado.
     */
    public function index()
    {
        if ($this->usuarioLogado === null) {
            return redirect()->route('login');
        }

        return view('Conta/Enderecos/index', [
            'titulo' => 'Meus Endereços',
            'enderecos' => $this->usuarioEnderecoModel->where('usuario_id', $this->usuarioLogado->id)->findAll(),
        ]);
    }

    /**
     * Exibe o formulário para criar um novo endereço.
     */
    public function criar()
    {
        return view('Conta/Enderecos/criar', [
            'titulo' => 'Adicionar Novo Endereço',
            'endereco' => new \App\Entities\UsuarioEndereco(),
            'bairros' => $this->bairroModel->where('ativo', true)->orderBy('nome')->findAll(), // Passa bairros ativos
        ]);
    }

    /**
     * Processa o formulário de criação de endereço.
     */
    public function cadastrar()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        $endereco = new \App\Entities\UsuarioEndereco($this->request->getPost());
        $endereco->usuario_id = $this->usuarioLogado->id;

        if ($this->usuarioEnderecoModel->save($endereco)) {
            return redirect()->route('conta.enderecos')->with('sucesso', 'Endereço salvo com sucesso!');
        }

        return redirect()->back()
            ->with('errors', $this->usuarioEnderecoModel->errors())
            ->with('atencao', 'Por favor, verifique os erros abaixo.')
            ->withInput();
    }

    /**
     * Exibe o formulário para editar um endereço existente.
     */
    public function editar(int $id)
    {
        $endereco = $this->buscaEnderecoOu404($id);

        return view('Conta/Enderecos/editar', [
            'titulo' => 'Editar Endereço',
            'endereco' => $endereco,
            'bairros' => $this->bairroModel->where('ativo', true)->orderBy('nome')->findAll(), // Passa bairros ativos
        ]);
    }

    /**
     * Processa o formulário de atualização de endereço.
     */
    public function atualizar(int $id)
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        $endereco = $this->buscaEnderecoOu404($id);

        $postData = $this->request->getPost();
        $endereco->fill($postData);

        if (!$endereco->hasChanged()) {
            return redirect()->back()->with('info', 'Nenhuma alteração foi detectada.');
        }

        if ($this->usuarioEnderecoModel->save($endereco)) {
            return redirect()->route('conta.enderecos')->with('sucesso', 'Endereço atualizado com sucesso!');
        }

        return redirect()->back()
            ->with('errors', $this->usuarioEnderecoModel->errors())
            ->with('atencao', 'Por favor, verifique os erros abaixo.')
            ->withInput();
    }

    /**
     * Processa a exclusão (soft delete) de um endereço.
     */
    public function excluir(int $id)
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        $endereco = $this->buscaEnderecoOu404($id);

        if ($this->usuarioEnderecoModel->delete($id)) {
            return redirect()->route('conta.enderecos')->with('sucesso', 'Endereço excluído com sucesso.');
        }

        return redirect()->back()->with('erro', 'Não foi possível excluir o endereço.');
    }

    /**
     * Busca um endereço específico do usuário logado ou retorna erro 404.
     */
    private function buscaEnderecoOu404(int $id)
    {
        $endereco = $this->usuarioEnderecoModel->where('id', $id)
                                               ->where('usuario_id', $this->usuarioLogado->id)
                                               ->first();

        if (!$endereco) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Endereço não encontrado.");
        }

        return $endereco;
    }
}
