<?php echo $this->extend('layout/principalView'); ?>

<?php echo $this->section('conteudo'); ?>
<br>
<br>
<br>

<div class="container mt-5">
    <h2><?php echo esc($titulo); ?></h2>
    
    <?php echo form_open(route_to('enderecos.atualizar', $endereco->id)); ?>
        
        <?php echo $this->include('Conta/Enderecos/_form'); ?> <button type="submit" class="btn btn-success">Atualizar Endereço</button>
        <a href="<?php echo route_to('conta.enderecos'); ?>" class="btn btn-secondary">Cancelar</a>
        
    <?php echo form_close(); ?>
</div>

<br>
<br>
<br>
<?php echo $this->endSection(); ?>