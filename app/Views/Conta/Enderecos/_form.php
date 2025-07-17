<?php if(session()->has('errors')): ?>
    <div class="alert alert-danger">
        <?php foreach(session('errors') as $error): ?>
            <p><?php echo $error; ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="row">
    <div class="form-group col-md-6">
        <label for="titulo">Título (Ex: Casa)</label>
        <input type="text" class="form-control" name="titulo" value="<?php echo old('titulo', esc($endereco->titulo)); ?>">
    </div>
    <div class="form-group col-md-6">
        <label for="cep">CEP</label>
        <input type="text" class="form-control" name="cep" value="<?php echo old('cep', esc($endereco->cep)); ?>">
    </div>
</div>

<div class="form-group">
    <label for="logradouro">Rua / Logradouro</label>
    <input type="text" class="form-control" name="logradouro" value="<?php echo old('logradouro', esc($endereco->logradouro)); ?>">
</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="numero">Número</label>
        <input type="text" class="form-control" name="numero" value="<?php echo old('numero', esc($endereco->numero)); ?>">
    </div>
    <div class="form-group col-md-8">
        <label for="complemento">Complemento</label>
        <input type="text" class="form-control" name="complemento" value="<?php echo old('complemento', esc($endereco->complemento)); ?>">
    </div>
</div>

<div class="row">
    <div class="form-group col-md-5">
        <label for="bairro">Bairro</label>
        <input type="text" class="form-control" name="bairro" value="<?php echo old('bairro', esc($endereco->bairro)); ?>">
    </div>
    <div class="form-group col-md-5">
        <label for="cidade">Cidade</label>
        <input type="text" class="form-control" name="cidade" value="<?php echo old('cidade', esc($endereco->cidade)); ?>">
    </div>
    <div class="form-group col-md-2">
        <label for="estado">Estado</label>
        <input type="text" class="form-control" name="estado" maxlength="2" value="<?php echo old('estado', esc($endereco->estado)); ?>">
    </div>
</div>

<div class="form-group">
    <label for="referencia">Ponto de Referência</label>
    <textarea class="form-control" name="referencia"><?php echo old('referencia', esc($endereco->referencia)); ?></textarea>
</div>
<hr>