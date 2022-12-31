<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe oid da Empresa
	$oidEmpresa = $oidEmpresaSession;
?>

<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 25/06/2003
	Última Atualização: 29/06/2003
	Módulo: cwConsLog.php
	  Consulta de LOG do sistema
-->
<html>
<head>
<title>::FIEL Contábil::</title>


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

			// -- Data
			if ( testaNulo( document.forms[0].dataInicial ) ) {
				mensagem += '\n - Data inicial não preenchida';
				retorna = false; }

			// -- Data
			if ( !validaData( document.forms[0].dataInicial ) ) {
				mensagem += '\n - Data inicial inválida';
				retorna = false; }

			// -- Data
			if ( testaNulo( document.forms[0].dataFinal ) ) {
				mensagem += '\n - Data final não preenchida';
				retorna = false; }

			// -- Data
			if ( !validaData( document.forms[0].dataFinal ) ) {
				mensagem += '\n - Data final inválida';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem );
				document.forms[0].dataInicial.focus(); }

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

	$cabec = new TituloCw( $cabecConsLog );
	$cabec->mostra();

	$usuario = new UsuarioCw();
	$listaUsuarios = $usuario->buscaUsuario( $oidEmpresa, "" );
	
	switch( $controleNavegacao ) {

	 default: {

?>
<body class="pagina" onLoad="this.document.formConsLog.dataInicial.focus();">

	<div align="center">

	<br><br>

	<form action="cwConsLog.php"
				name="formConsLog" method="get" onSubmit="return validaDados();">

	<input type="hidden" name="controleNavegacao" value="1">


		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloConsLog; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwConsLog')">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>

		<!-- Opções do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoDataInicial; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
				    <input type="text" name="dataInicial" class="txjanela" size="10" maxlength="10">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoDataFinal; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
				    <input type="text" name="dataFinal" class="txjanela" size="10" maxlength="10">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoNumeroIp; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
				    <input type="text" name="numeroIp" class="txjanela" size="15" maxlength="15">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoNomeUsuario; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="loginUsuario" class="dljanela">
						<option value="0"><?PHP echo $msgTodosUsuarios; ?></option>
						<? for ( $indx = 0; $indx < sizeof( $listaUsuarios ); $indx++ ) { ?>
							<option value="<?= $listaUsuarios[$indx][2]; ?>"><?PHP echo $listaUsuarios[$indx][2]." - ".$listaUsuarios[$indx][1]; ?></option>
						<? } ?>
					</select>

				</td>
			</tr>

			<tr>
				<td width="30%" align="right">&nbsp;
				</td>
				<td width="70%" align="left">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoConsultar; ?>" name="bt_incluir">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
					OnClick="javascript:history.go(-1);">
					<input type="button" class="bjanela"
					value="<?PHP echo $botaoAjuda; ?>" name="bt_ajuda"
					OnClick="javascript:abreAjuda('../cw_ajuda.html#cwConsLog');">
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

	 $log = new LogCw();
	 if ( !( $listaLog = $log->pesquisaLog( $oidEmpresa,
			     $dataInicial, $dataFinal, $numeroIp, $loginUsuario ) ) ) {

	?>
	<body class="pagina" onLoad="this.document.formConsLog.dataInicial.focus();">

	<div align="center">
	<?				 
		$msg = new MsgCw( $msgConsultaInvalida );
		$msg->mostra();
	?>
	</div>
	</body>
	<?
	 }
	 else
	     $log->mostraPesquisaLog( $listaLog );
	 break;
	 }

   }
?>
</html>
