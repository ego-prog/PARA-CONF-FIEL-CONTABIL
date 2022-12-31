<?PHP

	// Inclui pacote da aplicacao...
	include $pathClasses."cw.inc";

	// Abre sessao...
	@session_start( "cw" );

	// flag de controle...
	$erroSession = false;

	// Testa se sessao foi destruida ou se foi tentado entrar indevidamente
	if ( !( session_is_registered( "loginSession" ) ) &&
			!( session_is_registered( "numeroIpSession" ) ) )
		$erroSession = true;

	// Verifica diretorio para direcionamento do PATH
	$dirAtual = dirname( $PATH_INFO );

	// se diretorio atual for /vox o PATH muda
	if ( $dirAtual == "/contabil" ) {
		$flagDiretorio = false;
		$arqEstilo	   = "./estilo/cw.css";
	}
	else {
		$flagDiretorio = true;
		$arqEstilo	   = "../estilo/cw.css";
	}


	// Verifica se deve exibir a mensagem...
	if ( $erroSession ) {

?>

<!--									  -->
<!-- FIEL Contábil							  -->
<!--  Desenvolvido por APOENA Soluções em Software Livre		  -->
<!--  suporte@apoenasoftwarelivre.com.br				  -->
<!--  http://www.apoenasoftwarelivre.com.br			  -->
<!--									  -->
<!-- Data de Criação: 26/05/2003					  -->
<!-- Última Atualização: 26/05/2003				  -->
<!-- Módulo: cwErro.php 						  -->
<!--	Mostra Erro de sessao						  -->

<html>

<head>

<title>::FIEL Contábil::</title>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="<?PHP echo $arqEstilo; ?>">

</head>

<?PHP

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	// Mostra mensagem de erro de sessao do FIEL Contábil...
	$cabec = new TituloCw( $cabecErroSession );
	$cabec->mostra();

	if ( $flagDiretorio )
		$msg = new MsgCw( $msgErroSession, "../imagens/contabil.jpg" );
	else
		$msg = new MsgCw( $msgErroSession, "./imagens/contabil.jpg" );

	$msg->mostra( false );
	exit();

?>

</html>

<?PHP } ?>
