<?PHP

/**
*
*   Framework de Persistencia
*
*   Data de Criacao: 17/05/2002
*   Ultima Atualizacao: 17/05/2002
*   Modulo: AbstractBroker.php
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
*	AbstractBroker
*
*   Classe que contem as principais definicoes que serao herdadas para os
*   "brokers" especificos
*
*/
class AbstractBroker {

	var $host;			// Endereco da maquina onde estara disponivel o "broker"
	var $usuario;		// Usuario de conexao
	var $senha;			// Senha do usuario
	var $porta;			// Porta de acesso
	var $nomeBanco;		// Nome do Banco de Dados
	var $nomeArquivo;	// Nome do Arquivo usado para persistencia

	/**
	*	setHost( $host )
	*	Recebe host
	*	@param $host	Host informado
	*/
	function setHost( $host ) {

		$this->host = $host;

	}

	/**
	*	getHost()
	*	Retorna host
	*	@return $host	Host informado
	*/
	function getHost() {

		return $this->host;

	}

    /**
	*	setUsuario( $usuario )
	*	Recebe usuario
	*	@param $usuario	Usuario informado
	*/
	function setUsuario( $usuario ) {

		$this->usuario = $usuario;

	}

	/**
	*	getUsuario()
	*	Retorna usuario
	*	@return $usuario	Usuario informado
	*/
	function getUsuario() {

		return $this->usuario;

	}

	/**
	*	setSenha( $senha )
	*	Recebe senha
	*	@param $senha	Senha informada
	*/
	function setSenha( $senha ) {

		$this->senha = $senha;

	}

	/**
	*	getSenha()
	*	Retorna senha
	*	@return $senha	Senha informada
	*/
	function getSenha() {

		return $this->senha;

	}

	/**
	*	setPorta( $porta )
	*	Recebe porta
	*	@param $porta	Porta informada
	*/
	function setPorta( $porta ) {

		$this->porta = $porta;

	}

	/**
	*	getPorta()
	*	Retorna porta
	*	@return $porta	Porta informada
	*/
	function getPorta() {

		return $this->porta;

	}

	/**
	*	setNomeBanco( $nomeBanco )
	*	Recebe nome do Banco de Dados
	*	@param $nomeBanco	Nome do Banco de Dados informado
	*/
	function setNomeBanco( $nomeBanco ) {

		$this->nomeBanco = $nomeBanco;

	}

	/**
	*	getNomeBanco()
	*	Retorna nome do Banco de Dados
	*	@return $nomeBanco	Nome do Banco de Dados informado
	*/
	function getNomeBanco() {

		return $this->nomeBanco;

	}

    /**
	*	setNomeArquivo( $nomeArquivo )
	*	Recebe nome do arquivo
	*	@param $nomeArquivo	Nome do Arquivo informado
	*/
	function setNomeArquivo( $nomeArquivo ) {

		$this->nomeArquivo = $nomeArquivo;

	}

	/**
	*	getNomeArquivo()
	*	Retorna nome do arquivo
	*	@return $nomeArquivo	Nome do Arquivo informado
	*/
	function getNomeArquivo() {

		return $this->nomeArquivo;

	}

	/**
	*	setParametro( $nomeBanco, $usuario, $senha, $porta, $host )
	*	Recebe parametros
	*	@param $nomeBanco	Nome do Banco de Dados
	*	@param $usuario		Usuario
	*	@param $senha       Senha do usuario
	*	@param $porta		Porta de conexao
	*	@param $host        Host
	*/
	function setParametro( $nomeBanco, $usuario, $senha, $porta, $host ) {

		$this->setNomeBanco( $nomeBanco );
		$this->setUsuario( $usuario );
		$this->setSenha( $senha );
		$this->setPorta( $porta );
		$this->setHost( $host );

	}

}

?>
