<?PHP

	// Abre sessao...
	@session_start( "cw" );

	// Recebe oid da Empresa
	$oidEmpresa    = $oidEmpresaSession;
	$perfilUsuario = $perfilUsuarioSession;
	$loginUsuario  = $loginUsuarioSession;

	// Inclui pacote da aplicacao...
	include "../classes/cw.inc";

	// Carrega lista de empresas
	$empresa = new Empresa();
	$listaEmpresas	 = $empresa->buscaEmpresa( $oidEmpresa, "", 4, $loginUsuario );

	//  Empresa, Conta, Descricao
	$conta = new Conta();
	$listaContas = $conta->buscaConta( 0, "", 4 );

?>

<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 19/01/2004
	Última Atualização: 19/01/2004
	Módulo: cwGrafComparativo.php
	  Consulta Grafico Comparativo de Previsto x Executado
-->
<html>
<head>
<title>::FIEL Contábil::</title>

<script language="javascript">

	var listaContas   = new Array();
	var contador	  = -1;
	var itemsIndex;

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
	// abreAjuda()
	// - Abre a ajuda
	//--------------------------------------------
	function abreAjuda( arquivo ) {

		var janela;
		window.open(arquivo, 'janela',
			'toolbar=no,location=no,directories=no,menubar=no,width=500,height=300');

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
	// testaNulo()
	// - Testa se campo é nulo
	//--------------------------------------------
	function testaNulo( nome_campo ) {

		return ( nome_campo.value.length == 0 )?true:false;

	}

	//--------------------------------------------
	// newEmpresaConta()
	// - Seta nova empresa
	//--------------------------------------------
	function newEmpresaConta() {

		 contador++;
		 listaContas[contador] = new Array();
		 itemsIndex = 0;

	}

	//--------------------------------------------
	// newConta()
	// - Seta nova conta
	//--------------------------------------------
	function newConta( contaTmp, codigoAcessoTmp, descricaoTmp, empresaTmp ) {

		 listaContas[contador][itemsIndex]= new setaConta( contaTmp, codigoAcessoTmp, descricaoTmp, empresaTmp );
		 itemsIndex++;
	}

	//--------------------------------------------
	// setaConta()
	// - Seta nova conta
	//--------------------------------------------
	function setaConta( contaTmp, codigoAcessoTmp, descricaoTmp, empresaTmp ){

		 this.text	   = contaTmp + " - " + descricaoTmp;
		 this.value	   = codigoAcessoTmp;
		 this.codEmpresa   = empresaTmp;
		 this.codigoAcesso = contaTmp;

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
	// carregaColecao()
	// - Carrega colecao
	//--------------------------------------------
	function carregaColecao() {
		<?
		for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) {
		echo "\n	    // ".$listaEmpresas[$indx][1]."\n	    newEmpresaConta();\n";
		     // Laco de contas...
		     for ( $indy = 0; $indy < sizeof( $listaContas ); $indy++ ) {
			 if ( $listaContas[$indy][0] == $listaEmpresas[$indx][0] ) {
			    echo "	    newConta( '".$listaContas[$indy][2]."', '".$listaContas[$indy][1]."', '".$listaContas[$indy][3]."', '".$listaContas[$indy][0]."' );\n";
			 }
		     }
		}
		echo "\n	  selecionaConta( '0' );\n\n";
		?>
	}

	//--------------------------------------------
	// selecionaConta()
	// - Seleciona conta de determinada empresa
	//--------------------------------------------
	function selecionaConta( codigoEmpresa ) {

	    var posArray = 0, indx, indy;
	    document.forms[0].codigoSintetico.options.length = 0;

	    codigoEmpresa = document.forms[0].oidEmpresaCont[codigoEmpresa].value;
	    for ( indx = 0; indx < listaContas.length; indx++ ) {

		for ( indy = 0; indy < listaContas[indx].length; indy++ ) {
		   if ( listaContas[indx][indy].codEmpresa == codigoEmpresa ) {
		      posArray = indx;
		      break; }
		}
	    }

	    for ( indx = 0; indx < listaContas[posArray].length; indx++ ) {

		document.forms[0].codigoSintetico.options[indx] =
			 new Option( listaContas[posArray][indx].text,
			     listaContas[posArray][indx].value );
	    }

	    document.forms[0].codigoSintetico.options[0].selected = true;

	}

	//--------------------------------------------
	// validaDados()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaDados( controle ) {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

			// -- Ano
			if ( testaNulo( document.forms[0].ano ) ) {
				mensagem += '\n - Ano não preenchido';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem );
				document.forms[0].ano.focus(); }

		return retorna;

	}

</SCRIPT>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="../estilo/cw.css">

</head>

<?PHP

	echo "\n<!-- numero da pagina: $numeroPagina -->\n";

	if ( empty( $controleNavegacao ) )
		$controleNavegacao = 0;

	 switch( $controleNavegacao ) {

	 default: {

		  $cabec = new TituloCw( "Gráfico Comparativo de Execução Orçamentária" );
		  $cabec->mostra();
?>
<body class="pagina" onLoad="carregaColecao();this.document.formGrafComparativo.ano.focus();">

	<div align="center">

	<br><br>

	<form action="cwGrafComparativo.php"
				name="formGrafComparativo" method="post" onSubmit="return validaDados();">

	<input type="hidden" name="controleNavegacao" value="1">
	<input type="hidden" name="login" value="<?= $loginUsuario; ?>">


		<table class="ejanela" width="80%">
		<tr class="ejanela">
		<td>

		<!-- Janela -->
		<table border="0" width="100%">
			<tr>
			<td background="../imagens/cw_janela.gif" border="0" width="85%" class="tjanela">
				<?PHP echo "Gráfico Comparativo de Execução Orçamentaria"; ?>
			</td>
			<td width="15%" align="center" class="tjanela">
				<input type="button" class="btitulo" name= "bt_fechar"
					value="<?= $botaoFechaJanela; ?>" onClick="javascript:history.go(-1);">
			</td>
			</tr>
		</table>

		<!-- Opções do Menu -->
		<table class="cjanela" border="0" width="100%">

			<tr>
				<td width="30%" align="right" class="cjanela"><?PHP echo $campoAno; ?>
				</td>
				<td align="left" width="70%" class="cjanela">
				   <input type="text" class="txjanela" name="ano"
						size="4" maxlength="4">

				</td>
			</tr>


			<tr>
				<td width="30%" align="right" class="cjanela">
								  <?PHP echo $campoEmpresa; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="oidEmpresaCont" class="dljanela" onChange="selecionaConta( this.selectedIndex );">
					<? for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) { ?>
					   <option value="<?= $listaEmpresas[$indx][0]; ?>"><?= $listaEmpresas[$indx][1]; ?></option>
					<? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%" align="right" class="cjanela">
				  <?PHP echo $campoCodigoSintetico; ?>
				</td>

				<td width="70%" align="left" class="cjanela">
					<select name="codigoSintetico" class="dljanela">
					   <option value="0"><?= $msgNenhuma; ?></option>
					</select>
				</td>
			</tr>


			<tr>
				<td width="30%" align="right" class="cjanela">&nbsp;
				</td>
				<td align="left" width="70%" class="cjanela">
				   <input type="checkbox" class="cbjanela" name="exibeNaoLiberado"
						value="1"><?= $msgExibeIncluirNaoLiberados; ?>
				</td>
			</tr>


			<tr>
				<td width="30%" align="right">&nbsp;
				</td>
				<td width="70%" align="left">
					<input type="submit" class="bjanela" value="<?PHP echo $botaoConsultar; ?>" name="bt_consultar">
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

		 // Cria um objeto do tipo conta
		 $conta = new Conta();
		 $conta->pesquisaConta( $codigoSintetico, $oidEmpresaCont );

		 // Agora, tem que buscar os 12 valores previstos no orcamento
		 $previsto  = array(0,0,0,0,0,0,0,0,0,0,0,0);
		 $orcamento = new Orcamento();
		 $temOrcamento = $orcamento->pesquisaOrcamento( $conta->oidConta, $ano);
		 if ($temOrcamento)
		 for ($indx=0; $indx<12; $indx++)
			$previsto[$indx] = $orcamento->previsto[$indx];

		// Agora, tem que buscar os 12 valores realizados no orcamento (fazer um metodo)
		$realizado = array(0,0,0,0,0,0,0,0,0,0,0,0);
		$arrayDias = array( 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 );

		if ( $ano % 4 == 0 )
			$arrayDias[1] = 29;

		if ($exibeNaoLiberado)
			$contabilizado = "N";
		else
			$contabilizado = "S";

		$lancamento = new Lancamento();

		for ($indx=0;$indx<12; $indx++) {
			if ( ($indx+1) < 10)
				$mes = "0". ($indx+1);
			else
				$mes = $indx+1;

			$dataInicial = "01/" . $mes . "/". $ano;
			$dataFinal   = $arrayDias[$indx] . "/" . $mes . "/". $ano;

			$totalDebito  = $lancamento->buscaMovimentoConta( $conta->oidConta, $dataInicial, $dataFinal, $contabilizado, "D" );
			$totalCredito = $lancamento->buscaMovimentoConta( $conta->oidConta, $dataInicial, $dataFinal, $contabilizado, "C" );

			$movimentoMensal  = $totalDebito - $totalCredito;

			if ($conta->natureza == "C")
				$movimentoMensal = $movimentoMensal * -1;

			$realizado[$indx] = $movimentoMensal;
		}

		// Vamos montar a escala do grafico.
		//Precisamos saber o maior valor dos dois vetores
		$maiorValor = -1;
		$menorValor = 0;

		for ($indx = 0;$indx < 12; $indx++) {
			if ($previsto[$indx] > $maiorValor)
				$maiorValor = $previsto[$indx];
			if ($realizado[$indx] > $maiorValor)
				$maiorValor = $realizado[$indx];
			if ($realizado[$indx] < $menorValor)
				$menorValor = $realizado[$indx];
		}

		// Para nao ficar muito feio, vamos incrementar em 20% o valor do maiorValor
		$maiorValor = $maiorValor * 1.2;

		// Definindo biblioteca e tipo de grafico...
		include ("../classes/grafico/jpgraph.php");
		include ("../classes/grafico/jpgraph_bar.php");

		$eixox	= array("Jan","Fev","Mar","Abr","Mai","Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
		$datazero = array(0,0,0,0,0,0,0,0,0,0,0,0);


		 $graph = new Graph(500,290,"auto");
		 $graph->img->SetMargin(60,30,20,60);
		 $graph->img->SetImgFormat("jpeg");    // PNG ficou bem melhor...
		 $graph->SetScale("textlin",$menorValor,$maiorValor);
		 $graph->SetY2Scale( "lin",$menorValor,$maiorValor);
		 $graph->SetMarginColor("#FFFFFF");
		 $graph->SetShadow();

		 // Seta o rodape do grafico
		 $graph->footer->right->Set("Fonte: FIEL Contábil");

		 // Seta a cor de background (gradiente)
		 $graph->SetBackgroundGradient("#F3B561","#FFFFFF",GRAD_HOR,BGRAD_PLOT);

		 $graph->title->Set("Execução Orçamentária - " . $ano );
		 $graph->title->SetFont(FF_VERDANA,FS_BOLD,12);
		 $graph->title->SetColor("darkred");
		 $graph->subtitle->Set($conta->descricao);
		 $graph->subtitle->SetFont(FF_VERDANA,FS_NORMAL,10);
		 $graph->subtitle->SetColor("darkred");

		 $graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,8);
		 $graph->yaxis->SetFont(FF_VERDANA,FS_NORMAL,8);

		 $graph->yscale->ticks->SupressZeroLabel(false);

		 // Retira o label para o segundo eixo Y
		 $graph->y2axis->Hide( true );

		 // Setup X-axis labels
		 $graph->xaxis->SetTickLabels($eixox);
		 $graph->xaxis->SetLabelAngle(0);

		 $bplotzero = new BarPlot( $datazero );

		 $ybplot1 = new BarPlot($previsto);
		 $ybplot1->SetWidth(0.6);
		 $ybplot1->SetFillGradient("navy","#99FFFF",GRAD_LEFT_REFLECTION);

		 $ybplot1->SetColor("white");
		 $ybplot1->SetLegend("Previsto");
		 $ybplot = new GroupBarPlot(array($ybplot1, $bplotzero) );

		 $ybplot2 = new BarPlot($realizado);
		 $ybplot2->SetWidth(0.6);

		 $ybplot2->SetFillGradient("navy","#FF9999",GRAD_LEFT_REFLECTION);

		 $ybplot2->SetColor("white");
		 $ybplot2->SetLegend("Realizado");
		 $y2bplot = new GroupBarPlot(array($bplotzero, $ybplot2) );

		 $graph->legend->SetLayout(LEGEND_HOR);
		 $graph->legend->Pos(0.32,0.87,'left','top');
		 $graph->legend->SetShadow( false );
		 $graph->legend->setLineWeight(1);
		 $graph->legend->SetLineSpacing(5);

		 $graph->Add($ybplot);
		 $graph->AddY2($y2bplot);

		 // Finalmente, apaga os PNG antigos e grava o arquivo PNG do grafico gerado
		 $tempo = substr( microtime(), 12, 10 );
		 @unlink( "../pdfs/" . $login . "_grafcomp_*" );
		 $nomeArq = "../pdfs/" . $login . "_grafcomp_" . $tempo . ".jpg";
		 $graph->Stroke( $nomeArq );

		 // Apresentacao dos dados no browser
?>
<body class="pagina">

	<div align="center">
<?
	$cabec = new TituloCw("Gráfico Comparativo de Execução Orçamentária");
	$cabec->mostra();

	echo "<br><img src=\"". $nomeArq . "\">";

?>
	<br><br>
	<form name="final" method="get">
		<input type="button" name="btImprimir" class="bjanela" value="<?= $botaoImprimir; ?>" onClick="javascript:window.print();">
		<input type="button" name="btVoltar" class="bjanela" value="<?= $botaoVoltar; ?>" onClick="javascript:history.back();">
	</form>
<br><br>

	</div>
</body>
	<?
	 break;
	 }
  }

?>
</html>
