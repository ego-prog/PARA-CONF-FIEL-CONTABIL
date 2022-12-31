<?PHP

/**
*
*   Framework de Relatorio - Arquivo "header"
*
*   Data de Criacao: 20/05/2002
*   Ultima Atualizacao: 20/05/2002
*   Modulo: framework_relatorio.inc
*       Framework de relatorio
*
*   Copyright (C) por APOENA Solucoes em Software Livre
*   http://www.apoenasoftwarelivre.com.br
*
*   @author     Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*   @version    PHP3 & PHP4
*/

/**
*   Estao declaradas aqui todas as classes componentes do Framework,
*  bem como arquivo de constantes utilizadas.
*   
*   IMPORTANTE: Para usar o framework, e necessario incluir este arquivo no modulo
*/

// Definicao de Constantes
@define( "CRLF",chr(13) . chr(10) );  // Fim de Linha
@define( "FF"  ,chr(12) );            // Salto de Pagina

// PATH de classes
$pathClassesRelatorio = $pathClasses."relatorio/";

// Superclasse com as principais definicoes de Relatorios e Graficos
include_once $pathClassesRelatorio."AbstractFormat.php";

// Constantes para Relatorios
include_once $pathClassesRelatorio."RelatorioConst.php";

// Relatorio formato HTML
include_once $pathClassesRelatorio."RelatorioHTML.php";

// Relatorio formato TXT
include_once $pathClassesRelatorio."RelatorioTXT.php";

// Relatorio formato PS
include_once $pathClassesRelatorio."RelatorioPS.php";

// Relatorio formato PDF
include_once $pathClassesRelatorio."RelatorioPDF.php";

// Relatorio formato de frafico
include_once $pathClassesRelatorio."Grafico.php";

// Componente FPDF
include_once $pathClassesRelatorio."fpdf.php";

// Facade de acesso ao PDF
include_once $pathClassesRelatorio."PDF.php";

?>
