
<div class="form-row">

<div class="form-group col-md-5">
    <label for="nome">Nome</label>
    <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" value="<?php echo esc($usuario->nome); ?>">
</div>

<div class="form-group col-md-2">
    <label for="cpf">Cpf</label>
    <input type="text" class="form-control cpf" name="cpf" id="cpf" placeholder="Cpf" value="<?php echo esc($usuario->cpf); ?>">
</div>

<div class="form-group col-md-2">
    <label for="telefone">Telefone</label>
    <input type="text" class="form-control sp_celphones" name="telefone" id="telefone" placeholder="Telefone" value="<?php echo esc($usuario->telefone); ?>">
</div>

<div class="form-group col-md-3">
    <label for="email">Email</label>
    <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo esc($usuario->email); ?>">
</div>

</div>

<div class="form-row">
    <div class="form-group col-md-4">
        <label for="password">Senha</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Senha">
    </div>
    <div class="form-group col-md-4">
        <label for="password_confirm">Confirmar Senha</label>
        <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirmar Senha">
    </div>

    <div class="form-group col-md-2">
        <label for="administrador">Perfil de Acesso</label>
        <select class="form-control" name="administrador" id="administrador">

            <?php if ($usuario->is_admin): ?>
                <option value="1" <?php echo ($usuario->is_admin == 1 ? 'selected' : ''); ?>>Administrador</option>
                <option value="0" <?php echo ($usuario->is_admin == 0 ? 'selected' : ''); ?>>Cliente</option>
            <?php else: ?>
                <option value="1">Administrador</option>
                <option value="0" selected>Cliente</option>
            <?php endif; ?>
        </select>
    </div>


    <div class="form-group col-md-2">
        <label for="status">Status</label>
        <select class="form-control" name="status" id="status">
            
            <?php if ($usuario->ativo): ?>
                <option value="1" <?php echo ($usuario->ativo == 1 ? 'selected' : ''); ?>>Ativo</option>
                <option value="0" <?php echo ($usuario->ativo == 0 ? 'selected' : ''); ?>>Inativo</option>
            <?php else: ?>
                <option value="1">Ativo</option>
                <option value="0" selected>Inativo</option>
            <?php endif; ?>
        </select>
    </div>

    

</div>

<button type="submit" class="btn btn-primary mr-2">
<i class="fa-regular fa-floppy-disk" style="font-size: 1em;"></i> Salvar</button>

<a href="<?php echo site_url("admin/usuarios/show/$usuario->id"); ?>" class="btn btn-warning text-white">
<i class="fa fa-arrow-left" style="font-size: 1em;"></i> Voltar</a>
