<?php
libxml_use_internal_errors(true);
require_once 'vendor/autoload.php';

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

// Função para buscar e estruturar os dados
function buscarDados() {
    $conteudo = file_get_contents('C:\xampp\htdocs\exercicios-2024\php\assets\origin.html');
    $documento = new DOMDocument();
    $documento->loadHTML($conteudo);

    $xpath = new DOMXPath($documento);

    // Filtrando os elementos <a> que contêm os dados
    $elementosANodeList = $xpath->query('.//div[@class="col-sm-12 col-md-8 col-lg-8 col-md-pull-4 col-lg-pull-4"]/a');

    $resultados = [];

    foreach ($elementosANodeList as $elementoANode) {
        // Inicializa um array para armazenar os dados de cada conjunto
        $conjunto = [];

        // Filtra e armazena o ID
        $volumeNodeList = $xpath->query('.//div[@class="volume-info"]', $elementoANode);
        if ($volumeNodeList->length > 0) {
            $id = $volumeNodeList->item(0)->textContent;
            $conjunto['ID'] = $id;
        }

        // Filtra e armazena o Type
        $tagsNodeList = $xpath->query('.//div[@class="tags mr-sm"]', $elementoANode);
        if ($tagsNodeList->length > 0) {
            $type = $tagsNodeList->item(0)->textContent;
            $conjunto['Type'] = $type;
        }

        // Filtra e armazena o Title
        $tituloNode = $xpath->query('.//h4[@class="my-xs paper-title"]', $elementoANode);
        if ($tituloNode->length > 0) {
            $title = $tituloNode->item(0)->textContent;
            $conjunto['Title'] = $title;
        }

        // Filtra e armazena os autores
        $autoresNodeList = $xpath->query('.//div[@class="authors"]/span', $elementoANode);
        $autores = [];
        if ($autoresNodeList->length > 0) {
            $i = 1;
            foreach ($autoresNodeList as $autorNode) {
                $autor = $autorNode->textContent;
                $institution = $autorNode->getAttribute('title');
                $autores["Author $i"] = $autor;
                $autores["Author $i Institution"] = $institution;
                $i++;
            }
        }
        $conjunto['Authors'] = $autores;

        // Adiciona o conjunto de dados à matriz de resultados
        $resultados[] = $conjunto;
    }

    return $resultados;
}

// Função para criar o arquivo .xlsx
function criarArquivoExcel($resultados) {
    // Criação de um novo escritor de arquivo XLSX
    $writer = WriterEntityFactory::createXLSXWriter();

    // Define o caminho completo para o arquivo na pasta "assets"
    $filePath = 'C:\xampp\htdocs\exercicios-2024\php\src\WebScrapping\output.xlsx';

    // Abre o arquivo para escrita
    $writer->openToFile($filePath);

    // Cria o cabeçalho da planilha
    $headerRow = WriterEntityFactory::createRowFromArray(['ID', 'Type', 'Title', 'Authors 1', 'Author 1 Institution', 'Authors 2', 'Author 2 Institution', 'Authors 3', 'Author 3 Institution', 'Authors 4', 'Author 4 Institution', 'Authors 5', 'Author 5 Institution', 'Authors 6', 'Author 6 Institution', 'Authors 7', 'Author 7 Institution', 'Authors 8', 'Author 8 Institution', 'Authors 9', 'Author 9 Institution', 'Authors 10', 'Author 10 Institution']);
    $writer->addRow($headerRow);

    // Adiciona os dados dos resultados à planilha
    foreach ($resultados as $resultado) {
        $rowData = [
            $resultado['ID'],
            $resultado['Type'],
            $resultado['Title'],
        ];

        // Adiciona os autores e suas instituições
        for ($i = 1; $i <= 10; $i++) {
            $authorKey = "Author $i";
            $institutionKey = "Author $i Institution";
            $rowData[] = isset($resultado['Authors'][$authorKey]) ? $resultado['Authors'][$authorKey] : '';
            $rowData[] = isset($resultado['Authors'][$institutionKey]) ? $resultado['Authors'][$institutionKey] : '';
        }

        $row = WriterEntityFactory::createRowFromArray($rowData);
        $writer->addRow($row);
    }

    // Fecha o escritor
    $writer->close();
}

// Busca e estrutura os dados
$resultados = buscarDados();

// Cria o arquivo Excel
criarArquivoExcel($resultados);

?>
