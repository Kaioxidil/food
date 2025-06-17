<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class Usuarios extends BaseController
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {

        $data = [

            'titulo' => 'Listando os usuários',
            'usuarios' => $this->usuarioModel->findAll(),

        ];

        return view('Admin/Usuarios/index', $data);
    }

    public function procurar(){
    // Permite apenas requisições AJAX
    if (!$this->request->isAJAX()) {
        exit('Página não encontrada');
    }

    $usuarios = $this->usuarioModel->procurar($this->request->getGet('term'));

    $retorno = [];

    foreach ($usuarios as $usuario) {
        $data['id'] = $usuario->id;
        $data['value'] = $usuario->nome;
        $retorno[] = $data;
    }

    return $this->response->setJSON($retorno);
}


    public function show($id = null){

        $usuario = $this->buscaUsuarioOu404($id);

        $data = [
            'titulo' => "Detalhes do usuário: $usuario->nome",
            'usuario' => $usuario,
        ];

        return view('Admin/Usuarios/show', $data);
    }


    public function editar($id = null){

        $usuario = $this->buscaUsuarioOu404($id);


        $data = [
            'titulo' => "Editando usuário: $usuario->nome",
            'usuario' => $usuario,
        ];

        return view('Admin/Usuarios/editar', $data);
    }

    /**
     * Busca um usuário pelo ID ou retorna 404
     */
    private function buscaUsuarioOu404($id = null){
        if (!$id || !$usuario = $this->usuarioModel->where(['id' => $id])->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o usuário $id");
        }
        return $usuario;
    }
}
