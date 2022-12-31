<?PHP

/**
*
*   Framework de Persistencia - Arquivo "header"
*
*   Data de Criacao: 17/05/2002
*   Ultima Atualizacao: 17/05/2002
*   Modulo: framework_persistencia.inc
*       Framework de mapeamento de objetos
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
$pathClassesPersistencia = $pathClasses."persistencia/";

// Propriedades utilizadas pelo Framework
include_once $pathClassesPersistencia."persistencia.properties";

// Constantes utilizadas pelo Framework
include_once $pathClassesPersistencia."BrokerConst.php";

// Superclasse de definicoes para brokers
include_once $pathClassesPersistencia."AbstractBroker.php";

// Broker para SGBD
include_once $pathClassesPersistencia."BrokerSGBD.php";

// Broker para Arquivo
include_once $pathClassesPersistencia."BrokerArquivo.php";

// Interface para uso dos Brokers
include_once $pathClassesPersistencia."Broker.php";

// Preparacao para as classes de materializacao
include_once $pathClassesPersistencia."Proxy.php";

// Broker para PostgreSQL
include_once $pathClassesPersistencia."BrokerPgSQL.php";

// Broker para MySQL
include_once $pathClassesPersistencia."BrokerMySQL.php";

// Broker para Oracle
//include_once $pathClassesPersistencia."BrokerOracle.php";

// Broker para ODBC
//include_once $pathClassesPersistencia."BrokerOdbc.php";

// Broker para DBase
//include_once $pathClassesPersistencia."BrokerDbase.php";

// Broker para Informix
//include_once $pathClassesPersistencia."BrokerInformix.php";

// Broker para SQL Server
//include_once $pathClassesPersistencia."BrokerSQLServer.php";

// Broker para Sybase
//include_once $pathClassesPersistencia."BrokerSybase.php";

// Broker para miniSQL
//include_once $pathClassesPersistencia."BrokermSQL.php";

// Broker para Interbase
//include_once $pathClassesPersistencia."BrokerInterbase.php";

// Broker para Access
//include_once $pathClassesPersistencia."BrokerAccess.php";

// Broker para XML
include_once $pathClassesPersistencia."BrokerXML.php";

// Broker para Arquivos TXT
include_once $pathClassesPersistencia."BrokerTXT.php";

// Broker para Teste de Classes "Proxy"
include_once $pathClassesPersistencia."BrokerTeste.php";

?>
