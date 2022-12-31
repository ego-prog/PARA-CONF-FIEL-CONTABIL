<?PHP

	// Recebe numero IP de conexao do cliente
	$numeroIpSession = empty($REMOTE_ADDR)?$SERVER_ADDR:$REMOTE_ADDR;
	$loginSession	 = $login;

	// cria sessao para usuario, registrando login e IP...
	session_start( "cw" );
	session_register( "loginSession", "numeroIpSession" );

	// Inclui pacote da aplicacao...
	include_once "./classes/cw.inc";

	// Testa se login e registrado no VOX
	$usuario   = new UsuarioCw();
	$erroLogin = true;

	if ( $usuario->validaAcessoUsuario( $login, $senha ) ) {

		// 1: identifica empresa e perfil do usuario
		$erroLogin	   = false;
		$perfilUsuario = $usuario->getPerfilUsuario();
		$oidEmpresa	   = $usuario->getOidEmpresa();

		// Seta atributos para sessao
		$perfilUsuarioSession = $perfilUsuario;
		$oidEmpresaSession    = $oidEmpresa;
		$descricaoLog	      = $msgLogAcessoSistema;
		$complementoLog       = $msgLogAcessoSistema;

		// 2: registra atributos na sessao
		session_register( "perfilUsuarioSession", "oidEmpresaSession" );

		// 3: registra no LOG
		// Registra operacoes no LOG
		$log = new LogCw();
		$log->setLogCw( $oidEmpresaSession, $loginSession,
					   $numeroIpSession, $descricaoLog, $complementoLog );
		$log->grava();

	}

?>

<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 26/05/2003
	Última Atualização: 26/05/2003
	Módulo: index.php
	  Main de Frames
-->

<html>

<head>

<title>::FIEL Contábil::</title>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="estilo/cw.css">

</head>

<?PHP

echo "\n<!-- numero da pagina: $numeroPagina -->\n";


	// Verifica se usuario nao esta autorizado...
	if ( $erroLogin ) {

		// Mostra mensagem de erro...
		echo "<body bgcolor=\"#FFFFFF\">";
		$cabec = new TituloCw( $cabecUsuarioNaoAutorizado );
		$cabec->mostra();
		$msg = new MsgCw( $msgUsuarioNaoAutorizado, "./imagens/contabil.jpg" );
		$msg->mostra();
		echo "</body>";
		exit();

	}

	else {

		// Consulta dados dos parametros da empresa (ClasseParametro)
		$param = new ParametroCw();

		$param->pesquisaEmpresa( $oidEmpresa );
		$arquivo	= "./imagens/".$param->getLogotipo();
		$empresa	= strtr( $param->getEmpresa(), " ", "_" );
		$linha1 	= strtr( $param->getLinha1(), " ", "_" );
		$linha2 	= strtr( $param->getLinha2(), " ", "_" );

		//$log->limpaLog( $param->getMaximoDiasLog(), $idPrefeituraSession );

		// Seta dados de cabecalho...
		$cabecalho = "cwCabec.php?logo=".$arquivo."&empresa=".$empresa."&linha1=".$linha1."&linha2=".$linha2;

?>

	<!-- Monta frames de tela  -->
	<frameset rows="95,*" border=0 frameborder=no framespacing=0>

		<!-- Frame 1: Parte superior da tela -->
		<frame src="<?PHP echo $cabecalho; ?>" name="f_cabec" frameborder=no noresize
			framespacing=0 marginheight=0 marginwidth=0 scrolling=no>

		<!-- Frame 2: 2/3 de tela -->
		<frame src="cwMenu.php?perfilUsuario=<?= $perfilUsuario; ?>&login=<?= $login; ?>"
			name="f_menu" frameborder=no framespacing=0
			marginheight=0 marginwidth=0 scrolling=yes>

	</frameset>

	<noframes>

<body bgcolor="#FFFFFF">

</body>

</noframes>

<? } ?>

</html>
