<?php

namespace App\Libraries;

require_once APPPATH . 'Libraries/tcpdf/tcpdf.php';

class MyPdf extends \TCPDF
{
    /**
     * Método Header aprimorado
     */
    public function Header()
    {
        // --- MANIPULAÇÃO DO LOGO (MAIS ROBUSTA) ---
        // Verifique se o arquivo de imagem existe antes de tentar usá-lo.
        // Altere 'assets/img/logo.png' para o caminho real do seu logo.
        

        // --- TÍTULO E SUBTÍTULO ---
        // AJUSTE: Define a posição Y para o cursor, dando mais espaço no topo.
        $this->SetY(12);
        $this->SetFont('helvetica', 'B', 18); // AJUSTE: Fonte do título um pouco menor.
        $this->Cell(0, 9, 'Relatório de Usuários', 0, true, 'C', 0, '', 0, false, 'M', 'M');

        // NOVO: Adiciona um subtítulo com a data de emissão.
        $this->SetFont('helvetica', '', 10);
        // A função strftime foi descontinuada no PHP 8.1. Usando a classe DateTime.
        $data = new \DateTime('now', new \DateTimeZone('America/Sao_Paulo'));
        $this->Cell(0, 8, 'Emitido em: ' . $data->format('d/m/Y H:i:s'), 0, false, 'C', 0, '', 0, false, 'M', 'M');


        // --- LINHA DIVISÓRIA DO CABEÇALHO ---
        // AJUSTE: Posição da linha ajustada para ficar abaixo do novo subtítulo.
        $this->Line(10, 32, $this->getPageWidth() - 10, 32);
    }

    /**
     * Método Footer aprimorado
     */
    public function Footer()
    {
        // --- POSICIONAMENTO ---
        $this->SetY(-15);

        // NOVO: Linha divisória para separar o rodapé do conteúdo.
        $this->Line(10, $this->GetY() - 3, $this->getPageWidth() - 10, $this->GetY() - 3);

        // --- TEXTO DO RODAPÉ ---
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}