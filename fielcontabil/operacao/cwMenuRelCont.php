<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 26/05/2003
	Última Atualização: 26/05/2003
	Módulo: cwMenuRelCont.php
	  Menu de opções de relatórios contábeis
-->
<html>
<head>
<title>::VOX::</title>

<script language="javascript">

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

	$cabec = new TituloCw( $tituloMenuRelCont );
	$cabec->mostra();

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";
?>

	<div align="center">

		<center>
			<img src="../imagens/contabil.jpg" width="200" border="0">
		</center>

	<table border="0" width="70%">
	<tr>
		<td width="100%" align="center">

			<form name="f_login" action="index.php" method="get">

				<!-- Janela -->
				<table border="0" width="80%">
					<tr>
						<td background="../imagens/cw_janela.gif" border="0" width="90%" class="tjanela">
							<?PHP echo $tituloMenuRelCont; ?>
						</td>
						<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="center">
							<input type="button" class="btitulo" name= "bt_ajuda"
								value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwMenuRelCont')">
						</td>
					</tr>
				</table>

				<!-- Opções do Menu -->
				<table class="cjanela" border="0" width="80%">

					<!-- Vamos ter que fazer uma opcao de listagem de opções do menu,
					ordenados pelo atributo "ordem" -->
					<tr>
						<td align="center" class="cjanela" width="50%">
							<a href="../supervisao/cwConsDiario.php"><?PHP echo $opcaoRelDiarioLancamentos; ?></a>
						</td>
						<td align="center" class="cjanela" width="50%">
							<a href="../supervisao/cwConsRazao.php"><?PHP echo $opcaoRelRazaoAnalitico; ?></a>
						</td>
					</tr>
					<tr>
						<td align="center" class="cjanela" width="50%">
							<a href="../supervisao/cwConsAnalitico.php"><?PHP echo $opcaoRelBalanceteAnalitico; ?></a>
						</td>
						<td align="center" class="cjanela" width="50%">
							<a href="../supervisao/cwConsDemoResult.php"><?PHP echo $opcaoRelDemonstrativoResultados; ?></a>
						</td>
					</tr>
					<tr>
						<td align="center" class="cjanela" width="50%">
							<a href="../supervisao/cwConsBalanco.php"><?PHP echo $opcaoRelBalanco; ?></a>							
						</td>
						<td align="center" class="cjanela" width="50%">
							<a href="../supervisao/cwConsDoar.php"><?PHP echo $opcaoRelDoar; ?></a>	
						</td>
					</tr>
					<tr>
						<td align="center" class="cjanela" width="50%">
							<a href="../supervisao/cwConsOrcamento.php"><?PHP echo $opcaoRelAcompanhamentoOrcamento; ?></a>
						</td>
						<td align="center" class="cjanela" width="50%">
							<a href="../supervisao/cwConsPlano.php"><?PHP echo $opcaoRelPlanoContas; ?></a>
						</td>
					</tr>
					<tr>
						<td align="center" class="cjanela" width="50%">
							<a href="../supervisao/cwConsPlanoDoar.php"><?PHP echo $opcaoRelPlanoContasDoar; ?></a>
						</td>
						<td align="center" class="cjanela" width="50%">
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
