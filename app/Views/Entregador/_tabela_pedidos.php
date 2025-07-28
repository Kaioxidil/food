<?php if (empty($pedidos)): ?>

    <div class="no-orders-message">
        <p>Você não tem entregas pendentes no momento. 🎉</p>
    </div>

<?php else: ?>

    <table class="pedidos-table">
        <tbody id="pedidos-tbody">
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td data-label="Código"><?= esc($pedido->id) ?></td>
                    <td data-label="Cliente"><?= esc($pedido->cliente_nome) ?></td>
                    
                    <td data-label="Endereço"><?= esc("{$pedido->logradouro}, {$pedido->numero} - {$pedido->bairro_nome}") ?></td>
                    
                    <td data-label="Ações">
                        <button class="btn-acao btn-detalhes" data-pedido-id="<?= esc($pedido->id) ?>">
                            <i class="fas fa-info-circle"></i> Detalhes
                        </button>
                        <button class="btn-acao btn-mapa-rota" data-pedido-id="<?= esc($pedido->id) ?>">
                            <i class="fas fa-route"></i> Ver Rota
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>