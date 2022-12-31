<?PHP

/**
*
*   Framework de Persistencia
*
*   Data de Criacao: 17/05/2002
*   Ultima Atualizacao: 17/05/2002
*   Modulo: BrokerOracle.php
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
*	BrokerOracle
*
*   Classe que contem as principais definicoes para utilizacao do
*   "broker" Oracle
*
*/
class BrokerOracle extends BrokerSGBD {

	/**
	* 	BrokerOracle()
	* 	Construtor da classe
	*/
	function BrokerOracle() {

		// No construtor e possivel definir algumas definicoes especificas
		// do BD, incluindo maquina, usuario, senha...
		// $this->setParametro( banco, usuario, senha,
		//						"5432", host );

	}

	/**
	* 	mostra()
	* 	Metodo de teste do Broker
	*/
	function mostra() {

		return "SGBD ORACLE";

	}

}

?>

