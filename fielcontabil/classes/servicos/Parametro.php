<?PHP

/**
*
*	Framework de Servicos
*
*	Data de Criacao: 19/05/2002
*	Ultima Atualizacao: 20/05/2002
*	Modulo: Parametro.php
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
*	Parametro
*
*	Classe que contem as principais definicoes de parametros
*	que utilizam os sistemas
*
*/
class Parametro {

	var $empresa;		// empresa que possui o sistema
	var $linha1;		// linha 1
	var $linha2;		// linha 2
	var $linha3;		// linha 3
	var $logotipo;		// logotipo da empresa
	var $maximoDiasLog; // numero maximo de dias de manutencao do LOG

	/**
	*	setParametro( $empresa, $linha1, $linha2, $linha3, $maximoDiasLog, $logotipo = "nada" )
	*	Recebe informacoes de parametros da aplicacao
	*	@param $empresa 		nome da empresa
	*	@param $linha1			linha 1
	*	@param $linha2			linha 2
	*	@param $linha3			linha 3
	*	@param $maximoDiasLog	numero maximo de dias
	*	@param $logotipo		logotipo da empresa
	*/
	function setParametro( $empresa, $linha1, $linha2, $linha3,
									 $maximoDiasLog, $logotipo = "nada"  ) {

		$this->setEmpresa( $empresa );
		$this->setLinha1( $linha1 );
		$this->setLinha2( $linha2 );
		$this->setLinha3( $linha3 );
		$this->setLogotipo( $logotipo );
		$this->setMaximoDiasLog( $maximoDiasLog );

	}

	/**
	*	setEmpresa( $empresa )
	*	Recebe empresa
	*	@param $empresa empresa
	*/
	function setEmpresa( $empresa ) {

		$this->empresa = $empresa;

	}

	/**
	*	getEmpresa()
	*	Retorna empresa
	*	@return $empresa	empresa
	*/
	function getEmpresa() {

		return $this->empresa;

	}

	/**
	*	setLinha1( $linha1 )
	*	Recebe linha 1
	*	@param $linha1	linha 1
	*/
	function setLinha1( $linha1 ) {

		$this->linha1 = $linha1;

	}

	/**
	*	getLinha1()
	*	Retorna linha 1
	*	@return $linha1 	linha 1
	*/
	function getLinha1() {

		return $this->linha1;

	}

	/**
	*	setLinha2( $linha2 )
	*	Recebe linha 2
	*	@param $linha2	linha 2
	*/
	function setLinha2( $linha2 ) {

		$this->linha2 = $linha2;

	}

	/**
	*	getLinha2()
	*	Retorna linha 2
	*	@return $linha2 	linha 2
	*/
	function getLinha2() {

		return $this->linha2;

	}

	/**
	*	setLinha3( $linha3 )
	*	Recebe linha 3
	*	@param $linha3	linha 3
	*/
	function setLinha3( $linha3 ) {

		$this->linha3 = $linha3;

	}

	/**
	*	getLinha3()
	*	Retorna linha 3
	*	@return $linha3 	linha 3
	*/
	function getLinha3() {

		return $this->linha3;

	}

	/**
	*	setLogotipo( $logotipo )
	*	Recebe logotipo
	*	@param $logotipo	logotipo
	*/
	function setLogotipo( $logotipo ) {

		$this->logotipo = $logotipo;

	}

	/**
	*	getLogotipo()
	*	Retorna logotipo
	*	@return $logotipo		logotipo
	*/
	function getLogotipo() {

		return $this->logotipo;

	}

	/**
	*	setMaximoDiasLog( $maximoDiasLog )
	*	Recebe numero de dias maximo para log
	*	@param $maximoDiasLog	maximo de dias
	*/
	function setMaximoDiasLog( $maximoDiasLog ) {

		$this->maximoDiasLog = $maximoDiasLog;

	}

	/**
	*	getMaximoDiasLog()
	*	Retorna numero de dias maximo para Log
	*	@return $maximoDiasLog		maximo de dias
	*/
	function getMaximoDiasLog() {

		return $this->maximoDiasLog;

	}

}

?>
