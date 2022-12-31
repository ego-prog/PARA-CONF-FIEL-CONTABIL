<?PHP

	// Recebe dados da sess�o
	session_start( "cw" );
	$login	    = $loginSession;
	$oidEmpresa = $oidEmpresaSession;

?>

<!--
	FIEL Cont�bil
	Desenvolvido por APOENA Solu��es em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Cria��o: 25/06/2003
	�ltima Atualiza��o: 29/06/2003
	M�dulo: cwAltSenha.php
	  Altera senha de usu�rio
-->
<html>
<head>
<title>::FIEL Cont�bil::</title>


<script language="javascript">

	//--------------------------------------------
	// comparaCampo()
	// - Testa se campos s�o iguais
	//--------------------------------------------
	function comparaCampo( campo1, campo2 ) {

		return ( campo1.value == campo2.value )?true:false;

	}

	//--------------------------------------------
	// validaDados()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaDados() {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- Senha Atual
			if ( testaNulo( document.forms[0].confSenhaAtual ) ) {
				mensagem += '\n - Senha de acesso n�o preenchida';
				retorna = false; }

			// -- Senha Atual
			if ( !comparaCampo( document.forms[0].senhaAtual, document.forms[0].confSenhaAtual ) ) {
				mensagem += '\n - Senha atual digitada � inv�lida';
				retorna = false; }

			// -- Senha
			if ( testaNulo( document.forms[0].senha ) ) {
				mensagem += '\n - Senha de acesso n�o preenchida';
				retorna = false; }

			// -- Compara Senha
			if ( testaNulo( document.forms[0].confSenha ) ) {
				mensagem += '\n - Confirma��o de senha n�o preenchida';
				retorna = false; }

			// -- Senha
			if ( !comparaCampo( document.forms[0].senha, document.forms[0].confSenha ) ) {
				mensagem += '\n - Senhas n�o s�o iguais';
				retorna = false; }

		if ( !retorna ) {
			alert( mensagem );
			document.forms[0].confSenhaAtual.focus(); }

		return retorna;

	}

	//--------------------------------------------
	// testaNulo()
	// - Testa se campo � nulo
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
<link rel="stylesheet" type="text/css" href="./estilo/cw.css">

</head>
<?PHP

	// Inclui pacote da aplicacao...
	include "./classes/cw.inc";

	$cabec = new TituloCw( $cabecTituloAltSenha );
	$cabec->mostra();

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

?>

<body class="pagina" onLoad="this.document.formAltSenha.confSenhaAtual.focus();">

	<div align="center">

	<br><br><br>

	<form action="./admin/cwGravaAdmin.php"
				name="formAltSenha" method="get" onSubmit="return validaDados();">

	<?
		$usuario = new UsuarioCw();
		$usuario->pesquisaInfoAtualizaSenha( $oidEmpresa, $login );
	?>

	<input type="hidden" name="tipoOperacao" value="1">
	<input type="hidden" name="senhaAtual" value="<?= $usuario->getSenha(); ?>">
	<input type="hidden" name="oidUsuario" value="<?= $usuario->getOidUsuario(); ?>">

		<table class="ejanela" width="70%">
		<tr class="ejanela">
		<td>
		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="./imagens/cw_janela.gif" border="0" width="90%" class="tjanela">
				<?PHP echo $tituloAltSenha; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('./cw_ajuda.html#cwAltSenha')">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>

		<!-- Op��es do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoNome; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<?= $usuario->getNome(); ?>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoLogin; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<?= $usuario->getLogin(); ?>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoSenhaAtual; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="password" class="txjanela" name="confSenhaAtual"
							size="12" maxlength="12">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoSenha; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="password" class="txjanela" name="senha"
							size="12" maxlength="12">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoConfirmaSenha; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="password" class="txjanela" name="confSenha"
							size="12" maxlength="12">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right">&nbsp;
				</td>
				<td width="70%" align="left">
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

