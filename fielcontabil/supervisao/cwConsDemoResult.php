<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe oid da Empresa
	$oidEmpresa = $oidEmpresaSession;
	$perfilUsuario = $perfilUsuarioSession;
	$loginUsuario  = $loginSession;

	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";

	// Carrega lista de empresas
	$empresa = new Empresa();
	$listaEmpresas = $empresa->buscaEmpresa( $oidEmpresa, "", 1, $loginUsuario );

	$centro = new CentroCusto();
	$listaCentros = $centro->buscaCentroCusto(0,"");
?>

<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 25/06/2003
	Última Atualização: 04/05/2003
	Módulo: cwConsDemoResult.php
	  Consulta Demonstrativo de Resultados
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

	//--------------------------------------------
	// testaNulo()
	// - Testa se campo é nulo
	//--------------------------------------------
	function testaNulo( nome_campo ) {

		return ( nome_campo.value.length == 0 )?true:false;

	}

	//--------------------------------------------
	// criaVetor()
	// - Cria vetor com tamanho especificado
	//--------------------------------------------
	function criaVetor( tamanho ) {

		this.lenght = tamanho;
		for (var i=0; i< tamanho; i++)
			this[i] = 0;
		return this;

	}

	//--------------------------------------------
	// validaData()
	// - Valida data especificada
	//--------------------------------------------
	function validaData( data_digitada ) {

		var dia, mes, ano, data_tmp;
		data_tmp = data_digitada.value;
		// Testa se possui estrutura 99/99/9999

		if ( ( data_tmp.charAt(2) != '/' ) || ( data_tmp.charAt(5) != '/' ) )
			return false;

		// Recebe informações de dia, mes e ano
		dia = data_tmp.substring(0,2);
		mes = data_tmp.substring(3,5);
		ano = data_tmp.substring(6,10);

		// Cria vetor com número de dias dos meses...
		vet_dia = new criaVetor(12);
		vet_dia[0] = 31;
		vet_dia[1] = 28;
		vet_dia[2] = 31;
		vet_dia[3] = 30;
		vet_dia[4] = 31;
		vet_dia[5] = 30;
		vet_dia[6] = 31;
		vet_dia[7] = 31;
		vet_dia[8] = 30;
		vet_dia[9] = 31;
		vet_dia[10] = 30;
		vet_dia[11] = 31;

		// Se ano bissexto
		if ( ( ano % 4 ) == 0 )
			vet_dia = 29;

		if ( mes < 1 || mes > 12 )
			return false;

		if ( dia < 1 || dia > vet_dia[mes-1] )
			return false;

		return true;

	}

	//--------------------------------------------
	// validaDados()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaDados( controle ) {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- Data Inicial
			if ( testaNulo( document.forms[0].dataInicial ) ) {
				mensagem += '\n - Data inicial não preenchida';
				retorna = false; }

			// -- Data Inicial
			if ( !validaData( document.forms[0].dataInicial ) ) {
				mensagem += '\n - Data inicial inválida';
				retorna = false; }

			// -- Data Final
			if ( testaNulo( document.forms[0].dataFinal ) ) {
				mensagem += '\n - Data final não preenchida';
				retorna = false; }

			// -- Data Final
			if ( !validaData( document.forms[0].dataFinal ) ) {
				mensagem += '\n - Data final inválida';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem );
				document.forms[0].dataInicial.focus(); }

		return retorna;

	}

</SCRIPT>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="../estilo/cw.css">

</head>

<?PHP

	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	if ( empty( $controleNavegacao ) )
		$controleNavegacao = 0;

	 switch( $controleNavegacao ) {

	 default: {

		  $cabec = new TituloCw( $cabecConsDemoResult );
		  $cabec->mostra();
?>
<body class="pagina" onLoad="this.document.formConsDemoResult.dataInicial.focus();">

	<div align="center">

	<br><br>

	<form action="cwConsDemoResult.php"
				name="formConsDemoResult" method="get" onSubmit="return validaDados();">

	<input type="hidden" name="controleNavegacao" value="1">


		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloConsDemoResult; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwConsDemoResult')">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>

		<!-- Opções do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="30%" align="right" class="cjanela"><?PHP echo $campoDataInicial; ?>
				</td>
				<td align="left" width="70%" class="cjanela">
				   <input type="text" class="txjanela" name="dataInicial"
						size="10" maxlength="10">

				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela"><?PHP echo $campoDataFinal; ?>
				</td>
				<td align="left" width="70%" class="cjanela">
				   <input type="text" class="txjanela" name="dataFinal"
						size="10" maxlength="10">

				</td>
			</tr>

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

			<? if ( $perfilUsuario != "O" && $perfilUsuario != "C" ) { ?>
				<tr>
					<td width="30%" align="right" class="cjanela"><?PHP echo $campoPaginaInicial; ?>
					</td>
					<td align="left" width="70%" class="cjanela">
					<input type="text" class="txjanela" name="paginaInicial"
							size="10" maxlength="10">

					</td>
				</tr>
			<? }
			else
				echo "<input type=\"hidden\" name=\"paginaInicial\" value=\"1\">";
			?>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoCentroCusto; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="oidCentroCusto" class="dljanela">
					<option value="0" selected><?= $campoTodosCentros; ?></option>
					<? for ( $indx = 0; $indx < sizeof( $listaCentros ); $indx++ ) { ?>
					   <option value="<?= $listaCentros[$indx][0]; ?>"><?= $listaCentros[$indx][1]; ?></option>
					<? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">&nbsp;
				</td>
				<td align="left" width="70%" class="cjanela">
				   <input type="checkbox" class="cbjanela" name="exibeNaoLiberado"
						value="false"><?= $msgExibeIncluirNaoLiberados; ?>
				</td>
			</tr>
			
			<tr>
				<td width="30%" align="right" class="cjanela">&nbsp;
				</td>
				<td align="left" width="70%" class="cjanela">
				   <input type="checkbox" class="cbjanela" name="desconsiderarZeramento"
						value="false"><?= $msgDesconsiderarZeramentos; ?>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">&nbsp;
				</td>
				<td align="left" width="70%" class="cjanela">
				   <input type="checkbox" class="cbjanela" name="exibeContador"
						value="false"><?= $msgExibeContador; ?>
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
					OnClick="javascript:abreAjuda('../cw_ajuda.html#cwConsDemoResult');">
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

		 $lancamento = new Lancamento();
		 if ( $lancamento->consultaDemonstrativo( $dataInicial, $dataFinal,
					$oidEmpresaCont, $oidEmpresa, $paginaInicial, $exibeNaoLiberado,
						$exibeContador, $perfilUsuario, $oidCentroCusto, $desconsiderarZeramento ) == false ) {
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
		  $cabec = new TituloCw( $cabecConsDemoResult );
		  $cabec->mostra();

		 $lancamento = new Lancamento();
		 $lancamento->consultaDemonstrativoPDF( $dataInicial, $dataFinal,
					$oidEmpresaCont, $oidEmpresa, $paginaInicial,
						$exibeContador, $desconsiderarZeramento );

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
		  $cabec = new TituloCw( $cabecConsDemoResult );
		  $cabec->mostra();

		// Exibe mensagem...
		if ( @file( "../pdfs/".PDF_DEMO_RESULT ) ) {
			$msg = new MsgCw( $msgCliqueAquiParaVisualizar,
		       "../imagens/contabil.jpg", "javascript:history.go(-2);" );
			   $msg->mostraMsgLink( "../pdfs/".PDF_DEMO_RESULT, true );
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
<?
	   }

  }

?>
</html>
