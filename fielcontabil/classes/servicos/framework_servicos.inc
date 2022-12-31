<?PHP

/**
*
*   Framework de Servicos - Arquivo "header"
*
*   Data de Criacao: 19/05/2002
*   Ultima Atualizacao: 19/05/2002
*   Modulo: framework_servicos.inc
*       Framework de varios servicos utilizados nas Aplicacoes
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

// PATH de classes
$pathClassesServicos = $pathClasses."/servicos/";

// Usuario
include_once $pathClassesServicos."Usuario.php";

// LOG
include_once $pathClassesServicos."Log.php";

// Mensagem
include_once $pathClassesServicos."Msg.php";

// Parametros da Aplicacao
include_once $pathClassesServicos."Parametro.php";

// Consulta
include_once $pathClassesServicos."Consulta.php";

// Cabecalho
include_once $pathClassesServicos."Cabecalho.php";

?>
