<?PHP

/**
*
*   Framework de Persistencia
*
*   Data de Criacao: 17/05/2002
*   Ultima Atualizacao: 17/05/2002
*   Modulo: BrokerArquivo.php
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
*	BrokerArquivo
*
*   Classe que contem as principais definicoes para utilizacao de
*   "brokers" baseados em arquivos
*
*/
class BrokerArquivo extends AbstractBroker {

	var $handler;		// Ponteiro para uso do broker

	/**
	*	getInstancia()
	*	Retorna objeto de uso de arquivo
	*	@return &$handler	Objeto retornado
	*/
	function &getInstancia() {

		return $handler;

	}

	/**
	*	abreArquivo()
	*	Abre arquivo para uso
	*/
	function abreArquivo() {

		// Implementar quando preciso...

	}

	/**
	*	fechaArquivo()
	*	Fecha arquivo em uso
	*/
	function fechaArquivo() {

		// Implementar quando preciso...

	}

	/**
	*	leArquivo()
	*	Le arquivo em uso
	*/
	function leArquivo() {

		// Implementar quando preciso...

	}

	/**
	*	gravaArquivo()
	*	Grava arquivo em uso
	*/
	function gravaArquivo() {

		// Implementar quando preciso...

	}

}

?>
