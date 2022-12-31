<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe os atributos de sessão
	$loginLog	   = $loginSession;
	$numeroIpLog   = $numeroIpSession;
	$oidEmpresaLog = $oidEmpresaSession;
	$oidEmpresa    = $oidEmpresaSession;

	setcookie( "oidEmpresaContCookie", $oidEmpresaCont );
	setcookie( "dataCookie", $dataLanc );

?>

<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 25/06/2003
	Última Atualização: 29/07/2003
	Módulo: cwGravaOperacao.php
	  Facade (controller) de acesso as classes de negocios
-->
<html>
<head>
<title>::FIEL Contábil::</title>

<script language="javascript">

	//--------------------------------------------
	// abreJanela()
	// - Abre a ajuda
	//--------------------------------------------
	function abreJanela( arquivo ) {

		var janela;
		window.open(arquivo, 'janela',
			'toolbar=no,location=no,directories=no,menubar=no,scrollbars=yes');

	}

</script>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="../estilo/cw.css">

</head>

<body class="pagina">

<?PHP

	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	// Mostra mensagem de erro de sessao do CW...
	$cabec = new TituloCw( $cabecRegOperacaoOperacao );
	$cabec->mostra();
	$dia			   = array ( 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 );
	$dia[1] 		   = ( $ano % 4 == 0 )?29:28;

	// Verifica tipo de operacao...
	switch( $tipoOperacao ) {

		// Inclusao de Lancamentos...
		case 1: {
				// Testes do Sistema
				$arquivo = isset($_FILES["arquivoAnexado"]) ? $_FILES["arquivoAnexado"] : FALSE;

				// Formulário postado... executa as ações
				if($arquivo && !empty($arquivoAnexado))
				{
				    // Verifica se o mime-type do arquivo é de imagem
				    if(!eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"]))
				    {
				       $erro[] = "Arquivo em formato inválido! A imagem deve ser jpg, jpeg, bmp, gif ou png. Envie outro arquivo";
				    }
				    else
				    {
				    // Verifica tamanho do arquivo
				    if($arquivo["size"] > TAMANHO_UPLOAD)
				    {
					$erro[] = "Arquivo em tamanho muito grande!	A imagem deve ser de no máximo " . TAMANHO_UPLOAD . " bytes. Envie outro arquivo";
				     }

				    // Para verificar as dimensões da imagem
				    $tamanhos = getimagesize($arquivo["tmp_name"]);

				    // Verifica largura
				    if($tamanhos[0] > LARGURA_UPLOAD)
				    {
				       $erro[] = "Largura da imagem não deve ultrapassar " . LARGURA_UPLOAD . " pixels";
				    }

				    // Verifica altura
				    if($tamanhos[1] > ALTURA_UPLOAD)
				    {
					$erro[] = "Altura da imagem não deve ultrapassar " . ALTURA_UPLOAD . " pixels";
				    }
				 }

				 // Imprime as mensagens de erro
				 if(sizeof($erro))
				 {
				     foreach($erro as $err)
				     {
					 echo " - " . $err . "<BR>";
				     }
				     $strErro  = "<br><center>\n<font face=\"Verdana,Arial\" size=\"1\" color=\"#990000\">\n";
				     $strErro .= $erro ."\n</font>\n</center><br>";
				     $msg = new MsgCw( $msgIncluiLancamento."<br>".$strErro,
							"../imagens/contabil.jpg", "javascript:history.go(-1);" );
				     $msg->mostra();
				 }
			     }

				// Instancia objetos...
				$lancamento	= new Lancamento();
				$lancamento->buscaTotaisDC( $dataLanc, $loginUsuario, $oidEmpresaCont );
				$empresa		= new Empresa();
				$empresa->pesquisaEmpresa( $oidEmpresaCont );
				$conta			= new Conta();
				$orcamento		= new Orcamento();
				$oidConta		= explode( ".", $oidPlano );
				$valor			= strtr( $valor, ",", "." );
				$strWarning	= "&nbsp;";
				$mes			= Data::retornaMes( $dataLanc );
				$ano			= Data::retornaAno( $dataLanc );
				$dataInicial	= "01/".Data::retornaMes( $dataLanc )."/".Data::retornaAno( $dataLanc );
				$mesArray		= $mes - 1;
				$dataFinal		= $dia[$mesArray]."/".Data::retornaMes( $dataLanc )."/".Data::retornaAno( $dataLanc );
				$conta->pesquisaContaSemDV( $oidConta[0] );

				// testa se a conta vai ficar Devedora/Credora
				$saldoConta = $lancamento->buscaSaldoConta( $oidConta[0], date( "d/m/Y" ), "N" );
				if ( $operacao == "D" )
					$novoSaldo	= $saldoConta + $valor;
				else
					$novoSaldo	= $saldoConta - $valor;

				if ( $conta->getCredora() == "N" && $novoSaldo < 0 ) {
					$strErro  = "<br><center>\n<font face=\"Verdana,Arial\" size=\"1\" color=\"#990000\">\n";
					$strErro .= $msgErroContaCredora." - ".$conta->getDescricao()."\n</font>\n</center><br>";
					$msg = new MsgCw( $msgIncluiLancamento."<br>".$strErro,
							"../imagens/contabil.jpg", "javascript:history.go(-1);" );
					$msg->mostra();
					exit;
				}

				if ( $conta->getDevedora() == "N" && $novoSaldo > 0 ) {
					$strErro  = "<br><center>\n<font face=\"Verdana,Arial\" size=\"1\" color=\"#990000\">\n";
					$strErro .= $msgErroContaDevedora." - ".$conta->getDescricao()."\n</font>\n</center><br>";
					$msg = new MsgCw( $msgIncluiLancamento."<br>".$strErro,
							"../imagens/contabil.jpg", "javascript:history.go(-1);" );
					$msg->mostra();
					exit;
				}

				// Se existe contra-partida automatica, testa se vai ficar Devedora/Credora...
				if ( !empty( $contraPartida ) ) {

					$operacaoCP = ( $operacao == "D" )?"C":"D";
					$oidCP		=  explode( ".", $contraPartida );

					$contaCP = new Conta();
					$contaCP->pesquisaContaSemDV( $oidCP[0] );

					// testa se a contra-partida vai ficar Devedora/Credora
					$saldoConta = $lancamento->buscaSaldoConta( $oidCP[0],
								date( "d/m/Y" ), "N" );

					if ( $operacaoCP == "D" )
						$novoSaldo	= $saldoConta + $valor;
					else
						$novoSaldo	= $saldoConta - $valor;

					if ( $contaCP->getCredora() == "N" && $novoSaldo < 0 ) {
						 $strErro  = "<br><center>\n<font face=\"Verdana,Arial\" size=\"1\" color=\"#990000\">\n";
						 $strErro .= $msgErroContaCredora." - ".$contaCP->getDescricao()."\n</font>\n</center><br>";
						 $msg = new MsgCw( $msgIncluiLancamento."<br>".$strErro,
							"../imagens/contabil.jpg", "javascript:history.go(-1);" );
						 $msg->mostra();
						 exit;
					}

					if ( $contaCP->getDevedora() == "N" && $novoSaldo > 0 ) {
						$strErro  = "<br><center>\n<font face=\"Verdana,Arial\" size=\"1\" color=\"#990000\">\n";
						$strErro .= $msgErroContaDevedora." - ".$contaCP->getDescricao()."\n</font>\n</center><br>";
						$msg = new MsgCw( $msgIncluiLancamento."<br>".$strErro,
							"../imagens/contabil.jpg", "javascript:history.go(-1);" );
						$msg->mostra();
						exit;
					}

				}

				$lancamento->setLancamento( $oidEmpresaCont, $dataLanc, date( "d/m/Y" ),
							date( "h:i:s" ), $loginUsuario, "N" );

				// Testa se é um novo lancamento...
				if ( ( $lancamento->getTotalDebito() == 0 ) &&
							( $lancamento->getTotalCredito() == 0 ) ) {
					// Cria o cabecalho do lancamento...
					$lancamento->grava();
				}

				// Busca OID de lancamento...
				$lancamento->buscaOidLancamento( $dataLanc, $loginUsuario, $oidEmpresaCont );

				// Primeiro, manda a imagem anexada, se houver
				$imagem_nome = '';	 // Se não tiver upload de imagem, deixa nullo
				if ( !empty($arquivoAnexado) ) {
				   // Pega a extensão do Arquivo
				   preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
				   // Gera um nome único para a imagem
				   $imagem_nome = md5(uniqid(time())) . "." . $ext[1];
				   // Caminho de onde a imagem ficará
				   $imagem_dir = "../uploads/" . $imagem_nome;
				   // Faz o upload da imagem
				   move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
				}

				// Inclui item de lancamento...
				$resposta = $lancamento->incluiItemLancamento( $lancamento->getOidLancamento(),
										$oidConta[0], $historico, $valor, $operacao, 0, $oidCentroCusto, $imagem_nome );


				// warning!!!!
				// Testa se excedeu o limite orcado previsto para a conta...
				$debitosConta  = $lancamento->buscaMovimentoConta( $oidConta[0], $dataInicial,
													$dataFinal, "N", "D" );
				$creditosConta = $lancamento->buscaMovimentoConta( $oidConta[0], $dataInicial,
													$dataFinal, "N", "C" );

				$saldoConta = $debitosConta - $creditosConta;
				if ( $saldoConta < 0 )
					$saldoConta = $saldoConta * -1;

				$previstoMes = $orcamento->buscaPrevistoMes( $oidEmpresaCont, $mes, $ano, $oidConta[0] );
				if ( ( ( $saldoConta + $valor ) > $previstoMes ) && ( $previstoMes != -1 ) ) {
					$strWarning .= "<br><center>\n<font face=\"Verdana,Arial\" size=\"1\" color=\"#990000\">\n";
					$strWarning .= $msgAvisoExcedeuPrevistoOrcamento."\n<br>".$conta->getDescricao()."</font>\n</center>";
				}

				// Testa se existe contra-partida automatica...
				if ( !empty( $contraPartida ) ) {

					// Inclui lancamento de contra-partida...
					$resposta	= $lancamento->incluiItemLancamento( $lancamento->getOidLancamento(),
											  $oidCP[0], $historico, $valor, $operacaoCP, 0, $oidCentroCusto, $imagem_nome );

					// warning para contra-partida!!!
					// Testa se excedeu o limite orcado previsto para a contra-partida...
					$debitosConta  = $lancamento->buscaMovimentoConta( $oidCP[0], $dataInicial,
													$dataFinal, "N", "D" );
					$creditosConta = $lancamento->buscaMovimentoConta( $oidCP[0], $dataInicial,
													$dataFinal, "N", "C" );

					$saldoConta = $debitosConta - $creditosConta;
					if ( $saldoConta < 0 )
						 $saldoConta = $saldoConta * -1;

					$previstoMes = $orcamento->buscaPrevistoMes( $oidEmpresaCont, $mes, $ano, $oidCP[0] );
					if ( ( ( $saldoConta + $valor ) > $previstoMes ) && ( $previstoMes != -1 ) ) {
					   $strWarning .= "<br><center>\n<font face=\"Verdana,Arial\" size=\"1\" color=\"#990000\">\n";
					   $strWarning .= $msgAvisoExcedeuPrevistoOrcamento."\n<br>".$contaCP->getDescricao()."</font>\n</center>";
					}

				}

				// Testa se for sucesso...
				if ( $resposta )
					$msg = new MsgCw( $msgCodigoLancamento."&nbsp;".$lancamento->getOidLancamento()."<br>".$msgIncluiLancamentoOk.$strWarning,
							"../imagens/contabil.jpg", "javascript:history.go(-1);" );
				else
					$msg = new MsgCw( $msgIncluiLancamento,
							"../imagens/contabil.jpg", "javascript:history.go(-2);" );

				// Busca totais para fechamento...
				$lancamento->buscaTotaisDC( $lancamento->getDataLancamento(),
						$lancamento->getLoginOperador(), $lancamento->getOidEmpresaCont() );


				// testa fechamento de lancamento...
				if ( strcmp($lancamento->getTotalDebito(),$lancamento->getTotalCredito()) == 0 &&
					$lancamento->getTotalDebito() != 0 ) {
						$lancamento->grava( false );
						$strSlip  = "<br><center>\n<font face=\"Verdana,Arial\" size=\"1\">\n";
						$strSlip .= "<a href=\"javascript:abreJanela('cwRegLanc.php?controleNavegacao=2&operacaoJS=1&oidLancamento=".$lancamento->getOidLancamento()."');\">";
						$strSlip .= $msgCliqueAquiVisualizarSlip."</a>\n</font>\n</center>";
						$strVolta = "javascript:history.go(-2)";
						$msg = new MsgCw( $msgCodigoLancamento."&nbsp;".$lancamento->getOidLancamento()."<br>".$msgIncluiLancamentoOk.$strWarning.$strSlip,
							"../imagens/contabil.jpg", "javascript:history.go(-2);" );
				}

				// Exibe mensagem...
				$msg->mostra();

				// seta atributos para LOG
				$descricaoLog = $msgLogIncluiLancamento;
				$complementoLog = $oidEmpresaCont." ".$loginUsuario." ".$dataLanc;

			break; }

		// Exclusao de Lancamentos...
		case 2: {

			// Instancia objeto...
			$lancamento	= new Lancamento();
			$itemLancamento = new ItemLancamento();

			// Testa login...
			if ( $itemLancamento->excluiLancamento( $oidLancamento ) ) {

				$lancamento->setOidLancamento( $oidLancamento );
				if ( $lancamento->exclui() ) {
					$msg = new MsgCw( $msgExcluiLancamentoOk,
						"../imagens/contabil.jpg", "javascript:history.go(-2);" );
				}
				
			}
			else {
					$msg = new MsgCw( $msgExcluiLancamento,
						"../imagens/contabil.jpg", "javascript:history.go(-2);" );
			}

			// Exibe mensagem...
			$msg->mostra();

			// seta atributos para LOG
			$descricaoLog = $msgLogExcluiLancamento;
			$complementoLog = $oidLancamento;

			break; }

		// Alteracao de Lancamentos...
		case 3: {

			// Instancia classe
			$lancamento = new Lancamento();
			$lancamento->pesquisaLancamento( $oidLancamento );

			$lancamento->buscaTotaisDC( $lancamento->getDataLancamento(),
				$lancamento->getLoginOperador(), $lancamento->getOidEmpresaCont() );
			$oidConta = explode( ".", $oidPlano );
			$valor	  = String::removeChar( strtr( $valor, ".", "_" ), "_" );
			$valor	  = strtr( $valor, ",", "." );

			if ( $lancamento->alteraItemLancamento( $oidItemLancamento,
				$lancamento->getOidLancamento(),
				$oidConta[0], $historico, $valor, $operacao, 0, $oidCentroCusto ) ) {
				$msg = new MsgCw( $msgAlteraLancamentoOk,
					"../imagens/contabil.jpg", "javascript:history.go(-2);" );
			}
			else
				$msg = new MsgCw( $msgAlteraLancamento,
					"../imagens/contabil.jpg", "javascript:history.go(-2);" );

			$msg->mostra();

			// Teste para fechamento do lancamento...
			$lancamento->buscaTotaisDC( $lancamento->getDataLancamento(),
					$lancamento->getLoginOperador(), $lancamento->getOidEmpresaCont() );
			if ( $lancamento->getTotalDebito() == $lancamento->getTotalCredito() &&
					$lancamento->getTotalDebito() != 0 ) {
				$lancamento->grava( false );
			}

			// Ajusta lancamento, caso seja necessario...
			$lancamento->ajustaLancamento( $lancamento->getOidLancamento() );

			// seta atributos para LOG
			$descricaoLog = $msgLogAlteraLancamento;
			$complementoLog = $oidLancamento." ".$oidItemLancamento;

			break; }

		// Inclusao de Item de Lancamentos na Alteração de Lancamentos...
		case 4: {
				// Testes do Sistema
				$arquivo = isset($_FILES["arquivoAnexado"]) ? $_FILES["arquivoAnexado"] : FALSE;

				// Formulário postado... executa as ações
				if($arquivo && !empty($arquivoAnexado))
				{
				    // Verifica se o mime-type do arquivo é de imagem
				    if(!eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"]))
				    {
				       $erro[] = "Arquivo em formato inválido! A imagem deve ser jpg, jpeg, bmp, gif ou png. Envie outro arquivo";
				    }
				    else
				    {
				    // Verifica tamanho do arquivo
				    if($arquivo["size"] > TAMANHO_UPLOAD)
				    {
					$erro[] = "Arquivo em tamanho muito grande!	A imagem deve ser de no máximo " . TAMANHO_UPLOAD . " bytes. Envie outro arquivo";
				     }

				    // Para verificar as dimensões da imagem
				    $tamanhos = getimagesize($arquivo["tmp_name"]);

				    // Verifica largura
				    if($tamanhos[0] > LARGURA_UPLOAD)
				    {
				       $erro[] = "Largura da imagem não deve ultrapassar " . LARGURA_UPLOAD . " pixels";
				    }

				    // Verifica altura
				    if($tamanhos[1] > ALTURA_UPLOAD)
				    {
					$erro[] = "Altura da imagem não deve ultrapassar " . ALTURA_UPLOAD . " pixels";
				    }
				 }

				 // Imprime as mensagens de erro
				 if(sizeof($erro))
				 {
				     foreach($erro as $err)
				     {
					 echo " - " . $err . "<BR>";
				     }
				     $strErro  = "<br><center>\n<font face=\"Verdana,Arial\" size=\"1\" color=\"#990000\">\n";
				     $strErro .= $erro ."\n</font>\n</center><br>";
				     $msg = new MsgCw( $msgIncluiLancamento."<br>".$strErro,
							"../imagens/contabil.jpg", "javascript:history.go(-1);" );
				     $msg->mostra();
				 }
			     }

				// Instancia objetos...
				$lancamento	= new Lancamento();
				$lancamento->buscaTotaisDC( $dataLanc, $loginUsuario, $oidEmpresaCont );
				$empresa		= new Empresa();
				$empresa->pesquisaEmpresa( $oidEmpresaCont );
				$conta			= new Conta();
				$orcamento		= new Orcamento();
				$oidConta		= explode( ".", $oidPlano );
				$valor			= strtr( $valor, ",", "." );
				$strWarning	= "&nbsp;";
				$mes			= Data::retornaMes( $dataLanc );
				$ano			= Data::retornaAno( $dataLanc );
				$dataInicial	= "01/".Data::retornaMes( $dataLanc )."/".Data::retornaAno( $dataLanc );
				$mesArray		= $mes - 1;
				$dataFinal		= $dia[$mesArray]."/".Data::retornaMes( $dataLanc )."/".Data::retornaAno( $dataLanc );
				$conta->pesquisaContaSemDV( $oidConta[0] );

				// testa se a conta vai ficar Devedora/Credora
				$saldoConta = $lancamento->buscaSaldoConta( $oidConta[0], date( "d/m/Y" ), "N" );
				if ( $operacao == "D" )
					$novoSaldo	= $saldoConta + $valor;
				else
					$novoSaldo	= $saldoConta - $valor;

				if ( $conta->getCredora() == "N" && $novoSaldo < 0 ) {
					$strErro  = "<br><center>\n<font face=\"Verdana,Arial\" size=\"1\" color=\"#990000\">\n";
					$strErro .= $msgErroContaCredora." - ".$conta->getDescricao()."\n</font>\n</center><br>";
					$msg = new MsgCw( $msgIncluiLancamento."<br>".$strErro,
							"../imagens/contabil.jpg", "javascript:history.go(-1);" );
					$msg->mostra();
					exit;
				}

				if ( $conta->getDevedora() == "N" && $novoSaldo > 0 ) {
					$strErro  = "<br><center>\n<font face=\"Verdana,Arial\" size=\"1\" color=\"#990000\">\n";
					$strErro .= $msgErroContaDevedora." - ".$conta->getDescricao()."\n</font>\n</center><br>";
					$msg = new MsgCw( $msgIncluiLancamento."<br>".$strErro,
							"../imagens/contabil.jpg", "javascript:history.go(-1);" );
					$msg->mostra();
					exit;
				}

				// Se existe contra-partida automatica, testa se vai ficar Devedora/Credora...
				if ( !empty( $contraPartida ) ) {

					$operacaoCP = ( $operacao == "D" )?"C":"D";
					$oidCP		=  explode( ".", $contraPartida );

					$contaCP = new Conta();
					$contaCP->pesquisaContaSemDV( $oidCP[0] );

					// testa se a contra-partida vai ficar Devedora/Credora
					$saldoConta = $lancamento->buscaSaldoConta( $oidCP[0],
								date( "d/m/Y" ), "N" );

					if ( $operacaoCP == "D" )
						$novoSaldo	= $saldoConta + $valor;
					else
						$novoSaldo	= $saldoConta - $valor;

					if ( $contaCP->getCredora() == "N" && $novoSaldo < 0 ) {
						 $strErro  = "<br><center>\n<font face=\"Verdana,Arial\" size=\"1\" color=\"#990000\">\n";
						 $strErro .= $msgErroContaCredora." - ".$contaCP->getDescricao()."\n</font>\n</center><br>";
						 $msg = new MsgCw( $msgIncluiLancamento."<br>".$strErro,
							"../imagens/contabil.jpg", "javascript:history.go(-1);" );
						 $msg->mostra();
						 exit;
					}

					if ( $contaCP->getDevedora() == "N" && $novoSaldo > 0 ) {
						$strErro  = "<br><center>\n<font face=\"Verdana,Arial\" size=\"1\" color=\"#990000\">\n";
						$strErro .= $msgErroContaDevedora." - ".$contaCP->getDescricao()."\n</font>\n</center><br>";
						$msg = new MsgCw( $msgIncluiLancamento."<br>".$strErro,
							"../imagens/contabil.jpg", "javascript:history.go(-1);" );
						$msg->mostra();
						exit;
					}

				}

				$lancamento->setLancamento( $oidEmpresaCont, $dataLanc, date( "d/m/Y" ),
							date( "h:i:s" ), $loginUsuario, "N" );

				// Primeiro, manda a imagem anexada, se houver
				$imagem_nome = '';	 // Se não tiver upload de imagem, deixa nullo
				if ( !empty($arquivoAnexado) ) {
				   // Pega a extensão do Arquivo
				   preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
				   // Gera um nome único para a imagem
				   $imagem_nome = md5(uniqid(time())) . "." . $ext[1];
				   // Caminho de onde a imagem ficará
				   $imagem_dir = "../uploads/" . $imagem_nome;
				   // Faz o upload da imagem
				   move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
				}

				// Inclui item de lancamento...
				$resposta = $lancamento->incluiItemLancamento( $oidLancamento,
										$oidConta[0], $historico, $valor, $operacao, 0, $oidCentroCusto, $imagem_nome );


				// warning!!!!
				// Testa se excedeu o limite orcado previsto para a conta...
				$debitosConta  = $lancamento->buscaMovimentoConta( $oidConta[0], $dataInicial,
													$dataFinal, "N", "D" );
				$creditosConta = $lancamento->buscaMovimentoConta( $oidConta[0], $dataInicial,
													$dataFinal, "N", "C" );

				$saldoConta = $debitosConta - $creditosConta;
				if ( $saldoConta < 0 )
					$saldoConta = $saldoConta * -1;

				$previstoMes = $orcamento->buscaPrevistoMes( $oidEmpresaCont, $mes, $ano, $oidConta[0] );
				if ( ( ( $saldoConta + $valor ) > $previstoMes ) && ( $previstoMes != -1 ) ) {
					$strWarning .= "<br><center>\n<font face=\"Verdana,Arial\" size=\"1\" color=\"#990000\">\n";
					$strWarning .= $msgAvisoExcedeuPrevistoOrcamento."\n<br>".$conta->getDescricao()."</font>\n</center>";
				}

				// Testa se existe contra-partida automatica...
				if ( !empty( $contraPartida ) ) {

					// Inclui lancamento de contra-partida...
					$resposta	= $lancamento->incluiItemLancamento( $lancamento->getOidLancamento(),
											  $oidCP[0], $historico, $valor, $operacaoCP, 0, $oidCentroCusto, $imagem_nome );

					// warning para contra-partida!!!
					// Testa se excedeu o limite orcado previsto para a contra-partida...
					$debitosConta  = $lancamento->buscaMovimentoConta( $oidCP[0], $dataInicial,
													$dataFinal, "N", "D" );
					$creditosConta = $lancamento->buscaMovimentoConta( $oidCP[0], $dataInicial,
													$dataFinal, "N", "C" );

					$saldoConta = $debitosConta - $creditosConta;
					if ( $saldoConta < 0 )
						 $saldoConta = $saldoConta * -1;

					$previstoMes = $orcamento->buscaPrevistoMes( $oidEmpresaCont, $mes, $ano, $oidCP[0] );
					if ( ( ( $saldoConta + $valor ) > $previstoMes ) && ( $previstoMes != -1 ) ) {
					   $strWarning .= "<br><center>\n<font face=\"Verdana,Arial\" size=\"1\" color=\"#990000\">\n";
					   $strWarning .= $msgAvisoExcedeuPrevistoOrcamento."\n<br>".$contaCP->getDescricao()."</font>\n</center>";
					}

				}

				// Testa se for sucesso...
				if ( $resposta )
					$msg = new MsgCw( $msgCodigoLancamento."&nbsp;".$oidLancamento."<br>".$msgIncluiLancamentoOk.$strWarning,
							"../imagens/contabil.jpg", "javascript:history.go(-1);" );
				else
					$msg = new MsgCw( $msgIncluiLancamento,
							"../imagens/contabil.jpg", "javascript:history.go(-2);" );

				// Busca totais para fechamento...
				$lancamento->buscaTotaisDC( $lancamento->getDataLancamento(),
						$lancamento->getLoginOperador(), $lancamento->getOidEmpresaCont() );

  			   // Ajusta lancamento, caso seja necessario...
			   $lancamento->ajustaLancamento( $oidLancamento );

				// testa fechamento de lancamento...
				if ( strcmp($lancamento->getTotalDebito(),$lancamento->getTotalCredito()) == 0 &&
					$lancamento->getTotalDebito() != 0 ) {
						$lancamento->grava( false );
						$strSlip  = "<br><center>\n<font face=\"Verdana,Arial\" size=\"1\">\n";
						$strSlip .= "<a href=\"javascript:abreJanela('cwRegLanc.php?controleNavegacao=2&operacaoJS=1&oidLancamento=".$lancamento->getOidLancamento()."');\">";
						$strSlip .= $msgCliqueAquiVisualizarSlip."</a>\n</font>\n</center>";
						$strVolta = "javascript:history.go(-2)";
						$msg = new MsgCw( $msgCodigoLancamento."&nbsp;".$lancamento->getOidLancamento()."<br>".$msgIncluiLancamentoOk.$strWarning.$strSlip,
							"../imagens/contabil.jpg", "javascript:history.go(-2);" );
				}

				// Exibe mensagem...
				$msg->mostra();

				// seta atributos para LOG
				$descricaoLog = $msgLogIncluiLancamento;
				$complementoLog = $oidEmpresaCont." ".$loginUsuario." ".$dataLanc;

			break; }

	}

	// Registra operacoes no LOG
	$log = new LogCw();
	$log->setLogCw( $oidEmpresaLog, $loginLog,
					 $numeroIpLog, $descricaoLog, $complementoLog );
	$log->grava();

?>

</body>

</html>

