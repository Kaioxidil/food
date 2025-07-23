<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('titulo') ?>
    <?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('estilos') ?>
<style>
    /* Estilos gerais */
    .info-label { font-weight: bold; color: #555; margin-bottom: 3px; font-size: 0.9em; }
    .info-data { background-color: #f8f9fa; padding: 10px; border-radius: 4px; border: 1px solid #dee2e6; font-size: 1em; color: #333; word-wrap: break-word; min-height: 40px; display: flex; align-items: center; }
    
    /* Imagens */
    .profile-image-circle { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    .banner-image { width: 100%; height: 250px; object-fit: cover; border-radius: 8px; }

    /* Abas de navegação */
    .nav-tabs .nav-link { border-width: 0 0 2px 0; font-weight: 500; }
    .nav-tabs .nav-link.active { border-color: #007bff; color: #007bff; }
    .tab-content { padding-top: 20px; }

    /* Estilo para os horários */
    .list-group-item.current-day { background-color: #e7f3ff; border-left: 4px solid #007bff; font-weight: bold; }
    .list-group-item.current-day .badge { background-color: #007bff; color: white; }

    /* Botões de redes sociais */
    .social-btn { margin-right: 10px; font-size: 1.2rem; }
    .social-btn.facebook { color: #3b5998; }
    .social-btn.instagram { color: #e1306c; }

</style>
<?= $this->endSection() ?>


<?= $this->section('conteudo') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="m-0"><?= esc($empresa->nome) ?></h4>
                    <p class="m-0 text-muted">Detalhes da Empresa</p>
                </div>
                <a href="<?= site_url('admin/empresa/form/' . $empresa->id) ?>" class="btn btn-primary"><i class="mdi mdi-pencil"></i> Editar</a>
            </div>

            <div class="card-body">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="principal-tab" data-toggle="tab" href="#principal" role="tab" aria-controls="principal" aria-selected="true"><i class="mdi mdi-store"></i> Principal</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="endereco-tab" data-toggle="tab" href="#endereco" role="tab" aria-controls="endereco" aria-selected="false"><i class="mdi mdi-map-marker"></i> Endereço e Mapa</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="horarios-tab" data-toggle="tab" href="#horarios" role="tab" aria-controls="horarios" aria-selected="false"><i class="mdi mdi-clock-outline"></i> Horários</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    
                    <div class="tab-pane fade show active" id="principal" role="tabpanel" aria-labelledby="principal-tab">
                        <div class="row">
                            <div class="col-md-4 d-flex flex-column align-items-center justify-content-center text-center">
                                <img src="<?= $empresa->foto_perfil ? site_url('uploads/' . $empresa->foto_perfil) : site_url('web/assets/seudelivery.png') ?>" alt="Foto de Perfil" class="profile-image-circle mb-3">
                                <a href="<?= site_url('admin/empresa/fotos/' . $empresa->id) ?>" class="btn btn-outline-secondary btn-sm"><i class="mdi mdi-image-multiple"></i> Gerenciar Fotos</a>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="info-label">Descrição</label>
                                    <p class="text-muted"><?= esc($empresa->descricao ?? 'Nenhuma descrição informada.') ?></p>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group"><label class="info-label">Faixa de Preço</label><div class="info-data font-weight-bold"><?= esc($empresa->faixa_preco ?? 'N/A') ?></div></div>
                                    <div class="col-md-6 form-group"><label class="info-label">Status</label><div class="info-data"><?= $empresa->ativo ? '<span class="badge badge-success">Ativa</span>' : '<span class="badge badge-danger">Inativa</span>' ?></div></div>
                                    <div class="col-md-6 form-group"><label class="info-label">E-mail</label><div class="info-data"><i class="mdi mdi-email-outline mr-2"></i><?= esc($empresa->email ?? 'N/A') ?></div></div>
                                    <div class="col-md-6 form-group"><label class="info-label">Telefone Fixo</label><div class="info-data"><i class="mdi mdi-phone mr-2"></i><?= esc($empresa->telefone ?? 'N/A') ?></div></div>
                                    <div class="col-md-6 form-group"><label class="info-label">Celular / WhatsApp</label><div class="info-data"><i class="mdi mdi-whatsapp mr-2"></i><?= esc($empresa->celular ?? 'N/A') ?></div></div>
                                    <div class="col-md-6 form-group">
                                        <label class="info-label">Redes Sociais</label>
                                        <div class="info-data">
                                            <a href="<?= esc($empresa->link_facebook) ?>" target="_blank" class="social-btn facebook"><i class="mdi mdi-facebook"></i></a>
                                            <a href="<?= esc($empresa->link_instagram) ?>" target="_blank" class="social-btn instagram"><i class="mdi mdi-instagram"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="endereco" role="tabpanel" aria-labelledby="endereco-tab">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-8 form-group"><label class="info-label">Logradouro</label><div class="info-data"><?= esc($empresa->logradouro ?? 'N/A') ?></div></div>
                                    <div class="col-md-4 form-group"><label class="info-label">Número</label><div class="info-data"><?= esc($empresa->numero ?? 'N/A') ?></div></div>
                                    <div class="col-md-6 form-group"><label class="info-label">Bairro</label><div class="info-data"><?= esc($empresa->bairro ?? 'N/A') ?></div></div>
                                    <div class="col-md-6 form-group"><label class="info-label">Cidade</label><div class="info-data"><?= esc($empresa->cidade ?? 'N/A') ?></div></div>
                                    <div class="col-md-4 form-group"><label class="info-label">CEP</label><div class="info-data"><?= esc($empresa->cep ?? 'N/A') ?></div></div>
                                    <div class="col-md-2 form-group"><label class="info-label">UF</label><div class="info-data"><?= esc($empresa->estado ?? 'N/A') ?></div></div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label class="info-label">Localização no Mapa</label>
                                <?php if($empresa->maps_iframe): ?>
                                    <div class="embed-responsive embed-responsive-16by9"><?= $empresa->maps_iframe ?></div>
                                <?php else: ?>
                                    <div class="info-data" style="height: 100%;">Nenhum mapa cadastrado.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="horarios" role="tabpanel" aria-labelledby="horarios-tab">
                        <p class="text-muted">Horários de funcionamento para entregas e atendimento.</p>
                        <?php 
                            $dia_atual = strtolower(date('l')); // Pega o dia da semana atual em inglês (ex: 'tuesday')
                        ?>
                        <?php if (!empty($empresa->horarios_array)): ?>
                            <ul class="list-group list-group-flush">
                                <?php $dias_semana = ['monday' => 'Segunda-feira', 'tuesday' => 'Terça-feira', 'wednesday' => 'Quarta-feira', 'thursday' => 'Quinta-feira', 'friday' => 'Sexta-feira', 'saturday' => 'Sábado', 'sunday' => 'Domingo']; ?>
                                <?php foreach($dias_semana as $key => $dia): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center <?= ($key === $dia_atual) ? 'current-day' : '' ?>">
                                        <?= $dia ?>
                                        <span class="badge badge-info badge-pill p-2"><?= esc($empresa->horarios_array[$key] ?? 'Não informado') ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <div class="alert alert-warning">Horários de funcionamento não cadastrados.</div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>