<?PHP

	// Abre sessao...
	@session_start( "cw" );

	if ( empty( $oidEmpresaContCookie ) )
		setcookie( "oidEmpresaContCookie", -1 );

	// Recebe oid da Empresa
	$oidEmpresa = $oidEmpresaSession;
	$loginUsuario = $loginSession;

	include "../classes/cw.inc";

	// Carrega lista de empresas
	$empresa = new Empresa();
	$listaEmpresas = $empresa->buscaEmpresa( $oidEmpresa, "", 2, $loginUsuario );

?>

<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 25/06/2003
	Última Atualização: 11/07/2003
	Módulo: cwCadDoar.php
	  Cadastro de Plano de Contas DOAR
-->

<html>
<head>
<title>::FIEL Contábil::</title>


<script language="javascript">

	var empresas   = new Array;

	//--------------------------------------------
	// validaSelecaoItem()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaSelecaoItem(opcao) {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- Titulo da Consulta
			if ( document.forms[0].oidDoar.selectedIndex == -1 ) {
				mensagem += '\n - Você deve selecionar uma conta DOAR';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem ); }
			else {
				// Se e exclusao...
				if ( opcao != 1 ) {
					if( !confirm( 'Tem certeza que deseja excluir conta DOAR?' ) )
					retorna = false;
				}
			}

		return retorna;

	}

	//--------------------------------------------
	// testaNumero
	// - Valida se e numero e ponto
	//--------------------------------------------
	function testaNumero( numero ) {
		 return /^[0-9.]+$/.test( numero );
	}

	//--------------------------------------------
	// validaCodigoSintetico()
	// - Valida codigo de sintetico
	//--------------------------------------------
	function validaCodigoSintetico( codigo, mascara ) {

		var mascara	   = mascara.value;
		var codigo	   = codigo.value;
		var tamanhoCodigo  = codigo.length;
		var tamanhoMascara = mascara.length;
		var indx, flagRetorno = true, nivel = 0, numeroNiveis = 1;

		var valorNivel = new Array;

		// Verifica quantos niveis possui a conta...
		for ( indx = 0; indx < tamanhoMascara; indx++ )
		    if ( mascara.charAt( indx ) == '.' )
		       numeroNiveis++;

		// Seta niveis no array...
		for ( indx = 0; indx < numeroNiveis; indx++ ) {
		    valorNivel[indx] = "";
		}

		// testa contexto de codigo (0-9 e .)
		if ( !testaNumero( codigo ) ) {
		       flagRetorno = false;
		}

		// Coloca o codigo em um vetor de niveis
		for ( indx = 0; indx < tamanhoCodigo; indx++ ) {
		    if ( codigo.charAt( indx ) == '.' )
		       nivel++;
		    else
		       valorNivel[nivel] += codigo.charAt( indx );
		}

		// Testa se algum nivel esta zerado (invalido)
		for ( indx = numeroNiveis; indx >= 0; indx-- )
		    if ( parseInt( valorNivel[indx] ) == 0  )
		       flagRetorno = false;

		// Verifica conformidade da mascara
		// com o codigo informado
		nivel = 0;
		for ( indx = 0; indx < tamanhoMascara; indx++ ) {
		    if ( codigo.charAt( indx ) == '.' )
		       nivel++;
		    if ( codigo.charAt( indx ) == '.' &&
			 !( mascara.charAt( indx ) == '.' &&
			   parseInt( valorNivel[nivel] ) > 0 ) )
			   flagRetorno = false;
		}

		// Retorna se codigo esta correto...
		return flagRetorno;

	}

	//--------------------------------------------
	// validaConta()
	// - Valida conta analitica
	//--------------------------------------------
	function validaConta( codigo, mascara, flagSintetica ) {

		var mascara	   = mascara.value;
		var codigo	   = codigo.value;
		var tamanhoCodigo  = codigo.length;
		var tamanhoMascara = mascara.length;
		var numeroNiveisCodigo = 1;
		var indx, flagRetorno = true, nivel = 0, numeroNiveis = 1;

		var valorNivel = new Array;

		// Verifica quantos niveis possui a mascara...
		for ( indx = 0; indx < tamanhoMascara; indx++ )
		    if ( mascara.charAt( indx ) == '.' )
		       numeroNiveis++;
	    
		// Verifica quantos niveis possui a conta...
		for ( indx = 0; indx < tamanhoCodigo; indx++ )
		    if ( codigo.charAt( indx ) == '.' )
		       numeroNiveisCodigo++;

		for ( indx = 0; indx < numeroNiveis; indx++ ) {
		    valorNivel[indx] = "";
		}

		// Coloca o codigo em um vetor de niveis
		for ( indx = 0; indx < tamanhoCodigo; indx++ ) {
		    if ( codigo.charAt( indx ) == '.' )
		       nivel++;
		    else
		       valorNivel[nivel] += codigo.charAt( indx );
		}

		if ( flagSintetica ) {
		   // Testa se ultimo nivel nao esta zerado e
		   // se for uma conta sintetica, e erro!!
		   if ( ( parseInt( valorNivel[nivel] ) > 0 ) &&
			  ( document.forms[0].tipo[0].checked ) && ( numeroNiveisCodigo == numeroNiveis ) ) {
			  flagRetorno = false;
		   }
		}
		else {
		   // Testa se o numero de niveis digitado for menor que o da mascara e
		   // se for uma conta analitica
		   if ( ( numeroNiveisCodigo < numeroNiveis ) &&
			( document.forms[0].tipo[1].checked ) ) {
			  flagRetorno = false;
		   }
		}

		// Retorna se codigo esta correto...
		return flagRetorno;

	}

	//--------------------------------------------
	// validaDados()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaDados( controle ) {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- Codigo Sintetico
			if ( testaNulo( document.forms[0].codigoSintetico ) ) {
				mensagem += '\n - Código sintético não preenchido';
				retorna = false; }

			// -- Codigo Sintetico
			if ( !validaCodigoSintetico( document.forms[0].codigoSintetico,
						document.forms[0].mascaraCodigo ) ) {
				mensagem += '\n - Código sintético inválido';
				retorna = false; }

			// -- Conta
			if ( !validaConta( document.forms[0].codigoSintetico,
						document.forms[0].mascaraCodigo, true ) ) {
				mensagem += '\n - Conta definida no último nivel somente pode ser analítica';
				retorna = false; }

			// -- Conta
			if ( !validaConta( document.forms[0].codigoSintetico,
						document.forms[0].mascaraCodigo, false ) ) {
				mensagem += '\n - Conta definida em níveis anteriores somente pode ser sintética';
				retorna = false; }

			// -- Descricao
			if ( testaNulo( document.forms[0].descricao ) ) {
				mensagem += '\n - Descrição não preenchida';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem );
				document.forms[0].codigoSintetico.focus(); }

		return retorna;

	}

	//--------------------------------------------
	// validaDadosAlt()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaDadosAlt() {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- Descricao
			if ( testaNulo( document.forms[0].descricao ) ) {
				mensagem += '\n - Descrição não preenchida';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem );
				document.forms[0].descricao.focus(); }

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
	// carregaColecao()
	// - Carrega colecao
	//--------------------------------------------
	function carregaColecao() {

		<?
		echo "\n";
		for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) {
		echo "		empresas[$indx]    = new Array;\n";
		echo "		empresas[$indx][0] = ".$listaEmpresas[$indx][0].";\n";
		echo "		empresas[$indx][1] = '".$listaEmpresas[$indx][1]."';\n";
		echo "		empresas[$indx][2] = '".$listaEmpresas[$indx][3]."';\n";
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
		 for ( indx = 0; indx < 2; indx++ ) {
		   if ( empresas[indx][0] == codigoEmpresa ) {
		      document.forms[0].textoMascaraCodigo.value = empresas[indx][2];
		      document.forms[0].mascaraCodigo.value = empresas[indx][2];
		      break; }
		 }

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
	$cabec = new TituloCw( $cabecCadDoar );
	$cabec->mostra();

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	// Verifica o controle de navegacao...
	switch( $controleNavegacao ) {

		// Inclusao de Doar
		default: {

?>
		<body class="pagina" onLoad="carregaColecao();this.document.formCadDoar.codigoSintetico.focus();">

		<div align="center">

		<br>

		<form action="cwGravaSupervisao.php"
					name="formCadDoar" method="get" onSubmit="return validaDados();">

		<input type="hidden" name="tipoOperacao" value="10">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">
		<input type="hidden" name="mascaraCodigo" value="<?= $listaEmpresas[0][3]; ?>">

		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>
		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloCadDoar; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwCadDoar')">
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
						OnClick="javascript:abreJanela('cwCadDoar.php?controleNavegacao=3');">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoAlterar; ?>" name="bt_alterar"
						OnClick="javascript:abreJanela('cwCadDoar.php?controleNavegacao=1&operacao=1');">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoExcluir; ?>" name="bt_excluir"
						OnClick="javascript:abreJanela('cwCadDoar.php?controleNavegacao=1&operacao=2');">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoEmpresa; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
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
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoCodigoSintetico; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="codigoSintetico"
							size="14" maxlength="14">&nbsp;
							<i><?= $msgExemploCodigoSintetico; ?><input type="text" class="txinvis" name="textoMascaraCodigo"
							size="14" maxlength="14" value="<?= $listaEmpresas[0][3]; ?>" onFocus="this.blur();document.forms[0].descricao.focus();"></i>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoDescricao; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="descricao"
							size="30" maxlength="40">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoTipo; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
				   <input type="radio" name="tipo" value="S" checked><?PHP echo $campoTipoSintetica; ?>
				   <input type="radio" name="tipo" value="A"><?PHP echo $campoTipoAnalitica; ?>
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
					value="<?= $botaoAjuda; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwCadDoar')">

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

		<body class="pagina" onLoad="this.document.formConsDoar.descricao.focus();">

		<div align="center">

		<br><br><br>

		<form action="cwCadDoar.php"
					name="formConsDoar" method="get">

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
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoDescricao; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="descricao"
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
				$acaoExecutada = "cwCadDoar.php";
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
				<input type="hidden" name="tipoOperacao" value="12">

			<?PHP
				if ( $operacao == 1 ) ?>
				<input type="hidden" name="controleNavegacao" value="4">

		<?PHP
			$doar = new ContaDoar();
			$listaDoar = $doar->buscaContaDoar( $oidEmpresaCont, $descricao );

			if ( $listaDoar[0][0] == "0" ) {
				$msg = new MsgCw( $msgDoarNaoEncontrados );
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
						<select name="oidDoar" size= "10" class="dljanela">
						<?PHP
						for ( $indx = 0; $indx < sizeof( $listaDoar ); $indx++ ) {
						?>
							<option value="<?= trim( $listaDoar[$indx][0] ); ?>"><?= trim( $listaDoar[$indx][1] )." - ".trim( $listaDoar[$indx][2] ); ?></option>
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

		case 3: { // Consulta de Doar...

			$consulta = new ConsultaCw();

			$consulta->mostraConsulta( "Plano de Contas DOAR",
			"select codigodoar, descricao, tipo from contadoar_cont doar, empresa_cont empresa, parametro_cont param where doar.codigoempresa = empresa.codigo and empresa.codigocliente = param.codigocliente order by codigodoar,descricao;",
										false );
			break; }

		case 4: { // Alteração de Doar...

		?>

		<body class="pagina">

		<div align="center">

		<br><br>

		<?PHP
			$doar = new ContaDoar();
			$doar->pesquisaContaDoar( $oidDoar );
		?>

		<form action="cwGravaSupervisao.php"
					name="formAltDoar" method="get" onSubmit="return validaDadosAlt();">

		<input type="hidden" name="tipoOperacao" value="11">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">
		<input type="hidden" name="oidDoar" value="<?PHP echo $oidDoar; ?>">
		<input type="hidden" name="mascaraCodigo" value="<?= $listaEmpresas[0][3]; ?>">

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
				  <?PHP echo $campoEmpresa; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="oidEmpresaCont" class="dljanela">
					<? for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) { ?>
					   <option value="<?= $listaEmpresas[$indx][0]; ?>"
					   <? if ( $doar->getOidEmpresaCont() == $listaEmpresas[$indx][0] )
					      echo " selected"; ?>><?= $listaEmpresas[$indx][1]; ?></option>
					<? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoCodigoSintetico; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<?= $oidDoar; ?>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoDescricao; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="descricao"
							size="30" maxlength="40" value="<?= $doar->getDescricao(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoTipo; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
				   <input type="radio" name="tipo" value="S" 
				   <? if ( $doar->getTipo() == "S" ) echo " checked"; ?>><?PHP echo $campoTipoSintetica; ?>
				   <input type="radio" name="tipo" value="A"
				   <? if ( $doar->getTipo() == "A" ) echo " checked"; ?>><?PHP echo $campoTipoAnalitica; ?>
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

