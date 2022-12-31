<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 29/10/2003
*	Modulo: ContaDoar.php
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
*	ContaDoar
*
*	Classe que contem as principais definicoes de contas DOAR
*	da contabilidade no Contabil Web
*
*/
class ContaDoar {

	var $oidContaDoar;    // OID da conta DOAR
	var $oidEmpresaCont;  // Codigo da empresa (proprietaria)
	var $descricao;       // Descricao da conta
	var $tipo;	      // Tipo da conta DOAR (Analitica ou Sintetica)
	var $persistence;	  // Utilizado para persistencia dos objetos

	/**
	*  ContaDoar()
	*  Construtor da classe
	*/
	function ContaDoar() {

		$this->persistence = new ContaDoarProxy();

	}

	/**
	*	setContaDoar( $oidEmpresaCont, $descricao, $tipo )
	*	Recebe os dados para manipulacao
	*	@param $oidEmpresaCont	   OID da empresa
	*	@param $descricao	       Descricao da conta
	*	@param $tipo			   Tipo da conta
	*/
	function setContaDoar( $oidEmpresaCont, $descricao, $tipo ) {

		$this->setOidEmpresaCont( $oidEmpresaCont );
		$this->setDescricao( $descricao );
		$this->setTipo( $tipo );

	}

	/**
	*	setOidEmpresaCont( $oidEmpresaCont )
	*	Recebe OID de empresa
	*	@param $oidEmpresaCont	 OID da empresa
	*/
	function setOidEmpresaCont( $oidEmpresaCont ) {

		$this->oidEmpresaCont = $oidEmpresaCont;

	}

	/**
	*	getOidEmpresaCont()
	*	Retorna OID de empresa
	*	@return $oidEmpresaCont    OID da empresa
	*/
	function getOidEmpresaCont() {

		return $this->oidEmpresaCont;

	}

	/**
	*	setOidContaDoar( $oidContaDoar )
	*	Recebe OID de conta DOAR
	*	@param $oidContaDoar   OID da conta DOAR
	*/
	function setOidContaDoar( $oidContaDoar ) {

		$this->oidContaDoar = $oidContaDoar;

	}

	/**
	*	getOidContaDoar()
	*	Retorna OID de conta DOAR
	*	@return $oidContaDoar	 OID da conta DOAR
	*/
	function getOidContaDoar() {

		return $this->oidContaDoar;

	}

	/**
	*	setDescricao( $descricao )
	*	Recebe descricao da conta
	*	@param $descricao	 descricao da conta
	*/
	function setDescricao( $descricao ) {

		$this->descricao = trim( String::upper( $descricao ) );

	}

	/**
	*	getDescricao()
	*	Retorna descricao
	*	@return $descricao		descricao da conta
	*/
	function getDescricao() {

		return $this->descricao;

	}

	/**
	*	setTipo( $tipo )
	*	Recebe tipo da conta
	*	@param $tipo		Tipo de conta
	*/
	function setTipo( $tipo ) {

		$this->tipo = trim( String::upper( $tipo ) );

	}

	/**
	*	getTipo()
	*	Retorna tipo da conta
	*	@return $tipo		Tipo de conta
	*/
	function getTipo() {

		return $this->tipo;

	}

	/**
	*	grava( $operacao = true )
	*	Grava objeto
	*	@param $operacao	Operacao a ser realizada (true = inclusao | false = alteracao)
	*	@return se conseguiu gravar
	*/
	function grava( $operacao = true ) {

		// Seta variaveis utilizada no metodo...
		$flagGravou = false;

		// Seta dados...
		$this->persistence->setObject( $this->getOidEmpresaCont(), $this->getDescricao(), 
					$this->getTipo() );

		// Se for inclusão...
		if ( $operacao )
			$flagGravou = $this->persistence->save();
		// se for alteracao...
		else
			$flagGravou = $this->persistence->update( $this->getOidContaDoar() );

		return $flagGravou;

	}

	/**
	*	pesquisaContaDoar( $oidContaDoar, $oidEmpresaCont )
	*	Retorna conta encontrada
	*	@return true se encontrou conta por OID
	*/
	function pesquisaContaDoar( $oidContaDoar, $oidEmpresaCont = 0 ) {

		// Seta variaveis utilizada no metodo
		$flagAchou = false;

		if ( $this->persistence->findByOid( $oidContaDoar, $oidEmpresaCont ) ) {
		   $flagAchou = true;

		   // Retorna objeto
		   $objetoAtual = $this->persistence->getObject();

		   // Seta atributos
		   $this->setOidContaDoar( $objetoAtual[0] );
		   $this->setOidEmpresaCont( $objetoAtual[1] );
		   $this->setDescricao( $objetoAtual[2] );
		   $this->setTipo( $objetoAtual[3] );

		}

		// Retorna se encontrou conta DOAR...
		return $flagAchou;

	}

	/**
	*	buscaContaDoar( $oidEmpresaCont, $expressao, $operacao = 1 )
	*	Retorna todos as contas DOAR
	*	@param	$oidEmpresaCont OID da empresa
	*	@param	$expressao		Expressao de busca
	*	@param	$operacao	Operacao
	*	@return $contas 	    contas encontradas
	*/
	function buscaContaDoar( $oidEmpresaCont, $expressao, $operacao = 1 ) {

		// Pesquisa contas por criterio de selecao...
		$this->persistence->search( $oidEmpresaCont, $expressao, $operacao );

		// retorna contas encontradas...
		return $this->persistence->getList();

	}

	/**
	*	exclui()
	*	Exclui conta
	*/
	function exclui() {

		// Exclui Conta...
		return $this->persistence->delete( $this->getOidContaDoar() );

	}

	/**
	*	consultaPlanoContasDoar( $oidEmpresaCont, $oidEmpresa, $perfilUsuario )
	*	Mostra consulta de plano de contas DOAR de uma determinada empresa, no formato HTML
	*   @param  $oidEmpresaCont   OID da empresa contabil
	*	@param	$oidEmpresa	  OID da empresa
	*	@param	$perfilUsuario	  Perfil do usuario
	*/
	function consultaPlanoContasDoar( $oidEmpresaCont, $oidEmpresa, $perfilUsuario ) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		
		// Instancia objetos, seta atributos...
		$empresa	   = new Empresa();
		
		$lista	    = $this->buscaContaDoar( $oidEmpresaCont, "" );
		
		$empresa->pesquisaEmpresa( $oidEmpresaCont );
		
		if ( $lista[0][0] == "0" )
		   return false;
		else {

		     // Seta variaveis auxiliares...
		     $acaoAdicional   = "javascript:window.print();";

		     $voltar	      = $mostra == true?"javascript:history.back();":"javascript:history.back();";

		     $infoAdicionais  = "<input type=\"hidden\" name=\"oidEmpresa\" ";
		     $infoAdicionais .= "value=\"".$oidEmpresa."\">\n";
		     $infoAdicionais .= "<input type=\"hidden\" name=\"oidEmpresaCont\" ";
		     $infoAdicionais .= "value=\"".$oidEmpresaCont."\">\n";
		     if ( $perfilUsuario != "O" ) {
				 $infoAdicionais .= "<input type=\"hidden\" name=\"controleNavegacao\" ";
				 $infoAdicionais .= "value=\"2\">\n";
				 $infoAdicionais .= "<input type=\"submit\" name=\"gerar\" class=\"bjanela\" ";
				 $infoAdicionais .= "value=\"".$botaoGerarPDF."\">\n";
			 }
			 else {
				 $infoAdicionais .= "<input type=\"hidden\" name=\"controleNavegacao\" ";
				 $infoAdicionais .= "value=\"3\">\n";
				 $infoAdicionais .= "<input type=\"submit\" name=\"gerar\" class=\"bjanela\" ";
				 $infoAdicionais .= "value=\"".$botaoVisualizarPDF."\">\n";
			 }
		     $infoAdicionais .= "<input type=\"button\" name=\"imprimir\" class=\"bjanela\" ";
		     $infoAdicionais .= "value=\"".$botaoImprimir."\" onClick=\"".$acaoAdicional."\">\n";

		     // Cabecalho...
			 $cabecalho  = "<font face=\"Verdana, Arial\" color=\"#000099\" size=\"2\">";
			 $cabecalho .= $empresa->getOidEmpresaCont()." - ".$empresa->getRazaoSocial();
		     $cabecalho .= "</font><br><br>";

		     // Cria relatorio...
		     $relatorio = new RelatorioHTMLCw( $oidEmpresa,
										$relatorioPlanoContasDoar, $cabecalho );

		     // Inicia apresentacao do relatorio...
		     $relatorio->inicioRelatorio();
			 
			 $relatorio->mostraString( "<table width=\"100%\" border=\"0\">" );
			 $relatorio->mostraString( "<tr>" );
			 $relatorio->mostraString( "<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"40%\" class=\"tjanela\" align=\"left\">" );
			 $relatorio->mostraString( $relatorioConta );
			 $relatorio->mostraString( "</td>" );
			 $relatorio->mostraString( "<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"60%\" class=\"tjanela\" align=\"left\">" );
			 $relatorio->mostraString( $relatorioDescricao );
			 $relatorio->mostraString( "</td></tr>" );

		     // Comeca laco para apresentacao do relatorio...
		     for ( $indx = 0; $indx < sizeof( $lista ); $indx++ ) {

				 // Define cor da linha
				 $cor = ($indx % 2)==0?"lcons1":"lcons2";

				 $relatorio->mostraString( "<tr>" );

				 // Codigo sintetico...
				 $relatorio->mostraString( "<td align=\"left\" width=\"40%\" class=\"".$cor."\">" );
				 $relatorio->mostraString( $lista[$indx][0] );
				 $relatorio->mostraString( "</td>" );

				 // Descricao...
				 $relatorio->mostraString( "<td align=\"left\" width=\"60%\" class=\"".$cor."\">" );
				 $relatorio->mostraString( $lista[$indx][1] );
				 $relatorio->mostraString( "</td>" );

				 $relatorio->mostraString( "</tr>" );

				} // Fim do for indx...

			 // Finaliza relatorio...
		     $relatorio->mostraString( "</table>" );
			 
		     $relatorio->fimRelatorio( "cwConsPlanoDoar.php", $infoAdicionais, $voltar );

		     return true;

	       } // Fim da decisao de validacao do array

	}

	/**
	*	consultaPlanoContasDoarPDF( $oidEmpresaCont, $oidEmpresa )
	*	Mostra consulta de plano de contas DOAR, em formato PDF
	*   @param  $oidEmpresaCont OID da empresa contabil
	*	@param	$oidEmpresa	    OID da empresa
	*/
	function consultaPlanoContasDoarPDF( $oidEmpresaCont, $oidEmpresa ) {

		// Seta variaveis que possam ser utilizadas...
		$controleLinha	   = 1;
		$flagPreenchido    = false;

		// Instancia objetos, seta atributos...
		$empresa	   = new Empresa();
		
		$lista	    = $this->buscaContaDoar( $oidEmpresaCont, "" );
		
		$empresa->pesquisaEmpresa( $oidEmpresaCont );

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";

		$larguraColunas = array( 80, 100 );
		$cabecalho	= array( $relatorioConta, $relatorioDescricao );
		
		// Cria relatorio...
		$relatorio = new RelatorioPDFCw( $oidEmpresa, $relatorioPlanoContasDoar,
			$oidEmpresaCont." - ".$empresa->getRazaoSocial(),
			$tituloSistema, $campoTextoPagina );

		// Gera instancia de documento...
		$relatorio->getInstancia();

		// Seta margens do documento
		$relatorio->document->SetMargins( 10, 10, 10 );
		$relatorio->document->Open();
		$relatorio->document->AliasNbPages();
		$relatorio->document->SetAutoPageBreak( true, 10 );
		$relatorio->document->AddPage();

		// Monta cabecalho da tabela...
		$relatorio->document->setFonte( $relatorio->fonteTituloTabela );
		$relatorio->document->setCorTexto( $relatorio->corTituloTabela );
		$relatorio->document->setCorFundo( $relatorio->corFundoTituloTabela );
		$relatorio->document->setCorBorda( $relatorio->corBordaTabela );

		$relatorio->document->SetLineWidth( .2 );

		for( $indx = 0; $indx < count( $cabecalho ); $indx++ )
		    $relatorio->document->Cell($larguraColunas[ $indx ], 4,
			    $cabecalho[ $indx ], 1, 0, "C", 1 );
		   $relatorio->document->Ln();

		    $relatorio->document->setCorFundo( $relatorio->corFundoTabela );
		    $relatorio->document->setCorTexto( $relatorio->corTextoTabela );
		    $relatorio->document->setFonte( $relatorio->fonteTextoTabela );

		    // Comeca laco para impressao do relatorio...
		    for ( $indx = 0; $indx < sizeof( $lista ); $indx++ ) {

				// Controla preenchimento (automato finito - :-)...
				$flagPreenchido = !$flagPreenchido;

				// Imprime os dados...
				$relatorio->document->Cell( $larguraColunas[0],4, substr( $lista[$indx][0], 0, 29 ),
					    "LR", 0, "L", $flagPreenchido );
				$relatorio->document->Cell( $larguraColunas[1],4, $lista[$indx][1],
					    "LR", 0, "L", $flagPreenchido );

				// Salta linha...
				$relatorio->document->Ln();

				// Incrementa linha...
				$controleLinha++;

				// Se terminou pagina...
				if ( $controleLinha > 60 ) {
					$relatorio->document->AddPage();

					// Monta cabecalho da tabela...
					$relatorio->document->setFonte( $relatorio->fonteTituloTabela );
					$relatorio->document->setCorTexto( $relatorio->corTituloTabela );
					$relatorio->document->setCorFundo( $relatorio->corFundoTituloTabela );
					$relatorio->document->setCorBorda( $relatorio->corBordaTabela );

					$relatorio->document->SetLineWidth( .2 );

					for( $indx = 0; $indx < count( $cabecalho ); $indx++ )
						$relatorio->document->Cell($larguraColunas[ $indx ], 4,
							$cabecalho[ $indx ], 1, 0, "C", 1 );
								$relatorio->document->Ln();

					$relatorio->document->setCorFundo( $relatorio->corFundoTabela );
					$relatorio->document->setCorTexto( $relatorio->corTextoTabela );
					$relatorio->document->setFonte( $relatorio->fonteTextoTabela );

					$controleLinha = 1;

					}
					
				} // Fim do indx

			// Monta cabecalho da tabela...
			$relatorio->document->setFonte( $relatorio->fonteTituloTabela );
			$relatorio->document->setCorTexto( $relatorio->corTituloTabela );
			$relatorio->document->setCorFundo( $relatorio->corFundoTituloTabela );
			$relatorio->document->setCorBorda( $relatorio->corBordaTabela );
			$relatorio->document->SetLineWidth( .2 );
			
			$relatorio->document->setCorFundo( $relatorio->corFundoTabela );
			$relatorio->document->setCorTexto( $relatorio->corTextoTabela );
			$relatorio->document->setFonte( $relatorio->fonteTextoTabela );

		$relatorio->document->closeDoc( "../pdfs/".PDF_PLANO_CONTAS_DOAR );

		// Exibe mensagem...
		$msg = new MsgCw( $msgCliqueAquiParaVisualizar,
		       "../imagens/contabil.jpg", "javascript:history.go(-2);" );
		$msg->mostraMsgLink( "../pdfs/".PDF_PLANO_CONTAS_DOAR, true );
		exit();

	}

	/**
	*	buscaSaldoContaDoar( $oidContaDoar, $dataInicial, $dataFinal,
	*			     $contabilizado, $oidEmpresaCont )
	*	Retorna saldo da conta DOAR, em um periodo, considerando
	*		lancamentos contabilizados ou nao
	*	@param	$oidContaDoar	  OID da conta DOAR
	*	@param	$dataInicial	  Data inicial
	*	@param	$dataFinal	  Data final
	*	@param	$contabilizado	  Contabilizado (default = S)
	*	@param	$oidEmpresaCont   OID da empresa contábil
	*	@return $saldoConta	  saldo da conta
	*/
	function buscaSaldoContaDoar( $oidContaDoar, $dataInicial,
					$dataFinal, $contabilizado = "S", $oidEmpresaCont ) {

		$saldoDebito  = 0;
		$saldoCredito = 0;

		$saldoDebito  = $this->persistence->searchSaldoContaDoar( $oidContaDoar,
				    $dataInicial, $dataFinal, $contabilizado, "D", $oidEmpresaCont );

		$saldoCredito = $this->persistence->searchSaldoContaDoar( $oidContaDoar,
				    $dataInicial, $dataFinal, $contabilizado, "C", $oidEmpresaCont );

		return ( $saldoDebito - $saldoCredito );

	}

	/**
	*	consultaDoar( $dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, 
	*					$paginaInicial, $exibeNaoLiberado, $exibeContador, 
	*					$perfilUsuario )
	*	Mostra demonstrativo de origem e aplicação de recursos, no formato HTML
	*	@param	$dataInicial	  Data inicial
	*	@param	$dataFinal	      Data final
	*   @param  $oidEmpresaCont   OID da empresa contabil
	*	@param	$oidEmpresa	  OID da empresa
	*	@param	$paginaInicial	  Pagina inicial
	*	@param	$exibeNaoLiberado se true, exibe os lancamentos nao liberados pelo contador
	*	@param	$exibeContador	  se true, exibe dados do contador no final
	*	@param	$perfilUsuario	  Perfil do usuario
	*/
	function consultaDoar( $dataInicial, $dataFinal, $oidEmpresaCont, 
				$oidEmpresa, $paginaInicial = 1, $exibeNaoLiberado, $exibeContador,
					$perfilUsuario ) { 
		
		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$flagExibeNaoLiberado = ( $exibeNaoLiberado == false )?"S":"N";

		// Instancia objetos, seta atributos...
		$empresa = new Empresa();
		$empresa->pesquisaEmpresa( $oidEmpresaCont );
		$lista = $this->buscaContaDoar( $oidEmpresaCont, "", 4 );

		if ( $lista[0][0] == "0" )
		   return false;
		else {

		     // Seta variaveis auxiliares...
		     $acaoAdicional   = "javascript:window.print();";

		     $voltar	      = $mostra == true?"javascript:history.back();":"javascript:history.back();";

		     $infoAdicionais  = "<input type=\"hidden\" name=\"oidEmpresa\" ";
		     $infoAdicionais .= "value=\"".$oidEmpresa."\">\n";
		     $infoAdicionais .= "<input type=\"hidden\" name=\"oidEmpresaCont\" ";
		     $infoAdicionais .= "value=\"".$oidEmpresaCont."\">\n";
		     $infoAdicionais .= "<input type=\"hidden\" name=\"dataInicial\" ";
		     $infoAdicionais .= "value=\"".$dataInicial."\">\n";
		     $infoAdicionais .= "<input type=\"hidden\" name=\"dataFinal\" ";
		     $infoAdicionais .= "value=\"".$dataFinal."\">\n";
		     $infoAdicionais .= "<input type=\"hidden\" name=\"paginaInicial\" ";
		     $infoAdicionais .= "value=\"".$paginaInicial."\">\n";
		     $infoAdicionais .= "<input type=\"hidden\" name=\"exibeNaoLiberado\" ";
		     $infoAdicionais .= "value=\"".$exibeNaoLiberado."\">\n";
		     $infoAdicionais .= "<input type=\"hidden\" name=\"exibeContador\" ";
		     $infoAdicionais .= "value=\"".$exibeContador."\">\n";
		     if ( $perfilUsuario != "O" ) {
				 $infoAdicionais .= "<input type=\"hidden\" name=\"controleNavegacao\" ";
				 $infoAdicionais .= "value=\"2\">\n";
				 $infoAdicionais .= "<input type=\"submit\" name=\"gerar\" class=\"bjanela\" ";
				 $infoAdicionais .= "value=\"".$botaoGerarPDF."\">\n";
			 }
			 else {
				 $infoAdicionais .= "<input type=\"hidden\" name=\"controleNavegacao\" ";
				 $infoAdicionais .= "value=\"3\">\n";
				 $infoAdicionais .= "<input type=\"submit\" name=\"gerar\" class=\"bjanela\" ";
				 $infoAdicionais .= "value=\"".$botaoVisualizarPDF."\">\n";
			 }
		     $infoAdicionais .= "<input type=\"button\" name=\"imprimir\" class=\"bjanela\" ";
		     $infoAdicionais .= "value=\"".$botaoImprimir."\" onClick=\"".$acaoAdicional."\">\n";

		     // Cabecalho...
		     $cabecalho  = "<font face=\"Verdana, Arial\" color=\"#000099\" size=\"2\">";
		     $cabecalho .= $empresa->getOidEmpresaCont()." - ".$empresa->getRazaoSocial();
		     $cabecalho .= "<br>";
		     $cabecalho .= $dataInicial." - ".$dataFinal."</font><br><br>";

		     // Cria relatorio...
		     $relatorio = new RelatorioHTMLCw( $oidEmpresa,
							 $relatorioDoar, $cabecalho );

		     // Inicia apresentacao do relatorio...
		     $relatorio->inicioRelatorio();

			 $relatorio->mostraString( "<table width=\"100%\" border=\"0\">" );
		     $relatorio->mostraString( "<tr>" );
		     $relatorio->mostraString( "<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"30%\" class=\"tjanela\">" );
		     $relatorio->mostraString( $relatorioConta );
		     $relatorio->mostraString( "</td>" );
		     $relatorio->mostraString( "<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"40%\" class=\"tjanela\">" );
		     $relatorio->mostraString( $relatorioDescricao );
		     $relatorio->mostraString( "</td>" );
		     $relatorio->mostraString( "<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"30%\" class=\"tjanela\">" );
		     $relatorio->mostraString( $relatorioSaldoFinal );
		     $relatorio->mostraString( "</td>" );
		     $relatorio->mostraString( "</tr>" );

		     $contLinha = 0;
		     // Comeca laco para apresentacao do relatorio...
		     for ( $indx = 0; $indx < sizeof( $lista ); $indx++ ) {

				$saldo = $this->buscaSaldoContaDoar( $lista[$indx][1], $dataInicial,
								$dataFinal, $contabilizado, $oidEmpresaCont );

				if ( $saldo != 0 ) {
					// Define cor da linha
					$cor = ($contLinha % 2)==0?"lcons1":"lcons2";
					$contLinha++;

					$relatorio->mostraString( "<tr>" );

					// Codigo Sintetico...
					$relatorio->mostraString( "<td align=\"left\" width=\"15%\" class=\"".$cor."\">" );
					$relatorio->mostraString( $lista[$indx][1] );
					$relatorio->mostraString( "</td>" );

					// Descricao...
					$relatorio->mostraString( "<td align=\"left\" width=\"45%\" class=\"".$cor."\">" );
					$relatorio->mostraString( $lista[$indx][2] );
					$relatorio->mostraString( "</td>" );

					// Saldo...
					$relatorio->mostraString( "<td align=\"right\" width=\"20%\" class=\"".$cor."\">" );
					$relatorio->mostraString( Numero::convReal( $saldo, true ) );
					$relatorio->mostraString( "</td>" );

					$relatorio->mostraString( "</tr>" );
					
				}
				
			} // Fim do indx...

			 // Finaliza relatorio...
		     $relatorio->mostraString( "</table>" );
			 
			 if ( !empty( $exibeNaoLiberado ) && $exibeNaoLiberado ) {
				 $relatorio->mostraString( "<br><table class=\"pagina\" border=\"0\" width=\"100%\">" );
				 $relatorio->mostraString( "<tr><td width=\"100%\" align=\"left\" class=\"lcons11\">" );
				 $relatorio->mostraString( $msgConsLancamentosNaoLiberados );
				 $relatorio->mostraString( "</td></tr></table><br>" );
			 }

			 // Testa se precisa exibir dados do contador...
			 if ( !empty( $exibeContador ) && $exibeContador ) { 
				 $relatorio->mostraString( "<br><table class=\"pagina\" border=\"0\" width=\"100%\">" );
				 $relatorio->mostraString( "<tr><td width=\"100%\" align=\"center\" class=\"lcons2\">" );
				 $relatorio->mostraString( $empresa->getNomeContador() );
				 $relatorio->mostraString( "</td></tr><tr><td width=\"100%\" align=\"center\" class=\"lcons2\">" );
				 $relatorio->mostraString( $empresa->getRegistroContador() );
				 $relatorio->mostraString( "</td></tr></table><br><br>" );
			 }

		     $relatorio->fimRelatorio( "cwConsDoar.php", $infoAdicionais, $voltar );

		     return true;

	       } // Fim da decisao de validacao do array

	}

	/**
	*	consultaDoarPDF( $dataInicial, $dataFinal, $oidEmpresaCont,
	*						$oidEmpresa, $paginaInicial = 1, $exibeContador )
	*	Mostra consulta de demonstrativo de origem e aplicação de recursos 
	*				contabilizados, em formato PDF
	*	@param	$dataInicial	Data inicial
	*	@param	$dataFinal	    Data final
	*   @param  $oidEmpresaCont OID da empresa contabil
	*	@param	$oidEmpresa	    OID da empresa
	*	@param	$paginaInicial	Pagina inicial
	*	@param	$exibeContador	Exibe dados do contador
	*/
	function consultaDoarPDF( $dataInicial, $dataFinal, $oidEmpresaCont, 
				$oidEmpresa, $paginaInicial, $exibeContador ) {

		// Seta variaveis que possam ser utilizadas...
		$controleLinha	   = 1;
		$flagPreenchido    = false;

		// Instancia objetos, seta atributos...
		$empresa	   = new Empresa();

		$empresa->pesquisaEmpresa( $oidEmpresaCont );
		$lista = $this->buscaContaDoar( $oidEmpresaCont, "", 4 ); 

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$larguraColunas = array( 50, 100, 30 );
		$cabecalho	= array( $relatorioCodigo, $relatorioDescricao, 
								$relatorioSaldoFinal );
		
		// Cria relatorio...
		$relatorio = new RelatorioPDFCw( $oidEmpresa, $relatorioDoar,
			$oidEmpresaCont." - ".$empresa->getRazaoSocial()." - ".$dataInicial." a ".$dataFinal,
			$tituloSistema, $campoTextoPagina, $paginaInicial );

		// Gera instancia de documento...
		$relatorio->getInstancia();

		// Seta margens do documento
		$relatorio->document->SetMargins( 10, 10, 10 );
		$relatorio->document->Open();
		$relatorio->document->AliasNbPages();
		$relatorio->document->SetAutoPageBreak( true, 10 );
		$relatorio->document->AddPage();

		// Monta cabecalho da tabela...
		$relatorio->document->setFonte( $relatorio->fonteTituloTabela );
		$relatorio->document->setCorTexto( $relatorio->corTituloTabela );
		$relatorio->document->setCorFundo( $relatorio->corFundoTituloTabela );
		$relatorio->document->setCorBorda( $relatorio->corBordaTabela );

		$relatorio->document->SetLineWidth( .2 );

		for( $indx = 0; $indx < count( $cabecalho ); $indx++ )
		   $relatorio->document->Cell($larguraColunas[ $indx ], 4,
				$cabecalho[ $indx ], 1, 0, "C", 1 );
		   $relatorio->document->Ln();
			
		    $relatorio->document->setCorFundo( $relatorio->corFundoTabela );
		    $relatorio->document->setCorTexto( $relatorio->corTextoTabela );
		    $relatorio->document->setFonte( $relatorio->fonteTextoTabela );

			$somaDebito = $somaCredito = 0;
			// Comeca laco para impressao do relatorio...
		    for ( $indx = 0; $indx < sizeof( $lista ); $indx++ ) {

					// Controla preenchimento (automato finito - :-)...
					$flagPreenchido = !$flagPreenchido;

					$saldo = $this->buscaSaldoContaDoar( $lista[$indx][1], $dataInicial, 
								$dataFinal, $contabilizado, $oidEmpresaCont );

					// Imprime os dados...
					$relatorio->document->Cell( $larguraColunas[0],4, $lista[$indx][1],
						    "LR", 0, "L", $flagPreenchido );
					$relatorio->document->Cell( $larguraColunas[1],4, $lista[$indx][2],
						    "LR", 0, "L", $flagPreenchido );
					$relatorio->document->Cell( $larguraColunas[2],4, Numero::convReal( $saldo, true ),
								"LR", 0, "R", $flagPreenchido );

					// Salta linha...
					$relatorio->document->Ln();

					// Incrementa linha...
					$controleLinha++;

					// Se terminou pagina...
					if ( $controleLinha > 52 ) {
						$relatorio->document->AddPage();

						// Monta cabecalho da tabela...
						$relatorio->document->setFonte( $relatorio->fonteTituloTabela );
						$relatorio->document->setCorTexto( $relatorio->corTituloTabela );
						$relatorio->document->setCorFundo( $relatorio->corFundoTituloTabela );
						$relatorio->document->setCorBorda( $relatorio->corBordaTabela );

						$relatorio->document->SetLineWidth( .2 );

						for( $indx = 0; $indx < count( $cabecalho ); $indx++ )
							$relatorio->document->Cell($larguraColunas[ $indx ], 4,
								$cabecalho[ $indx ], 1, 0, "C", 1 );
									$relatorio->document->Ln();

						$relatorio->document->setCorFundo( $relatorio->corFundoTabela );
						$relatorio->document->setCorTexto( $relatorio->corTextoTabela );
						$relatorio->document->setFonte( $relatorio->fonteTextoTabela );

						$controleLinha = 1;
						} 

				} // Fim do indx...

			// Testa se tem que colocar dados da contadora...
			if ( !empty( $exibeContador ) && $exibeContador ) {
				$relatorio->document->Ln();
				$relatorio->document->Ln();
				$relatorio->document->setCorTexto( $relatorio->corTextoTabela );
				$relatorio->document->setFonte( $relatorio->fonteTextoTabela );
				$relatorio->document->Cell( 0,10,
				$empresa->getNomeContador()." - ".$empresa->getRegistroContador(), 
					0, 1, "C", 0 );
					$relatorio->document->Ln();
			}

		$relatorio->document->setCorFundo( $relatorio->corFundoTabela );
		$relatorio->document->setCorTexto( $relatorio->corTextoTabela );
		$relatorio->document->setFonte( $relatorio->fonteTextoTabela );
			
		$relatorio->document->closeDoc( "../pdfs/".PDF_DOAR );

		// Exibe mensagem...
		$msg = new MsgCw( $msgCliqueAquiParaVisualizar,
		       "../imagens/contabil.jpg", "javascript:history.go(-2);" );
		$msg->mostraMsgLink( "../pdfs/".PDF_DOAR, true );
		exit();

	}
	
}

?>
