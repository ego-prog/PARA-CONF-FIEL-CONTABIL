<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 10/11/2003
*	Modulo: ContaProxy.php
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
*   ContaProxy
*
*   Classe que persiste os dados das contas
*   no Contábil Web
*
*/
class ContaProxy extends Proxy {

      var $broker;		    // Atributo de persistencia (Singleton)
	  var $oidConta;	// OID da conta
	  var $dv;		// Digito verificador
	  var $codigoSintetico; // Codigo sintetico
      var $oidContaDoar;    // OID da conta DOAR
	  var $oidEmpresaCont;	// Codigo da empresa (proprietaria)
	  var $descricao;	// Descricao da conta
	  var $tipo;		// Tipo da conta DOAR (Analitica ou Sintetica)
	  var $natureza;	// Devedora ou Credora
	  var $classificacao;	// Despesa, Receita ou Outra
	  var $devedora;	// Pode ficar devedora (S/N)
	  var $credora; 	// Pode ficar credora (S/N)
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
	  *		setObject( $oidEmpresaCont, $codigoSintetico, $descricao, $natureza, $tipo,
	  *		$classificacao, $credora, $devedora, $oidContaDoar )
	  *		Recebe os dados para manipulacao
	  *		@param $oidEmpresaCont	   OID da empresa
	  *		@param $codigoSintetico    Codigo sintetico
	  *		@param $descricao	       Descricao da conta
	  *		@param $natureza		   Natureza
	  *		@param $tipo			   Tipo da conta
	  *		@param $classificacao	   Classificacao
	  *		@param $credora 	   Credora
	  *		@param $devedora	   Devedora
	  *		@param $oidContaDoar	   OID da conta DOAR
      */
	  function setObject( $oidEmpresaCont, $codigoSintetico, $descricao, $natureza,
			$tipo, $classificacao, $credora, $devedora, $oidContaDoar ) {

	     // Seta os atributos para objeto
		 $this->oidEmpresaCont	= $oidEmpresaCont;
		 $this->codigoSintetico = $codigoSintetico;
	     $this->descricao	    = $descricao;
		 $this->natureza	= $natureza;
		 $this->tipo		= $tipo;
		 $this->classificacao	= $classificacao;
		 $this->credora 	= $credora;
		 $this->devedora	= $devedora;
		 $this->oidContaDoar	= $oidContaDoar;

	  }

	  /**
	  *		setOidConta( $oidConta )
	  *		Recebe OID de conta
	  *		@param $oidConta   OID da conta
	  */
	  function setOidConta( $oidConta ) {

		  $this->oidConta = $oidConta;

	  }

	  /**
	  *		getOidConta()
	  *		Retorna OID de conta
	  *		@return $oidConta    OID da conta
	  */
	  function getOidConta() {

		  return $this->oidConta;

	  }

	  /**
	  *		setDV( $dv )
	  *		Recebe digito verificador
	  *		@param $dv		digito verificador
	  */
	  function setDV( $dv ) {

		  $this->dv = trim( $dv );

	  }

	  /**
	  *		getDV()
	  *		Retorna digito verificador
	  *		@return $dv		digito verificador
	  */
	  function getDV() {

		  return $this->dv;

	  }

	  /**
	  *		setOidContaDV( $oidContaDV )
	  *		Recebe OID da conta com DV
	  *		@param $oidContaDV		Conta com DV
	  */
	  function setOidContaDV( $oidContaDV ) {

		  $codigoConta = explode( ".", $oidContaDV );
		  $this->setOidConta( $codigoConta[0] );
		  $this->setDV( $codigoConta[1] );

	  }

	  /**
	  *		getOidContaDV()
	  *		Retorna Conta com digito verificador
	  *		@return $oidContaDV		conta com digito verificador
	  */
	  function getOidContaDV() {

		  return $this->getOidConta().".".$this->getDV();

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
		 $instrucao  = "insert into contacontabil_cont ( codigoacesso, codigoempresa, codigosintetico, descricao, ";
		 $instrucao .= " natureza, tipo, despesareceita, podecredora, podedevedora, contadoar, dv ) ";
		 $instrucao .= " values ";
		 $instrucao .= " ( nextval('contacontabil_pk'), '$this->oidEmpresaCont', '$this->codigoSintetico', ";
		 $instrucao .= " '$this->descricao', '$this->natureza', '$this->tipo', '$this->classificacao', ";
		 $instrucao .= " '$this->credora', '$this->devedora', '$this->oidContaDoar', '0' );";

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
    *	findByOid( $oidContaDV, $oidEmpresaCont )
    *	Pesquisa pelo OID do Objeto
    *	@param	 $oidContaDV	  OID da conta com DV
	*	@param	 $oidEmpresaCont  OID da empresa contabil
    */
    function findByOid( $oidContaDV, $oidEmpresaCont = 0 ) {

		// Seta variaveis utilizadas no metodo
		$this->setOidContaDV( $oidContaDV );
		$flagAchou	    = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagAchou;

		$instrucao  = "select codigoacesso, codigoempresa, dv, codigosintetico, descricao, ";
		$instrucao .= " natureza, tipo, despesareceita, podecredora, podedevedora, contadoar from contacontabil_cont ";
		$instrucao .= " where codigoacesso = '$this->oidConta' and dv = '$this->dv' ";
		if ( $oidEmpresaCont != 0 )
			$instrucao .= " and codigoempresa = '$oidEmpresaCont';";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {

			// Se conseguiu achar...
			if ( $broker->retornaNumLinhas() > 0 ) {
				$flagAchou = true;

				// seta variaveis de instancia
				$this->oidConta 	   = $broker->retornaResultado( 0, 0 );
				$this->oidEmpresaCont  = $broker->retornaResultado( 0, 1 );
				$this->dv	       = $broker->retornaResultado( 0, 2 );
				$this->codigoSintetico = $broker->retornaResultado( 0, 3 );
				$this->descricao       = $broker->retornaResultado( 0, 4 );
				$this->natureza        = $broker->retornaResultado( 0, 5 );
				$this->tipo	       = $broker->retornaResultado( 0, 6 );
				$this->classificacao   = $broker->retornaResultado( 0, 7 );
				$this->credora	       = $broker->retornaResultado( 0, 8 );
				$this->devedora        = $broker->retornaResultado( 0, 9 );
				$this->oidContaDoar    = $broker->retornaResultado( 0, 10 );

			}

		}

		// fecha conexao...
		$broker->fechaConexao();

		// Retorna flag...
		return $flagAchou;

    }

    /**
    *	findByOidNoDV( $oidConta, $oidEmpresaCont )
    *	Pesquisa pelo OID do Objeto
    *	@param	 $oidConta	  OID da conta
	*	@param	 $oidEmpresaCont  OID da empresa contabil
    */
    function findByOidNoDV( $oidConta, $oidEmpresaCont = 0 ) {

		// Seta variaveis utilizadas no metodo
		$flagAchou	    = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagAchou;

		$instrucao  = "select codigoacesso, codigoempresa, dv, codigosintetico, descricao, ";
		$instrucao .= " natureza, tipo, despesareceita, podecredora, podedevedora, contadoar from contacontabil_cont ";
		$instrucao .= " where codigoacesso = '$oidConta' ";
		if ( $oidEmpresaCont != 0 )
			$instrucao .= " and codigoempresa = '$oidEmpresaCont';";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {

			// Se conseguiu achar...
			if ( $broker->retornaNumLinhas() > 0 ) {
				$flagAchou = true;

				// seta variaveis de instancia
				$this->oidConta 	   = $broker->retornaResultado( 0, 0 );
				$this->oidEmpresaCont  = $broker->retornaResultado( 0, 1 );
				$this->dv	       = $broker->retornaResultado( 0, 2 );
				$this->codigoSintetico = $broker->retornaResultado( 0, 3 );
				$this->descricao       = $broker->retornaResultado( 0, 4 );
				$this->natureza        = $broker->retornaResultado( 0, 5 );
				$this->tipo	       = $broker->retornaResultado( 0, 6 );
				$this->classificacao   = $broker->retornaResultado( 0, 7 );
				$this->credora	       = $broker->retornaResultado( 0, 8 );
				$this->devedora        = $broker->retornaResultado( 0, 9 );
				$this->oidContaDoar    = $broker->retornaResultado( 0, 10 );

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
		return array( $this->oidConta, $this->oidEmpresaCont, $this->dv,
						$this->codigoSintetico, $this->descricao,
						$this->natureza, $this->tipo, $this->classificacao,
						$this->credora, $this->devedora, $this->oidContaDoar );

    }

    /**
    *	update( $oidContaDV )
    *	Altera objeto persistente
    *	@param	 $oidContaDV	OID da conta com DV
    *	@return  $flagGravou	true se foi possivel gravar ou false caso contrario
    */
    function update( $oidContaDV ) {

		// Seta variaveis utilizadas no metodo
		$this->setOidContaDV( $oidContaDV );
		$flagGravou		= false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagGravou;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "update contacontabil_cont ";
		$instrucao .= " set descricao = '$this->descricao', ";
		$instrucao .= " natureza = '$this->natureza', ";
		$instrucao .= " tipo = '$this->tipo', ";
		$instrucao .= " despesareceita = '$this->classificacao', ";
		$instrucao .= " podecredora = '$this->credora', ";
		$instrucao .= " podedevedora = '$this->devedora', ";
		$instrucao .= " contadoar = '$this->oidContaDoar' ";
		$instrucao .= " where codigoacesso = '$this->oidConta' and dv = '$this->dv';";

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
		$this->listObjects    = array();
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

				$instrucao  = "select codigoacesso, dv, codigosintetico, descricao, natureza, tipo, contadoar, despesareceita from contacontabil_cont ";
				$instrucao .= " where descricao like '$this->expressao' ";
				$instrucao .= " and codigoempresa = '$this->oidEmpresaCont' ";
				$instrucao .= " order by codigosintetico, codigoacesso, dv, descricao;";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ).".".$broker->retornaResultado( $indx, 1 ),
						$broker->retornaResultado( $indx, 2 ),
						$broker->retornaResultado( $indx, 3 ), $broker->retornaResultado( $indx, 4 ),
						$broker->retornaResultado( $indx, 5 ), $broker->retornaResultado( $indx, 6 ), $broker->retornaResultado( $indx, 7 ) );
				}

			}

			break; }

			// Pesquisa utilizada para verificar conta e retornar seu codigo de acesso c/ dv
			case 2: {

				// Seta variavel de pesquisa...
				$instrucao  = "select codigoempresa, codigoacesso, dv, codigosintetico, descricao, tipo from contacontabil_cont ";
				if ( $oidEmpresaCont != 0 )
					$instrucao .= " where codigoempresa = '$this->oidEmpresaCont' ";
				$instrucao .= " order by codigosintetico, codigoacesso, dv, descricao;";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						$broker->retornaResultado( $indx, 1 ).".".$broker->retornaResultado( $indx, 2 ),
						$broker->retornaResultado( $indx, 3 ), $broker->retornaResultado( $indx, 4 ),
						$broker->retornaResultado( $indx, 5 ) );
				}

			}

			break; }

			// Pesquisa utilizada na listagem de plano de contas de uma determinada empresa
			case 3: {

				// Seta variavel de pesquisa...
				$instrucao  = "select codigoempresa, codigoacesso, dv, codigosintetico, descricao, tipo, natureza, ";
				$instrucao .= " despesareceita, podedevedora, podecredora, contadoar from contacontabil_cont ";
				$instrucao .= " where codigoempresa = '$this->oidEmpresaCont' ";
				$instrucao .= " order by codigosintetico, codigoacesso, dv, descricao;";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						$broker->retornaResultado( $indx, 1 ).".".$broker->retornaResultado( $indx, 2 ),
						$broker->retornaResultado( $indx, 3 ), $broker->retornaResultado( $indx, 4 ),
						$broker->retornaResultado( $indx, 5 ), $broker->retornaResultado( $indx, 6 ),
						$broker->retornaResultado( $indx, 7 ), $broker->retornaResultado( $indx, 8 ),
						$broker->retornaResultado( $indx, 9 ), $broker->retornaResultado( $indx, 10 ) );

				}

			}

			break; }

			// Pesquisa todas as contas de todas as empresas contabeis, somente as analiticas...
			case 4: {

				// Seta variavel de pesquisa...
				$instrucao  = "select codigoempresa, codigoacesso, dv, codigosintetico, descricao, tipo from contacontabil_cont where ";
				if ( $oidEmpresaCont != 0 )
					$instrucao .= " codigoempresa = '$this->oidEmpresaCont' and ";
				$instrucao .= " tipo = 'A' ";
				$instrucao .= " order by codigosintetico, codigoacesso, dv, descricao;";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						$broker->retornaResultado( $indx, 1 ).".".$broker->retornaResultado( $indx, 2 ),
						$broker->retornaResultado( $indx, 3 ), $broker->retornaResultado( $indx, 4 ),
						$broker->retornaResultado( $indx, 5 ) );
				}

			}

			break; }

			// Pesquisa as contas que fazem parte de um determinado grupo, somente as analiticas...
			case 5: {

				$this->expressao     = trim( $expressao )."%";
				// Seta variavel de pesquisa...
				$instrucao  = "select codigoacesso from contacontabil_cont where ";
				if ( $oidEmpresaCont != 0 )
					$instrucao .= " codigoempresa = '$this->oidEmpresaCont' and ";
				$instrucao .= " tipo = 'A' and ";
				$instrucao .= " codigosintetico like '$this->expressao' and ";
				$instrucao .= " codigoempresa = '$oidEmpresaCont' order by codigosintetico;";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ) );
				}

			}

			break; }

			// Pesquisa todas as contas de todas as empresas contabeis...
			case 6: {

				// Seta variavel de pesquisa...
				$instrucao  = "select codigoempresa, codigoacesso, dv, codigosintetico, descricao, tipo from contacontabil_cont ";
				if ( $oidEmpresaCont != 0 )
					$instrucao .= " where codigoempresa = '$this->oidEmpresaCont' ";
				$instrucao .= " order by codigosintetico, codigoacesso, dv, descricao;";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						$broker->retornaResultado( $indx, 1 ).".".$broker->retornaResultado( $indx, 2 ),
						$broker->retornaResultado( $indx, 3 ), $broker->retornaResultado( $indx, 4 ),
						$broker->retornaResultado( $indx, 5 ) );
				}

			}

			break; }

			// Pesquisa todas as contas de um determinado Grupo de Contas...
			case 7: {

				// Seta variavel de pesquisa...
				$expressao = trim($expressao);
				$instrucao  = "select codigoempresa, codigoacesso, dv, codigosintetico, descricao, tipo from contacontabil_cont where ";
				if ( $oidEmpresaCont != 0 )
					$instrucao .= " codigoempresa = '$this->oidEmpresaCont' and ";
				$instrucao .= " codigosintetico like '$expressao%' and tipo = 'A' ";
				$instrucao .= " order by codigosintetico, codigoacesso, dv, descricao;";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						$broker->retornaResultado( $indx, 1 ).".".$broker->retornaResultado( $indx, 2 ),
						$broker->retornaResultado( $indx, 3 ), $broker->retornaResultado( $indx, 4 ),
						$broker->retornaResultado( $indx, 5 ) );
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
    *	delete( $oidContaDV )
    *	Exclui objeto persistente
    *	@param	 $oidContaDV	 OID da conta
    *	@return  $flagExcluiu true se foi possivel gravar ou false caso contrario
    */
    function delete( $oidContaDV ) {

		// Seta variaveis utilizadas no metodo
		$this->setOidContaDV( $oidContaDV );
		$flagExcluiu	    = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagExcluiu;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "delete from contacontabil_cont ";
		$instrucao .= "where codigoacesso = '$this->oidConta' and dv = '$this->dv';";

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
    *	findByParams( $oidEmpresaCont, $codigoSintetico, $descricao, $natureza, $tipo )
    *	Pesquisa por critério de selecao, retornando o OID para gerar DV
    *	@param	$oidEmpresaCont 	OID da empresa
    *	@param	$codigoSintetico	Codigo sintetico
	*	@param	$descricao	    Descricao da conta
	*	@param	$natureza	    Natureza da operacao
	*	@param	$tipo		    Tipo
    */
    function findByParams( $oidEmpresaCont, $codigoSintetico, $descricao, $natureza, $tipo ) {

		// Seta variaveis utilizadas no metodo
		$this->oidEmpresaCont  = $oidEmpresaCont;
		$this->codigoSintetico = $codigoSintetico;
		$this->descricao       = $descricao;
		$this->natureza        = $natureza;
		$this->tipo	       = $tipo;
		$retorna	       = 0;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return false;

		$instrucao  = "select codigoacesso from contacontabil_cont ";
		$instrucao .= " where descricao = '$this->descricao' ";
		$instrucao .= " and codigoempresa = '$this->oidEmpresaCont' and ";
		$instrucao .= " codigosintetico = '$this->codigoSintetico' and ";
		$instrucao .= " natureza = '$this->natureza' and ";
		$instrucao .= " tipo = '$this->tipo';";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {

			$retorna  = $broker->retornaResultado( 0, 0 );

		}

		// fecha conexao...
		$broker->fechaConexao();

		return $retorna;

    }

    /**
    *	updateDV( $oidConta )
    *	Altera objeto persistente
    *	@param	 $oidConta    OID da conta
	*	@param	 $dv	      Digito verificador
    *	@return  $flagGravou  true se foi possivel gravar ou false caso contrario
    */
    function updateDV( $oidConta ) {

		// Seta variaveis utilizadas no metodo
		$this->setOidConta( $oidConta );
		$flagGravou		= false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagGravou;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "update contacontabil_cont ";
		$instrucao .= " set dv = '$this->dv' ";
		$instrucao .= " where codigoacesso = '$this->oidConta';";
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
    *	findByOidConta( $codigoSintetico, $oidEmpresaCont )
    *	Pesquisa pelo OID do Objeto, para inclusao
    *	@param	 $codigoSintetico	Codigo sintetico
	*	@param	 $oidEmpresaCont		OID da empresa contabil
    */
    function findByOidConta( $codigoSintetico, $oidEmpresaCont = 0 ) {

		// Seta variaveis utilizadas no metodo
		$flagAchou	    = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagAchou;

		$instrucao  = "select codigoacesso ";
		$instrucao .= " from contacontabil_cont ";
		$instrucao .= " where codigosintetico = '$codigoSintetico' ";
		if ( $oidEmpresaCont != 0 )
			$instrucao .= " and codigoempresa = '$oidEmpresaCont';";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {

			// Se conseguiu achar...
			if ( $broker->retornaNumLinhas() > 0 ) {
				$flagAchou = true;

			}

		}

		// fecha conexao...
		$broker->fechaConexao();

		// Retorna flag...
		return $flagAchou;

    }

}

?>
