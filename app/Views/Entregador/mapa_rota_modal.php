<?php
    /**
     * Boa prática: Guarde a sua chave de API no ficheiro .env na raiz do seu projeto.
     * Exemplo no .env: google.maps.apiKey = "AIzaSy..."
     * A função getenv() busca a chave de lá de forma segura.
     */
    $googleApiKey = getenv('google.maps.apiKey');

    // Monta o endereço de destino completo para ser usado nas URLs
    $destino = "{$pedido->logradouro}, {$pedido->numero}, {$pedido->bairro_nome}, {$pedido->cidade}, {$pedido->estado}, Brasil";
    
    /**
     * URL para o mapa embutido (iframe) usando a API de Incorporação de Mapas.
     * Usamos o modo 'directions' para mostrar a rota até o destino.
     * O Google Maps tentará usar a localização atual do dispositivo como origem.
     */
    $embedUrl = "https://www.google.com/maps/embed/v1/directions?key={$googleApiKey}&destination=" . urlencode($destino) . "&mode=driving";
    
    /**
     * URL para o botão "Abrir no App".
     * Usa o esquema de URL universal do Google Maps que abre o aplicativo nativo (se instalado)
     * ou o site do Google Maps, já com o destino preenchido.
     */
    $fullScreenUrl = "https://www.google.com/maps/dir/?api=1&destination=" . urlencode($destino) . "&travelmode=driving";
?>

<div class="modal-header">
    <h2>Rota do Pedido #<?= esc($pedido->id) ?></h2>
</div>
<div class="modal-body">
    <p><strong>Endereço de Entrega:</strong> <?= esc($destino) ?></p>
    <hr>
    
    <div style="width: 100%; height: 50vh; border-radius: 8px; overflow: hidden; background: #eee;">
        <?php if ($googleApiKey && $googleApiKey !== 'SUA_CHAVE_DO_Maps_AQUI'): ?>
            <iframe 
                width="100%" 
                height="100%" 
                frameborder="0" 
                style="border:0" 
                src="<?= esc($embedUrl, 'attr') ?>" 
                allowfullscreen>
            </iframe>
        <?php else: ?>
            <div style="text-align: center; padding-top: 50px;">
                <p style="color: red;">Chave da API do Google Maps não configurada no ficheiro .env.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="modal-footer" style="text-align: right; padding: 20px 30px; border-top: 1px solid var(--modal-hr-color);">
    <a href="<?= esc($fullScreenUrl, 'attr') ?>" target="_blank" class="btn-acao btn-mapa-rota">
        Abrir no App <i class="fas fa-external-link-alt"></i>
    </a>
</div>