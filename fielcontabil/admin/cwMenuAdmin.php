<?PHP

	// Recebe dados da sessão
	session_start( "cw" );
	$login	    = $loginSession;
	$oidEmpresa = $oidEmpresaSession;

?>
<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 26/05/2003
	Última Atualização: 26/05/2003
	Módulo: cwMenuAdmin.php
	  Menu de opções de Administração do Sistema
-->
<html>
<head>
<title>::FIEL Contábil::</title>

<script language="javascript">

	//--------------------------------------------
	// voltaMenuPrinc()
	// - Volta ao Menu Principal
	//--------------------------------------------
	function voltaMenuPrinc(  ) {

		 document.location = "../cwMenu.php?perfilUsuario=A";

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

	$cabec = new TituloCw( $tituloMenuAdmin );
	$cabec->mostra();

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";
?>

	<div align="center">
		<center>
			<img src="../imagens/contabil.jpg" width="200" border="0">
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
							<?PHP echo $tituloMenuAdmin; ?>
						</td>
						<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="center">
							<input type="button" class="btitulo" name= "bt_ajuda"
								value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwMenuAdmin')">
						</td>
					</tr>
				</table>

				<!-- Opções do Menu -->
				<table class="cjanela" border="0" width="80%">

					<tr>
						<td align="center" class="cjanela">
							<a href="cwParametro.php"><?PHP echo $opcaoParametrosSistema; ?></a>
						</td>
					</tr>
					<tr>
						<td align="center" class="cjanela">
							<a href="cwCadUsuario.php"><?PHP echo $opcaoCadastroUsuarios; ?></a>
						</td>
					</tr>
					<tr>
					<tr>
						<td align="center" class="cjanela">
							<a href="cwVincUsuario.php"><?PHP echo $opcaoVincularUsuarios; ?></a>
						</td>
					</tr>
					<tr>
						<td align="center" class="cjanela">
							<a href="cwEdCons.php"><?PHP echo $opcaoEditorConsultas; ?></a>
						</td>
					</tr>
					<tr>
						<td align="center" class="cjanela">
							<a href="cwConsLog.php"><?PHP echo $opcaoConsultaArquivoLOG; ?></a>
						</td>
					</tr>
					<tr>
						<td align="center" class="cjanela">
							<a href="javascript:voltaMenuPrinc();"><?= $opcaoRetornarMenu; ?></a>
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
