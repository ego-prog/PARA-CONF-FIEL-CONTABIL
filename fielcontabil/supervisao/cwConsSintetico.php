<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe oid da Empresa
	$oidEmpresa = $oidEmpresaSession;

	// Carrega lista de empresas
	$listaEmpresas = array();
	$listaEmpresas[] = array( "1", "Empresa 1", "9.9.99.99.9999", "9.9.999" );
	$listaEmpresas[] = array( "2", "Empresa 2", "99.99.99.99.99", "9.9.999" );
?>

<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 25/06/2003
	Última Atualização: 14/07/2003
	Módulo: cwConsSintetico.php
	  Consulta Balancete Sintético
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

		  $cabec = new TituloCw( $cabecConsSintetico );
		  $cabec->mostra();
?>
<body class="pagina" onLoad="this.document.formConsSintetico.dataInicial.focus();">

	<div align="center">

	<br><br>

	<form action="cwConsSintetico.php"
				name="formConsSintetico" method="get" onSubmit="return validaDados();">

	<input type="hidden" name="controleNavegacao" value="1">


		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloConsSintetico; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwConsSintetico')">
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
					OnClick="javascript:abreAjuda('../cw_ajuda.html#cwConsSintetico');">
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

	 // Pesquisa lancamentos realizados no periodo e retorna array com estas opcoes...
	 $lista[] = array( "4480.27", "1", "Ativo", "C", "310.43" );
	 $lista[] = array( "1883.52", "1.1", "Circulante", "C", "86.00" );
	 $lista[] = array( "1883.52", "1.1.01", "Disponível", "C", "86.00" );
	 $lista[] = array( "702.87", "1.1.01.001", "Caixa", "C", "86.00" );
	 $lista[] = array( "-8776.73", "3.2", "Despesas", "D", "310.43" );
	 $lista[] = array( "-8698.15", "3.2.01", "Despesas Operacionais", "D", "310.43" );
	 $lista[] = array( "-8698.15", "3.2.01.001", "Despesas Operacionais", "D", "310.43" );

	 ?>

<body class="pagina">

	<div align="center">

		<!-- Mostra o resultado da consulta, esta sera validada com
		o Framework de relatorio -->
		<br><br><br>
		<center>
		<font face="Verdana, Arial" color="#000099" size="2">
		<b><?= $relatorioBalanceteSintetico; ?></b><br>
		<?= $oidEmpresaCont." - Empresa ".$oidEmpresaCont; ?></font>
		</center>
		<br>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="15%" class="tjanela" align="left">
				<?= $relatorioConta; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="25%" class="tjanela" align="left">
				<?= $relatorioDescricao; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="15%" class="tjanela" align="right">
				<?= $relatorioSaldoAnterior; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="15%" class="tjanela" align="right">
				<?= $relatorioDebito; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="15%" class="tjanela" align="right">
				<?= $relatorioCredito; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="15%" class="tjanela" align="right">
				<?= $relatorioSaldoAtual; ?>
			</td>
			</tr>

	     <?
	       for ( $indx = 0; $indx < sizeof( $lista ); $indx++ ) {
	       $cor = ($indx % 2 ) == 0?"lcons1":"lcons2";
	     ?>
			<tr>
			<td width="15%" align="left" class="<?= $cor; ?>">
			<?= $lista[$indx][1]; ?>
			</td>
			<td width="25%" align="left" class="<?= $cor; ?>">
			<? for ( $indy = 0; $indy < strlen( $lista[$indx][1] ) - 1; $indy++ )
			       echo CW_HTML_BRANCO;
			       echo $lista[$indx][2]; ?>
			</td>
			<td width="15%" align="right" class="<?= $cor; ?>">
			<?= Numero::convReal( $lista[$indx][0] )." ".($lista[$indx][0]>0?"D":"C"); ?>
			</td>
			<td width="15%" align="right" class="<?= $cor; ?>">
			<?  if ( $lista[$indx][3] == "D" ) {
				  echo Numero::convReal( $lista[$indx][4] ); }
			    else
				  echo Numero::convReal( "0" ); ?>
			</td>
			<td width="15%" align="right" class="<?= $cor; ?>">
			<?  if ( $lista[$indx][3] == "C" ) {
				  echo Numero::convReal( $lista[$indx][4] ); }
			    else
				  echo Numero::convReal( "0" ); ?>
			</td>
			<td width="15%" align="right" class="<?= $cor; ?>">
			<?
			  $saldoAtual = ($lista[$indx][3] == "D")?( $lista[$indx][0] +
				      $lista[$indx][4] ):( $lista[$indx][0] - $lista[$indx][4] );
			      echo Numero::convReal( $saldoAtual )." ".($lista[$indx][0]>0?"D":"C");
			?>

			</td>
			</tr>
		  <? } ?>

	      </table>

	      <form>

	      <? if ( !empty( $exibeContador ) && $exibeContador ) { ?>
		 <table class="pagina" border="0" width="100%">

			<tr>
				<td width="100%" align="center" class="lcons2">
					<?= "Carmen D´Elia Branco"; ?>
				</td>
			</tr>
			<tr>
				<td width="100%" align="center" class="lcons2">
					<?= "CRC 10210-10"; ?>
				</td>
			</tr>

		 </table>
		 <br><br>
	      <? } ?>

	      <table class="pagina" border="0" width="100%">

			<tr>
				<td width="100%" align="center">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoGerarPDF; ?>" name="bt_gerar"
					OnClick="javascript:alert('Geraria o arquivo formato PDF');">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoImprimir; ?>" name="bt_imprimir"
					OnClick="javascript:window.print();">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
					OnClick="javascript:history.go(-1);">
				</td>
			</tr>

	     </table>

	     </form>

      </div>
</body>
	      <?
		break; }

	   case 2: {

		// Aqui executa o metodo de conversao para PDF
		// Exibe mensagem...
		$msg = new MsgCw( $msgDocumentoNaoDisponivel,
			"../imagens/contabil.jpg", "javascript:history.go(-1);" );
		$msg->mostra();
		exit();


		break;
	   }

  }

?>
</html>
