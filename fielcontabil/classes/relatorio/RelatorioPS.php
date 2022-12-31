<?PHP

/**
*
*   Framework de Relatorio
*
*   Data de Criacao: 20/05/2002
*   Ultima Atualizacao: 02/06/2002
*   Modulo: RelatorioPS.php
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
*	RelatorioPS
*
*   Classe que contem as principais definicoes de relatorios no formato PostScript
*   exibidas nos sistemas
*
*/
class RelatorioPS extends RelatorioHTML {

	var $handler;			// ponteiro para arquivo ps (Handler)
	var $texto;			    // Texto PostScript a ser gerado
	var $numeroPagina;	// Número da página do documento

	/**
	*	novoDocumento( $arqNome = "", $autor = "Apoena PS",
	*					$titulo = "Gerado por classe RelatorioPS",
	*					$orientacao = "Portrait" )
	*	Cria novo documento PostScript
	*	@param $arqNome 	Nome do arquivo
	*	@param $autor		autor do documento
	*	@param $titulo		titulo do documento
	*	@param $orientacao	orientacao do documento
	*/
	function novoDocumento( $arqNome = "", $autor = "Apoena PS",
						$titulo = "Gerado por classe RelatorioPS",
						$orientacao = "Portrait" ) {


		// Se arquivo for preenchido...
		if ( $arqNome ) {
			// Se não conseguiu criar?
			if ( !$this->handler = fopen( $arqNome, "w" ) )
				return false;
		}

		// Seta cabeçalho do documento...
	$this->texto .= "%!PS-Adobe-3.0 \n";
	$this->texto .= "%%Creator: " . $autor . "\n";
	$this->texto .= "%%CreationDate: " . date("d/m/Y, H:i") . "\n";
	$this->texto .= "%%Title: " . $titulo . "\n";
	$this->texto .= "%%PageOrder: Ascend \n";
	$this->texto .= "%%Orientation: " . $orientacao . "\n";
	$this->texto .= "%%EndComments \n";
	$this->texto .= "%%BeginProlog \n";
	$this->texto .= "%%BeginResource: definicoes \n";

		// Se existir arquivo para pontuação...
		if ( file_exists( $pathClassesRelatorio."apoena_pont.ps" ) ) {
			if ( $arqTemporario = join( "", file( $pathClassesRelatorio."apoena_pont.ps" ) ) )
				$this->texto .= $arqTemporario;
		}

		// Termina parte de cabeçalho do PostScript...
	$this->texto .= "%%EndResource \n";
	$this->texto .= "%%EndProlog \n";

	return true;

    }

	/**
	*	inicioPagina( $pagina )
	*	Marca inicio da pagina
	*	@param $pagina		numero de pagina
	*/
	function inicioPagina( $pagina ) {

		// Inicia uma nova página no documento...
		$this->texto .= "%%Page: " . $pagina ." ". $pagina . "\n";
		return true;

	}

	/**
	*	incrementaPagina( $numero = 1 )
	*	Soma numero de pagina do documento
	*	@param $numero		numero de pagina
	*/
	function incrementaPagina( $numero = 1 ) {

		// Soma página no documento...
		return ( $this->numeroPagina = $this->numeroPagina + $numero );

	}

	/**
	*	fimPagina()
	*	Marca fim da pagina
	*/
	function fimPagina() {

		// Marca fim de página no documento...
	$this->texto .= "showpage \n";
	return true;

	}

	/**
	*	fimDocumento()
	*	Marca fim documento
	*	@return $this->texto	Retorna o texto gerado
	*/
	function fimDocumento() {

		// Marca fim de documento...
	$this->texto .= "showpage \n";

		// Se arquivo já criado, inclui conteúdo...
	if( $this->handler ) {
	   fwrite( $this->handler,$this->texto );
	   fclose( $this->handler );
	  }

	return $this->texto;
	}

	/**
	*	desenhaLinha( $xini = 0, $yini = 0,
	*				$xfim = 0, $yfim = 0, $largura = 0 )
	*	Desenha linha no documento
	*	@param $xini	valor x inicial
	*	@param $yini	valor y inicial
	*	@param $xfim	valor x final
	*	@param $lagura	largura da linha
	*/
	function desenhaLinha( $xini = 0, $yini = 0,
							$xfim = 0, $yfim = 0, $largura = 0 ) {

		// Se não passado nenhum parâmetro...
		if ( !$xini || !$yini || !$xfim || !$yfim || !$largura )
			return false;

		// faz a linha no documento...
	$this->texto .= $largura . " setlinewidth  \n";
	$this->texto .= $xini . " " . $yini . " moveto \n";
	$this->texto .= $xfim . " " . $yfim . " lineto \n";
	$this->texto .= "stroke \n";

	return true;
    }

	/**
	*	movePara( $x = 0, $y = 0 )
	*	Move para posicao XY do documento
	*	@param $x	valor x
	*	@param $y	valor y
	*/
	function movePara( $x = 0, $y = 0 ) {

		// Se não passado nenhum parâmetro...
		if ( !$x || !$y )
			return false;

			// move para XY no documento...
		$this->texto .= $x . " " . $y . " moveto \n";

	return false;
	}

	/**
	*	moveParaFonte( $x = 0, $y = 0, $fonte, $tamanho )
	*	Move para posicao XY do documento, trocando a fonte
	*	@param $x		valor x
	*	@param $y		valor y
	*	@param $fonte	fonte utilizada
	*	@param $tamanho tamanho da fonte
	*/
	function moveParaFonte( $x = 0, $y = 0, $fonte, $tamanho  ) {

		// Se não passado nenhum parâmetro...
		if ( !$x || !$y || !$fonte || !$tamanho )
			return false;

		// move para XY no documento, setando a Fonte...
	$this->texto .= $x . " " . $y . " moveto \n";
	$this->texto .= "/" . $fonte . " findfont " . $tamanho . " scalefont setfont \n";

	return true;

	}

	/**
	*	insereArquivo( $arquivo )
	*	Insere arquivo (com imagem) dentro do documento PostScript
	*	@param $arquivo arquivo
	*/
	function insereArquivo( $arquivo = "" ) {

		// Se não passado nenhum parâmetro...
		if ( !$arquivo )
			return false;

		// Se existir arquivo para pontuação...
		if ( $arqTemporario = join( "", file( $arquivo ) ) )
				$this->texto .= $arqTemporario;
		else
			return false;

	return true;
    }

	/**
	*	desenhaRetangulo( $xini = 0, $yini = 0,
	*				$xfim = 0, $yfim = 0, $largura = 0 )
	*	Desenha retangulo no documento
	*	@param $xini	valor x inicial
	*	@param $yini	valor y inicial
	*	@param $xfim	valor x final
	*	@param $lagura	largura da linha
	*/
	function desenhaRetangulo( $xini = 0, $yini = 0,
					$xfim = 0, $yfim = 0, $largura = 0 ) {

		// Se não passado nenhum parâmetro...
		if ( !$xini || !$yini || !$xfim || !$yfim || !$largura )
			return false;

		// faz o retangulo no documento...
	$this->texto .= $largura . " setlinewidth  \n";
		$this->texto .= "newpath \n";
	$this->texto .= $xini . " " . $yini . " moveto \n";
	$this->texto .= $xfim . " " . $yini . " lineto \n";
	$this->texto .= $xfim . " " . $yfim . " lineto \n";
	$this->texto .= $xini . " " . $yfim . " lineto \n";
	$this->texto .= "closepath \n";
	$this->texto .= "stroke \n";

	return true;

	}


	/**
	*	desenhaRetanguloP( $xini = 0, $yini = 0,
	*				$xfim = 0, $yfim = 0, $largura = 0, $preenchimento )
	*	Desenha retangulo  preenchido no documento
	*	@param $xini			valor x inicial
	*	@param $yini			valor y inicial
	*	@param $xfim			valor x final
	*	@param $lagura			largura da linha
	*	@param $preenchimento	preenchimento
	*/
	function desenhaRetanguloP( $xini = 0, $yini = 0,
					$xfim = 0, $yfim = 0, $largura = 0, $preenchimento ) {

		// Se não passado nenhum parâmetro...
		if ( !$xini || !$yini || !$xfim || !$yfim || !$largura || !$preenchimento )
			return false;

		// faz retangulo no documento...
	$this->texto .= $largura . " setlinewidth  \n";
		$this->texto .= "newpath \n";
	$this->texto .= $xini . " " . $yini . " moveto \n";
	$this->texto .= $xfim . " " . $yini . " lineto \n";
	$this->texto .= $xfim . " " . $yfim . " lineto \n";
	$this->texto .= $xini . " " . $yfim . " lineto \n";
	$this->texto .= "closepath \n";
	$this->texto .= "gsave \n";
	$this->texto .= $preenchimento . " setgray  \n";
	$this->texto .= "fill \n";
	$this->texto .= "grestore \n";
	$this->texto .= "stroke \n";

	return true;

	}

	/**
	*	rotaciona( $graus )
	*	Rotaciona "n" graus no texto do documento
	*	@param $graus			graus
	*/
	function rotaciona( $graus ) {

		// Se não passado nenhum parâmetro...
		if ( !$graus )
			return false;

		// Resta graus == 0  ou 360...
		if( ( $graus == "0" ) || ( $graus == "360" ) )
	   $this->texto .= "grestore \n";
	else {
	   $this->texto .= "gsave \n";
	   $this->texto .= $graus . " rotate \n"; }

	return true;

	}

	/**
	*	setaFonte( $fonte, $tamanho )
	*	Define fonte para documento
	*	@param $fonte		fonte
	*	@param $tamanho 	tamanho da fonte
	*/
	function setaFonte( $fonte, $tamanho ) {

		// Se não passado nenhum parâmetro...
		if ( !$fonte || !$tamanho )
			return false;

		$this->texto .=  "/" . $fonte . " findfont " . $tamanho . " scalefont setfont \n";

	return true;

    }

	/**
	*	mostraTexto( $texto )
	*	Exibe texto no documento
	*	@param $texto		texto a ser exibido
	*/
	function mostraTexto( $texto ) {

		// Se não passado nenhum parâmetro...
		if ( !$texto )
			return false;

		$this->texto .=  "(" . $texto . ") show \n";

	return true;

    }

	/**
	*	mostraTextoP( $texto )
	*	Processa o texto, mostrando-o no documento
	*	@param $texto		texto a ser exibido
	*/
	function mostraTextoP( $texto ) {

		// Se não passado nenhum parâmetro...
		if ( !$texto )
			return false;

		eval( "\$texto = \"$texto\";" );
		$this->texto .=  "(" . $texto . ") show \n";

	return true;

    }

	/**
	*	mostraTextoXY( $texto, $x, $y )
	*	Exibe texto na posicao XY no documento
	*	@param $texto		texto a ser exibido
	*	@param $x			valor x
	*	@param $y			valor y
	*/
	function mostraTextoXY( $texto, $x, $y ) {

		// Se não passado nenhum parâmetro...
		if ( !$texto || !$x || !$y )
			return false;

		$this->movePara( $x, $y );
		$this->mostraTexto( $texto );

	return true;

	}

	/**
	*	mostraTextoXYFonte( $texto, $x, $y, $fonte, $tamanho )
	*	Exibe texto na posicao XY no documento
	*	@param $texto		texto a ser exibido
	*	@param $x			valor x
	*	@param $y			valor y
	*	@param $fonte		fonte
	*	@param $tamanho 	tamanho do texto
	*/
	function mostraTextoXYFonte( $texto, $x, $y, $fonte, $tamanho ) {

		// Se não passado nenhum parâmetro...
		if ( !$texto || !$x || !$y || !$fonte || !$tamanho )
			return false;

		$this->setaFonte( $fonte, $tamanho );
		$this->mostraTextoXY( $texto, $x, $y );

	return true;

	}

}

?>
