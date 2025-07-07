<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title><?= esc($titulo) ?> - SeuDelivery</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .subtitulo {
            text-align: center;
            margin-bottom: 25px;
            font-size: 12px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px 8px;
            text-align: left;
        }

        th {
            background-color: #f7f7f7;
            color: #2c3e50;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .status-ativo {
            color: green;
            font-weight: bold;
        }

        .status-inativo {
            color: red;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #999;
        }

        a{
            color: #999;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <h1><?= esc($titulo) ?></h1>
    <div class="subtitulo">
        Gerado em <?= date('d/m/Y H:i') ?> &nbsp;|&nbsp;<strong>SeuDelivery</strong>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Criado em</th>
                <th>Status</th>
                <th>Dele.</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <?php if ($usuario->id == 1) continue; ?>
                <tr>
                    <td><?= esc($usuario->nome) ?></td>
                    <td><?= esc($usuario->email) ?></td>
                    <td><?= esc($usuario->criado_em) ?></td>
                    <td>
                        <span class="<?= $usuario->ativo ? 'status-ativo' : 'status-inativo' ?>">
                            <?= $usuario->ativo ? 'Ativo' : 'Inativo' ?>
                        </span>
                    </td>
                    <td><?= $usuario->deletado_em ? 'Sim' : 'Não' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        <a href="https://seudeliverybr.com.br/" target="_blank">seudeliverybr.com.br</a>
    </div>

</body>
</html>
