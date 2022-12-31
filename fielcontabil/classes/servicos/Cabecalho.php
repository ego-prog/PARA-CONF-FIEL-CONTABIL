<?PHP

/**
*
*   Framework de Servicos
*
*   Data de Criacao: 19/05/2002
*   Ultima Atualizacao: 20/05/2002
*   Modulo: Msg.php
*	Framework de varios servicos utilizados nas Aplicacoes
*
*   Copyright (C) por APOENA Solucoes em Software Livre
*   http://www.apoenasoftwarelivre.com.br
*
*   @author	Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*   @version	PHP3 & PHP4
*/

// Arquivo "header" do Framework
include $pathClassesServicos."framework_servicos.inc";

/**
*
*	Cabecalho
*
*   Classe que contem as principais definicoes de cabecalho
*   exibidas nos sistemas
*
*/
class Cabecalho {

	var $titulo;		// mensagem a ser exibida
	var $estiloLetra;	// estilo CSS
	var $estiloFundo;	// estilo CSS

	// Mes por extenso, que possa ser utilizado pelo sistema
	var $mesExtenso = array( "Jan", "Fev", "Mar", "Abr",
				  "Mai", "Jun", "Jul",
				  "Ago", "Set", "Out", "Nov", "Dez" );

	/**
	*	setTitulo( $titulo )
	*	Recebe titulo da pagina
	*	@param $titulo		titulo
	*/
	function setTitulo( $titulo ) {

		$this->titulo = $titulo;

	}

	/**
	*	setConf( $estiloLetra, $estiloFundo )
	*	Recebe configuracao da classe
	*	@param $estiloLetra		estilo de letra
	*	@param $estiloFundo		estilo de fundo
	*/
	function setConf( $estiloLetra, $estiloFundo ) {

		$this->estiloLetra	 = $estiloLetra;
		$this->estiloFundo	 = $estiloFundo;

	}

	/**
	*	mostra()
	*	Exibe o cabecalho
	*/
	function mostra() {

		$hora	     = date("H");
		$minuto      = date("i");
		$dia	     = date("d");
		$mes	     = date("m");
		$ano	     = date("Y");

		echo "<table border=\"0\" class=\"$this->estiloFundo\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
		echo "<tr>\n<td class=\"$this->estiloLetra\">\n";
		echo "<strong>&nbsp;";
		echo $this->titulo;
		echo "</font><br></td>";
		echo "<td class=\"$this->estiloLetra\">\n<p align=\"right\">";
		echo "<small><strong>\n";
		print( " Data: " . $dia . "/" . $this->mesExtenso[($mes-1)] . "/" . $ano . " Hora: " . $hora . ":" . $minuto );
		echo "\n</strong></small>\n</td>\n</tr>\n</table>\n";

	}

	/**
	*	getMesExtenso()
	*	Retorna meses por extenso (array)
	*	@param $mesExtenso	    mes por extenso
	*/
	function getMesExtenso() {

		return $this->mesExtenso;

	}

}

?>
