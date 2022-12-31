<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 26/05/2003
	Última Atualização: 26/05/2003
	Módulo: cwMenuOperacao.php
	  Menu de opções de Operação do Sistema
-->
<html>
<head>
<title>::FIEL Contábil::</title>

<script language="javascript">

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

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="../estilo/cw.css">

</head>

<body class="pagina">
<?PHP

	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";

	$cabec = new TituloCw( $tituloMenuOperacao );
	$cabec->mostra();

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";
?>

	<div align="center">
		<center>
			<a href="javascript:abreJanela('../sobre.php');"><img src="../imagens/contabil.jpg" width="200" border="0"></a>
			<font face="Verdana, Arial" color="#000099" size="2"><br>
			<b>Usuário: </b><?PHP echo $login; ?></font>
		</center>

	<table border="0" width="70%">
	<tr>
		<td width="100%" align="center">

			<form name="f_login" action="index.php" method="get">

				<!-- Janela -->
				<table border="0" width="80%">
					<tr>
						<td background="../imagens/cw_janela.gif" border="0" width="90%" class="tjanela">
							<?PHP echo $tituloMenuOperacao; ?>
						</td>
						<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="center">
							<input type="button" class="btitulo" name= "bt_ajuda"
								value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwMenuOperacao')">
						</td>
					</tr>
				</table>

				<!-- Opções do Menu -->
				<table class="cjanela" border="0" width="80%">

					<!-- Vamos ter que fazer uma opcao de listagem de opções do menu,
					ordenados pelo atributo "ordem" -->
					<? if ( $perfilUsuario != "C" ) { ?>
					<tr>
						<td align="center" class="cjanela">
							<a href="cwRegLanc.php"><?PHP echo $opcaoRegLancamento; ?></a>
						</td>
					</tr>
					<? } ?>
					<tr>
						<td align="center" class="cjanela">
							<a href="../supervisao/cwConsLancNaoCont.php"><?PHP echo $opcaoRelLancNaoContabilizados; ?></a>
						</td>
					</tr>
					<tr>
						<td align="center" class="cjanela">
							<a href="cwMenuRelCont.php"><?PHP echo $opcaoRelContabeis; ?></a>
						</td>
					</tr>
					<tr>
						<td align="center" class="cjanela">
							<a href="javascript:history.back();"><?= $opcaoRetornarMenu; ?></a>
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
