<?PHP

/**
*
*   Framework de Relatorio
*
*   Data de Criacao: 19/05/2002
*   Ultima Atualizacao: 07/08/2002
*   Modulo: PDF.php
*	Framework de relatorios
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
*	PDF
*
*   Classe que contem as principais definicoes dos PDF que serao gerados
*   Estende o componente FPDF
*
*/
class PDF extends FPDF {

	var $tituloDoc; 		// Titulo do documento PDF
	var $autorDoc;			// Autor do documento PDF
	var $pdfTitulo; 			// Titulo do documento
	var $pdfSubTitulo;			// Subtitulo do documento
	var $pdfEmpresa;			// Nome da empresa
	var	$pdfLinha1;		// Linha 1
	var $pdfLinha2; 			// Linha 2
	var $pdfLinha3; 			// Linha 3
	var $pdfLogotipo;			// Logotipo da empresa
	var $pdfCorTimbre;			// Cor do timbre
	var $pdfFonteTimbre;		// Fonte do timbre
	var $pdfCorTitulo;			// Cor do titulo do relatorio
	var $pdfFonteTitulo;		// Fonte do titulo
	var $pdfCorBordaTitulo; 	// Cor da borda
	var $pdfCorFundoTitulo; 	// Cor de fundo
	var $pdfCorSubTitulo;		// Cor do subtitulo
	var $pdfFonteSubTitulo; 	// Fonte do subtitulo
	var $pdfCorBordaSubTitulo;	// Cor da borda do subtitulo
	var $pdfCorFundoSubTitulo;	// Cor de fundo do subtitulo
	var $pdfNomeSoftware;		// Nome do software
	var	$pdfTextoPagina;		// Texto da pagina
	var $pdfNumeroPagina;	    // Numero da pagina
	var $widths;		    // Variavel usada para MultiCell em tables...
	var $tituloHeader;	    // Flag de controle de titulo em header...
	var $tamanhoColunas;	    // Tamanho das colunas...
	var $textoColunas;	    // Texto das colunas...

	/**
	*	setTituloDoc( $tituloDoc )
	*	Recebe titulo do documento
	*	@param $tituloDoc	titulo do PDF
	*/
	function setTituloDoc( $tituloDoc = "Relatório Gerado" ) {

		$this->$tituloDoc = $tituloDoc;
		$this->SetTitle( $this->tituloDoc );

	}

	/**
	*	setAutorDoc( $autorDoc )
	*	Recebe autor do documento
	*	@param $autorDoc	autor do PDF
	*/
	function setAutorDoc( $autorDoc = "APOENA" ) {

		$this->$autorDoc = $autorDoc;
		$this->SetAuthor( $this->autorDoc );

	}

	/**
	*	Header()
	*	Metodo sobre-escrito da classe FPDF (Cabeçalho)
	*/
	function Header() {

		// mostra imagem...
		$this->Image( $this->pdfLogotipo, 10, 8, 33 );

		// Mostra Empresa...
		$this->SetFont( $this->pdfFonteTimbre[0], $this->pdfFonteTimbre[1], $this->pdfFonteTimbre[2] );
		$this->SetTextColor( $this->pdfCorTimbre[0], $this->pdfCorTimbre[1], $this->pdfCorTimbre[2] );
		$this->Cell( 35 );
		$this->Cell( 5, 5, $this->pdfEmpresa, 0, 0 );

		// Data...
		$this->Cell( 135 );
		$this->Cell( 5, 5, date( "d/m/Y" ), 0, 1, "R" );

		// Linha 1...
		$this->Cell( 35 );
		$this->Cell( 5, 5, $this->pdfLinha1, 0, 0 );

		// Hora...
		$this->Cell( 135 );
		$this->Cell( 5, 5, date( "H:i" ), 0, 1, "R" );

		// Linha 2...
		$this->Cell( 35 );
		$this->Cell( 5, 5, $this->pdfLinha2, 0, 1 );
		$this->Ln( 10 );

		// Titulo do Relatorio
		$this->SetFont( $this->pdfFonteTitulo[0], $this->pdfFonteTitulo[1], $this->pdfFonteTitulo[2] );
		$this->SetTextColor( $this->pdfCorTitulo[0], $this->pdfCorTitulo[1], $this->pdfCorTitulo[2] );
		$this->SetDrawColor( $this->pdfCorBordaTitulo[0], $this->pdfCorBordaTitulo[1], $this->pdfCorBordaTitulo[2] );
		$this->SetFillColor( $this->pdfCorFundoTitulo[0], $this->pdfCorFundoTitulo[1], $this->pdfCorFundoTitulo[2] );
		$largura = $this->GetStringWidth( $this->pdfTitulo ) + 6;
		$this->SetX( ( 210 - $largura ) / 2 );
		$this->Cell( $largura, 5, $this->pdfTitulo, 1, 1, "C", 1 );

		// Subtitulo do relatorio
		$sTitulo = explode( "*", $this->pdfSubTitulo );
		for ( $indx = 0; $indx < sizeof( $sTitulo ); $indx++ ) {
		  $this->SetFont( $this->pdfFonteSubTitulo[0], $this->pdfFonteSubTitulo[1], $this->pdfFonteSubTitulo[2] );
		  $this->SetTextColor( $this->pdfCorSubTitulo[0], $pdfCorSubTitulo[1], $this->pdfCorSubTitulo[2] );
		  $this->SetDrawColor( $this->pdfCorBordaSubTitulo[0], $this->pdfCorBordaSubTitulo[1], $this->pdfCorBordaSubTitulo[2] );
		  $this->SetFillColor( $this->pdfCorFundoSubTitulo[0], $this->pdfCorFundoSubTitulo[1], $this->pdfCorFundoSubTitulo[2] );
		  $largura = $this->GetStringWidth( $this->pdfSubTitulo ) + 6;
		  $this->SetX( ( 210 - $largura ) / 2 );
		  $this->Cell( $largura, 5, $sTitulo[$indx], 1, 1, "C", 1 );
		  $this->Ln(2);
		}

		// Alterado para imprimir cabecalho de tabelas...
		if ( $this->tituloHeader == true ) {

			// Alterar aqui p/ outros sistemas as fontes e cores do cabecalho...
			$this->setFonte( array( "Arial", "B", 8 ) );
			$this->SetCorTexto( array( 255, 255, 255 ) );
			$this->setCorFundo( array( 102, 153, 0 ) );
			$this->setCorBorda( array( 255, 255, 255 ) );

			for( $indx = 0; $indx < count( $this->textoColunas ); $indx++ )
			$this->Cell( $this->tamanhoColunas[ $indx ], 4,
				$this->textoColunas[ $indx ], 1, 0, "C", 1 );
					$this->Ln();
		}

	}

	/**
	*	Footer()
	*	Metodo sobre-escrito da classe FPDF (Rodapé)
	*/
	function Footer() {

		// Monta rodapé...
		$this->Ln();
		$this->SetY( -10 );
		$this->SetCorTexto( array( 0, 0, 0 ) );
		$this->setCorFundo( array( 255, 255, 255 ) );
		$this->SetFont( "Arial", "I", 8 );
		$this->Cell( 0, 10, $this->pdfNomeSoftware, 0, 0, "L" );
		if ( $this->pdfNumeroPagina == 0 ) // era $this->pdfTextoPagina.$this->PageNo()."/{nb}"
			$this->Cell( 0, 10, $this->pdfTextoPagina.$this->PageNo()."/{nb}", 0, 0, "R" );
		else {
			$this->Cell( 0, 10, $this->pdfTextoPagina.$this->pdfNumeroPagina, 0, 0, "R" );
			$this->pdfNumeroPagina++;
		}
		$this->Ln(20);

	}

	/**
	*	setCorTexto( $corTexto )
	*	Seta cor de texto
	*	@param $corTexto	Cor do texto (RGB)
	*/
	function setCorTexto( $corTexto ) {

		$this->SetTextColor( $corTexto[0], $corTexto[1], $corTexto[2] );

	}

	/**
	*	setCorBorda( $corBorda )
	*	Seta cor de borda
	*	@param $corBorda	Cor da borda (RGB)
	*/
	function setCorBorda( $corBorda ) {

		$this->SetDrawColor( $corBorda[0], $corBorda[1], $corBorda[2] );

	}

	/**
	*	setCorFundo( $corFundo )
	*	Seta cor de fundo
	*	@param $corFundo	Cor de fundo (RGB)
	*/
	function setCorFundo( $corFundo ) {

		$this->SetFillColor( $corFundo[0], $corFundo[1], $corFundo[2] );

	}

	/**
	*	setFonte( $fonte )
	*	Seta fonte
	*	@param $fonte	fonte (array com fonte, estilo, tamanho)
	*/
	function setFonte( $fonte ) {

		$this->SetFont( $fonte[0], $fonte[1], $fonte[2] );

	}

	/**
	*	closeDoc( $arquivo, $flagDownload )
	*	Fecha documento PDF
	*	@param $arquivo 	arquivo que tera a saida
	*	@param $flagDownload	se true permite fazer download automatico
	*/
	function closeDoc( $arquivo, $flagDownload = false ) {

		//$this->Footer();
		$this->Close();
		$this->OutPut( $arquivo, $flagDownload );

	}

	/**
	*	setConf( $timbre, $titulo, $subTitulo, $corTimbre, $fonteTimbre, $corTitulo, 
	*		$fonteTitulo, $corBordaTitulo, $corFundoTitulo, $corSubTitulo, $fonteSubTitulo,
	*		$corBordaSubTitulo, $corFundoSubTitulo, $nomeSoftware, $textoPagina, $numeroPagina,
	*		$tituloHeader = false, $tamanhoColunas, $textoColunas )
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
	*	@param $numeroPagina	    Numero de pagina
	*	@param $tituloHeader	    Se tem titulo no header
	*	@param $tamanhoColunas	    Tamanho das colunas
	*	@param $textoColunas	    Texto de colunas
	*/
	function setConf( $timbre, $titulo, $subTitulo, $corTimbre, $fonteTimbre, $corTitulo, 
				$fonteTitulo, $corBordaTitulo, $corFundoTitulo, $corSubTitulo, $fonteSubTitulo,
				$corBordaSubTitulo, $corFundoSubTitulo, $nomeSoftware, $textoPagina, $numeroPagina = 1,
				$tituloHeader = false, $tamanhoColunas, $textoColunas ) {

		$this->pdfTitulo	    = $titulo;
		$this->pdfSubTitulo	    = $subTitulo;
		$this->pdfEmpresa	    = $timbre[REL_EMPRESA];
		$this->pdfLinha1	    = $timbre[REL_LINHA1];
		$this->pdfLinha2	    = $timbre[REL_LINHA2];
		$this->pdfLinha3	    = $timbre[REL_LINHA3];
		$this->pdfLogotipo	    = $timbre[REL_LOGO];
		$this->pdfCorTimbre	    = $corTimbre;
		$this->pdfFonteTimbre	    = $fonteTimbre;
		$this->pdfCorTitulo	    = $corTitulo;
		$this->pdfFonteTitulo	    = $fonteTitulo;
		$this->pdfCorBordaTitulo    = $corBordaTitulo;
		$this->pdfCorFundoTitulo    = $corFundoTitulo;
		$this->pdfCorSubTitulo	    = $corSubTitulo;
		$this->pdfFonteSubTitulo    = $fonteSubTitulo;
		$this->pdfCorBordaSubTitulo = $corBordaSubTitulo;
		$this->pdfCorFundoSubTitulo = $corFundoSubTitulo;
		$this->pdfNomeSoftware	    = $nomeSoftware;
		$this->pdfTextoPagina	    = $textoPagina;
		$this->pdfNumeroPagina	    = $numeroPagina;
		$this->tituloHeader	    = $tituloHeader;
		$this->tamanhoColunas	    = $tamanhoColunas;
		$this->textoColunas	    = $textoColunas;

	}

	// A partir daqui, codigo incorporado para realizar a quebra de linha em tables
	// Por Olivier e alterado por Guilherme.
    function SetWidths( $w ) {

	  //Set the array of column widths
	  $this->widths=$w;

      }

      function Row( $data, $conf ) {

	  //Calculate the height of the row
	  $nb = 0;

	  for($i=0; $i < count( $data ); $i++ )
		$nb = max( $nb, $this->NbLines( $this->widths[$i], $data[$i] ) );
	  $h  = 3 * $nb;

	  //Issue a page break first if needed
	  $this->CheckPageBreak($h);

	  //Draw the cells of the row
	  for($i=0;$i<count($data);$i++) {

		$w = $this->widths[$i];

		//Save the current position
		$x = $this->GetX();
		$y = $this->GetY();

		//Draw the border
		$this->Rect($x,$y,$w,$h);

		//Print the text
		$this->MultiCell($w,3,$data[$i],$conf[$i][0],$conf[$i][1],$conf[$i][2]);

		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	  }

	//Go to the next line
	$this->Ln($h);

    }

    function CheckPageBreak($h) {

	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt) {

	//Computes the number of lines a MultiCell of width w will take
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb) {
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
    }

	/**
	*	setSubTitulo( $subTitulo )
	*/
	function setSubTitulo( $subTitulo ) {

		$this->pdfSubTitulo	    = $subTitulo;

	}

}
