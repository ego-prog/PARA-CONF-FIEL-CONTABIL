<?PHP

/**
*
*   Componentes - Arquivo "header"
*
*   Data de Criacao: 19/05/2002
*   Ultima Atualizacao: 21/05/2002
*   Modulo: componentes.inc
*	Componentes utilizados nas Aplicacoes
*
*   Copyright (C) por APOENA Solucoes em Software Livre
*   http://www.apoenasoftwarelivre.com.br
*
*   @author	Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*   @version	PHP3 & PHP4
*/

/**
*   Estao declaradas aqui todas as classes de componentes,
*  bem como arquivo de constantes utilizadas.
*   
*   IMPORTANTE: Para usar o componente, e necessario incluir este arquivo no modulo
*/

// PATH de classes
if ( empty( $pathClasses ) )
	@$pathClassesComponente = "/home/httpd/html/contabil/classes/componente/";
else
	@$pathClassesComponente = $pathClasses."/componente/";

// Datas convertidas
@include_once $pathClassesComponente."Data.php";

// Calendario
@include_once $pathClassesComponente."Calendario.php";

// Numero
@include_once $pathClassesComponente."Numero.php";

// String
@include_once $pathClassesComponente."String.php";
?>
