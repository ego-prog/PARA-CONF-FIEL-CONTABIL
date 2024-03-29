<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe oid da Empresa
	$oidEmpresa   = $oidEmpresaSession;
	$loginUsuario = $loginSession;

	if ( empty( $oidEmpresaContCookie ) )
		setcookie( "oidEmpresaContCookie", -1 );

	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";

	$empresa = new Empresa();
	$empresas = $empresa->buscaEmpresa( $oidEmpresa, "",1,$loginUsuario );

?>

<!--
	FIEL Cont�bil
	Desenvolvido por APOENA Solu��es em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Cria��o: 21/03/2005
	�ltima Atualiza��o: 21/03/2005
	M�dulo: cwCadCentro.php
	  Cadastro de Centros de Custo
-->

<html>
<head>
<title>::FIEL Cont�bil::</title>


<script language="javascript">

	//--------------------------------------------
	// validaSelecaoItem()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaSelecaoItem(opcao) {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- Titulo da Consulta
			if ( document.forms[0].oidCentroCusto.selectedIndex == -1 ) {
				mensagem += '\n - Voc� deve selecionar um centro de custo';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem ); }
			else {
				// Se e exclusao...
				if ( opcao != 1 ) {
					if( !confirm( 'Tem certeza que deseja excluir Centro de Custo ?' ) )
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

			// -- texto
			if ( testaNulo( document.forms[0].sigla ) ) {
				mensagem += '\n - Sigla n�o preenchida';
				retorna = false; }

			if ( testaNulo( document.forms[0].descricao ) ) {
				mensagem += '\n - Descri��o n�o preenchida';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem );
				document.forms[0].sigla.focus(); }

		return retorna;

	}

	//--------------------------------------------
	// testaNulo()
	// - Testa se campo � nulo
	//--------------------------------------------
	function testaNulo( nome_campo ) {

		return ( nome_campo.value.length == 0 )?true:false;

	}

	//--------------------------------------------
	// comparaCampo()
	// - Testa se campos s�o iguais
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
	// setaValor()
	// - Seta valor recebido
	//--------------------------------------------
	function setaValor( valor1, valor2 ) {

		window.opener.setaCentroCusto( valor1, valor2 );
		window.close();

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
	$cabec = new TituloCw( $cabecCadCentro );
	$cabec->mostra();

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	// Verifica o controle de navegacao...
	switch( $controleNavegacao ) {

		// Inclusao de Centro de Custo
		default: {

?>
		<body class="pagina" onLoad="this.document.formCadCentro.sigla.focus();">

		<div align="center">

		<br><br><br><br><br>

		<form action="cwGravaSupervisao.php"
					name="formCadCentro" method="get" onSubmit="return validaDados();">

		<input type="hidden" name="tipoOperacao" value="28">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">

		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>
		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloCadCentro; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwCadCentro')">
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
				<td width="30%" align="right">&nbsp;
				</td>
				<td width="70%" align="left">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoConsultar; ?>" name="bt_consultar"
						OnClick="javascript:abreJanela('cwCadCentro.php?controleNavegacao=1&operacao=3');">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoAlterar; ?>" name="bt_alterar"
						OnClick="javascript:abreJanela('cwCadCentro.php?controleNavegacao=1&operacao=1');">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoExcluir; ?>" name="bt_excluir"
						OnClick="javascript:abreJanela('cwCadCentro.php?controleNavegacao=1&operacao=2');">


				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoEmpresa; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="oidEmpresaCont" class="dljanela">
					<? for ( $indx = 0; $indx < sizeof( $empresas ); $indx++ ) { ?>
					   <option value="<?= $empresas[$indx][0]; ?>"
					   <? if ( $oidEmpresaContCookie == $empresas[$indx][0] )
							echo " selected"; ?>><?= $empresas[$indx][1]; ?></option>
					<? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoSigla; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="sigla"
							size="10" maxlength="10">
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
					<input type="submit" class="bjanela" value="<?PHP echo $botaoIncluir; ?>" name="bt_incluir">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
						OnClick="javascript:history.go(-1);">
				<input type="button" class="bjanela" name= "bt_ajuda"
					value="<?= $botaoAjuda; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwCadCentro')">

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

		<body class="pagina" onLoad="this.document.formConsCentro.descricao.focus();">

		<div align="center">

		<br><br><br>

		<form action="cwCadCentro.php"
					name="formConsDescricao" method="get">

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

		<!-- Op��es do Menu -->
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

		case 2: { // Seleciona o item para opera��o...

			// Se for altera��o...
			if ( $operacao == 1 ) {
				$acaoExecutada = "cwCadCentro.php";
				$botao = $botaoAlterar; }
			// Se for exclus�o...
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
				<input type="hidden" name="tipoOperacao" value="30">

			<?PHP
				if ( $operacao == 1 ) ?>
				<input type="hidden" name="controleNavegacao" value="4">

		<?PHP
			$centroCusto = new CentroCusto();
			$listaCentro = $centroCusto->buscaCentroCusto( $oidEmpresaCont, $descricao );

			if ( $listaCentro[0][0] == "0" ) {
				$msg = new MsgCw( $msgCentrosNaoEncontrados );
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
						<select name="oidCentroCusto" size= "10" class="dljanela">
						<?PHP
						for ( $indx = 0; $indx < sizeof( $listaCentro ); $indx++ ) {
						?>
							<option value="<?= trim( $listaCentro[$indx][0] ); ?>"><?= trim( $listaCentro[$indx][2] ); ?></option>
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

		case 3: { // Consulta de Centros de Custo...

			$consulta = new ConsultaCw();

			$consulta->mostraConsulta( "Centros de Custo Cadastrados",
			"select centro.codigo as \"C�digo\", emp.razaosocial as \"Empresa\", centro.sigla as \"Sigla\", centro.descricao as \"Descri��o\" from centrocusto_cont centro, empresa_cont emp where codigoempresa = emp.codigo and codigoempresa = '$oidEmpresaCont' and emp.codigocliente = '$oidEmpresa' order by centro.codigo, centro.descricao;",
										false );
			break; }

		case 4: { // Altera��o de Centro de Custo...

		?>

		<body class="pagina" onLoad="this.document.formAltCentro.sigla.focus();">

		<div align="center">

		<br><br><br><br><br>

		<?PHP
			$centroCusto = new CentroCusto();
			$centroCusto->pesquisaCentroCusto( $oidCentroCusto );
		?>

		<form action="cwGravaSupervisao.php"
					name="formAltCentro" method="get" onSubmit="return validaDados();">

		<input type="hidden" name="tipoOperacao" value="29">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">
		<input type="hidden" name="oidCentroCusto" value="<?PHP echo $oidCentroCusto; ?>">

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

		<!-- Op��es do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoEmpresa; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="oidEmpresaCont" class="dljanela">
					<? for ( $indx = 0; $indx < sizeof( $empresas ); $indx++ ) { ?>
					   <option value="<?= $empresas[$indx][0]; ?>"
					   <? if ( $empresas[$indx][0] == $centroCusto->getOidEmpresaCont() )
					      echo " selected"; ?>><?= $empresas[$indx][1]; ?></option>
					<? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoSigla; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="sigla"
							size="10" maxlength="10" value="<?= $centroCusto->getSigla(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoDescricao; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="descricao"
							size="40" maxlength="40" value="<?= $centroCusto->getDescricao(); ?>">
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
		break; } // Fim do Case (Altera��o)

		case 5: {

		// Realizar pesquisa de centros de custo da empresa consultada

		// Carrega lista de empresas
		$empresa = new Empresa();
		$listaEmpresas = $empresa->buscaEmpresa( $oidEmpresa, "", 2 );

		for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ )
			if ( $listaEmpresas[$indx][0] == $oidEmpresaCont )
			$nomeEmpresa = $listaEmpresas[$indx][1];

		$centroCusto = new CentroCusto();
		$listaCentro = $centroCusto->buscaCentroCusto( $oidEmpresaCont, "", 2 );

	 ?>

		<body class="pagina">

		<div align="center">

		<!-- Mostra o resultado da consulta, esta sera validada com
		o Framework de relatorio -->
		<br><br><br>
		<center>
		<font face="Verdana, Arial" color="#000099" size="2">
		<b><?= $tituloCadCentro; ?></b><br>
		<?= $oidEmpresaCont." - ".$nomeEmpresa; ?></font>
		</center>
		<br>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="40%" class="tjanela" align="left">
				<?= $relatorioCodigo; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="60%" class="tjanela" align="left">
				<?= $relatorioDescricao; ?>
			</td>
			</tr>

	     <?
	       for ( $indx = 0; $indx < sizeof( $listaCentro ); $indx++ ) {
	       $cor	       = ($indx % 2 ) == 0?"lcons1":"lcons2";
	       if ( $oidEmpresaCont == $listaCentro[$indx][0] ) {
		   $descricao = $listaCentro[$indx][2];
		   $codigo    = $listaCentro[$indx][1];
	       $link = "javascript:setaValor( '".$codigo."', '".$descricao."');";
	     ?>
			<tr>
			<td width="40%" align="left" class="<?= $cor; ?>">
			   <a href="<?= $link; ?>">
			   <?= $listaCentro[$indx][1]; ?>
			   </a>
			</td>
			<td width="60%" align="left" class="<?= $cor; ?>">
			   <a href="<?= $link; ?>">
			   <?= $listaCentro[$indx][2]; ?>
			   </a>
			</td>
			</tr>
	      <? }
	       } ?>
	      </table>

	     </div>
	     </body>

	 <?
	 break;
	 }

	} // Fim do Switch/Case
?>

</html>

