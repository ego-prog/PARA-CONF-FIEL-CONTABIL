<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe oid da Empresa
	$oidEmpresa = $oidEmpresaSession;
	$perfilUsuario = $perfilUsuarioSession;
	$loginUsuario  = $loginSession;

	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";

	// Carrega lista de empresas
	$empresa = new Empresa();
	$listaEmpresas = $empresa->buscaEmpresa( $oidEmpresa, "", 1, $loginSession );
?>

<!--
	FIEL Cont�bil
	Desenvolvido por APOENA Solu��es em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Cria��o: 25/06/2003
	�ltima Atualiza��o: 13/07/2003
	M�dulo: cwConsOrcamento.php
	  Consulta Acompanhamento de Or�amento
-->
<html>
<head>
<title>::FIEL Cont�bil::</title>


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

	//--------------------------------------------
	// abreAjuda()
	// - Abre a ajuda
	//--------------------------------------------
	function abreAjuda( arquivo ) {

		var janela;
		window.open(arquivo, 'janela',
			'toolbar=no,location=no,directories=no,menubar=no,width=500,height=300');

	}

	//--------------------------------------------
	// consultaExtrato()
	// - Consulta extrato da conta
	//--------------------------------------------
	function consultaExtrato( arquivo ) {

		var janela;
		window.open(arquivo, 'janela',
			'toolbar=no,location=no,directories=no,scrollbars=yes');

	}

	//--------------------------------------------
	// testaNulo()
	// - Testa se campo � nulo
	//--------------------------------------------
	function testaNulo( nome_campo ) {

		return ( nome_campo.value.length == 0 )?true:false;

	}

	//--------------------------------------------
	// validaDados()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaDados( controle ) {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- Ano
			if ( testaNulo( document.forms[0].ano ) ) {
				mensagem += '\n - Ano n�o preenchido';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem );
				document.forms[0].ano.focus(); }

		return retorna;

	}

</SCRIPT>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="../estilo/cw.css">

</head>

<?PHP

	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	if ( empty( $controleNavegacao ) )
		$controleNavegacao = 0;

	 switch( $controleNavegacao ) {

	 default: {

		  $cabec = new TituloCw( $cabecConsOrcamento );
		  $cabec->mostra();
		  $meses = $cabec->getMesExtenso();
?>
<body class="pagina" onLoad="this.document.formConsOrcamento.ano.focus();">

	<div align="center">

	<br><br>

	<form action="cwConsOrcamento.php"
				name="formConsOrcamento" method="get" onSubmit="return validaDados();">

	<input type="hidden" name="controleNavegacao" value="1">


		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloConsOrcamento; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwConsOrcamento')">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>

		<!-- Op��es do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="30%" align="right" class="cjanela"><?PHP echo $campoAno; ?>
				</td>
				<td align="left" width="70%" class="cjanela">
					<input type="text" class="txjanela" name="ano"
						size="4" maxlength="4">
				</td>
				
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela"><?PHP echo $campoMesInicial; ?>
				</td>
				<td align="left" width="70%" class="cjanela">
					<select name="mesInicial" class="dljanela">
					<? for ( $indx = 0; $indx < sizeof( $meses ); $indx++ ) { ?>
					   <option value="<?= $indx + 1; ?>"><?= $meses[$indx]; ?></option>
					<? } ?>
					</select>
				</td>
				
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela"><?PHP echo $campoMesFinal; ?>
				</td>
				<td align="left" width="70%" class="cjanela">
					<select name="mesFinal" class="dljanela">
					<? for ( $indx = 0; $indx < sizeof( $meses ); $indx++ ) { ?>
					   <option value="<?= $indx + 1; ?>"><?= $meses[$indx]; ?></option>
					<? } ?>
					</select>
				</td>
				
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoEmpresa; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="oidEmpresaCont" class="dljanela">
					<? for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) { ?>
					   <option value="<?= $listaEmpresas[$indx][0]; ?>"><?= $listaEmpresas[$indx][1]; ?></option>
					<? } ?>
					</select>
				</td>
			</tr>

			<? if ( $perfilUsuario != "O" && $perfilUsuario != "C" ) { ?>
				<tr>
					<td width="30%" align="right" class="cjanela"><?PHP echo $campoPaginaInicial; ?>
					</td>
					<td align="left" width="70%" class="cjanela">
					<input type="text" class="txjanela" name="paginaInicial"
							size="10" maxlength="10">

					</td>
				</tr>
			<? }
			else
				echo "<input type=\"hidden\" name=\"paginaInicial\" value=\"1\">";
			?>

			<tr>
				<td width="30%" align="right" class="cjanela">&nbsp;
				</td>
				<td align="left" width="70%" class="cjanela">
				   <input type="checkbox" class="cbjanela" name="exibeNaoLiberado"
						value="false"><?= $msgExibeIncluirNaoLiberados; ?>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">&nbsp;
				</td>
				<td align="left" width="70%" class="cjanela">
				   <input type="checkbox" class="cbjanela" name="exibeContador"
						value="false"><?= $msgExibeContador; ?>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right">&nbsp;
				</td>
				<td width="70%" align="left">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoConsultar; ?>" name="bt_consultar">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
					OnClick="javascript:history.go(-1);">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoAjuda; ?>" name="bt_ajuda"
					OnClick="javascript:abreAjuda('../cw_ajuda.html#cwConsOrcamento');">
				</td>
			</tr>

		</table>

	</td>
	</tr>
	</table>

	</form>

	</div>

</body>

<?PHP
	 break;
	 }

	 case 1: {

		 $anoMesInicial = $ano * 100 + $mesInicial;
		 $anoMesFinal	= $ano * 100 + $mesFinal;

		 if ( $anoMesFinal < $anoMesInicial ) {
			echo "<body class=\"pagina\"><center>";
			$msg = new MsgCw( $msgPeriodoInvalido,
				"../imagens/contabil.jpg", "javascript:history.go(-1);" );
			$msg->mostra();
			echo "</center></body>";
			exit;
		 }
		 else {

			 $orcamento = new Orcamento();
			 if ( $orcamento->consultaAcompanhamentoOrcamento( $mesInicial, $mesFinal, $ano,
				$oidEmpresaCont, $oidEmpresa, $paginaInicial, $exibeNaoLiberado,
					$exibeContador, $perfilUsuario ) == false ) {
				echo "<body class=\"pagina\"><center>";
				$msg = new MsgCw( $msgConsultaInvalida,
					"../imagens/contabil.jpg", "javascript:history.go(-1);" );
				$msg->mostra();
				echo "</center></body>";
				exit;
			 }
		}

		break; }

		case 2: {
?>
<body class="pagina">

	<div align="center">
<?
		  $cabec = new TituloCw( $cabecConsOrcamento );
		  $cabec->mostra();

		 $orcamento = new Orcamento();
		 $orcamento->consultaAcompanhamentoOrcamentoPDF( $mesInicial, $mesFinal, $ano,
			$oidEmpresaCont, $oidEmpresa, $paginaInicial, $exibeContador );

		break;
?>
	</div>
</body>
<?
	   }
	   case 3: {
?>
<body class="pagina">

	<div align="center">
<?
		  $cabec = new TituloCw( $cabecConsOrcamento );
		  $cabec->mostra();

		// Exibe mensagem...
		if ( @file( "../pdfs/".PDF_ORCAMENTO ) ) {
			$msg = new MsgCw( $msgCliqueAquiParaVisualizar,
			   "../imagens/contabil.jpg", "javascript:history.go(-2);" );
			   $msg->mostraMsgLink( "../pdfs/".PDF_ORCAMENTO, true );
			   exit;
		}
		else {
			$msg = new MsgCw( $msgDocumentoNaoDisponivel,
				"../imagens/contabil.jpg", "javascript:history.go(-1);" );
				$msg->mostra();
				exit;
		}

		break;
?>
	</div>
</body>
<?
	   }
	 case 4: {

		$lancamento = new Lancamento();
		if ( $lancamento->consultaRazaoAnalitico( $dataInicial, $dataFinal, $oidEmpresaCont, $oidConta,
						$oidEmpresa, 1, $exibeNaoLiberado, false, "O", true ) == false ) {

			$cabec = new TituloCw( $cabecConsOrcamento );
			$cabec->mostra();

			echo "<body class=\"pagina\"><center>";
			$msg = new MsgCw( $msgConsultaInvalida,
								"../imagens/contabil.jpg", "javascript:history.go(-1);" );
			$msg->mostra();
			echo "</center></body>";
			exit;
	   }


		break; }

  }

?>
</html>
