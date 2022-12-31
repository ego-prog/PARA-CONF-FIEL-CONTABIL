<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe oid da Empresa
	$oidEmpresa    = $oidEmpresaSession;
	$perfilUsuario = $perfilUsuarioSession;
	$loginUsuario  = $loginSession;
	
	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";

	// Carrega lista de empresas
	$empresa = new Empresa();
	$listaEmpresas = $empresa->buscaEmpresa( $oidEmpresa, "", 3, $loginUsuario );

?>
<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 25/04/2003
	Última Atualização: 12/07/2003
	Módulo: cwZeramentoContas.php
	  Zeramento de Contas
-->
<html>
<head>
<title>::FIEL Contábil::</title>


<script language="javascript">

	var empresas	     = new Array;

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
	// validaPeriodo()
		// - Valida data especificada
	//--------------------------------------------
	function validaPeriodo( data_atual, data_inicial, data_final ) {

		var dia_atual, mes_atual, ano_atual, data_atual_tmp;
		var dia_inicial, mes_inicial, ano_inicial, data_inicial_tmp;
		var dia_final, mes_final, ano_final, data_final_tmp;
		var data_inicial_inv, data_final_inv, data_atual_inv;

		data_atual_tmp	 = data_atual.value;
		data_inicial_tmp = data_inicial.value;
		data_final_tmp	 = data_final.value;

		// Testa se possui estrutura 99/99/9999
		if ( ( data_inicial_tmp.charAt(2) != '/' ) || ( data_inicial_tmp.charAt(5) != '/' ) )
			return false;

		// Testa se possui estrutura 99/99/9999
		if ( ( data_final_tmp.charAt(2) != '/' ) || ( data_final_tmp.charAt(5) != '/' ) )
			return false;

		// Testa se possui estrutura 99/99/9999
		if ( ( data_atual_tmp.charAt(2) != '/' ) || ( data_atual_tmp.charAt(5) != '/' ) )
			return false;

		// Recebe informações de dia, mes e ano
		dia_inicial = data_inicial_tmp.substring(0,2);
		mes_inicial = data_inicial_tmp.substring(3,5);
		ano_inicial = data_inicial_tmp.substring(6,10);

		// Recebe informações de dia, mes e ano
		dia_final = data_final_tmp.substring(0,2);
		mes_final = data_final_tmp.substring(3,5);
		ano_final = data_final_tmp.substring(6,10);

		// Recebe informações de dia, mes e ano
		dia_atual = data_atual_tmp.substring(0,2);
		mes_atual = data_atual_tmp.substring(3,5);
		ano_atual = data_atual_tmp.substring(6,10);

		data_inicial_inv = ano_inicial + mes_inicial + dia_inicial;
		data_final_inv	 = ano_final + mes_final + dia_final;
		data_atual_inv	 = ano_atual + mes_atual + dia_atual;

		if ( data_atual_inv < data_inicial_inv ||
		    data_atual_inv > data_final_inv )
		   return false;

		return true;

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

			// -- Data lancamento
			if ( testaNulo( document.forms[0].dataLanc ) ) {
				mensagem += '\n - Data de lançamento não preenchida';
				retorna = false; }

			// -- Data lancamento
			if ( !validaData( document.forms[0].dataLanc ) ) {
				mensagem += '\n - Data de lançamento inválida';
				retorna = false; }

			// -- Se esta enquadrado no periodo
			if ( !validaPeriodo( document.forms[0].dataLanc,
				       document.forms[0].dataInicialEmpresa,
				       document.forms[0].dataFinalEmpresa ) ) {
				mensagem += '\n - Data inválida para período contábil da empresa';
				retorna = false; }

			// -- Data limite
			if ( testaNulo( document.forms[0].dataLimite ) ) {
				mensagem += '\n - Data de limite não preenchida';
				retorna = false; }

			// -- Data limite
			if ( !validaData( document.forms[0].dataLimite ) ) {
				mensagem += '\n - Data de limite inválida';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem );
				document.forms[0].dataLanc.focus(); }

		return retorna;

	}

	//--------------------------------------------
	// executaZeramento()
	// - Executa zeramento
	//--------------------------------------------
	function executaZeramento() {

		document.forms[0].tipoOperacao.value=27;
		document.forms[0].submit();

	}

	//--------------------------------------------
	// verificaOpcao()
	// - Verifica opcao
	//--------------------------------------------
	function verificaOpcao() {

		retorna = true;

		if( !confirm( 'Tem certeza que deseja executar o zeramento de contas de resultado?' ) ) {
				retorna = false;
		}

		return retorna;
		
	}

	//--------------------------------------------
	// carregaColecaoEmpresa()
	// - Carrega colecao da empresa
	//--------------------------------------------
	function carregaColecaoEmpresa() {

		<?
		echo "\n";
		for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) {
		echo "		empresas[$indx]    = new Array;\n";
		echo "		empresas[$indx][0] = ".$listaEmpresas[$indx][0].";\n";
		echo "		empresas[$indx][1] = '".$listaEmpresas[$indx][1]."';\n";
		echo "		empresas[$indx][2] = '".$listaEmpresas[$indx][2]."';\n";
		echo "		empresas[$indx][3] = '".$listaEmpresas[$indx][3]."';\n";
		echo "		empresas[$indx][4] = '".$listaEmpresas[$indx][4]."';\n";
		echo "		empresas[$indx][5] = '".$listaEmpresas[$indx][5]."';\n";
		}

		echo "\n	  setaEmpresa( empresas[0][0] );\n\n";
		?>
	}

	//--------------------------------------------
	// setaEmpresa()
	// - Troca informacao da empresa
	//--------------------------------------------
	function setaEmpresa( codigoEmpresa ) {

		var indx;
		 for ( indx = 0; indx < <?= sizeof( $listaEmpresas ); ?>; indx++ ) {
		   if ( empresas[indx][0] == codigoEmpresa ) {
		      document.forms[0].dataInicialEmpresa.value = empresas[indx][4];
		      document.forms[0].dataFinalEmpresa.value	 = empresas[indx][5];
		      break; }
		 }

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

		  $cabec = new TituloCw( $cabecZeramentoContas );
		  $cabec->mostra();
?>
<body class="pagina" onLoad="carregaColecaoEmpresa();this.document.formZeramentoContas.dataLanc.focus();">

	<div align="center">

	<br><br>

	<form action="cwZeramentoContas.php"
				name="formZeramentoContas" method="get" onSubmit="return validaDados();">

	<input type="hidden" name="controleNavegacao" value="1">
	<input type="hidden" name="dataInicialEmpresa" value="<?= $listaEmpresas[0][4]; ?>">
	<input type="hidden" name="dataFinalEmpresa" value="<?= $listaEmpresas[0][5]; ?>">


		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloZeramentoContas; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwZeramentoContas')">
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
					<select name="oidEmpresaCont" class="dljanela" onChange="setaEmpresa(this.options[selectedIndex].value);">
					<? for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) { ?>
					   <option value="<?= $listaEmpresas[$indx][0]; ?>"><?= $listaEmpresas[$indx][1]; ?></option>
					<? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela"><?PHP echo $campoDataLanc; ?>
				</td>
				<td align="left" width="70%" class="cjanela">
				   <input type="text" class="txjanela" name="dataLanc"
						size="10" maxlength="10">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela"><?PHP echo $campoDataLimite; ?>
				</td>
				<td align="left" width="70%" class="cjanela">
				   <input type="text" class="txjanela" name="dataLimite"
						size="10" maxlength="10">
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				<?PHP echo $campoHistorico; ?>
				</td>
				<td align="left" width="80%" class="cjanela" valign="center">
					<textarea name="historico" class="txjanela"
						rows="5" cols="45" wrap="hard"></textarea>
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				<?PHP echo $campoHistoricoDestino; ?>
				</td>
				<td align="left" width="80%" class="cjanela" valign="center">
					<textarea name="historicoDestino" class="txjanela"
						rows="5" cols="45" wrap="hard"></textarea>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right">&nbsp;
				</td>
				<td width="70%" align="left">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoIncluir; ?>" name="bt_incluir">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
					OnClick="javascript:history.go(-1);">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoAjuda; ?>" name="bt_ajuda"
					OnClick="javascript:abreAjuda('../cw_ajuda.html#cwZeramentoContas');">
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
		 
		 // Pesquisa dados do zeramento...
		 $zeramento  = new Zeramento();
		 $conta      = new Conta();
		 $contrapartida = new Conta();
		 $lancamento = new Lancamento();
		 $empresa    = new Empresa();
		 $listaLancamentos = array();
		 
		 $empresa->pesquisaEmpresa( $oidEmpresaCont );
		 
		 $zeramento->setaZeramento( $oidEmpresaCont );
		 
		 $listaGrupos = array( $zeramento->getGrupo1(), $zeramento->getGrupo2(),
				$zeramento->getGrupo3(), $zeramento->getGrupo4(), $zeramento->getGrupo5() );
		 
		 for ( $indx = 0; $indx < sizeof( $listaGrupos ); $indx++ ) {
			if ( $listaGrupos[$indx] > 0 ) {
				$conta->pesquisaContaSemDV( $listaGrupos[$indx] );
				$listaConta[$indx] = $conta->buscaConta( $oidEmpresaCont, 
												$conta->getCodigoSintetico(), 5 );
				}
		 }
		 
		 for ( $indx = 0; $indx < sizeof( $listaConta ); $indx++ )
			for ( $indy = 0; $indy < sizeof( $listaConta[$indx] ); $indy++ ) {
				$saldo = $lancamento->buscaSaldoConta( $listaConta[$indx][$indy][0],
						$dataLimite, "S" );
				if ( $saldo != 0 )
					$listaLancamentos[] = array( $listaConta[$indx][$indy][0], $saldo );
			}

?>
<body class="pagina">

	<div align="center">

		<br><br><br>
		<center>
		<font face="Verdana, Arial" color="#000099" size="2">
		<b><?= $tituloZeramentoContas; ?></b><br>
		<?= $oidEmpresaCont." - ".$empresa->getRazaoSocial(); ?></font>
		</center>
		<br>
		<form method="GET" action="cwGravaSupervisao.php" name="formZeramento" 
				onSubmit="return verificaOpcao();">
		<input type="hidden" name="tipoOperacao" value="27">
		
		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="center">
				<?= $relatorioDataLanc; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="left">
				<?= $relatorioConta; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="30%" class="tjanela" align="left">
				<?= $relatorioDescricao; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="30%" class="tjanela" align="left">
				<?= $relatorioHistorico; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="right">
				<?= $relatorioDebito; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="right">
				<?= $relatorioCredito; ?>
			</td>
			</tr>
			<input type="hidden" name="tipoOperacao" value="27">			
			<input type="hidden" name="dataLanc"   value="<?= $dataLanc; ?>">
			<input type="hidden" name="dataLimite" value="<?= $dataLimite; ?>">
			<input type="hidden" name="historico" value="<?= $historico; ?>">
			<input type="hidden" name="historicoDestino" value="<?= $historicoDestino; ?>">
			<input type="hidden" name="oidEmpresaCont" value="<?= $oidEmpresaCont; ?>">
			<input type="hidden" name="contrapartida"  value="<?= $zeramento->getContrapartida(); ?>">
			<input type="hidden" name="loginUsuario"   value="<?= $loginUsuario; ?>">

		<?

		$totalDebito = $totalCredito = 0;

		for ( $indx = 0; $indx < sizeof( $listaLancamentos ); $indx++ ) {

			$cor = ($indx % 2 ) == 0?"lcons1":"lcons2";
			
			// Lanca o debito...
			if ( $listaLancamentos[$indx][1] > 0 ) {
				
				// Lancar um debito na contrapartida
				$conta->pesquisaContaSemDV( $zeramento->getContrapartida() );
				$contrapartida->pesquisaContaSemDV( $listaLancamentos[$indx][0]);
			
		?>
			<tr>
			<td width="10%" align="center" class="<?= $cor; ?>">
			<?= $dataLanc; ?>
			</td>

			<td width="10%" align="left" class="<?= $cor; ?>">
			<?= $conta->getCodigoSintetico(); ?>			
			</td>
			<td width="30%" align="left" class="<?= $cor; ?>">
			<?= $conta->getDescricao(); ?>
			</td>
			<td width="30%" align="left" class="<?= $cor; ?>">
			<?= str_replace("[nomeconta]", $contrapartida->getDescricao(), $historicoDestino); ?>
			</td>
			<td width="10%" align="right" class="<?= $cor; ?>">
				<? echo Numero::convReal( $listaLancamentos[$indx][1] ); ?>
			</td>
			<td width="10%" align="right" class="<?= $cor; ?>">
				<?= "&nbsp;"; ?>
			</td>
			</tr>
	      <?
			$totalDebito  += $listaLancamentos[$indx][1];
				
			// Lancar um credito na conta
			$conta->pesquisaContaSemDV( $listaLancamentos[$indx][0] );	
			
		?>
			<tr>
			<td width="10%" align="center" class="<?= $cor; ?>">
			<?= $dataLanc; ?>
			</td>

			<td width="10%" align="left" class="<?= $cor; ?>">
			<?= $conta->getCodigoSintetico(); ?>			
			</td>
			<td width="30%" align="left" class="<?= $cor; ?>">
			<?= $conta->getDescricao(); ?>
			</td>
			<td width="30%" align="left" class="<?= $cor; ?>">
			<?= $historico; ?>
			</td>
			<td width="10%" align="right" class="<?= $cor; ?>">
				<? echo "&nbsp;"; ?>
			</td>
			<td width="10%" align="right" class="<?= $cor; ?>">
				<? echo Numero::convReal( $listaLancamentos[$indx][1] ); ?>
			</td>
			</tr>
	      <?
			$totalCredito  += $listaLancamentos[$indx][1] * -1;
	       }

			// Lanca o credito...
			if ( $listaLancamentos[$indx][1] < 0 ) {
				
				// Lancar um credito na contrapartida
				$conta->pesquisaContaSemDV( $listaLancamentos[$indx][0] );	
			
		?>
			<tr>
			<td width="10%" align="center" class="<?= $cor; ?>">
			<?= $dataLanc; ?>
			</td>

			<td width="10%" align="left" class="<?= $cor; ?>">
			<?= $conta->getCodigoSintetico(); ?>			
			</td>
			<td width="30%" align="left" class="<?= $cor; ?>">
			<?= $conta->getDescricao(); ?>
			</td>
			<td width="30%" align="left" class="<?= $cor; ?>">
			<?= $historico; ?>
			</td>
			<td width="10%" align="right" class="<?= $cor; ?>">
				<? echo Numero::convReal( $listaLancamentos[$indx][1] ); ?>
			</td>
			<td width="10%" align="right" class="<?= $cor; ?>">
				<?= "&nbsp;"; ?>
			</td>
			</tr>
	      <?
			$totalDebito  += $listaLancamentos[$indx][1] * -1;
				
			// Lancar um credito na contrapartida
			$conta->pesquisaContaSemDV( $zeramento->getContrapartida() );	
   		    $contrapartida->pesquisaContaSemDV( $listaLancamentos[$indx][0]);
			
		?>
			<tr>
			<td width="10%" align="center" class="<?= $cor; ?>">
			<?= $dataLanc; ?>
			</td>

			<td width="10%" align="left" class="<?= $cor; ?>">
			<?= $conta->getCodigoSintetico(); ?>			
			</td>
			<td width="30%" align="left" class="<?= $cor; ?>">
			<?= $conta->getDescricao(); ?>
			</td>
			<td width="30%" align="left" class="<?= $cor; ?>">
			<?= str_replace("[nomeconta]", $contrapartida->getDescricao(), $historicoDestino); ?>
			</td>
			<td width="10%" align="right" class="<?= $cor; ?>">
				<? echo "&nbsp;"; ?>
			</td>
			<td width="10%" align="right" class="<?= $cor; ?>">
				<? echo Numero::convReal( $listaLancamentos[$indx][1] ); ?>
			</td>
			</tr>
	      <?
			$totalCredito  += $listaLancamentos[$indx][1];
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
			<td background="../imagens/cw_janela.gif" border="0" width="30%" class="tjanela" align="left">
				&nbsp;
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="30%" class="tjanela" align="right">
				<?= $relatorioTotais; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="right">
				<?= Numero::convReal( $totalDebito ); ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="right">
				<?= Numero::convReal( $totalCredito ); ?>
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
					value="<?PHP echo $botaoExecutarZeramento; ?>" name="bt_liberar"
					OnClick="executaZeramento();">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
					OnClick="javascript:history.go(-1);">
				</td>
			</tr>

	     </table>
		 <br><br>
	     </form>

      </div>
</body>
	      <?
		 
		 break;
	 }
  
  }

?>
</html>
