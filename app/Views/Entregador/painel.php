<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title><?= $titulo ?? 'Painel do Entregador' ?></title>
    
    <link rel="shortcut icon" href="<?php echo site_url('web/') ?>assets/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Cores inspiradas no iFood */
        :root {
            --bg-color: #f0f0f0; /* Cinza claro de fundo */
            --container-bg: #ffffff; /* Branco para contêineres */
            --text-color: #333333; /* Texto principal escuro */
            --header-color: #ea1d2c; /* Vermelho principal do iFood */
            --secondary-header-color: #d84315; /* Laranja/Vermelho mais escuro para destaque */
            --border-color: #eeeeee; /* Borda clara */
            --table-header-bg: #ea1d2c; /* Vermelho iFood para cabeçalhos de tabela */
            --table-header-text: #fff; /* Texto branco */
            --button-primary-bg: #1e88e5; /* Azul para botões primários (alternativo) */
            --button-secondary-bg: #ffc107; /* Amarelo/Laranja para botões secundários */
            --modal-bg: #fefefe; /* Fundo do modal */
            --modal-shadow: rgba(0,0,0,0.3); /* Sombra do modal */
            --modal-close-color: #aaa; /* Cor do botão fechar modal */
            --modal-hr-color: #e0e0e0; /* Linha divisória no modal */
            --bottom-nav-bg: #ffffff; /* Fundo da navegação inferior */
            --bottom-nav-icon: #757575; /* Ícones da navegação inferior */
            --bottom-nav-icon-active: #ea1d2c; /* Vermelho iFood para ícone ativo */
        }
        body.dark-mode {
            --bg-color: #363636; /* Cinza escuro de fundo */
            --container-bg: #424242; /* Cinza mais claro para contêineres */
            --text-color: #e0e0e0; /* Texto claro */
            --header-color: #ff5252; /* Vermelho mais vibrante para dark mode */
            --secondary-header-color: #ff9800; /* Laranja para destaque em dark mode */
            --border-color: #616161; /* Borda escura */
            --table-header-bg: #ff5252; /* Vermelho vibrante para cabeçalhos de tabela em dark mode */
            --table-header-text: #fff; /* Texto branco */
            --button-primary-bg: #2196f3; /* Azul para botões primários em dark mode */
            --button-secondary-bg: #ffb300; /* Amarelo/Laranja para botões secundários em dark mode */
            --modal-bg: #424242; /* Fundo do modal dark mode */
            --modal-shadow: rgba(0,0,0,0.7); /* Sombra do modal dark mode */
            --modal-close-color: #e0e0e0; /* Cor do botão fechar modal dark mode */
            --modal-hr-color: #616161; /* Linha divisória no modal dark mode */
            --bottom-nav-bg: #212121; /* Fundo da navegação inferior dark mode */
            --bottom-nav-icon: #bdbdbd; /* Ícones da navegação inferior dark mode */
            --bottom-nav-icon-active: #ff5252; /* Vermelho vibrante para ícone ativo dark mode */
        }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: var(--bg-color); margin: 0; color: var(--text-color); }
        .main-content { padding: 20px 15px 80px 15px; /* Padding inferior para não sobrepor a nav */ }
        .header { margin-bottom: 20px; }
        h1 { color: var(--header-color); margin: 0; font-size: 1.5em; }
        h2 { color: var(--secondary-header-color); font-size: 1.2em; border-bottom: 2px solid var(--secondary-header-color); padding-bottom: 5px; margin-top: 25px; }
        hr { border: 0; height: 1px; background: var(--border-color); margin: 20px 0; }
        
        /* Tabela de Pedidos - Estilo App */
        .pedidos-container { width: 100%; }
        .pedidos-table { width: 100%; border-collapse: collapse; }
        .pedidos-table tr { display: flex; flex-direction: column; margin-bottom: 15px; background-color: var(--container-bg); border: 1px solid var(--border-color); border-radius: 8px; padding: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .pedidos-table td { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border: none; text-align: right; }
        .pedidos-table td::before { content: attr(data-label); font-weight: bold; color: var(--secondary-header-color); text-align: left; }
        .pedidos-table td[data-label="Ações"] { flex-direction: column; align-items: stretch; gap: 8px; margin-top: 10px; }
        .pedidos-table td[data-label="Ações"]::before { display: none; } /* Esconde o label de Ações */
        
        /* Estilos dos botões com cores do iFood */
        .btn-acao { 
            background-color: var(--button-primary-bg); /* Azul ou outra cor para o detalhes */
            color: white; 
            border: none; 
            padding: 12px; 
            border-radius: 5px; 
            cursor: pointer; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 8px; 
            text-decoration: none; 
            font-size: 1em; 
            transition: background-color 0.3s ease;
        }
        .btn-acao:hover {
            opacity: 0.9;
        }
        .btn-mapa-rota { 
            background-color: var(--button-secondary-bg); 
            color: var(--text-color); /* Texto escuro */
        }
        /* Cores específicas para os botões de status */
        .btn-mudar-status[data-novo-status="saiu_para_entrega"] {
            background-color: #ffc107; /* Amarelo/Laranja */
            color: #333;
        }
        .btn-mudar-status[data-novo-status="entregue"] {
            background-color: #28a745; /* Verde */
        }

        .no-orders-message { text-align: center; padding: 40px 20px; background-color: var(--container-bg); border-radius: 8px; font-style: italic; }
        
        /* Navegação Inferior */
        .bottom-nav { 
            display: flex; 
            justify-content: space-around; 
            align-items: center; 
            position: fixed; 
            bottom: 0; 
            left: 0; 
            width: 100%; 
            height: 60px; 
            background-color: var(--bottom-nav-bg); 
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1); 
            z-index: 1000; 
            padding-bottom: env(safe-area-inset-bottom); /* Para iPhones com notch */
        }
        .bottom-nav a { display: flex; flex-direction: column; align-items: center; text-decoration: none; color: var(--bottom-nav-icon); padding: 5px 0; flex-grow: 1; transition: color 0.2s ease; }
        .bottom-nav a.active { color: var(--bottom-nav-icon-active); }
        .bottom-nav a i { font-size: 1.5em; }
        .bottom-nav a span { font-size: 0.7em; margin-top: 2px; }

        /* Modal */
        .modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.6); justify-content: center; align-items: center; padding: 10px; box-sizing: border-box; }
        .modal-content { 
            background-color: var(--modal-bg); 
            margin: auto; 
            border-radius: 10px; 
            width: 100%; 
            max-width: 600px; 
            max-height: 95vh; 
            overflow-y: auto; 
            position: relative; 
            box-shadow: 0 4px 15px var(--modal-shadow);
        }
        .close-button { color: var(--modal-close-color); position: absolute; top: 10px; right: 15px; font-size: 28px; font-weight: bold; cursor: pointer; z-index: 10; }

        /* Estilo para o botão de atualização */
        .refresh-button-container {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .btn-refresh {
            background-color: #ea1d2c; /* Vermelho iFood */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s ease;
        }
        .btn-refresh:hover {
            background-color: #d84315; /* Tom mais escuro do vermelho iFood */
        }
    </style>
</head>
<body class="">

    <div class="main-content" id="mainContent">
        <div class="header">
            <h1>Olá, <strong><?= esc($entregador_nome ?? 'Entregador') ?></strong>!</h1>
            <p>Seus pedidos para hoje.</p>
        </div>
        
        <div class="pedidos-section">
            <h2>Próximas Entregas</h2>
            <div class="refresh-button-container">
                <button id="refreshPedidosBtn" class="btn-refresh">
                    <i class="fas fa-sync-alt"></i> Atualizar Pedidos
                </button>
            </div>
            <div id="pedidos-container">
                </div>
        </div>
    </div>

    <nav class="bottom-nav">
        <a href="#" class="active"><i class="fas fa-motorcycle"></i><span>Pedidos</span></a>
        <a href="#" id="open-general-map"><i class="fas fa-map-marked-alt"></i><span>Mapa</span></a>
        <a href="#" id="theme-toggle"><i class="fas fa-adjust"></i><span>Tema</span></a> <a href="<?= site_url('entregador/logout') ?>"><i class="fas fa-sign-out-alt"></i><span>Sair</span></a>
    </nav>

    <div id="detalhesModal" class="modal">
        <div class="modal-content">
            <span class="close-button">×</span>
            <div id="detalhesModalBody"></div>
        </div>
    </div>
    <div id="mapaModal" class="modal">
        <div class="modal-content">
            <span class="close-button">×</span>
            <div id="mapaModalBody"></div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- ELEMENTOS ---
        const detalhesModal = document.getElementById('detalhesModal');
        const mapaModal = document.getElementById('mapaModal');
        const pedidosContainer = document.getElementById('pedidos-container');
        const refreshPedidosBtn = document.getElementById('refreshPedidosBtn');
        const themeToggleBtn = document.getElementById('theme-toggle');

        // --- LÓGICA DOS MODAIS ---
        function openModal(modal) { modal.style.display = 'flex'; }
        function closeModal(modal) { modal.style.display = 'none'; }
        document.querySelectorAll('.modal .close-button').forEach(btn => {
            btn.addEventListener('click', e => closeModal(e.target.closest('.modal')));
        });
        window.addEventListener('click', e => {
            if (e.target.classList.contains('modal')) closeModal(e.target);
        });

        // --- FUNÇÃO PARA ADICIONAR EVENTOS AOS BOTÕES ---
        function rebindButtons() {
            document.querySelectorAll('.btn-detalhes').forEach(button => {
                button.removeEventListener('click', handleDetalhesClick);
                button.addEventListener('click', handleDetalhesClick);
            });

            document.querySelectorAll('.btn-mapa-rota').forEach(button => {
                button.removeEventListener('click', handleMapaRotaClick);
                button.addEventListener('click', handleMapaRotaClick);
            });

            document.querySelectorAll('.btn-mudar-status').forEach(button => {
                button.removeEventListener('click', handleChangeStatusClick);
                button.addEventListener('click', handleChangeStatusClick);
            });
        }

        // Handlers para os botões de detalhes e mapa (mantidos com Fetch para carregar conteúdo do modal)
        function handleDetalhesClick() {
            const pedidoId = this.dataset.pedidoId;
            const modalBody = document.getElementById('detalhesModalBody');
            modalBody.innerHTML = '<div class="modal-body">Carregando detalhes...</div>';
            openModal(detalhesModal);
            fetch(`<?= site_url('entregador/detalhesPedidoModal/') ?>${pedidoId}`, {
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
            .then(res => {
                if (!res.ok) {
                    return res.json()
                              .then(errorData => {
                                  const errorMessage = errorData && errorData.messages && errorData.messages.error 
                                                       ? errorData.messages.error 
                                                       : 'Erro desconhecido ao carregar detalhes.';
                                  return Promise.reject(errorMessage);
                              })
                              .catch(() => {
                                  return Promise.reject('Erro na rede ou resposta inválida do servidor.');
                              });
                }
                return res.text();
            })
            .then(html => {
                modalBody.innerHTML = html;
                rebindButtons(); 
            })
            .catch(err => {
                console.error('Erro ao carregar detalhes do pedido:', err);
                modalBody.innerHTML = `<div class='modal-body'><p style='color:red;'>Erro: ${err}</p></div>`;
            });
        }

        function handleMapaRotaClick() {
            const pedidoId = this.dataset.pedidoId;
            const modalBody = document.getElementById('mapaModalBody');
            modalBody.innerHTML = '<div class="modal-body">Carregando mapa...</div>';
            openModal(mapaModal);
            fetch(`<?= site_url('entregador/mapaRotaModal/') ?>${pedidoId}`, {
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
            .then(res => {
                if (!res.ok) {
                    return res.json()
                              .then(errorData => {
                                  const errorMessage = errorData && errorData.messages && errorData.messages.error 
                                                       ? errorData.messages.error 
                                                       : 'Erro desconhecido ao carregar o mapa.';
                                  return Promise.reject(errorMessage);
                              })
                              .catch(() => {
                                  return Promise.reject('Erro na rede ou resposta inválida do servidor ao carregar o mapa.');
                              });
                }
                return res.text();
            })
            .then(html => modalBody.innerHTML = html)
            .catch(err => {
                console.error('Erro ao carregar mapa do pedido:', err);
                modalBody.innerHTML = `<div class='modal-body'><p style='color:red;'>Erro: ${err}</p></div>`;
            });
        }
        
        function handleChangeStatusClick() {
            const pedidoId = this.dataset.pedidoId;
            const novoStatus = this.dataset.novoStatus;
            const statusMessageDiv = detalhesModal.querySelector('#status-message');
            const currentStatusSpan = detalhesModal.querySelector('#current-status');
            const statusButtons = detalhesModal.querySelectorAll('.btn-mudar-status');

            statusButtons.forEach(btn => btn.disabled = true);
            statusMessageDiv.innerHTML = '<p style="color: blue;">Atualizando status...</p>';

            fetch('<?= site_url('entregador/mudarStatusPedido') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: `pedido_id=${pedidoId}&novo_status=${novoStatus}`
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    return response.json()
                              .then(errorData => {
                                  const errorMessage = errorData && errorData.messages && errorData.messages.error 
                                                       ? errorData.messages.error 
                                                       : 'Erro desconhecido ao mudar status.';
                                  return Promise.reject(errorMessage);
                              })
                              .catch(() => {
                                  return Promise.reject('Erro na rede ou resposta inválida do servidor ao mudar status.');
                              });
                }
            })
            .then(data => {
                statusMessageDiv.innerHTML = `<p style="color: green;">${data.message}</p>`;
                if (currentStatusSpan) {
                    currentStatusSpan.textContent = novoStatus.replace(/_/g, ' ').toUpperCase(); 
                }
                
                atualizarTabelaPedidos(); 
                
                // Recarrega o conteúdo do modal de detalhes para exibir os botões de status corretos
                if (detalhesModal.style.display === 'flex') {
                    // Simula o clique no botão de detalhes do pedido que acabou de ser atualizado.
                    // Isso garante que o modal seja recarregado com o estado mais recente.
                    const targetButton = document.querySelector(`.btn-detalhes[data-pedido-id="${pedidoId}"]`);
                    if (targetButton) {
                        handleDetalhesClick.call(targetButton);
                    }
                }
            })
            .catch(error => {
                console.error('Erro ao mudar status:', error);
                statusMessageDiv.innerHTML = `<p style="color: red;">Erro: ${error}</p>`;
                statusButtons.forEach(btn => btn.disabled = false);
            });
        }

        // --- ATUALIZAÇÃO MANUAL DA TABELA ---
        function atualizarTabelaPedidos() {
            refreshPedidosBtn.disabled = true;
            refreshPedidosBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Carregando...';

            fetch('<?= site_url('entregador/atualizarPedidos') ?>', {
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json()
                              .then(errorData => {
                                  const errorMessage = errorData && errorData.messages && errorData.messages.error 
                                                       ? errorData.messages.error 
                                                       : 'Erro desconhecido ao carregar pedidos.';
                                  return Promise.reject(errorMessage);
                              })
                              .catch(() => {
                                  return Promise.reject('Erro na rede ou resposta inválida do servidor ao carregar pedidos.');
                              });
                }
                return response.text();
            })
            .then(html => {
                pedidosContainer.innerHTML = html;
                rebindButtons(); 
            })
            .catch(error => {
                console.error('Erro ao atualizar pedidos:', error);
                pedidosContainer.innerHTML = `<div class="no-orders-message"><p style='color:red;'>Erro: ${error}</p></div>`;
            })
            .finally(() => {
                refreshPedidosBtn.disabled = false;
                refreshPedidosBtn.innerHTML = '<i class="fas fa-sync-alt"></i> Atualizar Pedidos';
            });
        }

        // --- LÓGICA DO MODO CLARO/ESCURO ---
        function applyTheme(theme) {
            const themeIcon = themeToggleBtn.querySelector('i');
            const themeText = themeToggleBtn.querySelector('span');

            if (theme === 'dark') {
                document.body.classList.add('dark-mode');
                themeIcon.classList.replace('fa-adjust', 'fa-sun'); // Ícone do sol
                themeText.textContent = 'Claro';
            } else {
                document.body.classList.remove('dark-mode');
                themeIcon.classList.replace('fa-sun', 'fa-adjust'); // Ícone de ajuste (para alternar entre modos)
                themeText.textContent = 'Escuro';
            }
        }

        // Carrega a preferência de tema salva ou usa o padrão do sistema
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            applyTheme(savedTheme);
        } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            applyTheme('dark'); 
        } else {
            applyTheme('light');
        }

        // Adiciona evento de clique para alternar o tema
        themeToggleBtn.addEventListener('click', function(e) {
            e.preventDefault(); 
            if (document.body.classList.contains('dark-mode')) {
                applyTheme('light');
                localStorage.setItem('theme', 'light');
            } else {
                applyTheme('dark');
                localStorage.setItem('theme', 'dark');
            }
        });

        // --- CARREGAMENTO INICIAL E EVENTOS ---
        atualizarTabelaPedidos();
        refreshPedidosBtn.addEventListener('click', atualizarTabelaPedidos);

        document.getElementById('open-general-map').addEventListener('click', function(e) {
            e.preventDefault();
            alert('Funcionalidade do Mapa Geral a ser implementada.');
        });
    });
    </script>
</body>
</html>