<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Entities\Bairro;

class Bairros extends BaseController
{

    private $bairroModel;

    function __construct(){
        
        $this->bairroModel = new \App\Models\BairroModel();

    }

    public function index()
    {
        
        $data = [

            'titulo' => 'Listando os bairros antendidos',
            'bairros' => $this->bairroModel->withDeleted(true)->paginate(10),
            'pager'=> $this->bairroModel->page,
        ];


        return view('Admin/Bairros/index', $data);


    }
}
