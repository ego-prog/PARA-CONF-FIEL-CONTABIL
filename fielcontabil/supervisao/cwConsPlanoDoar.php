<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe oid da Empresa
	$oidEmpresa = $oidEmpresaSession;
	$loginUsuario = $loginSession;

	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";

	// Carrega lista de empresas
	$empresa = new Empresa();
	$listaEmpresas = $empresa->buscaEmpresa( $oidEmpresa, "", 1, $loginUsuario );
?>
<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 25/06/2003
	Última Atualização: 14/07/2003
	Módulo: cwConsPlanoDoar.php
	  Consulta Plano de Contas DOAR
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
			'toolbar=no,location=no,directories=no,menubar=no,scrollbars=yes');

	}

	//--------------------------------------------
	// abreAjuda()
	// - Abre a ajuda
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

<?PHP

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	if ( empty( $controleNavegacao ) )
		$controleNavegacao = 0;

	 switch( $controleNavegacao ) {

	 default: {

		  $cabec = new TituloCw( $cabecConsPlanoDoar );
		  $cabec->mostra();
?>
<body class="pagina" onLoad="this.document.formConsPlanoDoar.oidEmpresaCont.focus();">

	<div align="center">

	<br><br>

	<form action="cwConsPlanoDoar.php"
				name="formConsPlanoDoar" method="get">

	<input type="hidden" name="controleNavegacao" value="1">


		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloConsPlanoDoar; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwConsPlanoDoar')">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>

		<!-- Opções do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoEmpresa; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="oidEmpresaCont" class="dljanela">
					<? for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) { ?>
					   <option value="<?= $listaEmpresas[$indx][0]; ?>"><?= $listaEmpresas[$indx][1]; ?></option>
					<? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right">&nbsp;
				</td>
				<td width="70%" align="left">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoConsultar; ?>" name="bt_consultar">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
					OnClick="javascript:history.go(-1);">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoAjuda; ?>" name="bt_ajuda"
					OnClick="javascript:abreAjuda('../cw_ajuda.html#cwConsPlanoDoar');">
				</td>
			</tr>

		</table>

	</td>
	</tr>
	</table>

	</form>

	</div>

</body>

<?PHP
	 break;
	 }

	 case 1: {

		 $contaDoar = new ContaDoar();
		 if ( $contaDoar->consultaPlanoContasDoar( $oidEmpresaCont, $oidEmpresa, $perfilUsuario ) == false ) {
			echo "<body class=\"pagina\"><center>";
			$msg = new MsgCw( $msgConsultaInvalida,
				"../imagens/contabil.jpg", "javascript:history.go(-1);" );
			$msg->mostra();
			echo "</center></body>"; 
			exit;
		 }

		break; }

	   case 2: {
?>
<body class="pagina">

	<div align="center">
<?
		  $cabec = new TituloCw( $cabecConsPlanoDoar );
		  $cabec->mostra();

		 $contaDoar = new ContaDoar();
		 $contaDoar->consultaPlanoContasDoarPDF( $oidEmpresaCont, $oidEmpresa );
		break;
?>
	</div>
</body>
<?
	   }
	   case 3: {

?>
<body class="pagina">

	<div align="center">
<?
		  $cabec = new TituloCw( $cabecConsPlanoDoar );
		  $cabec->mostra();

		// Exibe mensagem...
		if ( @file( "../pdfs/".PDF_PLANO_CONTAS_DOAR ) ) {
			$msg = new MsgCw( $msgCliqueAquiParaVisualizar,
		       "../imagens/contabil.jpg", "javascript:history.go(-2);" );
			   $msg->mostraMsgLink( "../pdfs/".PDF_PLANO_CONTAS_DOAR, true );
			   exit;
		}
		else {
			$msg = new MsgCw( $msgDocumentoNaoDisponivel,
				"../imagens/contabil.jpg", "javascript:history.go(-1);" );
				$msg->mostra();
				exit;
		}

		break;
?>
	</div>
</body>

<?	   }

	}
?>

</html>
