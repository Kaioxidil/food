<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder {
    public function run() {
        
        $usuarioModel = new  \App\Models\UsuarioModel();
        $usuario = [

          'nome' => 'Kaio Gremaschi da Silva',
          'email' => 'kaiogremaschidasilva@gmail.com',
          'cpf' => '326.013.440-91',
          'telefone' => '44 - 9724-9833',

        ];

        $usuarioModel->protect(false)->insert($usuario);

        $usuario = [

          'nome' => 'admin',
          'email' => 'admin@gmail.com',
          'cpf' => '368.407.480-22',
          'telefone' => '44 - 9724-9833',

        ];

        $usuarioModel->protect(false)->insert($usuario);

        dd($usuarioModel->errors());

    }
}
