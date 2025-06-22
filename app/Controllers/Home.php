<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function email(){

        $email = \Config\Services::email();

        $email->setTo('gabrielasouzacaiado@gmail.com');
        $email->setFrom('seudeliverytrx@gmail.com', 'SeuDelivery');
        $email->setSubject('Teste de envio');
        $email->setMessage('<h1>Funcionou!</h1><p>Esse é um e-mail de teste.</p>');

        if ($email->send()) {
            echo 'Email enviado com sucesso!';
        } else {
            echo $email->printDebugger(['headers']);
        }


    }
}
