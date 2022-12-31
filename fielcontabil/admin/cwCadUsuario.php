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

	Data de Criação: 25/06/2003
	Última Atualização: 29/06/2003
	Módulo: cwCadUsuario.php
	  Cadastro de Usuários
-->

<html>
<head>
<title>::FIEL Contábil::</title>


<script language="javascript">

	//--------------------------------------------
	// validaSelecaoItem()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaSelecaoItem( opcao ) {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- Titulo da Consulta
			if ( document.forms[0].oidUsuario.selectedIndex == -1 ) {
				mensagem += '\n - Você deve selecionar um usuário';
				retorna = false; }

		if ( !retorna ) {
			alert( mensagem ); }
		else {
		     // Se e exclusao...
		     if ( opcao != 1 ) {
			if( !confirm( 'Tem certeza que deseja excluir usuário?' ) )
				      retorna = false;
		     }
		}				

		return retorna;

	}

	//--------------------------------------------
	// validaDados()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaDados( controle ) {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- Nome
			if ( testaNulo( document.forms[0].nome ) ) {
				mensagem += '\n - Nome do usuário não preenchido';
				retorna = false; }

			// -- Login
			if ( testaNulo( document.forms[0].login ) ) {
				mensagem += '\n - Login não preenchido';
				retorna = false; }

			// -- Senha
			if ( testaNulo( document.forms[0].senha ) ) {
				mensagem += '\n - Senha não preenchida';
				retorna = false; }

			// -- Confirma Senha
			if ( testaNulo( document.forms[0].confSenha ) ) {
				mensagem += '\n - Confirma senha não preenchida';
				retorna = false; }

			// -- Senha
			if ( !comparaCampo( document.forms[0].senha, document.forms[0].confSenha ) ) {
				mensagem += '\n - Senhas não são iguais';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem );
				document.forms[0].nome.focus(); }

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
	// comparaCampo()
	// - Testa se campos são iguais
	//--------------------------------------------
	function comparaCampo( campo1, campo2 ) {

		return ( campo1.value == campo2.value )?true:false;

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
	// abreJanela()
	// - Abre a ajuda
	//--------------------------------------------
	function abreJanela( arquivo ) {

		var janela;
		window.open(arquivo, 'janela',
			'toolbar=no,location=no,directories=no,menubar=no,scrollbars=yes');

	}

</SCRIPT>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="../estilo/cw.css">

</head>
<?PHP

	if ( empty( $controleNavegacao ) )
		$controleNavegacao = 0;

	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";
	$cabec = new TituloCw( $cabecCadUsuario );
	$cabec->mostra();

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	// Verifica o controle de navegacao...
	switch( $controleNavegacao ) {

		// Inclusao de Usuarios
		default: {

?>
		<body class="pagina" onLoad="this.document.formCadUsuario.nome.focus();">

		<div align="center">

		<br>

		<form action="cwGravaAdmin.php"
					name="formCadUsuario" method="get" onSubmit="return validaDados();">

		<input type="hidden" name="tipoOperacao" value="4">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">

		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>
		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloCadUsuario; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwCadUsuario')">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>

		</td>
		</tr>
		<tr>
		<td>
		
		<!-- Opções do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="30%" align="right">&nbsp;
				</td>
				<td width="70%" align="left">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoConsultar; ?>" name="bt_consultar"
						OnClick="javascript:abreJanela('cwCadUsuario.php?controleNavegacao=3');">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoAlterar; ?>" name="bt_alterar"
						OnClick="javascript:abreJanela('cwCadUsuario.php?controleNavegacao=1&operacao=1');">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoExcluir; ?>" name="bt_excluir"
						OnClick="javascript:abreJanela('cwCadUsuario.php?controleNavegacao=1&operacao=2');">


				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoNome; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="nome"
							size="30" maxlength="40">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoLogin; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="login"
							size="10" maxlength="12">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoSenha; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="password" class="txjanela" name="senha"
							size="10" maxlength="12">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoConfirmaSenha; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="password" class="txjanela" name="confSenha"
							size="10" maxlength="12">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoPerfilUsuario; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="perfilUsuario" class="dljanela">
						<option value="A"><?PHP echo $msgPerfilAdministrador; ?></option>
						<option value="S"><?PHP echo $msgPerfilSupervisor; ?></option>
						<option value="O"><?PHP echo $msgPerfilOperador; ?></option>
						<option value="C"><?PHP echo $msgPerfilConsulta; ?></option>						
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right">&nbsp;
				</td>
				<td width="70%" align="left">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoIncluir; ?>" name="bt_incluir">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
						OnClick="javascript:history.go(-1);">
				<input type="button" class="bjanela" name= "bt_ajuda"
					value="<?= $botaoAjuda; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwCadUsuario')">

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
			break; }

		case 1: { // Mostra tela de pesquisa...

		?>

		<body class="pagina" onLoad="this.document.formConsUsuario.nome.focus();">

		<div align="center">

		<br><br><br>

		<form action="cwCadUsuario.php"
					name="formConsUsuario" method="get">

		<?PHP
			echo "<input type=\"hidden\" name=\"operacao\" value=\"$operacao\">";
			echo "<input type=\"hidden\" name=\"controleNavegacao\" value=\"2\">";
		?>
			<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">

		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="90%" class="tjanela">
				<?PHP echo $tituloPesquisa; ?>
			</td>
			<td width="10%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:window.close();">
			</td>
			</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td>		

		<!-- Opções do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoNome; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="nome"
							size="40" maxlength="60">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right">&nbsp;
				</td>
				<td width="70%" align="left">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoConsultar; ?>" name="bt_consultar">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
						OnClick="javascript:window.close();">
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
			break; }

		case 2: { // Seleciona item para operação...

			// Se for alteração...
			if ( $operacao == 1 ) {
				$acaoExecutada = "cwCadUsuario.php";
				$botao = $botaoAlterar; }
			// Se for exclusão...
			else {
				$acaoExecutada = "cwGravaAdmin.php";
				$botao		   = $botaoExcluir; }

		?>
		<body class="pagina">

			<div align="center">

			<br><br><br>

			<form name="formPesquisa" action="<?PHP echo $acaoExecutada; ?>"
						method="get" onSubmit="return validaSelecaoItem(<?= $operacao; ?>);">

			<?PHP
				if ( $operacao != 1 ) ?>
				<input type="hidden" name="tipoOperacao" value="6">

			<?PHP
				if ( $operacao == 1 ) ?>
				<input type="hidden" name="controleNavegacao" value="4">

		<?PHP
			$usuario = new UsuarioCw();
			$listaUsuarios = $usuario->buscaUsuario( $oidEmpresa, $nome );

			if ( $listaUsuarios[0][0] == "0" ) {
				$msg = new MsgCw( $msgUsuariosNaoEncontrados );
				$msg->mostra();
				exit(); }
		?>

		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

				<!-- Janela -->
				<table border="0" width="100%">
					<tr>
					<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
						<?PHP echo $tituloPesquisaItem; ?>
					</td>
					<td width="15%" align="center" class="tjanela">
						<input type="button" class="btitulo" name= "bt_fechar"
							value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
					</td>
					</tr>
				</table>

		</td>
		</tr>
		<tr>
		<td>
				<!-- Opções do Menu -->
				<table class="cjanela" border="0" width="100%">

					<tr>
						<td width="10%" align="right">&nbsp;
						</td>
						<td align="center" width="90%" class="cjanela">
						<select name="oidUsuario" size= "10" class="dljanela">
						<?PHP
						for ( $indx = 0; $indx < sizeof( $listaUsuarios ); $indx++ ) {
						?>
							<option value="<?= trim( $listaUsuarios[$indx][0] ); ?>"><?= trim( $listaUsuarios[$indx][1] )." - ".trim( $listaUsuarios[$indx][2] ); ?></option>
						<?PHP } ?>
						</select>
					</td>
					</tr>
					<tr>
						<td width="10%" align="right">&nbsp;
						</td>
						<td width="90%" align="center">
							<input type="submit" class="bjanela" value="<?PHP echo $botao; ?>" name="bt_executar">
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
			break; }

		case 3: { // Consulta de usuários...

			$consulta = new ConsultaCw();

			$consulta->mostraConsulta( "Usuários Cadastrados",
			"select nome as \"Nome\", login as \"Login\", perfilusuario as \"Perfil\" from usuario_cont where codigocliente = '$oidEmpresa' order by nome;",
										false );
			break; }

		case 4: { // Alteração de usuários...

		?>

		<body class="pagina" onLoad="this.document.formAltUsuario.nome.focus();">

		<div align="center">

		<br><br>

		<?PHP
			$usuario = new UsuarioCw();
			$usuario->pesquisaUsuario( $oidUsuario );
		?>

		<form action="cwGravaAdmin.php"
					name="formAltUsuario" method="get" onSubmit="return validaDados();">

		<input type="hidden" name="tipoOperacao" value="5">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">
		<input type="hidden" name="oidUsuario" value="<?PHP echo $oidUsuario; ?>">

		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="90%" class="tjanela">
				<?PHP echo $tituloAlteracao; ?>
			</td>
			<td width="10%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>
	</td>
	</tr>
	<tr>
	<td>

		<!-- Opções do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoNome; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="nome"
							size="30" maxlength="40" value="<?= trim( $usuario->getNome() ); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoLogin; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="login"
							size="10" maxlength="12" value="<?= trim( $usuario->getLogin() ); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoSenha; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="password" class="txjanela" name="senha"
							size="10" maxlength="12" value="<?= trim( $usuario->getSenha() ); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoConfirmaSenha; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="password" class="txjanela" name="confSenha"
							size="10" maxlength="12" value="<?= trim( $usuario->getSenha() ); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoPerfilUsuario; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="perfilUsuario" class="dljanela">
						<option value="A" <? if ( trim( $usuario->getPerfilUsuario() ) == "A" )
							echo " selected"; ?>><?PHP echo $msgPerfilAdministrador; ?></option>
						<option value="S"  <? if ( trim( $usuario->getPerfilUsuario() ) == "S" )
							echo " selected"; ?>><?PHP echo $msgPerfilSupervisor; ?></option>
						<option value="O" <? if ( trim( $usuario->getPerfilUsuario() ) == "O" )
							echo " selected"; ?>><?PHP echo $msgPerfilOperador; ?></option>
						<option value="C" <? if ( trim( $usuario->getPerfilUsuario() ) == "C" )
							echo " selected"; ?>><?PHP echo $msgPerfilConsulta; ?></option>
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right">&nbsp;
				</td>
				<td width="70%" align="left">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoAlterar; ?>" name="bt_alterar">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
						OnClick="javascript:history.back();">

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
		break; } // Fim do Case (Alteração)

	} // Fim do Switch/Case
?>

</html>

