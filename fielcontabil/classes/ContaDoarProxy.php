<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 07/11/2003
*	Modulo: ContaDoarProxy.php
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
include $pathClasses."cw.inc";

/**
*
*   ContaDoarProxy
*
*   Classe que persiste os dados das contas DOAR
*   no Contábil Web
*
*/
class ContaDoarProxy extends Proxy {

      var $broker;		// Atributo de persistencia (Singleton)
      var $oidContaDoar;	// OID da conta DOAR
      var $oidEmpresaCont;	// Codigo da empresa contabil
      var $descricao;		// Descricao
      var $tipo;		// Tipo
      var $listObjects; 	// Lista de objetos
      var $expressao;		// Expressao de busca
      var $flagAuxiliar;	// Flag auxiliar de desenvolvimento

      /**
      * 	getBroker()
      *  Retorna o broker utilizado para persistencia
      *  @return getBroker
      */
      function getBroker() {

		  return BD_PgSQL;

      }

      /**
      *     setObject( $oidEmpresaCont, $descricao, $tipo )
      *     Recebe os dados para registro
      *     @param $oidEmpresaCont	OID da empresa
      *     @param $descricao		Descricao
	  *		@param $tipo			Tipo de conta
      */
      function setObject( $oidEmpresaCont, $descricao, $tipo ) {

	     // Seta os atributos para objeto
	     $this->oidEmpresaCont = $oidEmpresaCont;
	     $this->descricao	   = $descricao;
		 $this->tipo	       = $tipo;

	  }

	  /**
	  *		setOidContaDoar( $oidContaDoar )
	  *		Recebe OID de conta DOAR
	  *		@param $oidContaDoar   OID da conta DOAR
	  */
	  function setOidContaDoar( $oidContaDoar ) {

		  $this->oidContaDoar = $oidContaDoar;

	  }

	  /**
	  *		getOidContaDoar()
	  *		Retorna OID de conta DOAR
	  *		@return $oidContaDoar	 OID da conta DOAR
	  */
	  function getOidContaDoar() {

		  return $this->oidContaDoar;

	  }

	  /**
	  *		save()
	  *		Grava objeto persistente
	  *		@return  flagGravou	  true se foi possivel gravar ou false caso contrario
	  */
	  function save() {

		  // Seta variaveis utilizadas no metodo
		  $flagGravou = false;

		  // Cria broker para conexao...
		  $broker = $this->criaBroker();

		  // Abre conexao...
		  if ( !$broker->abreConexao() )
			return $flagGravou;

		 // Inicia Transacao...
		 $broker->iniciaTransacao();

		 // Monta instrucao...
		 $instrucao  = "insert into contadoar_cont ( codigodoar, codigoempresa, descricao, tipo ) ";
		 $instrucao .= " values ";
		 $instrucao .= " ( '$this->oidContaDoar', '$this->oidEmpresaCont', '$this->descricao', '$this->tipo' );";
		 
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
    *	findByOid( $oidContaDoar, $oidEmpresaCont )
    *	Pesquisa pelo OID do Objeto
    *	@param	 $oidContaDoar	  OID da conta DOAR
	*	@param	 $oidEmpresaCont  OID da empresa contabil
    */
    function findByOid( $oidContaDoar, $oidEmpresaCont = 0 ) {

		// Seta variaveis utilizadas no metodo
		$this->oidContaDoar = $oidContaDoar;
		$flagAchou	    = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagAchou;

		$instrucao  = "select codigodoar, codigoempresa, descricao, tipo from contadoar_cont ";
		$instrucao .= " where codigodoar = '$this->oidContaDoar'";
		if ( $oidEmpresaCont != 0 )
			$instrucao .= " and codigoempresa = '$oidEmpresaCont';";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {

			// Se conseguiu achar...
			if ( $broker->retornaNumLinhas() > 0 ) {
				$flagAchou = true;

				// seta variaveis de instancia
				$this->oidContaDoar	  = $broker->retornaResultado( 0, 0 );
				$this->oidEmpresaCont = $broker->retornaResultado( 0, 1 );
				$this->descricao      = $broker->retornaResultado( 0, 2 );
				$this->tipo	      = $broker->retornaResultado( 0, 3 );

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
		return array( $this->oidContaDoar, $this->oidEmpresaCont, $this->descricao,
						$this->tipo );

    }

    /**
    *	update( $oidContaDoar )
    *	Altera objeto persistente
    *	@param	 $oidContaDoar	OID da conta DOAR
    *	@return  $flagGravou	true se foi possivel gravar ou false caso contrario
    */
    function update( $oidContaDoar ) {

		// Seta variaveis utilizadas no metodo
		$this->oidContaDoar = $oidContaDoar;
		$flagGravou		= false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagGravou;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "update contadoar_cont ";
		$instrucao .= " set descricao = '$this->descricao', ";
		$instrucao .= " tipo = '$this->tipo' ";
		$instrucao .= " where codigodoar = '$this->oidContaDoar';";

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
    *	search( $oidEmpresaCont, $expressao, $operacao )
    *	Pesquisa por critério de selecao
    *	@param	$oidEmpresaCont OID da empresa
    *	@param	$expressao	Expressao de busca
    *	@param	$operacao	Operacao a ser realizada
    */
    function search( $oidEmpresaCont, $expressao, $operacao = 1 ) {

		// Seta variaveis utilizadas no metodo
		$this->oidEmpresaCont = $oidEmpresaCont;
		$this->listObjects[0][0] = array();
		$this->listObjects[0][0] = "0";

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return false;

		switch( $operacao ) {

			case 1: {

				// Seta variavel de pesquisa...
				$this->expressao     = "%".strtoupper( trim( $expressao ) )."%";

				$instrucao  = "select codigodoar, descricao, tipo from contadoar_cont ";
				$instrucao .= " where descricao like '$this->expressao' ";
				$instrucao .= " and codigoempresa = '$this->oidEmpresaCont' ";
				$instrucao .= " order by codigodoar, descricao;";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						$broker->retornaResultado( $indx, 1 ), $broker->retornaResultado( $indx, 2 ) );
				}

			}

			break; }

			// Aqui para pegar as contas DOAR de uma empresa (não empresa contábil)
			case 2: {

				// Seta variavel de pesquisa...
				$this->expressao     = "%".strtoupper( trim( $expressao ) )."%";

				$instrucao  = "select doar.codigodoar, doar.descricao, doar.tipo from contadoar_cont doar, ";
				$instrucao .= " empresa_cont emp where doar.descricao like '$this->expressao' ";
				$instrucao .= " and doar.codigoempresa = emp.codigo and emp.codigocliente = '$this->oidEmpresaCont' ";
				$instrucao .= " order by doar.codigodoar, doar.descricao;";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						$broker->retornaResultado( $indx, 1 ), $broker->retornaResultado( $indx, 2 ) );
				}

			}

			break; }

			// Aqui para pegar as contas DOAR de uma empresa (não empresa contábil)
			case 3: {

				// Seta variavel de pesquisa...
				$this->expressao     = "%".strtoupper( trim( $expressao ) )."%";

				$instrucao  = "select doar.codigoempresa, doar.codigodoar, doar.descricao, doar.tipo from contadoar_cont doar, ";
				$instrucao .= " empresa_cont emp where doar.descricao like '$this->expressao' and doar.tipo = 'A' ";
				$instrucao .= " and doar.codigoempresa = emp.codigo ";
				$instrucao .= " order by doar.codigodoar, doar.descricao;";
				
				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						$broker->retornaResultado( $indx, 1 ), $broker->retornaResultado( $indx, 2 ) );
				}

			}

			break; }

			// Aqui para pegar as contas DOAR de uma empresa (não empresa contábil), incluindo as sinteticas
			case 4: {

				// Seta variavel de pesquisa...
				$this->expressao     = "%".strtoupper( trim( $expressao ) )."%";

				$instrucao  = "select doar.codigoempresa, doar.codigodoar, doar.descricao, doar.tipo from contadoar_cont doar, ";
				$instrucao .= " empresa_cont emp where doar.descricao like '$this->expressao' ";
				$instrucao .= " and doar.codigoempresa = emp.codigo and emp.codigo = '$this->oidEmpresaCont' ";
				$instrucao .= " order by doar.codigodoar, doar.descricao;";
				
				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						$broker->retornaResultado( $indx, 1 ), $broker->retornaResultado( $indx, 2 ) );
				}

			}

			break; }
			
		}

		// fecha conexao...
		$broker->fechaConexao();

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
    *	delete( $oidContaDoar )
    *	Exclui objeto persistente
    *	@param	 $oidContaDoar	 OID da conta DOAR
    *	@return  $flagExcluiu true se foi possivel gravar ou false caso contrario
    */
    function delete( $oidContaDoar ) {

		// Seta variaveis utilizadas no metodo
		$this->oidContaDoar = $oidContaDoar;
		$flagExcluiu	    = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagExcluiu;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "delete from contadoar_cont ";
		$instrucao .= "where codigodoar = '$this->oidContaDoar';";

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
    *	searchSaldoContaDoar( $oidContaDoar, $dataInicial, $dataFinal,
    *			      $contabilizado, $operacao, $oidEmpresaCont )
    *	Pesquisa saldo da conta DOAR por periodo
    *	    @param  $oidContaDoar     OID da conta DOAR
    *	    @param  $dataInicial      Data inicial
    *	    @param  $dataFinal	      Data final
    *	    @param  $contabilizado    Contabilizado (default = S)
    *	    @param  $operacao	      D || C
    *	    @param  $oidEmpresaCont   OID de empresa contábil
    */
    function searchSaldoContaDoar( $oidContaDoar, $dataInicial,
				$dataFinal, $contabilizado = "S",
				$operacao, $oidEmpresaCont ) {

		// Seta variaveis utilizadas no metodo
		$this->oidContaDoar   = $oidContaDoar;
		$dataInicial	    = Data::converteDmaAmd( $dataInicial );
		$dataFinal	    = Data::converteDmaAmd( $dataFinal );

		$expressao = trim ( $oidContaDoar )."%";

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return false;

		$instrucao  = "select sum(valor) from itemlancamento_cont, cablancamento_cont ";
		$instrucao .= " where itemlancamento_cont.codigolancamento = cablancamento_cont.codigo and ";
		$instrucao .= " cablancamento_cont.data between '$dataInicial' and '$dataFinal' and ";
		$instrucao .= " itemlancamento_cont.debitocredito = '$operacao' and cablancamento_cont.aberto = 'N' and itemlancamento_cont.codigoacesso in ";
		$instrucao .= "  ( select codigoacesso from contacontabil_cont where contadoar like '$expressao' and ";
		$instrucao .= "      codigoempresa = '$oidEmpresaCont' ) ";
		if ( $contabilizado == "S" )
			$instrucao.= " and cablancamento_cont.contabilizado = '$contabilizado' ";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {
			$saldo = $broker->retornaResultado( 0, 0 );
		}

		$saldo = empty( $saldo )?0:$saldo;
		
		// fecha conexao...
		$broker->fechaConexao();

		return $saldo;

    }
	
}

?>
