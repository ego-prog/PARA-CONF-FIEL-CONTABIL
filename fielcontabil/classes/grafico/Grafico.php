<?PHP

/**
*
*   Framework de Relatorio
*
*   Data de Criacao: 19/01/2004
*   Ultima Atualizacao: 19/01/2004
*   Modulo: GRAF.php
*       Framework de graficos 
*
*   Copyright (C) por APOENA Solucoes em Software Livre
*   http://www.apoenasoftwarelivre.com.br
*
*   @author     Claudimir Zavalik (claudimir@apoenasoftwarelivre.com.br)
*   @version    PHP4
*/

// Arquivo "header" do Framework
include $pathClassesRelatorio."framework_grafico.inc";

/**
*
*	GRAF
*
*   Classe que contem as principais definicoes dos Graficos que serao gerados
*   Estende o componente jpgraph
*
*/
class GRAF extends Graph {

	var $titulo;         	 // Titulo do grafico
	var $subtitulo;        	 // Subtitulo do Grafico
	var $grafCorTitulo;	 // Cor do Titulo do Grafico
	var $grafFonteTitulo;	 // Fonte do Titulo
	var $grafCorSubtitulo;	 // Cor do Subtitulo
	var $grafFonteSubtitulo; // Fonte do Subtitulo;
	
	/**
	*	setTituloGraf( $tituloGraf )
	*	Recebe titulo do Grafico
	*	@param $tituloDoc	titulo do Grafico
	*/
	function setTituloGraf( $tituloGraf = "Grafico Gerado" ) {

		$this->$titulo = $tituloGraf;
		$this->SetTitle( $this->titulo );

	}


	/**
	*	setConf( $timbre, $titulo, $subTitulo, $corTimbre, $fonteTimbre, $corTitulo, 
	*		$fonteTitulo, $corBordaTitulo, $corFundoTitulo, $corSubTitulo, $fonteSubTitulo,
	*		$corBordaSubTitulo, $corFundoSubTitulo, $nomeSoftware, $textoPagina, $numeroPagina )
	*	Seta parametros utilizados no PDF
	*	@param $timbre				Timbre do PDF
	*	@param $titulo				Titulo
	*	@param $subTitulo			SubTitulo
	*	@param $corTimbre			Cor do timbre
	*	@param $fonteTimbre			Fonte do timbre
	*	@param $corTitulo			Cor do titulo
	*	@param $fonteTitulo			Fonte do titulo
	*	@param $corBordaTitulo		Borda do titulo
	*	@param $corFundoTitulo		Fundo do titulo
	*	@param $corSubTitulo		Cor do subtitulo
	*	@param $fonteSubTitulo		Fonte do subtitulo
	*	@param $corBordaSubTitulo	Borda do subtitulo
	*	@param $corFundoSubTitulo	Fundo do subtitulo
	*	@param $nomeSoftware		Nome do Software
	*	@param $textoPagina			Texto da pagina
	*	@param $numeroPagina        Numero de pagina

	function setConf( $timbre, $titulo, $subTitulo, $corTimbre, $fonteTimbre, $corTitulo, 
				$fonteTitulo, $corBordaTitulo, $corFundoTitulo, $corSubTitulo, $fonteSubTitulo,
				$corBordaSubTitulo, $corFundoSubTitulo, $nomeSoftware, $textoPagina, $numeroPagina = 1 ) {
	
		$this->pdfTitulo            = $titulo;
		$this->pdfSubTitulo         = $subTitulo;
		$this->pdfEmpresa           = $timbre[REL_EMPRESA];
		$this->pdfLinha1            = $timbre[REL_LINHA1];
		$this->pdfLinha2            = $timbre[REL_LINHA2];
		$this->pdfLinha3            = $timbre[REL_LINHA3];
		$this->pdfLogotipo          = $timbre[REL_LOGO];		$this->pdfCorTimbre         = $corTimbre;
		$this->pdfFonteTimbre       = $fonteTimbre;
		$this->pdfCorTitulo         = $corTitulo;
		$this->pdfFonteTitulo       = $fonteTitulo;
		$this->pdfCorBordaTitulo    = $corBordaTitulo;
		$this->pdfCorFundoTitulo    = $corFundoTitulo;
		$this->pdfCorSubTitulo      = $corSubTitulo;
		$this->pdfFonteSubTitulo    = $fonteSubTitulo;
		$this->pdfCorBordaSubTitulo = $corBordaSubTitulo;
		$this->pdfCorFundoSubTitulo = $corFundoSubTitulo;
		$this->pdfNomeSoftware      = $nomeSoftware;
		$this->pdfTextoPagina       = $textoPagina;
		$this->pdfNumeroPagina      = $numeroPagina;
		
	}
	*/
	
}
