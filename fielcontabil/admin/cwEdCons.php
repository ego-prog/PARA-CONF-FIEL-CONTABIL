<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe oid da Empresa
	$oidEmpresa = $oidEmpresaSession;
?>

<!--
	FIEL Cont�bil
	Desenvolvido por APOENA Solu��es em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Cria��o: 25/06/2003
	�ltima Atualiza��o: 29/06/2003
	M�dulo: cwEdCons.php
	  Editor de consultas personalizadas
-->
<html>
<head>
<title>::FIEL Cont�bil::</title>


<script language="javascript">

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
	// executaModulo()
	// - Executa um m�dulo com par�metro
	//--------------------------------------------
	function executaModulo( url, numero_tipo ) {

		url = url + '?tipo='+ numero_tipo;
		window.open(url,'jan','toolbar=no,directories=no,menubar=no,scrollbars=yes');

	}

	//--------------------------------------------
	// testaNulo()
	// - Testa se campo � nulo
	//--------------------------------------------
	function testaNulo( nome_campo ) {

		return ( nome_campo.value.length == 0 )?true:false;

	}

	//--------------------------------------------
	// mostraModulo()
	// - Mostra m�dulo
	//--------------------------------------------
	function mostraModulo( url ) {

	   url = url + '&titulo=' + escape(document.formEdCons.titulo.value) +
			 '&query='+ escape(document.formEdCons.instrucaoSql.value);

	  window.open(url,'a','toolbar=no,directories=no,menubar=no,scrollbars=yes' );


	}

	//--------------------------------------------
	// validaDados()
	// - Testa validade das Query
	//--------------------------------------------
	function validaDados() {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;
		var str_modulo, posicao, soma;
		var str_query, parte_str;


		// -- T�tulo
		if ( testaNulo( document.forms[0].titulo ) ) {
			mensagem += '\n - T�tulo da Consulta n�o preenchida';
			retorna = false; }

		str_modulo = document.forms[0].modulo.value;
		str_query  = document.forms[0].instrucaoSql.value;

		if (str_modulo.length == 0 && str_query.length == 0 ) {
			mensagem += '\n - � necess�rio informar o m�dulo PHP ou a instru��o SQL';
			retorna = false; }

		if (str_modulo.length > 0 && str_query.length > 0) {
			mensagem += '\n - Informar somente um m�dulo PHP3 ou instru��o SQL';
			retorna = false; }

		if (str_query.length > 0) {

			// busca o ponto e virgula na query.
			// ---------------------------------
			if(str_query.indexOf(";",0) == -1) {
				mensagem += '\n - Falta o ponto e v�rgula (;) no final da query';
				retorna = false; }


			// busca o SELECT na query.
			// ------------------------
			soma = 0;
			for ( posicao = 0; posicao < ( str_query.length ); posicao++ ) {
				parte_str = str_query.substring( posicao, posicao + 6 );
				parte_str = parte_str.toUpperCase();
				if (parte_str == 'SELECT') {
					soma = soma + 1; } }

				if ( soma == 0 ) {
					mensagem += '\n - Query incorreta - falta da instru��o SELECT';
					retorna = false; }


			// busca o FROM na query.
			// ------------------------
			for ( posicao = 0; posicao < ( str_query.length ); posicao++ ) {
				parte_str = str_query.substring( posicao, posicao + 4 );
				parte_str = parte_str.toUpperCase();
				if ( parte_str == 'FROM') {
					soma = soma + 1; } }

				if ( soma == 0 ) {
					mensagem += '\n - Query incorreta - falta da instru��o FROM';
					retorna = false; }

		 }

		if ( !retorna ) {
			alert( mensagem );
				document.forms[0].titulo.focus(); }

		return retorna;

	}

</SCRIPT>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="../estilo/cw.css">

</head>

<?PHP

	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	if ( empty( $controleNavegacao ) )
		$controleNavegacao = 0;

	 switch( $controleNavegacao ) {

	 default: {

		  $cabec = new TituloCw( $cabecTituloEdCons );
		  $cabec->mostra();
?>
<body class="pagina" onLoad="this.document.formEdCons.perfilUsuario.focus();">

	<div align="center">

	<br><br>

	<form action="cwGravaAdmin.php"
				name="formEdCons" method="get" onSubmit="return validaDados();">

	<input type="hidden" name="tipoOperacao" value="3">


		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloEdCons; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwEdCons')">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>

		<!-- Op��es do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoPerfilUsuario; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="perfilUsuario" class="dljanela">
						<option value="A"><?PHP echo $msgPerfilAdministrador; ?></option>
						<option value="S"><?PHP echo $msgPerfilSupervisor; ?></option>
						<option value="O"><?PHP echo $msgPerfilOperador; ?></option>
						<option value="C"><?PHP echo $msgPerfilConsulta; ?></option>
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela"><?PHP echo $campoTitulo; ?>
				</td>
				<td align="left" width="70%" class="cjanela">
				   <input type="text" class="txjanela" name="titulo"
						size="40" maxlength="70">

				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela"><?PHP echo $campoModuloPHP; ?>
				</td>
				<td align="left" width="70%" class="cjanela">
				   <input type="text" class="txjanela" name="modulo"
						size="40" maxlength="70">

				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela"><?PHP echo $campoInstrucaoSQL; ?>
				</td>
				<td align="left" width="70%" class="cjanela">
					<textarea name="instrucaoSql" class="txjanela"
						rows="10" cols="60" wrap="hard"></textarea>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right">&nbsp;
				</td>
				<td width="70%" align="left">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoPreview; ?>" name="bt_preview"
					OnClick="javascript:mostraModulo('cwEdCons.php?controleNavegacao=1');">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoIncluir; ?>" name="bt_incluir">
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
	 break;
	 }

	 case 1: {

		 // Executa preview da consulta...
		 $consulta = new ConsultaCw();
		 $resposta = $consulta->mostraConsulta( $titulo, $query, false );
		 if ( !$resposta ) {
		  echo "<body bgcolor=\"#FFFFFF\"><div align=\"center\">";
		  $cabec = new TituloCw( $cabecTituloEdCons );
		  $cabec->mostra();
			 $msg = new MsgCw( $msgNaoFoiPossivelExecutarConsulta,
				"../imagens/contabil.jpg", "javascript:window.close();" );
			 $msg->mostra();
			exit;
		  echo "</div></body>";	
		 }
		 		 
		 break;

	 }

   }
?>
</html>
