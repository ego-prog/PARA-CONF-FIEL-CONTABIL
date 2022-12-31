<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 26/05/2003
	Última Atualização: 26/05/2003
	Módulo: cwLogin.php
	  Login do usuário
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

			// -- Login
			if ( testaNulo( document.forms[0].login ) ) {
				mensagem += '\n - Login não preenchido';
				retorna = false; }

			// -- Senha
			if ( testaNulo( document.forms[0].senha ) ) {
				mensagem += '\n - Senha não preenchida';
				retorna = false; }

		if ( !retorna ) {
			alert( mensagem );
			document.forms[0].login.focus(); }

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
	// abreJanela()
	// - Abre a ajuda
	//--------------------------------------------
	function abreJanela( arquivo ) {

		var janela;
		window.open(arquivo, 'janela',
			'toolbar=no,location=no,directories=no,menubar=no,scrollbars=yes,resizable=yes');

	}

	//--------------------------------------------
	// abreAjuda()
	// - Abre ajuda
	//--------------------------------------------
	function abreAjuda( arquivo ) {

		var janela;
		window.open(arquivo, 'janela',
			'toolbar=no,location=no,directories=no,menubar=no,width=500,height=300');

	}

</SCRIPT>

<?PHP

	// Inclui as classes...
	include "classes/cwLogin.inc";

?>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="estilo/cw.css">

</head>

<body class="pagina" onLoad="this.document.formLogin.login.focus();">

	<div align="center">

	<br>
		<center>
			<a href="javascript:abreJanela('sobre.php');"><img src="imagens/contabil.jpg" width="200" border="0"></a>
		</center>

	<table border="0" width="60%">
	<tr>
		<td width="100%" align="center">

			<form name="formLogin" action="index.php" method="post" onSubmit="return validaDados();">

				<!-- Janela -->
				<table class="ejanela" border="0" width="80%">
				<tr class="ejanela">
					<td>
					<table class="cjanela" border="0" width="100%">
					<tr>
						<td background="./imagens/cw_janela.gif" border="0" width="90%" class="tjanela"><?PHP echo $tituloJanelaLogin; ?>
						</td>
						<td background="./imagens/cw_janela.gif" border="0" width="10%" align="center">
							<input type="button" class="btitulo"
								name= "bt_ajuda" value="<?PHP echo $botaoAjudaJanela; ?>"
								OnClick="javascript:abreAjuda( 'cw_ajuda.html#cwLogin' );">
						</td>
					</tr>
					</table>
					</td>
				</tr>
				<tr>
					<td>

					<!-- Dados para acesso ao sistema -->
					<table width="100%" class="cjanela">

						<tr>
							<td width="30%" align="right" class="cjanela">
								<?PHP echo $campoLogin; ?>
							</td>

							<td width="70%" align="left" class="cjanela">
								<input type="text" class="txjanela" name="login"
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
							<td width="30%" align="right">&nbsp;
							</td>
							<td width="70%" align="left">
								<input type="submit" class="bjanela" value="<?PHP echo $botaoEntrar; ?>" name="bt_entrar">
								<input type="button" class="bjanela"
								value="<?PHP echo $botaoAjuda; ?>" name="bt_ajuda"
								OnClick="javascript:abreAjuda( 'cw_ajuda.html#cwLogin' );">
							</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>
			</form>
		</td>

	</tr>

	</table>

	</div>

</body>

</html>
