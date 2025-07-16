<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?> <?php echo $titulo; ?> <?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?> 

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-header">
                        <h4>📊 Últimos Pedidos Realizados</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Cliente</th>
                                        <th>Valor Total</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($pedidos)): ?>
                                        <?php foreach ($pedidos as $pedido): ?>
                                        <tr>
                                            <td>
                                                <a href="javascript:void(0);" 
                                                   class="btn-detalhes-pedido" 
                                                   data-pedido-id="<?php echo $pedido->id; ?>">
                                                    <?php echo esc($pedido->id); ?>
                                                </a>
                                            </td>
                                            <td><?php echo esc($pedido->cliente_nome ?? 'Cliente Anônimo'); ?></td>
                                            <td>R$ <?php echo esc(number_format($pedido->valor_total, 2, ',', '.')); ?></td>
                                            <td>
                                                <?php
                                                    $status = esc($pedido->status);
                                                    $badge = 'secondary';
                                                    switch ($status) {
                                                        case 'pendente': $badge = 'danger'; break;
                                                        case 'em andamento': $badge = 'warning'; break;
                                                        case 'finalizado': $badge = 'success'; break;
                                                        case 'cancelado': $badge = 'light'; break;
                                                    }
                                                ?>
                                                <label class="badge badge-<?php echo $badge; ?>"><?php echo ucfirst($status); ?></label>
                                            </td>
                                            <td><?php echo date('d/m/Y', strtotime($pedido->criado_em)); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-info btn-detalhes-pedido" data-pedido-id="<?php echo $pedido->id; ?>">
                                                    Detalhes
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Nenhum pedido encontrado nos últimos dias.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 text-center">
                            <a href="<?php echo site_url('admin/pedidos'); ?>" class="btn btn-primary">Ver todos os pedidos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPedido" tabindex="-1" role="dialog" aria-labelledby="modalPedidoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPedidoLabel">Detalhes do Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>

<script>
$(document).ready(function() {
    
    $('.btn-detalhes-pedido').on('click', function(e) {
        e.preventDefault(); // Impede qualquer comportamento padrão do link/botão

        const pedidoId = $(this).data('pedido-id');
        const url = '<?php echo site_url('admin/home/detalhes/'); ?>' + pedidoId;
        const modal = $('#modalPedido');
        
        $.ajax({
            url: url,
            method: 'GET',
            beforeSend: function() {
                // Mostra uma mensagem de "carregando"
                modal.find('.modal-title').text('Carregando detalhes...');
                modal.find('.modal-body').html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Carregando...</span></div></div>');
                modal.modal('show');
            },
            success: function(response) {
                // Atualiza o título e o corpo do modal com a resposta do controller
                modal.find('.modal-title').text('Detalhes do Pedido ' + pedidoId);
                modal.find('.modal-body').html(response);
            },
            error: function(xhr) {
                // Em caso de erro, exibe uma mensagem
                modal.find('.modal-title').text('Ocorreu um Erro');
                const errorMsg = xhr.responseJSON ? xhr.responseJSON.error : 'Não foi possível carregar os detalhes. Tente novamente.';
                modal.find('.modal-body').html('<div class="alert alert-danger">' + errorMsg + '</div>');
            }
        });
    });

});
</script>

<?php echo $this->endSection(); ?>