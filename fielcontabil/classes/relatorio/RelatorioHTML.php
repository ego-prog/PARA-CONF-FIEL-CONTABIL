<?PHP

/**
*
*   Framework de Relatorio
*
*   Data de Criacao: 20/05/2002
*   Ultima Atualizacao: 20/05/2002
*   Modulo: RelatorioHTML.php
*	Framework de relatorio
*
*   Copyright (C) por APOENA Solucoes em Software Livre
*   http://www.apoenasoftwarelivre.com.br
*
*   @author	Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*   @version	PHP3 & PHP4
*/

// Arquivo "header" do Framework
include $pathClassesRelatorio."framework_relatorio.inc";

/**
*
*	RelatorioHTML
*
*   Classe que contem as principais definicoes de relatorios no formato HTML
*   exibidas nos sistemas
*
*/
class RelatorioHTML extends AbstractFormat {

	var $arquivoEstilo;	 // estilo CSS
	var $estiloPagina;   // estilo da pagina
	var $estiloTimbre;	 // estilo do timbre
	var $estiloDataHora; // estilo de data e hora
	var $estiloBotao;	 // estilo de botao
	var $corTitulo;      // Cor do titulo (formato HTML)

	/**
	*	setConf( $arquivoEstilo, $estiloPagina, $estiloTimbre,
	*				$estiloDataHora, $estiloBotao, $corTitulo )
	*	Recebe configuracao da classe
	*	@param $arquivoEstilo	arquivo CSS
	*	@param $estiloPagina	pagina HTML
	*	@param $estiloTimbre	timbre
	*	@param $estiloDataHora	data e hora
	*	@param $estiloBotao		botao
	*	@param $corTitulo		cor do titulo (formato HTML)
	*/
	function setConf( $arquivoEstilo, $estiloPagina, $estiloTimbre,
						$estiloDataHora, $estiloBotao, $corTitulo ) {

		$this->arquivoEstilo  = $arquivoEstilo;
		$this->estiloPagina	  = $estiloPagina;
		$this->estiloTimbre	  = $estiloTimbre;
		$this->estiloDataHora = $estiloDataHora;
		$this->estiloBotao    = $estiloBotao;
		$this->corTitulo      = $corTitulo;

	}

	/**
	*	inicioRelatorio()
	*	Inicia formatacao do relatorio
	*/
    function inicioRelatorio() {

		// Monta título...
		// $this->arquivoEstilo
		echo "<HTML>\n<HEAD>\n<TITLE>Relatório</TITLE>\n";
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$this->arquivoEstilo\">\n";
		echo "</head>\n<body class=\"$this->estiloPagina\">\n";
		echo "<div align=\"center\">\n";
		if ( $this->getMostraTimbre() ) {
			echo "<table border=\"0\" width=\"100%\">\n";
			echo "<tr>\n<td align=\"center\" width=\"10%\">\n";
			echo "<img src=".$this->timbre[REL_LOGO]." width=\"130\"></td>\n";
			echo "<td width=\"60%\" align=\"left\" class=\"$this->estiloTimbre\">";
			echo $this->timbre[REL_EMPRESA]."<br>".$this->timbre[REL_LINHA1]."<br>".$this->timbre[REL_LINHA2]."<br>".$this->timbre[REL_LINHA3];
			echo "</td>\n";
			echo "<td width=\"30%\" align=\"right\" class=\"$this->estiloDataHora\">";
			echo date("d")."/".date("m")."/".date("Y")."<br>";
			echo date("H").":".date("i");
			echo "</td>\n";
			echo "</tr>\n</table>\n<br>\n"; }
		$this->mostraCabecalho();

	}

	/**
	*	fimRelatorio( $acao = "", $infoAdicionais = "", $voltar = "javascript:history.back();" )
	*	Finaliza formatacao do relatorio
	*	@param	$acao			acao a ser executada (modulo php)
	*	@param	$infoAdicionais textos adicionais
	*	@param	$voltar 		acao a ser executada para voltar (javascript:history.back)
	*/
    function fimRelatorio( $acao = "", $infoAdicionais = "",
								$voltar = "javascript:history.back();" ) {

		echo "<form name=\"final\" action=\"".$acao."\" method=\"get\">\n";
		echo "<p align=\"center\">\n";
		echo $infoAdicionais;
		echo "<input type=\"button\" name=\"voltar\" class=\"$this->estiloBotao\" value=\"Voltar\" onClick=\"".$voltar."\">\n";
		echo "</p><br><br>\n";
		// Finaliza...
		echo "</form>\n</div>\n</body>\n</html>\n";

	}

	/**
	*	mostraCabecalho()
	*	Mostra cabecalho do relatorio
	*/
	function mostraCabecalho() {

		// Mostra Cabeçalho
		echo "\n<font size=\"+1\" color=\"$this->corTitulo\" face=\"Verdana, Arial\">\n";
		echo "<strong>".$this->getTitulo()."</strong></font>\n";
		echo "<br><br>\n";
		if ( $this->getSubTitulo() != "NENHUM" )
			$this->mostraSubTitulo();
		echo $this->getCabecalho();

	}

	/**
	*	mostraString( $linha )
	*	Mostra string no relatorio
	*	@param	$linha		Linha a ser exibida
	*/
	function mostraString( $linha ) {

		if ( strlen( trim( $linha ) ) != 0 )
			echo $linha."\n";
		else
			echo "-";

	}

	/**
	*	mostraValor( $valor )
	*	Mostra valor no relatorio
	*	@param	$valor		valor a ser exibido
	*/
	function mostraValor( $valor ) {

		printf( "%.2f", $valor );

	}

	/**
	*	mostraSubTitulo()
	*
	*	Mostra do subtitulo
	*/
	function mostraSubTitulo() {

		$this->mostraString( "<table border =\"0\" width=\"100%\">" );
		$this->mostraString( "<tr><td bgcolor=\"#FFFFFF\">" );
		$this->mostraString( "<font color=\"$this->corTitulo\" face=\"Verdana, Arial\" size=\"1\">" );
		$this->mostraString( "<p align=\"center\"><b>" );
		$this->mostraString( $this->getSubTitulo() );
		$this->mostraString( "</b></p></font></td></tr></table><br>\n" );

	}

}

?>
