<?PHP

/**
*
*   Framework de Relatorio
*
*   Data de Criacao: 20/05/2002
*   Ultima Atualizacao: 08/08/2002
*   Modulo: RelatorioPDF.php
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
*	RelatorioPDF
*
*   Classe que contem as principais definicoes de relatorios no formato PDF
*   exibidas nos sistemas
*
*/
class RelatorioPDF extends AbstractFormat {

	var $document;		// Singleton de acesso ao PDF
	var $corTimbre; 	// Cor do timbre em RGB
	var $fonteTimbre;	// Fonte do timbre
	var $corTitulo; 	// Cor do titulo do relatorio
	var $fonteTitulo;	// Fonte do titulo
	var $corBordaTitulo;	// Cor da borda do titulo
	var $corFundoTitulo;	// Cor de fundo do titulo
	var $corSubTitulo;	// Cor do subtitulo do relatorio
	var $fonteSubTitulo;	// Cor do subtitulo
	var $corBordaSubTitulo; // Cor da borda do subtitulo
	var $corFundoSubTitulo; // Cor de fundo do subtitulo
	var $nomeSoftware;	// Nome da aplicacao
	var $textoPagina;	// Texto da página (Rodapé)
	var $numeroPagina;	// Numero de pagina
	var $tituloHeader;	// Flag de controle de titulo em header...
	var $tamanhoColunas;	// Tamanho das colunas...
	var $textoColunas;	// Texto das colunas...
	
	/**
	*	setConf( $titulo, $subTitulo, $timbre, $corTimbre, $fonteTimbre, $corTitulo, $fonteTitulo,
	*		$corBordaTitulo, $corFundoTitulo, $corSubTitulo, $fonteSubTitulo, $corBordaSubTitulo,
	*		$corFundoSubTitulo, $nomeSoftware, $textoPagina, $numeroPagina,
	*		$tituloHeader = false, $tamanhoColunas, $textoColunas )
	*	Seta informacoes necessarias para configuracao do PDF
	*	@param $titulo		      Titulo
	*	@param $subTitulo	      Subtitulo
	*	@param $timbre		      Timbre da empresa
	*	@param $corTimbre	  Cor do timbre em RGB
	*	@param $fonteTimbre	  Fonte do timbre
	*	@param $corTitulo	  Cor do titulo do relatorio
	*	@param $fonteTitulo	  Fonte do titulo
	*	@param $corBordaTitulo	  Cor da borda do titulo
	*	@param $corFundoTitulo	  Cor de fundo do titulo
	*	@param $corSubTitulo	  Cor do subtitulo do relatorio
	*	@param $fonteSubTitulo	  Cor do subtitulo
	*	@param $corBordaSubTitulo Cor da borda do subtitulo
	*	@param $corFundoSubTitulo Cor de fundo do subtitulo
	*	@param $nomeSoftware	  Nome da aplicacao
	*	@param $textoPagina	  Texto da página (Rodapé)
	*	@param $numeroPagina	  Numero de pagina
	*	@param $tituloHeader	    Se tem titulo no header
	*	@param $tamanhoColunas	    Tamanho das colunas
	*	@param $textoColunas	    Texto de colunas
	*/
	function setConf( $titulo, $subTitulo, $timbre, $corTimbre, $fonteTimbre, $corTitulo, $fonteTitulo,
			$corBordaTitulo, $corFundoTitulo, $corSubTitulo, $fonteSubTitulo, $corBordaSubTitulo,
			$corFundoSubTitulo, $nomeSoftware, $textoPagina, $numeroPagina,
			$tituloHeader = false, $tamanhoColunas, $textoColunas ) {

		$this->setTitulo( $titulo );
		$this->setSubTitulo( $subTitulo );
		$this->setTimbre( $timbre );

		// seta atributos...
		$this->corTimbre	 = $corTimbre;
		$this->fonteTimbre	 = $fonteTimbre;
		$this->corTitulo	 = $corTitulo;
		$this->fonteTitulo	 = $fonteTitulo;
		$this->corBordaTitulo	 = $corBordaTitulo;
		$this->corFundoTitulo	 = $corFundoTitulo;
		$this->corSubTitulo	 = $corSubTitulo;
		$this->fonteSubTitulo	 = $fonteSubTitulo;
		$this->corBordaSubTitulo = $corBordaSubTitulo;
		$this->corFundoSubTitulo = $corFundoSubTitulo;
		$this->nomeSoftware	 = $nomeSoftware;
		$this->textoPagina	 = $textoPagina;
		$this->numeroPagina	 = $numeroPagina;
		$this->tituloHeader	 = $tituloHeader;
		$this->tamanhoColunas	 = $tamanhoColunas;
		$this->textoColunas	 = $textoColunas;

	}

	/**
	*	getInstancia()
	*	Cria singleton de acesso a PDF
	*/
	function getInstancia() {

		$this->document = new PDF();
		$this->document->setConf( $this->getTimbre(), $this->getTitulo(), $this->getSubTitulo(),
				$this->corTimbre, $this->fonteTimbre, $this->corTitulo, $this->fonteTitulo,
				$this->corBordaTitulo, $this->corFundoTitulo, $this->corSubTitulo,
				$this->fonteSubTitulo, $this->corBordaSubTitulo, $this->corFundoSubTitulo,
				$this->nomeSoftware, $this->textoPagina, $this->numeroPagina,
				$this->tituloHeader, $this->tamanhoColunas, $this->textoColunas );

		
	}

	/**
	*	setSubTitulo( $subTitulo )
	*/
	//function setSubTitulo( $subTitulo ) {

	//	  $this->document->setSubTitulo( $subTitulo );

	//}

}

?>
