<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Entities\Extra;

class Extras extends BaseController{

    private $extraModel;

    public function __construct(){

        $this->extraModel = new \App\Models\ExtraModel();

    }

    public function index() {
        
        $data = [

            'titulo' => 'Listando os extras de produtos',
            'extras' => $this->extraModel->withDeleted(true)->paginate(10),
            'pager'  => $this->extraModel->pager
        ];

        return view('Admin/Extras/index', $data);
    }       

    public function procurar(){
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada');
        }

        $extras = $this->extraModel->procurar($this->request->getGet('term'));
        $retorno  = [];

        foreach ($extras as $extra) {
            $data['id']    = $extra->id;
            $data['value'] = $extra->nome;
            $retorno[]     = $data;
        }

        return $this->response->setJSON($retorno);
    }


    public function show($id = null)
    {
        $extra = $this->buscaExtraOu404($id);

        $data    = [
            'titulo'  => "Detalhando extras: $extra->nome",
            'extra' => $extra,
        ];

        return view('Admin/extras/show', $data);
    }

    public function criar() {

        $extra = new extra();

        $data = [
            'titulo'  => "Cadastrando novo extra",
            'extra' => $extra,
        ];

        return view('Admin/extras/criar', $data);
    }


    public function cadastrar()
     {
        if ($this->request->getMethod() === 'post') {
 


            $extra = new extra($this->request->getPost());  

            if ($this->extraModel->save($extra)) {
                return redirect()
                    ->to(site_url("admin/extras/show/".$this->extraModel->getInsertID()))
                    ->with('sucesso', "Extra cadastrado com sucesso: $extra->nome.");
            } else {
                return redirect()
                    ->back()
                    ->with('errors_model', $this->extraModel->errors())
                    ->with('atencao', 'Verifique os erros abaixo.')
                    ->withInput();
            }
        } else {
            // Não é POST
            return redirect()->back();
        }
    }

    public function editar($id = null)
    {
        $extra = $this->buscaExtraOu404($id);

        if (null != $extra->deletado_em) {
            return redirect()
                ->back()
                ->with('info', "O extra $extra->nome encontra-se excluído. Não é possível editar.");
        }

        $data = [
            'titulo'  => "Editando extra: $extra->nome",
            'extra' => $extra,
        ];

        return view('Admin/Extras/editar', $data);
    }

     public function atualizar($id = null)
     {
        if ($this->request->getMethod() === 'post') {
            $extra = $this->buscaExtraOu404($id);

            if (null != $extra->deletado_em) {
                return redirect()
                    ->back()
                    ->with('info', "O extra $extra->nome encontra-se excluído. Não é possível atualizar.");
            }


            $extra->fill($this->request->getPost());

            if (!$extra->hasChanged()) {
                return redirect()->back()
                    ->with('info', 'Não há dados para atualizar.');
            }

            if ($this->extraModel->save($extra)) {
                return redirect()
                    ->to(site_url("admin/extras/show/$extra->id"))
                    ->with('sucesso', "Extra atualizado com sucesso: $extra->nome.");
            } else {
                return redirect()
                    ->back()
                    ->with('errors_model', $this->extraModel->errors())
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
        $extra = $this->buscaextraOu404($id);

        if (null != $extra->deletado_em) {
            return redirect()
                ->back()
                ->with('info', "A extra $extra->nome já encontra-se excluído.");
        }

        if ($this->request->getMethod() === 'post') {
            $this->extraModel->delete($id);
            return redirect()->to(site_url('admin/extras'))
                ->with('sucesso', "extra excluído com sucesso: $extra->nome.");
        }

        $data = [
            'titulo'  => "Excluindo a extra: $extra->nome",
            'extra' => $extra,
        ];

        return view('Admin/extras/excluir', $data);
    }

    public function desfazerExclusao($id = null)
    {
        $extra = $this->buscaExtraOu404($id);

        if (null == $extra->deletado_em) {
            return redirect()->back()->with('info', 'Apenas extras excluídos podem ser recuperados.');
        }

        if ($this->extraModel->desfazerExclusao($id)) {
            return redirect()->back()->with('sucesso', 'Exclusão desfeita com sucesso.');
        } else {
            return redirect()
                ->back()
                ->with('errors_model', $this->extraModel->errors())
                ->with('atencao', 'Verifique os erros abaixo.')
                ->withInput();
        }
    }


    private function buscaExtraOu404(int $id = null)
    {
        if (!$id || !$extra = $this->extraModel->withDeleted(true)->where('id', $id)->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o extra: $id");
        }

        return $extra;
    }
}
