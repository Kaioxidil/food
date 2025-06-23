<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Entities\Categoria;

class Categorias extends BaseController
{
    private $categoriaModel;

    public function __construct(){

        $this->categoriaModel = new \App\Models\CategoriaModel();

    }

    public function index(){
        
        $data = [
            'titulo' => 'Listando as categorias',
            'categorias' => $this->categoriaModel->withDeleted(true)->paginate(10),
            'pager' => $this->categoriaModel->pager
        ];

        return view('Admin/Categorias/index', $data);

    }
    
    public function procurar(){
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada');
        }

        $categorias = $this->categoriaModel->procurar($this->request->getGet('term'));
        $retorno  = [];

        foreach ($categorias as $categoria) {
            $data['id']    = $categoria->id;
            $data['value'] = $categoria->nome;
            $retorno[]     = $data;
        }

        return $this->response->setJSON($retorno);
    }

     public function criar() {

        $categoria = new Categoria();

        $data = [
            'titulo'  => "Cadastrando nova categoria",
            'categoria' => $categoria,
        ];

        return view('Admin/categorias/criar', $data);
    }

     public function cadastrar()
     {
        if ($this->request->getMethod() === 'post') {
 


            $categoria = new Categoria($this->request->getPost());  

            if ($this->categoriaModel->save($categoria)) {
                return redirect()
                    ->to(site_url("admin/categorias/show/".$this->categoriaModel->getInsertID()))
                    ->with('sucesso', "Categoria cadastrada com sucesso: $categoria->nome.");
            } else {
                return redirect()
                    ->back()
                    ->with('errors_model', $this->categoriaModel->errors())
                    ->with('atencao', 'Verifique os erros abaixo.')
                    ->withInput();
            }
        } else {
            // Não é POST
            return redirect()->back();
        }
    }


    public function show($id = null)
    {
        $categoria = $this->buscaCategoriaOu404($id);
        $data    = [
            'titulo'  => "Detalhando categoria: $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/categorias/show', $data);
    }

    public function editar($id = null)
    {
        $categoria = $this->buscaCategoriaOu404($id);

        if (null != $categoria->deletado_em) {
            return redirect()
                ->back()
                ->with('info', "A categoria $categoria->nome encontra-se excluída. Não é possível editar.");
        }

        $data = [
            'titulo'  => "Editando categoria: $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/categorias/editar', $data);
    }

     public function atualizar($id = null)
     {
        if ($this->request->getMethod() === 'post') {
            $categoria = $this->buscaCategoriaOu404($id);

            if (null != $categoria->deletado_em) {
                return redirect()
                    ->back()
                    ->with('info', "A categoria $categoria->nome encontra-se excluído. Não é possível atualizar.");
            }


            $categoria->fill($this->request->getPost());

            if (!$categoria->hasChanged()) {
                return redirect()->back()
                    ->with('info', 'Não há dados para atualizar.');
            }

            if ($this->categoriaModel->save($categoria)) {
                return redirect()
                    ->to(site_url("admin/categorias/show/$categoria->id"))
                    ->with('sucesso', "Categoria atualizada com sucesso: $categoria->nome.");
            } else {
                return redirect()
                    ->back()
                    ->with('errors_model', $this->categoriaModel->errors())
                    ->with('atencao', 'Verifique os erros abaixo.')
                    ->withInput();
            }
        } else {
            // Não é POST
            return redirect()->back();
        }
    }

    public function excluir($id = null)
    {
        $categoria = $this->buscaCategoriaOu404($id);

        if (null != $categoria->deletado_em) {
            return redirect()
                ->back()
                ->with('info', "A categoria $categoria->nome já encontra-se excluído.");
        }

        if ($this->request->getMethod() === 'post') {
            $this->categoriaModel->delete($id);
            return redirect()->to(site_url('admin/categorias'))
                ->with('sucesso', "Categoria excluída com sucesso: $categoria->nome.");
        }

        $data = [
            'titulo'  => "Excluindo a categoria: $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/categorias/excluir', $data);
    }

    public function desfazerExclusao($id = null)
    {
        $categoria = $this->buscaCategoriaOu404($id);

        if (null == $categoria->deletado_em) {
            return redirect()->back()->with('info', 'Apenas categorias excluídas podem ser recuperados.');
        }

        if ($this->categoriaModel->desfazerExclusao($id)) {
            return redirect()->back()->with('sucesso', 'Exclusão desfeita com sucesso.');
        } else {
            return redirect()
                ->back()
                ->with('errors_model', $this->categoriaModel->errors())
                ->with('atencao', 'Verifique os erros abaixo.')
                ->withInput();
        }
    }


    private function buscaCategoriaOu404(int $id = null)
    {
        if (!$id || !$categoria = $this->categoriaModel->withDeleted(true)->where('id', $id)->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos a categoria: $id");
        }

        return $categoria;
    }
}
