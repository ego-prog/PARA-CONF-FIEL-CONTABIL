<?PHP

/**
*
*   Framework de Graficos
*
*   Data de Criacao: 19/01/2004
*   Ultima Atualizacao: 19/01/2004
*   Modulo: GraficoBarra2Y.php
*       Framework de grafico
*
*   Copyright (C) por APOENA Solucoes em Software Livre
*   http://www.apoenasoftwarelivre.com.br
*
*   @author     Claudimir Zavalik (claudimir@apoenasoftwarelivre.com.br)
*               Guilherme Lacerda (guilherme@apoenasoftwarelivre.com.br)
*   @version    PHP4
*/

// Arquivo "header" do Framework
include $pathClassesGrafico."framework_grafico.inc";

/**
*
*	GraficoBarra2Y
*
*   Classe que contem as principais definicoes de graficos de barra com duas series
*   a serem exibidos pelos sistemas
*
*/
class GraficoBarra2Y extends AbstractFormat {

	var $document;	        // Singleton de acesso ao Grafico
	var $corTitulo;         // Cor do titulo do grafico
	var $fonteTitulo;       // Fonte do titulo
	var $corSubTitulo;      // Cor do subtitulo do grafico
	var $fonteSubTitulo;    // Fonte do subtitulo

	/**
	*	setConf( $titulo, $subTitulo, $timbre, $corTimbre, $fonteTimbre, $corTitulo, $fonteTitulo,
	*		$corBordaTitulo, $corFundoTitulo, $corSubTitulo, $fonteSubTitulo, $corBordaSubTitulo,
	*		$corFundoSubTitulo, $nomeSoftware, $textoPagina, $numeroPagina )
	*	Seta informacoes necessarias para configuracao do PDF
	*	@param $titulo		      Titulo
	*	@param $subTitulo	      Subtitulo
	*	@param $timbre		      Timbre da empresa
	*	@param $corTimbre   	  Cor do timbre em RGB
	*	@param $fonteTimbre 	  Fonte do timbre
	*	@param $corTitulo   	  Cor do titulo do relatorio
	*	@param $fonteTitulo 	  Fonte do titulo
	*	@param $corBordaTitulo    Cor da borda do titulo
	*	@param $corFundoTitulo    Cor de fundo do titulo
	*	@param $corSubTitulo      Cor do subtitulo do relatorio
	*	@param $fonteSubTitulo    Cor do subtitulo
	*	@param $corBordaSubTitulo Cor da borda do subtitulo
	*	@param $corFundoSubTitulo Cor de fundo do subtitulo
	*	@param $nomeSoftware      Nome da aplicacao
	*	@param $textoPagina       Texto da página (Rodapé)
	*	@param $numeroPagina      Numero de pagina
	*/
	function setConf( $titulo, $subTitulo, $timbre, $corTimbre, $fonteTimbre, $corTitulo, $fonteTitulo,
			$corBordaTitulo, $corFundoTitulo, $corSubTitulo, $fonteSubTitulo, $corBordaSubTitulo,
			$corFundoSubTitulo, $nomeSoftware, $textoPagina, $numeroPagina ) {

		$this->setTitulo( $titulo );
		$this->setSubTitulo( $subTitulo );
		$this->setTimbre( $timbre );
		
		// seta atributos...
		$this->corTimbre         = $corTimbre;
		$this->fonteTimbre       = $fonteTimbre;
		$this->corTitulo         = $corTitulo;
		$this->fonteTitulo       = $fonteTitulo;
		$this->corBordaTitulo    = $corBordaTitulo;
		$this->corFundoTitulo    = $corFundoTitulo;
		$this->corSubTitulo      = $corSubTitulo;
		$this->fonteSubTitulo    = $fonteSubTitulo;
		$this->corBordaSubTitulo = $corBordaSubTitulo;
		$this->corFundoSubTitulo = $corFundoSubTitulo;
		$this->nomeSoftware      = $nomeSoftware;
		$this->textoPagina       = $textoPagina;
		$this->numeroPagina      = $numeroPagina;
		
	}

	/**
	*	getInstancia()
	*	Cria singleton de acesso a GRAF
	*/
	function getInstancia() {

		$this->document = new GRAF();
		$this->document->setConf( $this->getTimbre(), $this->getTitulo(), $this->getSubTitulo(),
				$this->corTimbre, $this->fonteTimbre, $this->corTitulo, $this->fonteTitulo,
				$this->corBordaTitulo, $this->corFundoTitulo, $this->corSubTitulo,
				$this->fonteSubTitulo, $this->corBordaSubTitulo, $this->corFundoSubTitulo,
				$this->nomeSoftware, $this->textoPagina, $this->numeroPagina );


	}

}

?>