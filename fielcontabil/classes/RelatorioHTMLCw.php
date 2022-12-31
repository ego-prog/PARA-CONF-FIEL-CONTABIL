<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 19/09/2003
*	Modulo: RelatorioHTMLCw.php
*
*	Desenvolvido por APOENA Solucoes em Software Livre
*	suporte@apoenasoftwarelivre.com.br
*	http://www.apoenasoftwarelivre.com.br
*
*	@author 	Claudimir Zavalik (claudimir@apoenasoftwarelivre.com.br)
*	@author 	Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*	@version	PHP3 & PHP4
*/

// Arquivo "header" do Contábil
include $pathClasses."cw.inc";

/**
*
*	RelatorioHTMLCw
*
*	Classe que contem as principais definicoes de para apresentacao
*	de relatorios e graficos no Contábil
*
*/
class RelatorioHTMLCw extends Grafico {

	/**
	*	RelatorioHTMLCw( $oidEmpresa, $tituloRelatorio, $cabecalho,
	*			  $subTitulo = "NENHUM", $mostraTimbre = true )
	*	Construtor da classe
	*	@param	$oidEmpresa	     OID da empresa
	*	@param	$tituloRelatorio     Titulo do relatorio
	*	@param	$cabecalho	     cabecalho
	*	@param	$subTitulo	     Sub-titulo do relatorio
	*	@param	$mostraTimbre	     flag de exibicao de timbre
	*/
	function RelatorioHTMLCw( $oidEmpresa, $tituloRelatorio,
			$cabecalho, $subTitulo = "NENHUM", $mostraTimbre = true ) {

		// Seta configuracoes dos relatorios a serem a presentados...
		$this->setConf( "../estilo/cw.css", "pagina", "lcons3", "lcons3",
						"bjanela", "#000099" );

		// Recebe parametros para montagem do relatorio...
		$parametro = new ParametroCw();
		$parametro->pesquisaEmpresa( $oidEmpresa );

		// monta o timbre do relatorio...
		$timbre[REL_LOGO]    = "../imagens/".LOGOMARCA; // $parametro->getLogotipo();
		$timbre[REL_EMPRESA] = $parametro->getEmpresa();
		$timbre[REL_LINHA1]  = $parametro->getLinha1();
		$timbre[REL_LINHA2]  = $parametro->getLinha2();
		$timbre[REL_LINHA3]  = $parametro->getLinha3();

		// Seta as propriedades do relatorio...
		$this->setPropriedade( $tituloRelatorio, $cabecalho, $timbre, $subTitulo,
				      $mostraTimbre );

	}

}

?>
