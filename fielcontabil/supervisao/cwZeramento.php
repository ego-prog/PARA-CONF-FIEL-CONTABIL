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
	$listaEmpresas = $empresa->buscaEmpresa( $oidEmpresa, "", 2, $loginUsuario );

?>

<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 25/06/2003
	Última Atualização: 16/10/2003
	Módulo: cwZeramento.php
	  Parâmetros de Zeramento
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
			if ( document.forms[0].oidZeramento.selectedIndex == -1 ) {
				mensagem += '\n - Você deve selecionar parâmetro de zeramento';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem ); }
			else {
				// Se e exclusao...
				if ( opcao != 1 ) {
					if( !confirm( 'Tem certeza que deseja excluir parâmetro de zeramento?' ) )
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
		   if ( ( parseInt( valorNivel[nivel] ) > 0 )
			  && ( numeroNiveisCodigo == numeroNiveis ) ) {
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
				mensagem += '\n - Código da conta não preenchido';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem );
				document.forms[0].codigoSintetico.focus(); }

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
	// setaConta()
	// - Seta atributo que foi pesquisado anteriormente
	//--------------------------------------------
	function setaConta( valor1, valor2 ) {

		 // codigo sintético
		 window.document.forms[0].codigoSintetico.value = valor1;
		 window.document.forms[0].descricao.value = valor2;


	}

	//--------------------------------------------
	// setaContaZeramento()
	// - Seta atributo que foi pesquisado anteriormente
	//--------------------------------------------
	function setaContaZeramento( valor1, valor2, valor3 ) {

		 // codigo sintético
		 switch( valor3 ) {

			 case 1: {
			      window.document.forms[0].grupo01.value = valor1;
			      window.document.forms[0].descricao01.value = valor2;
			      break;
			 }
			 case 2: {
			      window.document.forms[0].grupo02.value = valor1;
			      window.document.forms[0].descricao02.value = valor2;
			      break;
			 }
			 case 3: {
			      window.document.forms[0].grupo03.value = valor1;
			      window.document.forms[0].descricao03.value = valor2;
			      break;
			 }
			 case 4: {
			      window.document.forms[0].grupo04.value = valor1;
			      window.document.forms[0].descricao04.value = valor2;
			      break;
			 }
			 case 5: {
			      window.document.forms[0].grupo05.value = valor1;
			      window.document.forms[0].descricao05.value = valor2;
			      break;
			 }

		 }

	}

	//--------------------------------------------
	// mostraCodigoSintetico()
	// - Mostra módulo
	//--------------------------------------------
	function mostraCodigoSintetico( url ) {

	   url = url + '&oidEmpresaCont=' + escape(document.forms[0].oidEmpresaCont.value);

	  window.open(url,'a','toolbar=no,directories=no,menubar=no,scrollbars=yes' );

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
		echo "		empresas[$indx][2] = '".$listaEmpresas[$indx][2]."';\n";
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

	$cabec = new TituloCw( $cabecZeramento );
	$cabec->mostra();

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	// Verifica o controle de navegacao...
	switch( $controleNavegacao ) {

		// Inclusao de Orcamento
		default: {

?>
		<body class="pagina" onLoad="this.document.formZeramento.codigoSintetico.focus();">

		<div align="center">

		<br>

		<form action="cwGravaSupervisao.php"
					name="formZeramento" method="get" onSubmit="return validaDados();">

		<input type="hidden" name="tipoOperacao" value="24">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">
		<input type="hidden" name="mascaraCodigo" value="<?= $listaEmpresas[0][2]; ?>">

		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>
		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloZeramento; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwZeramento')">
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
						OnClick="javascript:abreJanela('cwZeramento.php?controleNavegacao=3');">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoExcluir; ?>" name="bt_excluir"
						OnClick="javascript:abreJanela('cwZeramento.php?controleNavegacao=1&operacao=2');">


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
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoContaDestino; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="codigoSintetico"
							size="14" maxlength="14">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoConsultar; ?>" name="bt_consultarConta"
						OnClick="mostraCodigoSintetico('cwCadPlano.php?controleNavegacao=5');">

				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoDescricao; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txinvis" name="descricao"
							size="40" maxlength="40" onFocus="this.blur();">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  &nbsp;
				</td>

				<td width="70%" align="left" class="cjanela">
				<b><? echo $msgContasZeradas; ?></b>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoGrupo01; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="grupo01"
							size="14" maxlength="14">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoConsultar; ?>" name="bt_consultarConta"
						OnClick="mostraCodigoSintetico('cwCadPlano.php?controleNavegacao=5&zeramento=1');">

				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoDescricao; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txinvis" name="descricao01"
							size="40" maxlength="40" onFocus="this.blur();">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoGrupo02; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="grupo02"
							size="14" maxlength="14">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoConsultar; ?>" name="bt_consultarConta"
						OnClick="mostraCodigoSintetico('cwCadPlano.php?controleNavegacao=5&zeramento=2');">

				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoDescricao; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txinvis" name="descricao02"
							size="40" maxlength="40" onFocus="this.blur();">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoGrupo03; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="grupo03"
							size="14" maxlength="14">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoConsultar; ?>" name="bt_consultarConta"
						OnClick="mostraCodigoSintetico('cwCadPlano.php?controleNavegacao=5&zeramento=3');">

				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoDescricao; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txinvis" name="descricao03"
							size="40" maxlength="40" onFocus="this.blur();">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoGrupo04; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="grupo04"
							size="14" maxlength="14">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoConsultar; ?>" name="bt_consultarConta"
						OnClick="mostraCodigoSintetico('cwCadPlano.php?controleNavegacao=5&zeramento=4');">

				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoDescricao; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txinvis" name="descricao04"
							size="40" maxlength="40" onFocus="this.blur();">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoGrupo05; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="grupo05"
							size="14" maxlength="14">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoConsultar; ?>" name="bt_consultarConta"
						OnClick="mostraCodigoSintetico('cwCadPlano.php?controleNavegacao=5&zeramento=5');">

				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoDescricao; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txinvis" name="descricao05"
							size="40" maxlength="40" onFocus="this.blur();">
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
					value="<?= $botaoAjuda; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwZeramento')">

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

		<body class="pagina" onLoad="this.document.formZeramento.oidEmpresaCont.focus();">

		<div align="center">

		<br><br><br>

		<form action="cwZeramento.php"
					name="formZeramento" method="get">

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
				$acaoExecutada = "cwZeramento.php";
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
				<input type="hidden" name="tipoOperacao" value="26">

			<?PHP
				if ( $operacao == 1 ) ?>
				<input type="hidden" name="controleNavegacao" value="4">

		<?PHP
			$zeramento = new Zeramento();
			$listaZeramento = $zeramento->buscaZeramento( $oidEmpresaCont );

			if ( $listaZeramento[0][0] == "0" ) {
				$msg = new MsgCw( $msgZeramentosNaoEncontrados );
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
						<select name="oidZeramento" size= "10" class="dljanela">
						<?PHP
						for ( $indx = 0; $indx < sizeof( $listaZeramento ); $indx++ ) {
						?>
							<option value="<?= $listaZeramento[$indx][0]; ?>"><?= trim( $listaZeramento[$indx][0] ); ?></option>
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

		case 3: { // Consulta de orcamentos...

			$consulta = new ConsultaCw();

			$consulta->mostraConsulta( "Parâmetros de Zeramentos Cadastrados",
			"select emp.razaosocial, zera.contrapartida, zera.grupo1, zera.grupo2, zera.grupo3, zera.grupo4, zera.grupo5 from zeramento_cont zera, empresa_cont emp where zera.codigoempresa = emp.codigo and emp.codigocliente = '$oidEmpresa' order by zera.codigo;",
										false );
			break; }

	} // Fim do Switch/Case
?>

</html>

