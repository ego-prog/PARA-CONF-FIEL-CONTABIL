<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 26/05/2003
	Última Atualização: 26/05/2003
	Módulo: cwMenuSupervisao.php
	  Menu de opções de supervisão do Sistema
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

	$cabec = new TituloCw( $tituloMenuSupervisao );
	$cabec->mostra();

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";
?>

	<div align="center">

		<center>
			<a href="javascript:abreJanela('../sobre.php');"><img src="../imagens/contabil.jpg" width="200" border="0"></a>
			<font face="Verdana, Arial" color="#000099" size="2"><br>
			<b>Usuário: </b><?PHP echo $login; ?></font>
		</center>
	<table border="0" width="90%">
	<tr>
		<td width="100%" align="center">

			<form name="f_login" action="index.php" method="get">

				<!-- Janela -->
				<table border="0" width="80%">
					<tr>
						<td background="../imagens/cw_janela.gif" border="0" width="90%" class="tjanela">
							<?PHP echo $tituloMenuSupervisao; ?>
						</td>
						<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela"  align="center">
							<input type="button" class="btitulo" name= "bt_ajuda"
								value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwMenuSupervisao')">
						</td>
					</tr>
				</table>

				<!-- Opções do Menu -->
				<table class="cjanela" border="0" width="80%">

					<!-- Vamos ter que fazer uma opcao de listagem de opções do menu,
					ordenados pelo atributo "ordem" -->
					<tr>
						<td align="center" class="cjanela" width="50%">
							<a href="cwCadEmpresa.php"><?PHP echo $opcaoCadEmpresa; ?></a>
						</td>
						<td align="center" class="cjanela" width="50%">
							<a href="cwCadCentro.php"><?PHP echo $opcaoCadCentro; ?></a>
						</td>
					</tr>
					<tr>
						<td align="center" class="cjanela" width="50%">
							<a href="cwCadTermo.php"><?PHP echo $opcaoCadTermoAbertura; ?></a>
						</td>
						<td align="center" class="cjanela" width="50%">
							<a href="cwCadPlano.php"><?PHP echo $opcaoCadPlanoConta; ?></a>
						</td>
					</tr>
					<tr>
						<td align="center" class="cjanela" width="50%">
							<a href="cwCadDoar.php"><?PHP echo $opcaoCadPlanoDoar; ?></a>
						</td>
						<td align="center" class="cjanela" width="50%">
							<a href="cwCadNota.php"><?PHP echo $opcaoNotasExplicativas; ?></a>
						</td>
					</tr>
					<tr>
						<td align="center" class="cjanela" width="50%">
							<a href="cwCadHistorico.php"><?PHP echo $opcaoCadHistoricoPadrao; ?></a>
						</td>
						<td align="center" class="cjanela" width="50%">
							<a href="cwCadOrcamento.php"><?PHP echo $opcaoCadOrcamentoAnual; ?></a>
						</td>
					</tr>
					<tr>
						<td align="center" class="cjanela" width="50%">
							<a href="cwZeramento.php"><?PHP echo $opcaoZeramento; ?></a>
						</td>
						<td align="center" class="cjanela" width="50%">
							<a href="cwLiberaLanc.php"><?PHP echo $opcaoLiberacao; ?></a>
						</td>
					</tr>
					<tr>
						<td align="center" class="cjanela" width="50%">
							<a href="cwZeramentoContas.php"><?PHP echo $opcaoZeramentoContasResultado; ?></a>
						</td>
						<td align="center" class="cjanela" width="50%">
							<a href="cwMenuRelCont.php"><?PHP echo $opcaoRelContabeis; ?></a>
						</td>
					</tr>

					<tr>
						<td align="center" class="cjanela" width="50%">
							<a href="cwConsLancNaoCont.php"><?PHP echo $opcaoRelLancNaoContab; ?></a>
						</td>
						<td align="center" class="cjanela" width="50%">
							<a href="cwGrafComparativo.php?login=<?= $login ?>"><?= $opcaoGrafAcompanhamentoOrcamento; ?></a>
						</td>
					</tr>

					<tr>
						<td align="center" class="cjanela" width="50%">
							<a href="cwGrafEvolutivo.php?login=<?= $login ?>"><?= $opcaoGrafEvolucaoSaldo; ?></a>
						</td>
						<td align="center" class="cjanela" width="50%">
							<a href="../admin/cwConsLog.php"><?PHP echo $opcaoConsultaArquivoLOG; ?></a>
						</td>
					</tr>

					<tr>
						<td align="center" class="cjanela" width="50%">
							<a href="cwVerificaLancs.php"><?= $opcaoVerificacaoLanc; ?></a>
						</td>
						<td align="center" class="cjanela" width="50%">
							<a href="cwCopiaPlano.php"><?PHP echo $opcaoCopiaPlano; ?></a>
						</td>
						<td align="center" class="cjanela" width="50%">
							&nbsp;
						</td>
					</tr>
					
					<tr>
						<td align="center" class="cjanela" width="50%">
							<a href="javascript:history.back();"><?PHP echo $opcaoRetornarMenu; ?></a>
						</td>
						<td align="center" class="cjanela" width="50%">
						&nbsp;
						</td>
						<td align="center" class="cjanela" width="50%">
							&nbsp;
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
