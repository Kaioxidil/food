<?php echo $this->extend('layout/principalView'); ?> 


<?= $this->section('titulo') ?> <?= esc($titulo) ?> <?= $this->endSection() ?>

<?php echo $this->section('conteudo'); ?>

<style>
     .menu-lateral .list-group-item {
        border: none; border-left: 4px solid transparent; border-radius: 0;
        padding: 15px 20px; font-weight: 500; color: #555;
    }
    .menu-lateral .list-group-item:hover,
    .menu-lateral .list-group-item:focus {
        background-color: #e9ecef; color: #000;
    }
    .menu-lateral .list-group-item.active {
        border-left: 4px solid #EA1D2C; /* Cor principal iFood */
        background-color: #f7f7f7; font-weight: 700; color: #EA1D2C;
    }
    .menu-lateral .list-group-item i {
        margin-right: 12px; width: 20px;
    }

</style>

<br>
<br>
<br>

<div class="container mt-5 mb-5">
    <div class="row">

         <div class="col-lg-3">
            <div class="menu-lateral bg-white rounded shadow-sm">
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action"><i class="bi bi-person-circle"></i> Meu Perfil</a>
                    <a href="<?= site_url('conta/pedidos') ?>" class="list-group-item list-group-item-action "><i class="bi bi-box-seam"></i> Meus Pedidos</a>
                    <a href="<?= site_url('conta/enderecos') ?>" class="list-group-item list-group-item-action active"><i class="bi bi-geo-alt"></i> Meus Endereços</a>
                    <a href="<?= site_url('login/logout') ?>" class="list-group-item list-group-item-action text-danger"><i class="bi bi-box-arrow-right"></i> Sair</a>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <h2><?php echo esc($titulo); ?></h2>
            <hr>

            <?php if(session()->has('sucesso')): ?>
                <div class="alert alert-success"><?php echo session('sucesso'); ?></div>
            <?php endif; ?>
            <?php if(session()->has('erro')): ?>
                <div class="alert alert-danger"><?php echo session('erro'); ?></div>
            <?php endif; ?>

            <a href="<?php echo site_url('conta/enderecos/criar'); ?>" class="btn btn-primary mb-3">Adicionar Novo Endereço</a>

            <?php if (empty($enderecos)): ?>
                <p>Você ainda não tem nenhum endereço cadastrado.</p>
            <?php else: ?>
                <div class="list-group">
                    <?php foreach ($enderecos as $endereco): ?>
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1"><?php echo esc($endereco->titulo); ?></h5>
                                    <p class="mb-1">
                                        <?php echo esc($endereco->logradouro); ?>, <?php echo esc($endereco->numero); ?> - <?php echo esc($endereco->bairro); ?><br>
                                        <?php echo esc($endereco->cidade); ?> - <?php echo esc($endereco->estado); ?>, CEP: <?php echo esc($endereco->cep); ?>
                                    </p>
                                </div>
                                <div class="text-nowrap"> <a href="<?php echo site_url('conta/enderecos/editar/' . $endereco->id); ?>" class="btn btn-sm btn-outline-primary me-1">Editar</a>
                                    
                                    <?php echo form_open("conta/enderecos/excluir/{$endereco->id}", ['class' => 'd-inline', 'onsubmit' => 'return confirm("Tem certeza que deseja excluir este endereço?");']); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        </div>
</div>

<br>
<br>
<?php echo $this->endSection(); ?>