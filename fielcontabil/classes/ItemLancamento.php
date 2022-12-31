<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 26/11/2003
*	Modulo: ItemLancamento.php
*
*	Desenvolvido por APOENA Solucoes em Software Livre
*	suporte@apoenasoftwarelivre.com.br
*	http://www.apoenasoftwarelivre.com.br
*
*	@author 	Claudimir Zavalik (claudimir@apoenasoftwarelivre.com.br)
*	@author 	Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*	@version	PHP3 & PHP4
*/

// Arquivo "header" do Contábil
// include $pathClasses."cw.inc";

/**
*
*	ItemLancamento
*
*	Classe que contem as principais definicoes de itens de lancamentos
*	da contabilidade no Contabil Web
*
*/
class ItemLancamento {

	var $oidItemLancamento;   // OID do item de lancamento
	var $oidLancamento;	  // OID do lancamento
	var $oidConta;		  // OID da conta
	var $historico; 	  // Historico
	var $valor;		  // Valor
	var $operacao;		  // Operacao (D/C)
	var $oidZeramento;	  // OID de zeramento
	var $OidCentroCusto;	  // OID do Centro de Custo
	var $nomeImagem;	  // Nome da Imagem anexada (se houver)
	var $persistence;	      // Utilizado para persistencia dos objetos

	/**
	*  ItemLancamento()
	*  Construtor da classe
	*/
	function ItemLancamento() {

		$this->persistence = new ItemLancamentoProxy();

	}

	/**
	*	setItemLancamento( $oidLancamento, $oidConta, $historico,
	*		$valor, $operacao, $oidZeramento )
	*	Recebe os dados para manipulacao
	*	@param $oidLancamento	   OID de lancamento
	*	@param $oidConta	   OID da conta contabil
	*	@param $historico	   Historico
	*	@param $valor		   Valor
	*	@param $operacao	   Operacao (D/C)
	*	@param $oidZeramento	   OID Zeramento
	*	@param $oidCentroCusto	   OID do Centro de Custo associado
	*	@param $nomeImagem	   Nome da Imagem anexada, se houver
	*/
	function setItemLancamento( $oidLancamento, $oidConta, $historico,
							$valor, $operacao, $oidZeramento, $oidCentroCusto = 0, $nomeImagem = '' ) {

		$this->setOidLancamento( $oidLancamento );
		$this->setOidConta( $oidConta );
		$this->setHistorico( $historico );
		$this->setValor( $valor );
		$this->setOperacao( $operacao );
		$this->setOidZeramento( $oidZeramento );
		$this->setOidCentroCusto( $oidCentroCusto );
		$this->setNomeImagem( $nomeImagem );

	}

	/**
	*	setOidLancamento( $oidLancamento )
	*	Recebe OID de Lancamento
	*	@param $oidLancamento	OID de lancamento
	*/
	function setOidLancamento( $oidLancamento ) {

		$this->oidLancamento = $oidLancamento;

	}

	/**
	*	getOidLancamento()
	*	Retorna OID de lancamento
	*	@return $oidLancamento OID de lancamento
	*/
	function getOidLancamento() {

		return $this->oidLancamento;

	}

	/**
	*	setOidItemLancamento( $oidItemLancamento )
	*	Recebe OID de Item de Lancamento
	*	@param $oidItemLancamento	OID de item de lancamento
	*/
	function setOidItemLancamento( $oidItemLancamento ) {

		$this->oidItemLancamento = $oidItemLancamento;

	}

	/**
	*	getOidItemLancamento()
	*	Retorna OID de Item de lancamento
	*	@return $oidItemLancamento OID de item de lancamento
	*/
	function getOidItemLancamento() {

		return $this->oidItemLancamento;

	}

	/**
	*	setOidConta( $oidConta )
	*	Recebe OID de conta
	*	@param $oidConta	 OID da conta
	*/
	function setOidConta( $oidConta ) {

		$this->oidConta = $oidConta;

	}

	/**
	*	getOidConta()
	*	Retorna OID de conta
	*	@return $oidConta    OID da conta
	*/
	function getOidConta() {

		return $this->oidConta;

	}

	/**
	*	setHistorico( $historico )
	*	Recebe historico
	*	@param $historico	Historico
	*/
	function setHistorico( $historico ) {

		$this->historico = trim( String::upper( $historico ) );

	}

	/**
	*	getHistorico()
	*	Retorna historico
	*	@return $historico		Historico
	*/
	function getHistorico() {

		return $this->historico;

	}

	/**
	*	setValor( $valor )
	*	Recebe valor
	*	@param $valor		Valor
	*/
	function setValor( $valor ) {

		$this->valor = $valor;

	}

	/**
	*	getValor()
	*	Retorna valor
	*	@return $valor		Valor
	*/
	function getValor() {

		return $this->valor;

	}

	/**
	*	setOperacao( $operacao )
	*	Recebe operacao
	*	@param $operacao	operacao
	*/
	function setOperacao( $operacao ) {

		$this->operacao = trim( $operacao );

	}

	/**
	*	getOperacao()
	*	Retorna operacao
	*	@return $operacao		Operacao
	*/
	function getOperacao() {

		return $this->operacao;

	}

	/**
	*	setOidZeramento( $oidZeramento )
	*	Recebe OID de zeramento
	*	@param $oidZeramento		OID de zeramento
	*/
	function setOidZeramento( $oidZeramento ) {

		$this->oidZeramento = $oidZeramento;

	}

	/**
	*	getOidZeramento()
	*	Retorna OID de zeramento
	*	@return $oidZeramento	OID de zeramento
	*/
	function getOidZeramento() {

		return $this->oidZeramento;

	}

	/**
	*	setOidCentroCusto( $oidCentroCusto )
	*	Recebe OID do Centro de Custo
	*	@param $oidCentroCusto		  OID do Centro de Custo
	*/
	function setOidCentroCusto( $oidCentroCusto ) {

		$this->oidCentroCusto = $oidCentroCusto;

	}

	/**
	*	getOidCentroCusto()
	*	Retorna OID de Centro de Custo
	*	@return $oidCentroCusto   OID do Centro de Custo
	*/
	function getOidCentroCusto() {

		return $this->oidCentroCusto;

	}

	/**
	*	setNomeImagem( $nomeImagem )
	*	Recebe o nome da imagem armazenada
	*	@param $nomeImagem	      Nome da Imagem que foi feito o UPLOAD
	*/
	function setNomeImagem( $nomeImagem ) {

		$this->nomeImagem = $nomeImagem;

	}

	/**
	*	getNomeImagem()
	*	Retorna o nome da Imagem anexada
	*	@return $nomeImagem   Nome da Imagem anexada
	*/
	function getNomeImagem() {

		return $this->nomeImagem;

	}

	/**
	*	grava( $operacao = true )
	*	Grava objeto
	*	@param $operacao	Operacao a ser realizada (true = inclusao | false = alteracao)
	*	@return se conseguiu gravar
	*/
	function grava( $operacao = true ) {

		// Seta variaveis utilizada no metodo...
		$flagGravou = false;

		// Seta dados...
		$this->persistence->setObject( $this->getOidLancamento(),
					$this->getOidConta(),
					$this->getHistorico(), $this->getValor(),
					$this->getOperacao(), $this->getOidZeramento(), $this->getOidCentroCusto(), $this->getNomeImagem() );

		// Realiza operacao...
		if ( $operacao )
				$flagGravou = $this->persistence->save();
		else
				$flagGravou = $this->persistence->update( $this->getOidItemLancamento() );

		return $flagGravou;

	}

	/**
	*	pesquisaItemLancamento( $oidItemLancamento )
	*	Retorna item de lancamento encontrado
	*	@return true se encontrou item de lancamento por OID
	*/
	function pesquisaItemLancamento( $oidItemLancamento ) {

		// Seta variaveis utilizada no metodo
		$flagAchou = false;

		if ( $this->persistence->findByOid( $oidItemLancamento ) ) {
		   $flagAchou = true;

		   // Retorna objeto
		   $objetoAtual = $this->persistence->getObject();

		   // Seta atributos
		   $this->setOidItemLancamento( $objetoAtual[0] );
		   $this->setOidLancamento( $objetoAtual[1] );
		   $this->setOidConta( $objetoAtual[2] );
		   $this->setHistorico( $objetoAtual[3] );
		   $this->setValor( $objetoAtual[4] );
		   $this->setOperacao( $objetoAtual[5] );
		   $this->setOidZeramento( $objetoAtual[6] );
		   $this->setOidCentroCusto( $objetoAtual[7] );
		   $this->setNomeImagem( $objetoAtual[8] );

		}

		// Retorna se encontrou item de lancamento...
		return $flagAchou;

	}

	/**
	*	buscaItemLancamento( $oidLancamento, $operacao = 1 )
	*	Retorna todos os itens de lancamentos
	*	@param	$oidLancamento		OID de lancamento
	*	@return $itensLancamentos	itens de lancamentos encontrados
	*/
	function buscaItemLancamento( $oidLancamento, $operacao = 1 ) {

		// Pesquisa lancamentos por criterio de selecao...
		$this->persistence->search( $oidLancamento, $operacao );

		// retorna itens de lancamentos encontrados...
		return $this->persistence->getList();

	}
	/**
	*	buscaItemLancamentoConta( $codigoSintetico, $operacao = 1 )
	*	Retorna todos os itens de lancamentos
	*	@param	$oidEmpresaCont 	oid da Empresa dona da conta
	*	@param	$codigoSintetico	Código Sintético da Conta (ou grupo de contas)
	*	@param	$dataInicial		Data Inicial do Período
	*	@param	$dataFinal		Data Final do Período

	*	@return $itensLancamentos	itens de lancamentos encontrados
	*/
	function buscaItemLancamentoConta( $oidEmpresaCont, $codigoSintetico, $dataInicial, $dataFinal, $exibeNaoLiberado, $operacao = 1 ) {

		// Pesquisa lancamentos por criterio de selecao...
		$this->persistence->searchByConta( $oidEmpresaCont, $codigoSintetico, $dataInicial, $dataFinal, $exibeNaoLiberado, $operacao );

		// retorna itens de lancamentos encontrados...
		return $this->persistence->getList();

	}

	/**
	*	exclui()
	*	Exclui item de lancamento
	*/
	function exclui() {

		// Exclui item de lancamento...
		return $this->persistence->delete( $this->getOidItemLancamento() );

	}

	/**
	*	excluiLancamento( $oidLancamento )
	*	Exclui lancamento completo
	@	param  $oidLancamento		OID de lancamento
	*/
	function excluiLancamento( $oidLancamento ) {

		// Exclui lancamento...
		return $this->persistence->deleteAll( $oidLancamento );

	}

	/**
	*	buscaTotaisDC( $oidLancamento )
	*	Retorna totais de debito e credito dos lancamentos, por OID de lancamento
	*	@param	$oidLancamento	OID de lancamento
	*	@return $totais 	    Array contendo os totais de debito e credito
	*/
	function buscaTotaisDC( $oidLancamento ) {

		// Busca totais dos lancamentos...
		$totais[0] = $this->persistence->searchTotal( $oidLancamento, "D" );
		$totais[1] = $this->persistence->searchTotal( $oidLancamento, "C" );

		// Retorna objeto
		return $totais;

	}

}

?>
