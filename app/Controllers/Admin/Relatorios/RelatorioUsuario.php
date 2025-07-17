<?php

namespace App\Controllers\Admin\Relatorios;

use CodeIgniter\Controller;
use App\Models\UsuarioModel;

class RelatorioUsuario extends Controller
{
    public function gerarPdf()
    {
        $usuarioModel = new UsuarioModel();
        $usuarios = $usuarioModel->where('id !=', 1)->findAll();

        require_once APPPATH . 'Libraries/MyPdf.php';
        $pdf = new \App\Libraries\MyPdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Metadados do documento
        $pdf->SetCreator('SeuDelivery');
        $pdf->SetAuthor('Kaio');
        $pdf->SetTitle('Relatório de Usuários');

        // AJUSTE: Margens para acomodar o novo cabeçalho e rodapé.
        $pdf->SetMargins(10, 36, 10);
        $pdf->AddPage();

        // --- CSS da tabela (sem alterações) ---
        $html = '
        <style>
            body {
                font-family: helvetica, sans-serif;
                font-size: 10pt;
                color: #333;
            }
            table {
                border-collapse: collapse;
                width: 100%;
                margin-top: 10px;
            }
            th {
                background-color: #E0E0E0; /* Cinza claro para o cabeçalho */
                color: #333;
                font-weight: bold;
                text-align: left;
                border: 1px solid #BDBDBD;
            }
            td {
                border: 1px solid #E0E0E0; /* Bordas mais suaves */
                vertical-align: middle; /* Alinha o conteúdo no meio da célula */
            }
            td, th {
                padding: 10px; /* Mais espaçamento interno para respirar */
            }
            /* Efeito "zebra" para facilitar a leitura */
            tr:nth-child(even) {
                background-color: #f9f9f9;
            }
            .status-ativo {
                color: #2E7D32; /* Verde mais escuro */
                font-weight: bold;
            }
            .status-inativo {
                color: #C62828; /* Vermelho mais escuro */
                font-weight: bold;
            }
            /* Estilo para a mensagem de "Nenhum usuário" */
            .no-users-message {
                text-align: center;
                font-style: italic;
                color: #757575;
            }
        </style>
        ';

        // --- Estrutura da tabela HTML ---
        $html .= '
            <table>
                <thead>
                    <tr>
                        <th width="30%">Nome</th>
                        <th width="25%">Email</th>
                        <th width="15%">CPF</th>      <th width="15%">Telefone</th> <th width="15%" align="center">Status</th>
                    </tr>
                </thead>
                <tbody>';

        if (empty($usuarios)) {
            // AJUSTE: O colspan agora é 5 para abranger todas as colunas.
            $html .= '<tr><td colspan="5" class="no-users-message">Nenhum usuário encontrado.</td></tr>';
        } else {
            foreach ($usuarios as $usuario) {
                $statusTexto = $usuario->ativo ? 'Ativo' : 'Inativo';
                $statusClass = $usuario->ativo ? 'status-ativo' : 'status-inativo';

                $html .= '
                    <tr>
                        <td>' . esc($usuario->nome) . '</td>
                        <td>' . esc($usuario->email) . '</td>
                        <td>' . esc($usuario->cpf) . '</td>      <td>' . esc($usuario->telefone) . '</td>  <td align="center" class="' . $statusClass . '">' . $statusTexto . '</td>
                    </tr>';
            }
        }

        $html .= '
                </tbody>
            </table>';

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdfContent = $pdf->Output('', 'S');

        return service('response')
            ->setStatusCode(200)
            ->setContentType('application/pdf')
            ->setHeader('Content-Disposition', 'inline; filename="relatorio_usuarios.pdf"')
            ->setBody($pdfContent);
    }
}