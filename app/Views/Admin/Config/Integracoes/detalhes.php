<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('titulo') ?>
    <?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('estilos') ?>
<style>
    .info-label { font-weight: bold; color: #555; margin-bottom: 3px; font-size: 0.9em; }
    .info-data { background-color: #f8f9fa; padding: 10px; border-radius: 4px; border: 1px solid #dee2e6; font-size: 1em; color: #333; word-wrap: break-word; min-height: 40px; display: flex; align-items: center; }
    .integration-status .badge-success { background-color: #28a745; color: white; }
    .integration-status .badge-danger { background-color: #dc3545; color: white; }
</style>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="m-0"><?= esc($title) ?></h4>
                    <p class="m-0 text-muted">Configurações das integrações</p>
                </div>
                <a href="<?= site_url('admin/integracoes/form/' . $integracao->id) ?>" class="btn btn-primary"><i class="mdi mdi-pencil"></i> Editar</a>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h5 class="mb-3">Meta Pixel</h5>
                        <div class="form-group">
                            <label class="info-label">ID do Pixel</label>
                            <div class="info-data"><?= esc($integracao->meta_pixel_id ?? 'Não configurado') ?></div>
                        </div>
                        <div class="form-group integration-status">
                            <label class="info-label">Status</label>
                            <div class="info-data">
                                <?php if ($integracao->meta_pixel_id): ?>
                                    <span class="badge badge-success p-2">Ativo</span>
                                <?php else: ?>
                                    <span class="badge badge-danger p-2">Inativo</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <h5 class="mb-3">Google Analytics</h5>
                        <div class="form-group">
                            <label class="info-label">ID de Medição</label>
                            <div class="info-data"><?= esc($integracao->google_analytics_id ?? 'Não configurado') ?></div>
                        </div>
                        <div class="form-group integration-status">
                            <label class="info-label">Status</label>
                            <div class="info-data">
                                <?php if ($integracao->google_analytics_id): ?>
                                    <span class="badge badge-success p-2">Ativo</span>
                                <?php else: ?>
                                    <span class="badge badge-danger p-2">Inativo</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-4">
                        <h5 class="mb-3">Instagram (Fotos)</h5>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="info-label">Access Token</label>
                                <div class="info-data"><?= esc(substr($integracao->instagram_access_token ?? 'Não configurado', 0, 30)) . '...' ?></div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="info-label">Business ID</label>
                                <div class="info-data"><?= esc($integracao->instagram_business_id ?? 'Não configurado') ?></div>
                            </div>
                        </div>
                        <div class="form-group integration-status">
                            <label class="info-label">Status</label>
                            <div class="info-data">
                                <?php if ($integracao->instagram_access_token && $integracao->instagram_business_id): ?>
                                    <span class="badge badge-success p-2">Ativo</span>
                                <?php else: ?>
                                    <span class="badge badge-danger p-2">Inativo</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>