<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table            = 'pedidos';
    protected $primaryKey       = 'id';
    protected $returnType       = \App\Entities\Pedido::class;
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'usuario_id',
        'entregador_id', 
        'codigo',
        'forma_pagamento_id',
        'status',
        'observacoes',
        'valor_entrega',
        'valor_total',
        'endereco_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';


    // ------------------ MÉTODO CORRIGIDO PARA A DASHBOARD ------------------ //

    /**
     * [CORRIGIDO] Recupera os últimos 10 pedidos com todos os dados necessários para o dashboard.
     */
    public function recuperaUltimosPedidosParaDashboard(): array
    {
        // A mágica acontece aqui! Adicionamos o JOIN com 'formas_pagamento'
        // e selecionamos o seu nome, exatamente como na outra função.
        return $this->select([
                        'pedidos.*', // Usamos pedidos.* para garantir todos os campos do pedido
                        'usuarios.nome AS cliente_nome',
                        'formas_pagamento.nome AS forma_pagamento_nome', // CAMPO ADICIONADO
                    ])
                    ->join('usuarios', 'usuarios.id = pedidos.usuario_id', 'left')
                    ->join('formas_pagamento', 'formas_pagamento.id = pedidos.forma_pagamento_id', 'left') // JOIN ADICIONADO
                    ->orderBy('pedidos.id', 'DESC')
                    ->limit(10)
                    ->findAll();
    }


    /**
     * Recupera os pedidos para a view principal com filtros e paginação.
     */
      public function recuperaPedidosPaginados(array $filtros, int $perPage = 10): array
    {
        $builder = $this->select([
            'pedidos.id',
            'pedidos.status',
            'pedidos.valor_total',
            'pedidos.entregador_id',
            'pedidos.criado_em',
            'usuarios.nome AS cliente_nome',
            'formas_pagamento.nome AS forma_pagamento_nome',
        ])
        ->join('usuarios', 'usuarios.id = pedidos.usuario_id', 'left') // Usar 'left' join é mais seguro
        ->join('formas_pagamento', 'formas_pagamento.id = pedidos.forma_pagamento_id', 'left');

        if (!empty($filtros['busca'])) {
            $builder->like('pedidos.id', $filtros['busca']); // Pesquisar por código é mais comum
        }

        if (!empty($filtros['status'])) {
            $builder->where('pedidos.status', $filtros['status']);
        }

        return $builder->orderBy('pedidos.id', 'DESC')->paginate($perPage);
    }
    
    /**
     * Retorna o valor total de pedidos faturados no mês corrente.
     * Considera o status 'entregue' como faturado.
     */
    public function valorPedidosDoMes(): float
    {
        $primeiroDiaDoMes = date('Y-m-01 00:00:00');
        $ultimoDiaDoMes   = date('Y-m-t 23:59:59');

        $resultado = $this->selectSum('valor_total')
                          ->where('status', 'entregue') // Mudei para 'entregue', que é um status mais comum para faturamento. Ajuste se o seu for 'finalizado'.
                          ->where('criado_em >=', $primeiroDiaDoMes)
                          ->where('criado_em <=', $ultimoDiaDoMes)
                          ->get()->getRow();

        return (float) ($resultado->valor_total ?? 0.0);
    }

    /**
     * Retorna o faturamento por dia dos últimos 30 dias para o gráfico.
     * Considera o status 'entregue' como faturado.
     */
    public function getFaturamentoParaGrafico(): array
    {
        $trintaDiasAtras = date('Y-m-d 00:00:00', strtotime('-30 days'));

        $db = \Config\Database::connect();
        return $db->query(
            "SELECT DATE_FORMAT(criado_em, '%d/%m') as dia, SUM(valor_total) as faturamento 
             FROM pedidos 
             WHERE status = 'entregue' AND criado_em >= ? 
             GROUP BY dia 
             ORDER BY criado_em ASC",
            [$trintaDiasAtras]
        )->getResultObject();
    }


    // --- Demais métodos do seu model (totalPedidosDoMes, getStatusPedidosParaGrafico) podem continuar como estão ---
    
    public function totalPedidosDoMes(): int
    {
        $primeiroDiaDoMes = date('Y-m-01 00:00:00');
        $ultimoDiaDoMes   = date('Y-m-t 23:59:59');

        return $this->where('criado_em >=', $primeiroDiaDoMes)
                    ->where('criado_em <=', $ultimoDiaDoMes)
                    ->countAllResults();
    }
    
    public function getStatusPedidosParaGrafico(): array
    {
        $primeiroDiaDoMes = date('Y-m-01 00:00:00');
        $ultimoDiaDoMes   = date('Y-m-t 23:59:59');

        return $this->select('status, COUNT(id) as total')
                    ->where('criado_em >=', $primeiroDiaDoMes)
                    ->where('criado_em <=', $ultimoDiaDoMes)
                    ->groupBy('status')
                    ->orderBy('total', 'DESC')
                    ->findAll();
    }

    public function recuperaPedidosDoUsuario(int $usuario_id): array
    {
        return $this->select('pedidos.*')
                    ->where('pedidos.usuario_id', $usuario_id)
                    ->orderBy('pedidos.criado_em', 'DESC') // Ordena pelos mais recentes
                    ->findAll();
    }

    public function recuperaDetalhesDoPedido(int $pedido_id, int $usuario_id)
    {
        return $this->select('pedidos.*, formas_pagamento.nome AS forma_pagamento')
                    ->join('formas_pagamento', 'formas_pagamento.id = pedidos.forma_pagamento_id', 'left')
                    ->where('pedidos.id', $pedido_id)
                    ->where('pedidos.usuario_id', $usuario_id)
                    ->first();
    }

     public function recuperaDetalhesDoPedidoParaModal(int $pedido_id, int $usuario_id)
    {
        return $this->select([
                        'pedidos.*',
                        'formas_pagamento.nome AS forma_pagamento',
                        'entregadores.nome AS entregador_nome',
                        
                        // Campos do endereço do usuário
                        'usuarios_enderecos.logradouro',
                        'usuarios_enderecos.numero',
                        'usuarios_enderecos.cidade',
                        'usuarios_enderecos.estado',
                        'usuarios_enderecos.cep',

                        // ✅ CORREÇÃO APLICADA AQUI:
                        // Pegamos o `nome` da tabela `bairros` e o chamamos de `bairro`
                        'bairros.nome AS bairro',
                        'bairros.valor_entrega AS taxa_entrega_bairro'
                    ])
                    ->join('formas_pagamento', 'formas_pagamento.id = pedidos.forma_pagamento_id', 'left')
                    ->join('usuarios_enderecos', 'usuarios_enderecos.id = pedidos.endereco_id', 'left')
                    ->join('entregadores', 'entregadores.id = pedidos.entregador_id', 'left')
                    
                    // ✅ ESTA É A LINHA MAIS IMPORTANTE DA CORREÇÃO:
                    // Juntamos a tabela `bairros` usando o ID que está na coluna `usuarios_enderecos.bairro`.
                    ->join('bairros', 'bairros.id = usuarios_enderecos.bairro', 'left')

                    ->where('pedidos.id', $pedido_id)
                    ->where('pedidos.usuario_id', $usuario_id)
                    ->first();
    }

    public function recuperaPedidoParaImpressao(int $pedido_id)
    {
        $pedido = $this->select([
                                'pedidos.*', // This already includes 'observacoes'
                                'usuarios.nome AS cliente_nome',
                                'formas_pagamento.nome AS forma_pagamento_nome',
                                'entregadores.nome AS entregador_nome',
                                
                                // Campos do endereço do usuário
                                'usuarios_enderecos.logradouro',
                                'usuarios_enderecos.numero',
                                'usuarios_enderecos.complemento',
                                'usuarios_enderecos.referencia',
                                'usuarios_enderecos.cidade',
                                'usuarios_enderecos.estado',
                                'usuarios_enderecos.cep',

                                // Nome do bairro e taxa de entrega
                                'bairros.nome AS bairro_nome',
                                'bairros.valor_entrega AS taxa_entrega_bairro'
                            ])
                            ->join('usuarios', 'usuarios.id = pedidos.usuario_id', 'left')
                            ->join('formas_pagamento', 'formas_pagamento.id = pedidos.forma_pagamento_id', 'left')
                            ->join('entregadores', 'entregadores.id = pedidos.entregador_id', 'left')
                            ->join('usuarios_enderecos', 'usuarios_enderecos.id = pedidos.endereco_id', 'left')
                            ->join('bairros', 'bairros.id = usuarios_enderecos.bairro', 'left')
                            ->where('pedidos.id', $pedido_id)
                            ->first();

        if ($pedido) {
            // Anexar itens do pedido
            $pedidoItemModel = new PedidoItemModel();
            $pedidoItemExtraModel = new PedidoItemExtraModel();

            $itens = $pedidoItemModel->recuperaItensDoPedidoParaImpressao($pedido->id);
            foreach ($itens as $key => $item) {
                $extras = $pedidoItemExtraModel->recuperaExtrasDoItem($item['id']);
                if ($extras) {
                    $itens[$key]['extras'] = $extras;
                }
            }
            $pedido->itens_impressao = $itens;

            // Formatar o endereço para a impressão
            $endereco_impressao = new \stdClass();
            $endereco_impressao->logradouro = $pedido->logradouro;
            $endereco_impressao->numero = $pedido->numero;
            $endereco_impressao->complemento = $pedido->complemento;
            $endereco_impressao->referencia = $pedido->referencia;
            $endereco_impressao->bairro = $pedido->bairro_nome;
            $endereco_impressao->cidade = $pedido->cidade;
            $endereco_impressao->estado = $pedido->estado;
            $endereco_impressao->cep = $pedido->cep;

            $pedido->endereco_impressao = $endereco_impressao;
            
            // Add company information that will be used in the receipt
            $pedido->empresa_nome = 'Nome da Sua Empresa';
            $pedido->empresa_endereco = 'Endereço da Empresa';
            $pedido->empresa_telefone = '(00) 00000-0000';
        }

        return $pedido;
    }


    
}