<?PHP

	// Abre sessao...
	//@session_start( "cw" );

	// Recebe oid da Empresa
	$oidEmpresa = $oidEmpresaSession;
?>

<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 25/04/2003
	Última Atualização: 22/06/2003
	Módulo: cwRegLanc.php
	  Registro de Lançamentos
-->
<html>
<head>
<title>::FIEL Contábil::</title>


<script language="javascript">

	var colecaoConta = new Array;

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
	// testaItensLista()
	// - Testa se exist iten na lista
	//--------------------------------------------
	function testaItensLista() {

		 var flagItem = false;
		 var strLista = "";
		 var indx;

		 for ( indx = 1; indx < 20; indx++ ) {

		     if( document.forms[0].lista.options[indx].value != "" ) {
			      strLista = strLista + document.forms[0].lista.options[indx].value + "|";
			      flagItem = true;
		     }

		 }

		 document.forms[0].strLista.value = strLista;

		 return flagItem;

	}

	//--------------------------------------------
	// validaDados()
	// - Testa validade das Query
	//--------------------------------------------
	function validaDados( operacao ) {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;


		if ( operacao ) {

		  // -- Verifica itens na lista
		  if ( !testaItensLista() ) {
			mensagem += '\n - Não existem lançamentos contábeis na transação corrente...';
			retorna = false; }
		}
		else {

		  // -- Verifica oidConta
		  if ( testaNulo( document.forms[0].oidConta ) ) {
			mensagem += '\n - Conta contábil não preenchida...';
			retorna = false; }

		  // -- Verifica valor
		  if ( testaNulo( document.forms[0].valor ) ) {
			mensagem += '\n - Valor não preenchido...';
			retorna = false; }

		  // -- Verifica valor ( > 0 )
		  if ( document.forms[0].valor.value < 0 ) {
			mensagem += '\n - Valor inválido...';
			retorna = false; }

		}

		if ( !retorna ) {
			alert( mensagem );
				document.forms[0].oidConta.focus(); }

		return retorna;

	}

	//--------------------------------------------
	// validaConta()
	// - Testa validade das Query
	//--------------------------------------------
	function validaConta() {

		var indx;
		var retorna = false;

		for ( indx = 0; indx < colecaoConta.length; indx++ ) {

		    if ( document.forms[0].oidConta.value == colecaoConta[indx][0] ) {
			document.forms[0].descricaoConta.value = colecaoConta[indx][1];
			retorna = true;
			break; }
		}

		if ( !retorna ) {
			alert( 'Conta não registrada... Consulte a lista' );
				document.forms[0].oidConta.focus(); }

		return retorna;

	}

	//--------------------------------------------
	// removeLista()
	// - Remove da lista de lançamento da transacao
	//--------------------------------------------
	function removeLista() {

	    var indx, flagRemove;

	    flagRemove = true;

	    if ( document.forms[0].lista.selectedIndex == -1 )
	       flagRemove = false;

	    if ( flagRemove ) {

	       for ( indx = 1; indx < 20; indx++ ) {

		   if( document.forms[0].lista.options[indx].selected &&
		       document.forms[0].lista.options[indx].value != "" ) {
			 document.forms[0].lista.options[indx].selected = false;
			 document.forms[0].lista.options[indx].value = "";
			 document.forms[0].lista.options[indx].text = "";
		   }

	       }

	    }
	    else {
		alert( 'Lançamento contábil não selecionado... É necessário selecionar' );
			 document.forms[0].oidConta.focus(); }

	}

	//--------------------------------------------
	// removeTodosLista()
	// - Remove todos os elementos da lista de lançamento da transacao
	//--------------------------------------------
	function removeTodosLista() {

	    var indx;

	    for ( indx = 1; indx < 20; indx++ ) {
		document.forms[0].lista.options[indx].selected = false;
		document.forms[0].lista.options[indx].value = "";
		document.forms[0].lista.options[indx].text = "";
	    }

	    document.forms[0].oidConta.focus();

	}

	//--------------------------------------------
	// adicionaLista()
	// - adiciona na lista
	//--------------------------------------------
	function adicionaLista() {

		 var strLista, opcaoLista, operacao, indx, flagIncluido;

		 if ( validaDados( false ) ) {

		 if ( document.forms[0].operacao[0].checked )
		    operacao = 'C';
		 else
		    operacao = 'D';

		 strLista   = strBlank( document.forms[0].oidConta.value, 11 ) + " | " +
			       strBlank( operacao, 4 ) + " | " +
			       document.forms[0].valor.value;
		 opcaoLista = document.forms[0].oidConta.value + "_" +
			       operacao + "_" +
			       document.forms[0].valor.value;

		 // testa se ja existe...
		 flagIncluido = false;
		 for ( indx = 1; indx < 20; indx++ ) {
		     if ( document.forms[0].lista.options[indx].value == opcaoLista ) {
			flagIncluido = true;
			break;
		     }
		 }

		 if ( !flagIncluido ) {
		   for ( indx = 1; indx < 20; indx++ ) {
		     if ( document.forms[0].lista.options[indx].value == "" ) {
			document.forms[0].lista.options[indx].value = opcaoLista;
			document.forms[0].lista.options[indx].text = strLista;
			break;
		     }
		   }
		 }
		 else {
		     alert( 'Lançamento já registrado na transação corrente...' );
				document.forms[0].oidConta.focus(); }
		 }
	}

	//--------------------------------------------
	// carregaColecao()
	// - Carrega colecao
	//--------------------------------------------
	function carregaColecao() {

		 var indx, indy, numero;

		 for ( indx = 0; indx < 5; indx++ ) {
		     numero = indx + 1;
		     colecaoConta[indx] = new Array;
		     colecaoConta[indx][0] = numero + '.' + indx;
		     colecaoConta[indx][1] = 'Conta ' + numero;
		 }

	}

	//--------------------------------------------
	// strBlank()
	// - adiciona brancos
	//--------------------------------------------
	function strBlank( strVariavel, tamanho ) {

		 var indx = 1, tamVar;
		 strVariavel = strVariavel;
		 tamVar      = strVariavel.length;

		 while ( indx <= ( tamanho - tamVar ) ) {
		       strVariavel += "  ";
		       indx++; }

	    return strVariavel;
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

		  $cabec = new TituloCw( "Registro de Lançamentos Contábeis" );
		  $cabec->mostra();

?>
<body class="pagina" onLoad="carregaColecao();document.formRegLanc.oidConta.focus();">

	<div align="center">

	<br><br>

	<form action="cwRegLanc.php"
				name="formRegLanc" method="get" onSubmit="return validaDados( true );">

	<!-- mudar aqui tb... -->
	<input type="hidden" name="controleNavegacao" value="2">
	<input type="hidden" name="strLista" value="">


		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td width="85%" class="tjanela">
				<?PHP echo "Registro de Lançamentos"; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_ajuda"
					value="<?= $botaoAjudaJanela; ?>" onClick="javascript:abreAjuda('../cw_ajuda.html#sac_edcons')">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>

		<!-- Opções do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo "Fórmula Contábil:"; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="radio" name="formula" value="1" checked><?PHP echo "1a. Fórmula (1D/1C)"; ?>
				   <input type="radio" name="formula" value="2"><?PHP echo "2a. Fórmula (1D/nC)"; ?>
				   <input type="radio" name="formula" value="3"><?PHP echo "3a. Fórmula (nD/1C)"; ?>
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo "Conta Contábil:"; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="text" class="txjanela" name="oidConta"
						size="15" maxlength="15" onChange="return validaConta();document.formRegLanc.valor.focus();">
				<input type="button" class="bjanela" name= "bt_consultarConta"
					value="<?= $botaoConsultar; ?>" onClick="javascript:alert('Mostra consulta de contas');">

				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo "Descrição:"; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="text" class="txinvis" name="descricaoConta"
						size="40" maxlength="40" onFocus="this.blur();document.formRegLanc.valor.focus();">
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo "Operação:"; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="radio" name="operacao" value="C" checked><?PHP echo "Crédito"; ?>
				   <input type="radio" name="operacao" value="D"><?PHP echo "Débito"; ?>
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  <?PHP echo "Valor:"; ?>
				</td>

				<td align="left" width="80%" class="cjanela">
				   <input type="text" class="txjanela" name="valor"
						size="15" maxlength="15">
				</td>
			</tr>

			<tr>
				<td width="20%" align="right">&nbsp;
				</td>
				<td width="80%" align="left">
					<input type="button" class="bjanela" value="<?PHP echo 'Adicionar'; ?>" name="bt_adicionar"
					       onClick="adicionaLista();">
					<input type="button" class="bjanela"
					value="<?PHP echo 'Remover'; ?>" name="bt_remover"
					onClick="removeLista();">
					<input type="button" class="bjanela"
					value="<?PHP echo 'Remover Todos Lançamentos'; ?>" name="bt_removerTodos"
					onClick="removeTodosLista();">
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  &nbsp;
				</td>

				<td width="80%" align="left" class="cjanela">
				  <?PHP echo "Lista de Operações:"; ?>
				</td>
			</tr>

			<tr>
				<td width="20%" align="right" class="cjanela">
				  &nbsp;
				</td>

				<td width="80%" align="left" class="cjanela">
					<select multiple name="lista" size="5" class="dljanela">
					   <option value="0"><?= "----[Conta]----|--[Op]--|----[Valor R$]----"; ?></option>
					   <? for ( $indx = 1; $indx < 20; $indx++ ) { ?>
					      <option value=""></option>
					   <? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="20%" align="right">&nbsp;
				</td>
				<td width="80%" align="left">
					<input type="submit" class="bjanela" value="<?PHP echo "Gravar"; ?>" name="bt_incluir">
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
	 case 2: {


	      echo "<h1>Lançamentos realizados:</h1>";

	      $lista = explode( "|", $strLista );
	      $tamanhoLista = sizeof( $lista ) - 1;

	     echo "<br><b>&nbsp;->>&nbsp;&nbsp;NumTrans&nbsp;&nbsp;&nbsp;Cod Conta&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Op&nbsp;&nbsp;&nbsp;Valor R$</b>";
	     for ( $indx  = 0; $indx < $tamanhoLista; $indx++ ) {
		  $transacao = explode( "_", $lista[$indx] );
		  $numero = $indx + 1;
		  echo "<br>&nbsp;->>&nbsp;".$numero."&nbsp;&nbsp;&nbsp;".$transacao[0]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$transacao[1]."&nbsp;&nbsp;&nbsp;".$transacao[2];
	      }

	      echo "<br><br>";
	      echo "<a href='javascript:history.back();'>Voltar</a>";

	      break;
	 }

   }
?>
</html>
