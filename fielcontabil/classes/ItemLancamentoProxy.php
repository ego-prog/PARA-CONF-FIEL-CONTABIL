<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 03/05/2005
*	Modulo: ItemLancamentoProxy.php
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
*   ItemLancamentoProxy
*
*   Classe que persiste os dados dos itens de lancamentos
*   no Contábil Web
*
*/
class ItemLancamentoProxy extends Proxy {

      var $broker;			// Atributo de persistencia (Singleton)
      var $oidItemLancamento;	// OID do item de lancamento
      var $oidLancamento;	// OID do lancamento
      var $oidConta;		// OID da conta
      var $historico;		// Historico
      var $valor;		// Valor
      var $operacao;		// Operacao (D/C)
      var $oidZeramento;	// OID de zeramento
      var $oidCentroCusto;	// OID do Centro de Custo
      var $nomeImagem;		// Nome da Imagem anexada, se houver
      var $listObjects; 	    // Lista de objetos
      var $expressao;		    // Expressao de busca
      var $flagAuxiliar;	    // Flag auxiliar de desenvolvimento

      /**
      * 	getBroker()
      *  Retorna o broker utilizado para persistencia
      *  @return getBroker
      */
      function getBroker() {

		  return BD_PgSQL;

      }

	  /**
	  *		setObject( $oidLancamento, $oidConta, $historico,
	  *					$valor, $operacao, $oidZeramento, $oidCentroCusto, $nomeImagem )
	  *		Recebe os dados para manipulacao
	  *		@param $oidLancamento	   OID de lancamento
	  *		@param $oidConta	   OID da conta contabil
	  *		@param $historico	   Historico
	  *		@param $valor		   Valor
	  *		@param $operacao	   Operacao (D/C)
	  *		@param $oidZeramento	   OID Zeramento
	  *		@param $oidCentroCusto	   OID do Centro de Custo
	  *		@param $nomeImagem	   Nome da Imagem anexada, se houver
	  */
	  function setObject( $oidLancamento, $oidConta, $historico,
					$valor, $operacao, $oidZeramento, $oidCentroCusto, $nomeImagem ) {

	     // Seta os atributos para objeto
	     $this->oidLancamento  = $oidLancamento;
	     $this->oidConta	   = $oidConta;
	     $this->historico	   = $historico;
	     $this->valor	   = $valor;
	     $this->operacao	   = $operacao;
	     $this->oidZeramento   = $oidZeramento;
	     $this->oidCentroCusto = $oidCentroCusto;
	     $this->nomeImagem	   = $nomeImagem;

	  }

	  /**
	  *		save()
	  *		Grava objeto persistente
	  *		@return  flagGravou	  true se foi possivel gravar ou false caso contrario
	  */
	  function save() {

		  // Seta variaveis utilizadas no metodo
		  $flagGravou = false;
		  $horaLiberacao = "00:00";

		  // Cria broker para conexao...
		  $broker = $this->criaBroker();

		  // Abre conexao...
		  if ( !$broker->abreConexao() )
			return $flagGravou;

		 // Inicia Transacao...
		 $broker->iniciaTransacao();

		 // Monta instrucao...
		 $instrucao  = "insert into itemlancamento_cont ( codigo, codigolancamento, codigoacesso, ";
		 $instrucao .= " historico, valor, debitocredito, codigozeramento, codigocentrocusto, nomeimagem ) ";
		 $instrucao .= " values ";
		 $instrucao .= " ( nextval('itemlancamento_pk'), '$this->oidLancamento', '$this->oidConta', ";
		 $instrucao .= " '$this->historico', '$this->valor', '$this->operacao', '$this->oidZeramento', '$this->oidCentroCusto', '$this->nomeImagem' );";

		 $relatorioTXT = new RelatorioTXT();
		 $relatorioTXT->setConf(  "/var/www/html/fielcontabil/pdfs/erros.txt" );
		 $relatorioTXT->inicioRelatorio();
		 $relatorioTXT->mostraString( $instrucao );
		 $relatorioTXT->fimRelatorio();

		 // Executa instrucao SQL...
		 if ( $broker->atualizaBD( $instrucao ) ) {
			 $flagGravou = true;
			 $broker->gravaTransacao(); }
		 else
			 $broker->abortaTransacao();

		 // Finaliza Transacao...
		 $broker->finalizaTransacao();

		 // fecha conexao...
		 $broker->fechaConexao();

		 // Retorna flag...
		 return $flagGravou;

    }

    /**
    *	findByOid( $oidItemLancamento )
    *	Pesquisa pelo OID do Objeto
    *	@param	 $oidItemLancamento   OID do item de lancamento
    */
    function findByOid( $oidItemLancamento ) {

		// Seta variaveis utilizadas no metodo
		$this->oidItemLancamento = $oidItemLancamento;
		$flagAchou		 = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagAchou;

		$instrucao  = "select codigo, codigolancamento, codigoacesso, historico, valor, ";
		$instrucao .= " debitocredito, codigozeramento, codigocentrocusto, nomeimagem ";
		$instrucao .= " from itemlancamento_cont where codigo = '$this->oidItemLancamento';";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {

			// Se conseguiu achar...
			if ( $broker->retornaNumLinhas() > 0 ) {
				$flagAchou = true;

				// seta variaveis de instancia
				$this->oidItemLancamento = $broker->retornaResultado( 0, 0 );
				$this->oidLancamento	 = $broker->retornaResultado( 0, 1 );
				$this->oidConta 	 = $broker->retornaResultado( 0, 2 );
				$this->historico	 = $broker->retornaResultado( 0, 3 );
				$this->valor		 = $broker->retornaResultado( 0, 4 );
				$this->operacao 	 = $broker->retornaResultado( 0, 5 );
				$this->oidZeramento	 = $broker->retornaResultado( 0, 6 );
				$this->oidCentroCusto	 = $broker->retornaResultado( 0, 7 );
				$this->nomeImagem	 = $broker->retornaResultado( 0, 8 );

			}

		}

		// fecha conexao...
		$broker->fechaConexao();

		// Retorna flag...
		return $flagAchou;

    }

    /**
    *	getObject()
    *	Retorna objeto atual
    *	@return $array		     Retorna objeto atual
    */
    function getObject() {

		// retorna objeto atual
		return array( $this->oidItemLancamento, $this->oidLancamento, $this->oidConta,
						$this->historico, $this->valor, $this->operacao,
						$this->oidZeramento, $this->oidCentroCusto, $this->nomeImagem );

    }

    /**
    *	update( $oidItemLancamento )
    *	Altera objeto persistente
    *	@param	 $oidItemLancamento  OID do item de lancamento
    *	@return  $flagGravou	true se foi possivel gravar ou false caso contrario
    */
    function update( $oidItemLancamento ) {

		// Seta variaveis utilizadas no metodo
		$this->oidItemLancamento = $oidItemLancamento;
		$flagGravou		 = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagGravou;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "update itemlancamento_cont ";
		$instrucao .= " set ";
		$instrucao .= " historico = '$this->historico', codigoacesso = '$this->oidConta', valor = '$this->valor', ";
		$instrucao .= " debitocredito = '$this->operacao', codigocentrocusto = '$this->oidCentroCusto', nomeimagem = '$this->nomeImagem' ";
		$instrucao .= " where codigo = '$this->oidItemLancamento';";

		// Executa instrucao SQL...
		if ( $broker->atualizaBD( $instrucao ) ) {
			$flagGravou = true;
			$broker->gravaTransacao(); }
		else
			$broker->abortaTransacao();

		// Finaliza Transacao...
		$broker->finalizaTransacao();

		// fecha conexao...
		$broker->fechaConexao();

		// Retorna flag...
		return $flagGravou;

    }

    /**
    *  getList()
    *  Retorna lista de objetos
    *  @return listObjects
    */
    function getList() {

	return $this->listObjects;

    }

    /**
    *	search( $oidLancamento, $operacao )
    *	Pesquisa por critério de selecao
    *	@param	$oidLancamento OID de lancamento
    *	@param	$operacao	   Operacao a ser realizada
    */
    function search( $oidLancamento, $operacao = 1 ) {

		// Seta variaveis utilizadas no metodo
		$this->oidLancamento = $oidLancamento;
		$this->listObjects = array();
		$this->listObjects[0][0] = "0";

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return false;

		switch( $operacao ) {

			case 1: {

				$instrucao  = "select codigo, codigolancamento, codigoacesso, historico, ";
				$instrucao .= " valor, debitocredito, codigozeramento, codigocentrocusto, nomeimagem from itemlancamento_cont ";
				$instrucao .= " where ";
				$instrucao .= " codigolancamento = '$this->oidLancamento' ";
				$instrucao .= " order by codigo, codigoacesso;";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {
					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						$broker->retornaResultado( $indx, 1 ), $broker->retornaResultado( $indx, 2 ),
						$broker->retornaResultado( $indx, 3 ), $broker->retornaResultado( $indx, 4 ),
						$broker->retornaResultado( $indx, 5 ), $broker->retornaResultado( $indx, 6 ),
						$broker->retornaResultado( $indx, 7 ), $broker->retornaResultado( $indx, 8 ) );
				}

			}


			break; }

		}

		// fecha conexao...
		$broker->fechaConexao();

    }
    /**
    *	searchByConta( $codigoSintetico, $dataInicial, $dataFinal, $exibeNaoLiberado, $operacao )
    *	Pesquisa por código sintético e período
    *	@param	$oidEmpresaCont    oid da Empresa dona da conta
    *	@param	$codigoSintetico   Código Sintético da Conta (ou grupo de Contas)
    *	@param	$dataInicial	   Data Inicial
    *	@param	$dataFinal	   Data Final
    *	@param	$exibeNaoLiberado  Exibe os lançamentos não liberados (true/false)
    *	@param	$operacao	   Operacao a ser realizada
    */
    function searchByConta( $oidEmpresaCont, $codigoSintetico, $dataInicial, $dataFinal, $exibeNaoLiberado, $operacao = 1 ) {

		// Seta variaveis utilizadas no metodo
		$this->listObjects = array();
		$this->listObjects[0][0] = "0";
		$codigoSintetico = trim($codigoSintetico);

		$dataInicialAMD = Data::ConverteDmaAmd( $dataInicial);
		$dataFinalAMD	= Data::ConverteDmaAmd( $dataFinal);

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return false;

		switch( $operacao ) {

			case 1: {

				$instrucao  = "select itemlancamento_cont.codigo, codigolancamento, itemlancamento_cont.codigoacesso, historico, ";
				$instrucao .= " valor, debitocredito, codigozeramento, codigocentrocusto, nomeimagem, cablancamento_cont.data as \"datalancamento\", contacontabil_cont.codigosintetico as \"codigosintetico\", cablancamento_cont.contabilizado";
				$instrucao .= " from itemlancamento_cont,contacontabil_cont,cablancamento_cont ";
				$instrucao .= " where ";
				$instrucao .= " itemlancamento_cont.codigoacesso = contacontabil_cont.codigoacesso ";
				$instrucao .= " and itemlancamento_cont.codigolancamento = cablancamento_cont.codigo ";
				$instrucao .= " and contacontabil_cont.codigoempresa = '$oidEmpresaCont' ";
				$instrucao .= " and contacontabil_cont.codigosintetico like '$codigoSintetico%' ";
				$instrucao .= " and cablancamento_cont.data between '$dataInicialAMD' and '$dataFinalAMD' ";
				$instrucao .= " and cablancamento_cont.aberto like 'N' ";
				if (!$exibeNaoLiberado)
				     $instrucao .= " and contabilizado = 'S' ";
				$instrucao .= " order by codigosintetico, datalancamento,codigolancamento;";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {
					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						$broker->retornaResultado( $indx, 1 ), $broker->retornaResultado( $indx, 2 ),
						$broker->retornaResultado( $indx, 3 ), $broker->retornaResultado( $indx, 4 ),
						$broker->retornaResultado( $indx, 5 ), $broker->retornaResultado( $indx, 6 ),
						$broker->retornaResultado( $indx, 7 ), $broker->retornaResultado( $indx, 8 ),Data::converteAmdDma($broker->retornaResultado( $indx, 9 )),$broker->retornaResultado( $indx, 10 ),$broker->retornaResultado( $indx, 11 ) );
				}

			}


			break; }

		}

		// fecha conexao...
		$broker->fechaConexao();

    }

    /**
    *	delete( $oidItemLancamento )
    *	Exclui objeto persistente
    *	@param	 $oidItemLancamento	  OID de item de lancamento
    *	@return  $flagExcluiu true se foi possivel gravar ou false caso contrario
    */
    function delete( $oidItemLancamento ) {

		// Seta variaveis utilizadas no metodo
		$this->oidItemLancamento = $oidItemLancamento;
		$flagExcluiu		 = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagExcluiu;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "delete from itemlancamento_cont ";
		$instrucao .= "where codigo = '$this->oidItemLancamento';";

		// Executa instrucao SQL...
		if ( $broker->atualizaBD( $instrucao ) ) {
			$flagExcluiu = true;
			$broker->gravaTransacao(); }
		else
			$broker->abortaTransacao();

		// Finaliza Transacao...
		$broker->finalizaTransacao();

		// fecha conexao...
		$broker->fechaConexao();

		// Retorna flag...
		return $flagExcluiu;

    }

    /**
    *	deleteAll( $oidLancamento )
    *	Exclui objeto persistente
    *	@param	 $oidLancamento   OID de lancamento
    *	@return  $flagExcluiu true se foi possivel gravar ou false caso contrario
    */
    function deleteAll( $oidLancamento ) {

		// Seta variaveis utilizadas no metodo
		$this->oidLancamento = $oidLancamento;
		$flagExcluiu		 = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagExcluiu;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "delete from itemlancamento_cont ";
		$instrucao .= "where codigolancamento = '$this->oidLancamento';";

		// Executa instrucao SQL...
		if ( $broker->atualizaBD( $instrucao ) ) {
			$flagExcluiu = true;
			$broker->gravaTransacao(); }
		else
			$broker->abortaTransacao();

		// Finaliza Transacao...
		$broker->finalizaTransacao();

		// fecha conexao...
		$broker->fechaConexao();

		// Retorna flag...
		return $flagExcluiu;

    }

    /**
    *	searchTotal( $oidLancamento, $operacao )
    *	Pesquisa por critério de selecao a totalizacao da operacao
    *	@param	$oidLancamento OID de lancamento
    *	@param	$operacao	   Operacao a ser realizada
    */
    function searchTotal( $oidLancamento, $operacao ) {

		// Seta variaveis utilizadas no metodo
		$this->oidLancamento = $oidLancamento;
		$total		     = 0.0;
		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return false;

		$instrucao  = "select sum(valor) ";
		$instrucao .= " from itemlancamento_cont ";
		$instrucao .= " where debitocredito = '$operacao' ";
		$instrucao .= " and codigolancamento = '$this->oidLancamento';";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) )
			$total = $broker->retornaResultado( 0, 0 );

		// fecha conexao...
		$broker->fechaConexao();

		return $total;

    }

}

?>
