<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe oid da Empresa
	$oidEmpresa = $oidEmpresaSession;
	$perfilUsuario = $perfilUsuarioSession;
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

	Data de Criação: 25/04/2003
	Última Atualização: 25/07/2003
	Módulo: cwLiberaLanc.php
	  Libera lançamentos não contabilizados
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
	// liberaLanc()
	// - Libera lancamentos
	//--------------------------------------------
	function liberaLanc() {

		document.formRelLiberaLanc.tipoOperacao.value=19;
		document.formRelLiberaLanc.submit();

	}

	//--------------------------------------------
	// verificaOpcao()
	// - Verifica opcao
	//--------------------------------------------
	function verificaOpcao() {

		retorna = true;

		document.formRelLiberaLanc.tipoOperacao.value == 20;
		
		if( !confirm( 'Tem certeza que deseja excluir lançamentos selecionados?' ) ) {
				retorna = false;
		}

		return retorna;
		
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

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	if ( empty( $controleNavegacao ) )
		$controleNavegacao = 0;

		  $cabec = new TituloCw( $cabecLiberaLanc );
		  $cabec->mostra();

	 switch( $controleNavegacao ) {

	 default: {

?>
<body class="pagina" onLoad="this.document.formLiberaLanc.dataInicial.focus();">

	<div align="center">

	<br><br>

	<form action="cwLiberaLanc.php"
				name="formLiberaLanc" method="get" onSubmit="return validaDados();">

	<input type="hidden" name="controleNavegacao" value="1">


		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloLiberaLanc; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwLiberaLanc')">
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
				<td width="30%" align="right">&nbsp;
				</td>
				<td width="70%" align="left">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoConsultar; ?>" name="bt_consultar">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
					OnClick="javascript:history.go(-1);">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoAjuda; ?>" name="bt_ajuda"
					OnClick="javascript:abreAjuda('../cw_ajuda.html#cwLiberaLanc');">
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

	 // Pesquisa lancamentos não contabilizados no periodo para a empresa
	 $empresa	 = new Empresa();
	 $lancamento	 = new Lancamento();
	 $itemLancamento = new ItemLancamento();
	 $conta 	 = new Conta();
	 
	 $empresa->pesquisaEmpresa( $oidEmpresaCont );
	 $lista = $lancamento->buscaLancamentosPeriodo( $dataInicial, $dataFinal, 
						$oidEmpresaCont, $loginUsuario );
						
	 if ( $lista[0][0] == "0" ) {
			echo "<body class=\"pagina\"><center>";
			$msg = new MsgCw( $msgConsultaInvalida,
				"../imagens/contabil.jpg", "javascript:history.go(-1);" );
			$msg->mostra();
			echo "</center></body>"; 
			exit;
		 }

	 ?>

<body class="pagina">

	<div align="center">

		<!-- Mostra o resultado da consulta, esta sera validada com
		o Framework de relatorio -->
		<br><br><br>
		<center>
		<font face="Verdana, Arial" color="#000099" size="2">
		<b><?= $relatorioLiberaLanc; ?></b><br>
		<?= $oidEmpresaCont." - ".$empresa->getRazaoSocial(); ?></font>
		</center>
		<br>
		<form method="GET" action="cwGravaSupervisao.php" name="formRelLiberaLanc" 
				onSubmit="return verificaOpcao();">
		<input type="hidden" name="tipoOperacao" value="20">
		
		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="center">
				<?= $relatorioLancamento; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="left">
				<?= $relatorioConta; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="20%" class="tjanela" align="left">
				<?= $relatorioDescricao; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="35%" class="tjanela" align="left">
				<?= $relatorioHistorico; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="right">
				<?= $relatorioDebito; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="right">
				<?= $relatorioCredito; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="5%" class="tjanela" align="center">
				&nbsp;
			</td>
			</tr>
			<input type="hidden" name="dataInicial"    value="<?= $dataInicial; ?>">
			<input type="hidden" name="dataFinal"	   value="<?= $dataFinal; ?>">
			<input type="hidden" name="oidEmpresaCont" value="<?= $oidEmpresaCont; ?>">
			<input type="hidden" name="loginUsuario"   value="<?= $loginUsuario; ?>">

	     <?

		// controle do checkbox...
		$totalDebito = $totalCredito = 0;
		$listaCodigo = array();
		for ( $indx = 0; $indx < sizeof( $lista ); $indx++ ) {
			$listaCodigo[$indx][0] = $lista[$indx][0];
			$listaCodigo[$indx][1] = false;
		}

		for ( $indx = 0; $indx < sizeof( $lista ); $indx++ ) {

			$itens = $itemLancamento->buscaItemLancamento( $lista[$indx][0] );
			
			for ( $indy = 0; $indy < sizeof( $itens ); $indy++ ) {
			
				$cor = ($indy % 2 ) == 0?"lcons1":"lcons2";

				$oidConta = $itens[$indy][2].".".Numero::modulo11( $itens[$indy][2] );
				$conta->pesquisaConta( $oidConta );
	     ?>
			<tr>
			<td width="10%" align="center" class="<?= $cor; ?>">
			<?= $lista[$indx][0]." - ".$lista[$indx][1]; ?>
			</td>
			<td width="10%" align="left" class="<?= $cor; ?>">
			<?= $conta->getCodigoSintetico(); ?>			
			</td>
			<td width="20%" align="left" class="<?= $cor; ?>">
			<?= $conta->getDescricao(); ?>
			</td>
			<td width="35%" align="left" class="<?= $cor; ?>">
			<?= $itens[$indy][3]; ?>
			</td>
			<td width="10%" align="right" class="<?= $cor; ?>">
				<? if ( $itens[$indy][5] == "D" ) {
					if ( $itens[$indy][4] > 0 )
						echo Numero::convReal( $itens[$indy][4] );
					}
					else echo "&nbsp;"; ?>
			</td>
			<td width="10%" align="right" class="<?= $cor; ?>">
				<? if ( $itens[$indy][5] == "C" ) {
					if ( $itens[$indy][4] > 0 )
						echo Numero::convReal( $itens[$indy][4] );
					}
					else echo "&nbsp;"; ?>
			</td>
			<td width="5%" align="center" class="<?= $cor; ?>">
			   <? if ( !$listaCodigo[$indx][1] ) {
			      $nomeCampo = "lanc_".$lista[$indx][0]; ?>
			      <input type="checkbox" name="<?= $nomeCampo; ?>" checked>
			    <? for ( $indz = 0; $indz < sizeof( $listaCodigo ); $indz++ ) {
			       if ( $lista[$indx][0] == $listaCodigo[$indz][0] )
						$listaCodigo[$indz][1] = true;
			       }
			   }
			   else echo "&nbsp;";
			   ?>

			</td>
			</tr>
	      <?
			if ( $itens[$indy][5] == "D" )
				$totalDebito  += $itens[$indy][4];
			else
				$totalCredito += $itens[$indy][4];
			  
	       }
		}
	       ?>
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="center">
				&nbsp;
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="left">
				&nbsp;
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="20%" class="tjanela" align="left">
				&nbsp;
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="35%" class="tjanela" align="right">
				<?= $relatorioTotais; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="right">
				<?= Numero::convReal( $totalDebito ); ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="right">
				<?= Numero::convReal( $totalCredito ); ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="5%" class="tjanela" align="center">
				&nbsp;
			</td>
			</tr>

		  </table>

	      <table class="pagina" border="0" width="100%">

			<tr>
				<td width="100%" align="center">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoImprimir; ?>" name="bt_imprimir"
					OnClick="javascript:window.print();">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoLiberarSelec; ?>" name="bt_liberar"
					OnClick="liberaLanc();">
					<input type="submit" class="bjanela"
					value="<?PHP echo $botaoExcluirSelec; ?>" name="bt_excluir">
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
