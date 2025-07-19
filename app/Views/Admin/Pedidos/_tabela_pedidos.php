<?php if (empty($pedidos)): ?>
    <tr>
        <td colspan="8" class="text-center">Nenhum pedido encontrado no momento.</td>
    </tr>
<?php else: ?>
    <?php foreach ($pedidos as $pedido): ?>
        <tr>
            <td>
               
                    <?php echo $pedido->id; ?>
                
            </td>
            
            <td><?php echo esc($pedido->cliente_nome); ?></td>
            
            <td><?php echo $pedido->criado_em->humanize(); ?></td>
            
            <td>
                <select class="form-control form-control-sm select-status" data-pedido-id="<?php echo $pedido->id; ?>">
                    <?php foreach ($statusDisponiveis as $status): ?>
                        <option value="<?php echo $status; ?>" <?php echo ($status == $pedido->status ? 'selected' : ''); ?>>
                            <?php echo ucfirst(str_replace('_', ' ', $status)); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>

            <td>
                <?php if ($pedido->status === 'saiu_para_entrega' || $pedido->status === 'entregue'): ?>
                    <select class="form-control form-control-sm select-entregador" data-pedido-id="<?php echo $pedido->id; ?>">
                        <option value="">Selecione...</option>
                        <?php foreach ($entregadores as $entregador): ?>
                            <option value="<?php echo $entregador->id; ?>" <?php echo ($entregador->id == $pedido->entregador_id ? 'selected' : ''); ?>>
                                <?php echo esc($entregador->nome); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <span>--</span>
                <?php endif; ?>
            </td>

            <td>R$ <?= number_format((float) ($pedido->valor_total ?? 0), 2, ',', '.'); ?></td>

            
            <td><?php echo esc($pedido->forma_pagamento_nome); ?></td>

            <td>
                <button class="btn btn-sm btn-outline-primary imprimir-cupom" 
                        data-id="<?php echo $pedido->codigo; ?>"
                        data-cliente="<?php echo esc($pedido->cliente_nome); ?>"
                        data-valor="<?php echo number_format((float) ($pedido->valor_total ?? 0), 2, ',', '.'); ?>"

                        data-data="<?php echo $pedido->criado_em; ?>"
                        data-url-dados="<?= site_url('admin/pedidos/getdadosimpressao?pedido_id='.$pedido->id); ?>">
                    <i class="mdi mdi-printer"></i>

                </button>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>