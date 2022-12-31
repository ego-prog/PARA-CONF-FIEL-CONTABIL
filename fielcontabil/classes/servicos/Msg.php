<?PHP

/**
*
*	Framework de Servicos
*
*	Data de Criacao: 19/05/2002
*	Ultima Atualizacao: 19/05/2002
*	Modulo: Msg.php
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
*	Msg
*
*	Classe que contem as principais definicoes de mensagens
*	exibidas nos sistemas
*
*/
class Msg {

	var $mensagem;		// mensagem a ser exibida
	var $acaoExecutada; // acao a ser executada
	var $imagem;		// imagem a ser exibida
	var $estiloBotao;	// estilo CSS

	/**
	*	setMensagem( $mensagem )
	*	Recebe mensagem
	*	@param $mensagem	mensagem
	*/
	function setMensagem( $mensagem ) {

		$this->mensagem 	 = $mensagem;

	}

	/**
	*	setConf( $estiloBotao, $imagem, $acaoExecutada )
	*	Recebe configuracao da classe
	*	@param $estiloBotao estilo de botao
	*	@param $imagem			imagem (logo)
	*	@param $acaoExecutada	acao a ser executada
	*/
	function setConf( $estiloBotao, $imagem, $acaoExecutada ) {

		$this->estiloBotao	 = $estiloBotao;
		$this->imagem		 = $imagem;
		$this->acaoExecutada = $acaoExecutada;

	}

	/**
	*	mostra( $mostra )
	*	Exibe a mensagem
	*	@param	$mostra 	(boolean) Exibe Voltar
	*/
	function mostra( $mostra = true ) {

		echo "<br>\n<table width=\"500\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n";
		echo "<tr>\n";
		echo "<td width=\"27%\" height=\"91\">\n";
		echo "<div align=\"center\">\n<img src=".$this->imagem." width=\"200\" border=\"0\">\n</div>\n";
		echo "</td>\n</tr>\n</table>\n";
		echo "<font face=\"Verdana, Arial\" size=\"2\" color=\"darkblue\">\n";
		echo "<p align=\"center\">\n<big>\n<strong>\n".$this->mensagem."</strong>\n</big>\n</p>\n</font>\n";
		echo "<center>\n";

		if ( $mostra ) {
			echo "<form name=\"final\" action=\"executa.cgi\" method=\"post\">";
			echo "<input type=\"button\" class=\"$this->estiloBotao\" name=\"voltar\" value=\" Voltar \" onClick=\"$this->acaoExecutada\">";
			echo "</form>"; }

		echo "</center>\n";

	}

	/**
	*	mostraMsg( $mostra )
	*	Exibe a mensagem
	*	@param	$mostra 	(boolean) Exibe Voltar
	*/
	function mostraMsg( $mostra = true ) {

		echo "<br>\n";
		echo "<font face=\"Verdana, Arial\" size=\"2\" color=\"darkblue\">\n";
		echo "<p align=\"center\">\n<big>\n<strong>\n".$this->mensagem."</strong>\n</big>\n</p>\n</font>\n";
		echo "<center>\n";

		if ( $mostra ) {
			echo "<form name=\"final\" action=\"executa.cgi\" method=\"post\">";
			echo "<input type=\"button\" class=\"$this->estiloBotao\" name=\"voltar\" value=\" Voltar \" onClick=\"$this->acaoExecutada\">";
			echo "</form>"; }

		echo "</center>\n";

	}

	/**
	*	mostraMsgLink( $link, $mostra )
	*	Exibe a mensagem com link
	*	@param	$link		Link (URL) de acesso ao documento
	*	@param	$mostra 	(boolean) Exibe Voltar
	*/
	function mostraMsgLink( $link, $mostra = true ) {

		echo "<br>\n<table width=\"500\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n";
		echo "<tr>\n";
		echo "<td width=\"27%\" height=\"91\">\n";
		echo "<div align=\"center\">\n<img src=".$this->imagem." width=\"200\" border=\"0\">\n</div>\n";
		echo "</td>\n</tr>\n</table>\n";
		echo "<font face=\"Verdana, Arial\" size=\"2\" color=\"darkblue\">\n";
		echo "<p align=\"center\">\n<big>\n<a href=".$link.">".$this->mensagem."</a>\n</big>\n</p>\n</font>\n";
		echo "<center>\n";

		if ( $mostra ) {
			echo "<form name=\"final\" action=\"executa.cgi\" method=\"post\">";
			echo "<input type=\"button\" class=\"$this->estiloBotao\" name=\"voltar\" value=\" Voltar \" onClick=\"$this->acaoExecutada\">";
			echo "</form>"; }

		echo "</center>\n";

	}

	/**
	*	mostraMsgLink( $link, $mostra )
	*	Exibe a mensagem com link
	*	@param	$link		Link (URL) de acesso ao documento
	*	@param	$mostra 	(boolean) Exibe Voltar
	*/
	function mostraMsgFim( $link, $mostra = true ) {

		echo "<br>\n<table width=\"500\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n";
		echo "<tr>\n";
		echo "<td width=\"27%\" height=\"91\">\n";
		echo "<div align=\"center\">\n<img src=".$this->imagem." width=\"200\" border=\"0\">\n</div>\n";
		echo "</td>\n</tr>\n</table>\n";
		echo "<font face=\"Verdana, Arial\" size=\"2\" color=\"darkblue\">\n";
		echo "<p align=\"center\">\n<big>\n<a href=".$link." target=\"_top\">".$this->mensagem."</a>\n</big>\n</p>\n</font>\n";
		echo "<center>\n";

		if ( $mostra ) {
			echo "<form name=\"final\" action=\"executa.cgi\" method=\"post\">";
			echo "<input type=\"button\" class=\"$this->estiloBotao\" name=\"voltar\" value=\" Voltar \" onClick=\"$this->acaoExecutada\">";
			echo "</form>"; }

		echo "</center>\n";

	}
	
}
