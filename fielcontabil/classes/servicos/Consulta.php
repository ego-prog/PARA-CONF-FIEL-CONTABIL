<?PHP

/**
*
*   Framework de Servicos
*
*   Data de Criacao: 19/05/2002
*   Ultima Atualizacao: 20/05/2002
*   Modulo: Consulta.php
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
*	Consulta
*
*   Classe que contem as principais definicoes de consultas
*   que utilizam os sistemas
*
*/
class Consulta {

	var $titulo;		// titulo da consulta
	var $modulo;    	// modulo PHP
	var $instrucaoSql;  // instrucao SQL

	/**
	*	setConsulta( $titulo, $modulo, $instrucaoSql )
	*	Recebe informacoes da Consulta
	*	@param $titulo			titulo da consulta
	*	@param $modulo			modulo PHP
	*	@param $instrucaoSql	instrucao SQL
	*/
	function setConsulta( $titulo, $modulo, $instrucaoSql ) {

		$this->setTitulo( trim( $titulo ) );
		$this->setModulo( trim( $modulo ) );
		$this->setInstrucaoSql( trim( $instrucaoSql ) );

	}

	/**
	*	setTitulo( $titulo )
	*	Recebe titulo da consulta
	*	@param $titulo	titulo
	*/
	function setTitulo( $titulo ) {

		$this->titulo = $titulo;

	}

	/**
	*	getTitulo()
	*	Retorna titulo da consulta
	*	@return $titulo	titulo
	*/
	function getTitulo() {

		return $this->titulo;

	}


	/**
	*	setModulo( $modulo )
	*	Recebe modulo PHP
	*	@param $modulo	modulo
	*/
	function setModulo( $modulo ) {

		$this->modulo = $modulo;

	}

	/**
	*	getModulo()
	*	Retorna modulo PHP
	*	@return $modulo	modulo
	*/
	function getModulo() {

		return $this->modulo;

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

	/**
	* 	mostraModulo()
	* 	Executa modulo PHP
	*/
	function mostraModulo() {

		$arquivo = fopen( trim( $this->getModulo() ),"r" );

		if ( !$arquivo ) {
    		exit; }

	    while(!feof( $arquivo ) ) {
    		$byteLido = fgets( $arquivo, 1024 );
	      	echo $byteLido; }

		fclose( $arquivo );

	}

}

?>
