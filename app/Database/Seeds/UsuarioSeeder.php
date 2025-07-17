<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{

    public function run()
    {
        
        $usuarioModel = new \App\Models\UsuarioModel();

        $usuarioModel->where('email', "seudeliverytrx@gmail.com")->delete();


        $usuario = [
            'nome'      => "Suporte",
            'email'     => "seudeliverytrx@gmail.com",
            'cpf'       => "115.439.429-89",
            'telefone'  => "(44) 99724-9833",
            'is_admin'  => 1,
            'password'  => 'K@io310107ff', 
            'password_confirmation' => 'K@io310107ff',
            'ativo'     => 1,
 
        ];
 
        $usuarioModel->protect(false)->insert($usuario);


        echo "Usuário 'Suporte' inserido com status ATIVO!\n";
    }
}