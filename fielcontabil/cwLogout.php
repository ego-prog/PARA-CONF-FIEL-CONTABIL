<?PHP

	// Inclui pacote da aplicacao...
	include "./classes/cw.inc";

	// Abre sessao...
	session_start( "cw" );

	// Seta variaveis...
	$descricaoLog	      = $msgLogSaidaSistema;
	$complementoLog       = $msgLogSaidaSistema;

	// Registra operacoes no LOG
	$log = new LogCw();
	$log->setLogCw( $oidEmpresaSession, $loginSession,
				$numeroIpSession, $descricaoLog, $complementoLog );
	$log->grava();

	// Elimina registro de atributos de sessao...
	session_unregister( "loginSession" );
	session_unregister( "perfilUsuarioSession" );
	session_unregister( "numeroIpSession" );
	session_unregister( "oidEmpresaSession" );

	// Destroi a sessao...
	session_destroy();

?>

<!--
	FIEL Cont�bil
	Desenvolvido por APOENA Solu��es em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Cria��o: 26/05/2003
	�ltima Atualiza��o: 26/05/2003
	M�dulo: cwLogout.php
	  Sair do FIEL Cont�bil
-->
<html>

<head>

<title>::FIEL Cont�bil::</title>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="estilo/cw.css">

</head>

<body class="pagina">
<?PHP
	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	// Mostra mensagem de finalizacao do FIEL Cont�bil...
	$cabec = new TituloCw( $cabecLogout );
	$cabec->mostra();
	$msg = new MsgCw( $msgLogout, "./imagens/contabil.jpg" );
	$msg->mostraMsgFim( "./index.html", false );
	exit();

?>
</body>
</html>
