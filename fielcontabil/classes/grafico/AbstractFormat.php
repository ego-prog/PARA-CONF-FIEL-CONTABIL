<?PHP

/**
*
*   Framework de Relatorio
*
*   Data de Criacao: 19/05/2002
*   Ultima Atualizacao: 20/05/2002
*   Modulo: AbstractFormat.php
*       Framework de relatorios
*
*   Copyright (C) por APOENA Solucoes em Software Livre
*   http://www.apoenasoftwarelivre.com.br
*
*   @author     Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*   @version    PHP3 & PHP4
*/

// Arquivo "header" do Framework
include $pathClassesRelatorio."framework_relatorio.inc";

/**
*
*	AbstractFormat
*
*   Classe que contem as principais definicoes dos relatorios
*   utilizados pelos sistemas
*
*/
class AbstractFormat {

	var $titulo;		// titulo
	var $subTitulo;		// subtitulo do relatorio
	var $cabecalho;	    // cabecalho
	var $timbre;        // timbre
	var $mostraTimbre;	// flag de exibicao de timbre

	/**
	*	setPropriedade( $titulo, $cabecalho, $timbre, $subTitulo, $mostraTimbre )
	*	Recebe as propriedades do relatorio
	*	@param $titulo		titulo
	*	@param $cabecalho	cabecalho
	*	@param $timbre		timbre
	*	@param $subTitulo	subtitulo do relatorio
	*/
	function setPropriedade( $titulo, $cabecalho, $timbre, $subTitulo = "NENHUM",
			$mostraTimbre = true ) { 

		$this->setTitulo( $titulo );
		$this->setCabecalho( $cabecalho );
		$this->setTimbre( $timbre );
		$this->setSubTitulo( $subTitulo );
		$this->setMostraTimbre( $mostraTimbre );

	}

	/**
	*	setTitulo( $titulo )
	*	Recebe titulo do relatorio
	*	@param $titulo	titulo
	*/
	function setTitulo( $titulo ) {

		$this->titulo  	 = $titulo;

	}

	/**
	*	getTitulo()
	*	Retorna titulo do relatorio
	*	@return $titulo	titulo
	*/
	function getTitulo() {

		return $this->titulo;

	}

	/**
	*	setSubTitulo( $subTitulo )
	*	Recebe subtitulo do relatorio
	*	@param $subTitulo	subTitulo
	*/
	function setSubTitulo( $subTitulo ) {

		$this->subTitulo  	 = $subTitulo;

	}

	/**
	*	getSubTitulo()
	*	Retorna subtitulo do relatorio
	*	@return $subTitulo	subTitulo
	*/
	function getSubTitulo() {

		return $this->subTitulo;

	}

	/**
	*	setTimbre( $timbre )
	*	Recebe timbre do relatorio
	*	@param $timbre	timbre
	*/
	function setTimbre( $timbre ) {

		$this->timbre  	 = $timbre;

	}

	/**
	*	getTimbre()
	*	Retorna timbre do relatorio
	*	@return $timbre	timbre
	*/
	function getTimbre() {

		return $this->timbre;

	}

	/**
	*	setCabecalho( $cabecalho )
	*	Recebe cabecalho do relatorio
	*	@param $cabecalho	cabecalho
	*/
	function setCabecalho( $cabecalho ) {

		$this->cabecalho	= $cabecalho;

	}

	/**
	*	getCabecalho()
	*	Retorna cabecalho do relatorio
	*	@return $cabecalho	cabecalho
	*/
	function getCabecalho() {

		return $this->cabecalho;

	}

	/**
	*	setMostraTimbre( $mostraTimbre )
	*	Recebe flag de exibicao
	*	@param $mostraTimbre	flag
	*/
	function setMostraTimbre( $mostraTimbre ) {

		$this->mostraTimbre	 = $mostraTimbre;

	}

	/**
	*	getMostraTimbre()
	*	Retorna flag de exibicao
	*	@return $mostraTimbre	flag
	*/
	function getMostraTimbre() {

		return $this->mostraTimbre;

	}
}
