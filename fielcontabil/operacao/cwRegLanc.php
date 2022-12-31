<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe oid da Empresa
	$oidEmpresa    = $oidEmpresaSession;
	$loginUsuario  = $loginSession;
	$perfilUsuario = $perfilUsuarioSession;

	if ( empty( $oidEmpresaContCookie ) )
		setcookie( "oidEmpresaContCookie", -1 );

	if ( empty( $dataCookie ) )
		setcookie( "dataCookie", date( "d/m/Y" ) );

	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";

	// Carrega lista de empresas
	$empresa = new Empresa();
	$listaEmpresas = $empresa->buscaEmpresa( $oidEmpresa, "", 3, $loginUsuario );

	if ( !empty( $oidEmpresaCont ) ) {
		$conta = new Conta();
		$listaContas = $conta->buscaConta( $oidEmpresaCont, "", 3 );

		$historico = new HistoricoPadrao();
		$listaHistorico = $historico->buscaHistoricoPadrao( $oidEmpresaCont, "", 2 );

	}

?>

<!--
	FIEL Cont�bil
	Desenvolvido por APOENA Solu��es em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Cria��o: 25/04/2003
	�ltima Atualiza��o: 03/05/2005
	M�dulo: cwRegLanc.php
	  Registro de Lan�amentos
-->
<html>
<head>
<title>::FIEL Cont�bil::</title>


<script language="javascript">

	var colecaoConta	 = new Array;
	var colecaoHistorico = new Array;
	var empresas		 = new Array;
	var TOTAL_COMPOSICAO = <?= CW_TOTAL_COMPOSICAO; ?>;

	//--------------------------------------------
	// validaSelecaoItem()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaSelecaoItem() {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- Titulo da Consulta
			if ( document.forms[0].oidItemLancamento.selectedIndex == -1 ) {
				mensagem += '\n - Voc� deve selecionar um item do lan�amento';
				retorna = false; }

		if ( !retorna )
			alert( mensagem );

		return retorna;

	}

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
	// validaExclusaoLanc()
	// - Testa validade da exclusao de lancamento
	//--------------------------------------------
	function validaExclusaoLanc() {

		var retorna  = true;

			if( !confirm( 'Tem certeza que deseja excluir lan�amento?' ) )
					  retorna = false;

		return retorna;

	}

	//--------------------------------------------
	// validaConsDados()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaConsDados() {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- Data Inicial
			if ( testaNulo( document.forms[0].dataInicial ) ) {
				mensagem += '\n - Data inicial n�o preenchida';
				retorna = false; }

			// -- Data Inicial
			if ( !validaData( document.forms[0].dataInicial ) ) {
				mensagem += '\n - Data inicial inv�lida';
				retorna = false; }

			// -- Data Final
			if ( testaNulo( document.forms[0].dataFinal ) ) {
				mensagem += '\n - Data final n�o preenchida';
				retorna = false; }

			// -- Data Final
			if ( !validaData( document.forms[0].dataFinal ) ) {
				mensagem += '\n - Data final inv�lida';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem );
				document.forms[0].dataInicial.focus(); }

		return retorna;

	}

	//--------------------------------------------
	// setaValor()
	// - Seta valor recebido
	//--------------------------------------------
	function setaValor( numero ) {

		window.opener.setaOidLanc( numero );
		window.close();

	}

	//--------------------------------------------
	// consultaPlano()
	// - consulta plano de contas da empresa
	//--------------------------------------------
	function consultaPlano( url ) {

	   url = url + '&oidEmpresaCont=' + escape(document.formRegLanc.oidEmpresaCont.value);

	  window.open(url,'a','toolbar=no,directories=no,menubar=no,scrollbars=yes' );


	}

	//--------------------------------------------
	// consultaContraPartida()
	// - consulta (contra-partida) plano de contas da empresa
	//--------------------------------------------
	function consultaContraPartida( url ) {

	   url = url + '&cp=1&oidEmpresaCont=' + escape(document.formRegLanc.oidEmpresaCont.value);

	  window.open(url,'a','toolbar=no,directories=no,menubar=no,scrollbars=yes' );


	}

	//--------------------------------------------
	// consultaHistorico()
	// - consulta historico padrao da empresa
	//--------------------------------------------
	function consultaHistorico( url ) {

	   url = url + '&oidEmpresaCont=' + escape(document.formRegLanc.oidEmpresaCont.value);

	  window.open(url,'a','toolbar=no,directories=no,menubar=no,scrollbars=yes' );


	}

	//--------------------------------------------
	// excluirLancamento()
	// - Excluir lancamento
	//--------------------------------------------
	function excluirLancamento() {

	   document.location = "cwRegLanc.php?controleNavegacao=3&oidLancamento=" + escape(document.formRegLanc.oidLancamento.value);


	}

	//--------------------------------------------
	// alterarLancamento()
	// - Alterar lancamento
	//--------------------------------------------
	function alterarLancamento() {

	   document.location = "cwRegLanc.php?controleNavegacao=7&oidLancamento=" + escape(document.formRegLanc.oidLancamento.value);

	}

	//--------------------------------------------
	// imprimirSlip()
	// - Imprimir slip de lancamento
	//--------------------------------------------
	function imprimirSlip() {

	   document.location = "cwRegLanc.php?controleNavegacao=2&oidLancamento=" + escape(document.formRegLanc.oidLancamento.value);


	}

	//--------------------------------------------
	// alteraLancamento()
	// - Altera lancamento
	//--------------------------------------------
	function alteraLancamento() {

	   document.location = "cwRegLanc.php?controleNavegacao=4&oidLancamento=" + escape(document.formRegLanc.oidLancamento.value);


	}

	//--------------------------------------------
	// formataValor()
	// - Formata valor
	//--------------------------------------------
	function formataValor( valor ) {

		 var numero;
		 string = "" + valor;
		 numero = string.length - string.indexOf('.');
		 if (string.indexOf('.') == -1)
		 return string + '.00';
		 if (numero == 1)
			return string + '00';
		 if (numero == 2)
			return string + '0';
		 if (numero > 3)
			return string.substring(0,string.length-numero+3);
		 return string;

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

		// Recebe informa��es de dia, mes e ano
		dia = data_tmp.substring(0,2);
		mes = data_tmp.substring(3,5);
		ano = data_tmp.substring(6,10);

		// Cria vetor com n�mero de dias dos meses...
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

		// Recebe informa��es de dia, mes e ano
		dia_inicial = data_inicial_tmp.substring(0,2);
		mes_inicial = data_inicial_tmp.substring(3,5);
		ano_inicial = data_inicial_tmp.substring(6,10);

		// Recebe informa��es de dia, mes e ano
		dia_final = data_final_tmp.substring(0,2);
		mes_final = data_final_tmp.substring(3,5);
		ano_final = data_final_tmp.substring(6,10);

		// Recebe informa��es de dia, mes e ano
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
	// - Testa se campo � nulo
	//--------------------------------------------
	function testaNulo( nome_campo ) {

		return ( nome_campo.value.length == 0 )?true:false;

	}

	//--------------------------------------------
	// validaDados()
	// - Testa validade
	//--------------------------------------------
	function validaDados( operacao ) {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

		  // -- Verifica oidPlano
		  if ( testaNulo( document.forms[0].oidPlano ) ) {
			mensagem += '\n - Conta cont�bil n�o preenchida...';
			retorna = false; }

		  // -- testa nulo
		  if ( testaNulo( document.forms[0].historico ) ) {
			mensagem += '\n - Hist�rico n�o preenchido...';
			retorna = false; }

		  // -- Verifica valor
		  if ( testaNulo( document.forms[0].valor ) ) {
			mensagem += '\n - Valor n�o preenchido...';
			retorna = false; }

		  // -- Verifica valor ( > 0 )
		  if ( document.forms[0].valor.value <= 0 ) {
			mensagem += '\n - Valor inv�lido (n�o pode ser negativo ou zero)...';
			retorna = false; }

		if ( !retorna ) {
			alert( mensagem );
				document.forms[0].oidPlano.focus(); }

		return retorna;

	}

	//--------------------------------------------
	// validaCodigoLanc()
	// - Testa validade do codigo do lancamento
	//--------------------------------------------
	function validaCodigoLanc() {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

		  // -- Verifica valor
		  if ( testaNulo( document.forms[0].oidLancamento ) ) {
			mensagem += '\n - C�digo do lan�amento n�o preenchido...';
			retorna = false; }

		if ( !retorna ) {
			alert( mensagem );
			document.forms[0].oidLancamento.focus(); }

		return retorna;

	}

	//--------------------------------------------
	// validaInclusaoLanc()
	// - Testa validade do codigo do lancamento
	//--------------------------------------------
	function validaInclusaoLanc() {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

		  // -- Data lancamento...
		  if ( testaNulo( document.forms[0].dataLanc ) ) {
			mensagem += '\n - Data do lan�amento n�o preenchida';
			retorna = false; }

		  // -- Data lancamento
		  if ( !validaData( document.forms[0].dataLanc ) ) {
			mensagem += '\n - Data do lan�amento inv�lida';
			retorna = false; }

		  // -- Se esta enquadrado no periodo
		  if ( !validaPeriodo( document.forms[0].dataLanc,
					   document.forms[0].dataInicialEmpresa,
					   document.forms[0].dataFinalEmpresa ) ) {
				mensagem += '\n - Data inv�lida para per�odo cont�bil da empresa';
				retorna = false; }

		if ( !retorna ) {
			alert( mensagem );
			document.forms[0].dataLanc.focus(); }

		return retorna;

	}

	//--------------------------------------------
	// validaConta()
	// - Testa validade da conta cont�bil
	//--------------------------------------------
	function validaConta() {

		var indx;
		var retorna = false;

		for ( indx = 0; indx < colecaoConta.length; indx++ ) {

			if ( document.forms[0].oidPlano.value == colecaoConta[indx][0] && colecaoConta[indx][3] == 'A') {
			document.forms[0].descricaoConta.value = colecaoConta[indx][1] + ' - ' + colecaoConta[indx][2];
			retorna = true;
			break; }
		}

		if ( !retorna && !testaNulo( document.forms[0].oidPlano ) ) {
			alert( 'Conta n�o cadastrada... Consulte a lista' );
				document.forms[0].oidPlano.focus(); }

		return retorna;

	}

	//--------------------------------------------
	// validaContraPartida()
	// - Testa validade da contra-partida
	//--------------------------------------------
	function validaContraPartida() {

		var indx;
		var retorna = false;

		if ( testaNulo( document.forms[0].contraPartida ) )
		   return true;

		for ( indx = 0; indx < colecaoConta.length; indx++ ) {

			if ( document.forms[0].contraPartida.value == colecaoConta[indx][0] && colecaoConta[indx][3] == 'A' ) {
			document.forms[0].descricaoCP.value = colecaoConta[indx][1] + ' - ' + colecaoConta[indx][2];
			retorna = true;
			break; }
		}

		if ( !retorna ) {
			alert( 'Conta n�o cadastrada... Consulte a lista' );
				document.forms[0].contraPartida.focus(); }

		return retorna;

	}

	//--------------------------------------------
	// validaHistorico()
	// - Testa validade das Query
	//--------------------------------------------
	function validaHistorico() {

		var indx;
		var retorna = false;

		for ( indx = 0; indx < colecaoHistorico.length; indx++ ) {

			if ( document.forms[0].oidHistorico.value == colecaoHistorico[indx][0] ) {
			document.forms[0].historico.value = colecaoHistorico[indx][1];
			retorna = true;
			break; }
		}

		if ( !retorna ) {
			alert( 'Hist�rico padr�o n�o cadastrado... Consulte a lista' );
				document.forms[0].oidHistorico.focus(); }

		return retorna;

	}

	//--------------------------------------------
	// carregaColecaoEmpresa()
	// - Carrega colecao da empresa
	//--------------------------------------------
	function carregaColecaoEmpresa() {

		<?
		echo "\n";
		$oidEmpCookie = 0;
		for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) {
		echo "		empresas[$indx]    = new Array;\n";
		echo "		empresas[$indx][0] = ".$listaEmpresas[$indx][0].";\n";
		echo "		empresas[$indx][1] = '".$listaEmpresas[$indx][1]."';\n";
		echo "		empresas[$indx][2] = '".$listaEmpresas[$indx][2]."';\n";
		echo "		empresas[$indx][3] = '".$listaEmpresas[$indx][3]."';\n";
		echo "		empresas[$indx][4] = '".$listaEmpresas[$indx][4]."';\n";
		echo "		empresas[$indx][5] = '".$listaEmpresas[$indx][5]."';\n";

			if ( $oidEmpresaContCookie == $listaEmpresas[$indx][0] ) 
				$oidEmpCookie = $indx;

		}

		echo "\n	  setaEmpresa( empresas[".$oidEmpCookie."][0] );\n\n";
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
			  document.forms[0].mascaraCodigo.value  = empresas[indx][2];
			  document.forms[0].dataInicialEmpresa.value = empresas[indx][4];
			  document.forms[0].dataFinalEmpresa.value	 = empresas[indx][5];
			  break; }
		 }

	}

	//--------------------------------------------
	// carregaColecaoConta()
	// - Carrega colecao
	//--------------------------------------------
	function carregaColecaoConta() {

		<?
		if ( !empty( $oidEmpresaCont ) ) {
		$indy = 0;
		echo "\n";
			 for ( $indx = 0; $indx < sizeof( $listaContas ); $indx++ ) {
				if ( $oidEmpresaCont == $listaContas[$indx][0] ) {
		echo "		colecaoConta[$indy]    = new Array;\n";
		echo "		colecaoConta[$indy][0] = '".$listaContas[$indx][1]."';\n";
		echo "		colecaoConta[$indy][1] = '".$listaContas[$indx][2]."';\n";
		echo "		colecaoConta[$indy][2] = '".$listaContas[$indx][3]."';\n";
		echo "		colecaoConta[$indy][3] = '".$listaContas[$indx][4]."';\n";
		echo "		colecaoConta[$indy][4] = '".$listaContas[$indx][5]."';\n";
		echo "		colecaoConta[$indy][5] = '".$listaContas[$indx][6]."';\n";
		echo "		colecaoConta[$indy][6] = '".$listaContas[$indx][7]."';\n";
				$indy++;
				}
			}
		}
		?>

	}

	//--------------------------------------------
	// setaConta()
	// - Seta atributo que foi pesquisado anteriormente
	//--------------------------------------------
	function setaConta( valor1, valor2 ) {

		 // dados da conta
		 window.document.formRegLanc.oidPlano.value = valor1;
		 window.document.formRegLanc.descricaoConta.value = valor2;
		 document.forms[0].oidHistorico.focus();

	}

	//--------------------------------------------
	// setaContraPartida()
	// - Seta atributo que foi pesquisado anteriormente
	//--------------------------------------------
	function setaContraPartida( valor1, valor2 ) {

		 // dados da contra-partida
		 window.document.formRegLanc.contraPartida.value = valor1;
		 window.document.formRegLanc.descricaoCP.value = valor2;

	}

	//--------------------------------------------
	// setaHistorico()
	// - Seta atributo que foi pesquisado anteriormente
	//--------------------------------------------
	function setaHistorico( valor1, valor2 ) {

		 // Historico
		 window.document.formRegLanc.oidHistorico.value = valor1;
		 window.document.formRegLanc.historico.value = valor2;
		 document.forms[0].historico.focus();
	}

	//--------------------------------------------
	// carregaColecaoHistorico()
	// - Carrega colecao
	//--------------------------------------------
	function carregaColecaoHistorico() {

		<?
		if ( !empty( $oidEmpresaCont ) ) {
		$indy = 0;
		echo "\n";
			 for ( $indx = 0; $indx < sizeof( $listaHistorico ); $indx++ ) {
				if ( $oidEmpresaCont == $listaHistorico[$indx][0] ) {
		echo "		colecaoHistorico[$indy]    = new Array;\n";
		echo "		colecaoHistorico[$indy][0] = '".$listaHistorico[$indx][1]."';\n";
		echo "		colecaoHistorico[$indy][1] = '".$listaHistorico[$indx][2]."';\n";
				$indy++;
				}
			}
		}
		?>

	}

	//--------------------------------------------
	// setaOidLanc()
	// - Seta atributo que foi pesquisado anteriormente
	//--------------------------------------------
	function setaOidLanc( valor1 ) {

		 // Historico
		 window.document.formRegLanc.oidLancamento.value = valor1;
		 document.forms[0].oidLancamento.focus();
	}
	

	//--------------------------------------------
	// incluiItemLancamento( codLanc, oidEmpresaCont )
	// - Redireciona para a tela de inclus�o de itens
	//--------------------------------------------
	function incluiItemLancamento( codLanc, oidEmpresaCont ) {

		document.location = "cwRegLanc.php?controleNavegacao=10&oidLancamento=" + codLanc + "&oidEmpresaCont=" + oidEmpresaCont;

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

		  $cabec = new TituloCw( $cabecRegLanc );
		  $cabec->mostra();

?>
		<body class="pagina" onLoad="carregaColecaoEmpresa();this.document.formRegLanc.oidLancamento.focus();">

		<div align="center">

		<br>
		<form action="cwRegLanc.php"
					name="formRegLanc" method="get" onSubmit=" return validaInclusaoLanc();">

		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">
		<input type="hidden" name="controleNavegacao" value="1">
		<input type="hidden" name="loginUsuario" value="<?= $loginUsuario; ?>">
		
		<? 
		$flagCookie = false;
		for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) { 
			
			if ( $oidEmpresaContCookie == $listaEmpresas[$indx][0] ) { ?>
			<input type="hidden" name="mascaraCodigo" value="<?= $listaEmpresas[$indx][2]; ?>">
			<input type="hidden" name="dataInicialEmpresa" value="<?= $listaEmpresas[$indx][4]; ?>">
			<input type="hidden" name="dataFinalEmpresa" value="<?= $listaEmpresas[$indx][5]; ?>">
			<? 
				$flagCookie = true;
				break;
				} 
			}
			
		if ( $flagCookie == false ) { ?>
			<input type="hidden" name="mascaraCodigo" value="<?= $listaEmpresas[0][2]; ?>">
			<input type="hidden" name="dataInicialEmpresa" value="<?= $listaEmpresas[0][4]; ?>">
			<input type="hidden" name="dataFinalEmpresa" value="<?= $listaEmpresas[0][5]; ?>">
		<? } ?>
		
		<table class="ejanela" width="95%">
		<tr class="ejanela">
		<td>
		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloRegLanc; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="15%" class="tjanela" align="center">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwRegLanc')">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>

		</td>
		</tr>
		<tr>
		<td>

		<!-- Op��es do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="25%" align="right" class="cjanela">
				  &nbsp;
				</td>

				<td width="75%" align="left" class="cjanela">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoImprimirSlip; ?>" name="bt_imprimir"
						OnClick="if ( validaCodigoLanc() ) imprimirSlip();">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoAlterar; ?>" name="bt_alterar"
						OnClick="if ( validaCodigoLanc() ) alterarLancamento();">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoExcluir; ?>" name="bt_excluir"
						OnClick="if ( validaCodigoLanc() ) excluirLancamento();">
				</td>
			</tr>

			<tr>
				<td width="25%" align="right" class="cjanela">
				  <?PHP echo $campoCodigoLancamento; ?>
				</td>

				<td width="75%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="oidLancamento" size="15"
					   maxlength="15">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoConsultar; ?>" name="bt_consultar"
						OnClick="javascript:abreJanela('cwRegLanc.php?controleNavegacao=5');">
					<?= "<i>".$msgNaoInformarNovoLancamento."</i>"; ?>
				</td>
			</tr>

			<tr>
				<td width="25%" align="right" class="cjanela">
					<hr>
				</td>

				<td width="75%" align="left" class="cjanela">
					<hr>
				</td>
			</tr>

			<tr>
				<td width="25%" align="right" class="cjanela">
				  <?PHP echo $campoEmpresa; ?>
				</td>

				<td width="75%" align="left" class="cjanela">
					<select name="oidEmpresaCont" class="dljanela" onChange="setaEmpresa(this.options[selectedIndex].value);">
					<? for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) { ?>
					   <option value="<?= $listaEmpresas[$indx][0]; ?>"
					   <? if ( $oidEmpresaContCookie == $listaEmpresas[$indx][0] )
							echo " selected"; ?>><?= $listaEmpresas[$indx][1]; ?></option>
					<? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="25%" align="right" class="cjanela"><?PHP echo $campoDataLanc; ?>
				</td>
				<td align="left" width="75%" class="cjanela">
				   <input type="text" class="txjanela" name="dataLanc"
						size="10" maxlength="10" value="<?= $dataCookie; ?>">

				</td>
			</tr>

			<tr>
				<td width="25%" align="right">&nbsp;
				</td>
				<td width="75%" align="left">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoIncluir; ?>" name="bt_incluir">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
						OnClick="javascript:history.go(-1);">
				<input type="button" class="bjanela" name= "bt_ajuda"
					value="<?= $botaoAjuda; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwRegLanc')">

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
			break; }

		 // Inclui lancamento...
		 case 1: {

		  $cabec = new TituloCw( $cabecRegLanc );
		  $cabec->mostra();

		  for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ )
			  if ( $listaEmpresas[$indx][0] == $oidEmpresaCont )
			 $descEmpresa =  $listaEmpresas[$indx][1];

		  $lancamento	= new Lancamento();
		  $lancamento->buscaTotaisDC( $dataLanc, $loginUsuario, 
													$oidEmpresaCont );

		  $totalDebito	= $lancamento->getTotalDebito();
		  $totalCredito = $lancamento->getTotalCredito();

		  if ( $totalDebito == $totalCredito && $totalDebito != 0 ) {
			$totalDebito = $totalCredito = 0; }
		?>

	<body class="pagina" onLoad="carregaColecaoConta();carregaColecaoHistorico();document.formRegLanc.oidPlano.focus();">

	<div align="center">

	<br>

	<form action="cwGravaOperacao.php"
				name="formRegLanc" method="post" enctype="multipart/form-data" onSubmit="return validaDados( true );">

	<input type="hidden" name="tipoOperacao"   value="1">
	<input type="hidden" name="oidEmpresaCont" value="<?= $oidEmpresaCont; ?>">
	<input type="hidden" name="dataLanc"	   value="<?= $dataLanc; ?>">
	<input type="hidden" name="loginUsuario"   value="<?= $loginUsuario; ?>">
	<input type="hidden" name="totalDebito"    value="<?= $totalDebito; ?>">
	<input type="hidden" name="totalCredito"   value="<?= $totalCredito; ?>">

		<table class="ejanela" width="95%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="90%" class="tjanela">
				<?PHP echo $tituloRegLanc; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="center">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>

		<!-- Op��es do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoEmpresa; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <?= $oidEmpresaCont." - ".substr( $descEmpresa, 0, 30 )."&nbsp;&nbsp;&nbsp;&nbsp;".$campoDataLanc." ".$dataLanc."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$campoLogin."&nbsp;".$loginSession; ?>
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				 &nbsp;
				</td>

				<td width="80%" align="right" class="cjanela">
				  <?PHP echo "<b>".$campoTotal."</b>"; ?>
				  <?PHP echo $campoOperacaoDebito."&nbsp;"; ?>
				  <?= Numero::convReal( $totalDebito )."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - "; ?>
				  <?PHP echo $campoOperacaoCredito."&nbsp;"; ?>
				  <?= Numero::convReal( $totalCredito ); ?>
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoChaveAcesso; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="text" class="txjanela" name="oidPlano"
						size="15" maxlength="15" onChange="return validaConta();document.formRegLanc.oidHistorico.focus();">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoConsultar; ?>" name="bt_consultar"
						OnClick="javascript:consultaPlano('../supervisao/cwCadPlano.php?controleNavegacao=8&oidEmpresaCont=<?= $oidEmpresaCont; ?>');">

				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoDescricao; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="text" class="txinvis" name="descricaoConta"
						size="70" maxlength="70" onFocus="this.blur();document.formRegLanc.oidHistorico.focus();">
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoCodigo; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="text" class="txjanela" name="oidHistorico"
						size="15" maxlength="15" onChange="return validaHistorico();document.formRegLanc.historico.focus();">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoConsultarHistorico; ?>" name="bt_consultar"
						OnClick="javascript:consultaHistorico('../supervisao/cwCadHistorico.php?controleNavegacao=5');">

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
				  <?PHP echo $campoValor; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="text" class="txjanela" name="valor"
						size="15" maxlength="15">
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoOperacaoDB; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="radio" name="operacao" value="D" checked><?PHP echo $campoOperacaoDebito; ?>
				   <input type="radio" name="operacao" value="C"><?PHP echo $campoOperacaoCredito; ?>
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoContraPartida; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="text" class="txjanela" name="contraPartida"
						size="15" maxlength="15" onChange="return validaContraPartida();document.formRegLanc.oidCentroCusto.focus();">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoConsultar; ?>" name="bt_consultarConta"
						OnClick="javascript:consultaContraPartida('../supervisao/cwCadPlano.php?controleNavegacao=8&oidEmpresaCont=<?= $oidEmpresaCont; ?>');">
				   <input type="text" class="txinvis" name="descricaoCP"
						size="60" maxlength="70" onFocus="this.blur();document.formRegLanc.oidCentroCusto.focus();">
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoCentroCusto; ?>
				</td>
				<? $centroCusto = new CentroCusto();
				   $listaCentros = $centroCusto->buscaCentroCusto( $oidEmpresaCont, '' );
				?>
				<td width="80%" align="left">
					<select name="oidCentroCusto" class="dljanela">
					<option value="0" selected><?= $msgNenhum; ?></option>
					<? for ( $indx = 0; $indx < sizeof( $listaCentros ); $indx++ ) { ?>
					   <option value="<?= $listaCentros[$indx][0]; ?>"><?= $listaCentros[$indx][1]; ?></option>
					   <? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoArquivoAnexado; ?>
				</td>
				<td width="80%" align="left">
				    <input type="file" class="txjanela" name="arquivoAnexado" size="30">
				</td>
			</tr>

			<tr>
				<td width="20%" align="right">&nbsp;
				</td>
				<td width="80%" align="left">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoIncluir; ?>" name="bt_incluir">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
					OnClick="javascript:history.go(-1);">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoConsultarItens; ?>" name="bt_consultarItens"
					OnClick="javascript:abreJanela('cwRegLanc.php?controleNavegacao=9&dataLanc=<?= $dataLanc; ?>&oidEmpresaCont=<?= $oidEmpresaCont; ?>&loginUsuario=<?= $loginUsuario; ?>' );">
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
	 break; }

	 case 2: {

	 // Instancia objetos...
	 $empresa		 = new Empresa();
	 $lancamento	 = new Lancamento();
	 $itemLancamento = new ItemLancamento();
	 $conta 		 = new Conta();

	if ( empty( $operacaoJS ) )
		$operacaoJS = 0;

	 ?>

	<body class="pagina">

	<div align="center">
	<?
	 if ( !$lancamento->pesquisaLancamento( $oidLancamento ) ) {
		 $cabec = new TituloCw( $relatorioImprimirSlipTexto );
		 $cabec->mostra();
		 $msg = new MsgCw( $msgLancamentoNaoEncontrado );
		 $msg->mostra();
		 exit(); }

	 // Pesquisa objetos...

	 $empresa->pesquisaEmpresa( $lancamento->getOidEmpresaCont() );
	 $lista = $itemLancamento->buscaItemLancamento( $oidLancamento );

	 if ( $lancamento->getAberto() == "S" ) {
		 $cabec = new TituloCw( $relatorioImprimirSlipTexto );
		 $cabec->mostra();
		 $msg = new MsgCw( $msgLancamentoEmAberto );
		 $msg->mostra();
		exit; }


		$lancamento->imprimeSlip( $oidLancamento, $operacaoJS );
	?>
	 </div>
	 </body>

		  <?
		break; }

	 case 3: {

	 // Instancia objetos...
	 $empresa		 = new Empresa();
	 $lancamento	 = new Lancamento();
	 $itemLancamento = new ItemLancamento();
	 $conta 		 = new Conta();

	 ?>

	 <body class="pagina">

	<div align="center">
	<?

	 // Pesquisa objetos...
	 if ( !$lancamento->pesquisaLancamento( $oidLancamento ) ) {
		 $cabec = new TituloCw( $relatorioExcluirLancamento );
		 $cabec->mostra();
		 $msg = new MsgCw( $msgLancamentoNaoEncontrado );
		 $msg->mostra();
		 exit(); }

	 $empresa->pesquisaEmpresa( $lancamento->getOidEmpresaCont() );
	 $lista = $itemLancamento->buscaItemLancamento( $oidLancamento );

	 if ( strcmp( $lancamento->getContabilizado(), "S" ) == 0 && 
			strcmp( $perfilUsuario, "O" ) != 1 ) {

		 $cabec = new TituloCw( $relatorioExcluirLancamento );
		 $cabec->mostra();
		 $msg = new MsgCw( $msgLancamentoJaContabilizadoPeloSupervisor );
		 $msg->mostra();
		exit; }

	?>
		<!-- Mostra o resultado da consulta, esta sera validada com
		o Framework de relatorio -->
		<br><br><br>
		<center>
		<font face="Verdana, Arial" color="#000099" size="2">
		<b><?= $relatorioExcluirLancamento; ?></b><br><br>
		<?= $empresa->getOidEmpresaCont()." - ".$empresa->getRazaoSocial()."<br>"; ?>
		<?= $campoCodigoLancamento."&nbsp;".$oidLancamento." - ".$lancamento->getDataLancamento(); ?>
		</font>
		</center>
		<br>
		<form action="cwGravaOperacao.php" name="formExcluiLanc" method="GET" onSubmit="return validaExclusaoLanc();">
		<input type="hidden" name="tipoOperacao" value="2">
		<input type="hidden" name="oidLancamento" value="<?= $oidLancamento; ?>">

		<!-- Janela -->
		<table border="0" width="80%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="15%" class="tjanela" align="left">
				<?= $relatorioConta; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="15%" class="tjanela" align="left">
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

		 <?
		$totalDebito = $totalCredito = 0.0;
		for ( $indx = 0; $indx < sizeof( $lista ); $indx++ ) {
			$cor = ($indx % 2 ) == 0?"lcons1":"lcons2";
			$oidConta = $lista[$indx][2].".".Numero::modulo11( $lista[$indx][2] );
			$conta->pesquisaConta( $oidConta );
		 ?>
			<tr>
			<td width="15%" align="center" class="<?= $cor; ?>">
			<?= $conta->getCodigoSintetico()." (".$conta->getOidContaDV().")"; ?>
			</td>
			<td width="15%" align="left" class="<?= $cor; ?>">
			<?= $conta->getDescricao(); ?>
			</td>
			<td width="30%" align="left" class="<?= $cor; ?>">
			 <?= $lista[$indx][3]; ?>
			</td>
			<td width="10%" align="right" class="<?= $cor; ?>">
			<? if ( $lista[$indx][5] == "D" ) {
				  if ( $lista[$indx][4] > 0 )
				  echo Numero::convReal( $lista[$indx][4] ); }
			   else echo "&nbsp;"; ?>
			</td>
			<td width="10%" align="right" class="<?= $cor; ?>">
			<? if ( $lista[$indx][5] == "C" ) {
				  if ( $lista[$indx][4] > 0 )
				  echo Numero::convReal( $lista[$indx][4] ); }
			   else echo "&nbsp;"; ?>
			</td>
			</tr>
		  <?
			if ( $lista[$indx][5] == "D" )
				$totalDebito  += $lista[$indx][4];
			else
				$totalCredito += $lista[$indx][4];
		   }
		   ?>
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="15%" class="tjanela" align="left">
				&nbsp;
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="15%" class="tjanela" align="left">
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
					<input type="submit" class="bjanela"
					value="<?PHP echo $botaoExcluir; ?>" name="bt_excluir">
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

	 case 5: {

		  $cabec = new TituloCw( $cabecConsLanc );
		  $cabec->mostra();

?>
<body class="pagina" onLoad="this.document.formConsLanc.dataInicial.focus();">

	<div align="center">

	<br><br>

	<form action="cwRegLanc.php"
				name="formConsLanc" method="get" onSubmit="return validaConsDados();">

	<input type="hidden" name="controleNavegacao" value="6">
	<input type="hidden" name="loginUsuario" value="<?= $loginUsuario; ?>">

		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="90%" class="tjanela">
				<?PHP echo $tituloConsLanc; ?>
			</td>
			<td width="10%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:window.close();">
			</td>
			</tr>
		</table>

		<!-- Op��es do Menu -->
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
					OnClick="javascript:window.close();">
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

	 case 6: {

	 // Instancia objetos...
	 $empresa		 = new Empresa();
	 $lancamento	 = new Lancamento();
	 $itemLancamento = new ItemLancamento();
	 $conta 		 = new Conta();

	 $empresa->pesquisaEmpresa( $oidEmpresaCont );
	 
	 ?>

<body class="pagina">

	<div align="center">

		<!-- Mostra o resultado da consulta, esta sera validada com
		o Framework de relatorio -->
		<br><br><br>
		<center>
		<font face="Verdana, Arial" color="#000099" size="2">
		<b><?= $relatorioConsLanc; ?></b><br>
		<?= $oidEmpresaCont." - ".$empresa->getRazaoSocial(); ?></font>
		</center>
		<br>
		<form>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="center">
				<?= $relatorioLancamento; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="15%" class="tjanela" align="left">
				<?= $relatorioConta; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="15%" class="tjanela" align="left">
				<?= $relatorioDescricao; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="40%" class="tjanela" align="left">
				<?= $relatorioHistorico; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="right">
				<?= $relatorioDebito; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="right">
				<?= $relatorioCredito; ?>
			</td>
			</tr>

		 <?
		$lista = $lancamento->buscaLancamentosPeriodo( $dataInicial, $dataFinal,
						$oidEmpresaCont, $loginUsuario, "N", "S" );
		
		for ( $indx = 0; $indx < sizeof( $lista ); $indx++ ) {

			$link = "javascript:setaValor('". $lista[$indx][0]."');";
			$itens = $itemLancamento->buscaItemLancamento( $lista[$indx][0] );

			for ( $indy = 0; $indy < sizeof( $itens ); $indy++ ) {
			
				$cor = ($indy % 2 ) == 0?"lcons1":"lcons2";

				$oidConta = $itens[$indy][2].".".Numero::modulo11( $itens[$indy][2] );
				$conta->pesquisaConta( $oidConta );
		 ?>
				<tr>
				<td width="10%" align="center" class="<?= $cor; ?>">
				<a href="<?= $link; ?>">
				<?= $lista[$indx][0]." - ".$lista[$indx][1]; ?>
				</a>
				</td>
				<td width="15%" align="left" class="<?= $cor; ?>">
				<a href="<?= $link; ?>">
				<?= $conta->getCodigoSintetico(); ?>
				</a>
				</td>
				<td width="15%" align="left" class="<?= $cor; ?>">
				<a href="<?= $link; ?>">
				<?= $conta->getDescricao(); ?>
				</a>
				</td>
				<td width="40%" align="left" class="<?= $cor; ?>">
				<a href="<?= $link; ?>">
				<?= $itens[$indy][3]; ?>
				</a>
				</td>
				<td width="10%" align="right" class="<?= $cor; ?>">
				<a href="<?= $link; ?>">
				<? if ( $itens[$indy][5] == "D" ) {
					if ( $itens[$indy][4] > 0 )
						echo Numero::convReal( $itens[$indy][4] );
					}
					else echo "&nbsp;";
				?>
				</a>
				</td>
				<td width="10%" align="right" class="<?= $cor; ?>">
				<a href="<?= $link; ?>">
				<? if ( $itens[$indy][5] == "C" ) {
					if ( $itens[$indy][4] > 0 )
						echo Numero::convReal( $itens[$indy][4] );
					}
					else echo "&nbsp;"; ?>
				</a>
				</td>
				</tr>
				<?
				}
		   }
		   ?>
		  </table>

		  <table class="pagina" border="0" width="100%">

			<tr>
				<td width="100%" align="center">
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

		case 7: { // Altera��o de lancamentos...

		?>
		<body class="pagina">

			<div align="center">

			<br><br><br>

			<form name="formPesquisa" action="cwRegLanc.php"
						method="get" onSubmit="return validaSelecaoItem();">

			<input type="hidden" name="controleNavegacao" value="8">
			<input type="hidden" name="oidLancamento" value="<?= $oidLancamento; ?>">

		<?PHP
			$lancamento	= new Lancamento();
			$itemLancamento = new ItemLancamento();
			$conta			= new Conta();

			// Se nao achou lancamento...
			if ( !$lancamento->pesquisaLancamento( $oidLancamento ) ) {
				$msg = new MsgCw( $msgLancamentoNaoEncontrado );
				$msg->mostra();
				exit(); }
				
			// Se lancamento j� foi "fechado"...
			if ( $lancamento->getContabilizado() == "S" && $perfilUsuario != "S" ) {
				$msg = new MsgCw( $msgLancamentoJaFechado );
				$msg->mostra();
				exit(); }
				
			$itens = $itemLancamento->buscaItemLancamento( $oidLancamento );

			if ( $itens[0][0] == "0" ) {
				$msg = new MsgCw( $msgItemLancamentoNaoEncontrados );
				$msg->mostra();
				exit(); }
		?>

		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

				<!-- Janela -->
				<table border="0" width="100%">
					<tr>
					<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
						<?PHP echo $tituloPesquisaItem; ?>
					</td>
					<td width="15%" align="center" class="tjanela">
						<input type="button" class="btitulo" name= "bt_fechar"
							value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
					</td>
					</tr>
				</table>

		</td>
		</tr>
		<tr>
		<td>
				<!-- Op��es do Menu -->
				<table class="cjanela" border="0" width="100%">

					<tr>
						<td width="10%" align="right">&nbsp;
						</td>
						<td align="center" width="90%" class="cjanela">
						<select name="oidItemLancamento" size= "10" class="dljanela">
						<?PHP
						for ( $indx = 0; $indx < sizeof( $itens ); $indx++ ) {
							$oidConta = $itens[$indx][2].".".Numero::modulo11( $itens[$indx][2] ); 
							$conta->pesquisaConta( $oidConta );
						?>
							<option value="<?= trim( $itens[$indx][0] ); ?>"><?= trim( $oidConta )." - ".$conta->getDescricao()." - ".trim($itens[$indx][3])." - ".Numero::convReal( $itens[$indx][4] )." - ".$itens[$indx][5]; ?></option>
						<?PHP } ?>
						</select>
					</td>
					</tr>
					<tr>
						<td width="10%" align="right">&nbsp;
						</td>
						<td width="90%" align="center">
							<input type="button" class="bjanela"
							value="<?PHP echo $msgIncluiItemLancamento ?>" name="bt_incluiritem"
							OnClick="javascript:incluiItemLancamento(<?= $oidLancamento; ?>, <?= $lancamento->getOidEmpresaCont(); ?>);">						
							<input type="submit" class="bjanela" value="<?PHP echo $botaoAlterar; ?>" name="bt_executar">
							<input type="button" class="bjanela"
							value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
							OnClick="javascript:history.go(-1);">
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
			break; }

		 // Altera lancamento...
		 case 8: {

		  $cabec = new TituloCw( $cabecRegLanc );
		  $cabec->mostra();

		  $lancamento	  = new Lancamento();
		  $itemLancamento = new ItemLancamento();
		  $empresa		  = new Empresa();
		  $conta		  = new Conta();

		  $lancamento->pesquisaLancamento( $oidLancamento );
		  $lancamento->buscaTotaisDC( $lancamento->getDataLancamento(), $lancamento->getLoginOperador(),
													$lancamento->getOidEmpresaCont() );

		  $empresa->pesquisaEmpresa( $lancamento->getOidEmpresaCont() );
		  $itemLancamento->pesquisaItemLancamento( $oidItemLancamento );

		  $oidConta	= $itemLancamento->getOidConta().".".Numero::modulo11( $itemLancamento->getOidConta() );
		  $conta->pesquisaConta( $oidConta );

		  $totalDebito	= $lancamento->getTotalDebito();
		  $totalCredito = $lancamento->getTotalCredito();
		?>

	<body class="pagina" onLoad="carregaColecaoConta();carregaColecaoHistorico();document.formRegLanc.oidPlano.focus();">

	<div align="center">

	<br>

	<form action="cwGravaOperacao.php"
				name="formRegLanc" method="get" onSubmit="return validaDados( true );">

	<input type="hidden" name="tipoOperacao"	  value="3">
	<input type="hidden" name="oidEmpresaCont"	  value="<?= $lancamento->getOidEmpresaCont(); ?>">
	<input type="hidden" name="oidLancamento"	  value="<?= $oidLancamento; ?>">
	<input type="hidden" name="oidItemLancamento" value="<?= $oidItemLancamento; ?>">
	<input type="hidden" name="dataLancamento"	  value="<?= $lancamento->getDataLancamento(); ?>">
	<input type="hidden" name="loginUsuario"	  value="<?= $lancamento->getLoginOperador(); ?>">
	<input type="hidden" name="totalDebito" 	  value="<?= $totalDebito; ?>">
	<input type="hidden" name="totalCredito"	  value="<?= $totalCredito; ?>">

		<table class="ejanela" width="95%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="90%" class="tjanela">
				<?PHP echo $tituloRegLanc; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="center">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>

		<!-- Op��es do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoEmpresa; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <?= $lancamento->getOidEmpresaCont()." - ".$empresa->getRazaoSocial()."&nbsp;&nbsp;&nbsp;&nbsp;".$campoDataLanc." ".$lancamento->getDataLancamento()."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$campoLogin."&nbsp;".$loginSession; ?>
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				 &nbsp;
				</td>

				<td width="80%" align="right" class="cjanela">
				  <?PHP echo "<b>".$campoTotal."</b>"; ?>
				  <?PHP echo $campoOperacaoDebito."&nbsp;"; ?>
				  <?= Numero::convReal( $lancamento->getTotalDebito() )."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - "; ?>
				  <?PHP echo $campoOperacaoCredito."&nbsp;"; ?>
				  <?= Numero::convReal( $lancamento->getTotalCredito() ); ?>
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoChaveAcesso; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="text" class="txjanela" name="oidPlano"
						size="15" maxlength="15" value="<?= $conta->getOidContaDV(); ?>" onChange="return validaConta();document.formRegLanc.oidHistorico.focus();">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoConsultar; ?>" name="bt_consultar"
						OnClick="javascript:consultaPlano('../supervisao/cwCadPlano.php?controleNavegacao=8&oidEmpresaCont=<?= $oidEmpresaCont; ?>');;document.formRegLanc.historico.focus();">

				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoDescricao; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="text" class="txinvis" name="descricaoConta"
						size="70" maxlength="70" value="<?= $conta->getDescricao(); ?>" onFocus="this.blur();document.formRegLanc.oidHistorico.focus();">
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoCodigo; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="text" class="txjanela" name="oidHistorico"
						size="15" maxlength="15" onChange="return validaHistorico();document.formRegLanc.historico.focus();">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoConsultarHistorico; ?>" name="bt_consultar"
						OnClick="javascript:consultaHistorico('../supervisao/cwCadHistorico.php?controleNavegacao=5');">

				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				<?PHP echo $campoHistorico; ?>
				</td>
				<td align="left" width="80%" class="cjanela" valign="center">
					<textarea name="historico" class="txjanela"
						rows="5" cols="45" wrap="hard"><?= $itemLancamento->getHistorico(); ?></textarea>
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoValor; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="text" class="txjanela" name="valor" value="<?= Numero::convReal( trim( $itemLancamento->getValor() ) ); ?>"
						size="15" maxlength="15">
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoOperacaoDB; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="radio" name="operacao" value="D" <? if ( $itemLancamento->getOperacao() == "D" ) echo " checked"; ?>><?PHP echo $campoOperacaoDebito; ?>
				   <input type="radio" name="operacao" value="C" <? if ( $itemLancamento->getOperacao() == "C" ) echo " checked"; ?>><?PHP echo $campoOperacaoCredito; ?>
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoCentroCusto; ?>
				</td>
				<? $centroCusto = new CentroCusto();
				   $listaCentros = $centroCusto->buscaCentroCusto( $lancamento->getOidEmpresaCont(), '' );
				?>
				<td width="80%" align="left">
					<select name="oidCentroCusto" class="dljanela">
					<option value="0" <? if ( $itemLancamento->getOidCentroCusto() == "0" ) echo " selected"; ?>><?= $msgNenhum; ?></option>
					<? for ( $indx = 0; $indx < sizeof( $listaCentros ); $indx++ ) { ?>
					   <option value="<?= $listaCentros[$indx][0]; ?>"
					   <? if ( $itemLancamento->getOidCentroCusto() == $listaCentros[$indx][0] ) echo " selected"; ?>><?= $listaCentros[$indx][1]; ?></option>
					   <? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="20%" align="right">&nbsp;
				</td>
				<td width="80%" align="left">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoAlterar; ?>" name="bt_alterar">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
					OnClick="javascript:history.go(-1);">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoConsultarItens; ?>" name="bt_consultarItens"
					OnClick="javascript:abreJanela('cwRegLanc.php?controleNavegacao=9&oidLancamento=<?= $oidLancamento; ?>' );">
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
	 break; }

	case 9: {

		  // Instancia objetos...
		  $empresa		  = new Empresa();
		  $lancamento	  = new Lancamento();
		  $itemLancamento = new ItemLancamento();
		  $conta		  = new Conta();

	 ?>

	<body class="pagina">

	<div align="center">

	<?
		 if ( empty( $oidLancamento ) )
			 $lancamento->buscaOidLancamento( $dataLanc, $loginUsuario, $oidEmpresaCont );
		 else
			 $lancamento->setOidLancamento( $oidLancamento );

		 if ( !$lancamento->pesquisaLancamento( $lancamento->getOidLancamento() ) ) {
			$cabec = new TituloCw( $cabecRegLanc );
			$cabec->mostra();
			$msg = new MsgCw( $msgLancamentoNaoEncontrado,
				   "../imagens/contabil.jpg", "javascript:window.close();" );
			$msg->mostra();
			exit(); }

		$lancamento->mostraItens( $lancamento->getOidLancamento() );
	?>
	 </div>
	 </body>
	<?

	break; }

		 // Inclui item de lancamento (na altera��o)...
		 
		 case 10: {

		  $cabec = new TituloCw( $cabecRegLanc );
		  $cabec->mostra();

		  $lancamento	= new Lancamento();
		   
		  $lancamento->pesquisaLancamento( $oidLancamento );
		  $oidEmpresaCont = $lancamento->getOidEmpresaCont();
		  for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ )
			  if ( $listaEmpresas[$indx][0] == $oidEmpresaCont )
			 $descEmpresa =  $listaEmpresas[$indx][1];
		  $dataLanc = $lancamento->getDataLancamento();

		  $lancamento->buscaTotaisDC( $dataLanc, $loginUsuario, 
													$oidEmpresaCont );

		  $totalDebito	= $lancamento->getTotalDebito();
		  $totalCredito = $lancamento->getTotalCredito();
			
//		  if ( $totalDebito == $totalCredito && $totalDebito != 0 ) {
//			$totalDebito = $totalCredito = 0; }
		?>

	<body class="pagina" onLoad="carregaColecaoConta();carregaColecaoHistorico();document.formRegLanc.oidPlano.focus();">

	<div align="center">

	<br>

	<form action="cwGravaOperacao.php"
				name="formRegLanc" method="post" enctype="multipart/form-data" onSubmit="return validaDados( true );">

	<input type="hidden" name="tipoOperacao"   value="4">
	<input type="hidden" name="oidEmpresaCont" value="<?= $oidEmpresaCont; ?>">
	<input type="hidden" name="dataLanc"	   value="<?= $dataLanc; ?>">
	<input type="hidden" name="loginUsuario"   value="<?= $loginUsuario; ?>">
	<input type="hidden" name="totalDebito"    value="<?= $totalDebito; ?>">
	<input type="hidden" name="totalCredito"   value="<?= $totalCredito; ?>">
	<input type="hidden" name="oidLancamento"  value="<?= $oidLancamento; ?>">

		<table class="ejanela" width="95%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="90%" class="tjanela">
				<?PHP echo $tituloIncItem; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="10%" class="tjanela" align="center">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>

		<!-- Op��es do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoEmpresa; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <?= $oidEmpresaCont." - ".substr( $descEmpresa, 0, 30 )."&nbsp;&nbsp;&nbsp;&nbsp;".$campoDataLanc." ".$dataLanc."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$campoLogin."&nbsp;".$loginSession; ?>
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				 &nbsp;
				</td>

				<td width="80%" align="right" class="cjanela">
				  <?PHP echo "<b>".$campoTotal."</b>"; ?>
				  <?PHP echo $campoOperacaoDebito."&nbsp;"; ?>
				  <?= Numero::convReal( $totalDebito )."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - "; ?>
				  <?PHP echo $campoOperacaoCredito."&nbsp;"; ?>
				  <?= Numero::convReal( $totalCredito ); ?>
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoChaveAcesso; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="text" class="txjanela" name="oidPlano"
						size="15" maxlength="15" onChange="return validaConta();document.formRegLanc.oidHistorico.focus();">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoConsultar; ?>" name="bt_consultar"
						OnClick="javascript:consultaPlano('../supervisao/cwCadPlano.php?controleNavegacao=8&oidEmpresaCont=<?= $oidEmpresaCont; ?>');">

				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoDescricao; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="text" class="txinvis" name="descricaoConta"
						size="70" maxlength="70" onFocus="this.blur();document.formRegLanc.oidHistorico.focus();">
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoCodigo; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="text" class="txjanela" name="oidHistorico"
						size="15" maxlength="15" onChange="return validaHistorico();document.formRegLanc.historico.focus();">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoConsultarHistorico; ?>" name="bt_consultar"
						OnClick="javascript:consultaHistorico('../supervisao/cwCadHistorico.php?controleNavegacao=5');">

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
				  <?PHP echo $campoValor; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="text" class="txjanela" name="valor"
						size="15" maxlength="15">
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoOperacaoDB; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="radio" name="operacao" value="D" checked><?PHP echo $campoOperacaoDebito; ?>
				   <input type="radio" name="operacao" value="C"><?PHP echo $campoOperacaoCredito; ?>
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoContraPartida; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="text" class="txjanela" name="contraPartida"
						size="15" maxlength="15" onChange="return validaContraPartida();document.formRegLanc.bt_incluir.focus();">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoConsultar; ?>" name="bt_consultarConta"
						OnClick="javascript:consultaContraPartida('../supervisao/cwCadPlano.php?controleNavegacao=8&oidEmpresaCont=<?= $oidEmpresaCont; ?>');">
				   <input type="text" class="txinvis" name="descricaoCP"
						size="60" maxlength="70" onFocus="this.blur();document.formRegLanc.bt_incluir.focus();">
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoCentroCusto; ?>
				</td>
				<? $centroCusto = new CentroCusto();
				   $listaCentros = $centroCusto->buscaCentroCusto( $oidEmpresaCont, '' );
				?>
				<td width="80%" align="left">
					<select name="oidCentroCusto" class="dljanela">
					<option value="0" selected><?= $msgNenhum; ?></option>
					<? for ( $indx = 0; $indx < sizeof( $listaCentros ); $indx++ ) { ?>
					   <option value="<?= $listaCentros[$indx][0]; ?>"><?= $listaCentros[$indx][1]; ?></option>
					   <? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo $campoArquivoAnexado; ?>
				</td>
				<td width="80%" align="left">
				    <input type="file" class="txjanela" name="arquivoAnexado" size="30">
				</td>
			</tr>

			<tr>
				<td width="20%" align="right">&nbsp;
				</td>
				<td width="80%" align="left">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoIncluir; ?>" name="bt_incluir">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
					OnClick="javascript:history.go(-1);">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoConsultarItens; ?>" name="bt_consultarItens"
					OnClick="javascript:abreJanela('cwRegLanc.php?controleNavegacao=9&dataLanc=<?= $dataLanc; ?>&oidEmpresaCont=<?= $oidEmpresaCont; ?>&loginUsuario=<?= $loginUsuario; ?>' );">
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
	 break; }

 }
 
?>

</html>

