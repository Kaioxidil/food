<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('titulo') ?>
    <?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Foto de Perfil</h3>
            </div>
            <?= form_open_multipart('admin/empresa/uploadFotos') ?>
                <div class="card-body text-center">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $empresa->id ?>">
                    <input type="hidden" name="upload_type" value="profile">

                    <p><strong>Foto de Perfil Atual:</strong></p>
                    <?php if ($empresa->foto_perfil): ?>
                        <img src="<?= site_url('uploads/' . $empresa->foto_perfil) ?>" alt="Foto de Perfil" class="img-fluid rounded" style="max-height: 250px;">
                    <?php else: ?>
                        <p>Nenhuma foto de perfil definida.</p>
                    <?php endif; ?>
                    
                    <hr>
                    <div class="form-group">
                        <label for="foto_perfil_file">Enviar/Alterar Foto de Perfil:</label>
                        <input type="file" class="form-control-file" id="foto_perfil_file" name="foto_perfil_file" accept="image/*" required>
                        <small class="form-text text-muted">Máximo 2MB. Formatos: JPG, PNG.</small>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-upload"></i> Salvar Foto</button>
                    <?php if ($empresa->foto_perfil): ?>
                        <a href="<?= site_url('admin/empresa/deleteFoto/'. $empresa->id . '/foto_perfil') ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja remover a foto de perfil?');"><i class="mdi mdi-delete"></i> Remover</a>
                    <?php endif; ?>
                </div>
            <?= form_close() ?>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Banner da Empresa</h3>
            </div>
            <?= form_open_multipart('admin/empresa/uploadFotos') ?>
                <div class="card-body text-center">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $empresa->id ?>">
                    <input type="hidden" name="upload_type" value="banner">
                    
                    <p><strong>Banner Atual:</strong></p>
                    <?php if ($empresa->banner): ?>
                        <img src="<?= site_url('uploads/' . $empresa->banner) ?>" alt="Banner" class="img-fluid rounded" style="max-height: 250px;">
                    <?php else: ?>
                        <p>Nenhum banner definido.</p>
                    <?php endif; ?>
                    
                    <hr>
                    <div class="form-group">
                        <label for="banner_file">Enviar/Alterar Banner:</label>
                        <input type="file" class="form-control-file" id="banner_file" name="banner_file" accept="image/*" required>
                        <small class="form-text text-muted">Máximo 5MB. Formatos: JPG, PNG.</small>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-upload"></i> Salvar Banner</button>
                    <?php if ($empresa->banner): ?>
                        <a href="<?= site_url('admin/empresa/deleteFoto/'. $empresa->id . '/banner') ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja remover o banner?');"><i class="mdi mdi-delete"></i> Remover</a>
                    <?php endif; ?>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12 text-center">
        <a href="<?= site_url('admin/empresa/detalhes/' . $empresa->id) ?>" class="btn btn-secondary">
            <i class="mdi mdi-arrow-left"></i> Voltar para Detalhes da Empresa
        </a>
    </div>
</div>
<?= $this->endSection() ?>