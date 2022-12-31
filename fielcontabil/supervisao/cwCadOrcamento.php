<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe oid da Empresa
	$oidEmpresa = $oidEmpresaSession;
	$loginUsuario = $loginSession;

	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";

	$meses = array( $campoJan, $campoFev, $campoMar, $campoAbr, $campoMai,
			$campoJun, $campoJul, $campoAgo, $campoSet, $campoOut,
			$campoNov, $campoDez );

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
	Módulo: cwCadOrcamento.php
	  Cadastro de orçamento anual
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
			if ( document.forms[0].oidOrcamento.selectedIndex == -1 ) {
				mensagem += '\n - Você deve selecionar orçamento anual';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem ); }
			else {
				// Se e exclusao...
				if ( opcao != 1 ) {
					if( !confirm( 'Tem certeza que deseja excluir previsão orçamentária?' ) )
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

		    if ( controle ) {
			// -- Codigo Sintetico
			if ( testaNulo( document.forms[0].oidContaDV ) ) {
				mensagem += '\n - Código da conta não preenchido';
				retorna = false; }

			// -- Ano
			if ( testaNulo( document.forms[0].ano ) ) {
				mensagem += '\n - Ano não preenchido';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem );
				document.forms[0].oidContaDV.focus(); }
		    }
		    else {

			// -- Ano
			if ( testaNulo( document.forms[0].ano ) ) {
				mensagem += '\n - Ano não preenchido';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem ); }

		    }

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
		 window.document.forms[0].oidContaDV.value = valor1;
		 window.document.forms[0].descricao.value = valor2;

	}

	//--------------------------------------------
	// mostraCodigoSintetico()
	// - Mostra módulo
	//--------------------------------------------
	function mostraCodigoSintetico( url ) {
	   
	   url = url + '&oidEmpresaCont=' + escape(document.forms[0].oidEmpresaCont.value );
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

</SCRIPT>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="../estilo/cw.css">

</head>
<?PHP

	if ( empty( $controleNavegacao ) )
		$controleNavegacao = 0;

	$cabec = new TituloCw( $cabecCadOrcamento );
	$cabec->mostra();

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	// Verifica o controle de navegacao...
	switch( $controleNavegacao ) {

		// Inclusao de Orcamento
		default: {

?>
		<body class="pagina" onLoad="this.document.formCadOrcamento.oidContaDV.focus();">

		<div align="center">

		<br>

		<form action="cwGravaSupervisao.php"
					name="formCadOrcamento" method="get" onSubmit="return validaDados( true );">

		<input type="hidden" name="tipoOperacao" value="16">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">
		<input type="hidden" name="mascaraCodigo" value="<?= $listaEmpresas[0][2]; ?>">

		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>
		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloCadOrcamento; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwCadOrcamento')">
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
						OnClick="javascript:abreJanela('cwCadOrcamento.php?controleNavegacao=1&operacao=3');">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoAlterar; ?>" name="bt_alterar"
						OnClick="javascript:abreJanela('cwCadOrcamento.php?controleNavegacao=1&operacao=1');">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoExcluir; ?>" name="bt_excluir"
						OnClick="javascript:abreJanela('cwCadOrcamento.php?controleNavegacao=1&operacao=2');">


				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoEmpresa; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="oidEmpresaCont" class="dljanela">
					<? for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) { ?>
					   <option value="<?= $listaEmpresas[$indx][0]; ?>"
					   <? if ( $indx == 0 ) echo " selected"; ?>><?= $listaEmpresas[$indx][1]; ?></option>
					<? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoCodigoConta; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="oidContaDV"
							size="14" maxlength="14">&nbsp;
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
							size="40" maxlength="40" onFocus="this.blur();document.forms[0].ano.focus();">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoAno; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="ano"
							size="4" maxlength="4">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  &nbsp;
				</td>

				<td width="70%" align="left" class="cjanela">
				<b><? echo $msgValorOrcadoMensal; ?></b>
				</td>
			</tr>

			<? for ( $indx = 0; $indx < sizeof( $meses ); $indx++ ) {
			  $num = $indx + 1;
			  $campo = "previsto0".$num;
			  ?>
			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $meses[$indx].":"; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="<?= $campo; ?>"
							size="12" maxlength="12">
				</td>
			</tr>
			<? } ?>

			<tr>
				<td width="30%" align="right">&nbsp;
				</td>
				<td width="70%" align="left">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoIncluir; ?>" name="bt_incluir">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
						OnClick="javascript:history.go(-1);">
				<input type="button" class="bjanela" name= "bt_ajuda"
					value="<?= $botaoAjuda; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwCadOrcamento')">

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

		<body class="pagina" onLoad="this.document.formConsOrcamento.oidEmpresaCont.focus();">

		<div align="center">

		<br><br><br>

		<form action="cwCadOrcamento.php"
					name="formConsOrcamento" method="get" onSubmit="return validaDados( false );">

		<?PHP
			echo "<input type=\"hidden\" name=\"operacao\" value=\"$operacao\">";
			if ( $operacao != 3 ) 
				echo "<input type=\"hidden\" name=\"controleNavegacao\" value=\"2\">";
			else 
				echo "<input type=\"hidden\" name=\"controleNavegacao\" value=\"3\">";
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
					   <option value="<?= $listaEmpresas[$indx][0]; ?>"
					   <? if ( $indx == 0 ) echo " selected"; ?>><?= $listaEmpresas[$indx][1]; ?></option>
					<? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoAno; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="ano"
							size="4" maxlength="4">
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
				$acaoExecutada = "cwCadOrcamento.php";
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
				<input type="hidden" name="tipoOperacao" value="18">

			<?PHP
				if ( $operacao == 1 ) ?>
				<input type="hidden" name="controleNavegacao" value="4">

		<?PHP
			$orcamento = new Orcamento();
			$listaOrcamento = $orcamento->buscaOrcamento( $oidEmpresaCont, $ano );

			if ( $listaOrcamento[0][0] == "0" ) {
				$msg = new MsgCw( $msgOrcamentosNaoEncontrados );
				$msg->mostra();
				exit(); }
			$conta = new Conta();
			
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
						<select name="oidOrcamento" size= "10" class="dljanela">
						<?PHP
						for ( $indx = 0; $indx < sizeof( $listaOrcamento ); $indx++ ) {
							$conta->pesquisaContaSemDV( $listaOrcamento[$indx][0] ); 
						?>
							<option value="<?= $listaOrcamento[$indx][0]."_".$listaOrcamento[$indx][1]; ?>"><?= trim( $listaOrcamento[$indx][0] )." - ".trim( $conta->getDescricao() )." - ".trim( $listaOrcamento[$indx][1] ); ?></option>
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

			$consulta->mostraConsulta( "Previsões Orçamentárias Cadastradas",
			"select conta.descricao as \"Descrição da Conta\", orc.ano as \"Ano\", orc.previsto01 as \"Jan\", orc.previsto02 as \"Fev\", orc.previsto03 as \"Mar\", orc.previsto04 as \"Abr\", orc.previsto05 as \"Mai\", orc.previsto06 as \"Jun\", orc.previsto07 as \"Jul\", orc.previsto08 as \"Ago\", orc.previsto09 as \"Set\", orc.previsto10 as \"Out\", orc.previsto11 as \"Nov\", orc.previsto12 as \"Dez\" from orcamento_cont orc, contacontabil_cont conta, empresa_cont emp where conta.codigoacesso = orc.codigoacesso and conta.codigoempresa = emp.codigo and conta.codigoempresa = '$oidEmpresaCont' and emp.codigocliente = '$oidEmpresa' order by orc.ano, orc.codigoacesso;",
										false );
			break; }

		case 4: { // Alteração de Orcamentos...

		?>

		<body class="pagina">

		<div align="center">

		<br><br>

		<?PHP
			$opcao = explode( "_", $oidOrcamento );
			$oidConta  = $opcao[0];
			$ano	   = $opcao[1];
			$orcamento = new Orcamento();
			$orcamento->pesquisaOrcamento( $oidConta, $ano );
			
			$dv = Numero::modulo11( $oidConta );

			$conta = new Conta();
			$conta->pesquisaContaSemDV( $oidConta );
		?>

		<form action="cwGravaSupervisao.php"
					name="formAltOrcamento" method="get" onSubmit="return validaDados( true );">

		<input type="hidden" name="tipoOperacao" value="17">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">
		<input type="hidden" name="oidConta" value="<?PHP echo $oidConta; ?>">
		<input type="hidden" name="ano" value="<?= $ano; ?>">

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
				  <?PHP echo $campoCodigoConta; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<?= $oidConta.".".$dv; ?>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoDescricao; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<?= $conta->getDescricao(); ?>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoAno; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<?= $ano; ?>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  &nbsp;
				</td>

				<td width="70%" align="left" class="cjanela">
				<b><? echo $msgValorOrcadoMensal; ?></b>
				</td>
			</tr>

			<? for ( $indx = 0; $indx < sizeof( $meses ); $indx++ ) {
			  $num = $indx + 1;
			  $campo = "previsto0".$num;
			  ?>
			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $meses[$indx].":"; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="<?= $campo; ?>"
							size="12" maxlength="12" value="<?= $orcamento->getPrevistoMes( $indx ); ?>">
				</td>
			</tr>
			<? } ?>

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

