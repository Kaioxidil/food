<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Login do Entregador' ?></title>
    <link rel="shortcut icon" href="<?php echo site_url('web/') ?>assets/favicon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #FF7F00; /* Laranja vibrante - cor principal de comida/delivery */
            --secondary-color: #4CAF50; /* Verde - para botões de sucesso */
            --background-color: #FFF3E0; /* Fundo creme/amarelado claro */
            --text-color: #333;
            --light-text-color: #666;
            --border-color: #FFB300; /* Laranja mais claro para bordas */
            --error-bg: #FFEBEE; /* Rosa claro para erros */
            --error-text: #D32F2F; /* Vermelho escuro para erros */
            --info-bg: #E3F2FD; /* Azul claro para informações */
            --info-text: #1976D2; /* Azul escuro para informações */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: var(--text-color);
            overflow: hidden; /* Evita scroll indesejado para a mensagem de desktop */
        }

        .desktop-message {
            display: none; /* Escondido por padrão, mostrado por JS em desktop */
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
            max-width: 500px;
            margin: 20px;
            position: fixed; /* Fixa a mensagem na tela */
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            border: 2px solid var(--primary-color);
        }
        .desktop-message h2 {
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        .desktop-message p {
            font-size: 1.1em;
            line-height: 1.5;
            color: var(--light-text-color);
        }


        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            width: 90%; /* Mais flexível para mobile */
            max-width: 380px; /* Limite para não ficar muito largo em telas maiores */
            text-align: center;
            border-top: 5px solid var(--primary-color);
            box-sizing: border-box; /* Garante que padding e border sejam incluídos na largura */
        }
        @media (min-width: 768px) {
            .login-container {
                display: none; /* Esconde o formulário em telas maiores */
            }
            .desktop-message {
                display: block; /* Mostra a mensagem de desktop */
            }
        }

        .login-container h2 {
            margin-bottom: 25px;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.8em;
        }
        .form-group {
            margin-bottom: 20px; /* Mais espaço entre os grupos */
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--light-text-color);
            font-weight: 600;
            font-size: 0.9em;
        }
        .form-group input {
            width: calc(100% - 24px); /* Ajuste para padding */
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px; /* Cantos mais arredondados */
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-group input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 127, 0, 0.2); /* Sombra de foco com a cor primária */
        }
        .btn-login {
            width: 100%;
            padding: 14px; /* Mais preenchimento */
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1em; /* Fonte um pouco maior */
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 10px rgba(255, 127, 0, 0.3);
        }
        .btn-login:hover {
            background-color: #E66A00; /* Laranja um pouco mais escuro no hover */
            transform: translateY(-2px); /* Pequeno efeito de elevação */
        }
        .message {
            margin-top: 15px;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            text-align: center;
            border: 1px solid; /* Borda para mensagens */
        }
        .message.error {
            background-color: var(--error-bg);
            color: var(--error-text);
            border-color: var(--error-text);
        }
        .message.success {
            background-color: #E8F5E9; /* Verde bem claro */
            color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        .message.info {
            background-color: var(--info-bg);
            color: var(--info-text);
            border-color: var(--info-text);
        }
        .list-errors {
            list-style-type: none;
            padding: 0;
            margin: 10px 0 0 0;
            color: var(--error-text);
            font-size: 14px;
            text-align: left;
        }
        .list-errors li {
            margin-bottom: 5px;
        }
        
        /* Ícone de comida (opcional - você pode adicionar uma imagem real) */
        .food-icon {
            font-size: 3em;
            color: var(--primary-color);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="desktop-message">
        <h2>Acesso Apenas Pelo Celular</h2>
        <p>Este aplicativo é otimizado para entregadores e foi projetado para ser usado em dispositivos móveis.</p>
        <p>Por favor, acesse-o através do seu smartphone para ter a melhor experiência.</p>
    </div>

    <div class="login-container">
        <div class="food-icon">🍔</div> <h2><?= $titulo ?? 'Acesso do Entregador' ?></h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="message error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('info')): ?>
            <div class="message info">
                <?= session()->getFlashdata('info') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="message success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (isset($errors)): ?>
            <ul class="list-errors">
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?= form_open('entregador/autenticar') ?>

            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome" value="<?= old('nome') ?>" required autofocus>
            </div>

            <div class="form-group">
                <label for="cpf">CPF (000.000.000-00)</label>
                <input type="text" id="cpf" name="cpf" value="<?= old('cpf') ?>" required placeholder="000.000.000-00">
            </div>

            <button type="submit" class="btn-login">Entrar</button>

        <?= form_close() ?>
    </div>

    <script>
        // Máscara para CPF
        document.addEventListener('DOMContentLoaded', function() {
            const cpfInput = document.getElementById('cpf');
            if (cpfInput) {
                cpfInput.addEventListener('input', function (e) {
                    let value = e.target.value;
                    value = value.replace(/\D/g, ''); // Remove tudo que não for dígito
                    if (value.length > 0) {
                        value = value.replace(/(\d{3})(\d)/, '$1.$2');
                        value = value.replace(/(\d{3})(\d)/, '$1.$2');
                        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                    }
                    e.target.value = value;
                });
            }

            // Lógica para esconder/mostrar em desktop
            const loginContainer = document.querySelector('.login-container');
            const desktopMessage = document.querySelector('.desktop-message');
            const mobileBreakpoint = 768; // Defina o ponto de quebra para mobile (em pixels)

            function checkDeviceSize() {
                if (window.innerWidth >= mobileBreakpoint) {
                    loginContainer.style.display = 'none';
                    desktopMessage.style.display = 'block';
                } else {
                    loginContainer.style.display = 'block';
                    desktopMessage.style.display = 'none';
                }
            }

            // Executa a função na carga da página
            checkDeviceSize();

            // Adiciona um listener para quando a janela for redimensionada
            window.addEventListener('resize', checkDeviceSize);
        });
    </script>
</body>
</html>