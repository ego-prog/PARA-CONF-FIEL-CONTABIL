<?PHP

/**
*
*   Framework de Grafico - Arquivo "header"
*
*   Data de Criacao: 19/01/2004
*   Ultima Atualizacao: 19/01/2004
*   Modulo: framework_grafico.inc
*       Framework de grafico
*
*   Copyright (C) por APOENA Solucoes em Software Livre
*   http://www.apoenasoftwarelivre.com.br
*
*   @author     Claudimir Zavalik (claudimir@apoenasoftwarelivre.com.br)
*   @version    PHP4
*/

/**
*   Estao declaradas aqui todas as classes componentes do Framework,
*  bem como arquivo de constantes utilizadas.
*   
*   IMPORTANTE: Para usar o framework, e necessario incluir este arquivo no modulo
*/

// PATH de classes
$pathClassesGrafico = $pathClasses."grafico/";

// Superclasse com as principais definicoes de Relatorios e Graficos
include_once $pathClassesGrafico."AbstractFormat.php";

// Constantes para Graficos
include_once $pathClassesRelatorio."GraficoConst.php";

// Grafico de Barras com 2 dados
include_once $pathClassesRelatorio."GraficoBarras2Y.php";

// Componente Graph
include_once $pathClassesRelatorio."jpgraph.php";

// Facade de acesso ao GRAF
include_once $pathClassesRelatorio."GRAF.php";

?>
