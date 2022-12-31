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

	$doar = new ContaDoar();
	$listaDoar = $doar->buscaContaDoar( $oidEmpresa, "", 3 );

?>

<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 25/06/2003
	Última Atualização: 08/07/2003
	Módulo: cwCadPlano.php
	  Cadastro de Plano de Contas
-->

<html>
<head>
<title>::FIEL Contábil::</title>


<script language="javascript">

	var empresas		= new Array;
	<?= "var totalEmpresas = ".sizeof( $listaEmpresas ).";" ?> 
	var listaDoar = new Array();
	var contador		= -1;
	var itemsIndex;

	//--------------------------------------------
	// newEmpresaConta()
	// - Seta nova empresa
	//--------------------------------------------
	function newEmpresaConta() {

		 contador++;
		 listaDoar[contador] = new Array();
		 itemsIndex = 0;

	}

	//--------------------------------------------
	// newConta()
	// - Seta nova conta
	//--------------------------------------------
	function newConta( codigoAcessoTmp, descricaoTmp, empresaTmp ) {

		 listaDoar[contador][itemsIndex]= new setaConta( codigoAcessoTmp, descricaoTmp, empresaTmp );
		 itemsIndex++;
	}

	//--------------------------------------------
	// setaConta()
	// - Seta nova conta
	//--------------------------------------------
	function setaConta( codigoAcessoTmp, descricaoTmp, empresaTmp ){

		 this.text		   = codigoAcessoTmp + " - " + descricaoTmp;
		 this.value	   = codigoAcessoTmp;
		 this.codEmpresa   = empresaTmp;

	}

	//--------------------------------------------
	// carregaColecao()
	// - Carrega colecao
	//--------------------------------------------
	function carregaContasDoar() {
		<?
		for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) {
				echo "\n		// ".$listaEmpresas[$indx][1]."\n		newEmpresaConta();\n";
			 // Laco de contas...
			 echo " 	newConta( '0', 'Nenhuma', '".$listaEmpresas[$indx][0]."' );\n";
			 for ( $indy = 0; $indy < sizeof( $listaDoar ); $indy++ ) {
			 if ( $listaDoar[$indy][0] == $listaEmpresas[$indx][0] ) {
				echo "		newConta( '".$listaDoar[$indy][1]."', '".$listaDoar[$indy][2]."', '".$listaDoar[$indy][0]."' );\n";
			 }
			 }
		}

		if ( empty( $oidEmpresaContCookie ) || $oidEmpresaContCookie == -1 )
			echo "\n	  selecionaConta( '0' );\n\n";
		else {
			for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) {
				if ( $oidEmpresaContCookie == $listaEmpresas[$indx][0] ) {
					echo "\n	  selecionaConta( '".$indx."' );\n\n";
				}
			}
		}
			
		?>
	}

	//--------------------------------------------
	// selecionaConta()
	// - Seleciona conta de determinada empresa
	//--------------------------------------------
	function selecionaConta( codigoEmpresa ) {

		var posArray = -1, indx, indy;
		document.forms[0].oidContaDoar.options.length = 0;

		codigoEmpresa = document.forms[0].oidEmpresaCont[codigoEmpresa].value;		
		
		for ( indx = 0; indx < listaDoar.length; indx++ ) {

			for ( indy = 0; indy < listaDoar[indx].length; indy++ ) {
				if ( listaDoar[indx][indy].codEmpresa == codigoEmpresa ) {
					posArray = indx;
					break; }
			}
		
		}

			for ( indx = 0; indx < listaDoar[posArray].length; indx++ ) {

				// Testar o codigo da empresa novamente
				document.forms[0].oidContaDoar.options[indx] =
					new Option( listaDoar[posArray][indx].text,
						listaDoar[posArray][indx].value );
			}
		
	}

	//--------------------------------------------
	// selecionaContaDoar()
	// - Seleciona conta DOAR
	//--------------------------------------------
	function selecionaContaDoar( codigoEmpresa, codigoDoar ) {

		codigoEmpresa = document.forms[0].oidEmpresaCont[codigoEmpresa].value;		
		
		for ( indx = 0; indx < listaDoar.length; indx++ ) {

			for ( indy = 0; indy < listaDoar[indx].length; indy++ ) {
				if ( listaDoar[indx][indy].codEmpresa == codigoEmpresa ) {
					posArray = indx;
					break; }
			}
		
		}

		for ( indx = 0; indx < listaDoar[posArray].length; indx++ ) {

			if ( listaDoar[posArray][indx].value == codigoDoar )
			document.forms[0].oidContaDoar.options[indx].selected = true;

		}

	}

	//--------------------------------------------
	// validaSelecaoItem()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaSelecaoItem(opcao) {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- Titulo da Consulta
			if ( document.forms[0].oidPlano.selectedIndex == -1 ) {
				mensagem += '\n - Você deve selecionar um plano de contas';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem ); }
			else {
				// Se e exclusao...
				if ( opcao != 1 ) {
					if( !confirm( 'Tem certeza que deseja excluir conta contábil?' ) )
						retorna = false;
				}
			}

		return retorna;

	}

	//--------------------------------------------
	// setaValor()
	// - Seta valor recebido
	//--------------------------------------------
	function setaValor( numero, descricao ) {

		window.opener.setaAtributo( numero, descricao );
		window.close();

	}

	//--------------------------------------------
	// testaNumero
	// - Valida se e numero e ponto
	//--------------------------------------------
	function testaNumero( numero ) {
		 return /^[0-9.]+$/.test( numero );
	}

	//--------------------------------------------
	// testaCredoraDevedora
	// - Valida se e numero e ponto
	//--------------------------------------------
	function testaCredoraDevedora() {
		  return ( ( document.forms[0].podeDevedora[1].checked ) &&
			   ( document.forms[0].podeCredora[1].checked )?true:false );
	}

	//--------------------------------------------
	// validaCodigoSintetico()
	// - Valida codigo de sintetico
	//--------------------------------------------
	function validaCodigoSintetico( codigo, mascara ) {

		var mascara    = mascara.value;
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
		if ( !testaNumero( codigo ) )
			   flagRetorno = false;

		// Coloca o codigo em um vetor de niveis
		for ( indx = 0; indx < tamanhoCodigo; indx++ ) {
			if ( codigo.charAt( indx ) == '.' )
			   nivel++;
			else
			   valorNivel[nivel] += codigo.charAt( indx );
		}

		// Testa se algum nivel esta zerado (invalido)
		for ( indx = nivel; indx >= 0; indx-- )
		if ( valorNivel[indx] == 0	)
			flagRetorno = false;

		// Verifica conformidade da mascara
		// com o codigo informado
		nivel = 0;
		for ( indx = 0; indx < tamanhoMascara; indx++ ) {
			if ( codigo.charAt( indx ) == '.' )
			   nivel++;
			if ( codigo.charAt( indx ) == '.' &&
			 !( mascara.charAt( indx ) == '.' &&
			 valorNivel[nivel] > 0 ) )
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

		var mascara    = mascara.value;
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

			// -- Descricao
			if ( testaNulo( document.forms[0].descricao ) ) {
				mensagem += '\n - Descrição não preenchida';
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

			// -- Testa credora e devedora
			if ( testaCredoraDevedora() ) {
				mensagem += '\n - Conta deve permitir saldo devedor ou credor';
				retorna = false; }

			// -- Testa conta sintética e DOAR
			if ( document.forms[0].tipo[0].checked &&
				 document.forms[0].oidContaDoar.selectedIndex != 0 ) {
				mensagem += '\n - Impossível associar uma conta sintética a uma conta DOAR';
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
	function validaDadosAlt( controle ) {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- Descricao
			if ( testaNulo( document.forms[0].descricao ) ) {
				mensagem += '\n - Descrição não preenchida';
				retorna = false; }

			// -- Testa credora e devedora
			if ( testaCredoraDevedora() ) {
				mensagem += '\n - Conta deve permitir saldo devedor ou credor';
				retorna = false; }

			// -- Conta
			if ( !validaConta( document.forms[0].codigoSintetico,document.forms[0].mascaraCodigo, true ) ) {
				mensagem += '\n - Conta definida no último nivel somente pode ser analítica';
				retorna = false; }

			// -- Conta
			if ( !validaConta( document.forms[0].codigoSintetico,document.forms[0].mascaraCodigo, false ) ) {
				mensagem += '\n - Conta definida em níveis anteriores somente pode ser sintética';
				retorna = false; }

			// -- Testa conta sintética e DOAR
			if ( document.forms[0].tipo[0].checked &&
				 document.forms[0].oidContaDoar.selectedIndex != 0 ) {
				mensagem += '\n - Impossível associar uma conta sintética a uma conta DOAR';
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
		echo "		empresas[$indx][2] = '".$listaEmpresas[$indx][2]."';\n";
		}

		echo "\n	  setaEmpresa( empresas[0][0] );\n\n";
		?>
	}

	//--------------------------------------------
	// setaValor()
	// - Seta valor recebido
	//--------------------------------------------
	function setaValor( valor1, valor2, valor3 ) {

		window.opener.setaConta( valor1, valor2, valor3 );
		window.close();

	}

	//--------------------------------------------
	// setaCP()
	// - Seta valor recebido para contra-partida
	//--------------------------------------------
	function setaCP( numero, descricao ) {

		window.opener.setaContraPartida( numero, descricao );
		window.close();

	}

	//--------------------------------------------
	// setaValorZeramento()
	// - Seta valor recebido
	//--------------------------------------------
	function setaValorZeramento( valor1, valor2, valor3 ) {

		window.opener.setaContaZeramento( valor1, valor2, valor3 );
		window.close();

	}

	//--------------------------------------------
	// setaEmpresa()
	// - Troca informacao da empresa
	//--------------------------------------------
	function setaEmpresa( codigoEmpresa ) {

		var indx;
		 for ( indx = 0; indx < totalEmpresas; indx++ ) {
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
	$cabec = new TituloCw( $cabecCadPlano );
	$cabec->mostra();

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	// Verifica o controle de navegacao...
	switch( $controleNavegacao ) {

		// Inclusao de Plano
		default: {

?>
		<body class="pagina" onLoad="carregaColecao();carregaContasDoar();this.document.formCadPlano.codigoSintetico.focus();">

		<div align="center">

		<br>

		<form action="cwGravaSupervisao.php"
					name="formCadPlano" method="get" onSubmit="return validaDados();">

		<input type="hidden" name="tipoOperacao" value="7">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">
		<input type="hidden" name="mascaraCodigo" value="<?= $listaEmpresas[0][2]; ?>">

		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>
		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo $tituloCadPlano; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwCadPlano')">
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
						OnClick="javascript:abreJanela('cwCadPlano.php?controleNavegacao=1&operacao=3');">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoAlterar; ?>" name="bt_alterar"
						OnClick="javascript:abreJanela('cwCadPlano.php?controleNavegacao=1&operacao=1');">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoExcluir; ?>" name="bt_excluir"
						OnClick="javascript:abreJanela('cwCadPlano.php?controleNavegacao=1&operacao=2');">


				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoEmpresa; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="oidEmpresaCont" class="dljanela" onChange="setaEmpresa(this.options[selectedIndex].value);selecionaConta( this.selectedIndex );">
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
							size="14" maxlength="14" value="<?= $listaEmpresas[0][2]; ?>" onFocus="this.blur();document.forms[0].descricao.focus();"></i>
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
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoNatureza; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
				   <input type="radio" name="natureza" value="D" checked><?PHP echo $campoNaturezaDevedora; ?>
				   <input type="radio" name="natureza" value="C"><?PHP echo $campoNaturezaCredora; ?>
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
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoClassificacao; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
				   <input type="radio" name="classificacao" value="D"><?PHP echo $campoClassificacaoDespesa; ?>
				   <input type="radio" name="classificacao" value="R"><?PHP echo $campoClassificacaoReceita; ?>
				   <input type="radio" name="classificacao" value="O" checked><?PHP echo $campoClassificacaoOutra; ?>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoPodeFicarCredora; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
				   <input type="radio" name="podeCredora" value="S" checked><?PHP echo $campoPodeCredoraSim; ?>
				   <input type="radio" name="podeCredora" value="N"><?PHP echo $campoPodeCredoraNao; ?>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoPodeFicarDevedora; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
				   <input type="radio" name="podeDevedora" value="S" checked><?PHP echo $campoPodeDevedoraSim; ?>
				   <input type="radio" name="podeDevedora" value="N"><?PHP echo $campoPodeDevedoraNao; ?>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoContaDoar; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="oidContaDoar" class="dljanela">
					<option value="0"><?= $msgNenhuma; ?></option>
					</select>
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
					value="<?= $botaoAjuda; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#cwCadPlano')">

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

		<body class="pagina" onLoad="this.document.formConsPlano.descricao.focus();">

		<div align="center">

		<br><br><br>

		<form action="cwCadPlano.php"
					name="formConsPlano" method="get">

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
				$acaoExecutada = "cwCadPlano.php";
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
				<input type="hidden" name="tipoOperacao" value="9">

			<?PHP
				if ( $operacao == 1 ) ?>
				<input type="hidden" name="controleNavegacao" value="4">

		<?PHP
			$conta = new Conta();
			$listaPlanos = $conta->buscaConta( $oidEmpresaCont, $descricao );

			if ( $listaPlanos[0][0] == "0" ) {
				$msg = new MsgCw( $msgPlanoNaoEncontrados );
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
						<select name="oidPlano" size= "10" class="dljanela">
						<?PHP
						for ( $indx = 0; $indx < sizeof( $listaPlanos ); $indx++ ) {
						?>
							<option value="<?= trim( $listaPlanos[$indx][0] ); ?>"><?= trim( $listaPlanos[$indx][1] )." - ".trim( $listaPlanos[$indx][2] ); ?></option>
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

		case 3: { // Consulta de Planos...

			$consulta = new ConsultaCw();

			$consulta->mostraConsulta( "Plano de Contas Cadastrados",
			"select conta.codigoacesso as \"Código\", conta.dv as \"DV\", conta.codigosintetico as \"Código Sintético\", conta.descricao as \"Descrição\" from contacontabil_cont conta, empresa_cont emp where conta.codigoempresa = emp.codigo and emp.codigocliente = '$oidEmpresa' and conta.codigoempresa = '$oidEmpresaCont' order by conta.codigosintetico, conta.codigoacesso, conta.descricao;",
										false );
			break; }

		case 4: { // Alteração de Planos...

			$conta = new Conta();
			$conta->pesquisaConta( $oidPlano );
			
			for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) {
				if ( $conta->getOidEmpresaCont() == $listaEmpresas[$indx][0] )
					$indiceEmp= $indx;
			}
			
		?>

		<body class="pagina" onLoad="carregaContasDoar();selecionaConta('<?= $indiceEmp; ?>');selecionaContaDoar('<?= $indiceEmp; ?>','<?= $conta->getOidContaDoar(); ?>' );">

		<div align="center">

		<br><br>

		<form action="cwGravaSupervisao.php"
					name="formAltPlano" method="get" onSubmit="return validaDadosAlt();">

		<input type="hidden" name="tipoOperacao" value="8">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">
		<input type="hidden" name="oidPlano" value="<?PHP echo $oidPlano; ?>">
		<input type="hidden" name="mascaraCodigo" value="<?= $listaEmpresas[0][2]; ?>">
		<input type="hidden" name="codigoSintetico" value="<?= $conta->getCodigoSintetico(); ?>">

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
					<select name="oidEmpresaCont" class="dljanela" onChange="selecionaConta( this.selectedIndex );">
					<? for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) { ?>
					   <option value="<?= $listaEmpresas[$indx][0]; ?>"
					   <? if ( $conta->getOidEmpresaCont() == $listaEmpresas[$indx][0] )
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
					<?= $conta->getCodigoSintetico(); ?>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoDescricao; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<input type="text" class="txjanela" name="descricao"
							size="40" maxlength="40" value="<?= $conta->getDescricao(); ?>">
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoNatureza; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
				   <input type="radio" name="natureza" value="D"
				   <? if ( $conta->getNatureza() == "D" ) echo " checked"; ?>><?PHP echo $campoNaturezaDevedora; ?>
				   <input type="radio" name="natureza" value="C"
				   <? if ( $conta->getNatureza() == "C" ) echo " checked"; ?>><?PHP echo $campoNaturezaCredora; ?>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoTipo; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
				   <input type="radio" name="tipo" value="S"
				   <? if ( $conta->getTipo() == "S" ) echo " checked"; ?>><?PHP echo $campoTipoSintetica; ?>
				   <input type="radio" name="tipo" value="A"
				   <? if ( $conta->getTipo() == "A" ) echo " checked"; ?>><?PHP echo $campoTipoAnalitica; ?>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoClassificacao; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
				   <input type="radio" name="classificacao" value="D"
				   <? if ( $conta->getClassificacao() == "D" ) echo " checked"; ?>><?PHP echo $campoClassificacaoDespesa; ?>
				   <input type="radio" name="classificacao" value="R"
				   <? if ( $conta->getClassificacao() == "R" ) echo " checked"; ?>><?PHP echo $campoClassificacaoReceita; ?>
				   <input type="radio" name="classificacao" value="O"
				   <? if ( $conta->getClassificacao() == "O" ) echo " checked"; ?>><?PHP echo $campoClassificacaoOutra; ?>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoPodeFicarCredora; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
				   <input type="radio" name="podeCredora" value="S"
				   <? if ( $conta->getCredora() == "S" ) echo " checked"; ?>><?PHP echo $campoPodeCredoraSim; ?>
				   <input type="radio" name="podeCredora" value="N"
				   <? if ( $conta->getCredora() == "N" ) echo " checked"; ?>><?PHP echo $campoPodeCredoraNao; ?>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoPodeFicarDevedora; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
				   <input type="radio" name="podeDevedora" value="S"
				   <? if ( $conta->getDevedora() == "S" ) echo " checked"; ?>><?PHP echo $campoPodeDevedoraSim; ?>
				   <input type="radio" name="podeDevedora" value="N"
				   <? if ( $conta->getDevedora() == "N" ) echo " checked"; ?>><?PHP echo $campoPodeDevedoraNao; ?>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoContaDoar; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="oidContaDoar" class="dljanela">
					<option value="0"><?= $msgNenhuma; ?></option>
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
		break; }

				// Pesquisa Plano...
		case 5: {

		if ( empty( $zeramento ) )
		   $zeramento = 0;

		if ( empty( $lancamento ) )
		   $lancamento = false;
		   
?>
		<body class="pagina">

		<div align="center">

		<br>

		<form action="cwCadPlano.php"
					name="formPlano" method="get">

		<input type="hidden" name="controleNavegacao" value="6">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">
		<input type="hidden" name="mascaraCodigo" value="<?= $listaEmpresas[0][2]; ?>">
		<input type="hidden" name="zeramento" value="<?= $zeramento; ?>">
		<input type="hidden" name="lancamento" value="<?= $lancamento; ?>">

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
					<input type="submit" class="bjanela" value="<?PHP echo $botaoConsultar; ?>" name="bt_pesquisar">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
						OnClick="javascript:window.close();">
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

		case 6: {

		// Realizar pesquisa de contas da empresa consultada, listando somente as
		// sinteticas

		// Carrega lista de empresas
		$empresa = new Empresa();
		$listaEmpresas = $empresa->buscaEmpresa( $oidEmpresa, "", 2 );

		for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ )
			if ( $listaEmpresas[$indx][0] == $oidEmpresaCont )
			   $nomeEmpresa = $listaEmpresas[$indx][1];

		$conta = new Conta();
		$listaContas = $conta->buscaConta( $oidEmpresaCont, "", 2 );

	 ?>

		<body class="pagina">

		<div align="center">

		<!-- Mostra o resultado da consulta, esta sera validada com
		o Framework de relatorio -->
		<br><br><br>
		<center>
		<font face="Verdana, Arial" color="#000099" size="2">
		<b><?= $tituloPlanoSintetico; ?></b><br>
		<?= $oidEmpresaCont." - ".$nomeEmpresa; ?></font>
		</center>
		<br>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="15%" class="tjanela" align="right">
				<?= $relatorioConta; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="20%" class="tjanela" align="left">
				<?= $relatorioCodigoSintetico; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="65%" class="tjanela" align="left">
				<?= $relatorioDescricao; ?>
			</td>
			</tr>

		 <?
		   for ( $indx = 0; $indx < sizeof( $listaContas ); $indx++ ) {
		   $cor 	   = ($indx % 2 ) == 0?"lcons1":"lcons2";
		   if ( $oidEmpresaCont == $listaContas[$indx][0] ) {
		   $numero		   = $listaContas[$indx][1];
		   $descricaoConta = trim( $listaContas[$indx][2] )." - ".trim( $listaContas[$indx][3] );
		   if ( $zeramento == 0 )
				$link = "javascript:setaValor('". $numero."', '".$descricaoConta."');";
		   else
				$link = "javascript:setaValorZeramento('". $numero."', '".$descricaoConta."', ".$zeramento." );";

		 ?>
			<tr>
			<td width="15%" align="right" class="<?= $cor; ?>">
			   <a href="<?= $link; ?>"> 
			   <?= $listaContas[$indx][1]; ?>
			   </a>
			</td>
			<td width="20%" align="left" class="<?= $cor; ?>">
			   <?
				 for ( $indy = 0; $indy < strlen( $listaContas[$indx][0] ); $indy++ ) {
				 echo "&nbsp;";  } ?>
			   <a href="<?= $link; ?>">
			   <?= $listaContas[$indx][2]; ?>
			   </a>
			</td>
			<td width="65%" align="left" class="<?= $cor; ?>">
			   <?
				 for ( $indy = 0; $indy < strlen( $listaContas[$indx][0] ); $indy++ ) {
				 echo "&nbsp;";  } ?>
			   <a href="<?= $link; ?>">
			   <?= $listaContas[$indx][3]; ?>
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

		// Pesquisa Plano para lancamento...
		case 7: {

		if ( empty( $zeramento ) )
		   $zeramento = 0;

?>
		<body class="pagina">

		<div align="center">

		<br>

		<form action="cwCadPlano.php"
					name="formPlano" method="get">

		<input type="hidden" name="controleNavegacao" value="8">
		<input type="hidden" name="oidEmpresa" value="<?PHP echo $oidEmpresa; ?>">
		<input type="hidden" name="mascaraCodigo" value="<?= $listaEmpresas[0][2]; ?>">
		<input type="hidden" name="zeramento" value="<?= $zeramento; ?>">

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
					<input type="submit" class="bjanela" value="<?PHP echo $botaoConsultar; ?>" name="bt_pesquisar">
					<input type="button" class="bjanela"
						value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
						OnClick="javascript:window.close();">
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

		case 8: {

		// Realizar pesquisa de contas da empresa consultada, listando somente as
		// sinteticas

		// Carrega lista de empresas
		$empresa = new Empresa();
		$listaEmpresas = $empresa->buscaEmpresa( $oidEmpresa, "", 2 );

		for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ )
			if ( $listaEmpresas[$indx][0] == $oidEmpresaCont )
			   $nomeEmpresa = $listaEmpresas[$indx][1];

		$conta = new Conta();
		$listaContas = $conta->buscaConta( $oidEmpresaCont, "", 2 );

	 ?>

		<body class="pagina">

		<div align="center">

		<!-- Mostra o resultado da consulta, esta sera validada com
		o Framework de relatorio -->
		<br><br><br>
		<center>
		<font face="Verdana, Arial" color="#000099" size="2">
		<b><?= $tituloPlanoSintetico; ?></b><br>
		<?= $oidEmpresaCont." - ".$nomeEmpresa; ?></font>
		</center>
		<br>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="15%" class="tjanela" align="left">
				<?= $relatorioConta; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="20%" class="tjanela" align="left">
				<?= $relatorioCodigoSintetico; ?>
			</td>
			<td background="../imagens/cw_janela.gif" border="0" width="65%" class="tjanela" align="left">
				<?= $relatorioDescricao; ?>
			</td>
			</tr>

		 <?
		   for ( $indx = 0; $indx < sizeof( $listaContas ); $indx++ ) {
		   $cor 	   = ($indx % 2 ) == 0?"lcons1":"lcons2";
		   if ( $oidEmpresaCont == $listaContas[$indx][0] ) {
		   $numero		   = $listaContas[$indx][1];
		   $descricaoConta = trim( $listaContas[$indx][2] )." - ".trim( $listaContas[$indx][3] );
		   if ( $zeramento == 0 ) {
			  if ( $cp == 1 ) // Contra-partida
				$link = "javascript:setaCP('". $numero."', '".$descricaoConta."');";
			  else
				$link = "javascript:setaValor('". $numero."', '".$descricaoConta."');";
		   }
		   else
				$link = "javascript:setaValorZeramento('". $numero."', '".$descricaoConta."', ".$zeramento." );";
		 ?>
			<tr>
			<td width="15%" align="left" class="<?= $cor; ?>">
			<? if ( $listaContas[$indx][4] == "A" ) { ?>
			   <a href="<?= $link; ?>">
			   <?= $listaContas[$indx][1]; ?>
			   </a>
			<? }
			else { ?>
			<? echo $listaContas[$indx][1]; } ?>
			</td>
			<td width="20%" align="left" class="<?= $cor; ?>">
			<? if ( $listaContas[$indx][4] == "A" ) { ?>
			   <?
				 for ( $indy = 0; $indy < strlen( $listaContas[$indx][0] ); $indy++ ) {
				 echo "&nbsp;";  } ?>
			   <a href="<?= $link; ?>">
			   <?= $listaContas[$indx][2]; ?>
			   </a>
			<? }
			else { ?>
			   <?
				 for ( $indy = 0; $indy < strlen( $listaContas[$indx][0] ); $indy++ ) {
				 echo "&nbsp;";  } ?>
			<? echo $listaContas[$indx][2]; } ?>
			</td>
			<td width="65%" align="left" class="<?= $cor; ?>">
			<? if ( $listaContas[$indx][4] == "A" ) { ?>
			   <?
				 for ( $indy = 0; $indy < strlen( $listaContas[$indx][0] ); $indy++ ) {
				 echo "&nbsp;";  } ?>
			   <a href="<?= $link; ?>">
			   <?= $listaContas[$indx][3]; ?>
			   </a>
			<? }
			else { ?>
			   <?
				 for ( $indy = 0; $indy < strlen( $listaContas[$indx][0] ); $indy++ ) {
				 echo "&nbsp;";  } ?>
			<? echo $listaContas[$indx][3]; } ?>
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

