<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe oid da Empresa
	$oidEmpresa    = $oidEmpresaSession;
	$perfilUsuario = $perfilUsuarioSession;

?>

<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 25/06/2003
	Última Atualização: 29/06/2003
	Módulo: cwRelatPers.php
	  Consulta de Relatórios personalizados
-->

<html>
<head>
<title>::FIEL Contábil::</title>

<script language="javascript">

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
	// validaSelecaoItem()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaSelecaoItem() {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- OID
			if ( document.forms[0].oidConsulta.selectedIndex == -1 ) {
				mensagem += '\n - Você deve selecionar uma consulta para execução';
				retorna = false; }

		if ( !retorna ) {
			alert( mensagem ); }

		return retorna;

	}

</SCRIPT>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="./estilo/cw.css">

</head>
<?PHP

	if ( empty( $controleNavegacao ) )
		$controleNavegacao = 0;

	// Inclui pacote da aplicacao...
	include "./classes/cw.inc";
	$cabec = new TituloCw( $cabecRelatPers );
	$cabec->mostra();

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	$consulta = new ConsultaCw();
	$listaConsultas = $consulta->buscaConsulta( $oidEmpresa, $perfilUsuario );

	// Verifica o controle de navegacao...
	switch( $controleNavegacao ) {

		// Pesquisa de reuniao...
		default: {

		if ( $listaConsultas[0][0] == "0" ) {
			$msg = new MsgCw( $msgNaoExistemConsultasPerfil,
			"./imagens/contabil.jpg", "javascript:history.go(-1);" );
			$msg->mostra();
			exit(); 
		}
?>
		<body class="pagina">

		<div align="center">

		<br>

		<form name="formCons" action="cwRelatPers.php" method="post" onSubmit="return validaSelecaoItem();">

		<input type="hidden" name="controleNavegacao" value="1">

		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="./imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloRelatPers; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('./cw_ajuda.html#cwRelatPers')">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>

		<!-- Opções do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="10%" align="right">&nbsp;
				</td>
				<td align="center" width="90%" class="cjanela">
				<select name="oidConsulta" size= "10" class="dljanela">
					<?PHP
					for ( $indx = 0; $indx < sizeof( $listaConsultas ); $indx++ ) { ?>
						<option value="<?= $listaConsultas[$indx][0]; ?>"><?= $listaConsultas[$indx][1]; ?></option>
					<?PHP } ?>
				</select>
			</td>
			</tr>
			<tr>
				<td width="10%" align="right">&nbsp;
				</td>
				<td width="90%" align="center">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoExecutar; ?>" name="bt_executar">
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

<?
	 break;}

	 case 1: { // Emissão Ata de reunião...

		 // Executa preview da consulta...
		 $consulta = new ConsultaCw();
		 $consulta->executaConsulta( $oidConsulta, 1 );
		 
	 break; }

	} // Fim do Switch/Case
?>

</html>

