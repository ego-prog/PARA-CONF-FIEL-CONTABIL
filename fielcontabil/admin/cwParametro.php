<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe oid da Empresa
	$oidEmpresa = $oidEmpresaSession;
?>

<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 26/05/2003
	Última Atualização: 22/09/2003
	Módulo: cwParametro.php
	  Parametros do sistema
-->

<html>
<head>
<title>::FIEL Contábil::</title>


<script language="javascript">

	//--------------------------------------------
	// validaDados()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaDados() {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- Empresa
			if ( testaNulo( document.forms[0].cliente ) ) {
				mensagem += '\n - Empresa não preenchida';
				retorna = false; }

			// -- Linha 1
			if ( testaNulo( document.forms[0].linha1 ) ) {
				mensagem += '\n - Linha 1 não preenchida';
				retorna = false; }

			// -- Linha 2
			if ( testaNulo( document.forms[0].linha2 ) ) {
				mensagem += '\n - Linha 2 não preenchida';
				retorna = false; }

			// -- Linha 3
			if ( testaNulo( document.forms[0].linha3 ) ) {
				mensagem += '\n - Linha 3 não preenchida';
				retorna = false; }

			// -- Maximo de dias para limpeza do LOG
			if ( testaNulo( document.forms[0].maximoDias ) ) {
				mensagem += '\n - No. máximo de dias não para limpeza do LOG não preenchido';
				retorna = false; }

		if ( !retorna ) {
			alert( mensagem );
			document.forms[0].cliente.focus(); }

		return retorna;

	}

	//--------------------------------------------
	// testaNulo()
	// - Testa se campo é nulo
	//--------------------------------------------
	function testaNulo( nome_campo ) {

		return ( nome_campo.value.length == 0 )?true:false;

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

</SCRIPT>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="../estilo/cw.css">

</head>

<body class="pagina" onLoad="this.document.formParametro.cliente.focus();">
<?PHP

	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";

	$cabec = new TituloCw( $cabecTituloAtualizaParametro );
	$cabec->mostra();

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	$param = new ParametroCw();
	$param->pesquisaEmpresa( $oidEmpresa );

?>

	<div align="center">

	<br>

	<form action="cwGravaAdmin.php"
				name="formParametro" method="get" onSubmit="return validaDados();">

	<input type="hidden" name="tipoOperacao" value="2">
	<input type="hidden" name="oidEmpresa" value="<?= $oidEmpresa; ?>">

	<!-- Janela -->
	<table class="ejanela" width="80%">
	<tr class="ejanela">
	<td>
		<!-- Janela -->
		<table border="0" width="100%">
			<tr class="ejanela">
			<td background="../imagens/cw_janela.gif" border="0" width="90%" class="tjanela">
			    <?PHP echo $tituloAtualizaParametro; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwParametro')">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>
	</td>
	</tr>
	<tr class="ejanela">
	<td>
		<!-- Opções do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="35%" align="right" class="cjanela">
				  <?PHP echo $campoEmpresa; ?>
				</td>

				<td width="65%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="cliente"
							size="40"
							maxlength="70" value="<?= trim( $param->getEmpresa() ); ?>">
				</td>
			</tr>

			<tr>
				<td width="35%" align="right" class="cjanela">
				  <?PHP echo $campoLinha1; ?>
				</td>

				<td width="65%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="linha1"
							size="40" maxlength="70"
							value="<?= trim( $param->getLinha1() ); ?>">
				</td>
			</tr>

			<tr>
				<td width="35%" align="right" class="cjanela">
				  <?PHP echo $campoLinha2; ?>
				</td>

				<td width="65%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="linha2"
							size="40" maxlength="70"
							value="<?= trim( $param->getLinha2() ); ?>">
				</td>
			</tr>

			<tr>
				<td width="35%" align="right" class="cjanela">
				  <?PHP echo $campoLinha3; ?>
				</td>

				<td width="65%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="linha3"
							size="40" maxlength="70"
							value="<?= trim( $param->getLinha3() ); ?>">
				</td>
			</tr>

			<tr>
				<td width="35%" align="right" class="cjanela">
				  <?PHP echo $campoMaximoDiasLog; ?>
				</td>

				<td width="65%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="maximoDias"
							size="3" maxlength="3"
							value="<?= trim( $param->getMaximoDiasLog() ); ?>">
				</td>
			</tr>

			<tr>
				<td width="35%" align="right">&nbsp;
				</td>
				<td width="65%" align="left">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoAlterar; ?>" name="bt_alterar">
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

</html>

