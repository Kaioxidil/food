<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder {
    public function run() {
        
        $usuarioModel = new  \App\Models\UsuarioModel();
        $usuario = [

          'nome' => 'Kaio Gremaschi da Silva',
          'email' => 'kaiogremaschidasilva@gmail.com',
          'telefone' => '44 - 9724-9833',

        ];

        $usuarioModel->protect(false)->insert($usuario);

        $usuario = [

          'nome' => 'admin',
          'email' => 'admin@gmail.com',
          'telefone' => '44 - 9724-9833',

        ];

        $usuarioModel->protect(false)->insert($usuario);

        dd($usuarioModel->errors());

    }
}
