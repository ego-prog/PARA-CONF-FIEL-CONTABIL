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
	$listaEmpresas = $empresa->buscaEmpresa( $oidEmpresa, "",1, $loginUsuario );
?>

<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 24/01/2006
	Última Atualização: 24/01/2006
	Módulo: cwCopiaPlano.php
	  Copia um Plano de Contas de uma Empresa para Outra
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

		  $cabec = new TituloCw( $cabecCopiaPlano );
		  $cabec->mostra();
?>
<body class="pagina" onLoad="this.document.formCopiaPlano.oidEmpresaOrigem.focus();">

	<div align="center">

	<br><br>

	<form action="cwCopiaPlano.php"
				name="formCopiaPlano" method="get">

	<input type="hidden" name="controleNavegacao" value="1">


		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloCopiaPlano; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwConsPlano')">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>

		<!-- Opções do Menu -->
		<table class="cjanela" border="0" width="100%">

            <tr>
				<td width="30%" align="right" class="cjanela">
				<?PHP echo $campoObservacoes; ?>
				</td>
                <td width="70%" align="justify" class="cjanela">
                <?PHP echo $msgCopiaPlano; ?>
                </td>
            </tr>
            
			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoEmpresaOrigem; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="oidEmpresaOrigem" class="dljanela">
					<? for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) { ?>
					   <option value="<?= $listaEmpresas[$indx][0]; ?>"><?= $listaEmpresas[$indx][1]; ?></option>
					<? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoEmpresaDestino; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="oidEmpresaDestino" class="dljanela">
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
					<input type="submit" class="bjanela" value="<?PHP echo $botaoCopiarPlano; ?>" name="bt_copiar">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
					OnClick="javascript:history.go(-1);">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoAjuda; ?>" name="bt_ajuda"
					OnClick="javascript:abreAjuda('../cw_ajuda.html#cwConsPlano');">
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

		 $conta = new Conta();
		 if ( $conta->copiaPlanoContas( $oidEmpresaOrigem, $oidEmpresaDestino) == false ) {
			echo "<body class=\"pagina\"><center>";
			$msg = new MsgCw( $msgCopiaInvalida,
				"../imagens/contabil.jpg", "javascript:history.go(-1);" );
			$msg->mostra();
			echo "</center></body>"; 
			exit;
		 } else {
			echo "<body class=\"pagina\"><center>";
			$msg = new MsgCw( $msgCopiaOk,
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
		  $cabec = new TituloCw( $cabecConsPlano );
		  $cabec->mostra();

		 $conta = new Conta();
		 $conta->consultaPlanoContasPDF( $oidEmpresaCont, $oidEmpresa );
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
		  $cabec = new TituloCw( $cabecConsPlano );
		  $cabec->mostra();

		// Exibe mensagem...
		if ( @file( "../pdfs/".PDF_PLANO_CONTAS ) ) {
			$msg = new MsgCw( $msgCliqueAquiParaVisualizar,
		       "../imagens/contabil.jpg", "javascript:history.go(-2);" );
			   $msg->mostraMsgLink( "../pdfs/".PDF_PLANO_CONTAS, true );
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
