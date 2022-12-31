<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 12/11/2003
*	Modulo: Orcamento.php
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
// include $pathClasses."cw.inc";

/**
*
*	Orcamento
*
*	Classe que contem as principais definicoes de orcamentos anuais
*	da contabilidade no Contabil Web
*
*/
class Orcamento {

	var $oidConta;		  // OID da conta
	var $dv;			  // Digito verificador
	var $ano;			  // Ano
	var $previsto;		  // Previsto nos meses
	var $persistence;	  // Utilizado para persistencia dos objetos

	/**
	*  Orcamento()
	*  Construtor da classe
	*/
	function Orcamento() {

		$this->persistence = new OrcamentoProxy();

	}

	/**
	*	setOrcamento( $oidConta, $ano, $previsto )
	*	Recebe os dados para manipulacao
	*	@param $oidConta		   OID da Conta
	*	@param $ano			   Ano de previsao
	*	@param $previsto		   Previsto
	*/
	function setOrcamento( $oidConta, $ano, $previsto ) {

		$this->setOidConta( $oidConta );
		$this->setAno( $ano );
		$this->setPrevisto( $previsto );

	}

	/**
	*	setOidConta( $oidConta )
	*	Recebe OID de conta
	*	@param $oidConta   OID da conta
	*/
	function setOidConta( $oidConta ) {

		$this->oidConta = $oidConta;

	}

	/**
	*	getOidConta()
	*	Retorna OID de conta
	*	@return $oidConta	 OID da conta
	*/
	function getOidConta() {

		return $this->oidConta;

	}

	/**
	*	setAno( $ano )
	*	Recebe ano
	*	@param $ano	Ano de previsao
	*/
	function setAno( $ano ) {

		$this->ano = trim( $ano );

	}

	/**
	*	getAno()
	*	Retorna Ano de previsao
	*	@return $ano	ano de previsao
	*/
	function getAno() {

		return $this->ano;

	}

	/**
	*	setPrevisto( $previsto )
	*	Recebe valores previstos
	*	@param $previsto		previsto
	*/
	function setPrevisto( $previsto ) {

		$this->previsto = $previsto;

	}

	/**
	*	getPrevistoMes( $posicao )
	*	Retorna valores previstos (especifico)
	*	@param	$posicao				Posicao
	*	@return $previsto[$posicao]	Previsto para mes relativo a posicao
	*/
	function getPrevistoMes( $posicao ) {

		return $this->previsto[$posicao];

	}

	/**
	*	getPrevisto()
	*	Retorna valores previstos
	*	@return $previsto		Previsto
	*/
	function getPrevisto() {

		return $this->previsto;

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
		$this->persistence->setObject( $this->getOidConta(), 
					$this->getAno(),
					$this->getPrevisto() );

		// Se for inclusão...
		if ( $operacao ) 
			$flagGravou = $this->persistence->save();

		// se for alteracao...
		else
			$flagGravou = $this->persistence->update( $this->getOidConta(), $this->getAno() );

		return $flagGravou;

	}

	/**
	*	pesquisaOrcamento( $oidConta, $ano )
	*	Retorna orcamento encontrado
	*	@return true se encontrou orcamento por OID
	*/
	function pesquisaOrcamento( $oidConta, $ano ) {

		// Seta variaveis utilizada no metodo
		$flagAchou = false;

		if ( $this->persistence->findByOid( $oidConta, $ano ) ) {
		   $flagAchou = true;

		   // Retorna objeto
		   $objetoAtual = $this->persistence->getObject();

		   // Seta atributos
		   $this->setOidConta( $objetoAtual[0] );
		   $this->setAno( $objetoAtual[1] );
		   $this->setPrevisto( $objetoAtual[2] );

		}

		// Retorna se encontrou orcamento...
		return $flagAchou;

	}

	/**
	*	buscaOrcamento( $oidEmpresaCont, $ano, $operacao = 1 )
	*	Retorna todos os orcamentos previstos, tanto pelo ano como pela conta
	*	@param	$oidEmpresaCont OID da empresa
	*	@param	$ano			Ano
	*	@param	$operacao		Operacao a ser realizada
	*	@return $orcamentos	orcamentos encontrados
	*/
	function buscaOrcamento( $oidEmpresaCont, $ano, $operacao = 1 ) {

		// Pesquisa orcamentos por criterio de selecao...
		$this->persistence->search( $oidEmpresaCont, $ano, $operacao );

		// retorna orcamentos encontrados...
		return $this->persistence->getList();

	}

	/**
	*	exclui()
	*	Exclui orcamento
	*/
	function exclui() {

		// Exclui orcamento...
		return $this->persistence->delete( $this->getOidConta(), $this->getAno() );

	}

	/**
	*	buscaPrevistoMes( $oidEmpresaCont, $mes, $ano, $oidConta )
	*	Retorna valor previsto no mes e ano, da conta contabil
	*	@param	$oidEmpresaCont OID da empresa
	*	@param	$mes			Mes
	*	@param	$ano			Ano
	*	@param	$oidConta		Conta contabil
	*	@return $valorPrevisto	Valor previsto encontrado
	*/
	function buscaPrevistoMes( $oidEmpresaCont, $mes, $ano, $oidConta ) {

		// Pesquisa lista de orcamento...
		$valorPrevisto = -1;
		$mes		  += 1;
		$listaOrcamento = $this->buscaOrcamento( $oidEmpresaCont, $ano, 2 );

		// Pesquisa orcamentos por criterio de selecao...
		for ( $indy = 0; $indy < sizeof( $listaOrcamento ); $indy++ ) {
			 if ( $oidConta == $listaOrcamento[$indy][0] ) {
				 $valorPrevisto = $listaOrcamento[$indy][$mes];
			 }
		}

		return $valorPrevisto;
	}

	/**
	*	consultaAcompanhamentoOrcamento( $mesInicial, $mesFinal, $ano,
	*				$oidEmpresaCont, $oidEmpresa,
	*					$paginaInicial, $exibeNaoLiberado, $exibeContador,
	*					$perfilUsuario )
	*	Mostra acompanhamento do orcamento, no formato HTML
	*	@param	$mesInicial	  Mes inicial
	*	@param	$mesFinal		  Mes final
	*	@param	$ano			  Ano
	*	@param	$valorAcumulado   flag de valor acumulado
	*	@param	$oidEmpresaCont   OID da empresa contabil
	*	@param	$oidEmpresa	  OID da empresa
	*	@param	$paginaInicial	  Pagina inicial
	*	@param	$exibeNaoLiberado se true, exibe os lancamentos nao liberados pelo contador
	*	@param	$exibeContador	  se true, exibe dados do contador no final
	*	@param	$perfilUsuario	  Perfil do usuario
	*/
	function consultaAcompanhamentoOrcamento( $mesInicial, $mesFinal, $ano,
					$oidEmpresaCont, $oidEmpresa,
					$paginaInicial, $exibeNaoLiberado, $exibeContador,
					$perfilUsuario ) {

		$flagExibeNaoLiberado = ( $exibeNaoLiberado == false )?"S":"N";
		$exibeNaoLiberado	  = ( $exibeNaoLiberado == false )?0:1;

		// Instancia objetos, seta atributos...
		$itemLancamento    = new ItemLancamento();
		$lancamento	   = new Lancamento();
		$empresa		   = new Empresa();
		$conta			   = new Conta();
		$cabec			   = new TituloCw( "" );
		$meses			   = $cabec->getMesExtenso();
		$mesArrayInicial   = $mesInicial - 1;
		$diaInicial	   = 1;
		$mesArrayFinal	   = $mesFinal - 1;
		$diaFinal		   = array ( 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 );
		$diaFinal[1]	   = ( $ano % 4 == 0 )?29:28;

		$empresa->pesquisaEmpresa( $oidEmpresaCont );
		$lista = $conta->buscaConta( $oidEmpresaCont, "" );

		if ( $lista[0][0] == "0" )
		   return false;
		else {

			 // Chama dicionario de internacionalizacao...
			 require "../classes/MessageBundle.properties";

			 $listaOrcamento = $this->buscaOrcamento( $oidEmpresaCont, $ano, 2 );

			 // Seta variaveis auxiliares...
			 $acaoAdicional   = "javascript:window.print();";

			 $voltar		  = $mostra == true?"javascript:history.back();":"javascript:history.back();";

			 $infoAdicionais  = "<input type=\"hidden\" name=\"oidEmpresa\" ";
			 $infoAdicionais .= "value=\"".$oidEmpresa."\">\n";
			 $infoAdicionais .= "<input type=\"hidden\" name=\"oidEmpresaCont\" ";
			 $infoAdicionais .= "value=\"".$oidEmpresaCont."\">\n";
			 $infoAdicionais .= "<input type=\"hidden\" name=\"mesInicial\" ";
			 $infoAdicionais .= "value=\"".$mesInicial."\">\n";
			 $infoAdicionais .= "<input type=\"hidden\" name=\"mesFinal\" ";
			 $infoAdicionais .= "value=\"".$mesFinal."\">\n";
			 $infoAdicionais .= "<input type=\"hidden\" name=\"ano\" ";
			 $infoAdicionais .= "value=\"".$ano."\">\n";
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
			 $cabecalho .= $meses[$mesArrayInicial]." a ".$meses[$mesArrayFinal]."/".$ano."</font><br><br>";

			 // Cria relatorio...
			 $relatorio = new RelatorioHTMLCw( $oidEmpresa,
							$relatorioOrcamento, $cabecalho );

			 // Inicia apresentacao do relatorio...
			 $relatorio->inicioRelatorio();

			 $relatorio->mostraString( "<table width=\"100%\" border=\"0\">" );
			 $relatorio->mostraString( "<tr>" );
			 $relatorio->mostraString( "<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"12%\" class=\"tjanela\">" );
			 $relatorio->mostraString( $relatorioConta );
			 $relatorio->mostraString( "</td>" );
			 $relatorio->mostraString( "<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"40%\" class=\"tjanela\">" );
			 $relatorio->mostraString( $relatorioDescricao );
			 $relatorio->mostraString( "</td>" );
			 $relatorio->mostraString( "<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"12%\" class=\"tjanela\">" );
			 $relatorio->mostraString( $relatorioPrevistoMes );
			 $relatorio->mostraString( "</td>" );
			 $relatorio->mostraString( "<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"12%\" class=\"tjanela\">" );
			 $relatorio->mostraString( $relatorioExecutadoMes );
			 $relatorio->mostraString( "</td>" );
			 $relatorio->mostraString( "<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"12%\" class=\"tjanela\">" );
			 $relatorio->mostraString( $relatorioSaldoFinal );
			 $relatorio->mostraString( "</td>" );
			 $relatorio->mostraString( "<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"12%\" class=\"tjanela\">" );
			 $relatorio->mostraString( $relatorioPercentual );
			 $relatorio->mostraString( "</td>" );

			 $relatorio->mostraString( "</tr>" );

			 $contLinha = 0;

			 if ($mesInicial < 10)
				$mesInicial = "0" . $mesInicial;

			 if ($mesFinal < 10)
				$mesFinal = "0" . $mesFinal;


			 $dataInicial = "01/".$mesInicial."/".$ano;
			 $dataFinal   = $diaFinal[$mesArrayFinal]."/".$mesFinal."/".$ano;

			 // Comeca laco para apresentacao do relatorio...
			 for ( $indx = 0; $indx < sizeof( $lista ); $indx++ ) {

				 $oidConta = explode( ".", $lista[$indx][0] );

				 $debitoPeriodo = $lancamento->buscaMovimentoConta( $oidConta[0], $dataInicial,
													$dataFinal, $flagExibeNaoLiberado, "D" );
				 $creditoPeriodo = $lancamento->buscaMovimentoConta( $oidConta[0], $dataInicial,
													$dataFinal, $flagExibeNaoLiberado, "C" );


				 $saldoPeriodo	 = $debitoPeriodo - $creditoPeriodo;
				 if ( $saldoPeriodo < 0 )
					$saldoPeriodo = $saldoPeriodo * -1;
					$saldoFinal   = $lancamento->buscaSaldoConta( $oidConta[0], $dataFinal, $flagExibeNaoLiberado );

				 // Pesquisa se conta esta prevista no orcamento
				 $mostraOrcamento = false;
				 for ( $indy = 0; $indy < sizeof( $listaOrcamento ); $indy++ ) {
					 if ( $oidConta[0] == $listaOrcamento[$indy][0] ) {
						 $posicao		= $mesInicial + 1;
						 $valorPrevisto = 0;
						 for ( $indz = $posicao; $indz <= $mesFinal + 1; $indz++ )
							$valorPrevisto += $listaOrcamento[$indy][$indz];
						 $mostraOrcamento = true;
					 }
				 }

				 if ( ( $debitoPeriodo != 0 || $creditoPeriodo != 0
						|| $valorPrevisto != 0 ) && $mostraOrcamento ) {

						// Define cor da linha
						$cor = ($contLinha % 2)==0?"lcons1":"lcons2";
						$contLinha++;

					$relatorio->mostraString( "<tr>" );
					$oidContaRazao = $lista[$indx][0];
					$strLink  = "javascript:consultaExtrato('cwConsOrcamento.php?controleNavegacao=4&";
					$strLink .= "dataInicial=$dataInicial&dataFinal=$dataFinal&oidEmpresaCont=$oidEmpresaCont&";
					$strLink .= "oidConta=$oidContaRazao&exibeNaoLiberado=$exibeNaoLiberado');";

					// Codigo Sintetico...
					$relatorio->mostraString( "<td align=\"left\" width=\"12%\" class=\"".$cor."\">" );
					$relatorio->mostraString( "<a href=\"$strLink\">" );
					$relatorio->mostraString( $lista[$indx][1] );
					$relatorio->mostraString( "</a></td>" );

					// Descricao...
					$relatorio->mostraString( "<td align=\"left\" width=\"40%\" class=\"".$cor."\">" );
					$relatorio->mostraString( "<a href=\"$strLink\">" );
					$relatorio->mostraString( $lista[$indx][2] );
					$relatorio->mostraString( "</a></td>" );

					// Previsto Ano...
					$relatorio->mostraString( "<td align=\"right\" width=\"12%\" class=\"".$cor."\">" );
					$relatorio->mostraString( Numero::convReal( $valorPrevisto ) );
					$relatorio->mostraString( "</td>" );

					// Executado no mes...
					$relatorio->mostraString( "<td align=\"right\" width=\"12%\" class=\"".$cor."\">" );
					$relatorio->mostraString( Numero::convReal( $saldoPeriodo ) );
					$relatorio->mostraString( "</td>" );

					// Saldo final...
					$relatorio->mostraString( "<td align=\"right\" width=\"12%\" class=\"".$cor."\">" );
					$relatorio->mostraString( Numero::convReal( $saldoFinal ) );
					$relatorio->mostraString( "</td>" );

					$percentual = 0;
					if ( $valorPrevisto > 0 )
						$percentual = ( $saldoPeriodo / $valorPrevisto ) * 100;

					if ( $percentual > 100 )
						$cor = ($contLinha % 2)==0?"lcons11":"lcons10";
					// %...
					$relatorio->mostraString( "<td align=\"right\" width=\"12%\" class=\"".$cor."\">" );

					$relatorio->mostraString( Numero::convReal( $percentual ) );
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

			 $relatorio->fimRelatorio( "cwConsOrcamento.php", $infoAdicionais, $voltar );

			 return true;

		   } // Fim da decisao de validacao do array

	}

	/**
	*	consultaAcompanhamentoOrcamentoPDF( $mesInicial, $mesFinal, $ano, $oidEmpresaCont, $oidEmpresa, 
	*						$paginaInicial, $exibeContador )
	*	Mostra acompanhamento do orcamento, somente os 
	*				contabilizados, em formato PDF
	*	@param	$mesInicial Mes inicial
	*	@param	$mesFinal		Mes final
	*	@param	$ano		Ano
	*		@param	$oidEmpresaCont OID da empresa contabil
	*	@param	$oidEmpresa OID da empresa
	*	@param	$paginaInicial	Pagina inicial
	*	@param	$exibeContador	Exibe dados do contador
	*/
	function consultaAcompanhamentoOrcamentoPDF( $mesInicial, $mesFinal, $ano, $oidEmpresaCont, $oidEmpresa,
					$paginaInicial, $exibeContador ) {

		// Seta variaveis que possam ser utilizadas...
		$controleLinha	   = 1;
		$flagPreenchido    = false;

		// Instancia objetos, seta atributos...
		$itemLancamento    = new ItemLancamento();
		$lancamento	   = new Lancamento();
		$empresa		   = new Empresa();
		$conta			   = new Conta();
		$cabec			   = new TituloCw( "" );
		$meses			   = $cabec->getMesExtenso();
		$mesArrayInicial   = $mesInicial - 1;
		$diaInicial	   = 1;
		$mesArrayFinal	   = $mesFinal - 1;
		$diaFinal		   = array ( 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 );
		$diaFinal[1]	   = ( $ano % 4 == 0 )?29:28;

		$empresa->pesquisaEmpresa( $oidEmpresaCont );
		$lista = $conta->buscaConta( $oidEmpresaCont, "" );

			$listaOrcamento = $this->buscaOrcamento( $oidEmpresaCont, $ano, 2 );

			// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$larguraColunas = array( 25, 50, 25, 25, 25, 25 );
		$cabecalho	= array( $relatorioConta, $relatorioDescricao,
								$relatorioPrevistoMes, $relatorioExecutadoMes,
								$relatorioSaldoFinal, $relatorioPercentual );

		$totalDebito = $totalCredito = 0.0;

		// Cria relatorio...
		$relatorio = new RelatorioPDFCw( $oidEmpresa, $relatorioOrcamento,
			$oidEmpresaCont." - ".$empresa->getRazaoSocial()." - ".$meses[$mesArrayInicial]." a ".$meses[$mesArrayFinal]."/".$ano,
			$tituloSistema, $campoTextoPagina, $paginaInicial, true, $larguraColunas, $cabecalho );

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

			$relatorio->document->setCorFundo( $relatorio->corFundoTabela );
			$relatorio->document->setCorTexto( $relatorio->corTextoTabela );
			$relatorio->document->setFonte( $relatorio->fonteTextoTabela );

		 if ($mesInicial < 10)
			$mesInicial = "0" . $mesInicial;

		 if ($mesFinal < 10)
			$mesFinal = "0" . $mesFinal;


		 $dataInicial = "01/".$mesInicial."/".$ano;
		 $dataFinal   = $diaFinal[$mesArrayFinal]."/".$mesFinal."/".$ano;

			// Comeca laco para impressao do relatorio...
			for ( $indx = 0; $indx < sizeof( $lista ); $indx++ ) {

				 $oidConta = explode( ".", $lista[$indx][0] );

				 $debitoPeriodo = $lancamento->buscaMovimentoConta( $oidConta[0], $dataInicial,
												$dataFinal, "S", "D" );
				 $creditoPeriodo = $lancamento->buscaMovimentoConta( $oidConta[0], $dataInicial,
												$dataFinal, "S", "C" );


				 $saldoPeriodo	 = $debitoPeriodo - $creditoPeriodo;
				 if ( $saldoPeriodo < 0 )
					$saldoPeriodo = $saldoPeriodo * -1;
					$saldoFinal   = $lancamento->buscaSaldoConta( $oidConta[0], $dataFinal, "S" );

				 // Pesquisa se conta esta prevista no orcamento
				 $mostraOrcamento = false;
				 for ( $indy = 0; $indy < sizeof( $listaOrcamento ); $indy++ ) {
					 if ( $oidConta[0] == $listaOrcamento[$indy][0] ) {
						 $posicao = $mesInicial + 1;
						 $valorPrevisto = 0;
						 for ( $indz = $posicao; $indz <= $mesFinal + 1; $indz++ )
							$valorPrevisto += $listaOrcamento[$indy][$indz];
						 $mostraOrcamento = true;
					 }
				 }

				 if ( ( $debitoPeriodo != 0 || $creditoPeriodo != 0
						|| $valorPrevisto != 0 ) && $mostraOrcamento ) {

					// Controla preenchimento (automato finito - :-)...
					$flagPreenchido = !$flagPreenchido;

					// Imprime os dados...
					$relatorio->document->Cell( $larguraColunas[0],4, $lista[$indx][1],
							"LR", 0, "L", $flagPreenchido );
					$relatorio->document->Cell( $larguraColunas[1],4, $lista[$indx][2],
							"LR", 0, "L", $flagPreenchido );
					$relatorio->document->Cell( $larguraColunas[2],4, Numero::convReal( $valorPrevisto ),
							"LR", 0, "R", $flagPreenchido );
					$relatorio->document->Cell( $larguraColunas[3],4, Numero::convReal( $saldoPeriodo ),
							"LR", 0, "R", $flagPreenchido );
					$relatorio->document->Cell( $larguraColunas[2],4, Numero::convReal( $saldoFinal ),
							"LR", 0, "R", $flagPreenchido );
					$percentual = 0;
					if ( $valorPrevisto > 0 )
						$percentual = ( $saldoPeriodo / $valorPrevisto ) * 100;

					$relatorio->document->Cell( $larguraColunas[2],4, Numero::convReal( $percentual ),
							"LR", 0, "R", $flagPreenchido );

					// Salta linha...
					$relatorio->document->Ln();

					// Incrementa linha...
					$controleLinha++;

					// Se terminou pagina...
					if (false) { // ( $controleLinha > 52 ) {
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
			
		$relatorio->document->closeDoc( "../pdfs/".PDF_ORCAMENTO );

		// Exibe mensagem...
		$msg = new MsgCw( $msgCliqueAquiParaVisualizar,
			   "../imagens/contabil.jpg", "javascript:history.go(-2);" );
		$msg->mostraMsgLink( "../pdfs/".PDF_ORCAMENTO, true );
		exit();

	}
	
}

?>
