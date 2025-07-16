<?php if (isset($pedido)): ?>
    
    <p><strong>Código do Pedido:</strong> <?php echo esc($pedido->id); ?></p>
    <p><strong>Cliente:</strong> <?php echo esc($pedido->cliente_nome ?? 'Não identificado'); ?></p>
    <p><strong>Status:</strong> <?php echo ucfirst(esc($pedido->status)); ?></p>
    <p><strong>Forma de Pagamento:</strong> <?php echo esc($pedido->forma_pagamento_nome ?? 'Não informada'); ?></p>
    <p><strong>Valor Total:</strong> R$ <?php echo esc(number_format($pedido->valor_total, 2, ',', '.')); ?></p>
    <p><strong>Data do Pedido:</strong> <?php echo date('d/m/Y H:i', strtotime($pedido->criado_em)); ?></p>

    <hr>

    <h4>Itens do Pedido</h4>

    <?php if (empty($pedido->itens)): ?>
        <p>Não há itens neste pedido.</p>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($pedido->itens as $item): ?>
                <li class="list-group-item">
                    <strong><?php echo esc($item->produto_nome); ?></strong>
                    <p class="mb-1">
                        Quantidade: <?php echo esc($item->quantidade); ?><br>
                        Tamanho: <?php echo esc($item->medida_nome ?? 'Padrão'); ?><br>
                        Subtotal: R$ <?php echo esc(number_format($item->subtotal, 2, ',', '.')); ?>
                    </p>
                    
                    <?php if (!empty($item->extras)): ?>
                        <small><strong>Extras:</strong></small>
                        <ul>
                            <?php foreach ($item->extras as $extra): ?>
                                <li><?php echo esc($extra->nome); ?> (x<?php echo esc($extra->quantidade); ?>)</li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

<?php else: ?>
    <div class="alert alert-danger" role="alert">
        Não foi possível carregar os detalhes do pedido.
    </div>
<?php endif; ?>