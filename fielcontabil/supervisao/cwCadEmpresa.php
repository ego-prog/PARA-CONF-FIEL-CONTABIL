<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe oid da Empresa
	$oidEmpresa = $oidEmpresaSession;

	$uf = array( "AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MG",
		     "MS", "MT", "PA", "PR", "PB", "PE", "PI", "RJ", "RN", "RO", "RR",
					"RS", "SC", "SE", "SP", "TO" );

?>

<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 25/06/2003
	Última Atualização: 06/07/2003
	Módulo: cwCadEmpresa.php
	  Cadastro de Empresas
-->

<html>
<head>
<title>::FIEL Contábil::</title>


<script language="javascript">

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
	// validaSelecaoItem()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaSelecaoItem(opcao) {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- Titulo da Consulta
			if ( document.forms[0].oidEmpresaCont.selectedIndex == -1 ) {
				mensagem += '\n - Você deve selecionar uma empresa';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem ); }
			else {
				// Se e exclusao...
				if ( opcao != 1 ) {
					if( !confirm( 'Tem certeza que deseja excluir empresa?' ) )
				      	retorna = false;
				}
			}
				
		return retorna;

	}

	//--------------------------------------------
	// validaDados()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaDados( controle ) {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- Razao Social
			if ( testaNulo( document.forms[0].razaoSocial ) ) {
				mensagem += '\n - Razão social não preenchida';
				retorna = false; }

			// -- CNPJ
			if ( testaNulo( document.forms[0].cnpj ) ) {
				mensagem += '\n - CNPJ não preenchido';
				retorna = false; }

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

			// -- Periodos
			if ( !validaPeriodo( document.forms[0].dataInicial, document.forms[0].horaPadrao,
			   document.forms[0].dataFinal, document.forms[0].horaPadrao ) ) {
				mensagem += '\n - Data inicial maior que data final';
				retorna = false; }

				// -- Nome contador
			if ( testaNulo( document.forms[0].nomeContador ) ) {
				mensagem += '\n - Nome do contador não preenchido';
				retorna = false; }

			// -- CRC contador
			if ( testaNulo( document.forms[0].registroContador ) ) {
				mensagem += '\n - Registro do contador não preenchido';
				retorna = false; }

			// -- Nome responsavel
			if ( testaNulo( document.forms[0].responsavel ) ) {
				mensagem += '\n - Responsável pela empresa não preenchido';
				retorna = false; }

			// -- CPF responsavel
			if ( testaNulo( document.forms[0].cpfResponsavel ) ) {
				mensagem += '\n - CPF do responsável pela empresa não preenchido';
				retorna = false; }

			// -- Mascara Plano de Contas
			if ( testaNulo( document.forms[0].mascaraPlano ) ) {
				mensagem += '\n - Máscara para plano de contas não preenchido';
				retorna = false; }

			// -- Mascara Doar
			if ( testaNulo( document.forms[0].mascaraPlano ) ) {
				mensagem += '\n - Máscara para contas DOAR não preenchida';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem );
				document.forms[0].razaoSocial.focus(); }

		return retorna;

	}

	//--------------------------------------------
	// testaNulo()
	// - Testa se campo é nulo
	//--------------------------------------------
	function testaNulo( nome_campo ) {

		return ( nome_campo.value.length == 0 )?true:false;

	}

	//--------------------------------------------
	// comparaCampo()
	// - Testa se campos são iguais
	//--------------------------------------------
	function comparaCampo( campo1, campo2 ) {

		return ( campo1.value == campo2.value )?true:false;

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
	// abreJanela()
	// - Abre a ajuda
	//--------------------------------------------
	function abreJanela( arquivo ) {

		var janela;
		window.open(arquivo, 'janela',
			'toolbar=no,location=no,directories=no,menubar=no,scrollbars=yes');

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
	// validaPeriodo()
	// - Valida data especificada
	//--------------------------------------------
	function validaPeriodo( data_inicial, hora_inicial, data_final, hora_final ) {

		var dia_inicial, mes_inicial, ano_inicial, data_inicial_tmp;
		var dia_final, mes_final, ano_final, data_final_tmp;
		var data_inicial_inv, data_final_inv;

		data_inicial_tmp = data_inicial.value;
		data_final_tmp = data_final.value;

		// Testa se possui estrutura 99/99/9999
		if ( ( data_inicial_tmp.charAt(2) != '/' ) || ( data_inicial_tmp.charAt(5) != '/' ) )
			return false;

		// Testa se possui estrutura 99/99/9999
		if ( ( data_final_tmp.charAt(2) != '/' ) || ( data_final_tmp.charAt(5) != '/' ) )
			return false;

		// Recebe informações de dia, mes e ano
		dia_inicial = data_inicial_tmp.substring(0,2);
		mes_inicial = data_inicial_tmp.substring(3,5);
		ano_inicial = data_inicial_tmp.substring(6,10);

		// Recebe informações de dia, mes e ano
		dia_final = data_final_tmp.substring(0,2);
		mes_final = data_final_tmp.substring(3,5);
		ano_final = data_final_tmp.substring(6,10);

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
		if ( ( ano_inicial % 4 ) == 0 )
			vet_dia = 29;

		if ( mes_inicial < 1 || mes_inicial > 12 )
			return false;

		if ( dia_inicial < 1 || dia_inicial > vet_dia[mes_inicial-1] )
			return false;

		// Se ano bissexto
		if ( ( ano_final % 4 ) == 0 )
			vet_dia = 29;

		if ( mes_final < 1 || mes_final > 12 )
			return false;

		if ( dia_final < 1 || dia_final > vet_dia[mes_final-1] )
			return false;

		data_inicial_inv = ano_inicial + mes_inicial + dia_inicial + hora_inicial.value;
		data_final_inv = ano_final + mes_final + dia_final + hora_final.value;

		if ( data_inicial_inv > data_final_inv )
		   return false;

		return true;

	}
	
</SCRIPT>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="../estilo/cw.css">

</head>
<?PHP

	if ( empty( $controleNavegacao ) )
		$controleNavegacao = 0;

	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";
	$cabec = new TituloCw( $cabecCadEmpresa );
	$cabec->mostra();

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	// Verifica o controle de navegacao...
	switch( $controleNavegacao ) {

		// Inclusao de Empresas
		default: {

?>
		<body class="pagina" onLoad="this.document.formCadEmpresa.razaoSocial.focus();">

		<div align="center">

		<br>

		<form action="cwGravaSupervisao.php"
					name="formCadEmpresa" method="get" onSubmit="return validaDados();">

		<input type="hidden" name="tipoOperacao" value="1">
		<input type="hidden" name="horaPadrao" value="00:00">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">
        <input type="hidden" name="codigoCaixa" value="0">
		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>
		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloCadEmpresa; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwCadEmpresa')">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>

		</td>
		</tr>
		<tr>
		<td>

		<!-- Opções do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="30%" align="right">&nbsp;
				</td>
				<td width="70%" align="left">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoConsultar; ?>" name="bt_consultar"
						OnClick="javascript:abreJanela('cwCadEmpresa.php?controleNavegacao=3');">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoAlterar; ?>" name="bt_alterar"
						OnClick="javascript:abreJanela('cwCadEmpresa.php?controleNavegacao=1&operacao=1');">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoExcluir; ?>" name="bt_excluir"
						OnClick="javascript:abreJanela('cwCadEmpresa.php?controleNavegacao=1&operacao=2');">


				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoRazaoSocial; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="razaoSocial"
							size="40" maxlength="40">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoCnpj; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="cnpj"
							size="18" maxlength="18">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoInscricaoEstadual; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="inscricaoEstadual"
							size="18" maxlength="18">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoInscricaoMunicipal; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="inscricaoMunicipal"
							size="18" maxlength="18">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoEndereco; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="endereco"
							size="40" maxlength="40">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoBairro; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="bairro"
							size="30" maxlength="30">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoCidade; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="cidade"
							size="30" maxlength="30">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoCep; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="cep"
							size="9" maxlength="9">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoUf; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="uf" class="dljanela">
					<? for ( $indx = 0; $indx < sizeof( $uf ); $indx++ ) { ?>
					   <option value="<?= $uf[$indx]; ?>"
					   <? if ( $uf[$indx] == "RS" )
					      echo " selected"; ?>><?= $uf[$indx]; ?></option>
					<? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoEmail; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="eMail"
							size="30" maxlength="60">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela"><?PHP echo $campoDataInicialLancamento; ?>
				</td>
				<td align="left" width="70%" class="cjanela">
				   <input type="text" class="txjanela" name="dataInicial"
						size="10" maxlength="10">

				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela"><?PHP echo $campoDataFinalLancamento; ?>
				</td>
				<td align="left" width="70%" class="cjanela">
				   <input type="text" class="txjanela" name="dataFinal"
						size="10" maxlength="10">

				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoNomeContador; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="nomeContador"
							size="30" maxlength="40">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoRegistroContador; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="registroContador"
							size="20" maxlength="20">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoResponsavel; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="responsavel"
							size="30" maxlength="40">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoCpfResponsavel; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="cpfResponsavel"
							size="14" maxlength="14">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoMascaraPlano; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="mascaraPlano"
							size="14" maxlength="14">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoMascaraDoar; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="mascaraDoar"
							size="14" maxlength="14">
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
				<input type="button" class="bjanela" name= "bt_ajuda"
					value="<?= $botaoAjuda; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwCadEmpresa')">

				</td>
			</tr>

		</table>
		</td>
		</tr>
		</table>
		<br>
		</form>

		</div>

		</body>

		<?PHP
			break; }

		case 1: { // Mostra tela de pesquisa...

		?>

		<body class="pagina" onLoad="this.document.formConsEmpresa.razaoSocial.focus();">

		<div align="center">

		<br><br><br>

		<form action="cwCadEmpresa.php"
					name="formConsEmpresa" method="get">

		<?PHP
			echo "<input type=\"hidden\" name=\"operacao\" value=\"$operacao\">";
			echo "<input type=\"hidden\" name=\"controleNavegacao\" value=\"2\">";
		?>
			<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">

		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="90%" class="tjanela">
				<?PHP echo $tituloPesquisa; ?>
			</td>
			<td width="10%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:window.close();">
			</td>
			</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td>

		<!-- Opções do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoRazaoSocial; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="razaoSocial"
							size="40" maxlength="40">
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
			break; }

		case 2: { // Seleciona o item para operação...

			// Se for alteração...
			if ( $operacao == 1 ) {
				$acaoExecutada = "cwCadEmpresa.php";
				$botao = $botaoAlterar; }
			// Se for exclusão...
			else {
				$acaoExecutada = "cwGravaSupervisao.php";
				$botao		   = $botaoExcluir; }

		?>
		<body class="pagina">

			<div align="center">

			<br><br><br>

			<form name="formPesquisa" action="<?PHP echo $acaoExecutada; ?>"
						method="get" onSubmit="return validaSelecaoItem(<?= $operacao; ?>);">

			<?PHP
				if ( $operacao != 1 ) ?>
				<input type="hidden" name="tipoOperacao" value="3">

			<?PHP
				if ( $operacao == 1 ) ?>
				<input type="hidden" name="controleNavegacao" value="4">

		<?PHP
			$empresa = new Empresa();
			$listaEmpresas = $empresa->buscaEmpresa( $oidEmpresa, $razaoSocial );

			if ( $listaEmpresas[0][0] == "0" ) {
				$msg = new MsgCw( $msgEmpresasNaoEncontradas );
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
				<!-- Opções do Menu -->
				<table class="cjanela" border="0" width="100%">

					<tr>
						<td width="10%" align="right">&nbsp;
						</td>
						<td align="center" width="90%" class="cjanela">
						<select name="oidEmpresaCont" size= "10" class="dljanela">
						<?PHP
						for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) {
						?>
							<option value="<?= trim( $listaEmpresas[$indx][0] ); ?>"><?= trim( $listaEmpresas[$indx][1] )." - ".trim( $listaEmpresas[$indx][2] ); ?></option>
						<?PHP } ?>
						</select>
					</td>
					</tr>
					<tr>
						<td width="10%" align="right">&nbsp;
						</td>
						<td width="90%" align="center">
							<input type="submit" class="bjanela" value="<?PHP echo $botao; ?>" name="bt_executar">
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

		case 3: { // Consulta de empresas...

			$consulta = new ConsultaCw();

			$consulta->mostraConsulta( $cabecCadEmpresa,
			"select razaosocial as \"Razão Social\", cnpj as \"CNPJ\", endereco as \"Endereço\", cidade as \"Cidade\", uf as \"UF\", responsavel as \"Responsável\" from empresa_cont where codigocliente = '$oidEmpresa' order by razaosocial;",
			false );

			break; }

		case 4: { // Alteração de empresas...

		?>

		<body class="pagina" onLoad="this.document.formAltEmpresa.razaoSocial.focus();">

		<div align="center">

		<br><br>

		<?PHP
			$empresa = new Empresa();
			$empresa->pesquisaEmpresa( $oidEmpresaCont );
			$conta = new Conta();
			$listaContas = $conta->buscaConta( $oidEmpresaCont, "", 4);
		?>

		<form action="cwGravaSupervisao.php"
					name="formAltEmpresa" method="get" onSubmit="return validaDados();">

		<input type="hidden" name="tipoOperacao" value="2">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">
		<input type="hidden" name="oidEmpresaCont" value="<?PHP echo $oidEmpresaCont; ?>">
		<input type="hidden" name="horaPadrao" value="00:00">
		
		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="90%" class="tjanela">
				<?PHP echo $tituloAlteracao; ?>
			</td>
			<td width="10%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>
	</td>
	</tr>
	<tr>
	<td>

		<!-- Opções do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoRazaoSocial; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="razaoSocial"
							size="40" maxlength="40"
							value="<?= $empresa->getRazaoSocial(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoCnpj; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="cnpj"
							size="18" maxlength="18"
							value="<?= $empresa->getCnpj(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoInscricaoEstadual; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="inscricaoEstadual"
							size="18" maxlength="18"
							value="<?= $empresa->getInscricaoEstadual(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoInscricaoMunicipal; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="inscricaoMunicipal"
							size="18" maxlength="18"
							value="<?= $empresa->getInscricaoMunicipal(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoEndereco; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="endereco"
							size="40" maxlength="40"
							value="<?= $empresa->getEndereco(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoBairro; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="bairro"
							size="30" maxlength="30"
							value="<?= $empresa->getBairro(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoCep; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="cep"
							size="9" maxlength="9"
							value="<?= $empresa->getCep(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoCidade; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="cidade"
							size="30" maxlength="30"
							value="<?= $empresa->getCidade(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoUf; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="uf" class="dljanela">
					<? for ( $indx = 0; $indx < sizeof( $uf ); $indx++ ) { ?>
					   <option value="<?= $uf[$indx]; ?>"
					   <? if ( $uf[$indx] == $empresa->getUf() )
					      echo " selected"; ?>><?= $uf[$indx]; ?></option>
					<? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoEmail; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="eMail"
							size="30" maxlength="60"
							value="<?= $empresa->getEmail(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela"><?PHP echo $campoDataInicialLancamento; ?>
				</td>
				<td align="left" width="70%" class="cjanela">
				   <input type="text" class="txjanela" name="dataInicial"
						size="10" maxlength="10"
						value="<?= $empresa->getDataInicial(); ?>">

				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela"><?PHP echo $campoDataFinalLancamento; ?>
				</td>
				<td align="left" width="70%" class="cjanela">
				   <input type="text" class="txjanela" name="dataFinal"
						size="10" maxlength="10"
						value="<?= $empresa->getDataFinal(); ?>">

				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoNomeContador; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="nomeContador"
							size="30" maxlength="40"
							value="<?= $empresa->getNomeContador(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoRegistroContador; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="registroContador"
							size="20" maxlength="20"
							value="<?= $empresa->getRegistroContador(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoResponsavel; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="responsavel"
							size="30" maxlength="40"
							value="<?= $empresa->getResponsavel(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoCpfResponsavel; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="cpfResponsavel"
							size="14" maxlength="14"
							value="<?= $empresa->getCpfResponsavel(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoMascaraPlano; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="mascaraPlano"
							size="14" maxlength="14"
							value="<?= $empresa->getMascaraPlano(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoMascaraDoar; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="mascaraDoar"
							size="14" maxlength="14"
							value="<?= $empresa->getMascaraDoar(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoCodigoCaixa; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="codigoCaixa" class="dljanela">
					   <option value="0"><?= $msgNenhuma; ?></option>
					   <? for ($indx=0; $indx < sizeof( $listaContas );$indx++) {
						      $codigoSD = substr($listaContas[$indx][1],0,strlen($listaContas[$indx][1])-2);
						      echo "<option value=\"" . $codigoSD . "\"" ;
							  if ($empresa->getCodigoCaixa() == $codigoSD)  echo " selected ";
							  echo ">" . $listaContas[$indx][2] . "-" . $listaContas[$indx][3] . "</option>\n";
					      } ?>
					</select>
				</td>

			</tr>

			<tr>
				<td width="30%" align="right">&nbsp;
				</td>
				<td width="70%" align="left">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoAlterar; ?>" name="bt_alterar">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
						OnClick="javascript:history.back();">

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
		break; } // Fim do Case (Alteração)

	} // Fim do Switch/Case
?>

</html>

