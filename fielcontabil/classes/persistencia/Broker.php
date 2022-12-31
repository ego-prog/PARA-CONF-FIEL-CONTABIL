<?PHP

/**
*
*	Framework de Persistencia
*
*	Data de Criacao: 17/05/2002
*	Ultima Atualizacao: 17/05/2002
*	Modulo: Broker.php
*		Framework de mapeamento de objetos
*
*	Copyright (C) por APOENA Solucoes em Software Livre
*	http://www.apoenasoftwarelivre.com.br
*
*	@author 	Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*	@version	PHP3 & PHP4
*/

// Arquivo "header" do Framework
include $pathClassesPersistencia."framework_persistencia.inc";

/**
*
*	Broker
*
*	Classe que contem as principais definicoes para utilizacao de
*	"brokers" (Esta classe e o Facade para acesso aos brokers)
*
*	IMPORTANTE: Pode-se setar as propriedades de conexao nesta classe,
*	ou passar para o broker especifico.
*
*/
class Broker extends AbstractBroker {

	var $objetoPersistente; 	// Objeto representando o broker
	var $broker;				// Broker a ser utilizado

	/**
	*	Broker( $broker )
	*	Construtor da classe
	*/
	function Broker( $broker ) {

		$this->broker = $broker;

	}

	/**
	*	getInstancia()
	*	Retorna objeto de uso de broker
	*	@return &objetoPersistente	Objeto retornado
	*/
	function &getInstancia() {

		// Seleciona o broker...
		switch( $this->broker ) {

			// Caso seja PostgreSQL...
			case BD_PgSQL: {
				$this->objetoPersistente = new BrokerPgSQL();
				// Dados da fabrica APOENA
				$this->objetoPersistente->setParametro( BANCO, USUARIO,
						SENHA, PORTA, SERVIDOR );
				// Dados da Unitec
				//	  $this->objetoPersistente->setParametro( "bancariospoa", "bancariospoa",	"camp1321", "5432",
				//		"192.168.2.198" );
				break; }

			// Caso seja MySQL...
			case BD_MySQL: {
				$this->objetoPersistente = new BrokerMySQL();
				$this->objetoPersistente->setParametro( "sac", "root",
						"myadm1321", "3306", "localhost" );

				break; }

			// Caso seja Oracle...
			case BD_ORACLE: {
				$this->objetoPersistente = new BrokerOracle();
				break; }

			// Caso seja Odbc...
			case BD_ODBC: {
				// $this->objetoPersistente = new BrokerOdbc();
				break; }

			// Caso seja DBase...
			case BD_DBASE: {
				// $this->objetoPersistente = new BrokerDbase();
				break; }

			// Caso seja Informix...
			case BD_INFORMIX: {
				// $this->objetoPersistente = new BrokerInformix();
				break; }

			// Caso seja SQL Server...
			case BD_SQL_SERVER: {
				// $this->objetoPersistente = new BrokerSQLServer();
				break; }

			// Caso seja Sybase...
			case BD_SYBASE: {
				// $this->objetoPersistente = new BrokerSybase();
				break; }

			// Caso seja miniSQL...
			case BD_mSQL: {
				// $this->objetoPersistente = new BrokermSQL();
				break; }

			// Caso seja DBase...
			case BD_INTERBASE: {
				// $this->objetoPersistente = new BrokerInterbase();
				break; }

			// Caso seja Access...
			case BD_ACCESS: {
				// $this->objetoPersistente = new BrokerAccess();
				break; }

			// Caso seja XML...
			case ARQ_XML: {
				// $this->objetoPersistente = new BrokerXML();
				break; }

			// Caso seja Arquivo TXT...
			case ARQ_TXT: {
				// $this->objetoPersistente = new BrokerTXT();
				break; }

			// Caso seja Broker para teste...
			case TESTE: {
				$this->objetoPersistente = new BrokerTeste();
				break; }

			// Caso nao encontre...
			default: {
				$this->objetoPersistente = new BrokerPgSQL();
				break; }
		}

		return $this->objetoPersistente;

	}

}

?>
