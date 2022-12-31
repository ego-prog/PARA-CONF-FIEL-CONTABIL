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
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 26/05/2003
	Última Atualização: 26/05/2003
	Módulo: cwLogout.php
	  Sair do FIEL Contábil
-->
<html>

<head>

<title>::FIEL Contábil::</title>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="estilo/cw.css">

</head>

<body class="pagina">
<?PHP
	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	// Mostra mensagem de finalizacao do FIEL Contábil...
	$cabec = new TituloCw( $cabecLogout );
	$cabec->mostra();
	$msg = new MsgCw( $msgLogout, "./imagens/contabil.jpg" );
	$msg->mostraMsgFim( "./index.html", false );
	exit();

?>
</body>
</html>
