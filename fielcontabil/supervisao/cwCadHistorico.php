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
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 25/06/2003
	Última Atualização: 11/07/2003
	Módulo: cwCadHistorico.php
	  Cadastro de historico padrão
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
			if ( document.forms[0].oidHistorico.selectedIndex == -1 ) {
				mensagem += '\n - Você deve selecionar um histórico padrão';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem ); }
			else {
				// Se e exclusao...
				if ( opcao != 1 ) {
					if( !confirm( 'Tem certeza que deseja excluir histórico padrão?' ) )
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
			if ( testaNulo( document.forms[0].historico ) ) {
				mensagem += '\n - Histórico não preenchido';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem );
				document.forms[0].historico.focus(); }

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
	// setaValor()
	// - Seta valor recebido
	//--------------------------------------------
	function setaValor( valor1, valor2 ) {

		window.opener.setaHistorico( valor1, valor2 );
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
	$cabec = new TituloCw( $cabecCadHistorico );
	$cabec->mostra();

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	// Verifica o controle de navegacao...
	switch( $controleNavegacao ) {

		// Inclusao de Historico
		default: {

?>
		<body class="pagina" onLoad="this.document.formCadHistorico.historico.focus();">

		<div align="center">

		<br>

		<form action="cwGravaSupervisao.php"
					name="formCadHistorico" method="get" onSubmit="return validaDados();">

		<input type="hidden" name="tipoOperacao" value="13">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">

		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>
		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloCadHistorico; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwCadHistorico')">
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
						OnClick="javascript:abreJanela('cwCadHistorico.php?controleNavegacao=1&operacao=3');">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoAlterar; ?>" name="bt_alterar"
						OnClick="javascript:abreJanela('cwCadHistorico.php?controleNavegacao=1&operacao=1');">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoExcluir; ?>" name="bt_excluir"
						OnClick="javascript:abreJanela('cwCadHistorico.php?controleNavegacao=1&operacao=2');">


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
				  <?PHP echo $campoHistorico; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="historico"
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
					value="<?= $botaoAjuda; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwCadHistorico')">

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

		<body class="pagina" onLoad="this.document.formConsHistorico.historico.focus();">

		<div align="center">

		<br><br><br>

		<form action="cwCadHistorico.php"
					name="formConsHistorico" method="get">

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
					<? for ( $indx = 0; $indx < sizeof( $empresas ); $indx++ ) { ?>
					   <option value="<?= $empresas[$indx][0]; ?>"><?= $empresas[$indx][1]; ?></option>
					<? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoHistorico; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="historico"
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
				$acaoExecutada = "cwCadHistorico.php";
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
				<input type="hidden" name="tipoOperacao" value="15">

			<?PHP
				if ( $operacao == 1 ) ?>
				<input type="hidden" name="controleNavegacao" value="4">

		<?PHP
			$historicoPadrao = new HistoricoPadrao();
			$listaHistorico = $historicoPadrao->buscaHistoricoPadrao( $oidEmpresaCont, $historico );

			if ( $listaHistorico[0][0] == "0" ) {
				$msg = new MsgCw( $msgHistoricosNaoEncontrados );
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
						<select name="oidHistorico" size= "10" class="dljanela">
						<?PHP
						for ( $indx = 0; $indx < sizeof( $listaHistorico ); $indx++ ) {
						?>
							<option value="<?= trim( $listaHistorico[$indx][0] ); ?>"><?= trim( $listaHistorico[$indx][1] ); ?></option>
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

		case 3: { // Consulta de Historicos...

			$consulta = new ConsultaCw();

			$consulta->mostraConsulta( "Históricos Padrões Cadastrados",
			"select hist.codigo as \"Código\", emp.razaosocial as \"Empresa\", hist.historico as \"Histórico\" from historicopadrao_cont hist, empresa_cont emp where codigoempresa = emp.codigo and codigoempresa = '$oidEmpresaCont' and emp.codigocliente = '$oidEmpresa' order by hist.codigo, hist.historico;",
										false );
			break; }

		case 4: { // Alteração de Historicos...

		?>

		<body class="pagina" onLoad="this.document.formAltHistorico.historico.focus();">

		<div align="center">

		<br><br>

		<?PHP
			$historicoPadrao = new HistoricoPadrao();
			$historicoPadrao->pesquisaHistoricoPadrao( $oidHistorico );
		?>

		<form action="cwGravaSupervisao.php"
					name="formAltHistorico" method="get" onSubmit="return validaDados();">

		<input type="hidden" name="tipoOperacao" value="14">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">
		<input type="hidden" name="oidHistorico" value="<?PHP echo $oidHistorico; ?>">

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
					   <? if ( $empresas[$indx][0] == $historicoPadrao->getOidEmpresaCont() )
					      echo " selected"; ?>><?= $empresas[$indx][1]; ?></option>
					<? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoHistorico; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="historico"
							size="40" maxlength="40" value="<?= $historicoPadrao->getHistorico(); ?>">
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

		case 5: {

		// Realizar pesquisa de historicos padroes da empresa consultada, listando somente as
		// sinteticas

		// Carrega lista de empresas
		$empresa = new Empresa();
		$listaEmpresas = $empresa->buscaEmpresa( $oidEmpresa, "", 2 );

		for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ )
			if ( $listaEmpresas[$indx][0] == $oidEmpresaCont )
			$nomeEmpresa = $listaEmpresas[$indx][1];

		$historico = new HistoricoPadrao();
		$listaHistorico = $historico->buscaHistoricoPadrao( $oidEmpresaCont, "", 2 );

	 ?>

		<body class="pagina">

		<div align="center">

		<!-- Mostra o resultado da consulta, esta sera validada com
		o Framework de relatorio -->
		<br><br><br>
		<center>
		<font face="Verdana, Arial" color="#000099" size="2">
		<b><?= $tituloCadHistorico; ?></b><br>
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
	       for ( $indx = 0; $indx < sizeof( $listaHistorico ); $indx++ ) {
	       $cor	       = ($indx % 2 ) == 0?"lcons1":"lcons2";
	       if ( $oidEmpresaCont == $listaHistorico[$indx][0] ) {
	       $descricao = $listaHistorico[$indx][2];
		   $codigo    = $listaHistorico[$indx][1];
	       $link = "javascript:setaValor( '".$codigo."', '".$descricao."');";
	     ?>
			<tr>
			<td width="40%" align="left" class="<?= $cor; ?>">
			   <a href="<?= $link; ?>">
			   <?= $listaHistorico[$indx][1]; ?>
			   </a>
			</td>
			<td width="60%" align="left" class="<?= $cor; ?>">
			   <a href="<?= $link; ?>">
			   <?= $listaHistorico[$indx][2]; ?>
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

