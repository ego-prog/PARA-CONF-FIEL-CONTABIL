<?PHP

/**
*
*	Framework de Persistencia - Constantes
*
*	Data de Criacao: 16/05/2002
*	Ultima Atualizacao: 16/05/2002
*	Modulo: BrokerConst.php
*		Framework de mapeamento de objetos
*
*	Copyright (C) por APOENA Solucoes em Software Livre
*	http://www.apoenasoftwarelivre.com.br
*
*	@author 	Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*	@version	PHP3 & PHP4
*/

/**
*	Estao declaradas aqui todas constantes utilizadas pelos brokers
*  que sao geralmente retorno de metodos
*/

// Definicoes de Excecoes
define("BD_OK", 			1);
define("BD_ERRO",			0);
define("BD_FALHA_CONSULTA", 0);

// Definicoes de Brokers SGBD
define("BD_PgSQL",		  0);
define("BD_MySQL",		  1);
define("BD_ORACLE", 	  2);
define("BD_ODBC",		  3);
define("BD_DBASE",		  4);
define("BD_INFORMIX",	  5);
define("BD_SQL_SERVER",   6);
define("BD_SYBASE", 	  7);
define("BD_mSQL",		  8);
define("BD_INTERBASE",	  9);
define("BD_ACCESS", 	 10);

// Definicoes de Brokers Arquivo
define("ARQ_XML",		 11);
define("ARQ_TXT",		 12);

// Broker para teste...
define("TESTE", 		 100);



?>
