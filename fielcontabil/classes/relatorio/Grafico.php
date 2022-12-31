<?PHP

/**
*
*   Framework de Relatorio
*
*   Data de Criacao: 20/05/2002
*   Ultima Atualizacao: 20/05/2002
*   Modulo: Grafico.php
*       Framework de relatorio
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
*	Grafico
*
*   Classe que contem as principais definicoes de graficos no formato HTML
*   exibidas nos sistemas
*
*/
class Grafico extends RelatorioHTML {

	/**
	* 	mostraBarra( $diretorio, $cor, $tamanho )
	* 	Mostra barra de imagem para grafico ou legenda
	*   @param  $diretorio	caminho relativo das imagens
	*	@param	$cor		cor desejada
	*	@param	$tamanho	tamanho da imagem
	*/
	function mostraBarra( $diretorio, $cor, $tamanho ) {

		$inicio = $diretorio."ini_".$cor.".gif";
		$meio   = $diretorio.$cor.".gif";
		$fim    = $diretorio."fim_".$cor.".gif";

		$this->mostraString( "<img src=\"$inicio\" border=\"0\" height=14 width=7><img src=\"$meio\" border=\"0\" height=14 width=\"$tamanho\"><img src=\"$fim\" border=\"0\" height=14 width=7>" );

	}

}

?>