<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe oid da Empresa
	$oidEmpresa = $oidEmpresaSession;
	$loginUsuario = $loginSession;
	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";

	$empresa = new Empresa();
	$empresas = $empresa->buscaEmpresa( $oidEmpresa, "",1,$loginUsuario );
?>

<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 25/06/2003
	Última Atualização: 06/07/2003
	Módulo: cwCadTermo.php
	  Cadastro de termo de abertura e fechamento
-->

<html>
<head>
<title>::FIEL Contábil::</title>


<script language="javascript">

	//--------------------------------------------
	// validaSelecaoItem()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaSelecaoItem(opcao) {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- Titulo da Consulta
			if ( document.forms[0].oidTermo.selectedIndex == -1 ) {
				mensagem += '\n - Você deve selecionar um termo de abertura-fechamento';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem ); }
			else {
				// Se e exclusao...
				if ( opcao != 1 ) {
					if( !confirm( 'Tem certeza que deseja excluir termo de abertura-fechamento?' ) )
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

			// -- Descricao
			if ( testaNulo( document.forms[0].descricao ) ) {
				mensagem += '\n - Descrição não preenchida';
				retorna = false; }

			// -- texto
			if ( testaNulo( document.forms[0].texto ) ) {
				mensagem += '\n - Texto não preenchido';
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

</SCRIPT>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="../estilo/cw.css">

</head>
<?PHP

	if ( empty( $controleNavegacao ) )
		$controleNavegacao = 0;

	$cabec = new TituloCw( $cabecCadTermo );
	$cabec->mostra();

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	// Verifica o controle de navegacao...
	switch( $controleNavegacao ) {

		// Inclusao de Termo
		default: {

?>
		<body class="pagina" onLoad="this.document.formCadTermo.descricao.focus();">

		<div align="center">

		<br>

		<form action="cwGravaSupervisao.php"
					name="formCadTermo" method="get" onSubmit="return validaDados();">

		<input type="hidden" name="tipoOperacao" value="4">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">

		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>
		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloCadTermo; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwCadTermo')">
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
						OnClick="javascript:abreJanela('cwCadTermo.php?controleNavegacao=3');">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoAlterar; ?>" name="bt_alterar"
						OnClick="javascript:abreJanela('cwCadTermo.php?controleNavegacao=1&operacao=1');">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoExcluir; ?>" name="bt_excluir"
						OnClick="javascript:abreJanela('cwCadTermo.php?controleNavegacao=1&operacao=2');">


				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoEmpresa; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="oidEmpresaCont" class="dljanela">
					<? for ( $indx = 0; $indx < sizeof( $empresas ); $indx++ ) { ?>
					   <option value="<?= $empresas[$indx][0]; ?>"><?= $empresas[$indx][1]; ?></option>
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
							size="50" maxlength="50">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoTexto; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<textarea name="texto" class="txjanela"
						rows="7" cols="60" wrap="hard"></textarea>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoLocalizacao; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
				   <input type="radio" name="localizacao" value="I" checked><?PHP echo $campoLocalizacaoInicio; ?>
				   <input type="radio" name="localizacao" value="F"><?PHP echo $campoLocalizacaoFim; ?>
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
					value="<?= $botaoAjuda; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwCadTermo')">

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

		<body class="pagina" onLoad="this.document.formConsTermo.descricao.focus();">

		<div align="center">

		<br><br><br>

		<form action="cwCadTermo.php"
					name="formConsTermo" method="get">

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
					<? for ( $indx = 0; $indx < sizeof( $empresas ); $indx++ ) { ?>
					   <option value="<?= $empresas[$indx][0]; ?>"><?= $empresas[$indx][1]; ?></option>
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
				$acaoExecutada = "cwCadTermo.php";
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
				<input type="hidden" name="tipoOperacao" value="6">

			<?PHP
				if ( $operacao == 1 ) ?>
				<input type="hidden" name="controleNavegacao" value="4">

		<?PHP
			$termo = new Termo();
			$listaTermos = $termo->buscaTermo( $oidEmpresaCont, $descricao );

			if ( $listaTermos[0][0] == "0" ) {
				$msg = new MsgCw( $msgTermosNaoEncontrados );
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
						<select name="oidTermo" size= "10" class="dljanela">
						<?PHP
						for ( $indx = 0; $indx < sizeof( $listaTermos ); $indx++ ) {
						?>
							<option value="<?= trim( $listaTermos[$indx][0] ); ?>"><?= trim( $listaTermos[$indx][1] ); ?></option>
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

		case 3: { // Consulta de Termos...

			$consulta = new ConsultaCw();

			$consulta->mostraConsulta( "Termos de Abertura e Fechamento Cadastrados",
			"select codigoempresa as \"Empresa\", descricao as \"Descrição\", texto as \"Texto\", localizacao as \"Localização(I/F)\" from termo_cont, empresa_cont where codigocliente = '$oidEmpresa' order by descricao;",
			false );
			break; }

		case 4: { // Alteração de Termos...

		?>

		<body class="pagina" onLoad="this.document.formAltTermo.descricao.focus();">

		<div align="center">

		<br><br>

		<?PHP
			$termo = new Termo();
			$termo->pesquisaTermo( $oidTermo );
		?>

		<form action="cwGravaSupervisao.php"
					name="formAltTermo" method="get" onSubmit="return validaDados();">

		<input type="hidden" name="tipoOperacao" value="5">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">
		<input type="hidden" name="oidTermo" value="<?PHP echo $oidTermo; ?>">

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
					<? for ( $indx = 0; $indx < sizeof( $empresas ); $indx++ ) { ?>
					   <option value="<?= $empresas[$indx][0]; ?>"
					   <? if ( $empresas[$indx][0] == $termo->getOidEmpresaCont() )
					      echo " selected"; ?>><?= $empresas[$indx][1]; ?></option>
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
							size="50" maxlength="50"
							value="<?= $termo->getDescricao(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoTexto; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<textarea name="texto" class="txjanela"
						rows="7" cols="60" wrap="hard"><?= $termo->getTexto(); ?></textarea>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoLocalizacao; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
				   <input type="radio" name="localizacao" value="I" <? if ( $termo->getLocalizacao() == "I" ) echo " checked"; ?>><?PHP echo $campoLocalizacaoInicio; ?>
				   <input type="radio" name="localizacao" value="F" <? if ( $termo->getLocalizacao() == "F" ) echo " checked"; ?>><?PHP echo $campoLocalizacaoFim; ?>
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

