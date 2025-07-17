<?php echo $this->extend('layout/principalView'); ?> 


<?= $this->section('titulo') ?> <?= esc($titulo) ?> <?= $this->endSection() ?>

<?php echo $this->section('conteudo'); ?>

<br>
<br>
<br>

<div class="container mt-5 mb-5">
    <div class="row">

        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    Minha Conta
                </div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action">Meu Perfil</a>
                    <a href="#" class="list-group-item list-group-item-action">Meus Pedidos</a>
                    <a href="<?php echo route_to('conta.enderecos'); ?>" class="list-group-item list-group-item-action active">
                        Meus Endereços
                    </a>
                    <a href="<?php echo site_url('login/logout'); ?>" class="list-group-item list-group-item-action">Sair</a>
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