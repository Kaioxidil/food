<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?> <?php echo $titulo; ?> <?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>

<!--Enviamos os estilos-->

<?php echo $this->endSection() ?>





<?php echo $this->section('conteudo'); ?>

<!--Enviamos o conteudo-->

<?php echo $titulo; ?>


<?php echo $this->endSection() ?>






<?php echo $this->section('scripts'); ?>

<!--Enviamos os scripts-->

<?php echo $this->endSection() ?>