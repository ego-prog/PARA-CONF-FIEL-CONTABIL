<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 26/05/2003
	Última Atualização: 26/05/2003
	Módulo: cwModuloNaoImp.php
	  Modulo nao implementado
-->
<html>

<head>

<title>::FIEL Contábil::</title>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="estilo/cw.css">

</head>

<body class="pagina">
<?PHP

	// Inclui pacote da aplicacao...
	include "./classes/cw.inc";

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	// Mostra mensagem de finalizacao do FIEL Contábil...
	$cabec = new TituloCw( $msgModuloNaoImp );
	$cabec->mostra();
	$msg = new MsgCw( $msgModuloNaoImp, "./imagens/contabil.jpg" );
	$msg->mostra();
	exit();

?>
</body>
</html>
