<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title><?= esc($titulo) ?> - SeuDelivery</title>
    <style>
        body {
            font-family: monospace;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }

  

        h2, .subtitulo {
            text-align: center;
            margin: 0;
        }

        h2 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .subtitulo {
            font-size: 11px;
            margin-bottom: 8px;
        }

        .empresa-info {
            text-align: center;
            font-size: 10px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        th, td {
            padding: 6px 4px;
            text-align: left;
            font-size: 11px;
        }

        th {
            border-bottom: 1px dashed #000;
        }

        tr td {
            border-bottom: 1px dashed #ccc;
        }

        .linha {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 12px;
        }
    </style>
</head>
<body>

<div class="container">

    <h2><?= esc($titulo) ?></h2>
    <div class="subtitulo">
        Data/Hora: <?= date('d/m/Y H:i') ?>
    </div>

    <div class="empresa-info">
        <strong>SeuDelivery</strong><br>
        Rua das Pizzas, 123 - Centro<br>
        CNPJ: 12.345.678/0001-90<br>
        Tel: (11) 98765-4321
    </div>

    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Cat.</th>
                <th>Criação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?= esc($produto->nome) ?></td>
                    <td><?= esc($produto->categoria) ?></td>
                    <td><?= date('d/m', strtotime($produto->criado_em)) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="linha"></div>

    <div class="footer">
        Cupom gerado - <strong>SeuDelivery</strong><br>
        www.seudeliverybr.com.br
    </div>

</div>

</body>
</html>
