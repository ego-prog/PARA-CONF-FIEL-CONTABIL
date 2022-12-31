<?PHP

/**
*
*   Framework de Persistencia
*
*   Data de Criacao: 17/05/2002
*   Ultima Atualizacao: 17/05/2002
*   Modulo: BrokerXML.php
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
*	BrokerXML
*
*   Classe que contem as principais definicoes para utilizacao de
*   "brokers" baseados em XML
*
*/
class BrokerXML extends BrokerArquivo {

	var $dtdFormato;	// DTD usada no arquivo XML

	/**
	*	validaArquivo()
	*	Valida arquivo XML com DTD informada
	*/
	function validaArquivo() {

		// Implementar quando preciso...

	}

	/**
	*	setDtdFormato( $dtdFormato )
	*	Recebe DTD utilizada no arquivo
	*	@param $dtdFormato	DTD utilizada
	*/
	function setDtdFormato( $dtdFormato ) {

		$this->dtdFormato = $dtdFormato;

	}

	/**
	*	getDtdFormato()
	*	Retorna DTD
	*	@return $dtdFormato	DTD utilizada
	*/
	function getDtdFormato() {

		return $this->dtdFormato;

	}

}

?>
