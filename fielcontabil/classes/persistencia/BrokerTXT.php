<?PHP

/**
*
*   Framework de Persistencia
*
*   Data de Criacao: 17/05/2002
*   Ultima Atualizacao: 26/05/2002
*   Modulo: BrokerTXT.php
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
*	BrokerTXT
*
*   Classe que contem as principais definicoes para utilizacao de
*   "brokers" baseados em arquivos TXT
*
*/
class BrokerTXT extends BrokerArquivo {

	var $delimitador;	// delimitador do arquivo

	/**
	*	setDelimitador( $delimitador )
	*	Recebe delimitador do arquivo
	*	@param $delimitador	delimitador
	*/
	function setDelimitador( $delimitador ) {

		$this->delimitador = $delimitador;

	}

	/**
	*	getDelimitador()
	*	Retorna delimitador do arquivo
	*	@return $delimitador	delimitador
	*/
	function getDelimitador() {

		return $this->delimitador;

	}

}

?>
