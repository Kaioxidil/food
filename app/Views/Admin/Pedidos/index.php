<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?> <?php echo $titulo; ?> <?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
<link rel="stylesheet" href="<?php echo site_url('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css'); ?>">
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?> 

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?php echo $titulo; ?></h4>
                    
                        <div class="table-responsive">
                            <table id="tabela-pedidos" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Cliente</th>
                                        <th>Valor Total</th>
                                        <th>Forma de Pagamento</th>
                                        <th>Status</th>
                                        <th>Criado em</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($pedidos)): ?>
                                        <?php foreach ($pedidos as $pedido): ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo site_url("admin/pedidos/show/$pedido->id"); ?>">
                                                    <?php echo esc($pedido->id); ?>
                                                </a>
                                            </td>
                                            <td><?php echo esc($pedido->cliente_nome ?? 'Cliente Anônimo'); ?></td>
                                            <td>R$ <?php echo esc(number_format($pedido->valor_total, 2, ',', '.')); ?></td>
                                            <td><?php echo esc($pedido->forma_pagamento_nome ?? 'Não informada'); ?></td>
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
                                            <td><?php echo date('d/m/Y H:i', strtotime($pedido->criado_em)); ?></td>
                                            <td>
                                                <a href="<?php echo site_url("admin/pedidos/show/$pedido->id"); ?>" class="btn btn-sm btn-info">Detalhes</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Nenhum pedido encontrado.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<script src="<?php echo site_url('admin/vendors/datatables.net/jquery.dataTables.js') ?>"></script>
<script src="<?php echo site_url('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.js') ?>"></script>

<script>
    $(document).ready(function() {
        $('#tabela-pedidos').DataTable({
            "language": {
                "url": "<?php echo site_url('admin/vendors/datatables.net/pt-BR.json'); ?>"
            }
        });
    });
</script>

<?php echo $this->endSection(); ?>