<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BairroModel;

class Bairros extends BaseController
{
    private $bairroModel;

    public function __construct()
    {
        $this->bairroModel = new BairroModel();
    }

    public function index()
    {
        $data = [
            'titulo' => 'Listando os bairros atendidos',
            'bairros' => $this->bairroModel->withDeleted(true)->paginate(10),
            'pager' => $this->bairroModel->pager,
        ];

        return view('Admin/Bairros/index', $data);
    }

    public function sincronizar()
    {
        $cidade = 'Terra Roxa'; // Defina dinamicamente, se quiser
        $estado = 'PR';

        $uf = strtoupper($estado);

        $urlMunicipios = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/$uf/municipios";

        $client = \Config\Services::curlrequest();
        $response = $client->get($urlMunicipios);

        if ($response->getStatusCode() !== 200) {
            return $this->response->setStatusCode(500)->setJSON(['erro' => 'Erro ao buscar cidade no IBGE']);
        }

        $municipios = json_decode($response->getBody());

        $idMunicipio = null;
        foreach ($municipios as $municipio) {
            if (strtolower($municipio->nome) === strtolower($cidade)) {
                $idMunicipio = $municipio->id;
                break;
            }
        }

        if (!$idMunicipio) {
            return $this->response->setStatusCode(404)->setJSON(['erro' => 'Cidade não encontrada']);
        }

        $cepBase = '85990000'; // CEP base para busca (ajuste conforme necessário)
        $bairroSet = [];

        for ($i = 0; $i < 10; $i++) {
            $cep = (string)((int)$cepBase + $i);

            $viaCepUrl = "https://viacep.com.br/ws/{$cep}/json/";
            $resp = $client->get($viaCepUrl);

            if ($resp->getStatusCode() !== 200) {
                continue;
            }

            $data = json_decode($resp->getBody());

            if (!isset($data->bairro) || empty($data->bairro)) {
                continue;
            }

            $bairroNome = trim($data->bairro);

            // Evita duplicatas
            if (!in_array($bairroNome, $bairroSet)) {
                $bairroSet[] = $bairroNome;

                // Verifica se o bairro já existe para evitar duplicidade no banco
                $bairroExistente = $this->bairroModel->where('nome', $bairroNome)->first();

                if (!$bairroExistente) {
                    $this->bairroModel->insert([
                        'nome' => $bairroNome,
                        'valor_entrega' => 5.00, // valor padrão numérico
                        'cep' => preg_replace('/[^0-9]/', '', $data->cep),
                        'ativo' => true
                    ]);
                }
            }
        }

        return $this->response->setJSON([
            'status' => 'sucesso',
            'bairros_importados' => $bairroSet,
        ]);
    }
}
