<!--
	FIEL Cont�bil
	Desenvolvido por APOENA Solu��es em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Cria��o: 26/05/2003
	�ltima Atualiza��o: 26/05/2003
	M�dulo: cwModuloNaoImp.php
	  Modulo nao implementado
-->
<html>

<head>

<title>::FIEL Cont�bil::</title>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="estilo/cw.css">

</head>

<body class="pagina">
<?PHP

	// Inclui pacote da aplicacao...
	include "./classes/cw.inc";

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	// Mostra mensagem de finalizacao do FIEL Cont�bil...
	$cabec = new TituloCw( $msgModuloNaoImp );
	$cabec->mostra();
	$msg = new MsgCw( $msgModuloNaoImp, "./imagens/contabil.jpg" );
	$msg->mostra();
	exit();

?>
</body>
</html>
