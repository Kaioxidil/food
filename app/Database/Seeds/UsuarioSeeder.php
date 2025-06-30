<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $usuarioModel = new \App\Models\UsuarioModel;

        $usuario = [
            'nome' => "Suporte",
            'email' => "seudeliverytrx@gmail.com",
            'cpf' => "115.439.429-89",
            'telefone' => "(44) 99724-9833"
        ];

        $usuarioModel->protect(false)->insert($usuario);

        dd($usuarioModel->errors());
    }
}
