namespace App\Services;

use App\Models\BairroModel;

class BairroService
{
    private $bairroModel;
    private $client;

    public function __construct()
    {
        $this->bairroModel = new BairroModel();
        $this->client = \Config\Services::curlrequest();
    }

    public function sincronizarBairros(string $cidade, string $estado): array
    {
        $uf = strtoupper($estado);
        $urlMunicipios = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/$uf/municipios";
        $response = $this->client->get($urlMunicipios);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Erro ao buscar cidade no IBGE');
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
            throw new \Exception('Cidade não encontrada');
        }

        $cepBase = '85990000'; 
        $bairroSet = [];

        for ($i = 0; $i < 10; $i++) {
            $cep = (string)((int)$cepBase + $i);
            $viaCepUrl = "https://viacep.com.br/ws/{$cep}/json/";
            $resp = $this->client->get($viaCepUrl);

            if ($resp->getStatusCode() !== 200) continue;

            $data = json_decode($resp->getBody());

            if (!isset($data->bairro) || empty($data->bairro)) continue;

            $bairroNome = trim($data->bairro);

            if (!in_array($bairroNome, $bairroSet)) {
                $bairroSet[] = $bairroNome;

                $bairroExistente = $this->bairroModel->where('nome', $bairroNome)->first();

                if (!$bairroExistente) {
                    $this->bairroModel->insert([
                        'nome' => $bairroNome,
                        'valor_entrega' => 5.00,
                        'cep' => preg_replace('/[^0-9]/', '', $data->cep),
                        'ativo' => true,
                    ]);
                }
            }
        }

        return $bairroSet;
    }
}
