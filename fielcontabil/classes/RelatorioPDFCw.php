<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 08/12/2003
*	Modulo: RelatorioPDFCw.php
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
*	RelatorioPDFCw
*
*	Classe que contem as principais definicoes de para apresentacao
*	de relatorios formato PDF no Contábil Web
*
*/
class RelatorioPDFCw extends RelatorioPDF {

	// Tem que ser alterado depois, para ver as cores do VOX
	var $corPreto;		   // Cor preto pertencente ao Relatorio
	var $corLaranja;	   // Cor laranja
	var $corBranco; 	   // Cor branca
	var $corVerde;		   // Cor verde
	var $fonteTimbre;	   // Fonte do timbre
	var $fonteTitulo;	   // Fonte do titulo do relatorio
	var $fonteSubTitulo;	   // Fonte do subtitulo
	var $fonteTituloTabela;    // Fonte do titulo da tabela
	var $fonteTextoTabela;	   // Fonte da tabela
	var $corTituloTabela;	   // Cor das letras do titulo da tabela
	var $corFundoTituloTabela; // Cor de fundo do titulo da tabela
	var $corBordaTabela;	   // Cor da borda da tabela
	var $corFundoTabela;	   // Cor de fundo da tabela
	var $corTextoTabela;	   // Cor do texto
	var $numeroPagina;		   // Numero de pagina
	var $tituloHeader;	   // Flag de controle de titulo em header...
	var $tamanhoColunas;	   // Tamanho das colunas...
	var $textoColunas;	   // Texto das colunas...

	/**
	*	RelatorioPDFCw( $oidEmpresa, $tituloRelatorio, $subTitulo, $nomeSoftware,
	*					textoPagina, $numeroPagina,
	*		$tituloHeader = false, $tamanhoColunas, $textoColunas )
	*	Construtor da classe
	*	@param	$oidEmpresa	 OID da empresa
	*	@param	$tituloRelatorio	 Titulo do relatorio
	*	@param	$subTitulo		 Sub-titulo do relatorio
	*	@param	$nomeSoftware		 Nome do software
	*	@param	$textoPagina		 Texto da pagina
	*	@param	$numeroPagina		 Numero de pagina
	*	@param $tituloHeader		Se tem titulo no header
	*	@param $tamanhoColunas		Tamanho das colunas
	*	@param $textoColunas		Texto de colunas
	*/
	function RelatorioPDFCw( $oidEmpresa, $tituloRelatorio, $subTitulo,
						$nomeSoftware, $textoPagina, $numeroPagina = 0,
		$tituloHeader = false, $tamanhoColunas = array( 0 ), $textoColunas = array( "texto" ) ) {

		// Seta as cores e fontes...
		$this->corPreto 		= array( 0, 0, 0 );
		$this->corLaranja		= array( 255, 204, 0 );
		$this->corBranco		= array( 255, 255, 255 );
		$this->corVerde 		= array( 102, 153, 0 );
		$this->fonteTimbre		= array( "Arial", "", 10 );
		$this->fonteTitulo		= array( "Arial", "B", 12 );
		$this->fonteSubTitulo		= array( "Arial", "I", 8 );
		$this->fonteTituloTabela	= array( "Arial", "B", 8 );
		$this->fonteTextoTabela 	= array( "Arial", "", 7 );
		$this->corTituloTabela		= $this->corBranco;
		$this->corFundoTituloTabela	= $this->corVerde;
		$this->corBordaTabela		= $this->corBranco;
		$this->corFundoTabela		= $this->corLaranja;
		$this->corTextoTabela		= $this->corPreto;
		$this->numeroPagina	= $numeroPagina;
		$this->tituloHeader	= $tituloHeader;
		$this->tamanhoColunas		= $tamanhoColunas;
		$this->textoColunas	= $textoColunas;

		$corFundo	 = array( 24, 118, 206 );
		$corTexto	 = array( 255, 255, 255 );
		$corBorda	 = array( 255, 255, 255 );
		$fonteTitulo = array( "Arial", "B", 8 );

		// Recebe parametros para montagem do relatorio...
		$parametro = new ParametroCw();
		$parametro->pesquisaEmpresa( $oidEmpresa );

		// monta o timbre do relatorio...
		$brasao 		 = explode( ".", $parametro->getLogotipo() );
		$timbre[REL_LOGO]	 = "../imagens/".LOGOMARCA;   // "../imagens/".$parametro->getLogotipo();
		$timbre[REL_EMPRESA] = $parametro->getEmpresa();
		$timbre[REL_LINHA1]  = $parametro->getLinha1();
		$timbre[REL_LINHA2]  = $parametro->getLinha2();
		$timbre[REL_LINHA3]  = $parametro->getLinha3();

		// Seta as propriedades do relatorio...
		$this->setConf( $tituloRelatorio, $subTitulo, $timbre, $this->corPreto, $this->fonteTimbre,
			$this->corPreto, $this->fonteTitulo, $this->corBranco, $this->corBranco, $this->corPreto,
			$this->fonteSubTitulo, $this->corBranco, $this->corBranco,
			$nomeSoftware, $textoPagina, $this->numeroPagina,
			$this->tituloHeader, $this->tamanhoColunas, $this->textoColunas );

	}

}

?>
