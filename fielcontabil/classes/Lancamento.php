<?PHP

/**
*		FIEL Contábil
*
*		Data de Criacao: 26/05/2003
*		Ultima Atualizacao: 04/05/2005
*		Modulo: Lancamento.php
*
*		Desenvolvido por APOENA Solucoes em Software Livre
*		suporte@apoenasoftwarelivre.com.br
*		http://www.apoenasoftwarelivre.com.br
*
*		@author 		Claudimir Zavalik (claudimir@apoenasoftwarelivre.com.br)
*		@author 		Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*		@version		PHP3 & PHP4
*/

// Arquivo "header" do Contábil
// include $pathClasses."cw.inc";

/**
*
*		Lancamento
*
*		Classe que contem as principais definicoes de lancamentos (com itens)
*		da contabilidade no Contabil Web
*
*/
class Lancamento {

	var $oidLancamento; // OID do lancamento
	var $oidEmpresaCont; // OID da empresa contabil
	var $dataLancamento; // Data de lancamento
	var $dataDigitacao; // Data de digitacao
	var $horaDigitacao; // Hora de digitacao
	var $loginOperador; // Login operador
	var $dataLiberacao; // Data de liberacao
	var $horaLiberacao; // Hora de liberacao
	var $loginSupervisor; // Login do supervisor
	var $aberto; // Aberto
	var $contabilizado; // Contabilizado
	var $totalDebito; // Total de debito
	var $totalCredito; // Total de credito
	var $persistence; // Utilizado para persistencia dos objetos

	/**
	*  Lancamento()
	*  Construtor da classe
	*/
	function Lancamento() {

		$this->persistence = new LancamentoProxy();

	}

	/**
	*		setLancamento( $oidEmpresaCont, $dataLancamento, $dataDigitacao, 
	*				$horaDigitacao, $loginOperador, $contabilizado )
	*		Recebe os dados para manipulacao
	*		@param $oidEmpresaCont	   OID da empresa contabil
	*		@param $dataLancamento	   Data de lancamento
	*		@param $dataDigitacao	   Data de digitacao
	*		@param $horaDigitacao	   Hora de digitacao
	*		@param $loginOperador	   Login do operador
	*		@param $contabilizado	   Contabilizado
	*/
	function setLancamento($oidEmpresaCont, $dataLancamento, $dataDigitacao, $horaDigitacao, $loginOperador, $contabilizado) {

		$this->setOidEmpresaCont($oidEmpresaCont);
		$this->setDataLancamento($dataLancamento);
		$this->setDataDigitacao($dataDigitacao);
		$this->setHoraDigitacao($horaDigitacao);
		$this->setLoginOperador($loginOperador);
		$this->setContabilizado($contabilizado);

	}

	/**
	*		setLiberaLancamento( $oidLancamento, $dataLiberacao, $horaLiberacao, 
	*				$loginSupervisor, $contabilizado )
	*		Recebe os dados para manipulacao
	*		@param $oidEmpresaCont	   OID da empresa contabil
	*		@param $dataLiberacao	   Data de liberacao
	*		@param $horaLiberacao	   Hora de liberacao
	*		@param $loginSupervisor    Login de supervisor
	*		@param $contabilizado	   Contabilizado
	*/
	function setLiberaLancamento($oidLancamento, $dataLiberacao, $horaLiberacao, $loginSupervisor, $contabilizado) {

		$this->setOidLancamento($oidLancamento);
		$this->setDataLiberacao($dataLiberacao);
		$this->setHoraLiberacao($horaLiberacao);
		$this->setLoginSupervisor($loginSupervisor);
		$this->setContabilizado($contabilizado);

	}

	/**
	*		setOidLancamento( $oidLancamento )
	*		Recebe OID de Lancamento
	*		@param $oidLancamento	OID de lancamento
	*/
	function setOidLancamento($oidLancamento) {

		$this->oidLancamento = $oidLancamento;

	}

	/**
	*		getOidLancamento()
	*		Retorna OID de lancamento
	*		@return $oidLancamento OID de lancamento
	*/
	function getOidLancamento() {

		return $this->oidLancamento;

	}

	/**
	*		setOidEmpresaCont( $oidEmpresaCont )
	*		Recebe OID de empresa
	*		@param $oidEmpresaCont	 OID da empresa
	*/
	function setOidEmpresaCont($oidEmpresaCont) {

		$this->oidEmpresaCont = $oidEmpresaCont;

	}

	/**
	*		getOidEmpresaCont()
	*		Retorna OID de empresa
	*		@return $oidEmpresaCont    OID da empresa
	*/
	function getOidEmpresaCont() {

		return $this->oidEmpresaCont;

	}

	/**
	*		setDataLancamento( $dataLancamento )
	*		Recebe data de lancamento
	*		@param $dataLancamento	data de lancamento
	*/
	function setDataLancamento($dataLancamento) {

		$this->dataLancamento = trim($dataLancamento);

	}

	/**
	*		getDataLancamento()
	*		Retorna data de lancamento
	*		@return $dataLancamento 		data de lancamento
	*/
	function getDataLancamento() {

		return $this->dataLancamento;

	}

	/**
	*		setDataDigitacao( $dataDigitacao )
	*		Recebe data de digitacao
	*		@param $dataDigitacao	data de digitacao
	*/
	function setDataDigitacao($dataDigitacao) {

		$this->dataDigitacao = trim($dataDigitacao);

	}

	/**
	*		getDataDigitacao()
	*		Retorna data de digitacao
	*		@return $dataDigitacao	data de digitacao
	*/
	function getDataDigitacao() {

		return $this->dataDigitacao;

	}

	/**
	*		setHoraDigitacao( $horaDigitacao )
	*		Recebe hora de digitacao
	*		@param $horaDigitacao	hora de digitacao
	*/
	function setHoraDigitacao($horaDigitacao) {

		$this->horaDigitacao = trim($horaDigitacao);

	}

	/**
	*		getHoraDigitacao()
	*		Retorna hora de digitacao
	*		@return $horaDigitacao	hora de digitacao
	*/
	function getHoraDigitacao() {

		return $this->horaDigitacao;

	}

	/**
	*		setLoginOperador( $loginOperador )
	*		Recebe login de operador
	*		@param $loginOperador			login de operador
	*/
	function setLoginOperador($loginOperador) {

		$this->loginOperador = $loginOperador;

	}

	/**
	*		getLoginOperador()
	*		Retorna login de operador
	*		@return $loginOperador	login de operador
	*/
	function getLoginOperador() {

		return $this->loginOperador;

	}

	/**
	*		setDataLiberacao( $dataLiberacao )
	*		Recebe data de liberacao
	*		@param $dataLiberacao	data de liberacao
	*/
	function setDataLiberacao($dataLiberacao) {

		$this->dataLiberacao = trim($dataLiberacao);

	}

	/**
	*		getDataLiberacao()
	*		Retorna data de liberacao
	*		@return $dataLiberacao	data de liberacao
	*/
	function getDataLiberacao() {

		return $this->dataLiberacao;

	}

	/**
	*		setHoraLiberacao( $horaLiberacao )
	*		Recebe hora de liberacao
	*		@param $horaLiberacao	hora de liberacao
	*/
	function setHoraLiberacao($horaLiberacao) {

		$this->horaLiberacao = trim($horaLiberacao);

	}

	/**
	*		getHoraLiberacao()
	*		Retorna hora de liberacao
	*		@return $horaLiberacao	hora de liberacao
	*/
	function getHoraLiberacao() {

		return $this->horaLiberacao;

	}

	/**
	*		setLoginSupervisor( $loginSupervisor )
	*		Recebe login de supervisor
	*		@param $loginSupervisor 		login de supervisor
	*/
	function setLoginSupervisor($loginSupervisor) {

		$this->loginSupervisor = $loginSupervisor;

	}

	/**
	*		getLoginSupervisor()
	*		Retorna login de supervisor
	*		@return $loginSupervisor		login de supervisor
	*/
	function getLoginSupervisor() {

		return $this->loginSupervisor;

	}

	/**
	*		setAberto( $aberto )
	*		Recebe se lancamento esta aberto
	*		@param $aberto			aberto
	*/
	function setAberto($aberto) {

		$this->aberto = $aberto;

	}

	/**
	*		getAberto()
	*		Retorna flag de status de lancamento
	*		@return $aberto 		aberto
	*/
	function getAberto() {

		return $this->aberto;

	}

	/**
	*		setContabilizado( $contabilizado )
	*		Recebe flag de contabilizado
	*		@param $contabilizado			contabilizado
	*/
	function setContabilizado($contabilizado) {

		$this->contabilizado = $contabilizado;

	}

	/**
	*		getContabilizado()
	*		Retorna flag de lancamento contabilizado
	*		@return $contabilizado	contabilizado
	*/
	function getContabilizado() {

		return $this->contabilizado;

	}

	/**
	*		setTotalDebito( $totalDebito )
	*		Recebe total de debitos
	*		@param $totalDebito		Total de debitos
	*/
	function setTotalDebito($totalDebito = 0) {

		$this->totalDebito = $totalDebito;

	}

	/**
	*		getTotalDebito()
	*		Retorna total de debitos
	*		@return $totalDebito	Total de debitos
	*/
	function getTotalDebito() {

		return $this->totalDebito;

	}

	/**
	*		setTotalCredito( $totalCredito )
	*		Recebe total de creditos
	*		@param $totalCredito			Total de creditos
	*/
	function setTotalCredito($totalCredito = 0) {

		$this->totalCredito = $totalCredito;

	}

	/**
	*		getTotalCredito()
	*		Retorna total de creditos
	*		@return $totalCredito	 Total de creditos
	*/
	function getTotalCredito() {

		return $this->totalCredito;

	}

	/**
	*		grava( $operacao = true )
	*		Grava objeto
	*		@param $operacao		Operacao a ser realizada (true = inclusao | false = alteracao)
	*		@return se conseguiu gravar
	*/
	function grava($operacao = true) {

		// Seta variaveis utilizada no metodo...
		$flagGravou = false;

		// Seta dados...
		if ($operacao)
			$this->persistence->setObject($this->getOidEmpresaCont(), $this->getDataLancamento(), $this->getDataDigitacao(), $this->getHoraDigitacao(), $this->getLoginOperador(), $this->getContabilizado());

		// Realiza operacao...
		if ($operacao)
			$flagGravou = $this->persistence->save();
		else
			$flagGravou = $this->persistence->update($this->getOidLancamento());

		return $flagGravou;

	}

	/**
	*		gravaLiberacao()
	*		Grava objeto
	*		@return se conseguiu gravar
	*/
	function gravaLiberacao() {

		// Seta variaveis utilizada no metodo...
		$flagGravou = false;

		$this->persistence->setLiberaObject($this->getOidLancamento(), $this->getDataLiberacao(), $this->getHoraLiberacao(), $this->getLoginSupervisor(), $this->getContabilizado());

		$flagGravou = $this->persistence->updateLiberacao($this->getOidLancamento());

		return $flagGravou;

	}

	/**
	*		pesquisaLancamento( $oidLancamento )
	*		Retorna lancamento encontrado
	*		@return true se encontrou lancamento por OID
	*/
	function pesquisaLancamento($oidLancamento) {

		// Seta variaveis utilizada no metodo
		$flagAchou = false;

		if ($this->persistence->findByOid($oidLancamento)) {
			$flagAchou = true;

			// Retorna objeto
			$objetoAtual = $this->persistence->getObject();

			// Seta atributos
			$this->setOidLancamento($objetoAtual[0]);
			$this->setOidEmpresaCont($objetoAtual[1]);
			$this->setDataLancamento($objetoAtual[2]);
			$this->setDataDigitacao($objetoAtual[3]);
			$this->setHoraDigitacao($objetoAtual[4]);
			$this->setLoginOperador($objetoAtual[5]);
			$this->setDataLiberacao($objetoAtual[6]);
			$this->setHoraLiberacao($objetoAtual[7]);
			$this->setLoginSupervisor($objetoAtual[8]);
			$this->setAberto($objetoAtual[9]);
			$this->setContabilizado($objetoAtual[10]);

		}

		// Retorna se encontrou lancamento...
		return $flagAchou;

	}

	/**
	*		buscaOidLancamento( $dataLancamento, $loginOperador, $oidEmpresaCont )
	*		Retorna todos os lancamentos, por data, operador e OID da empresa
	*		@param	$dataLancamento Data de lancamento
	*		@param	$loginOperador	Login do operador
	*		@param	$oidEmpresaCont OID da empresa contabil
	*		@return $oidLancamento	OID de lancamento
	*/
	function buscaOidLancamento($dataLancamento, $loginOperador, $oidEmpresaCont) {

		// Seta variaveis utilizada no metodo
		$flagAchou = false;

		if ($this->persistence->findByDataLoginEmpresa($dataLancamento, $loginOperador, $oidEmpresaCont)) {
			$flagAchou = true;

			// Retorna objeto
			$objetoAtual = $this->persistence->getObject();

			// Seta atributos
			$this->setOidLancamento($objetoAtual[0]);

		}

		// Retorna se encontrou lancamento...
		return $flagAchou;

	}

	/**
	*		exclui()
	*		Exclui lancamento
	*/
	function exclui() {

		// Exclui lancamento...
		return $this->persistence->delete($this->getOidLancamento());

	}

	/**
	*		buscaTotaisDC( $dataLancamento, $loginOperador, $oidEmpresaCont )
	*		Retorna totais de debito e credito dos lancamentos, por data,
	*				operador e OID da empresa
	*		@param	$dataLancamento Data de lancamento
	*		@param	$loginOperador	Login do operador
	*		@param	$oidEmpresaCont OID da empresa contabil
	*/
	function buscaTotaisDC($dataLancamento, $loginOperador, $oidEmpresaCont) {

		// Seta variaveis utilizada no metodo
		$itemLancamento = new ItemLancamento();

		// Busca totais dos lancamentos...
		if ($this->buscaOidLancamento($dataLancamento, $loginOperador, $oidEmpresaCont)) {
			$totais = $itemLancamento->buscaTotaisDC($this->getOidLancamento());
		}

		if (empty ($totais[0]))
			$totais[0] = 0;

		if (empty ($totais[1]))
			$totais[1] = 0;

		// Retorna objeto
		$this->setTotalDebito($totais[0]);
		$this->setTotalCredito($totais[1]);

	}

	/**
	*		incluiItemLancamento( $oidLancamento, $oidConta, $historico,
	*				$valor, $operacao, $oidZeramento )
	*		Recebe os dados para manipulacao
	*		@param	$oidLancamento		OID de lancamento
	*		@param	$oidConta		   OID da conta contabil
	*		@param	$historico			Historico
	*		@param	$valor				Valor
	*		@param	$operacao			Operacao (D/C)
	*		@param	$oidZeramento		OID Zeramento
	*		@param	$nomeImagem			Nome da Imagem que foi anexada
	*		@return true se conseguiu incluir item de lancamento
	*/
	function incluiItemLancamento($oidLancamento, $oidConta, $historico, $valor, $operacao, $oidZeramento, $codigoCentroCusto, $nomeImagem) {

		$flagIncluiu = false;
		$itemLancamento = new ItemLancamento();

		$itemLancamento->setItemLancamento($oidLancamento, $oidConta, $historico, $valor, $operacao, $oidZeramento, $codigoCentroCusto, $nomeImagem);

		if ($itemLancamento->grava()) {
			$flagIncluiu = true;
		}

		return $flagIncluiu;
	}

	/**
	*		alteraItemLancamento( $oidItemLancamento, $oidLancamento, $oidConta, $historico,
	*				$valor, $operacao, $oidZeramento, $oidCentroCusto )
	*		Recebe os dados para manipulacao
	*		@param	$oidItemLancamento	OID de item de lancamento
	*		@param	$oidLancamento		OID de lancamento
	*		@param	$oidConta		OID da conta contabil
	*		@param	$historico		Historico
	*		@param	$valor			Valor
	*		@param	$operacao		Operacao (D/C)
	*		@param	$oidZeramento		OID Zeramento
	*		@param	$oidCentroCusto 	OID Centro de Custo
	*		@return true se conseguiu incluir item de lancamento
	*/
	function alteraItemLancamento($oidItemLancamento, $oidLancamento, $oidConta, $historico, $valor, $operacao, $oidZeramento, $oidCentroCusto) {

		$itemLancamento = new ItemLancamento();
		$itemLancamento->setOidItemLancamento($oidItemLancamento);
		$itemLancamento->setItemLancamento($oidLancamento, $oidConta, $historico, $valor, $operacao, $oidZeramento, $oidCentroCusto);

		return $itemLancamento->grava(false);

	}

	/**
	*		buscaLancamentosPeriodo( $dataInicial, $dataFinal, $oidEmpresaCont, $loginUsuario,
	*										$exibeNaoLiberado = 0, $contabilizado )
	*		Retorna todos os codigos de lancamentos, por periodo e OID da empresa
	*		@param	$dataInicial	  Data de inicial
	*		@param	$dataFinal		  Data de final
	*		@param	$oidEmpresaCont   OID da empresa contabil
	*		@param	$loginUsuario	  Login usuario
	*		@param	$exibeNaoLiberado Exibe os lancamentos nao liberados tb (se true)
	*		@param	$contabilizado	  Contabilizado (default = N)
	*		@return $lancamentos	  Retorna OIDs de lancamentos pelo filtro
	*/
	function buscaLancamentosPeriodo($dataInicial, $dataFinal, $oidEmpresaCont, $loginUsuario = 0, $exibeNaoLiberado = 0, $contabilizado = "N") {

		$this->persistence->searchLancamentosPeriodo($dataInicial, $dataFinal, $oidEmpresaCont, $loginUsuario, $exibeNaoLiberado, $contabilizado);

		return $this->persistence->getList();

	}

	/**
	*		buscaSaldoConta( $oidConta, $dataLimite, $contabilizado )
	*		Retorna saldo da conta, em um data limite, considerando lancamentos contabilizados ou nao
	*		@param	$oidConta		  OID da conta contabil
	*		@param	$dataLimite   Data limite
	*		@param	$contabilizado	  Contabilizado (default = S)
	*		@return $saldoConta   saldo da conta
	*/
	function buscaSaldoConta($oidConta, $dataLimite, $contabilizado = "S") {

		$saldoDebito = 0;
		$saldoCredito = 0;

		$saldoDebito = $this->persistence->searchSaldoConta($oidConta, $dataLimite, $contabilizado, "D");

		$saldoCredito = $this->persistence->searchSaldoConta($oidConta, $dataLimite, $contabilizado, "C");

		return ($saldoDebito - $saldoCredito);

	}

	/**
	*		buscaMovimentoConta( $oidConta, $dataInicial, $dataFinal, $contabilizado,
	*							 $operacao, $desconsiderarZeramento = false, $oidCentroCusto = "0" )
	*		Retorna movimento da conta, no periodo
	*		@param	$oidConta				OID da conta contabil
	*		@param	$dataInicial			Data inicial
	*		@param	$dataFinal				Data final
	*		@param	$contabilizado			Contabilizado (default = S)
	*		@param	$operacao				Operacao (D/C)
	*		@param	$desconsiderarZeramento Desconsiderar zeramentos (default = false)
	*		@return $valorTotal		valor total movimentado na operacao e periodo informados
	*/
	function buscaMovimentoConta($oidConta, $dataInicial, $dataFinal, $contabilizado, $operacao, $desconsiderarZeramento = false, $oidCentroCusto = "0") {

		return $this->persistence->searchMovimentoConta($oidConta, $dataInicial, $dataFinal, $contabilizado, $operacao, $desconsiderarZeramento, $oidCentroCusto);

	}

	/**
	*		buscaSomaItens( $oidLancamento, $operacao )
	*		Retorna a soma dos itens
	*		@param	$oidLancamento	  OID do lancamento
	*		@param	$operacao		  Operacao (D/C)
	*		@return soma			  Soma dos itens referentes a operacao
	*/
	function buscaSomaItens($oidLancamento, $operacao) {

		return $this->persistence->searchSomaItens($oidLancamento, $operacao);

	}

	/**
	*		consultaLancamentosNaoContabilizados( $dataInicial, $dataFinal, $oidEmpresaCont,
	*																				$oidEmpresa, $mostra = true )
	*		Mostra consulta de lancamentos nao contabilizados, no formato HTML
	*		@param	$dataInicial	Data inicial
	*		@param	$dataFinal			Data final
	*	@param	$oidEmpresaCont OID da empresa contabil
	*		@param	$oidEmpresa	OID da empresa
	*		@param	$mostra 		se true javascript:history.back(), se nao go(-2)
	*/
	function consultaLancamentosNaoContabilizados($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $mostra = true) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();

		$lista = $this->buscaLancamentosPeriodo($dataInicial, $dataFinal, $oidEmpresaCont);

		$empresa->pesquisaEmpresa($oidEmpresaCont);

		if ($lista[0][0] == "0")
			return false;
		else {

			// Seta variaveis auxiliares...
			$acaoAdicional = "javascript:window.print();";

			$voltar = $mostra == true ? "javascript:history.back();" : "javascript:history.back();";

			$infoAdicionais = "<input type=\"hidden\" name=\"oidEmpresa\" ";
			$infoAdicionais .= "value=\"" . $oidEmpresa . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"oidEmpresaCont\" ";
			$infoAdicionais .= "value=\"" . $oidEmpresaCont . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"dataInicial\" ";
			$infoAdicionais .= "value=\"" . $dataInicial . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"dataFinal\" ";
			$infoAdicionais .= "value=\"" . $dataFinal . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"controleNavegacao\" ";
			$infoAdicionais .= "value=\"2\">\n";
			$infoAdicionais .= "<input type=\"submit\" name=\"gerar\" class=\"bjanela\" ";
			$infoAdicionais .= "value=\"" . $botaoGerarPDF . "\">\n";
			$infoAdicionais .= "<input type=\"button\" name=\"imprimir\" class=\"bjanela\" ";
			$infoAdicionais .= "value=\"" . $botaoImprimir . "\" onClick=\"" . $acaoAdicional . "\">\n";

			// Cabecalho...
			$cabecalho = "<font face=\"Verdana, Arial\" color=\"#000099\" size=\"2\">";
			$cabecalho .= $empresa->getOidEmpresaCont() . " - " . $empresa->getRazaoSocial();
			$cabecalho .= "<br>";
			$cabecalho .= $dataInicial . " - " . $dataFinal . "</font><br><br>";

			// Cria relatorio...
			$relatorio = new RelatorioHTMLCw($oidEmpresa, $relatorioLancNaoCont, $cabecalho);

			// Inicia apresentacao do relatorio...
			$relatorio->inicioRelatorio();

			$relatorio->mostraString("<table width=\"100%\" border=\"0\">");
			$relatorio->mostraString("<tr>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"center\" width=\"10%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioLancamento);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"center\" width=\"10%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioData);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"15%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioConta);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"15%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioDescricao);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"30%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioHistorico);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"10%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioDebito);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"10%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioCredito);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("</tr>");

			$totalDebito = $totalCredito = 0.0;
			// Comeca laco para apresentacao do relatorio...
			for ($indx = 0; $indx < sizeof($lista); $indx++) {

				$listaItens = $itemLancamento->buscaItemLancamento($lista[$indx][0]);

				for ($indy = 0; $indy < sizeof($listaItens); $indy++) {

					// Define cor da linha
					$cor = ($indx % 2) == 0 ? "lcons1" : "lcons2";

					// Pesquisa dados da conta...
					$oidConta = $listaItens[$indy][2] . "." . Numero :: modulo11($listaItens[$indy][2]);
					$conta->pesquisaConta($oidConta);

					$relatorio->mostraString("<tr>");

					// Codigo do lancamento...
					$relatorio->mostraString("<td align=\"center\" width=\"10%\" class=\"" . $cor . "\">");
					$relatorio->mostraString($lista[$indx][0]);
					$relatorio->mostraString("</td>");

					// Data do lancamento...
					$relatorio->mostraString("<td align=\"center\" width=\"10%\" class=\"" . $cor . "\">");
					$relatorio->mostraString($lista[$indx][1]);
					$relatorio->mostraString("</td>");

					// Codigo sintetico...
					$relatorio->mostraString("<td align=\"left\" width=\"15%\" class=\"" . $cor . "\">");
					$relatorio->mostraString($conta->getCodigoSintetico());
					$relatorio->mostraString("</td>");

					// Descricao...
					$relatorio->mostraString("<td align=\"left\" width=\"15%\" class=\"" . $cor . "\">");
					$relatorio->mostraString($conta->getDescricao());
					$relatorio->mostraString("</td>");

					// Historico...
					$relatorio->mostraString("<td align=\"left\" width=\"30%\" class=\"" . $cor . "\">");
					$relatorio->mostraString($listaItens[$indy][3]);
					$relatorio->mostraString("</td>");

					// Debito...
					$relatorio->mostraString("<td align=\"right\" width=\"10%\" class=\"" . $cor . "\">");
					if ($listaItens[$indy][5] == "D") {
						if ($listaItens[$indy][4] > 0)
							$relatorio->mostraString(Numero :: convReal($listaItens[$indy][4]));
					} else
						$relatorio->mostraString("&nbsp;");
					$relatorio->mostraString("</td>");

					// Credito...
					$relatorio->mostraString("<td align=\"right\" width=\"10%\" class=\"" . $cor . "\">");
					if ($listaItens[$indy][5] == "C") {
						if ($listaItens[$indy][4] > 0)
							$relatorio->mostraString(Numero :: convReal($listaItens[$indy][4]));
					} else
						$relatorio->mostraString("&nbsp;");
					$relatorio->mostraString("</td>");

					$relatorio->mostraString("</tr>");

					if ($listaItens[$indy][5] == "D")
						$totalDebito += $listaItens[$indy][4];
					else
						$totalCredito += $listaItens[$indy][4];

				} // Fim do for indy...

			} // Fim do for indx...

			$relatorio->mostraString("<tr>");

			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"center\">");
			$relatorio->mostraString("&nbsp;");
			$relatorio->mostraString("</td>");

			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"center\">");
			$relatorio->mostraString("&nbsp;");
			$relatorio->mostraString("</td>");

			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"15%\" class=\"tjanela\" align=\"center\">");
			$relatorio->mostraString("&nbsp;");
			$relatorio->mostraString("</td>");

			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"15%\" class=\"tjanela\" align=\"center\">");
			$relatorio->mostraString("&nbsp;");
			$relatorio->mostraString("</td>");

			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"30%\" class=\"tjanela\" align=\"right\">");
			$relatorio->mostraString($relatorioTotais);
			$relatorio->mostraString("</td>");

			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"right\">");
			$relatorio->mostraString(Numero :: convReal($totalDebito));
			$relatorio->mostraString("</td>");

			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"right\">");
			$relatorio->mostraString(Numero :: convReal($totalCredito));
			$relatorio->mostraString("</td>");

			$relatorio->mostraString("</tr>");

			// Finaliza relatorio...
			$relatorio->mostraString("</table>");
			$relatorio->fimRelatorio("cwConsLancNaoCont.php", $infoAdicionais, $voltar);

			return true;

		} // Fim da decisao de validacao do array

	}

	/**
	*		consultaLancamentosNaoContabilizadosPDF( $dataInicial, $dataFinal, $oidEmpresaCont,
	*																				$oidEmpresa )
	*		Mostra consulta de lancamentos nao contabilizados, no formato HTML
	*		@param	$dataInicial	Data inicial
	*		@param	$dataFinal			Data final
	*	@param	$oidEmpresaCont OID da empresa contabil
	*		@param	$oidEmpresa	OID da empresa
	*/
	function consultaLancamentosNaoContabilizadosPDF($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa) {

		// Seta variaveis que possam ser utilizadas...
		$controleLinha = 1;
		$flagPreenchido = false;

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();

		$lista = $this->buscaLancamentosPeriodo($dataInicial, $dataFinal, $oidEmpresaCont);

		$empresa->pesquisaEmpresa($oidEmpresaCont);

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$larguraColunas = array (
			10,
			15,
			20,
			40,
			60,
			15,
			15
		);
		$cabecalho = array (
			$relatorioCodigo,
			$relatorioData,
			$relatorioConta,
			$relatorioDescricao,
			$relatorioHistorico,
			$relatorioDebito,
			$relatorioCredito
		);

		$totalDebito = $totalCredito = 0.0;

		// Cria relatorio...
		$relatorio = new RelatorioPDFCw($oidEmpresa, $relatorioLancNaoCont, $oidEmpresaCont . " - " . $empresa->getRazaoSocial() . " - " . $dataInicial . " a " . $dataFinal, $tituloSistema, $campoTextoPagina);

		// Gera instancia de documento...
		$relatorio->getInstancia();

		// Seta margens do documento
		$relatorio->document->SetMargins(10, 10, 10);
		$relatorio->document->Open();
		$relatorio->document->AliasNbPages();
		$relatorio->document->SetAutoPageBreak(true, 10);
		$relatorio->document->AddPage();

		// Monta cabecalho da tabela...
		$relatorio->document->setFonte($relatorio->fonteTituloTabela);
		$relatorio->document->setCorTexto($relatorio->corTituloTabela);
		$relatorio->document->setCorFundo($relatorio->corFundoTituloTabela);
		$relatorio->document->setCorBorda($relatorio->corBordaTabela);

		$relatorio->document->SetLineWidth(.2);

		for ($indx = 0; $indx < count($cabecalho); $indx++)
			$relatorio->document->Cell($larguraColunas[$indx], 4, $cabecalho[$indx], 1, 0, "C", 1);
		$relatorio->document->Ln();

		$relatorio->document->setCorFundo($relatorio->corFundoTabela);
		$relatorio->document->setCorTexto($relatorio->corTextoTabela);
		$relatorio->document->setFonte($relatorio->fonteTextoTabela);

		// Comeca laco para impressao do relatorio...
		for ($indx = 0; $indx < sizeof($lista); $indx++) {

			$listaItens = $itemLancamento->buscaItemLancamento($lista[$indx][0]);

			// Controla preenchimento (automato finito - :-)...
			$flagPreenchido = !$flagPreenchido;

			for ($indy = 0; $indy < sizeof($listaItens); $indy++) {

				// Pesquisa dados da conta...
				$oidConta = $listaItens[$indy][2] . "." . Numero :: modulo11($listaItens[$indy][2]);
				$conta->pesquisaConta($oidConta);

				// Imprime os dados...
				$relatorio->document->Cell($larguraColunas[0], 4, substr($lista[$indx][0], 0, 29), "LR", 0, "R", $flagPreenchido);
				$relatorio->document->Cell($larguraColunas[1], 4, substr($lista[$indx][1], 0, 40), "LR", 0, "L", $flagPreenchido);
				$relatorio->document->Cell($larguraColunas[2], 4, substr($conta->getCodigoSintetico(), 0, 29), "LR", 0, "L", $flagPreenchido);
				$relatorio->document->Cell($larguraColunas[3], 4, substr($conta->getDescricao(), 0, 40), "LR", 0, "L", $flagPreenchido);
				$relatorio->document->Cell($larguraColunas[4], 4, substr($listaItens[$indy][3], 0, 40), "LR", 0, "L", $flagPreenchido);
				// testa se é debito...
				if ($listaItens[$indy][5] == "D") {
					if ($listaItens[$indy][4] > 0)
						$relatorio->document->Cell($larguraColunas[5], 4, Numero :: convReal($listaItens[$indy][4]), "LR", 0, "R", $flagPreenchido);
				} else
					$relatorio->document->Cell($larguraColunas[5], 4, " ", "LR", 0, "R", $flagPreenchido);

				// testa se é credito...
				if ($listaItens[$indy][5] == "C") {
					if ($listaItens[$indy][4] > 0)
						$relatorio->document->Cell($larguraColunas[5], 4, Numero :: convReal($listaItens[$indy][4]), "LR", 0, "R", $flagPreenchido);
				} else
					$relatorio->document->Cell($larguraColunas[5], 4, " ", "LR", 0, "R", $flagPreenchido);

				if ($listaItens[$indy][5] == "D")
					$totalDebito += $listaItens[$indy][4];
				else
					$totalCredito += $listaItens[$indy][4];

				// Salta linha...
				$relatorio->document->Ln();

				// Incrementa linha...
				$controleLinha++;

				// Se terminou pagina...
				if ($controleLinha > 52) {
					$relatorio->document->AddPage();

					// Monta cabecalho da tabela...
					$relatorio->document->setFonte($relatorio->fonteTituloTabela);
					$relatorio->document->setCorTexto($relatorio->corTituloTabela);
					$relatorio->document->setCorFundo($relatorio->corFundoTituloTabela);
					$relatorio->document->setCorBorda($relatorio->corBordaTabela);

					$relatorio->document->SetLineWidth(.2);

					for ($indx = 0; $indx < count($cabecalho); $indx++)
						$relatorio->document->Cell($larguraColunas[$indx], 4, $cabecalho[$indx], 1, 0, "C", 1);
					$relatorio->document->Ln();

					$relatorio->document->setCorFundo($relatorio->corFundoTabela);
					$relatorio->document->setCorTexto($relatorio->corTextoTabela);
					$relatorio->document->setFonte($relatorio->fonteTextoTabela);

					$controleLinha = 1;

				} // Fim do indy...

			} // Fim do indx

		}

		// Monta cabecalho da tabela...
		$relatorio->document->setFonte($relatorio->fonteTituloTabela);
		$relatorio->document->setCorTexto($relatorio->corTituloTabela);
		$relatorio->document->setCorFundo($relatorio->corFundoTituloTabela);
		$relatorio->document->setCorBorda($relatorio->corBordaTabela);
		$relatorio->document->SetLineWidth(.2);

		for ($indx = 0; $indx < 4; $indx++)
			$relatorio->document->Cell($larguraColunas[$indx], 4, " ", 1, 0, "C", 1);
		$relatorio->document->Cell($larguraColunas[4], 4, $relatorioTotais, 1, 0, "R", 1);
		$relatorio->document->Cell($larguraColunas[5], 4, Numero :: convReal($totalDebito), 1, 0, "R", 1);
		$relatorio->document->Cell($larguraColunas[6], 4, Numero :: convReal($totalCredito), 1, 0, "R", 1);
		$relatorio->document->Ln();

		$relatorio->document->setCorFundo($relatorio->corFundoTabela);
		$relatorio->document->setCorTexto($relatorio->corTextoTabela);
		$relatorio->document->setFonte($relatorio->fonteTextoTabela);

		$relatorio->document->closeDoc("../pdfs/" . PDF_NAO_CONTAB);

		// Exibe mensagem...
		$msg = new MsgCw($msgCliqueAquiParaVisualizar, "../imagens/contabil.jpg", "javascript:history.go(-2);");
		$msg->mostraMsgLink("../pdfs/" . PDF_NAO_CONTAB, true);
		exit ();

	}

	/**
	*		imprimeSlip( $oidLancamento, $operacao = 0 )
	*		Imprime slip do lancamento
	*		@param	$oidLancamento	OID de lancamento
	*		@param	$operacao		Operacao
	*/
	function imprimeSlip($oidLancamento, $operacao = 0) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";

		$this->setOidLancamento($oidLancamento);
		$this->pesquisaLancamento($this->getOidLancamento());

		$strVolta = ($operacao == 0) ? "javascript:history.go(-1);" : "javascript:window.close();";

		$empresa = new Empresa();
		$itemLancamento = new ItemLancamento();
		$conta = new Conta();

		$empresa->pesquisaEmpresa($this->getOidEmpresaCont());
		$lista = $itemLancamento->buscaItemLancamento($this->getOidLancamento());

		echo "<br><br><br>\n";
		echo "<center>\n";
		echo "<font face=\"Verdana, Arial\" color=\"#000000\" size=\"2\">\n";
		echo "<b>\n";
		echo $relatorioImprimirSlip . "&nbsp;" . $this->getOidLancamento();
		echo "</b><br><br>\n";
		echo $empresa->getOidEmpresaCont() . " - " . $empresa->getRazaoSocial() . "<br>";
		echo $campoDataLanc . $this->getDataLancamento();
		echo "</font></center><br><form>\n";
		echo "<table border=\"0\" width=\"100%\">\n";
		echo "<tr>\n<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"12%\"";
		echo "class=\"tjanela\" align=\"center\">\n";
		echo $relatorioConta;
		echo "</td>\n<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"30%\"";
		echo "class=\"tjanela\" align=\"center\">\n";
		echo $relatorioDescricao;
		echo "</td>\n<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"34%\"";
		echo "class=\"tjanela\" align=\"center\">\n";
		echo $relatorioHistorico;
		echo "</td>\n<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"12%\"";
		echo "class=\"tjanela\" align=\"right\">\n";
		echo $relatorioDebito;
		echo "</td>\n<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"12%\"";
		echo "class=\"tjanela\" align=\"right\">\n";
		echo $relatorioCredito;
		echo "</td>\n</tr>\n";

		$totalDebito = $totalCredito = 0.0;
		for ($indx = 0; $indx < sizeof($lista); $indx++) {
			$cor = ($indx % 2) == 0 ? "lcons8" : "lcons9";

			$oidConta = $lista[$indx][2] . "." . Numero :: modulo11($lista[$indx][2]);
			$conta->pesquisaConta($oidConta);

			// Alteração em 14.02.2006 -> Desconsiderar DV ao buscar o nome da conta
			$oidConta = $lista[$indx][2];
			$conta->pesquisaContaSemDV($oidConta);

			echo "<tr>\n";
			echo "<td width=\"12%\" align=\"center\" class=\"$cor\">\n";
			echo $conta->getCodigoSintetico() . " (" . $conta->getOidContaDV() . ")";
			echo "</td><td width=\"30%\" align=\"left\" class=\"$cor\">\n";
			echo $conta->getDescricao();
			echo "</td>\n<td width=\"34%\" align=\"left\" class=\"$cor\">\n";
			echo $lista[$indx][3];
			echo "</td>\n<td width=\"12%\" align=\"right\" class=\"$cor\">\n";
			if ($lista[$indx][5] == "D") {
				if ($lista[$indx][4] > 0)
					echo Numero :: convReal($lista[$indx][4]);
			} else
				echo "&nbsp;";
			echo "</td>\n<td width=\"12%\" align=\"right\" class=\"$cor\">\n";
			if ($lista[$indx][5] == "C") {
				if ($lista[$indx][4] > 0)
					echo Numero :: convReal($lista[$indx][4]);
			} else
				echo "&nbsp;";
			echo "</td>\n</tr>\n";

			if ($lista[$indx][5] == "D")
				$totalDebito += $lista[$indx][4];
			else
				$totalCredito += $lista[$indx][4];
		}

		echo "<tr>\n<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"12%\" ";
		echo "class=\"tjanela\" align=\"left\">&nbsp;</td>\n";
		echo "<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"30%\" ";
		echo "class=\"tjanela\" align=\"left\">&nbsp;</td>\n";
		echo "<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"34%\" ";
		echo "class=\"tjanela\" align=\"right\">" . $relatorioTotais . "</td>\n";
		echo "<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"12%\" ";
		echo "class=\"tjanela\" align=\"right\">" . Numero :: convReal($totalDebito) . "</td>\n";
		echo "<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"12%\" ";
		echo "class=\"tjanela\" align=\"right\">" . Numero :: convReal($totalCredito) . "</td>\n";
		echo "</tr>\n</table>\n";

		echo "<table class=\"pagina\" border=\"0\" width=\"100%\">\n";
		echo "<tr>\n<td width=\"100%\" align=\"center\">\n";
		echo "<input type=\"button\" class=\"bjanela\" value=\"$botaoImprimir\" name=\"bt_imprimir\" ";
		echo "OnClick=\"javascript:window.print();\">&nbsp;";
		echo "<input type=\"button\" class=\"bjanela\" value=\"$botaoVoltar\" name=\"bt_voltar\" ";
		echo " OnClick=\"$strVolta\">\n";
		echo "</td>\n</tr>\n</table>\n<br><br>\n</form>\n";

	}

	/**
	*		ajustaLancamento( $oidLancamento )
	*		Ajusta o lancamento, se debito e credito nao fecham, entao o lancamento e
	*		"aberto" e "nao liberado"
	*		@param	$oidLancamento	OID de lancamento
	*		@return true se ajustou lancamento
	*/
	function ajustaLancamento($oidLancamento) {

		$retorna = false;

		$this->setOidLancamento($oidLancamento);
		$this->pesquisaLancamento($this->getOidLancamento());

		$itemLancamento = new ItemLancamento();
		$lista = $itemLancamento->buscaItemLancamento($this->getOidLancamento());

		$totalDebito = $totalCredito = 0.0;

		for ($indx = 0; $indx < sizeof($lista); $indx++) {

			if ($lista[$indx][5] == "D")
				$totalDebito += $lista[$indx][4];
			else
				$totalCredito += $lista[$indx][4];
		}

		if (strcmp($totalDebito, $totalCredito) != 0) {

			// Atualiza o cabecalho do lancamento...
			$this->persistence->updateStatusLancamento($oidLancamento, false);
			$retorna = true;
		} else {
			// Atualiza o cabecalho do lancamento para Fechado
			$this->persistence->updateStatusLancamento($oidLancamento, true);
		}

		return $retorna;

	}

	/**
	*		consultaDiario( $dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa,
	*										$paginaInicial, $exibeNaoLiberado, $exibeContador, $perfilUsuario )
	*		Mostra consulta de diario de lancamentos, no formato HTML
	*		@param	$dataInicial	  Data inicial
	*		@param	$dataFinal			  Data final
	*	@param	$oidEmpresaCont   OID da empresa contabil
	*		@param	$oidEmpresa   OID da empresa
	*		@param	$paginaInicial	  Pagina inicial
	*		@param	$exibeNaoLiberado se true, exibe os lancamentos nao liberados pelo contador
	*		@param	$exibeContador	  se true, exibe dados do contador no final
	*		@param	$perfilUsuario	  Perfil do usuario
	*		@param	$exibeQuebras	  se true, exibe Sub-totais por dia
	*/
	function consultaDiario($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $paginaInicial, $exibeNaoLiberado, $exibeContador, $perfilUsuario, $exibeQuebras) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$exibeNaoLiberado = ($exibeNaoLiberado == false) ? 0 : 1;

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();

		$lista = $this->buscaLancamentosPeriodo($dataInicial, $dataFinal, $oidEmpresaCont, 0, $exibeNaoLiberado, "S");

		$empresa->pesquisaEmpresa($oidEmpresaCont);

		if ($lista[0][0] == "0")
			return false;
		else {

			// Seta variaveis auxiliares...
			$acaoAdicional = "javascript:window.print();";

			$voltar = $mostra == true ? "javascript:history.back();" : "javascript:history.back();";

			$infoAdicionais = "<font face=\"Verdana, Arial\" size=\"1\"><a href=\"../pdfs/" . TXT_DIARIO . "\">";
			$infoAdicionais .= $msgCliqueAquiParaVisualizarTXT;
			$infoAdicionais .= "</a></font>\n<br><br>\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"oidEmpresa\" ";
			$infoAdicionais .= "value=\"" . $oidEmpresa . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"oidEmpresaCont\" ";
			$infoAdicionais .= "value=\"" . $oidEmpresaCont . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"dataInicial\" ";
			$infoAdicionais .= "value=\"" . $dataInicial . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"dataFinal\" ";
			$infoAdicionais .= "value=\"" . $dataFinal . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"paginaInicial\" ";
			$infoAdicionais .= "value=\"" . $paginaInicial . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"exibeNaoLiberado\" ";
			$infoAdicionais .= "value=\"" . $exibeNaoLiberado . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"exibeContador\" ";
			$infoAdicionais .= "value=\"" . $exibeContador . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"exibeQuebras\" ";
			$infoAdicionais .= "value=\"" . $exibeQuebras . "\">\n";
			if ($perfilUsuario != "O") {
				$infoAdicionais .= "<input type=\"hidden\" name=\"controleNavegacao\" ";
				$infoAdicionais .= "value=\"2\">\n";
				$infoAdicionais .= "<input type=\"submit\" name=\"gerar\" class=\"bjanela\" ";
				$infoAdicionais .= "value=\"" . $botaoGerarPDF . "\">\n";
			} else {
				$infoAdicionais .= "<input type=\"hidden\" name=\"controleNavegacao\" ";
				$infoAdicionais .= "value=\"3\">\n";
				$infoAdicionais .= "<input type=\"submit\" name=\"gerar\" class=\"bjanela\" ";
				$infoAdicionais .= "value=\"" . $botaoVisualizarPDF . "\">\n";
			}
			$infoAdicionais .= "<input type=\"button\" name=\"imprimir\" class=\"bjanela\" ";
			$infoAdicionais .= "value=\"" . $botaoImprimir . "\" onClick=\"" . $acaoAdicional . "\">\n";

			// Cabecalho...
			$cabecalho = "<font face=\"Verdana, Arial\" color=\"#000099\" size=\"2\">";
			$cabecalho .= $empresa->getOidEmpresaCont() . " - " . $empresa->getRazaoSocial();
			$cabecalho .= "<br>";
			$cabecalho .= $dataInicial . " - " . $dataFinal . "</font><br><br>";

			// Cria relatorio...
			$relatorio = new RelatorioHTMLCw($oidEmpresa, $relatorioDiario, $cabecalho);
			$this->geraDiarioTXT($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $paginaInicial, $exibeNaoLiberado, $exibeContador, $perfilUsuario, $exibeQuebras);
			// Inicia apresentacao do relatorio...
			$relatorio->inicioRelatorio();

			$relatorio->mostraString("<table width=\"100%\" border=\"0\">");
			$relatorio->mostraString("<tr>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"center\" width=\"10%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioLancamento);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"center\" width=\"10%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioData);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"15%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioConta);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"15%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioDescricao);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"30%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioHistorico);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"10%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioDebito);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"10%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioCredito);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"10%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioCentroCusto);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("</tr>");

			$totalDebito = $totalCredito = 0.0;
			$contadorLinhas = 70;
			$contadorPagina = $paginaInicial -1;
			$dataAnterior = 0;
			$subTotalDebito = 0;
			$subTotalCredito = 0;
			// Comeca laco para apresentacao do relatorio...
			for ($indx = 0; $indx < sizeof($lista); $indx++) {

				$listaItens = $itemLancamento->buscaItemLancamento($lista[$indx][0]);

				for ($indy = 0; $indy < sizeof($listaItens); $indy++) {

					// Define cor da linha
					if ($lista[$indx][2] == "N")
						$cor = ($indx % 2) == 0 ? "lcons10" : "lcons11";
					else
						$cor = ($indx % 2) == 0 ? "lcons1" : "lcons2";

					// Pesquisa dados da conta...
					$oidConta = $listaItens[$indy][2] . "." . Numero :: modulo11($listaItens[$indy][2]);
					$conta->pesquisaConta($oidConta);

					if ($dataAnterior == 0)
						$dataAnterior = $lista[$indx][1];

					// Testa se precisa exibir os sub-totais parciais...
					if (!empty ($exibeQuebras) && $exibeQuebras && $dataAnterior != $lista[$indx][1]) {
						$relatorio->mostraString("<tr>");

						$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"center\">");
						$relatorio->mostraString("&nbsp;");
						$relatorio->mostraString("</td>");

						$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"center\">");
						$relatorio->mostraString("&nbsp;");
						$relatorio->mostraString("</td>");

						$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"15%\" class=\"tjanela\" align=\"center\">");
						$relatorio->mostraString("&nbsp;");
						$relatorio->mostraString("</td>");

						$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"15%\" class=\"tjanela\" align=\"center\">");
						$relatorio->mostraString("&nbsp;");
						$relatorio->mostraString("</td>");

						$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"30%\" class=\"tjanela\" align=\"right\">");
						$relatorio->mostraString($relatorioSubTotais);
						$relatorio->mostraString("</td>");

						$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"right\">");
						$relatorio->mostraString(Numero :: convReal($subTotalDebito));
						$relatorio->mostraString("</td>");

						$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"right\">");
						$relatorio->mostraString(Numero :: convReal($subTotalCredito));
						$relatorio->mostraString("</td>");

						$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"right\">");
						$relatorio->mostraString(" ");
						$relatorio->mostraString("</td>");

						$subTotalDebito = 0;
						$subTotalCredito = 0;
						$dataAnterior = $lista[$indx][1];
						$relatorio->mostraString("</tr>");

					}

					$relatorio->mostraString("<tr>");

					// Codigo do lancamento...
					$relatorio->mostraString("<td align=\"center\" width=\"10%\" class=\"" . $cor . "\">");
					$relatorio->mostraString($lista[$indx][0]);
					if (!empty ($listaItens[$indy][8])) {
						$urlImagem = "../uploads/" . $listaItens[$indy][8];
						$relatorio->mostraString("<a href=\"" . $urlImagem . "\" target=blank><img src=\"../imagens/imagem.gif\" border=\"0\" alt=\"Clique para visualizar o documento contábil\"></a> ");
					}

					$relatorio->mostraString("</td>");

					// Data do lancamento...
					$relatorio->mostraString("<td align=\"center\" width=\"10%\" class=\"" . $cor . "\">");
					$relatorio->mostraString($lista[$indx][1]);
					$relatorio->mostraString("</td>");

					// Codigo sintetico...
					$relatorio->mostraString("<td align=\"left\" width=\"15%\" class=\"" . $cor . "\">");
					$relatorio->mostraString($conta->getCodigoSintetico());
					$relatorio->mostraString("</td>");

					// Descricao...
					$relatorio->mostraString("<td align=\"left\" width=\"15%\" class=\"" . $cor . "\">");
					$relatorio->mostraString($conta->getDescricao());
					$relatorio->mostraString("</td>");

					// Historico...
					$relatorio->mostraString("<td align=\"left\" width=\"30%\" class=\"" . $cor . "\">");
					$relatorio->mostraString($listaItens[$indy][3]);
					$relatorio->mostraString("</td>");

					// Debito...
					$relatorio->mostraString("<td align=\"right\" width=\"10%\" class=\"" . $cor . "\">");
					if ($listaItens[$indy][5] == "D") {
						if ($listaItens[$indy][4] > 0)
							$relatorio->mostraString(Numero :: convReal($listaItens[$indy][4]));
					} else
						$relatorio->mostraString("&nbsp;");
					$relatorio->mostraString("</td>");

					// Credito...
					$relatorio->mostraString("<td align=\"right\" width=\"10%\" class=\"" . $cor . "\">");
					if ($listaItens[$indy][5] == "C") {
						if ($listaItens[$indy][4] > 0)
							$relatorio->mostraString(Numero :: convReal($listaItens[$indy][4]));
					} else
						$relatorio->mostraString("&nbsp;");
					$relatorio->mostraString("</td>");

					// Centro de Custo...
					$relatorio->mostraString("<td align=\"left\" width=\"10%\" class=\"" . $cor . "\">");
					if ($listaItens[$indy][7] != "0") {
						$centroCusto = new CentroCusto();
						$centroCusto->pesquisaCentroCusto($listaItens[$indy][7]);
						$relatorio->mostraString($centroCusto->getSigla());
					}

					$relatorio->mostraString("</tr>");

					if ($listaItens[$indy][5] == "D") {
						$totalDebito += $listaItens[$indy][4];
						$subTotalDebito += $listaItens[$indy][4];
					} else {
						$totalCredito += $listaItens[$indy][4];
						$subTotalCredito += $listaItens[$indy][4];
					}

				} // Fim do for indy...

			} // Fim do for indx...

			// Testa se precisa exibir os sub-totais parciais...
			if (!empty ($exibeQuebras) && $exibeQuebras) {
				$relatorio->mostraString("<tr>");

				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"center\">");
				$relatorio->mostraString("&nbsp;");
				$relatorio->mostraString("</td>");

				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"center\">");
				$relatorio->mostraString("&nbsp;");
				$relatorio->mostraString("</td>");

				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"15%\" class=\"tjanela\" align=\"center\">");
				$relatorio->mostraString("&nbsp;");
				$relatorio->mostraString("</td>");

				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"15%\" class=\"tjanela\" align=\"center\">");
				$relatorio->mostraString("&nbsp;");
				$relatorio->mostraString("</td>");

				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"30%\" class=\"tjanela\" align=\"right\">");
				$relatorio->mostraString($relatorioSubTotais);
				$relatorio->mostraString("</td>");

				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"right\">");
				$relatorio->mostraString(Numero :: convReal($subTotalDebito));
				$relatorio->mostraString("</td>");

				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"right\">");
				$relatorio->mostraString(Numero :: convReal($subTotalCredito));
				$relatorio->mostraString("</td>");

				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"right\">");
				$relatorio->mostraString(" ");
				$relatorio->mostraString("</td>");

				$subTotalDebito = 0;
				$subTotalCredito = 0;
				$dataAnterior = $lista[$indx][1];
				$relatorio->mostraString("</tr>");

			}

			$relatorio->mostraString("<tr>");

			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"center\">");
			$relatorio->mostraString("&nbsp;");
			$relatorio->mostraString("</td>");

			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"center\">");
			$relatorio->mostraString("&nbsp;");
			$relatorio->mostraString("</td>");

			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"15%\" class=\"tjanela\" align=\"center\">");
			$relatorio->mostraString("&nbsp;");
			$relatorio->mostraString("</td>");

			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"15%\" class=\"tjanela\" align=\"center\">");
			$relatorio->mostraString("&nbsp;");
			$relatorio->mostraString("</td>");

			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"30%\" class=\"tjanela\" align=\"right\">");
			$relatorio->mostraString($relatorioTotais);
			$relatorio->mostraString("</td>");

			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"right\">");
			$relatorio->mostraString(Numero :: convReal($totalDebito));
			$relatorio->mostraString("</td>");

			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"right\">");
			$relatorio->mostraString(Numero :: convReal($totalCredito));
			$relatorio->mostraString("</td>");

			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"right\">");
			$relatorio->mostraString(" ");
			$relatorio->mostraString("</td>");

			$relatorio->mostraString("</tr>");

			// Finaliza relatorio...
			$relatorio->mostraString("</table>");

			if (!empty ($exibeNaoLiberado) && $exibeNaoLiberado != false) {
				$relatorio->mostraString("<br><table class=\"pagina\" border=\"0\" width=\"100%\">");
				$relatorio->mostraString("<tr><td width=\"100%\" align=\"left\" class=\"lcons11\">");
				$relatorio->mostraString($msgLancamentosNaoLiberados);
				$relatorio->mostraString("</td></tr></table><br>");
			}

			// Testa se precisa exibir dados do contador...
			if (!empty ($exibeContador) && $exibeContador) {
				$relatorio->mostraString("<br><table class=\"pagina\" border=\"0\" width=\"100%\">");
				$relatorio->mostraString("<tr><td width=\"100%\" align=\"center\" class=\"lcons2\">");
				$relatorio->mostraString($empresa->getNomeContador());
				$relatorio->mostraString("</td></tr><tr><td width=\"100%\" align=\"center\" class=\"lcons2\">");
				$relatorio->mostraString($empresa->getRegistroContador());
				$relatorio->mostraString("</td></tr></table><br><br>");
			}

			$relatorio->fimRelatorio("cwConsDiario.php", $infoAdicionais, $voltar);

			return true;

		} // Fim da decisao de validacao do array

	}

	/**
	*		geraDiarioTXT( $dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa,
	*										$paginaInicial, $exibeNaoLiberado, $exibeContador, $perfilUsuario, $exibeQuebras )
	*		Mostra consulta de diario de lancamentos, no formato TXT
	*		@param	$dataInicial	  Data inicial
	*		@param	$dataFinal			  Data final
	*	@param	$oidEmpresaCont   OID da empresa contabil
	*		@param	$oidEmpresa   OID da empresa
	*		@param	$paginaInicial	  Pagina inicial
	*		@param	$exibeNaoLiberado se true, exibe os lancamentos nao liberados pelo contador
	*		@param	$exibeContador	  se true, exibe dados do contador no final
	*		@param	$perfilUsuario	  Perfil do usuario
	*		@param	$exibeQuebras	  se true, exibe sub-totais por dia
	*/
	function geraDiarioTXT($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $paginaInicial, $exibeNaoLiberado, $exibeContador, $perfilUsuario, $exibeQuebras) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$exibeNaoLiberado = ($exibeNaoLiberado == false) ? 0 : 1;

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();

		$lista = $this->buscaLancamentosPeriodo($dataInicial, $dataFinal, $oidEmpresaCont, 0, $exibeNaoLiberado, "S");

		$empresa->pesquisaEmpresa($oidEmpresaCont);

		if ($lista[0][0] == "0")
			return false;
		else {
			// Cria o relatório em formato TXT
			$relatorioTXT = new RelatorioTXT();
			$relatorioTXT->setConf("../pdfs/" . TXT_DIARIO);

			// Inicia apresentacao do relatorio...
			$relatorioTXT->inicioRelatorio();

			$totalDebito = $totalCredito = 0.0;
			$contadorLinhas = 70;
			$contadorPagina = $paginaInicial -1;

			$subTotalDebito = $subTotalCredito = 0.0;
			$dataAnterior = 0;
			// Comeca laco para apresentacao do relatorio...
			for ($indx = 0; $indx < sizeof($lista); $indx++) {

				$listaItens = $itemLancamento->buscaItemLancamento($lista[$indx][0]);

				for ($indy = 0; $indy < sizeof($listaItens); $indy++) {

					// Pesquisa dados da conta...
					$oidConta = $listaItens[$indy][2] . "." . Numero :: modulo11($listaItens[$indy][2]);
					$conta->pesquisaConta($oidConta);

					if ($listaItens[$indy][5] == "D")
						$totalDebito += $listaItens[$indy][4];
					else
						$totalCredito += $listaItens[$indy][4];

					// Monta a string para gravar no arquivo .TXT..
					$dataLancamento = sprintf("%-12s", $lista[$indx][1]);

					$codigoSintetico = sprintf("%-14s", $conta->getCodigoSintetico());
					$nomeConta = str_pad($conta->getDescricao(), 40);
					if ($listaItens[$indy][5] == "D") {
						$debito = sprintf("%12s", Numero :: convReal($listaItens[$indy][4]));
						$credito = str_pad(" ", 12);
					} else {
						$debito = str_pad(" ", 11);
						$credito = sprintf("%14s", Numero :: convReal($listaItens[$indy][4]));
					}

					// Testa se tem que imprimir um historico em varias linhas
					$numeroLinhas = 1;
					if (strlen($listaItens[$indy][3]) > 40) {
						// Corta em varios pedacos de 40 bytes
						$numeroLinhas = strlen($listaItens[$indy][3]) / 40;
						$numeroLinhas = ceil($numeroLinhas); // Se for 1,1 entao eh 2 linhas
					}

					for ($indz = 0; $indz < $numeroLinhas; $indz++) {
						$historico = sprintf("%-40s", substr($listaItens[$indy][3], ($indz +1) * 40 - 40, 40));
						$historico = str_replace(chr(13), "", $historico);
						$historico = str_replace(chr(10), " ", $historico);
						$historico = str_pad($historico, 40);
						$historico = substr($historico, 0, 40);

						// Se for a primeira linha do lancamento, deve aparecer data, codigo e nome da conta
						// Mas antes.... podemos testar se a data mudou...
						if ($dataAnterior == 0)
							$dataAnterior = $dataLancamento;
						if (!empty ($exibeQuebras) && $exibeQuebras && ($dataAnterior != $dataLancamento)) {
							if ($contadorLinhas > 52) { // Se recém pulou de página....tem que imprimir o cabeçalho antes de colocar os subtotais
								$contadorPagina = $contadorPagina +1;
								$linhaCabec = str_pad("=", 132, "=") . CRLF;
								$relatorioTXT->mostraString(chr(15) . str_pad(" ", 50) . "D I A R I O" . str_pad(" ", 4) . "D E" . str_pad(" ", 4) . "L A N C A M E N T O S" . CRLF);
								$relatorioTXT->mostraString(String :: removeAcento(sprintf("%-40s", $empresa->getRazaoSocial())) . str_pad(" ", 20) . "Periodo de " . $dataInicial . " a " . $dataFinal . str_pad(" ", 31) . "FL." . str_pad($contadorPagina, 4, "0", STR_PAD_LEFT) . CRLF);
								$relatorioTXT->mostraString($linhaCabec);
								$relatorioTXT->mostraString(str_pad(" ", 2) . "Data" . str_pad(" ", 9) . "Codigo" . str_pad(" ", 12) . "Conta" . str_pad(" ", 35) . "H i s t o r i c o" . str_pad(" ", 23) . "Debito" . str_pad(" ", 6) . "Credito" . CRLF);
								$relatorioTXT->mostraString($linhaCabec);
								$contadorLinhas = 0;
							}
							$subDebito = sprintf("%13s", Numero :: convReal($subTotalDebito));
							$subCredito = sprintf("%13s", Numero :: convReal($subTotalCredito));
							$linha = str_pad(" ", 77) . '*** ' . $relatorioSubTotais . ' ---->' . str_pad(" ", 2) . $subDebito . $subCredito;
							$linha .= CRLF;
							$relatorioTXT->mostraString($linha);
							$contadorLinhas++;
							$subTotalDebito = 0.0;
							$subTotalCredito = 0.0;
							if ($contadorLinhas > 52)
								$relatorioTXT->mostraString(FF);
						}

						if ($indz == 0) {
							$linha = $dataLancamento;
							$dataAnterior = $dataLancamento;
							$linha .= $codigoSintetico . " ";
							$linha .= $nomeConta;
							if ($listaItens[$indy][5] == "D")
								$subTotalDebito += $listaItens[$indy][4];
							else
								$subTotalCredito += $listaItens[$indy][4];

						} else {
							$linha = str_pad(" ", 67);
						}

						$linha .= $historico;
						// Retira os caracteres especiais da linha
						$linha = String :: removeAcento($linha);

						if ($contadorLinhas > 52) {
							$contadorPagina = $contadorPagina +1;
							$linhaCabec = str_pad("=", 132, "=") . CRLF;
							$relatorioTXT->mostraString(chr(15) . str_pad(" ", 50) . "D I A R I O" . str_pad(" ", 4) . "D E" . str_pad(" ", 4) . "L A N C A M E N T O S" . CRLF);
							$relatorioTXT->mostraString(String :: removeAcento(sprintf("%-40s", $empresa->getRazaoSocial())) . str_pad(" ", 20) . "Periodo de " . $dataInicial . " a " . $dataFinal . str_pad(" ", 31) . "FL." . str_pad($contadorPagina, 4, "0", STR_PAD_LEFT) . CRLF);
							$relatorioTXT->mostraString($linhaCabec);
							$relatorioTXT->mostraString(str_pad(" ", 2) . "Data" . str_pad(" ", 9) . "Codigo" . str_pad(" ", 12) . "Conta" . str_pad(" ", 35) . "H i s t o r i c o" . str_pad(" ", 23) . "Debito" . str_pad(" ", 6) . "Credito" . CRLF);
							$relatorioTXT->mostraString($linhaCabec);
							$contadorLinhas = 0;
						}
						if ($indz == ($numeroLinhas -1)) { // Se eh a ultima linha de historico
							$linha .= $debito;
							$linha .= $credito;
						}

						$linha .= CRLF;
						$relatorioTXT->mostraString($linha);
						$contadorLinhas++;
						if ($contadorLinhas > 52)
							$relatorioTXT->mostraString(FF);
					} // Fim do for para as linhas de historico

				} // Fim do for indy...

			} // Fim do for indx...

			if (!empty ($exibeQuebras) && $exibeQuebras) {
				$subDebito = sprintf("%13s", Numero :: convReal($subTotalDebito));
				$subCredito = sprintf("%13s", Numero :: convReal($subTotalCredito));
				$linha = str_pad(" ", 77) . '*** ' . $relatorioSubTotais . ' ---->' . str_pad(" ", 2) . $subDebito . $subCredito;
				$linha .= CRLF;
				$relatorioTXT->mostraString($linha);
				$contadorLinhas++;
				$subTotalDebito = 0.0;
				$subTotalCredito = 0.0;
			}
			if ($contadorLinhas != 70) {
				$relatorioTXT->mostraString(str_pad(" ", 71) . "T O T A I S" . str_pad(" ", 23) . sprintf("%14s", Numero :: convReal($totalDebito)) . sprintf("%13s", Numero :: convReal($totalCredito)) . FF);
			}

			$relatorioTXT->fimRelatorio();

			return true;

		} // Fim da decisao de validacao do array

	}

	/**
	*		consultaDiarioPDF( $dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa,
	*						$paginaInicial, $exibeContador, $exibeQuebras )
	*		Mostra consulta de diario de lancamentos, somente os contabilizados, em formato PDF
	*		@param	$dataInicial	Data inicial
	*		@param	$dataFinal			Data final
	*		@param	$oidEmpresaCont OID da empresa contabil
	*		@param	$oidEmpresa	OID da empresa
	*		@param	$paginaInicial	Pagina inicial
	*		@param	$exibeContador	Exibe dados do contador
	*		@param	$exibeQuebras	Exibe Sub-totais por dia
	*/
	function consultaDiarioPDF($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $paginaInicial, $exibeContador, $exibeQuebras) {

		// Seta variaveis que possam ser utilizadas...
		$controleLinha = 1;
		$flagPreenchido = false;

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();

		$lista = $this->buscaLancamentosPeriodo($dataInicial, $dataFinal, $oidEmpresaCont, 0, 0, "S");

		$empresa->pesquisaEmpresa($oidEmpresaCont);

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$larguraColunas = array (
			10,
			15,
			20,
			40,
			60,
			20,
			20
		);
		$confLista = array ();
		$confLista[] = array (
			0,
			"L",
			0
		);
		$confLista[] = array (
			0,
			"C",
			0
		);
		$confLista[] = array (
			0,
			"L",
			0
		);
		$confLista[] = array (
			0,
			"L",
			0
		);
		$confLista[] = array (
			0,
			"J",
			0
		);
		$confLista[] = array (
			0,
			"R",
			0
		);
		$confLista[] = array (
			0,
			"R",
			0
		);

		$cabecalho = array (
			$relatorioCodigo,
			$relatorioData,
			$relatorioConta,
			$relatorioDescricao,
			$relatorioHistorico,
			$relatorioDebito,
			$relatorioCredito
		);

		$totalDebito = $totalCredito = 0.0;

		// Cria relatorio...
		$relatorio = new RelatorioPDFCw($oidEmpresa, $relatorioDiario, $oidEmpresaCont . " - " . $empresa->getRazaoSocial() . " - " . $dataInicial . " a " . $dataFinal, $tituloSistema, $campoTextoPagina, $paginaInicial, true, $larguraColunas, $cabecalho);

		// Gera instancia de documento...
		$relatorio->getInstancia();

		// Seta margens do documento
		$relatorio->document->SetMargins(10, 10, 10);
		$relatorio->document->Open();
		$relatorio->document->AliasNbPages();
		$relatorio->document->SetAutoPageBreak(true, 10);
		$relatorio->document->AddPage();

		$relatorio->document->setCorFundo(array (
			255,
			255,
			255
		));
		$relatorio->document->setCorTexto($relatorio->corTextoTabela);
		$relatorio->document->setFonte($relatorio->fonteTextoTabela);

		//$relatorio->document->setCorFundo( $relatorio->corFundoTabela );
		//$relatorio->document->setCorTexto( $relatorio->corTituloTabela );
		//$relatorio->document->setFonte( $relatorio->fonteTextoTabela );

		$relatorio->document->SetWidths($larguraColunas);
		$relatorio->document->SetLineWidth(.2);
		$relatorio->document->SetDrawColor(0, 0, 0);

		$dataAnterior = 0;
		$subTotalDebito = 0;
		$subTotalCredito = 0;

		// Comeca laco para impressao do relatorio...
		for ($indx = 0; $indx < sizeof($lista); $indx++) {

			$listaItens = $itemLancamento->buscaItemLancamento($lista[$indx][0]);

			for ($indy = 0; $indy < sizeof($listaItens); $indy++) {

				// Pesquisa dados da conta...
				$oidConta = $listaItens[$indy][2] . "." . Numero :: modulo11($listaItens[$indy][2]);
				$conta->pesquisaConta($oidConta);

				if ($dataAnterior == 0)
					$dataAnterior = $lista[$indx][1];
				if ((!empty ($exibeQuebras) && $exibeQuebras) && ($lista[$indx][1] != $dataAnterior)) {
					// Imprime os dados...
					$valorDebito = Numero :: convReal($subTotalDebito);
					$valorCredito = Numero :: convReal($subTotalCredito);

					$relatorio->document->setCorTexto($relatorio->corVerde);

					$relatorio->document->Row(array (
						" ",
						" ",
						" ",
						" ",
						"		    " . $relatorioSubTotais . " " . $dataAnterior,
						$valorDebito,
						$valorCredito
					), $confLista);
					$relatorio->document->setCorTexto($relatorio->corTextoTabela);

					$subTotalDebito = 0;
					$subTotalCredito = 0;
				}

				// Imprime os dados...
				$valorDebito = $listaItens[$indy][5] == "D" ? Numero :: convReal($listaItens[$indy][4]) : " ";
				$valorCredito = $listaItens[$indy][5] == "C" ? Numero :: convReal($listaItens[$indy][4]) : " ";

				$relatorio->document->Row(array (
					$lista[$indx][0],
					$lista[$indx][1],
				$conta->getCodigoSintetico(), $conta->getDescricao(), String :: removeCRLF($listaItens[$indy][3]), $valorDebito, $valorCredito), $confLista);
				$dataAnterior = $lista[$indx][1];

				if ($listaItens[$indy][5] == "D") {
					$totalDebito += $listaItens[$indy][4];
					$subTotalDebito += $listaItens[$indy][4];
				} else {
					$totalCredito += $listaItens[$indy][4];
					$subTotalCredito += $listaItens[$indy][4];
				}

			} // Fim do indy...

			// Salta linha...
			//$relatorio->document->Ln();
			//$relatorio->document->Line( $relatorio->document->GetX(),
			//		10, $relatorio->document->GetX(),
			//		180 );

		} // Fim do indx

		if ((!empty ($exibeQuebras) && $exibeQuebras)) {
			// Imprime os dados...
			$valorDebito = Numero :: convReal($subTotalDebito);
			$valorCredito = Numero :: convReal($subTotalCredito);
			$relatorio->document->setCorTexto($relatorio->corVerde);

			$relatorio->document->Row(array (
				" ",
				" ",
				" ",
				" ",
				" 		" . $relatorioSubTotais . " " . $dataAnterior,
				$valorDebito,
				$valorCredito
			), $confLista);
			$relatorio->document->setCorTexto($relatorio->corTextoTabela);

			$subTotalDebito = 0;
			$subTotalCredito = 0;
		}

		// Monta cabecalho da tabela...
		$relatorio->document->setFonte($relatorio->fonteTituloTabela);
		$relatorio->document->setCorTexto($relatorio->corTituloTabela);
		$relatorio->document->setCorFundo($relatorio->corVerde);
		$relatorio->document->setCorBorda($relatorio->corBordaTabela);
		$relatorio->document->SetLineWidth(.2);

		// Totais...
		for ($indx = 0; $indx < 4; $indx++)
			$relatorio->document->Cell($larguraColunas[$indx], 4, " ", 1, 0, "C", 1);
		$relatorio->document->Cell($larguraColunas[4], 4, $relatorioTotais, 1, 0, "R", 1);
		$relatorio->document->Cell($larguraColunas[5], 4, Numero :: convReal($totalDebito), 1, 0, "R", 1);
		$relatorio->document->Cell($larguraColunas[6], 4, Numero :: convReal($totalCredito), 1, 0, "R", 1);
		$relatorio->document->Ln();

		// Testa se tem que colocar dados da contadora...
		if (!empty ($exibeContador) && $exibeContador) {
			$relatorio->document->Ln();
			$relatorio->document->Ln();
			$relatorio->document->setCorTexto($relatorio->corTextoTabela);
			$relatorio->document->setFonte($relatorio->fonteTextoTabela);
			$relatorio->document->Cell(0, 0, $empresa->getNomeContador() . " - " . $empresa->getRegistroContador(), 0, 1, "C", 0);
			$relatorio->document->Ln();
		}

		$relatorio->document->setCorFundo($relatorio->corFundoTabela);
		$relatorio->document->setCorTexto($relatorio->corTextoTabela);
		$relatorio->document->setFonte($relatorio->fonteTextoTabela);

		$relatorio->document->closeDoc("../pdfs/" . PDF_DIARIO);

		// Exibe mensagem...
		$msg = new MsgCw($msgCliqueAquiParaVisualizar, "../imagens/contabil.jpg", "javascript:history.go(-2);");
		$msg->mostraMsgLink("../pdfs/" . PDF_DIARIO, true);
		exit ();

	}

	/**
	*		consultaBalanceteAnalitico( $dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa,
	*										$paginaInicial, $exibeNaoLiberado, $exibeContador,
	*										$perfilUsuario, $nivelConta, $desconsiderarZeramento )
	*		Mostra balancete de analitico, no formato HTML
	*		@param	$dataInicial			Data inicial
	*		@param	$dataFinal				Data final
	*		@param	$oidEmpresaCont 		OID da empresa contabil
	*		@param	$oidEmpresa		OID da empresa
	*		@param	$paginaInicial			Pagina inicial
	*		@param	$exibeNaoLiberado		se true, exibe os lancamentos nao liberados pelo contador
	*		@param	$exibeContador			se true, exibe dados do contador no final
	*		@param	$perfilUsuario			Perfil do usuario
	*		@param	$nivelConta		Nivel da conta
	*		@param	$desconsiderarZeramento Desconsidera zeramento
	*/
	function consultaBalanceteAnalitico($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $paginaInicial, $exibeNaoLiberado, $exibeContador, $perfilUsuario, $nivelConta, $desconsiderarZeramento) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$flagExibeNaoLiberado = ($exibeNaoLiberado == false) ? "S" : "N";

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();

		$this->geraBalanceteAnaliticoTXT($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $paginaInicial, $exibeNaoLiberado, $exibeContador, $perfilUsuario, $nivelConta, $desconsiderarZeramento);

		$empresa->pesquisaEmpresa($oidEmpresaCont);
		$lista = $conta->buscaConta($oidEmpresaCont, "");

		if ($lista[0][0] == "0")
			return false;
		else {

			// Seta variaveis auxiliares...
			$acaoAdicional = "javascript:window.print();";

			$voltar = $mostra == true ? "javascript:history.back();" : "javascript:history.back();";

			$infoAdicionais = "<font face=\"Verdana, Arial\" size=\"1\"><a href=\"../pdfs/" . TXT_BALANCETE . "\">";
			$infoAdicionais .= $msgCliqueAquiParaVisualizarTXT;
			$infoAdicionais .= "</a></font>\n<br><br>\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"oidEmpresa\" ";
			$infoAdicionais .= "value=\"" . $oidEmpresa . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"oidEmpresaCont\" ";
			$infoAdicionais .= "value=\"" . $oidEmpresaCont . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"dataInicial\" ";
			$infoAdicionais .= "value=\"" . $dataInicial . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"dataFinal\" ";
			$infoAdicionais .= "value=\"" . $dataFinal . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"paginaInicial\" ";
			$infoAdicionais .= "value=\"" . $paginaInicial . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"nivelConta\" ";
			$infoAdicionais .= "value=\"" . $nivelConta . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"exibeNaoLiberado\" ";
			$infoAdicionais .= "value=\"" . $exibeNaoLiberado . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"desconsiderarZeramento\" ";
			$infoAdicionais .= "value=\"" . $desconsiderarZeramento . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"exibeContador\" ";
			$infoAdicionais .= "value=\"" . $exibeContador . "\">\n";
			if ($perfilUsuario != "O") {
				$infoAdicionais .= "<input type=\"hidden\" name=\"controleNavegacao\" ";
				$infoAdicionais .= "value=\"2\">\n";
				$infoAdicionais .= "<input type=\"submit\" name=\"gerar\" class=\"bjanela\" ";
				$infoAdicionais .= "value=\"" . $botaoGerarPDF . "\">\n";
			} else {
				$infoAdicionais .= "<input type=\"hidden\" name=\"controleNavegacao\" ";
				$infoAdicionais .= "value=\"3\">\n";
				$infoAdicionais .= "<input type=\"submit\" name=\"gerar\" class=\"bjanela\" ";
				$infoAdicionais .= "value=\"" . $botaoVisualizarPDF . "\">\n";
			}
			$infoAdicionais .= "<input type=\"button\" name=\"imprimir\" class=\"bjanela\" ";
			$infoAdicionais .= "value=\"" . $botaoImprimir . "\" onClick=\"" . $acaoAdicional . "\">\n";

			// Cabecalho...
			$cabecalho = "<font face=\"Verdana, Arial\" color=\"#000099\" size=\"2\">";
			$cabecalho .= $empresa->getOidEmpresaCont() . " - " . $empresa->getRazaoSocial();
			$cabecalho .= "<br>";
			$cabecalho .= $dataInicial . " - " . $dataFinal . "</font><br><br>";

			// Cria relatorio...
			$relatorio = new RelatorioHTMLCw($oidEmpresa, $relatorioBalanceteAnalitico, $cabecalho);

			// Inicia apresentacao do relatorio...
			$relatorio->inicioRelatorio();

			$relatorio->mostraString("<table width=\"100%\" border=\"0\">");
			$relatorio->mostraString("<tr>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"12%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioConta);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"40%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioDescricao);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"12%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioSaldoAnterior);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"12%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioDebito);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"12%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioCredito);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"12%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioSaldoAtual);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("</tr>");

			$dataLimite = Data :: somaDia($dataInicial, -1);
			$contLinha = 0;

			// Comeca laco para apresentacao do relatorio...
			for ($indx = 0; $indx < sizeof($lista); $indx++) {

				$oidConta = explode(".", $lista[$indx][0]);

				$saldoAnterior = $this->buscaSaldoConta($oidConta[0], $dataLimite, $flagExibeNaoLiberado);

				$tipoSaldoAnterior = ($saldoAnterior < 0) ? " C" : " D";

				$debitoPeriodo = $this->buscaMovimentoConta($oidConta[0], $dataInicial, $dataFinal, $flagExibeNaoLiberado, "D", $desconsiderarZeramento);
				$creditoPeriodo = $this->buscaMovimentoConta($oidConta[0], $dataInicial, $dataFinal, $flagExibeNaoLiberado, "C", $desconsiderarZeramento);

				$saldoAtual = $saldoAnterior + $debitoPeriodo - $creditoPeriodo;
				$tipoSaldoAtual = ($saldoAtual < 0) ? " C" : " D";

				if ($saldoAnterior != 0 || $debitoPeriodo != 0 || $creditoPeriodo != 0) {

					if (String :: contaOcorrencia($lista[$indx][1], ".") <= $nivelConta) {

						// Define cor da linha
						$cor = ($contLinha % 2) == 0 ? "lcons1" : "lcons2";
						$contLinha++;

						$relatorio->mostraString("<tr>");

						// Codigo Sintetico...
						$relatorio->mostraString("<td align=\"left\" width=\"12%\" class=\"" . $cor . "\">");
						$relatorio->mostraString($lista[$indx][1]);
						$relatorio->mostraString("</td>");

						// Descricao...
						$relatorio->mostraString("<td align=\"left\" width=\"40%\" class=\"" . $cor . "\">");
						$relatorio->mostraString($lista[$indx][2]);
						$relatorio->mostraString("</td>");

						// Saldo Anterior...
						$relatorio->mostraString("<td align=\"right\" width=\"12%\" class=\"" . $cor . "\">");
						$relatorio->mostraString(Numero :: convReal($saldoAnterior) . $tipoSaldoAnterior);
						$relatorio->mostraString("</td>");

						// Debito...
						$relatorio->mostraString("<td align=\"right\" width=\"12%\" class=\"" . $cor . "\">");
						$relatorio->mostraString(Numero :: convReal($debitoPeriodo));
						$relatorio->mostraString("</td>");

						// Credito...
						$relatorio->mostraString("<td align=\"right\" width=\"12%\" class=\"" . $cor . "\">");
						$relatorio->mostraString(Numero :: convReal($creditoPeriodo));
						$relatorio->mostraString("</td>");

						// Saldo Atual...
						$relatorio->mostraString("<td align=\"right\" width=\"12%\" class=\"" . $cor . "\">");
						$relatorio->mostraString(Numero :: convReal($saldoAtual) . $tipoSaldoAtual);
						$relatorio->mostraString("</td>");

						$relatorio->mostraString("</tr>");
					}

				}

			} // Fim do indx...

			// Finaliza relatorio...
			$relatorio->mostraString("</table>");

			if (!empty ($exibeNaoLiberado) && $exibeNaoLiberado) {
				$relatorio->mostraString("<br><table class=\"pagina\" border=\"0\" width=\"100%\">");
				$relatorio->mostraString("<tr><td width=\"100%\" align=\"left\" class=\"lcons11\">");
				$relatorio->mostraString($msgConsLancamentosNaoLiberados);
				$relatorio->mostraString("</td></tr></table><br>");
			}

			// Testa se precisa exibir dados do contador...
			if (!empty ($exibeContador) && $exibeContador) {
				$relatorio->mostraString("<br><table class=\"pagina\" border=\"0\" width=\"100%\">");
				$relatorio->mostraString("<tr><td width=\"100%\" align=\"center\" class=\"lcons2\">");
				$relatorio->mostraString($empresa->getNomeContador());
				$relatorio->mostraString("</td></tr><tr><td width=\"100%\" align=\"center\" class=\"lcons2\">");
				$relatorio->mostraString($empresa->getRegistroContador());
				$relatorio->mostraString("</td></tr></table><br><br>");
			}

			$relatorio->fimRelatorio("cwConsAnalitico.php", $infoAdicionais, $voltar);

			return true;

		} // Fim da decisao de validacao do array

	}

	/**
	*		geraBalanceteAnaliticoTXT( $dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa,
	*										$paginaInicial, $exibeNaoLiberado, $exibeContador,
	*										$perfilUsuario, $nivelConta, $desconsiderarZeramento )
	*		Gera o balancete analítico, em formato TXT
	*		@param	$dataInicial			Data inicial
	*		@param	$dataFinal				Data final
	*		@param	$oidEmpresaCont 		OID da empresa contabil
	*		@param	$oidEmpresa		OID da empresa
	*		@param	$paginaInicial			Pagina inicial
	*		@param	$exibeNaoLiberado		se true, exibe os lancamentos nao liberados pelo contador
	*		@param	$exibeContador			se true, exibe dados do contador no final
	*		@param	$perfilUsuario			Perfil do usuario
	*		@param	$nivelConta		Nivel da conta
	*		@param	$desconsiderarZeramento Desconsidera zeramento
	*/
	function geraBalanceteAnaliticoTXT($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $paginaInicial, $exibeNaoLiberado, $exibeContador, $perfilUsuario, $nivelConta, $desconsiderarZeramento) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$flagExibeNaoLiberado = ($exibeNaoLiberado == false) ? "S" : "N";

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();

		$empresa->pesquisaEmpresa($oidEmpresaCont);
		$lista = $conta->buscaConta($oidEmpresaCont, "");

		if ($lista[0][0] == "0")
			return false;
		else {

			// Cria relatorio...
			$relatorioTXT = new RelatorioTXT();
			$relatorioTXT->setConf("../pdfs/" . TXT_BALANCETE);

			// Inicia apresentacao do relatorio...
			$relatorioTXT->inicioRelatorio();

			$dataLimite = Data :: somaDia($dataInicial, -1);
			$contadorLinhas = 70;
			$contadorPagina = $paginaInicial -1;
			// Comeca laco para apresentacao do relatorio...
			for ($indx = 0; $indx < sizeof($lista); $indx++) {

				$oidConta = explode(".", $lista[$indx][0]);

				$saldoAnterior = $this->buscaSaldoConta($oidConta[0], $dataLimite, $flagExibeNaoLiberado);

				$tipoSaldoAnterior = ($saldoAnterior < 0) ? " C" : " D";

				$debitoPeriodo = $this->buscaMovimentoConta($oidConta[0], $dataInicial, $dataFinal, $flagExibeNaoLiberado, "D", $desconsiderarZeramento);
				$creditoPeriodo = $this->buscaMovimentoConta($oidConta[0], $dataInicial, $dataFinal, $flagExibeNaoLiberado, "C", $desconsiderarZeramento);

				$saldoAtual = $saldoAnterior + $debitoPeriodo - $creditoPeriodo;
				$tipoSaldoAtual = ($saldoAtual < 0) ? " C" : " D";

				if ($saldoAnterior != 0 || $debitoPeriodo != 0 || $creditoPeriodo != 0) {

					if (String :: contaOcorrencia($lista[$indx][1], ".") <= $nivelConta) {

						if ($contadorLinhas > 52) {
							$contadorPagina++;
							$linhaCabec = str_pad("=", 132, "=") . CRLF;
							$relatorioTXT->mostraString(chr(15) . str_pad(" ", 48) . "B A L A N C E T E" . str_pad(" ", 4) . "A N A L I T I C O" . CRLF);
							$relatorioTXT->mostraString(String :: removeAcento(sprintf("%-40s", $empresa->getRazaoSocial())) . str_pad(" ", 20) . "Periodo de " . $dataInicial . " a " . $dataFinal . str_pad(" ", 31) . "FL." . str_pad($contadorPagina, 4, "0", STR_PAD_LEFT) . CRLF);
							$relatorioTXT->mostraString($linhaCabec);
							$relatorioTXT->mostraString(str_pad(" ", 4) . "Codigo" . str_pad(" ", 8) . "D e s c r i c a o" . str_pad(" ", 26) . "Saldo Anterior" . str_pad(" ", 15) . "Debito" . str_pad(" ", 11) . "Credito" . str_pad(" ", 5) . "Saldo Atual" . CRLF);
							$relatorioTXT->mostraString($linhaCabec);
							$contadorLinhas = 0;
						}

						// Codigo Sintetico...
						$relatorioTXT->mostraString($lista[$indx][1]);
						$relatorioTXT->mostraString(str_pad(" ", 4));

						$descricao = sprintf("%-40s", $lista[$indx][2]);

						// Descricao...
						$relatorioTXT->mostraString(String :: removeAcento($descricao));
						$relatorioTXT->mostraString(str_pad(" ", 4));

						// Saldo Anterior...
						$stringSaldoAnterior = sprintf("%15s", Numero :: convReal($saldoAnterior) . $tipoSaldoAnterior);

						$relatorioTXT->mostraString($stringSaldoAnterior);
						$relatorioTXT->mostraString(str_pad(" ", 4));

						// Debito...
						$stringDebito = sprintf("%15s", Numero :: convReal($debitoPeriodo));
						$relatorioTXT->mostraString($stringDebito);
						$relatorioTXT->mostraString(str_pad(" ", 3));

						// Credito...
						$stringCredito = sprintf("%15s", Numero :: convReal($creditoPeriodo));
						$relatorioTXT->mostraString($stringCredito);
						$relatorioTXT->mostraString(str_pad(" ", 3));

						// Saldo Atual...
						$stringSaldo = sprintf("%15s", Numero :: convReal($saldoAtual) . $tipoSaldoAtual);
						$relatorioTXT->mostraString($stringSaldo);

						$relatorioTXT->mostraString(CRLF);
						$contadorLinhas++;
						if ($contadorLinhas > 52) {
							$relatorioTXT->mostraString(FF);
						}
					}

				}

			} // Fim do indx...

			// Finaliza relatorio...

			if (!empty ($exibeNaoLiberado) && $exibeNaoLiberado) {
				$relatorioTXT->mostraString($msgConsLancamentosNaoLiberados);
			}

			// Testa se precisa exibir dados do contador...
			if (!empty ($exibeContador) && $exibeContador) {
				$relatorioTXT->mostraString(CRLF);
				$relatorioTXT->mostraString(str_pad(" ", 40));
				$relatorioTXT->mostraString(String :: removeAcento($empresa->getNomeContador()));
				$relatorioTXT->mostraString(CRLF);
				$relatorioTXT->mostraString(str_pad(" ", 40));
				$relatorioTXT->mostraString($empresa->getRegistroContador());
			}

			$relatorioTXT->mostraString(FF);

			$relatorioTXT->fimRelatorio();

			return true;

		} // Fim da decisao de validacao do array

	}

	/**
	*		consultaBalanceteAnaliticoPDF( $dataInicial, $dataFinal, $oidEmpresaCont,
	*						$oidEmpresa, $paginaInicial = 1, $exibeContador,
	*								$nivelConta, $desconsiderarZeramento = false )
	*		Mostra consulta de balancete analitico, somente os contabilizados, em formato PDF
	*		@param	$dataInicial			Data inicial
	*		@param	$dataFinal				Data final
	*		@param	$oidEmpresaCont 		OID da empresa contabil
	*		@param	$oidEmpresa		OID da empresa
	*		@param	$paginaInicial			Pagina inicial
	*		@param	$exibeContador			Exibe dados do contador
	*		@param	$nivelConta		Nivel da conta a ser consultada
	*		@param	$desconsiderarZeramento Desconsiderar zeramentos (default = false)
	*/
	function consultaBalanceteAnaliticoPDF($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $paginaInicial = 1, $exibeContador, $nivelConta, $desconsiderarZeramento = false) {

		// Seta variaveis que possam ser utilizadas...
		$controleLinha = 1;
		$flagPreenchido = false;
		$oidContaRecebida = $oidConta;

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();

		$empresa->pesquisaEmpresa($oidEmpresaCont);
		$lista = $conta->buscaConta($oidEmpresaCont, "");

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties"; // 18
		$larguraColunas = array (
			20,
			70,
			20,
			20,
			20,
			20,
			20
		);
		$cabecalho = array (
			$relatorioConta,
			$relatorioDescricao,
			$relatorioSaldoAnterior,
			$relatorioDebito,
			$relatorioCredito,
			$relatorioSaldoAtual
		);

		// Cria relatorio...
		$relatorio = new RelatorioPDFCw($oidEmpresa, $relatorioBalanceteAnalitico, $oidEmpresaCont . " - " . $empresa->getRazaoSocial() . " - " . $dataInicial . " a " . $dataFinal, $tituloSistema, $campoTextoPagina, $paginaInicial, true, $larguraColunas, $cabecalho);

		// Gera instancia de documento...
		$relatorio->getInstancia();

		// Seta margens do documento
		$relatorio->document->SetMargins(10, 10, 10);
		$relatorio->document->Open();
		$relatorio->document->AliasNbPages();
		$relatorio->document->SetAutoPageBreak(true, 10);
		$relatorio->document->AddPage();

		// Monta cabecalho da tabela...
		$relatorio->document->setFonte($relatorio->fonteTituloTabela);
		$relatorio->document->setCorTexto($relatorio->corTituloTabela);
		$relatorio->document->setCorFundo($relatorio->corVerde);
		$relatorio->document->setCorBorda($relatorio->corBordaTabela);

		$relatorio->document->SetLineWidth(.2);
		$relatorio->document->setCorFundo($relatorio->corVerde);
		$relatorio->document->setCorTexto($relatorio->corTextoTabela);
		$relatorio->document->setFonte($relatorio->fonteTextoTabela);

		$dataLimite = Data :: somaDia($dataInicial, -1);

		// Comeca laco para apresentacao do relatorio...
		$relatorio->document->setCorFundo($relatorio->corLaranja);
		for ($indx = 0; $indx < sizeof($lista); $indx++) {

			// Controla preenchimento (automato finito - :-)...
			$oidConta = explode(".", $lista[$indx][0]);

			$saldoAnterior = $this->buscaSaldoConta($oidConta[0], $dataLimite, "S");
			$tipoSaldoAnterior = ($saldoAnterior < 0) ? " C" : " D";

			$debitoPeriodo = $this->buscaMovimentoConta($oidConta[0], $dataInicial, $dataFinal, "S", "D", $desconsiderarZeramento);
			$creditoPeriodo = $this->buscaMovimentoConta($oidConta[0], $dataInicial, $dataFinal, "S", "C", $desconsiderarZeramento);

			$saldoAtual = $saldoAnterior + $debitoPeriodo - $creditoPeriodo;
			$tipoSaldoAtual = ($saldoAtual < 0) ? " C" : " D";

			if ($saldoAnterior != 0 || $debitoPeriodo != 0 || $creditoPeriodo != 0) {

				$flagPreenchido = !$flagPreenchido;

				if (String :: contaOcorrencia($lista[$indx][1], ".") <= $nivelConta) {

					// Imprime os dados...
					$relatorio->document->Cell($larguraColunas[0], 4, substr($lista[$indx][1], 0, 29), "LR", 0, "L", $flagPreenchido);
					$relatorio->document->Cell($larguraColunas[1], 4, substr($lista[$indx][2], 0, 40), "LR", 0, "L", $flagPreenchido);
					$relatorio->document->Cell($larguraColunas[2], 4, Numero :: convReal($saldoAnterior) . $tipoSaldoAnterior, "LR", 0, "R", $flagPreenchido);
					$relatorio->document->Cell($larguraColunas[3], 4, Numero :: convReal($debitoPeriodo), "LR", 0, "R", $flagPreenchido);
					$relatorio->document->Cell($larguraColunas[4], 4, Numero :: convReal($creditoPeriodo), "LR", 0, "R", $flagPreenchido);
					$relatorio->document->Cell($larguraColunas[4], 4, Numero :: convReal($saldoAtual) . $tipoSaldoAtual, "LR", 0, "R", $flagPreenchido);

					// Salta linha...
					$relatorio->document->Ln();

					// Incrementa linha...
					$controleLinha++;

					// Se terminou pagina...
					if (false) { // ( $controleLinha > 52 ) {
						$relatorio->document->AddPage();

						// Monta cabecalho da tabela...
						$relatorio->document->setFonte($relatorio->fonteTituloTabela);
						$relatorio->document->setCorTexto($relatorio->corTituloTabela);
						$relatorio->document->setCorFundo($relatorio->corVerde);
						$relatorio->document->setCorBorda($relatorio->corBordaTabela);

						$relatorio->document->SetLineWidth(.2);

						for ($indx = 0; $indx < count($cabecalho); $indx++)
							$relatorio->document->Cell($larguraColunas[$indx], 4, $cabecalho[$indx], 1, 0, "C", 1);
						$relatorio->document->Ln();

						$relatorio->document->setCorFundo($relatorio->corVerde);
						$relatorio->document->setCorTexto($relatorio->corTextoTabela);
						$relatorio->document->setFonte($relatorio->fonteTextoTabela);

						$controleLinha = 1;

					}
				}

			}

		} // Fim do indx...

		// Testa se tem que colocar dados da contadora...
		if (!empty ($exibeContador) && $exibeContador) {
			$relatorio->document->Ln();
			$relatorio->document->Ln();
			$relatorio->document->setCorTexto($relatorio->corTextoTabela);
			$relatorio->document->setFonte($relatorio->fonteTextoTabela);
			$relatorio->document->Cell(0, 0, $empresa->getNomeContador() . " - " . $empresa->getRegistroContador(), 0, 1, "C", 0);
			$relatorio->document->Ln();
		}

		$relatorio->document->setCorFundo($relatorio->corVerde);
		$relatorio->document->setCorTexto($relatorio->corTextoTabela);
		$relatorio->document->setFonte($relatorio->fonteTextoTabela);

		$relatorio->document->closeDoc("../pdfs/" . PDF_BALANCETE);

		// Exibe mensagem...
		$msg = new MsgCw($msgCliqueAquiParaVisualizar, "../imagens/contabil.jpg", "javascript:history.go(-2);");
		$msg->mostraMsgLink("../pdfs/" . PDF_BALANCETE, true);
		exit ();

	}

	/**
	*		geraRazaoAnaliticoTXT( $dataInicial, $dataFinal, $oidEmpresaCont, $oidConta,
	*								$oidEmpresa, $paginaInicial, $exibeNaoLiberado,
	*								$exibeContador, $perfilUsuario, $acompanhamento = false )
	*		Mostra consulta de razao analitico, no formato TXT
	*		@param	$dataInicial	  Data inicial
	*		@param	$dataFinal			  Data final
	*		@param	$oidEmpresaCont   OID da empresa contabil
	*		@param	$oidConta		  OID da conta
	*		@param	$oidEmpresa   OID da empresa
	*		@param	$paginaInicial	  Pagina inicial
	*		@param	$exibeNaoLiberado se true, exibe os lancamentos nao liberados pelo contador
	*		@param	$exibeContador	  se true, exibe dados do contador no final
	*		@param	$perfilUsuario	  Perfil do usuario
	*		@param	$acompanhamento   Acompanhamento do orcamento (default = false)
	*/
	function geraRazaoAnaliticoTXT($dataInicial, $dataFinal, $oidEmpresaCont, $oidConta, $oidEmpresa, $paginaInicial, $exibeNaoLiberado, $exibeContador, $perfilUsuario, $acompanhamento = false) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$flagExibeNaoLiberado = ($exibeNaoLiberado == false) ? "S" : "N";
		$exibeNaoLiberado = ($exibeNaoLiberado == false) ? 0 : 1;

		if ($acompanhamento == true)
			$perfilUsuario = "O";

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();

		// Alteração - Múltiplas Contas (18.07.2005)
		$contaSolicitada = new Conta();
		$contaSolicitada->pesquisaConta($oidConta);
		$listaContasSolic = $conta->buscaConta($oidEmpresaCont, $contaSolicitada->getCodigoSintetico(), 7);
		// ------------------- Fim da Alteração

		$empresa->pesquisaEmpresa($oidEmpresaCont);

		// Cria relatorio...
		$relatorioTXT = new RelatorioTXT();
		$relatorioTXT->setConf("../pdfs/" . TXT_RAZAO);

		// Inicia apresentacao do relatorio...
		$relatorioTXT->inicioRelatorio();

		$dataLimite = Data :: somaDia($dataInicial, -1);

		$contadorPagina = $paginaInicial -1;
		$listaItensLancamento = $itemLancamento->buscaItemLancamentoConta($oidEmpresaCont, $contaSolicitada->getCodigoSintetico(), $dataInicial, $dataFinal, $exibeNaoLiberado, 1);

		$contadorLinhas = 70;
		for ($indContaContabil = 0; $indContaContabil < sizeof($listaContasSolic); $indContaContabil++) {

			$oidConta = $listaContasSolic[$indContaContabil][1];
			$oidContaSDV = explode(".", $oidConta);

			$saldoAnterior = $this->buscaSaldoConta($oidContaSDV[0], $dataLimite, $exibeNaoLiberado);
			$tipoSaldoAnterior = ($saldoAnterior < 0) ? " C" : " D";

			$numeroLancamentos = 0;
			for ($indice = 0; $indice < sizeof($listaItensLancamento); $indice++) {
				if ($listaItensLancamento[$indice][2] == $oidContaSDV[0])
					$numeroLancamentos++;
			}
			$saldoAnterior = $this->buscaSaldoConta($oidContaSDV[0], $dataLimite, $flagExibeNaoLiberado);
			if ($saldoAnterior != 0.00)
				$numeroLancamentos = 1;

			if (($numeroLancamentos > 0) && sizeof($listaContasSolic) > 0) {

				$conta->pesquisaContaSemDV($oidContaSDV[0]);

				$dataLimite = Data :: somaDia($dataInicial, -1);

				$saldoAnterior = $this->buscaSaldoConta($oidContaSDV[0], $dataLimite, $flagExibeNaoLiberado);
				$tipoSaldoAnterior = ($saldoAnterior < 0) ? " C" : " D";

				$saldoAtual = $saldoAnterior;
				$tipoSaldoAtual = ($saldoAtual < 0) ? " C" : " D";
				$flagCor = true;
				// Comeca laco para apresentacao do relatorio...

				for ($indx = 0; $indx < sizeof($listaItensLancamento); $indx++) {

					// Monta a string para gravar no arquivo .TXT..
					$codigoLancamento = sprintf("%10s", $listaItensLancamento[$indx][1]);
					$dataLancamento = sprintf("%-12s", $listaItensLancamento[$indx][9]);
					if ($listaItensLancamento[$indx][5] == "D") {
						$debito = sprintf("%12s", Numero :: convReal($listaItensLancamento[$indx][4]));
						$credito = str_pad(" ", 14);
					} else {
						$debito = str_pad(" ", 12);
						$credito = sprintf("%14s", Numero :: convReal($listaItensLancamento[$indx][4]));
					}

					// Testa se tem que imprimir um historico em varias linhas
					$numeroLinhas = 1;
					if (strlen($listaItensLancamento[$indx][3]) > 40) {
						// Corta em varios pedacos de 40 bytes
						$numeroLinhas = strlen($listaItensLancamento[$indx][3]) / 40;
						$numeroLinhas = ceil($numeroLinhas); // Se for 1,1 entao eh 2 linhas
					}
					// testa se for e a conta a ser consultada...

					if ($listaItensLancamento[$indx][2] == $oidContaSDV[0]) {
						for ($indz = 0; $indz < $numeroLinhas; $indz++) {
							$historico = sprintf("%-40s", substr($listaItensLancamento[$indx][3], ($indz +1) * 40 - 40, 40));
							$historico = str_replace(chr(13), "", $historico);
							$historico = str_replace(chr(10), " ", $historico);
							$historico = str_pad($historico, 40);
							$historico = substr($historico, 0, 40);

							// Se for a primeira linha do lancamento, deve aparecer data e codigo
							if ($indz == 0) {
								$linha = $codigoLancamento;
								$linha .= "   " . $dataLancamento . " ";
							} else {
								$linha = str_pad(" ", 26);
							}

							$linha .= $historico;
							// Retira os caracteres especiais da linha
							$linha = String :: removeAcento($linha);

							if ($contadorLinhas > 52) {
								$contadorPagina++;
								$linhaCabec = str_pad("=", 132, "=") . CRLF;
								$relatorioTXT->mostraString(chr(15) . str_pad(" ", 55) . "R A Z A O" . str_pad(" ", 4) . "A N A L I T I C O" . CRLF);
								$relatorioTXT->mostraString(String :: removeAcento(sprintf("%-40s", $empresa->getRazaoSocial())) . str_pad(" ", 20) . "Periodo de " . $dataInicial . " a " . $dataFinal . str_pad(" ", 31) . "FL." . str_pad($contadorPagina, 4, "0", STR_PAD_LEFT) . CRLF);
								$relatorioTXT->mostraString($linhaCabec);
								$relatorioTXT->mostraString(str_pad(" ", 4) . "Codigo" . str_pad(" ", 6) . "Data" . str_pad(" ", 10) . "H i s t o r i c o" . str_pad(" ", 25) . "Debito" . str_pad(" ", 7) . "Credito" . str_pad(" ", 8) . "S A L D O D/C" . CRLF);
								$relatorioTXT->mostraString($linhaCabec);
								$relatorioTXT->mostraString(String :: removeAcento("Conta Contabil....: " . $conta->getCodigoSintetico() . " - " . $conta->getDescricao()) . " (" . $conta->getOidConta() . "." . $conta->getDV() . ")" . CRLF);

								// Imprime o saldo anterior...
								$relatorioTXT->mostraString(str_pad(" ", 31) . $relatorioSaldoAnterior);

								$tipoSaldoAtual = ($saldoAtual < 0) ? "  C" : "  D";
								$relatorioTXT->mostraString(str_pad(" ", 50, ".") . sprintf("%14s", Numero :: convReal($saldoAtual)) . $tipoSaldoAtual . CRLF);
								$ultimaImpressa = $conta->getCodigoSintetico();
								$contadorLinhas = 0;
							}
							if ($conta->getCodigoSintetico() != $ultimaImpressa) {
								$relatorioTXT->mostraString(str_pad("-", 132, "-") . CRLF);
								$relatorioTXT->mostraString("  " . CRLF);
								$relatorioTXT->mostraString(String :: removeAcento("Conta Contabil....: " . $conta->getCodigoSintetico() . " - " . $conta->getDescricao()) . " (" . $conta->getOidConta() . "." . $conta->getDV() . ")" . CRLF);
								// Imprime o saldo anterior...
								$relatorioTXT->mostraString(str_pad(" ", 31) . $relatorioSaldoAnterior);
								$tipoSaldoAtual = ($saldoAtual < 0) ? "  C" : "  D";
								$relatorioTXT->mostraString(str_pad(" ", 50, ".") . sprintf("%14s", Numero :: convReal($saldoAtual)) . $tipoSaldoAtual . CRLF);
								$contadorLinhas = $contadorLinhas +4;
								$ultimaImpressa = $conta->getCodigoSintetico();
							}

							if ($indz == ($numeroLinhas -1)) { // Se eh a ultima linha de historico
								if ($listaItensLancamento[$indx][5] == "C")
									$saldoAtual = $saldoAtual - $listaItensLancamento[$indx][4];
								else
									$saldoAtual = $saldoAtual + $listaItensLancamento[$indx][4];
								$tipoSaldoAtual = ($saldoAtual < 0) ? "C" : "D";

								$linha .= $debito;
								$linha .= $credito;
								$linha .= str_pad(" ", 3) . sprintf("%14s", Numero :: convReal($saldoAtual)) . "  " . $tipoSaldoAtual;
							}

							$linha .= CRLF;
							$relatorioTXT->mostraString($linha);
							$contadorLinhas++;
							if ($contadorLinhas > 52) // && ($indz < ($numeroLinhas -1)) )
								$relatorioTXT->mostraString(FF);
						} // fim do for indz

					}

				} // Fim do for indx...

				if ($contadorLinhas > 52) {
					$contadorPagina++;
					$linhaCabec = str_pad("=", 132, "=") . CRLF;
					$relatorioTXT->mostraString(chr(15) . str_pad(" ", 55) . "R A Z A O" . str_pad(" ", 4) . "A N A L I T I C O" . CRLF);
					$relatorioTXT->mostraString(String :: removeAcento(sprintf("%-40s", $empresa->getRazaoSocial())) . str_pad(" ", 20) . "Periodo de " . $dataInicial . " a " . $dataFinal . str_pad(" ", 31) . "FL." . str_pad($contadorPagina, 4, "0", STR_PAD_LEFT) . CRLF);
					$relatorioTXT->mostraString(String :: removeAcento("Conta Contabil....: " . $conta->getCodigoSintetico() . " - " . $conta->getDescricao()) . CRLF);
					$relatorioTXT->mostraString($linhaCabec);
					$relatorioTXT->mostraString(str_pad(" ", 4) . "Codigo" . str_pad(" ", 6) . "Data" . str_pad(" ", 10) . "H i s t o r i c o" . str_pad(" ", 25) . "Debito" . str_pad(" ", 7) . "Credito" . str_pad(" ", 8) . "S A L D O D/C" . CRLF);
					$relatorioTXT->mostraString($linhaCabec);
					// Imprime o saldo anterior...
					$relatorioTXT->mostraString(str_pad(" ", 31) . $relatorioSaldoAnterior);
					$tipoSaldoAtual = ($saldoAtual < 0) ? "  C" : "  D";
					$relatorioTXT->mostraString(str_pad(" ", 50, ".") . sprintf("%14s", Numero :: convReal($saldoAtual)) . $tipoSaldoAtual . CRLF);
					$contadorLinhas = 0;
				}

				if ($conta->getCodigoSintetico() != $ultimaImpressa) {
					$relatorioTXT->mostraString(str_pad("-", 132, "-") . CRLF);
					$relatorioTXT->mostraString("  " . CRLF);
					$relatorioTXT->mostraString(String :: removeAcento("Conta Contabil....: " . $conta->getCodigoSintetico() . " - " . $conta->getDescricao()) . " (" . $conta->getOidConta() . "." . $conta->getDV() . ")" . CRLF);
					// Imprime o saldo anterior...
					$relatorioTXT->mostraString(str_pad(" ", 31) . $relatorioSaldoAnterior);
					$tipoSaldoAtual = ($saldoAtual < 0) ? "  C" : "  D";
					$relatorioTXT->mostraString(str_pad(" ", 50, ".") . sprintf("%14s", Numero :: convReal($saldoAtual)) . $tipoSaldoAtual . CRLF);
					$contadorLinhas = $contadorLinhas +5;
					$ultimaImpressa = $conta->getCodigoSintetico();
				}
				$relatorioTXT->mostraString(str_pad(" ", 31) . $relatorioSaldoFinal);

				$tipoSaldoAtual = ($saldoAtual < 0) ? "C" : "D";
				$relatorioTXT->mostraString(str_pad(" ", 53, ".") . sprintf("%14s", Numero :: convReal($saldoAtual)) . str_pad(" ", 2) . $tipoSaldoAtual . CRLF);
				$contadorLinhas = $contadorLinhas +1;
				if ($contadorLinhas > 52)
					$relatorioTXT->mostraString(FF);

				// Finaliza relatorio...

			} // Fim da decisao de validacao do array

		} //  Fim do FOR para as Contas Contábeis
		$relatorioTXT->mostraString(FF);
		$relatorioTXT->fimRelatorio();

	}

	/**
	*		consultaRazaoAnaliticoPDF( $dataInicial, $dataFinal, $oidEmpresaCont, $oidConta,
	*												$oidEmpresa, $paginaInicial = 1, $exibeContador )
	*		Mostra consulta de diario de lancamentos, somente os contabilizados, em formato PDF
	*		@param	$dataInicial	Data inicial
	*		@param	$dataFinal			Data final
	*		@param	$oidEmpresaCont OID da empresa contabil
	*		@param	$oidConta		OID da conta
	*		@param	$oidEmpresa	OID da empresa
	*		@param	$paginaInicial	Pagina inicial
	*		@param	$exibeContador	Exibe dados do contador
	*/
	function consultaRazaoAnaliticoPDF($dataInicial, $dataFinal, $oidEmpresaCont, $oidConta, $oidEmpresa, $paginaInicial = 1, $exibeContador) {

		// Seta variaveis que possam ser utilizadas...
		$controleLinha = 1;
		$flagPreenchido = false;
		$exibeNaoLiberado = false;

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();

		// Alteração - Múltiplas Contas (18.07.2005)
		$contaSolicitada = new Conta();
		$contaSolicitada->pesquisaConta($oidConta);
		$listaContasSolic = $conta->buscaConta($oidEmpresaCont, $contaSolicitada->getCodigoSintetico(), 7);
		// ------------------- Fim da Alteração

		$empresa->pesquisaEmpresa($oidEmpresaCont);
		$nomeEmpresa = $empresa->getRazaoSocial();
		$contadorPagina = $paginaInicial -1;
		$oidConta = $listaContasSolic[0][1];
		$oidContaSDV = explode(".", $oidConta);
		$conta->pesquisaContaSemDV($oidContaSDV);
		$listaItensLancamento = $itemLancamento->buscaItemLancamentoConta($oidEmpresaCont, $contaSolicitada->getCodigoSintetico(), $dataInicial, $dataFinal, $exibeNaoLiberado, 1);

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$larguraColunas = array (
			10,
			15,
			85,
			25,
			25,
			25
		);
		$confLista = array ();
		$confLista[] = array (
			0,
			"R",
			0
		);
		$confLista[] = array (
			0,
			"C",
			0
		);
		$confLista[] = array (
			0,
			"J",
			0
		);
		$confLista[] = array (
			0,
			"R",
			0
		);
		$confLista[] = array (
			0,
			"R",
			0
		);
		$confLista[] = array (
			0,
			"R",
			0
		);

		$cabecalho = array (
			$relatorioCodigo,
			$relatorioData,
			$relatorioHistorico,
			$relatorioDebito,
			$relatorioCredito,
			$relatorioSaldo
		);

		// Cria relatorio...
		$relatorio = new RelatorioPDFCw($oidEmpresa, $relatorioRazao, $oidEmpresaCont . " - " . $nomeEmpresa . "  " . $dataInicial . " a " . $dataFinal . "*" . $conta->getCodigoSintetico() . " - " . $conta->getDescricao(), $tituloSistema, $campoTextoPagina, $paginaInicial, true, $larguraColunas, $cabecalho);

		// Gera instancia de documento...
		$relatorio->getInstancia();

		// Seta margens do documento
		$relatorio->document->SetMargins(10, 10, 10);
		$relatorio->document->Open();
		$relatorio->document->AliasNbPages();
		$relatorio->document->SetAutoPageBreak(true, 10);

		$relatorio->document->SetLineWidth(.2);
		$relatorio->document->SetWidths($larguraColunas);
		$relatorio->document->SetDrawColor(0, 0, 0);

		$relatorio->document->setCorFundo(array (
			255,
			255,
			255
		));
		$relatorio->document->setCorTexto($relatorio->corTextoTabela);
		$relatorio->document->setFonte($relatorio->fonteTextoTabela);

		$dataLimite = Data :: somaDia($dataInicial, -1);

		for ($indContaContabil = 0; $indContaContabil < sizeof($listaContasSolic); $indContaContabil++) {

			$oidConta = $listaContasSolic[$indContaContabil][1];
			$oidContaSDV = explode(".", $oidConta);
			$conta->pesquisaContaSemDV($oidContaSDV[0]);

			$saldoAnterior = $this->buscaSaldoConta($oidContaSDV[0], $dataLimite, $exibeNaoLiberado);
			$tipoSaldoAnterior = ($saldoAnterior < 0) ? " C" : " D";

			$totalDebito = $totalCredito = 0.0;
			$numeroLancamentos = 0;
			for ($indice = 0; $indice < sizeof($listaItensLancamento); $indice++) {
				if ($listaItensLancamento[$indice][2] == $oidContaSDV[0])
					$numeroLancamentos++;
			}
			if ($saldoAnterior != 0.00)
				$numeroLancamentos = 1;
			if (($numeroLancamentos > 0) && sizeof($listaContasSolic) > 0) {

				$oidConta = $listaContasSolic[$indContaContabil][1];
				$oidContaSDV = explode(".", $oidConta);
				$conta->pesquisaContaSemDV($oidContaSDV[0]);
				$codigoSinteticoRel = $conta->getCodigoSintetico();
				$descricaoRel = $conta->getDescricao();

				$relatorio->document->setSubTitulo($nomeEmpresa . "-" . $dataInicial . " a " . $dataFinal . "*" . $codigoSinteticoRel . "-" . $descricaoRel . " (". $oidConta .")" );

				$relatorio->document->AddPage();

				$tipoSaldoAnterior = ($saldoAnterior < 0) ? " C" : " D";

				$saldoAtual = $saldoAnterior;
				$tipoSaldoAtual = ($saldoAtual < 0) ? " C" : " D";

				// Imprime Saldo anterior...
				$relatorio->document->setCorFundo(array (
					255,
					255,
					255
				));
				$relatorio->document->setCorTexto($relatorio->corTextoTabela);
				$relatorio->document->Cell($larguraColunas[0], 4, " ", "LR", 0, "R", true);
				$relatorio->document->Cell($larguraColunas[1], 4, " ", "LR", 0, "L", true);
				$relatorio->document->Cell($larguraColunas[2], 4, $relatorioSaldoAnterior, "LR", 0, "L", true);
				$relatorio->document->Cell($larguraColunas[3], 4, " ", "LR", 0, "R", true);
				$relatorio->document->Cell($larguraColunas[4], 4, " ", "LR", 0, "R", true);
				$relatorio->document->Cell($larguraColunas[5], 4, Numero :: convReal($saldoAnterior) . $tipoSaldoAnterior, "LR", 0, "R", true);

				// Salta linha...
				$relatorio->document->Ln();

				// Comeca laco para impressao do relatorio...
				for ($indx = 0; $indx < sizeof($listaItensLancamento); $indx++) {

					// testa se for e a conta a ser consultada...
					if ($listaItensLancamento[$indx][2] == $oidContaSDV[0]) {

						if ($listaItensLancamento[$indx][5] == "C")
							$saldoAtual = $saldoAtual - $listaItensLancamento[$indx][4];
						else
							$saldoAtual = $saldoAtual + $listaItensLancamento[$indx][4];

						$tipoSaldoAtual = ($saldoAtual < 0) ? " C" : " D";
						$textoSaldo = Numero :: convReal($saldoAtual) . $tipoSaldoAtual;
						$valorDebito = $listaItensLancamento[$indx][5] == "D" ? Numero :: convReal($listaItensLancamento[$indx][4]) : " ";
						$valorCredito = $listaItensLancamento[$indx][5] == "C" ? Numero :: convReal($listaItensLancamento[$indx][4]) : " ";

						// Imprime os dados...
						$relatorio->document->Row(array (
							$listaItensLancamento[$indx][1],
							$listaItensLancamento[$indx][9],
							String :: removeCRLF($listaItensLancamento[$indx][3]
						), $valorDebito, $valorCredito, $textoSaldo), $confLista);

					} // Fim do teste de comparacao de conta...
				} // Fim do indx
				// Imprime Saldo atual...
				$relatorio->document->setCorFundo($relatorio->corFundoTituloTabela);
				$relatorio->document->setCorTexto($relatorio->corTituloTabela);
				$tipoSaldoAtual = ($saldoAtual < 0) ? " C" : " D";
				$relatorio->document->Cell($larguraColunas[0], 4, " ", "LR", 0, "R", true);
				$relatorio->document->Cell($larguraColunas[1], 4, " ", "LR", 0, "L", true);
				$relatorio->document->Cell($larguraColunas[2], 4, $relatorioSaldoFinal, "LR", 0, "C", true);
				$relatorio->document->Cell($larguraColunas[3], 4, " ", "LR", 0, "R", true);
				$relatorio->document->Cell($larguraColunas[4], 4, " ", "LR", 0, "R", true);
				$relatorio->document->Cell($larguraColunas[5], 4, Numero :: convReal($saldoAtual) . $tipoSaldoAtual, "LR", 0, "R", true);

				// Salta linha...
				$relatorio->document->Ln();
				$relatorio->document->setCorFundo(array (
					255,
					255,
					255
				));
				$relatorio->document->setCorTexto($relatorio->corTextoTabela);

				$relatorio->document->setCorFundo(array (
					255,
					255,
					255
				));
				$relatorio->document->setCorTexto($relatorio->corTextoTabela);

				$relatorio->document->setCorFundo($relatorio->corFundoTabela);
				$relatorio->document->setCorTexto($relatorio->corTextoTabela);
				$relatorio->document->setFonte($relatorio->fonteTextoTabela);
			}

		}

		// Testa se tem que colocar dados da contadora...
		if (!empty ($exibeContador) && $exibeContador) {

			$relatorio->document->Ln();
			$relatorio->document->Ln();
			$relatorio->document->setCorTexto($relatorio->corTextoTabela);
			$relatorio->document->setFonte($relatorio->fonteTextoTabela);
			$relatorio->document->Cell(0, 0, $empresa->getNomeContador() . " - " . $empresa->getRegistroContador(), 0, 1, "C", 0);
			$relatorio->document->Ln();
		}

		$relatorio->document->closeDoc("../pdfs/" . PDF_RAZAO);
		// Exibe mensagem...
		$msg = new MsgCw($msgCliqueAquiParaVisualizar, "../imagens/contabil.jpg", "javascript:history.go(-2);");
		$msg->mostraMsgLink("../pdfs/" . PDF_RAZAO, true);
		exit ();
	}

	/**
	*		consultaRazaoAnalitico( $dataInicial, $dataFinal, $oidEmpresaCont, $oidConta,
	*								$oidEmpresa, $paginaInicial, $exibeNaoLiberado,
	*								$exibeContador, $perfilUsuario, $acompanhamento = false, $desconsiderarZeramento )
	*		Mostra consulta de razao analitico, no formato HTML
	*		@param	$dataInicial	  Data inicial
	*		@param	$dataFinal			  Data final
	*		@param	$oidEmpresaCont   OID da empresa contabil
	*		@param	$oidConta		  OID da conta
	*		@param	$oidEmpresa   OID da empresa
	*		@param	$paginaInicial	  Pagina inicial
	*		@param	$exibeNaoLiberado se true, exibe os lancamentos nao liberados pelo contador
	*		@param	$exibeContador	  se true, exibe dados do contador no final
	*		@param	$perfilUsuario	  Perfil do usuario
	*		@param	$acompanhamento   Acompanhamento do orcamento (default = false)
	*/
	function consultaRazaoAnalitico($dataInicial, $dataFinal, $oidEmpresaCont, $oidConta, $oidEmpresa, $paginaInicial = 1, $exibeNaoLiberado, $exibeContador, $perfilUsuario, $acompanhamento = false) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$flagExibeNaoLiberado = ($exibeNaoLiberado == false) ? "S" : "N";
		$exibeNaoLiberado = ($exibeNaoLiberado == false) ? 0 : 1;

		if ($acompanhamento == true)
			$perfilUsuario = "O";

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$oidContaSolic = $oidConta;
		$conta = new Conta();

		$contaSolicitada = new Conta();
		$contaSolicitada->pesquisaConta($oidConta);
		$listaItensLancamento = $itemLancamento->buscaItemLancamentoConta($oidEmpresaCont, $contaSolicitada->getCodigoSintetico(), $dataInicial, $dataFinal, $exibeNaoLiberado, 1);

		// Alteração - Múltiplas Contas (18.07.2005)
		$listaContasSolic = $conta->buscaConta($oidEmpresaCont, $contaSolicitada->getCodigoSintetico(), 7);
		// ------------------- Fim da Alteração

		// Cria relatorio em formato TXT...
		$this->geraRazaoAnaliticoTXT($dataInicial, $dataFinal, $oidEmpresaCont, $oidConta, $oidEmpresa, $paginaInicial, $exibeNaoLiberado, $exibeContador, $perfilUsuario, $acompanhamento, $desconsiderarZeramento);

		// Cabecalho...
		$empresa->pesquisaEmpresa($oidEmpresaCont);
		$cabecalho = "<font face=\"Verdana, Arial\" color=\"#000099\" size=\"2\">";
		$cabecalho .= $empresa->getOidEmpresaCont() . " - " . $empresa->getRazaoSocial();
		$cabecalho .= "<br>";
		$cabecalho .= $relatorioPeriodoDe . $dataInicial . $relatorioA . $dataFinal . "</font><br><br>";

		$relatorio = new RelatorioHTMLCw($oidEmpresa, $relatorioRazao, $cabecalho);
		$relatorio->inicioRelatorio();

		$listaContasSDV = "";

		for ($indContaContabil = 0; $indContaContabil < sizeof($listaContasSolic); $indContaContabil++) {

			$oidConta = $listaContasSolic[$indContaContabil][1];

			$oidContaSDV = explode(".", $oidConta);
			$listaContasSDV .= $oidContaSDV[0] . "_";

			$dataLimite = Data :: somaDia($dataInicial, -1);

			$saldoAnterior = $this->buscaSaldoConta($oidContaSDV[0], $dataLimite, $flagExibeNaoLiberado);
			$tipoSaldoAnterior = ($saldoAnterior < 0) ? " C" : " D";

			$numeroLancamentos = 0;
			for ($indice = 0; $indice < sizeof($listaItensLancamento); $indice++) {
				if ($listaItensLancamento[$indice][2] == $oidContaSDV[0])
					$numeroLancamentos++;
			}

			if (!($numeroLancamentos == 0 && $saldoAnterior == 0.00 && sizeof($listaContasSolic) > 1)) { //!( $lista[0][0] == "0" )) {

				echo "<font face=\"Verdana, Arial\" color=\"#000099\" size=\"2\"><b>" . $listaContasSolic[$indContaContabil][2] . " - " . $listaContasSolic[$indContaContabil][3] . " (". $oidConta .")</font></b><br>";

				$conta->pesquisaContaSemDV($oidContaSDV[0]);

				$relatorio->mostraString("<table width=\"100%\" border=\"0\">");
				$relatorio->mostraString("<tr>");
				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"center\" width=\"8%\" class=\"tjanela\">");
				$relatorio->mostraString($relatorioCodigo);
				$relatorio->mostraString("</td>");
				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"center\" width=\"10%\" class=\"tjanela\">");
				$relatorio->mostraString($relatorioData);
				$relatorio->mostraString("</td>");
				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"45%\" class=\"tjanela\">");
				$relatorio->mostraString($relatorioHistorico);
				$relatorio->mostraString("</td>");
				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"10%\" class=\"tjanela\">");
				$relatorio->mostraString($relatorioDebito);
				$relatorio->mostraString("</td>");
				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"10%\" class=\"tjanela\">");
				$relatorio->mostraString($relatorioCredito);
				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"17%\" class=\"tjanela\">");
				$relatorio->mostraString($relatorioSaldo);
				$relatorio->mostraString("</td>");
				$relatorio->mostraString("</tr>");

				// Codigo do lancamento...
				$relatorio->mostraString("<tr>");

				$relatorio->mostraString("<td align=\"left\" width=\"8%\" class=\"lcons2\">");
				$relatorio->mostraString("&nbsp;");
				$relatorio->mostraString("</td>");

				// Data do lancamento...
				$relatorio->mostraString("<td align=\"center\" width=\"10%\" class=\"lcons2\">");
				$relatorio->mostraString("&nbsp;");
				$relatorio->mostraString("</td>");

				// Historico...
				$relatorio->mostraString("<td align=\"left\" width=\"45%\" class=\"lcons2\">");
				$relatorio->mostraString("<b>" . $relatorioSaldoAnterior . "</b>");
				$relatorio->mostraString("</td>");

				// Debito...
				$relatorio->mostraString("<td align=\"right\" width=\"10%\" class=\"lcons2\">");
				$relatorio->mostraString("&nbsp;");
				$relatorio->mostraString("</td>");

				// Credito...
				$relatorio->mostraString("<td align=\"right\" width=\"10%\" class=\"lcons2\">");
				$relatorio->mostraString("&nbsp;");
				$relatorio->mostraString("</td>");

				// Saldo...
				$relatorio->mostraString("<td align=\"right\" width=\"17%\" class=\"lcons2\">");
				$relatorio->mostraString(Numero :: convReal($saldoAnterior) . $tipoSaldoAnterior);
				$relatorio->mostraString("</td>");

				$relatorio->mostraString("</tr>");

				$saldoAtual = $saldoAnterior;
				$tipoSaldoAtual = ($saldoAtual < 0) ? " C" : " D";
				$flagCor = true;
				// Comeca laco para apresentacao do relatorio...
				for ($indx = 0; $indx < sizeof($listaItensLancamento); $indx++) {

					// testa se for e a conta a ser consultada...
					if ($listaItensLancamento[$indx][2] == $oidContaSDV[0]) {

						// Define cor da linha
						if ($listaItensLancamento[$indx][11] == "N")
							$cor = $flagCor == true ? "lcons10" : "lcons11";
						else
							$cor = $flagCor == true ? "lcons1" : "lcons2";

						$relatorio->mostraString("<tr>");

						// Codigo do lancamento...
						$relatorio->mostraString("<td align=\"center\" width=\"8%\" class=\"" . $cor . "\">");
						$relatorio->mostraString($listaItensLancamento[$indx][1]);
						$relatorio->mostraString("</td>");

						// Data do lancamento...
						$relatorio->mostraString("<td align=\"center\" width=\"10%\" class=\"" . $cor . "\">");
						$relatorio->mostraString($listaItensLancamento[$indx][9]);
						$relatorio->mostraString("</td>");

						// Historico...
						$relatorio->mostraString("<td align=\"left\" width=\"45%\" class=\"" . $cor . "\">");
						$relatorio->mostraString($listaItensLancamento[$indx][3]);
						$relatorio->mostraString("</td>");

						// Debito...
						$relatorio->mostraString("<td align=\"right\" width=\"10%\" class=\"" . $cor . "\">");
						if ($listaItensLancamento[$indx][5] == "D") {
							if ($listaItensLancamento[$indx][4] > 0)
								$relatorio->mostraString(Numero :: convReal($listaItensLancamento[$indx][4]));
						} else
							$relatorio->mostraString("&nbsp;");
						$relatorio->mostraString("</td>");

						// Credito...
						$relatorio->mostraString("<td align=\"right\" width=\"10%\" class=\"" . $cor . "\">");
						if ($listaItensLancamento[$indx][5] == "C") {
							if ($listaItensLancamento[$indx][4] > 0)
								$relatorio->mostraString(Numero :: convReal($listaItensLancamento[$indx][4]));
						} else
							$relatorio->mostraString("&nbsp;");
						$relatorio->mostraString("</td>");

						if ($listaItensLancamento[$indx][5] == "C")
							$saldoAtual = $saldoAtual - $listaItensLancamento[$indx][4];
						else
							$saldoAtual = $saldoAtual + $listaItensLancamento[$indx][4];
						$tipoSaldoAtual = ($saldoAtual < 0) ? " C" : " D";

						$cor = $flagCor == true ? "lcons1" : "lcons2";

						$flagCor = !$flagCor;

						// Saldo...
						$relatorio->mostraString("<td align=\"right\" width=\"17%\" class=\"" . $cor . "\">");
						$relatorio->mostraString(Numero :: convReal($saldoAtual) . $tipoSaldoAtual);
						$relatorio->mostraString("</td>");

						$relatorio->mostraString("</tr>");

					} // Fim da comparacao de contas...

				} // Fim do for indx...

				$relatorio->mostraString("<tr>");

				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"8%\" class=\"tjanela\" align=\"center\">");
				$relatorio->mostraString("&nbsp;");
				$relatorio->mostraString("</td>");

				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"center\">");
				$relatorio->mostraString("&nbsp;");
				$relatorio->mostraString("</td>");

				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"45%\" class=\"tjanela\" align=\"right\">");
				$relatorio->mostraString($relatorioSaldoAtual);
				$relatorio->mostraString("</td>");

				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"right\">");
				$relatorio->mostraString("&nbsp;");
				$relatorio->mostraString("</td>");

				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"right\">");
				$relatorio->mostraString("&nbsp;");
				$relatorio->mostraString("</td>");
				$tipoSaldoAtual = ($saldoAtual < 0) ? " C" : " D";
				$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"17%\" class=\"tjanela\" align=\"right\">");
				$relatorio->mostraString(Numero :: convReal($saldoAtual) . $tipoSaldoAtual);
				$relatorio->mostraString("</td>");

				$relatorio->mostraString("</tr>");

				// Finaliza relatorio...
				$relatorio->mostraString("</table><br>");

				if (!empty ($exibeNaoLiberado) && $exibeNaoLiberado) {
					$relatorio->mostraString("<table class=\"pagina\" border=\"0\" width=\"100%\">");
					$relatorio->mostraString("<tr><td width=\"100%\" align=\"left\" class=\"lcons11\">");
					$relatorio->mostraString($msgLancamentosNaoLiberados);
					$relatorio->mostraString("</td></tr></table><br>");
				}

			} // Fim do FOR das Contas

		} // Fim da decisao de validacao do array
		// Testa se precisa exibir dados do contador...
		if (!empty ($exibeContador) && $exibeContador) {
			$relatorio->mostraString("<br><table class=\"pagina\" border=\"0\" width=\"100%\">");
			$relatorio->mostraString("<tr><td width=\"100%\" align=\"center\" class=\"lcons2\">");
			$relatorio->mostraString($empresa->getNomeContador());
			$relatorio->mostraString("</td></tr><tr><td width=\"100%\" align=\"center\" class=\"lcons2\">");
			$relatorio->mostraString($empresa->getRegistroContador());
			$relatorio->mostraString("</td></tr></table><br><br>");
		}

		// Seta variaveis auxiliares...
		$acaoAdicional = "javascript:window.print();";

		if ($acompanhamento == false)
			$voltar = $mostra == true ? "javascript:history.back();" : "javascript:history.back();";
		else
			$voltar = "javascript:window.close();";

		$infoAdicionais = "<font face=\"Verdana, Arial\" size=\"1\"><a href=\"../pdfs/" . TXT_RAZAO . "\">";
		$infoAdicionais .= $msgCliqueAquiParaVisualizarTXT;
		$infoAdicionais .= "</a></font>\n<br><br>\n";

		$infoAdicionais .= "<input type=\"hidden\" name=\"oidEmpresa\" ";
		$infoAdicionais .= "value=\"" . $oidEmpresa . "\">\n";
		$infoAdicionais .= "<input type=\"hidden\" name=\"oidEmpresaCont\" ";
		$infoAdicionais .= "value=\"" . $oidEmpresaCont . "\">\n";
		$infoAdicionais .= "<input type=\"hidden\" name=\"oidConta\" ";
		$infoAdicionais .= "value=\"" . $oidContaSolic . "\">\n";
		$infoAdicionais .= "<input type=\"hidden\" name=\"dataInicial\" ";
		$infoAdicionais .= "value=\"" . $dataInicial . "\">\n";
		$infoAdicionais .= "<input type=\"hidden\" name=\"dataFinal\" ";
		$infoAdicionais .= "value=\"" . $dataFinal . "\">\n";
		$infoAdicionais .= "<input type=\"hidden\" name=\"paginaInicial\" ";
		$infoAdicionais .= "value=\"" . $paginaInicial . "\">\n";
		$infoAdicionais .= "<input type=\"hidden\" name=\"exibeNaoLiberado\" ";
		$infoAdicionais .= "value=\"" . $exibeNaoLiberado . "\">\n";
		$infoAdicionais .= "<input type=\"hidden\" name=\"exibeContador\" ";
		$infoAdicionais .= "value=\"" . $exibeContador . "\">\n";
		if ($perfilUsuario != "O") {
			$infoAdicionais .= "<input type=\"hidden\" name=\"controleNavegacao\" ";
			$infoAdicionais .= "value=\"2\">\n";
			$infoAdicionais .= "<input type=\"submit\" name=\"gerar\" class=\"bjanela\" ";
			$infoAdicionais .= "value=\"" . $botaoGerarPDF . "\">\n";
		} else {
			if (!$acompanhamento) {
				$infoAdicionais .= "<input type=\"hidden\" name=\"controleNavegacao\" ";
				$infoAdicionais .= "value=\"3\">\n";
				$infoAdicionais .= "<input type=\"submit\" name=\"gerar\" class=\"bjanela\" ";
				$infoAdicionais .= "value=\"" . $botaoVisualizarPDF . "\">\n";
			}
		}
		$infoAdicionais .= "<input type=\"button\" name=\"imprimir\" class=\"bjanela\" ";
		$infoAdicionais .= "value=\"" . $botaoImprimir . "\" onClick=\"" . $acaoAdicional . "\">\n";

		$relatorio->fimRelatorio("cwConsRazao.php", $infoAdicionais, $voltar);
		return true;
	}

	/**
	*		consultaDemonstrativo( $dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa,
	*										$paginaInicial, $exibeNaoLiberado, $exibeContador,
	*										$perfilUsuario, $oidCentroCusto, $desconsiderarZeramento )
	*		Mostra demonstrativo de resultados, no formato HTML
	*		@param	$dataInicial	  Data inicial
	*		@param	$dataFinal			  Data final
	*		@param	$oidEmpresaCont   OID da empresa contabil
	*		@param	$oidEmpresa   OID da empresa
	*		@param	$paginaInicial	  Pagina inicial
	*		@param	$exibeNaoLiberado se true, exibe os lancamentos nao liberados pelo contador
	*		@param	$exibeContador	  se true, exibe dados do contador no final
	*		@param	$perfilUsuario	  Perfil do usuario
	*		@param	$oidCentroCusto   OID do Centro de Custo (0=todos)
	*       @param  $desconsiderarZeramento    Desconsiderar os zeramentos no periodo
	*/
	function consultaDemonstrativo($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $paginaInicial = 1, $exibeNaoLiberado, $exibeContador, $perfilUsuario, $oidCentroCusto, $desconsiderarZeramento) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$flagExibeNaoLiberado = ($exibeNaoLiberado == false) ? "S" : "N";

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();

		$this->geraDemonstrativoTXTnovo($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $paginaInicial, $exibeNaoLiberado, $exibeContador, $perfilUsuario, $oidCentroCusto, $desconsiderarZeramento);

		$empresa->pesquisaEmpresa($oidEmpresaCont);
		$lista = $conta->buscaConta($oidEmpresaCont, "");

		if ($lista[0][0] == "0")
			return false;
		else {

			// Seta variaveis auxiliares...
			$acaoAdicional = "javascript:window.print();";

			$voltar = $mostra == true ? "javascript:history.back();" : "javascript:history.back();";

			$infoAdicionais = "<font face=\"Verdana, Arial\" size=\"1\"><a href=\"../pdfs/" . TXT_DEMONSTRATIVO . "\">";
			$infoAdicionais .= $msgCliqueAquiParaVisualizarTXT;
			$infoAdicionais .= "</a></font>\n<br><br>\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"oidEmpresa\" ";
			$infoAdicionais .= "value=\"" . $oidEmpresa . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"oidEmpresaCont\" ";
			$infoAdicionais .= "value=\"" . $oidEmpresaCont . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"dataInicial\" ";
			$infoAdicionais .= "value=\"" . $dataInicial . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"dataFinal\" ";
			$infoAdicionais .= "value=\"" . $dataFinal . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"paginaInicial\" ";
			$infoAdicionais .= "value=\"" . $paginaInicial . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"exibeNaoLiberado\" ";
			$infoAdicionais .= "value=\"" . $exibeNaoLiberado . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"desconsiderarZeramento\" ";
			$infoAdicionais .= "value=\"" . $desconsiderarZeramento . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"exibeContador\" ";
			$infoAdicionais .= "value=\"" . $exibeContador . "\">\n";
			if ($perfilUsuario != "O") {
				$infoAdicionais .= "<input type=\"hidden\" name=\"controleNavegacao\" ";
				$infoAdicionais .= "value=\"2\">\n";
				$infoAdicionais .= "<input type=\"submit\" name=\"gerar\" class=\"bjanela\" ";
				$infoAdicionais .= "value=\"" . $botaoGerarPDF . "\">\n";
			} else {
				$infoAdicionais .= "<input type=\"hidden\" name=\"controleNavegacao\" ";
				$infoAdicionais .= "value=\"3\">\n";
				$infoAdicionais .= "<input type=\"submit\" name=\"gerar\" class=\"bjanela\" ";
				$infoAdicionais .= "value=\"" . $botaoVisualizarPDF . "\">\n";
			}
			$infoAdicionais .= "<input type=\"button\" name=\"imprimir\" class=\"bjanela\" ";
			$infoAdicionais .= "value=\"" . $botaoImprimir . "\" onClick=\"" . $acaoAdicional . "\">\n";

			// Cabecalho...
			$cabecalho = "<font face=\"Verdana, Arial\" color=\"#000099\" size=\"2\">";
			$cabecalho .= $empresa->getOidEmpresaCont() . " - " . $empresa->getRazaoSocial();
			$cabecalho .= "<br>";
			$cabecalho .= $dataInicial . " - " . $dataFinal . "</font><br><br>";

			if ($oidCentroCusto != "0") {
				$centroCusto = new CentroCusto();
				$centroCusto->pesquisaCentroCusto($oidCentroCusto);
				$cabecalho .= "<font face=\"Verdana, Arial\" color=\"#000099\" size=\"2\">";
				$cabecalho .= $relatorioCentroCusto . " = " . $centroCusto->getSigla();
			}

			// Cria relatorio...
			$relatorio = new RelatorioHTMLCw($oidEmpresa, $relatorioDemoResult, $cabecalho);

			// Inicia apresentacao do relatorio...
			$relatorio->inicioRelatorio();

			$relatorio->mostraString("<table width=\"100%\" border=\"0\">");
			$relatorio->mostraString("<tr>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"15%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioConta);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"45%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioDescricao);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"20%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioDebito);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"20%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioCredito);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("</tr>");

			$contLinha = 0;
			$somaDebito = $somaCredito = 0;
			// Comeca laco para apresentacao do relatorio...

			for ($indx = 0; $indx < sizeof($lista); $indx++) {

				$oidConta = explode(".", $lista[$indx][0]);

				$debitoPeriodo = $this->buscaMovimentoConta($oidConta[0], $dataInicial, $dataFinal, $flagExibeNaoLiberado, "D", $desconsiderarZeramento, $oidCentroCusto);
				$creditoPeriodo = $this->buscaMovimentoConta($oidConta[0], $dataInicial, $dataFinal, $flagExibeNaoLiberado, "C", $desconsiderarZeramento, $oidCentroCusto);

				$saldoPeriodo = $debitoPeriodo - $creditoPeriodo;

				if (abs(round($saldoPeriodo, 2)) != 0) {

					if ($lista[$indx][6] != "O") {

						// Define cor da linha
						$cor = ($contLinha % 2) == 0 ? "lcons1" : "lcons2";
						$contLinha++;

						$relatorio->mostraString("<tr>");

						// Codigo Sintetico...
						$relatorio->mostraString("<td align=\"left\" width=\"15%\" class=\"" . $cor . "\">");
						$relatorio->mostraString($lista[$indx][1]);
						$relatorio->mostraString("</td>");

						// Descricao...
						$relatorio->mostraString("<td align=\"left\" width=\"45%\" class=\"" . $cor . "\">");
						$relatorio->mostraString($lista[$indx][2]);
						$relatorio->mostraString("</td>");

						// Debito...
						$relatorio->mostraString("<td align=\"right\" width=\"20%\" class=\"" . $cor . "\">");
						if ($saldoPeriodo > 0) {
							if ($lista[$indx][4] == "A")
								$somaDebito += $saldoPeriodo;
							$relatorio->mostraString(Numero :: convReal($saldoPeriodo));
						} else
							$relatorio->mostraString("&nbsp;");
						$relatorio->mostraString("</td>");

						// Credito...
						$relatorio->mostraString("<td align=\"right\" width=\"20%\" class=\"" . $cor . "\">");
						if ($saldoPeriodo <= 0) {
							if ($lista[$indx][4] == "A")
								$somaCredito += ($saldoPeriodo * -1);
							$relatorio->mostraString(Numero :: convReal($saldoPeriodo));
						} else
							$relatorio->mostraString("&nbsp;");
						$relatorio->mostraString("</td>");

						$relatorio->mostraString("</tr>");
					}
				}
			} // Fim do indx...

			// Finaliza relatorio...
			$relatorio->mostraString("</table>");

			if (!empty ($exibeNaoLiberado) && $exibeNaoLiberado) {
				$relatorio->mostraString("<br><table class=\"pagina\" border=\"0\" width=\"100%\">");
				$relatorio->mostraString("<tr><td width=\"100%\" align=\"left\" class=\"lcons11\">");
				$relatorio->mostraString($msgConsLancamentosNaoLiberados);
				$relatorio->mostraString("</td></tr></table><br>");
			}

			$saldoPeriodo = $somaDebito - $somaCredito;
			$textoDemo = ($saldoPeriodo > 0) ? $msgDemoResultPrejuizo : $msgDemoResultLucro;
			$relatorio->mostraString("<table class=\"pagina\" border=\"0\" width=\"100%\">");
			$relatorio->mostraString("<tr><td width=\"70%\" align=\"center\" class=\"lcons2\">");
			$relatorio->mostraString($msgDemoResult . " - " . $textoDemo . " -> " . Numero :: convReal($saldoPeriodo));
			$relatorio->mostraString("</td></tr></table>");

			// Testa se precisa exibir dados do contador...
			if (!empty ($exibeContador) && $exibeContador) {
				$relatorio->mostraString("<br><table class=\"pagina\" border=\"0\" width=\"100%\">");
				$relatorio->mostraString("<tr><td width=\"100%\" align=\"center\" class=\"lcons2\">");
				$relatorio->mostraString($empresa->getNomeContador());
				$relatorio->mostraString("</td></tr><tr><td width=\"100%\" align=\"center\" class=\"lcons2\">");
				$relatorio->mostraString($empresa->getRegistroContador());
				$relatorio->mostraString("</td></tr></table><br><br>");
			}

			$relatorio->fimRelatorio("cwConsDemoResult.php", $infoAdicionais, $voltar);

			return true;

		} // Fim da decisao de validacao do array

	}

	/**
	*		geraDemonstrativoTXT( $dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa,
	*										$paginaInicial, $exibeNaoLiberado, $exibeContador,
	*										$perfilUsuario, $oidCentroCusto, $desconsiderarZeramento )
	*		Gera demonstrativo de resultados, no formato TXT
	*		@param	$dataInicial	  Data inicial
	*		@param	$dataFinal			  Data final
	*		@param	$oidEmpresaCont   OID da empresa contabil
	*		@param	$oidEmpresa   OID da empresa
	*		@param	$paginaInicial	  Pagina inicial
	*		@param	$exibeNaoLiberado se true, exibe os lancamentos nao liberados pelo contador
	*		@param	$exibeContador	  se true, exibe dados do contador no final
	*		@param	$perfilUsuario	  Perfil do usuario
	*		@param	$oidCentroCusto   OID do Centro de Custo (0=todos)
	*       @param  $desconsiderarZeramento    Desconsiderar os zeramentos no periodo
	*/
	function geraDemonstrativoTXT($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $paginaInicial, $exibeNaoLiberado, $exibeContador, $perfilUsuario, $oidCentroCusto, $desconsiderarZeramento) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$flagExibeNaoLiberado = ($exibeNaoLiberado == false) ? "S" : "N";

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();

		$empresa->pesquisaEmpresa($oidEmpresaCont);
		$lista = $conta->buscaConta($oidEmpresaCont, "");

		if ($lista[0][0] == "0")
			return false;
		else {

			// Cria relatorio...
			$relatorioTXT = new RelatorioTXT();
			$relatorioTXT->setConf("../pdfs/" . TXT_DEMONSTRATIVO);

			// Inicia apresentacao do relatorio...
			$relatorioTXT->inicioRelatorio();

			$contLinha = 0;
			$somaDebito = $somaCredito = 0;
			// Comeca laco para apresentacao do relatorio...

			$contadorLinhas = 70;
			$contadorPagina = $paginaInicial -1;
			for ($indx = 0; $indx < sizeof($lista); $indx++) {

				$oidConta = explode(".", $lista[$indx][0]);

				$debitoPeriodo = $this->buscaMovimentoConta($oidConta[0], $dataInicial, $dataFinal, $flagExibeNaoLiberado, "D", $desconsiderarZeramento, $oidCentroCusto);
				$creditoPeriodo = $this->buscaMovimentoConta($oidConta[0], $dataInicial, $dataFinal, $flagExibeNaoLiberado, "C", $desconsiderarZeramento, $oidCentroCusto);

				$saldoPeriodo = $debitoPeriodo - $creditoPeriodo;

				if (abs(round($saldoPeriodo, 2)) != 0) {

					if ($lista[$indx][6] != "O") {

						if ($contadorLinhas > 52) {
							$contadorPagina++;
							$linhaCabec = str_pad("=", 132, "=") . CRLF;
							$relatorioTXT->mostraString(chr(15) . str_pad(" ", 15) . "D E M O N S T R A T I V O" . str_pad(" ", 3) . "D E" . str_pad(" ", 3) . "R E S U L T A D O S" . CRLF);
							$relatorioTXT->mostraString(String :: removeAcento(sprintf("%-40s", $empresa->getRazaoSocial())) . str_pad(" ", 85) . "FL." . str_pad($contadorPagina, 4, "0", STR_PAD_LEFT) . CRLF);
							$relatorioTXT->mostraString($linhaCabec);
							$relatorioTXT->mostraString(str_pad(" ", 4) . "Conta" . str_pad(" ", 8) . "D e s c r i c a o" . str_pad(" ", 33) . "Debito" . str_pad(" ", 5) . "Credito" . CRLF);
							$relatorioTXT->mostraString($linhaCabec);
							$contadorLinhas = 0;
						}

						// Codigo Sintetico...
						$relatorioTXT->mostraString($lista[$indx][1]);
						$relatorioTXT->mostraString(str_pad(" ", 2));

						// Descricao...
						$descricao = sprintf("%-45s", String :: removeAcento($lista[$indx][2]));
						$relatorioTXT->mostraString($descricao);

						// Debito...
						if ($saldoPeriodo > 0) {
							if ($lista[$indx][4] == "A")
								$somaDebito += $saldoPeriodo;
							$stringDebito = sprintf("%12s", Numero :: convReal($saldoPeriodo));
							$relatorioTXT->mostraString($stringDebito);
						} else
							$relatorioTXT->mostraString(str_pad(" ", 12));

						// Credito...

						if ($saldoPeriodo <= 0) {
							if ($lista[$indx][4] == "A")
								$somaCredito += ($saldoPeriodo * -1);
							$stringCredito = sprintf("%12s", Numero :: convReal($saldoPeriodo));
							$relatorioTXT->mostraString($stringCredito);
						} else
							$relatorioTXT->mostraString(str_pad(" ", 12));
						$relatorioTXT->mostraString(CRLF);
						$contadorLinhas++;

						if ($contadorLinhas > 52)
							$relatorioTXT->mostraString(FF);

					}
				}
			} // Fim do indx...

			if (!empty ($exibeNaoLiberado) && $exibeNaoLiberado) {
				$relatorioTXT->mostraString($msgConsLancamentosNaoLiberados);
				$relatorioTXT->mostraString(CRLF);
			}

			$saldoPeriodo = $somaDebito - $somaCredito;
			$textoDemo = ($saldoPeriodo > 0) ? $msgDemoResultPrejuizo : $msgDemoResultLucro;
			$relatorioTXT->mostraString(CRLF);
			$relatorioTXT->mostraString(str_pad(" ", 5) . $msgDemoResult . " - " . $textoDemo . " -> " . Numero :: convReal($saldoPeriodo));
			$relatorioTXT->mostraString(CRLF);

			// Testa se precisa exibir dados do contador...
			if (!empty ($exibeContador) && $exibeContador) {
				$relatorioTXT->mostraString(CRLF);
				$relatorioTXT->mostraString(str_pad(" ", 20));
				$relatorioTXT->mostraString($empresa->getNomeContador());
				$relatorioTXT->mostraString(CRLF);
				$relatorioTXT->mostraString(str_pad(" ", 20));
				$relatorioTXT->mostraString($empresa->getRegistroContador());
				$relatorioTXT->mostraString(FF);
			}

			$relatorioTXT->fimRelatorio();

			return true;

		} // Fim da decisao de validacao do array

	}

	/**
	*		geraDemonstrativoTXTnovo( $dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa,
	*										$paginaInicial, $exibeNaoLiberado, $exibeContador,
	*										$perfilUsuario, $oidCentroCusto, $desconsiderarZeramento )
	*		Gera demonstrativo de resultados, no formato TXT (novo layout)
	*		@param	$dataInicial	  Data inicial
	*		@param	$dataFinal			  Data final
	*		@param	$oidEmpresaCont   OID da empresa contabil
	*		@param	$oidEmpresa   OID da empresa
	*		@param	$paginaInicial	  Pagina inicial
	*		@param	$exibeNaoLiberado se true, exibe os lancamentos nao liberados pelo contador
	*		@param	$exibeContador	  se true, exibe dados do contador no final
	*		@param	$perfilUsuario	  Perfil do usuario
	*		@param	$oidCentroCusto   OID do Centro de Custo (0=todos)
	*       @param  $desconsiderarZeramento    Desconsiderar os zeramentos no periodo
	*/
	function geraDemonstrativoTXTnovo($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $paginaInicial, $exibeNaoLiberado, $exibeContador, $perfilUsuario, $oidCentroCusto, $desconsiderarZeramento) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$flagExibeNaoLiberado = ($exibeNaoLiberado == false) ? "S" : "N";

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();

		$empresa->pesquisaEmpresa($oidEmpresaCont);
		$lista = $conta->buscaConta($oidEmpresaCont, "");

		if ($lista[0][0] == "0")
			return false;
		else {

			// Cria relatorio...
			$relatorioTXT = new RelatorioTXT();
			$relatorioTXT->setConf("../pdfs/" . TXT_DEMONSTRATIVO);

			// Inicia apresentacao do relatorio...
			$relatorioTXT->inicioRelatorio();

			$contLinha = 0;
			$somaDebito = $somaCredito = 0;
			// Comeca laco para apresentacao do relatorio...

			$contadorLinhas = 70;
			$contadorPagina = $paginaInicial -1;
			$ultimoGrupo = '-1'; // Controla se está imprimindo Receitas ou Despesas
			for ($indx = 0; $indx < sizeof($lista); $indx++) {

				$oidConta = explode(".", $lista[$indx][0]);

				$debitoPeriodo = $this->buscaMovimentoConta($oidConta[0], $dataInicial, $dataFinal, $flagExibeNaoLiberado, "D", $desconsiderarZeramento, $oidCentroCusto);
				$creditoPeriodo = $this->buscaMovimentoConta($oidConta[0], $dataInicial, $dataFinal, $flagExibeNaoLiberado, "C", $desconsiderarZeramento, $oidCentroCusto);

				$saldoPeriodo = $debitoPeriodo - $creditoPeriodo;

				if (abs(round($saldoPeriodo, 2)) != 0) {

					if ($lista[$indx][6] != "O") {

						if ($contadorLinhas > 52) {
							$contadorPagina++;
							$linhaCabec = str_pad("=", 79, "=") . CRLF;
							$relatorioTXT->mostraString(String :: removeAcento(sprintf("%-40s", $empresa->getRazaoSocial())) . CRLF);
							$relatorioTXT->mostraString("C.N.P.J.: " . $empresa->getCnpj() . CRLF);
							$relatorioTXT->mostraString(str_pad(" ", 13) . "DEMONSTRATIVO DE RESULTADOS DO EXERCICIO" . str_pad(" ", 19) . "FL." . str_pad($contadorPagina, 4, "0", STR_PAD_LEFT) . CRLF);
							$relatorioTXT->mostraString(str_pad(" ", 15) . "NO PERIODO DE " . $dataInicial . " A " . $dataFinal . CRLF);

							$relatorioTXT->mostraString($linhaCabec);
							$relatorioTXT->mostraString(str_pad(" ", 4) . "D e s c r i c a o" . str_pad(" ", 52) . "Saldo" . CRLF);
							$relatorioTXT->mostraString($linhaCabec);
							$contadorLinhas = 0;
						}

						if ((strlen(trim($lista[$indx][1])) == 1) && (strcmp($ultimoGrupo, $lista[$indx][6]) != 0))
							$ultimoGrupo = $lista[$indx][6];

						// Se for uma conta sintetica, deixa uma linha em branco
						if ($lista[$indx][4] == "S") {
							$relatorioTXT->mostraString(" " . CRLF);
							$contadorLinhas++;
						}

						// Identação de descricão
						$tamanhoString = strlen(trim($lista[$indx][1]));
						$relatorioTXT->mostraString(str_pad(" ", $tamanhoString));
						$relatorioTXT->mostraString(str_pad(" ", 2));

						// Descricao...
						$descricao = sprintf("%-43s", String :: removeAcento($lista[$indx][2]));
						$relatorioTXT->mostraString($descricao);
						$relatorioTXT->mostraString(str_pad(" ", (20 - $tamanhoString)));

						// Mostra Saldo
						$contaRedutora = false;
						if (strcmp($lista[$indx][6], $ultimoGrupo))
							$contaRedutora = true;

						if ($lista[$indx][4] == "A") {
							if ($saldoPeriodo > 0)
								$somaDebito += $saldoPeriodo;
							else
								$somaCredito += ($saldoPeriodo * -1);
						}
						// Imprime o saldo
						if ($contaRedutora == true)
							$stringSaldo = '(' . sprintf("%12s", Numero :: convReal($saldoPeriodo)) . ')';
						else
							$stringSaldo = ' ' . sprintf("%12s", Numero :: convReal($saldoPeriodo)) . ' ';
						$relatorioTXT->mostraString($stringSaldo);
						$relatorioTXT->mostraString(CRLF);
						$contadorLinhas++;

						if ($contadorLinhas > 52)
							$relatorioTXT->mostraString(FF);

					}
				}
			} // Fim do indx...

			if (!empty ($exibeNaoLiberado) && $exibeNaoLiberado) {
				$relatorioTXT->mostraString(CRLF . $msgConsLancamentosNaoLiberados);
				$relatorioTXT->mostraString(CRLF);
			}

			$saldoPeriodo = $somaDebito - $somaCredito;
			$textoDemo = ($saldoPeriodo > 0) ? String :: removeAcento(String :: upper($msgDemoResultPrejuizo)) : String :: removeAcento(String :: upper($msgDemoResultLucro));
			$relatorioTXT->mostraString(CRLF);
			$relatorioTXT->mostraString(str_pad(" ", 5) . String :: removeAcento(String :: upper($msgDemoResult)) . " - " . $textoDemo . " -> " . Numero :: convReal($saldoPeriodo));
			$relatorioTXT->mostraString(CRLF);

			// Testa se precisa exibir dados do contador...
			if (!empty ($exibeContador) && $exibeContador) {
				$relatorioTXT->mostraString(CRLF);
				$relatorioTXT->mostraString(str_pad(" ", 12));
				$relatorioTXT->mostraString(String :: removeAcento(String :: upper($empresa->getNomeContador())) . str_pad(" ", 10) . String :: removeAcento(String :: upper($empresa->getResponsavel())));
				$relatorioTXT->mostraString(CRLF);
				$relatorioTXT->mostraString(str_pad(" ", 12));
				$relatorioTXT->mostraString($empresa->getRegistroContador() . str_pad(" ", 32) . $empresa->getCpfResponsavel());
				$relatorioTXT->mostraString(FF);
			}

			$relatorioTXT->fimRelatorio();

			return true;

		} // Fim da decisao de validacao do array

	}

	/**
	*		consultaDemonstrativoPDF( $dataInicial, $dataFinal, $oidEmpresaCont,
	*												$oidEmpresa, $paginaInicial = 1, $exibeContador, $desconsiderarZeramento )
	*		Mostra consulta de demonstrativos de resultados, somente os
	*								contabilizados, em formato PDF
	*		@param	$dataInicial	Data inicial
	*		@param	$dataFinal			Data final
	*	@param	$oidEmpresaCont OID da empresa contabil
	*		@param	$oidEmpresa	OID da empresa
	*		@param	$paginaInicial	Pagina inicial
	*		@param	$exibeContador	Exibe dados do contador
	*       @param  $desconsiderarZeramento   Desconsiderar o Zeramento
	*/
	function consultaDemonstrativoPDF($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $paginaInicial, $exibeContador, $desconsiderarZeramento, $oidCentroCusto = 0) {

		// Seta variaveis que possam ser utilizadas...
		$controleLinha = 1;
		$flagPreenchido = false;

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();

		$empresa->pesquisaEmpresa($oidEmpresaCont);
		$lista = $conta->buscaConta($oidEmpresaCont, "");

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$larguraColunas = array (
			25,
			100,
			25,
			25,
			25
		);
		$cabecalho = array (
			$relatorioCodigo,
			$relatorioDescricao,
			$relatorioDebito,
			$relatorioCredito
		);

		$totalDebito = $totalCredito = 0.0;

		// Cria relatorio...
		$relatorio = new RelatorioPDFCw($oidEmpresa, $relatorioDemoResult, $oidEmpresaCont . " - " . $empresa->getRazaoSocial() . " - " . $dataInicial . " a " . $dataFinal, $tituloSistema, $campoTextoPagina, $paginaInicial, true, $larguraColunas, $cabecalho);

		// Gera instancia de documento...
		$relatorio->getInstancia();

		// Seta margens do documento
		$relatorio->document->SetMargins(10, 10, 10);
		$relatorio->document->Open();
		$relatorio->document->AliasNbPages();
		$relatorio->document->SetAutoPageBreak(true, 10);
		$relatorio->document->AddPage();

		// Monta cabecalho da tabela...
		$relatorio->document->setFonte($relatorio->fonteTituloTabela);
		$relatorio->document->setCorTexto($relatorio->corTituloTabela);
		$relatorio->document->setCorFundo($relatorio->corFundoTituloTabela);
		$relatorio->document->setCorBorda($relatorio->corBordaTabela);

		$relatorio->document->SetLineWidth(.2);
		$relatorio->document->setCorFundo($relatorio->corFundoTabela);
		$relatorio->document->setCorTexto($relatorio->corTextoTabela);
		$relatorio->document->setFonte($relatorio->fonteTextoTabela);

		$somaDebito = $somaCredito = 0;
		// Comeca laco para impressao do relatorio...
		for ($indx = 0; $indx < sizeof($lista); $indx++) {

			$oidConta = explode(".", $lista[$indx][0]);

			$debitoPeriodo = $this->buscaMovimentoConta($oidConta[0], $dataInicial, $dataFinal, $flagExibeNaoLiberado, "D", $desconsiderarZeramento, $oidCentroCusto);
			$creditoPeriodo = $this->buscaMovimentoConta($oidConta[0], $dataInicial, $dataFinal, $flagExibeNaoLiberado, "C", $desconsiderarZeramento, $oidCentroCusto);

			$saldoPeriodo = $debitoPeriodo - $creditoPeriodo;

			if (abs(round($saldoPeriodo, 2)) != 0) {

				if ($lista[$indx][6] != "O") {

					// Controla preenchimento (automato finito - :-)...
					$flagPreenchido = !$flagPreenchido;

					// Imprime os dados...
					$relatorio->document->Cell($larguraColunas[0], 4, $lista[$indx][1], "LR", 0, "L", $flagPreenchido);
					$relatorio->document->Cell($larguraColunas[1], 4, $lista[$indx][2], "LR", 0, "L", $flagPreenchido);
					if ($saldoPeriodo > 0) {
						if ($lista[$indx][4] == "A")
							$somaDebito += $saldoPeriodo;
						$relatorio->document->Cell($larguraColunas[2], 4, Numero :: convReal($saldoPeriodo), "LR", 0, "R", $flagPreenchido);
					} else
						$relatorio->document->Cell($larguraColunas[2], 4, " ", "LR", 0, "R", $flagPreenchido);
					if ($saldoPeriodo <= 0) {
						if ($lista[$indx][4] == "A")
							$somaCredito += ($saldoPeriodo * -1);
						$relatorio->document->Cell($larguraColunas[2], 4, Numero :: convReal($saldoPeriodo), "LR", 0, "R", $flagPreenchido);
					} else
						$relatorio->document->Cell($larguraColunas[2], 4, " ", "LR", 0, "R", $flagPreenchido);
					// Salta linha...
					$relatorio->document->Ln();

					// Incrementa linha...
					$controleLinha++;

					// Se terminou pagina...
					if (false) { //  ( $controleLinha > 52 ) {
						$relatorio->document->AddPage();

						// Monta cabecalho da tabela...
						$relatorio->document->setFonte($relatorio->fonteTituloTabela);
						$relatorio->document->setCorTexto($relatorio->corTituloTabela);
						$relatorio->document->setCorFundo($relatorio->corFundoTituloTabela);
						$relatorio->document->setCorBorda($relatorio->corBordaTabela);

						$relatorio->document->SetLineWidth(.2);

						for ($indx = 0; $indx < count($cabecalho); $indx++)
							$relatorio->document->Cell($larguraColunas[$indx], 4, $cabecalho[$indx], 1, 0, "C", 1);
						$relatorio->document->Ln();

						$relatorio->document->setCorFundo($relatorio->corFundoTabela);
						$relatorio->document->setCorTexto($relatorio->corTextoTabela);
						$relatorio->document->setFonte($relatorio->fonteTextoTabela);

						$controleLinha = 1;
					}
				}

			}

		} // Fim do indx...

		$saldoPeriodo = $somaDebito - $somaCredito;
		$textoDemo = ($saldoPeriodo > 0) ? $msgDemoResultPrejuizo : $msgDemoResultLucro;
		$relatorio->document->Ln();
		$relatorio->document->setCorTexto($relatorio->corTextoTabela);
		$relatorio->document->setFonte($relatorio->fonteTextoTabela);
		$relatorio->document->Cell(0, 0, $msgDemoResult . " - " . $textoDemo . " -> " . Numero :: convReal($saldoPeriodo), 0, 1, "C", 0);
		$relatorio->document->Ln();

		// Testa se tem que colocar dados da contadora...
		if (!empty ($exibeContador) && $exibeContador) {
			$relatorio->document->Ln();
			$relatorio->document->Ln();
			$relatorio->document->setCorTexto($relatorio->corTextoTabela);
			$relatorio->document->setFonte($relatorio->fonteTextoTabela);
			$relatorio->document->Cell(0, 10, $empresa->getNomeContador() . " - " . $empresa->getRegistroContador(), 0, 1, "C", 0);
			$relatorio->document->Ln();
		}

		$relatorio->document->setCorFundo($relatorio->corFundoTabela);
		$relatorio->document->setCorTexto($relatorio->corTextoTabela);
		$relatorio->document->setFonte($relatorio->fonteTextoTabela);

		$relatorio->document->closeDoc("../pdfs/" . PDF_DEMO_RESULT);

		// Exibe mensagem...
		$msg = new MsgCw($msgCliqueAquiParaVisualizar, "../imagens/contabil.jpg", "javascript:history.go(-2);");
		$msg->mostraMsgLink("../pdfs/" . PDF_DEMO_RESULT, true);
		exit ();

	}

	/**
	*		consultaBalanco( $dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa,
	*										$paginaInicial, $exibeNaoLiberado, $exibeContador,
	*										$perfilUsuario )
	*		Mostra balanco de lancamentos, no formato HTML
	*		@param	$dataInicial	  Data inicial
	*		@param	$dataFinal		  Data final
	*		@param	$oidEmpresaCont   OID da empresa contabil
	*		@param	$oidEmpresa   OID da empresa
	*		@param	$paginaInicial	  Pagina inicial
	*		@param	$exibeNaoLiberado se true, exibe os lancamentos nao liberados pelo contador
	*		@param	$exibeContador	  se true, exibe dados do contador no final
	*		@param	$perfilUsuario	  Perfil do usuario
	*/
	function consultaBalanco($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $paginaInicial = 1, $exibeNaoLiberado, $exibeContador, $perfilUsuario) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$flagExibeNaoLiberado = ($exibeNaoLiberado == false) ? "S" : "N";

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();

		$empresa->pesquisaEmpresa($oidEmpresaCont);
		$lista = $conta->buscaConta($oidEmpresaCont, "");

		if ($lista[0][0] == "0")
			return "0";
		else {

			$temResultados = false;
			for ($indx = 0; $indx < sizeof($lista); $indx++) {

				$oidConta = explode(".", $lista[$indx][0]);

				$saldoPeriodo = $this->buscaSaldoConta($oidConta[0], $dataFinal, 'S');

				if (abs(round($saldoPeriodo, 2)) != 0 && $lista[$indx][6] != "O")
					$temResultados = true;

			}
			if ($temResultados) {
				return "2";
			}

			$this->geraBalancoTXTnovo($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $paginaInicial, $exibeNaoLiberado, $exibeContador, $perfilUsuario);
			// Seta variaveis auxiliares...
			$acaoAdicional = "javascript:window.print();";

			$voltar = $mostra == true ? "javascript:history.back();" : "javascript:history.back();";

			$infoAdicionais = "<font face=\"Verdana, Arial\" size=\"1\"><a href=\"../pdfs/" . TXT_BALANCO . "\">";
			$infoAdicionais .= $msgCliqueAquiParaVisualizarTXT;
			$infoAdicionais .= "</a></font>\n<br><br>\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"oidEmpresa\" ";
			$infoAdicionais .= "value=\"" . $oidEmpresa . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"oidEmpresaCont\" ";
			$infoAdicionais .= "value=\"" . $oidEmpresaCont . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"dataInicial\" ";
			$infoAdicionais .= "value=\"" . $dataInicial . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"dataFinal\" ";
			$infoAdicionais .= "value=\"" . $dataFinal . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"paginaInicial\" ";
			$infoAdicionais .= "value=\"" . $paginaInicial . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"exibeNaoLiberado\" ";
			$infoAdicionais .= "value=\"" . $exibeNaoLiberado . "\">\n";
			$infoAdicionais .= "<input type=\"hidden\" name=\"exibeContador\" ";
			$infoAdicionais .= "value=\"" . $exibeContador . "\">\n";
			if ($perfilUsuario != "O") {
				$infoAdicionais .= "<input type=\"hidden\" name=\"controleNavegacao\" ";
				$infoAdicionais .= "value=\"2\">\n";
				$infoAdicionais .= "<input type=\"submit\" name=\"gerar\" class=\"bjanela\" ";
				$infoAdicionais .= "value=\"" . $botaoGerarPDF . "\">\n";
			} else {
				$infoAdicionais .= "<input type=\"hidden\" name=\"controleNavegacao\" ";
				$infoAdicionais .= "value=\"3\">\n";
				$infoAdicionais .= "<input type=\"submit\" name=\"gerar\" class=\"bjanela\" ";
				$infoAdicionais .= "value=\"" . $botaoVisualizarPDF . "\">\n";
			}
			$infoAdicionais .= "<input type=\"button\" name=\"imprimir\" class=\"bjanela\" ";
			$infoAdicionais .= "value=\"" . $botaoImprimir . "\" onClick=\"" . $acaoAdicional . "\">\n";

			// Cabecalho...
			$cabecalho = "<font face=\"Verdana, Arial\" color=\"#000099\" size=\"2\">";
			$cabecalho .= $empresa->getOidEmpresaCont() . " - " . $empresa->getRazaoSocial();
			$cabecalho .= "<br>";
			$cabecalho .= $dataInicial . " - " . $dataFinal . "</font><br><br>";

			// Cria relatorio...
			$relatorio = new RelatorioHTMLCw($oidEmpresa, $relatorioBalanco, $cabecalho);

			// Inicia apresentacao do relatorio...
			$relatorio->inicioRelatorio();

			$relatorio->mostraString("<table width=\"100%\" border=\"0\">");
			$relatorio->mostraString("<tr>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"15%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioConta);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"45%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioDescricao);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"20%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioDebito);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"20%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioCredito);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("</tr>");

			$contLinha = 0;
			$somaDebito = $somaCredito = 0;
			$totalBalanco = -1;
			// Comeca laco para apresentacao do relatorio...
			for ($indx = 0; $indx < sizeof($lista); $indx++) {

				$oidConta = explode(".", $lista[$indx][0]);

				$saldoPeriodo = $this->buscaSaldoConta($oidConta[0], $dataFinal, "S");
				if ($totalBalanco == -1) // Guarda o saldo da 1a. conta (ativo)
					$totalBalanco = $saldoPeriodo;

				if (abs(round($saldoPeriodo, 2)) != 0) {

					if ($lista[$indx][6] == "O") {

						// Define cor da linha
						$cor = ($contLinha % 2) == 0 ? "lcons1" : "lcons2";
						$contLinha++;

						$relatorio->mostraString("<tr>");

						// Codigo Sintetico...
						$relatorio->mostraString("<td align=\"left\" width=\"15%\" class=\"" . $cor . "\">");
						$relatorio->mostraString($lista[$indx][1]);
						$relatorio->mostraString("</td>");

						// Descricao...
						$relatorio->mostraString("<td align=\"left\" width=\"45%\" class=\"" . $cor . "\">");
						$relatorio->mostraString($lista[$indx][2]);
						$relatorio->mostraString("</td>");

						// Debito...
						$relatorio->mostraString("<td align=\"right\" width=\"20%\" class=\"" . $cor . "\">");
						if ($saldoPeriodo > 0) {
							if ($lista[$indx][4] == "A")
								$somaDebito += $saldoPeriodo;
							$relatorio->mostraString(Numero :: convReal($saldoPeriodo));
						} else
							$relatorio->mostraString("&nbsp;");
						$relatorio->mostraString("</td>");

						// Credito...
						$relatorio->mostraString("<td align=\"right\" width=\"20%\" class=\"" . $cor . "\">");
						if ($saldoPeriodo <= 0) {
							if ($lista[$indx][4] == "A")
								$somaCredito += ($saldoPeriodo * -1);
							$relatorio->mostraString(Numero :: convReal($saldoPeriodo));
						} else
							$relatorio->mostraString("&nbsp;");
						$relatorio->mostraString("</td>");

						$relatorio->mostraString("</tr>");
					}
				}
			} // Fim do indx...

			// Finaliza relatorio...
			$relatorio->mostraString("</table>");

			if (!empty ($exibeNaoLiberado) && $exibeNaoLiberado) {
				$relatorio->mostraString("<br><table class=\"pagina\" border=\"0\" width=\"100%\">");
				$relatorio->mostraString("<tr><td width=\"100%\" align=\"left\" class=\"lcons11\">");
				$relatorio->mostraString($msgConsLancamentosNaoLiberados);
				$relatorio->mostraString("</td></tr></table><br>");
			}

			$num = new Numero();
			$relatorio->mostraString("<table class=\"pagina\" border=\"0\" width=\"100%\">");
			$relatorio->mostraString("<tr><td width=\"70%\" align=\"center\" class=\"lcons2\">");
			$relatorio->mostraString($msgBalanco . " " . Numero :: convReal($totalBalanco) . " (" . $num->extenso($totalBalanco, true, 3) . ")");
			$relatorio->mostraString("</td></tr></table>");

			// Testa se precisa exibir dados do contador...
			if (!empty ($exibeContador) && $exibeContador) {
				$relatorio->mostraString("<br><table class=\"pagina\" border=\"0\" width=\"100%\">");
				$relatorio->mostraString("<tr><td width=\"100%\" align=\"center\" class=\"lcons2\">");
				$relatorio->mostraString($empresa->getNomeContador());
				$relatorio->mostraString("</td></tr><tr><td width=\"100%\" align=\"center\" class=\"lcons2\">");
				$relatorio->mostraString($empresa->getRegistroContador());
				$relatorio->mostraString("</td></tr></table><br><br>");
			}

			$relatorio->fimRelatorio("cwConsBalanco.php", $infoAdicionais, $voltar);

			return "1";

		} // Fim da decisao de validacao do array

	}

	/**
	*		geraBalancoTXT( $dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa,
	*										$paginaInicial, $exibeNaoLiberado, $exibeContador,
	*										$perfilUsuario )
	*		Gera o Balanço, no formato TXT
	*		@param	$dataInicial	  Data inicial
	*		@param	$dataFinal		  Data final
	*		@param	$oidEmpresaCont   OID da empresa contabil
	*		@param	$oidEmpresa   OID da empresa
	*		@param	$paginaInicial	  Pagina inicial
	*		@param	$exibeNaoLiberado se true, exibe os lancamentos nao liberados pelo contador
	*		@param	$exibeContador	  se true, exibe dados do contador no final
	*		@param	$perfilUsuario	  Perfil do usuario
	*/
	function geraBalancoTXT($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $paginaInicial, $exibeNaoLiberado, $exibeContador, $perfilUsuario) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$flagExibeNaoLiberado = ($exibeNaoLiberado == false) ? "S" : "N";

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();

		$empresa->pesquisaEmpresa($oidEmpresaCont);
		$lista = $conta->buscaConta($oidEmpresaCont, "");

		if ($lista[0][0] == "0")
			return "0";
		else {

			$temResultados = false;
			for ($indx = 0; $indx < sizeof($lista); $indx++) {

				$oidConta = explode(".", $lista[$indx][0]);

				$saldoPeriodo = $this->buscaSaldoConta($oidConta[0], $dataFinal, 'S');

				if (abs(round($saldoPeriodo, 2)) != 0 && $lista[$indx][6] != "O")
					$temResultados = true;

			}
			if ($temResultados) {
				return "2";
			}

			// Cria relatorio...
			$relatorioTXT = new RelatorioTXT();
			$relatorioTXT->setConf("../pdfs/" . TXT_BALANCO);

			// Inicia apresentacao do relatorio...
			$relatorioTXT->inicioRelatorio();

			$contadorLinhas = 70;
			$contadorPagina = $paginaInicial -1;
			$somaDebito = $somaCredito = 0;
			$totalBalanco = -1;
			// Comeca laco para apresentacao do relatorio...
			for ($indx = 0; $indx < sizeof($lista); $indx++) {

				$oidConta = explode(".", $lista[$indx][0]);

				$saldoPeriodo = $this->buscaSaldoConta($oidConta[0], $dataFinal, "S");
				if ($totalBalanco == -1) // Guarda o saldo da 1a. conta (ativo)
					$totalBalanco = $saldoPeriodo;

				if (abs(round($saldoPeriodo, 2)) != 0) {

					if ($lista[$indx][6] == "O") {

						if ($contadorLinhas > 52) {
							$contadorPagina++;
							$linhaCabec = str_pad("=", 132, "=") . CRLF;
							$relatorioTXT->mostraString(chr(15) . str_pad(" ", 38) . "B A L A N C O" . CRLF);
							$relatorioTXT->mostraString(String :: removeAcento(sprintf("%-40s", $empresa->getRazaoSocial())) . str_pad(" ", 85) . "FL." . str_pad($contadorPagina, 4, "0", STR_PAD_LEFT) . CRLF);
							$relatorioTXT->mostraString($linhaCabec);
							$relatorioTXT->mostraString(str_pad(" ", 4) . "Conta" . str_pad(" ", 8) . "D e s c r i c a o" . str_pad(" ", 37) . "Debito" . str_pad(" ", 11) . "Credito" . CRLF);
							$relatorioTXT->mostraString($linhaCabec);
							$contadorLinhas = 0;
						}

						// Codigo Sintetico...
						$relatorioTXT->mostraString($lista[$indx][1]);
						$relatorioTXT->mostraString(str_pad(" ", 3));

						// Descricao...
						$descricao = sprintf("%-45s", String :: removeAcento($lista[$indx][2]));
						$relatorioTXT->mostraString($descricao);

						// Debito...
						if ($saldoPeriodo > 0) {
							if ($lista[$indx][4] == "A")
								$somaDebito += $saldoPeriodo;
							$stringDebito = sprintf("%15s", Numero :: convReal($saldoPeriodo));
							$relatorioTXT->mostraString($stringDebito);
						} else
							$relatorioTXT->mostraString(str_pad(" ", 15));
						$relatorioTXT->mostraString(str_pad(" ", 3));

						// Credito...
						if ($saldoPeriodo <= 0) {
							if ($lista[$indx][4] == "A")
								$somaCredito += ($saldoPeriodo * -1);
							$stringCredito = sprintf("%15s", Numero :: convReal($saldoPeriodo));
							$relatorioTXT->mostraString($stringCredito);
						} else
							$relatorioTXT->mostraString(str_pad(" ", 15));
						$relatorioTXT->mostraString(CRLF);
						$contadorLinhas++;
						if ($contadorLinhas > 52)
							$relatorioTXT->mostraString(FF);
					}
				}
			} // Fim do indx...

			// Finaliza relatorio...
			$relatorioTXT->mostraString(CRLF);

			if (!empty ($exibeNaoLiberado) && $exibeNaoLiberado) {
				$relatorioTXT->mostraString($msgConsLancamentosNaoLiberados);
				$relatorioTXT->mostraString(CRLF);
			}

			$num = new Numero();
			$stringEncerramento = $msgBalanco . " " . Numero :: convReal($totalBalanco) . " (" . $num->extenso($totalBalanco, true, 3) . ").";
			$string1 = substr($stringEncerramento, 0, 132);
			$string2 = substr($stringEncerramento, 132, 132);

			$relatorioTXT->mostraString($string1 . CRLF);
			$relatorioTXT->mostraString($string2 . CRLF . CRLF);

			// Testa se precisa exibir dados do contador...
			if (!empty ($exibeContador) && $exibeContador) {
				$relatorioTXT->mostraString(str_pad(" ", 20) . $empresa->getNomeContador() . CRLF);
				$relatorioTXT->mostraString(str_pad(" ", 20) . $empresa->getRegistroContador());
			}
			$relatorioTXT->mostraString(FF);
			$relatorioTXT->fimRelatorio();

			return "1";

		} // Fim da decisao de validacao do array

	}

	/**
	*		geraBalancoTXTnovo( $dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa,
	*										$paginaInicial, $exibeNaoLiberado, $exibeContador,
	*										$perfilUsuario )
	*		Gera o Balanço, no formato TXT (novo layout)
	*		@param	$dataInicial	  Data inicial
	*		@param	$dataFinal		  Data final
	*		@param	$oidEmpresaCont   OID da empresa contabil
	*		@param	$oidEmpresa   OID da empresa
	*		@param	$paginaInicial	  Pagina inicial
	*		@param	$exibeNaoLiberado se true, exibe os lancamentos nao liberados pelo contador
	*		@param	$exibeContador	  se true, exibe dados do contador no final
	*		@param	$perfilUsuario	  Perfil do usuario
	*/
	function geraBalancoTXTnovo($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $paginaInicial, $exibeNaoLiberado, $exibeContador, $perfilUsuario) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$flagExibeNaoLiberado = ($exibeNaoLiberado == false) ? "S" : "N";

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();

		$empresa->pesquisaEmpresa($oidEmpresaCont);
		$lista = $conta->buscaConta($oidEmpresaCont, "");

		if ($lista[0][0] == "0")
			return "0";
		else {

			$temResultados = false;
			for ($indx = 0; $indx < sizeof($lista); $indx++) {

				$oidConta = explode(".", $lista[$indx][0]);

				$saldoPeriodo = $this->buscaSaldoConta($oidConta[0], $dataFinal, 'S');

				if (abs(round($saldoPeriodo, 2)) != 0 && $lista[$indx][6] != "O")
					$temResultados = true;

			}
			if ($temResultados) {
				return "2";
			}

			// Cria relatorio...
			$relatorioTXT = new RelatorioTXT();
			$relatorioTXT->setConf("../pdfs/" . TXT_BALANCO);

			// Inicia apresentacao do relatorio...
			$relatorioTXT->inicioRelatorio();

			$contadorLinhas = 70;
			$contadorPagina = $paginaInicial -1;
			$somaDebito = $somaCredito = 0;
			$totalBalanco = -1;
			
			$ultimoGrupo = 'I';  // Último Grupo impresso é indefinido
			
			// Comeca laco para apresentacao do relatorio...
			for ($indx = 0; $indx < sizeof($lista); $indx++) {

				$oidConta = explode(".", $lista[$indx][0]);

				$saldoPeriodo = $this->buscaSaldoConta($oidConta[0], $dataFinal, "S");
				if ($totalBalanco == -1) // Guarda o saldo da 1a. conta (ativo)
					$totalBalanco = $saldoPeriodo;

				if (abs(round($saldoPeriodo, 2)) != 0) {

					if ($lista[$indx][6] == "O") {

						if ($contadorLinhas > 52) {
							$contadorPagina++;
							$linhaCabec = str_pad("=", 79, "=") . CRLF;
							$relatorioTXT->mostraString(String :: removeAcento(sprintf("%-40s", $empresa->getRazaoSocial())) . CRLF);
							$relatorioTXT->mostraString("C.N.P.J.: " . $empresa->getCnpj() . CRLF);
							$relatorioTXT->mostraString(str_pad(" ", 19) . "B A L A N C O" . str_pad(" ",3) . "P A T R I M O N I A L".str_pad(" ", 15) . "FL." . str_pad($contadorPagina, 4, "0", STR_PAD_LEFT) . CRLF);
							$relatorioTXT->mostraString(str_pad(" ",26) . "LEVANTADO EM ". $dataFinal . CRLF);
							$relatorioTXT->mostraString($linhaCabec);
							$relatorioTXT->mostraString(str_pad(" ", 17) . "D e s c r i c a o" . str_pad(" ", 37) . "Saldo" . CRLF);
							$relatorioTXT->mostraString($linhaCabec);
							$contadorLinhas = 0;
						}

						// Se for uma conta sintetica, deixa uma linha em branco
						if ($lista[$indx][4] == "S") {
							$relatorioTXT->mostraString(" " . CRLF);
							$contadorLinhas++;
						}

						// Identação de descricão
						$tamanhoString = strlen(trim($lista[$indx][1]));
						$relatorioTXT->mostraString(str_pad(" ", $tamanhoString));
						$relatorioTXT->mostraString(str_pad(" ", 2));

						// Descricao...
						$descricao = sprintf("%-43s", String :: removeAcento($lista[$indx][2]));
						$relatorioTXT->mostraString($descricao);
						$relatorioTXT->mostraString(str_pad(" ", (20 - $tamanhoString)));

						if ($lista[$indx][4] == "A") {
							if ($saldoPeriodo > 0)
								$somaDebito += $saldoPeriodo;
							else
								$somaCredito += ($saldoPeriodo * -1);
						}

                        // Analisa se está imprimindo o Ativo ou o Passivo                        
                        if  (strlen(trim($lista[$indx][1])) == 1) {
                        	if ($ultimoGrupo == 'I') 
                        	   $ultimoGrupo = 'A';
                        	else
                        	   $ultimoGrupo = 'P';
                        }
                        // Analisa se a conta é redutora ou não
                        $contaRedutora = false;
                        if ( ($saldoPeriodo < 0) && ($ultimoGrupo == 'A')) $contaRedutora = true;
                        if ( ($saldoPeriodo > 0) && ($ultimoGrupo == 'P')) $contaRedutora = true;
                        
						// Imprime o saldo
						if ($contaRedutora == true)
							$stringSaldo = '(' . sprintf("%12s", Numero :: convReal($saldoPeriodo)) . ')';
						else
							$stringSaldo = ' ' . sprintf("%12s", Numero :: convReal($saldoPeriodo)) . ' ';
						$relatorioTXT->mostraString($stringSaldo);
						$relatorioTXT->mostraString(CRLF);
						$contadorLinhas++;

						if ($contadorLinhas > 52)
							$relatorioTXT->mostraString(FF);
					}
				}
			} // Fim do indx...

			// Finaliza relatorio...
			$relatorioTXT->mostraString(CRLF);

			if (!empty ($exibeNaoLiberado) && $exibeNaoLiberado) {
				$relatorioTXT->mostraString($msgConsLancamentosNaoLiberados);
				$relatorioTXT->mostraString(CRLF);
			}

			$num = new Numero();
			$stringEncerramento = $msgBalanco . " " . Numero :: convReal($totalBalanco) . " (" . $num->extenso($totalBalanco, true, 3) . ").";
			$string1 = substr($stringEncerramento,  0, 72);
			$string2 = substr($stringEncerramento, 72, 79);
			$string3 = substr($stringEncerramento,151, 79);
			$string4 = substr($stringEncerramento,230, 79);

			$relatorioTXT->mostraString(str_pad(" ",8).$string1 . CRLF);
			$relatorioTXT->mostraString(trim($string2));
			if (!empty($string3)) $relatorioTXT->mostraString(CRLF . trim($string3));
			if (!empty($string4)) $relatorioTXT->mostraString(CRLF . trim($string4));
			$relatorioTXT->mostraString(CRLF);

			// Testa se precisa exibir dados do contador...
			if (!empty ($exibeContador) && $exibeContador) {
				$relatorioTXT->mostraString(CRLF);
				$relatorioTXT->mostraString(str_pad(" ", 12));
				$relatorioTXT->mostraString(String :: removeAcento(String :: upper($empresa->getNomeContador())) . str_pad(" ", 10) . String :: removeAcento(String :: upper($empresa->getResponsavel())));
				$relatorioTXT->mostraString(CRLF);
				$relatorioTXT->mostraString(str_pad(" ", 12));
				$relatorioTXT->mostraString($empresa->getRegistroContador() . str_pad(" ", 32) . $empresa->getCpfResponsavel());
				$relatorioTXT->mostraString(FF);
			}
			$relatorioTXT->mostraString(FF);
			$relatorioTXT->fimRelatorio();

			return "1";

		} // Fim da decisao de validacao do array

	}

	/**
	*		consultaBalancoPDF( $dataInicial, $dataFinal, $oidEmpresaCont,
	*						$oidEmpresa, $paginaInicial = 1, $exibeContador )
	*		Mostra consulta de balanco, somente os
	*								contabilizados, em formato PDF
	*		@param	$dataInicial	Data inicial
	*		@param	$dataFinal			Data final
	*	@param	$oidEmpresaCont OID da empresa contabil
	*		@param	$oidEmpresa	OID da empresa
	*		@param	$paginaInicial	Pagina inicial
	*		@param	$exibeContador	Exibe dados do contador
	*/
	function consultaBalancoPDF($dataInicial, $dataFinal, $oidEmpresaCont, $oidEmpresa, $paginaInicial, $exibeContador) {

		// Seta variaveis que possam ser utilizadas...
		$controleLinha = 1;
		$flagPreenchido = false;

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();

		$empresa->pesquisaEmpresa($oidEmpresaCont);
		$lista = $conta->buscaConta($oidEmpresaCont, "");

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$larguraColunas = array (
			25,
			100,
			25,
			25,
			25
		);
		$cabecalho = array (
			$relatorioCodigo,
			$relatorioDescricao,
			$relatorioDebito,
			$relatorioCredito
		);

		$totalDebito = $totalCredito = 0.0;

		// Cria relatorio...
		$relatorio = new RelatorioPDFCw($oidEmpresa, $relatorioBalanco, $oidEmpresaCont . " - " . $empresa->getRazaoSocial() . " - " . $dataInicial . " a " . $dataFinal, $tituloSistema, $campoTextoPagina, $paginaInicial, true, $larguraColunas, $cabecalho);

		// Gera instancia de documento...
		$relatorio->getInstancia();

		// Seta margens do documento
		$relatorio->document->SetMargins(10, 10, 10);
		$relatorio->document->Open();
		$relatorio->document->AliasNbPages();
		$relatorio->document->SetAutoPageBreak(true, 10);
		$relatorio->document->AddPage();

		$relatorio->document->setCorFundo(array (
			255,
			255,
			255
		));
		$relatorio->document->setCorTexto($relatorio->corTextoTabela);
		$relatorio->document->setFonte($relatorio->fonteTextoTabela);

		$relatorio->document->SetWidths($larguraColunas);
		$relatorio->document->SetLineWidth(.2);
		$relatorio->document->SetDrawColor(255, 255, 255);

		$somaDebito = $somaCredito = 0;
		$totalBalanco = -1;
		// Comeca laco para impressao do relatorio...
		for ($indx = 0; $indx < sizeof($lista); $indx++) {

			$oidConta = explode(".", $lista[$indx][0]);

			$saldoPeriodo = $this->buscaSaldoConta($oidConta[0], $dataFinal, "S");

			if ($totalBalanco == -1) // Guarda o saldo da 1a. conta (ativo)
				$totalBalanco = $saldoPeriodo;

			if (abs(round($saldoPeriodo, 2)) != 0) {

				if ($lista[$indx][6] == "O") {

					// Controla preenchimento (automato finito - :-)...
					$flagPreenchido = !$flagPreenchido;

					// Imprime os dados...
					$relatorio->document->Cell($larguraColunas[0], 4, $lista[$indx][1], "LR", 0, "L", $flagPreenchido);
					$relatorio->document->Cell($larguraColunas[1], 4, $lista[$indx][2], "LR", 0, "L", $flagPreenchido);
					if ($saldoPeriodo > 0) {
						if ($lista[$indx][4] == "A")
							$somaDebito += $saldoPeriodo;
						$relatorio->document->Cell($larguraColunas[2], 4, Numero :: convReal($saldoPeriodo), "LR", 0, "R", $flagPreenchido);
					} else
						$relatorio->document->Cell($larguraColunas[2], 4, " ", "LR", 0, "R", $flagPreenchido);
					if ($saldoPeriodo <= 0) {
						if ($lista[$indx][4] == "A")
							$somaCredito += ($saldoPeriodo * -1);
						$relatorio->document->Cell($larguraColunas[2], 4, Numero :: convReal($saldoPeriodo), "LR", 0, "R", $flagPreenchido);
					} else
						$relatorio->document->Cell($larguraColunas[2], 4, " ", "LR", 0, "R", $flagPreenchido);
					// Salta linha...
					$relatorio->document->Ln();

					// Incrementa linha...
					$controleLinha++;

					// Se terminou pagina...
					if (false) { // ( $controleLinha > 52 ) {
						$relatorio->document->AddPage();

						// Monta cabecalho da tabela...
						$relatorio->document->setFonte($relatorio->fonteTituloTabela);
						$relatorio->document->setCorTexto($relatorio->corTituloTabela);
						$relatorio->document->setCorBorda($relatorio->corBordaTabela);
						$relatorio->document->setCorTexto($relatorio->corTextoTabela);
						$relatorio->document->setFonte($relatorio->fonteTextoTabela);

						$relatorio->document->SetLineWidth(.2);

						for ($indx = 0; $indx < count($cabecalho); $indx++)
							$relatorio->document->Cell($larguraColunas[$indx], 4, $cabecalho[$indx], 1, 0, "C", 1);
						$relatorio->document->Ln();

						$relatorio->document->setCorFundo(array (
							255,
							255,
							255
						));
						$relatorio->document->setCorTexto($relatorio->corTextoTabela);
						$relatorio->document->setFonte($relatorio->fonteTextoTabela);

						$controleLinha = 1;
					}
				}

			}

		} // Fim do indx...

		$num = new Numero();
		$relatorio->document->Ln();
		$relatorio->document->setCorTexto($relatorio->corTextoTabela);
		$relatorio->document->setFonte($relatorio->fonteTextoTabela);

		$relatorio->document->Cell(0, 0, $msgBalanco . " " . Numero :: convReal($totalBalanco), 0, 1, "C", 0);
		$relatorio->document->Ln();
		$relatorio->document->Cell(0, 10, $num->extenso($totalBalanco, true, 3) . ")", 0, 1, "C", 0);

		// Testa se tem que colocar dados da contadora...
		if (!empty ($exibeContador) && $exibeContador) {
			$relatorio->document->Ln();
			$relatorio->document->Ln();
			$relatorio->document->Ln();
			$relatorio->document->Ln();
			$relatorio->document->setCorTexto($relatorio->corTextoTabela);
			$relatorio->document->setFonte($relatorio->fonteTextoTabela);
			$relatorio->document->Cell(0, 10, $empresa->getNomeContador() . " - " . $empresa->getRegistroContador(), 0, 1, "C", 0);
			$relatorio->document->Ln();
		}
		$relatorio->document->setCorFundo(array (
			255,
			255,
			255
		));
		$relatorio->document->setCorTexto($relatorio->corTextoTabela);
		$relatorio->document->setFonte($relatorio->fonteTextoTabela);

		$relatorio->document->closeDoc("../pdfs/" . PDF_BALANCO);

		// Exibe mensagem...
		$msg = new MsgCw($msgCliqueAquiParaVisualizar, "../imagens/contabil.jpg", "javascript:history.go(-2);");
		$msg->mostraMsgLink("../pdfs/" . PDF_BALANCO, true);
		exit ();

	}

	/**
	*		buscaOidZeramento( $oidEmpresaCont )
	*		Busca OID de zeramento
	*		@param	 $oidEmpresaCont		OID da Empresa Contabil
	*		@return  $oidZeramento		OID de zeramento
	*/
	function buscaOidZeramento($oidEmpresaCont) {

		$oidZeramento = $this->persistence->findByOidZeramento($oidEmpresaCont);
		$oidZeramento++;

		return $oidZeramento;

	}

	/**
	*		verificaLancamentosAbertos( $oidEmpresa )
	*		Mostra os lancamentos em aberto da contabilidade
	*		@param	 $oidEmpresa  OID da empresa
	*		@return  false se nao achou nenhum
	*/
	function verificaLancamentosAbertos($oidEmpresa) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";

		// Instancia objetos, seta atributos...
		$empresa = new Empresa();
		$this->persistence->searchAllLancamentos();
		$lista = $this->persistence->getList();

		if ($lista[0][0] == "0")
			return false;
		else {

			// Seta variaveis auxiliares...
			$acaoAdicional = "javascript:window.print();";

			$voltar = "javascript:history.back();";

			$infoAdicionais = "<input type=\"button\" name=\"imprimir\" class=\"bjanela\" ";
			$infoAdicionais .= "value=\"" . $botaoImprimir . "\" onClick=\"" . $acaoAdicional . "\">\n";

			// Cabecalho...
			$cabecalho = "<br>";

			// Cria relatorio...
			$relatorio = new RelatorioHTMLCw($oidEmpresa, $relatorioVerificacaoLanc, $cabecalho);

			// Inicia apresentacao do relatorio...
			$relatorio->inicioRelatorio();

			$relatorio->mostraString("<table width=\"100%\" border=\"0\">");
			$relatorio->mostraString("<tr>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"50%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioEmpresa);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"center\" width=\"10%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioLancamento);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"center\" width=\"10%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioData);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"10%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioDebito);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"10%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioCredito);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"10%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioDiferenca);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("</tr>");

			$totalDebito = $totalCredito = 0.0;
			$flagCor = true;
			// Comeca laco para apresentacao do relatorio...
			for ($indx = 0; $indx < sizeof($lista); $indx++) {

				$empresa->pesquisaEmpresa($lista[$indx][2]);
				$totalDebito = $this->buscaSomaItens($lista[$indx][0], "D");
				$totalCredito = $this->buscaSomaItens($lista[$indx][0], "C");

				if ($totalDebito != $totalCredito) {

					// Define cor da linha
					$cor = ($flagCor == true) ? "lcons1" : "lcons2";
					$flagCor = !$flagCor;

					// Pesquisa dados da conta...
					$relatorio->mostraString("<tr>");

					// Descricao da Empresa...
					$relatorio->mostraString("<td align=\"left\" width=\"50%\" class=\"" . $cor . "\">");
					$relatorio->mostraString($empresa->getRazaoSocial());
					$relatorio->mostraString("</td>");

					// Codigo do lancamento...
					$relatorio->mostraString("<td align=\"center\" width=\"10%\" class=\"" . $cor . "\">");
					$relatorio->mostraString($lista[$indx][0]);
					$relatorio->mostraString("</td>");

					// Data do lancamento...
					$relatorio->mostraString("<td align=\"center\" width=\"10%\" class=\"" . $cor . "\">");
					$relatorio->mostraString($lista[$indx][1]);
					$relatorio->mostraString("</td>");

					// Debito...
					$relatorio->mostraString("<td align=\"right\" width=\"10%\" class=\"" . $cor . "\">");
					$relatorio->mostraString(Numero :: convReal($totalDebito));
					$relatorio->mostraString("</td>");

					// Credito...
					$relatorio->mostraString("<td align=\"right\" width=\"10%\" class=\"" . $cor . "\">");
					$relatorio->mostraString(Numero :: convReal($totalCredito));
					$relatorio->mostraString("</td>");

					// Diferenca...
					$relatorio->mostraString("<td align=\"right\" width=\"10%\" class=\"" . $cor . "\">");
					$relatorio->mostraString(Numero :: convReal($totalDebito - $totalCredito));
					$relatorio->mostraString("</td>");

					$relatorio->mostraString("</tr>");

					$this->ajustaLancamento($lista[$indx][0]);

				}

			} // Fim do for indx...

			// Finaliza relatorio...
			$relatorio->mostraString("</table>");
			$relatorio->fimRelatorio("cwVerificaLancs.php", $infoAdicionais, $voltar);

			return true;

		} // Fim da decisao de validacao do array

	}

	/**
	*		mostraItens( $oidLancamento )
	*		Mostra itens de lancamento
	*		@param	$oidLancamento	OID de lancamento
	*/
	function mostraItens($oidLancamento) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";

		$this->setOidLancamento($oidLancamento);
		$this->pesquisaLancamento($this->getOidLancamento());

		$strVolta = "javascript:window.close();";

		$empresa = new Empresa();
		$itemLancamento = new ItemLancamento();
		$conta = new Conta();

		$empresa->pesquisaEmpresa($this->getOidEmpresaCont());
		$lista = $itemLancamento->buscaItemLancamento($this->getOidLancamento());

		echo "<br><br><br>\n";
		echo "<center>\n";
		echo "<font face=\"Verdana, Arial\" color=\"#000000\" size=\"2\">\n";
		echo "<b>\n";
		echo $relatorioItensLancamento . "&nbsp;" . $this->getOidLancamento();
		echo "</b><br><br>\n";
		echo $empresa->getOidEmpresaCont() . " - " . $empresa->getRazaoSocial() . "<br>";
		echo $campoDataLanc . $this->getDataLancamento();
		echo "</font></center><br><form>\n";
		echo "<table border=\"0\" width=\"100%\">\n";
		echo "<tr>\n<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"12%\"";
		echo "class=\"tjanela\" align=\"center\">\n";
		echo $relatorioConta;
		echo "</td>\n<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"30%\"";
		echo "class=\"tjanela\" align=\"center\">\n";
		echo $relatorioDescricao;
		echo "</td>\n<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"34%\"";
		echo "class=\"tjanela\" align=\"center\">\n";
		echo $relatorioHistorico;
		echo "</td>\n<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"12%\"";
		echo "class=\"tjanela\" align=\"right\">\n";
		echo $relatorioDebito;
		echo "</td>\n<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"12%\"";
		echo "class=\"tjanela\" align=\"right\">\n";
		echo $relatorioCredito;
		echo "</td>\n</tr>\n";

		$totalDebito = $totalCredito = 0.0;
		for ($indx = 0; $indx < sizeof($lista); $indx++) {
			$cor = ($indx % 2) == 0 ? "lcons8" : "lcons9";

			$oidConta = $lista[$indx][2] . "." . Numero :: modulo11($lista[$indx][2]);
			$conta->pesquisaConta($oidConta);

			echo "<tr>\n";
			echo "<td width=\"12%\" align=\"center\" class=\"$cor\">\n";
			echo $conta->getCodigoSintetico() . " (" . $conta->getOidContaDV() . ")";
			echo "</td><td width=\"30%\" align=\"left\" class=\"$cor\">\n";
			echo $conta->getDescricao();
			echo "</td>\n<td width=\"34%\" align=\"left\" class=\"$cor\">\n";
			echo $lista[$indx][3];
			echo "</td>\n<td width=\"12%\" align=\"right\" class=\"$cor\">\n";
			if ($lista[$indx][5] == "D") {
				if ($lista[$indx][4] > 0)
					echo Numero :: convReal($lista[$indx][4]);
			} else
				echo "&nbsp;";
			echo "</td>\n<td width=\"12%\" align=\"right\" class=\"$cor\">\n";
			if ($lista[$indx][5] == "C") {
				if ($lista[$indx][4] > 0)
					echo Numero :: convReal($lista[$indx][4]);
			} else
				echo "&nbsp;";
			echo "</td>\n</tr>\n";

			if ($lista[$indx][5] == "D")
				$totalDebito += $lista[$indx][4];
			else
				$totalCredito += $lista[$indx][4];
		}

		echo "<tr>\n<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"12%\" ";
		echo "class=\"tjanela\" align=\"left\">&nbsp;</td>\n";
		echo "<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"30%\" ";
		echo "class=\"tjanela\" align=\"left\">&nbsp;</td>\n";
		echo "<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"34%\" ";
		echo "class=\"tjanela\" align=\"right\">" . $relatorioTotais . "</td>\n";
		echo "<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"12%\" ";
		echo "class=\"tjanela\" align=\"right\">" . Numero :: convReal($totalDebito) . "</td>\n";
		echo "<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"12%\" ";
		echo "class=\"tjanela\" align=\"right\">" . Numero :: convReal($totalCredito) . "</td>\n";
		echo "</tr>\n</table>\n";

		echo "<table class=\"pagina\" border=\"0\" width=\"100%\">\n";
		echo "<tr>\n<td width=\"100%\" align=\"center\">\n";
		echo "<input type=\"button\" class=\"bjanela\" value=\"$botaoImprimir\" name=\"bt_imprimir\" ";
		echo "OnClick=\"javascript:window.print();\">&nbsp;";
		echo "<input type=\"button\" class=\"bjanela\" value=\"$botaoVoltar\" name=\"bt_voltar\" ";
		echo " OnClick=\"$strVolta\">\n";
		echo "</td>\n</tr>\n</table>\n<br><br>\n</form>\n";

	}

	/**
	*		consultaRetrospectiva( $ano, $oidEmpresaCont, $oidEmpresa,
	*					  $exibeNaoLiberado, $perfilUsuario, $desconsiderarZeramento )
	*		Mostra retrospectiva de contas, no formato HTML
	*		@param	$ano					Ano
	*		@param	$oidEmpresaCont 		OID da empresa contabil
	*		@param	$oidEmpresa		OID da empresa
	*		@param	$exibeNaoLiberado		se true, exibe os lancamentos nao liberados pelo contador
	*		@param	$perfilUsuario			Perfil do usuario
	*		@param	$desconsiderarZeramento Desconsidera zeramento
	*/
	function consultaRetrospectiva($ano, $oidEmpresaCont, $oidEmpresa, $exibeNaoLiberado, $perfilUsuario, $desconsiderarZeramento) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$flagExibeNaoLiberado = ($exibeNaoLiberado == false) ? "S" : "N";

		// Instancia objetos, seta atributos...
		$itemLancamento = new ItemLancamento();
		$empresa = new Empresa();
		$conta = new Conta();
		$arrayDias = array (
			31,
			28,
			31,
			30,
			31,
			30,
			31,
			31,
			30,
			31,
			30,
			31
		);

		if ($ano % 4 == 0)
			$arrayDias[1] = 29;

		$empresa->pesquisaEmpresa($oidEmpresaCont);
		$lista = $conta->buscaConta($oidEmpresaCont, "");

		if ($lista[0][0] == "0")
			return false;
		else {

			// Seta variaveis auxiliares...
			$acaoAdicional = "javascript:window.print();";

			$voltar = $mostra == true ? "javascript:history.back();" : "javascript:history.back();";

			$infoAdicionais = "<br>\n";
			$infoAdicionais .= "<input type=\"button\" name=\"imprimir\" class=\"bjanela\" ";
			$infoAdicionais .= "value=\"" . $botaoImprimir . "\" onClick=\"" . $acaoAdicional . "\">\n";

			// Cabecalho...
			$cabecalho = "<font face=\"Verdana, Arial\" color=\"#000099\" size=\"2\">";
			$cabecalho .= $empresa->getOidEmpresaCont() . " - " . $empresa->getRazaoSocial();
			$cabecalho .= "<br>";
			$cabecalho .= $ano . "</font><br><br>";

			// Cria relatorio...
			$relatorio = new RelatorioHTMLCw($oidEmpresa, $relatorioRetrospectiva, $cabecalho);

			// Inicia apresentacao do relatorio...
			$relatorio->inicioRelatorio();

			$relatorio->mostraString("<table width=\"100%\" border=\"0\">");
			$relatorio->mostraString("<tr>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"left\" width=\"36%\" class=\"tjanela\">");
			$relatorio->mostraString($relatorioDescricao);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"9%\" class=\"tjanela\">");
			$relatorio->mostraString($campoJan . "/" . $campoJul);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"9%\" class=\"tjanela\">");
			$relatorio->mostraString($campoFev . "/" . $campoAgo);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"9%\" class=\"tjanela\">");
			$relatorio->mostraString($campoMar . "/" . $campoSet);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"9%\" class=\"tjanela\">");
			$relatorio->mostraString($campoAbr . "/" . $campoOut);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"9%\" class=\"tjanela\">");
			$relatorio->mostraString($campoMai . "/" . $campoNov);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"9%\" class=\"tjanela\">");
			$relatorio->mostraString($campoJun . "/" . $campoDez);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("<td background=\"../imagens/cw_janela.gif\" align=\"right\" width=\"10%\" class=\"tjanela\">");
			$relatorio->mostraString($campoTotal);
			$relatorio->mostraString("</td>");
			$relatorio->mostraString("</tr>");

			$dataLimite = Data :: somaDia($dataInicial, -1);
			$contLinha = 0;

			// Comeca laco para apresentacao do relatorio...
			for ($indx = 0; $indx < sizeof($lista); $indx++) {

				$oidConta = explode(".", $lista[$indx][0]);

				// Define cor da linha
				$cor = ($contLinha % 2) == 0 ? "lcons1" : "lcons2";
				$contLinha++;

				$relatorio->mostraString("<tr>");

				// Descricao...
				$relatorio->mostraString("<td align=\"left\" width=\"36%\" class=\"" . $cor . "\">");
				$relatorio->mostraString($lista[$indx][1] . "<br>");
				$relatorio->mostraString($lista[$indx][2]);
				$relatorio->mostraString("</td>");

				$total = 0;
				for ($indy = 0; $indy < 6; $indy++) {

					// Monta datas...
					if (($indy +1) < 10)
						$mes = "0" . ($indy +1);
					else
						$mes = $indy +1;

					$dataInicial = "01/" . $mes . "/" . $ano;
					$dataFinal = $arrayDias[$indy] . "/" . $mes . "/" . $ano;

					$debitoPeriodo = $this->buscaMovimentoConta($oidConta[0], $dataInicial, $dataFinal, $flagExibeNaoLiberado, "D", $desconsiderarZeramento);
					$creditoPeriodo = $this->buscaMovimentoConta($oidConta[0], $dataInicial, $dataFinal, $flagExibeNaoLiberado, "C", $desconsiderarZeramento);

					if ($lista[$indx][3] == "D")
						$movimentoMes = $debitoPeriodo - $creditoPeriodo;
					else
						$movimentoMes = $creditoPeriodo - $debitoPeriodo;

					$total += $movimentoMes;
					// Meses...
					$relatorio->mostraString("<td align=\"right\" width=\"9%\" class=\"" . $cor . "\">");
					$relatorio->mostraString(Numero :: convReal($movimentoMes, true));

					// Monta datas...
					$indz = $indy +6;
					if (($indz +1) < 10)
						$mes = "0" . ($indz +1);
					else
						$mes = $indz +1;

					$dataInicial = "01/" . $mes . "/" . $ano;
					$dataFinal = $arrayDias[$indz] . "/" . $mes . "/" . $ano;

					$debitoPeriodo = $this->buscaMovimentoConta($oidConta[0], $dataInicial, $dataFinal, $flagExibeNaoLiberado, "D", $desconsiderarZeramento);
					$creditoPeriodo = $this->buscaMovimentoConta($oidConta[0], $dataInicial, $dataFinal, $flagExibeNaoLiberado, "C", $desconsiderarZeramento);

					if ($lista[$indx][3] == "D")
						$movimentoMes = $debitoPeriodo - $creditoPeriodo;
					else
						$movimentoMes = $creditoPeriodo - $debitoPeriodo;

					$total += $movimentoMes;

					$relatorio->mostraString("<br>");
					$relatorio->mostraString(Numero :: convReal($movimentoMes, true));
					$relatorio->mostraString("</td>");

				} // Fim do indy...

				$relatorio->mostraString("<td align=\"right\" width=\"10%\" class=\"" . $cor . "\">");
				$relatorio->mostraString(Numero :: convReal($total, true));
				$relatorio->mostraString("</td>");

				$relatorio->mostraString("</tr>");

			} // Fim do indx...

			// Finaliza relatorio...
			$relatorio->mostraString("</table>");

			if (!empty ($exibeNaoLiberado) && $exibeNaoLiberado) {
				$relatorio->mostraString("<br><table class=\"pagina\" border=\"0\" width=\"100%\">");
				$relatorio->mostraString("<tr><td width=\"100%\" align=\"left\" class=\"lcons11\">");
				$relatorio->mostraString($msgConsLancamentosNaoLiberados);
				$relatorio->mostraString("</td></tr></table><br>");
			}

			$relatorio->fimRelatorio("cwConsRetrospectiva.php", $infoAdicionais, $voltar);

			return true;

		} // Fim da decisao de validacao do array

	}

}
?>


