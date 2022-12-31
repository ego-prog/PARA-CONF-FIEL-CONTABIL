<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe os atributos de sessão
	$loginLog      = $loginSession;
	$numeroIpLog   = $numeroIpSession;
	$oidEmpresaLog = $oidEmpresaSession;
	$oidEmpresa    = $oidEmpresaSession;

?>

<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 25/06/2003
	Última Atualização: 29/06/2003
	Módulo: cwGravaAdmin.php
	  Facade (controller) de acesso as classes de negocios
-->
<html>
<head>
<title>::FIEL Contábil::</title>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="../estilo/cw.css">

<script language="javascript">

	//--------------------------------------------
	// voltaVincUsuario()
	// - Retorna ao módulo de Vinculação de Usuários a Empresas
	//--------------------------------------------
	function voltaVincUsuario( ) {

		 document.location = "cwVincUsuario.php";

	}
</script>

</head>

<body class="pagina">

<?PHP

	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	// Mostra mensagem de erro de sessao do CW...
	$cabec = new TituloCw( $cabecRegOperacaoAdmin );
	$cabec->mostra();

	// Verifica tipo de operacao...
	switch( $tipoOperacao ) {

		// Alteracao de senhas...
		case 1: {

			// Instancia classe
			$usuario = new UsuarioCw();
			$usuario->setAtualizaSenhaUsuario( $oidUsuario, $loginLog, $senha );

			$usuario->setOidEmpresa( $oidEmpresa );

			// Verifica se gravou
			if ( $usuario->atualizaSenha() )
			   $msg = new MsgCw( $msgAlteraSenhaOk,
				"../imagens/contabil.jpg", "javascript:history.go(-2);" );
			else
			   $msg = new MsgCw( $msgAlteraSenha,
			   "../imagens/contabil.jpg", "javascript:history.go(-2);" );

			// Exibe mensagem...
			$msg->mostra();

			// seta atributos para LOG
			$descricaoLog = $msgLogAlteraSenha;
			$complementoLog = $oidEmpresa." ".$oidUsuario." ".$login;

			break; }

		// Alteracao de Parametros...
		case 2: {

			// Instancia classe
			$param = new ParametroCw();
			$param->setParametroCw( $cliente, $linha1, $linha2, $linha3,
									 $maximoDias );

			$param->setOidEmpresa( $oidEmpresa );

			// Verifica se gravou
			if ( $param->grava() )
			   $msg = new MsgCw( $msgAtualizaParametroOk );
			else
			   $msg = new MsgCw( $msgAtualizaParametro );

			// Exibe mensagem...
			$msg->mostra();

			// seta atributos para LOG
			$descricaoLog = $msgLogAtualizaParametro;
			$complementoLog = $oidEmpresa." ".$empresa;

			break; }

		// Inclusão de consultas...
		case 3: {

			// Instancia classe
			$consulta = new ConsultaCw();
			$consulta->setConsultaCw( $oidEmpresa, $perfilUsuario, $titulo,
								   $modulo, $instrucaoSql );

			// Verifica se gravou
			if ( $consulta->grava() )
			   $msg = new MsgCw( $msgIncluiConsultaOk );
			else
			   $msg = new MsgCw( $msgIncluiConsulta );

			// Exibe mensagem...
			$msg->mostra();

			// seta atributos para LOG
			$descricaoLog	= $msgLogIncluiConsulta;
			$complementoLog = $oidEmpresa." ".$perfilUsuario;

			break; }

		// Inclusao de usuarios...
		case 4: {

			// Instancia classe
			$usuario = new UsuarioCw();

			// Testa login...
			if ( $usuario->validaUsuario( $login, $senha ) ) {

				// incluindo usuario...
				$usuario->setUsuarioCw( $oidEmpresa, $nome,
							$login, $senha, $perfilUsuario, $numeroIpLog );

				// Verifica se gravou
				if ( $usuario->grava() )
					$msg = new MsgCw( $msgIncluiUsuarioOk );
				else
					$msg = new MsgCw( $msgIncluiUsuario );

				// Exibe mensagem...
				$msg->mostra();

				// seta atributos para LOG
				$descricaoLog = $msgLogIncluiUsuario;
				$complementoLog = $oidEmpresa." ".$nome;

			}
			else {
				// Exibe mensagem...
				$msg = new MsgCw( $msgJaExisteUsuarioLogin );
				$msg->mostra(); }

			break; }

		// Alteracao de usuarios...
		case 5: {

			// Instancia classe
			$usuario = new UsuarioCw();

			// Testa login...
			if ( $usuario->validaUsuario( $login, $senha, $oidUsuario, false ) ) {

				// incluindo usuario...
				$usuario->setUsuarioCw( $oidEmpresa, $nome,
						$login, $senha, $perfilUsuario, $numeroIpLog );

				$usuario->setOidUsuario( $oidUsuario );

				// Verifica se gravou
				if ( $usuario->grava(false) )
					$msg = new MsgCw( $msgAlteraUsuarioOk,
						"../imagens/contabil.jpg", "javascript:history.go(-3);" );
				else
					$msg = new MsgCw( $msgAlteraUsuario,
						"../imagens/contabil.jpg", "javascript:history.go(-3);" );

				// Exibe mensagem...
				$msg->mostra();

				// seta atributos para LOG
				$descricaoLog = $msgLogAlteraUsuario;
				$complementoLog = $oidEmpresa." ".$nome;

			}
			else {
				// Exibe mensagem...
				$msg = new MsgCw( $msgJaExisteUsuarioLogin );
				$msg->mostra(); }

			break; }

		// Exclusao de usuarios...
		case 6: {

			// Instancia classe
			$usuario = new UsuarioCw();

			$usuario->setOidUsuario( $oidUsuario );

			// Verifica se gravou
			if ( $usuario->exclui() )
				$msg = new MsgCw( $msgExcluiUsuarioOk,
					"../imagens/contabil.jpg", "javascript:history.go(-2);" );
			else
				$msg = new MsgCw( $msgExcluiUsuario,
					"../imagens/vox_logo.jpg", "javascript:history.go(-2);" );

			// Exibe mensagem...
			$msg->mostra();

			// seta atributos para LOG
			$descricaoLog = $msgLogExcluiUsuario;
			$complementoLog = $oidEmpresa." ".$oidUsuario;

			break; }

		// Inclusao de Vinculos de Usuarios a Empresas
		case 7: {

			// Instancia classe
			$usuarioEmpresa = new UsuarioEmpresa();
			$usuario = new UsuarioCw();

			// Testa login...
			if ( $usuario->validaUsuario( $login, $senha ) ) {

				// incluindo vínculo...
				$usuarioEmpresa->setUsuarioEmpresa( $oidEmpresa, $oidUsuario, $oidEmpresaUsuaria );

				// Verifica se gravou
				if ( $usuarioEmpresa->grava() )
					$msg = new MsgCw( $msgIncluiUsuarioEmpresaOk, "../imagens/contabil.jpg", "javascript:voltaVincUsuario();" );
				else
					$msg = new MsgCw( $msgIncluiUsuarioEmpresa,"../imagens/contabil.jpg", "javascript:voltaVincUsuario();" );

				// Exibe mensagem...
				$msg->mostra();

				// seta atributos para LOG
				$descricaoLog = $msgLogIncluiUsuarioEmpresa;
				$complementoLog = $oidEmpresa." ".$oidUsuario . "  " . $oidEmpresaUsuaria;

			}
			else {
				// Exibe mensagem...
				$msg = new MsgCw( $msgJaExisteVinculo );
				$msg->mostra(); }

			break; }

		// Exclusao de Vínculos de Usuário a Empresas...
		case 8: {

			// Instancia classe
			$usuarioEmpresa = new UsuarioEmpresa();

			$usuarioEmpresa->setOidUsuarioEmpresa( $oidUsuarioEmpresa );

			// Verifica se gravou
			if ( $usuarioEmpresa->exclui() )
				$msg = new MsgCw( $msgExcluiUsuarioEmpresaOk,
					"../imagens/contabil.jpg", "javascript:voltaVincUsuario();" );
			else
				$msg = new MsgCw( $msgExcluiUsuarioEmpresa,
					"../imagens/contabil.jpg", "javascript:voltaVincUsuario();" );

			// Exibe mensagem...
			$msg->mostra();

			// seta atributos para LOG
			$descricaoLog = $msgLogExcluiUsuarioEmpresa;
			$complementoLog = $oidEmpresa." ".$oidUsuario;

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

