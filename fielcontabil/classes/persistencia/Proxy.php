<?PHP

/**
*
*   Framework de Persistencia
*
*   Data de Criacao: 17/05/2002
*   Ultima Atualizacao: 17/05/2002
*   Modulo: Proxy.php
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
*	Proxy
*
*   Classe que contem as principais definicoes para utilizacao de
*   "brokers" (Cria objetos para uso dos Proxies)
*
*/
class Proxy {

	/**
	*	criaBroker()
	*	Retorna objeto de uso de broker especifico
	*	@return $broker->getInstancia()	Objeto retornado
	*/
	function criaBroker() {

		$broker = new Broker( $this->getBroker() );

		return $broker->getInstancia();

	}

}

?>
