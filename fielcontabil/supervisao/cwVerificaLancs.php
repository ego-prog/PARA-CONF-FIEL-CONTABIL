<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe oid da Empresa
	$oidEmpresa = $oidEmpresaSession;

	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";

	// Carrega lista de empresas
	$empresa = new Empresa();
	$listaEmpresas = $empresa->buscaEmpresa( $oidEmpresa, "" );
?>

<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 25/04/2003
	Última Atualização: 29/06/2004
	Módulo: cwVerificaLancs.php
	  Relatório de lancamentos abertos
-->
<html>
<head>
<title>::FIEL Contábil::</title>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="../estilo/cw.css">

</head>

<?PHP

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	if ( empty( $controleNavegacao ) )
		$controleNavegacao = 0;

	 switch( $controleNavegacao ) {

	 default: {

		  $cabec = new TituloCw( $opcaoVerificacaoLanc );
		  $cabec->mostra();
?>
<body class="pagina">

	<div align="center">

	<br><br>

	<form action="cwVerificaLancs.php"
				name="formVerifica" method="get">

	<input type="hidden" name="controleNavegacao" value="1">

		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $opcaoVerificacaoLanc; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>

		<!-- Opções do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="10%" align="right" class="cjanela">&nbsp;
				</td>
				<td align="left" width="90%" class="cjanela">&nbsp;
				</td>
			</tr>

			<tr>
				<td width="10%" align="right" class="cjanela">&nbsp;
				</td>
				<td align="left" width="90%" class="cjanela"><?= $msgVerificacaoLanc; ?>
				</td>
			</tr>

			<tr>
				<td width="10%" align="right" class="cjanela">&nbsp;
				</td>
				<td align="left" width="90%" class="cjanela">&nbsp;
				</td>
			</tr>

			<tr>
				<td width="10%" align="right">&nbsp;
				</td>
				<td width="90%" align="center">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoContinuar; ?>" name="bt_continuar">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
					OnClick="javascript:history.go(-1);">
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

		 $lancamento = new Lancamento();
		 if ( !$lancamento->verificaLancamentosAbertos( $oidEmpresa ) ) {
?>
<body class="pagina">

	<div align="center">
<?
			 $cabec = new TituloCw( $opcaoVerificacaoLanc );
			 $cabec->mostra();

			 $msg = new MsgCw( $msgConsultaInvalidaVerificacaoLanc,
					"../imagens/contabil.jpg", "javascript:history.go(-1);" );
			 $msg->mostra();
			 exit;
?>
	</div>
</body>
<?
		 }

		break; }

  }

?>

</html>
