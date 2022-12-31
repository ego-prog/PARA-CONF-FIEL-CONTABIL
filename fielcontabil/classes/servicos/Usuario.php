<?PHP

/**
*
*   Framework de Servicos
*
*   Data de Criacao: 19/05/2002
*   Ultima Atualizacao: 19/05/2002
*   Modulo: Usuario.php
*       Framework de varios servicos utilizados nas Aplicacoes
*
*   Copyright (C) por APOENA Solucoes em Software Livre
*   http://www.apoenasoftwarelivre.com.br
*
*   @author     Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*   @version    PHP3 & PHP4
*/

// Arquivo "header" do Framework
include $pathClassesServicos."framework_servicos.inc";

/**
*
*	Usuario
*
*   Classe que contem as principais definicoes de usuarios
*   que utilizam os sistemas
*
*/
class Usuario {

	var $nome;		// nome do usuario
	var $login;     // login do usuario
	var $senha;     // senha de acesso
	var $numeroIp;  // numero IP de acesso

	/**
	*	setUsuario( $nome, $login, $senha, $numeroIp )
	*	Recebe informacoes do usuario
	*	@param $nome		nome do usuario
	*	@param $login		login de acesso
	*	@param $senha		senha de acesso
	*	@param $numeroIp	IP de acesso
	*/
	function setUsuario( $nome, $login, $senha, $numeroIp ) {

		$this->setNome( $nome );
		$this->setLogin( $login );
		$this->setSenha( $senha );
		$this->setNumeroIp( $numeroIp );

	}

	/**
	*	setNome( $nome )
	*	Recebe nome do usuario
	*	@param $nome	nome
	*/
	function setNome( $nome ) {

		$this->nome = trim( String::upper( $nome ) );

	}

	/**
	*	getNome()
	*	Retorna nome do usuario
	*	@return $nome	nome
	*/
	function getNome() {

		return $this->nome;

	}


	/**
	*	setLogin( $login )
	*	Recebe login do usuario
	*	@param $login	login
	*/
	function setLogin( $login ) {

		$this->login = trim( $login );

	}

	/**
	*	getLogin()
	*	Retorna login do usuario
	*	@return $login	login
	*/
	function getLogin() {

		return $this->login;

	}

	/**
	*	setSenha( $senha )
	*	Recebe senha do usuario
	*	@param $senha	senha
	*/
	function setSenha( $senha ) {

		$this->senha = trim( $senha );

	}

	/**
	*	getSenha()
	*	Retorna senha do usuario
	*	@return $senha	senha
	*/
	function getSenha() {

		return $this->senha;

	}

	/**
	*	setNumeroIp( $numeroIp )
	*	Recebe IP de acesso
	*	@param $numeroIp	IP
	*/
	function setNumeroIp( $numeroIp ) {

		$this->numeroIp = $numeroIp;

	}

	/**
	*	getNumeroIp()
	*	Retorna IP de acesso
	*	@return $numeroIp	IP
	*/
	function getNumeroIp() {

		return $this->numeroIp;

	}

}

?>
