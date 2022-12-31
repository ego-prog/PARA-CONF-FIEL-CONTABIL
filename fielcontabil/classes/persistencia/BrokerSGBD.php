<?PHP

/**
*
*   Framework de Persistencia
*
*   Data de Criacao: 17/05/2002
*   Ultima Atualizacao: 17/05/2002
*   Modulo: BrokerSGBD.php
*       Framework de mapeamento de objetos
*
*   Copyright (C) por APOENA Solucoes em Software Livre
*   http://www.apoenasoftwarelivre.com.br
*
*   @author     Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*   @version    PHP3 & PHP4
*/

// Arquivo "header" do Framework
include $pathClassesPersistencia."framework_persistencia.inc";

/**
*
*	BrokerSGBD
*
*   Classe que contem as principais definicoes para utilizacao de
*   "brokers" baseados em SGBDs
*
*/
class BrokerSGBD extends AbstractBroker {

	var $handler;		// Ponteiro para uso do broker
	var $instrucaoSql;  // Instrucao SQL
	var $resultado;     // Resultado da execucao de uma instrucao
	var $parametroBD; 	// Todos os parametros para acesso ao BD	

	/**
	*	getInstancia()
	*	Retorna objeto de uso de broker
	*	@return &$handler	Objeto retornado
	*/
	function &getInstancia() {

		return $handler;

	}

	/**
	*	setInstrucaoSql( $instrucaoSql )
	*	Recebe instrucao SQL
	*	@param $instrucaoSql	instrucao SQL
	*/
	function setInstrucaoSql( $instrucaoSql ) {

		$this->instrucaoSql = $instrucaoSql;

	}

	/**
	*	getInstrucaoSql()
	*	Retorna instrucao SQL
	*	@return $instrucaoSql	instrucao SQL informada
	*/
	function getInstrucaoSql() {

		return $this->instrucaoSql;

	}

}

?>
