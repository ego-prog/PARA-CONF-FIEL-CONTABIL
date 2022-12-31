<?PHP

/**
*
*	Framework de Servicos
*
*	Data de Criacao: 19/05/2002
*	Ultima Atualizacao: 19/05/2002
*	Modulo: Log.php
*		Framework de varios servicos utilizados nas Aplicacoes
*
*	Copyright (C) por APOENA Solucoes em Software Livre
*	http://www.apoenasoftwarelivre.com.br
*
*	@author 	Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*	@version	PHP3 & PHP4
*/

// Arquivo "header" do Framework
include $pathClassesServicos."framework_servicos.inc";

/**
*
*	Log
*
*	Classe que contem as principais definicoes de log de operacoes
*	que utilizam os sistemas
*
*/
class Log {

	var $data;			// data da operacao
	var $hora;			// hora de registro
	var $numeroIp;		// numero IP de registro
	var $descricao; 	// descricao da operacao
	var $complemento;	// complemento da operacao

	/**
	*	setRegistro( $numeroIp, $descricao, $complemento )
	*	Recebe informacoes para registro de LOG
	*	@param $numeroIp	numero IP
	*	@param $descricao	descricao da operacao
	*	@param $complemento complemento da operacao
	*/
	function setRegistro( $numeroIp, $descricao, $complemento ) {

		$this->setData( date( "m/d/Y" ) );
		$this->setHora( date( "H:i" ) );
		$this->setNumeroIp( $numeroIp );
		$this->setDescricao( $descricao );
		$this->setComplemento( $complemento );

	}

	/**
	*	setData( $data )
	*	Recebe data de registro
	*	@param $data	data
	*/
	function setData( $data ) {

		$this->data = $data;

	}

	/**
	*	getData()
	*	Retorna data de registro
	*	@return $data	data
	*/
	function getData() {

		return $this->data;

	}

	/**
	*	setHora( $hora )
	*	Recebe hora de registro
	*	@param $hora	hora
	*/
	function setHora( $hora ) {

		$this->hora = $hora;

	}

	/**
	*	getHora()
	*	Retorna hora de registro
	*	@return $hora	hora
	*/
	function getHora() {

		return $this->hora;

	}

	/**
	*	setDescricao( $descricao )
	*	Recebe descricao da operacao
	*	@param $descricao	descricao
	*/
	function setDescricao( $descricao ) {

		$this->descricao = $descricao;

	}

	/**
	*	getDescricao()
	*	Retorna descricao da operacao
	*	@return $descricao	descricao
	*/
	function getDescricao() {

		return $this->descricao;

	}

	/**
	*	setComplemento( $complemento )
	*	Recebe complemento da operacao
	*	@param $complemento 	complemento
	*/
	function setComplemento( $complemento ) {

		$this->complemento = $complemento;

	}

	/**
	*	getComplemento()
	*	Retorna complemento da operacao
	*	@return $complemento	complemento
	*/
	function getComplemento() {

		return $this->complemento;

	}

	/**
	*	setNumeroIp( $numeroIp )
	*	Recebe IP de registro
	*	@param $numeroIp	IP
	*/
	function setNumeroIp( $numeroIp ) {

		$this->numeroIp = $numeroIp;

	}

	/**
	*	getNumeroIp()
	*	Retorna IP de registro
	*	@return $numeroIp	IP
	*/
	function getNumeroIp() {

		return $this->numeroIp;

	}

}

?>
