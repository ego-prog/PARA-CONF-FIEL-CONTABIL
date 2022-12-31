<?PHP

/**
*
*		FIEL Contábil
*
*		Data de Criacao: 26/05/2003
*		Ultima Atualizacao: 03/12/2003
*		Modulo: LancamentoProxy.php
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
*	LancamentoProxy
*
*	Classe que persiste os dados de lancamentos
*	no Contábil Web
*
*/
class LancamentoProxy extends Proxy {

	  var $broker;					// Atributo de persistencia (Singleton)
	  var $oidLancamento;	// OID do lancamento
	  var $oidEmpresaCont;	// OID da empresa contabil
	  var $dataLancamento;	// Data de lancamento
	  var $dataDigitacao;	// Data de digitacao
	  var $horaDigitacao;	// Hora de digitacao
	  var $loginOperador;	// Login operador
	  var $dataLiberacao;	// Data de liberacao
	  var $horaLiberacao;	// Hora de liberacao
	  var $loginSupervisor; // Login do supervisor
	  var $aberto;			// Aberto
	  var $contabilizado;	// Contabilizado
	  var $listObjects;		// Lista de objetos
	  var $expressao;			// Expressao de busca
	  var $flagAuxiliar;		// Flag auxiliar de desenvolvimento

	  /**
	  *		getBroker()
	  *  Retorna o broker utilizado para persistencia
	  *  @return getBroker
	  */
	  function getBroker() {

			   return BD_PgSQL;

	  }

	  /**
	  *	   setObject( $oidEmpresaCont, $dataLancamento, $dataDigitacao,
	  *			   $horaDigitacao, $loginOperador, $contabilizado )
	  *	   @param $oidEmpresaCont	  OID da empresa
	  *	   @param $dataLancamento	  Data de lancamento
	  *	   @param $dataDigitacao	  Data de digitacao
	  *	   @param $horaDigitacao	  Hora de digitacao
	  *	   @param loginOperador 	  Login do operador
	  *	   @param $contabilizado	  Contabilizado
	  */
	  function setObject( $oidEmpresaCont, $dataLancamento, $dataDigitacao,
										$horaDigitacao, $loginOperador, $contabilizado ) {

			 // Seta os atributos para objeto
			 $this->oidEmpresaCont = $oidEmpresaCont;
			 $this->dataLancamento = Data::converteDmaAmd( $dataLancamento );
			 $this->dataDigitacao  = Data::converteDmaAmd( $dataDigitacao );
			 $this->horaDigitacao  = $horaDigitacao;
			 $this->loginOperador  = $loginOperador;
			 $this->contabilizado  = $contabilizado;

	  }

	  /**
	  *	 setLiberaObject( $oidLancamento, $dataLiberacao, $horaLiberacao,
	  *					$loginSupervisor, $contabilizado )
	  *	 Recebe os dados para manipulacao
	  *	 @param $oidEmpresaCont 	OID da empresa contabil
	  *	 @param $dataLiberacao		Data de liberacao
	  *	 @param $horaLiberacao		Hora de liberacao
	  *	 @param $loginSupervisor	Login de supervisor
	  *	 @param $contabilizado		Contabilizado
	  */
	  function setLiberaObject( $oidLancamento, $dataLiberacao, $horaLiberacao,
								$loginSupervisor, $contabilizado ) {

		  $this->oidLancamento	 = $oidLancamento;
		  $this->dataLiberacao	 = Data::converteDmaAmd( $dataLiberacao );
		  $this->horaLiberacao	 = $horaLiberacao;
		  $this->loginSupervisor = $loginSupervisor;
		  $this->contabilizado	 = $contabilizado;

	  }

	  /**
	  *    save()
	  *    Grava objeto persistente
	  *    @return	flagGravou		 true se foi possivel gravar ou false caso contrario
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
				 $instrucao  = "insert into cablancamento_cont ( codigo, codigoempresa, data, datadigitacao, ";
				 $instrucao .= " horadigitacao, loginoperador, horaliberacao, aberto, contabilizado ) ";
				 $instrucao .= " values ";
				 $instrucao .= " ( nextval('cablancamento_pk'), '$this->oidEmpresaCont', '$this->dataLancamento', ";
				 $instrucao .= " '$this->dataDigitacao', '$this->horaDigitacao', '$this->loginOperador', ";
				 $instrucao .= " '$horaLiberacao', 'S', 'N' );";

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
	*	findByOid( $oidLancamento )
	*	Pesquisa pelo OID do Objeto
	*	@param	 $oidLancamento   OID do lancamento
	*/
	function findByOid( $oidLancamento ) {

				// Seta variaveis utilizadas no metodo
				$this->oidLancamento = $oidLancamento;
				$flagAchou			 = false;

				// Cria broker para conexao...
				$broker = $this->criaBroker();

				// Abre conexao...
				if ( !$broker->abreConexao() )
						return $flagAchou;

				$instrucao	= "select codigo, codigoempresa, data, datadigitacao, horadigitacao, ";
				$instrucao .= " loginoperador, dataliberacao, horaliberacao, loginsupervisor, ";
				$instrucao .= " aberto, contabilizado ";
				$instrucao .= " from cablancamento_cont where codigo = '$this->oidLancamento';";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

						// Se conseguiu achar...
						if ( $broker->retornaNumLinhas() > 0 ) {
								$flagAchou = true;

								// seta variaveis de instancia
								$this->oidLancamento   = $broker->retornaResultado( 0, 0 );
								$this->oidEmpresaCont  = $broker->retornaResultado( 0, 1 );
								$this->dataLancamento  = Data::converteAmdDma( $broker->retornaResultado( 0, 2 ) );
								$this->dataDigitacao   = Data::converteAmdDma( $broker->retornaResultado( 0, 3 ) );
								$this->horaDigitacao   = $broker->retornaResultado( 0, 4 );
								$this->loginOperador   = $broker->retornaResultado( 0, 5 );
								$this->dataLiberacao   = Data::converteAmdDma( $broker->retornaResultado( 0, 6 ) );
								$this->horaLiberacao   = $broker->retornaResultado( 0, 7 );
								$this->loginSupervisor = $broker->retornaResultado( 0, 8 );
								$this->aberto		   = $broker->retornaResultado( 0, 9 );
								$this->contabilizado   = $broker->retornaResultado( 0, 10 );
						
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
	*	@return $array				 Retorna objeto atual
	*/
	function getObject() {

				// retorna objeto atual
				return array( $this->oidLancamento, $this->oidEmpresaCont, $this->dataLancamento,
												$this->dataDigitacao, $this->horaDigitacao, $this->loginOperador,
												$this->dataLiberacao, $this->horaLiberacao, $this->loginSupervisor,
												$this->aberto, $this->contabilizado );

	}

	/**
	*	update( $oidLancamento )
	*	Altera objeto persistente
	*	@param	 $oidLancamento  OID do lancamento
	*	@return  $flagGravou	true se foi possivel gravar ou false caso contrario
	*/
	function update( $oidLancamento ) {

				// Seta variaveis utilizadas no metodo
				$this->oidLancamento = $oidLancamento;
				$flagGravou			 = false;

				// Cria broker para conexao...
				$broker = $this->criaBroker();

				// Abre conexao...
				if ( !$broker->abreConexao() )
						return $flagGravou;

				// Inicia Transacao...
				$broker->iniciaTransacao();

				// Monta instrucao...
				$instrucao	= "update cablancamento_cont ";
				$instrucao .= " set ";
				$instrucao .= " aberto = 'N' ";
				$instrucao .= " where codigo = '$this->oidLancamento';";

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
	*	findByDataLoginEmpresa( $dataLancamento, $loginOperador, $oidEmpresaCont )
	*	Pesquisa pelo OID do Objeto
	*	@param	$dataLancamento data de lancamento
		*		@param	$loginOperador	 Login operador
		*		@param	$oidEmpresaCont  OID da empresa
		*		@return true se enccontrou
	*/
	function findByDataLoginEmpresa( $dataLancamento, $loginOperador, $oidEmpresaCont ) {

				// Seta variaveis utilizadas no metodo
				$this->dataLancamento = Data::converteDmaAmd( $dataLancamento );
				$this->loginOperador  = $loginOperador;
				$this->oidEmpresaCont = $oidEmpresaCont;
				$flagAchou			 = false;

				// Cria broker para conexao...
				$broker = $this->criaBroker();

				// Abre conexao...
				if ( !$broker->abreConexao() )
						return $flagAchou;

				$instrucao	= "select codigo ";
				$instrucao .= " from cablancamento_cont where data = '$this->dataLancamento' ";
				$instrucao .= " and loginoperador = '$this->loginOperador' and ";
				$instrucao .= " codigoempresa = '$this->oidEmpresaCont' and aberto = 'S';";
				
				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

						// Se conseguiu achar...
						if ( $broker->retornaNumLinhas() > 0 ) {
								$flagAchou = true;

								// seta variaveis de instancia
								$this->oidLancamento   = $broker->retornaResultado( 0, 0 );
						
						}

				}

				// fecha conexao...
				$broker->fechaConexao();

				// Retorna flag...
				return $flagAchou;

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
	*	delete( $oidLancamento )
	*	Exclui objeto persistente
	*	@param	 $oidLancamento   OID de lancamento
	*	@return  $flagExcluiu true se foi possivel gravar ou false caso contrario
	*/
	function delete( $oidLancamento ) {

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
				$instrucao	= "delete from cablancamento_cont ";
				$instrucao .= "where codigo = '$this->oidLancamento';";
				
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
	*	searchLancamentosPeriodo( $dataInicial, $dataFinal, $oidEmpresaCont, $loginUsuario = 0,
	*						$exibeNaoLiberado = 0, $contabilizado )
	*	Pesquisa OIDs de lancamentos por critério de selecao
	*		@param	$dataInicial	  Data inicial
	*		@param	$dataFinal		  Data final
	*		@param	$oidEmpresaCont   OID da empresa de contabil
	*		@param	$loginUsuario	  Login de usuario
	*		@param	$exibeNaoLiberado Exibe lancamentos nao liberados
	*		@param	$contabilizado	  Contabilizado (default = N)
	*/
	function searchLancamentosPeriodo( $dataInicial, $dataFinal, $oidEmpresaCont, 
						$loginUsuario = 0, $exibeNaoLiberado = "N", $contabilizado = "N" ) {

				// Seta variaveis utilizadas no metodo
				$this->oidEmpresaCont = $oidEmpresaCont;
				$dataInicial		  = Data::converteDmaAmd( $dataInicial );
				$dataFinal			  = Data::converteDmaAmd( $dataFinal );
				$this->listObjects	  = array();
				$this->listObjects[0][0] = "0";

				// Cria broker para conexao...
				$broker = $this->criaBroker();

				// Abre conexao...
				if ( !$broker->abreConexao() )
						return false;

				$instrucao	= "select codigo, data, contabilizado ";
				$instrucao .= " from cablancamento_cont ";
				$instrucao .= " where data between '$dataInicial' and '$dataFinal' ";
				$instrucao .= " and codigoempresa = '$this->oidEmpresaCont' and aberto = 'N' ";
				if ( $exibeNaoLiberado == "S" )
						$instrucao.= " and contabilizado = '$contabilizado' ";
				if ( $loginUsuario != 0 )
						$instrucao .= " and loginoperador = '$loginUsuario' ";
				$instrucao .= " order by data, codigo;";
				
				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

						// Monta array de retorno
						for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {
								$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
														Data::converteAmdDma( $broker->retornaResultado( $indx, 1 ) ),
														$broker->retornaResultado( $indx, 2 ) );
						}

				}

				// fecha conexao...
				$broker->fechaConexao();

	}

	/**
	*	updateLiberacao( $oidLancamento )
	*	Altera objeto persistente
	*	@param	 $oidLancamento  OID do lancamento
	*	@return  $flagGravou	true se foi possivel gravar ou false caso contrario
	*/
	function updateLiberacao( $oidLancamento ) {

				// Seta variaveis utilizadas no metodo
				$this->oidLancamento = $oidLancamento;
				$flagGravou			 = false;

				// Cria broker para conexao...
				$broker = $this->criaBroker();

				// Abre conexao...
				if ( !$broker->abreConexao() )
						return $flagGravou;

				// Inicia Transacao...
				$broker->iniciaTransacao();

				// Monta instrucao...
				$instrucao	= "update cablancamento_cont ";
				$instrucao .= " set ";
				$instrucao .= " dataliberacao = '$this->dataLiberacao', ";
				$instrucao .= " horaliberacao = '$this->horaLiberacao', ";
				$instrucao .= " loginsupervisor = '$this->loginSupervisor', ";
				$instrucao .= " contabilizado = '$this->contabilizado' ";
				$instrucao .= " where codigo = '$this->oidLancamento';";

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
	*	searchSaldoConta( $oidConta, $dataLimite, $contabilizado, $operacao )
	*	Pesquisa saldo da conta por data limite
	*		@param	$oidConta				  OID da conta
	*		@param	$dataLimite	  Data limite
	*		@param	$contabilizado	  Se o lancamento esta contabilizado ou nao
	*		@param	$operacao
	*		@param	$exibeNaoLiberado Exibe lancamentos nao liberados
	*		@param	$contabilizado	  Contabilizado (default = S)
	*/
	function searchSaldoConta( $oidConta, $dataLimite, $contabilizado = "S", $operacao ) {

				// Seta variaveis utilizadas no metodo
				$this->oidConta = $oidConta;
				$dataLimite	= Data::converteDmaAmd( $dataLimite );
				$conta			= new Conta();

				$conta->pesquisaContaSemDV( $oidConta );
				$oidEmpresaCont = $conta->getOidEmpresaCont();
				$expressao		= trim ( $conta->getCodigoSintetico() )."%";

				// Cria broker para conexao...
				$broker = $this->criaBroker();

				// Abre conexao...
				if ( !$broker->abreConexao() )
						return false;

				$instrucao	= "select sum(valor) from itemlancamento_cont, cablancamento_cont ";
				$instrucao .= " where codigolancamento = cablancamento_cont.codigo and cablancamento_cont.aberto = 'N' ";
				$instrucao .= " and cablancamento_cont.data <= '$dataLimite' ";
				if ( $contabilizado == "S" )
						$instrucao.= " and contabilizado = '$contabilizado' ";
				$instrucao .= " and debitocredito = '$operacao' ";
				if ( $conta->getTipo() == "S" ) {
						$instrucao .= " and itemlancamento_cont.codigoacesso in ( select contacontabil_cont.codigoacesso ";
						$instrucao .= " from contacontabil_cont where contacontabil_cont.codigosintetico like '$expressao' and ";
						$instrucao .= " codigoempresa = '$oidEmpresaCont' );";
				}
				else
						$instrucao .= " and codigoacesso = '$oidConta';";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {
						$saldo = $broker->retornaResultado( 0, 0 );
				}

				$saldo = empty( $saldo )?0:$saldo;
				
				// fecha conexao...
				$broker->fechaConexao();

				return $saldo;

	}

	/**
	*	searchMovimentoConta( $oidConta, $dataInicial, $dataFinal,
	*						  $contabilizado, $operacao, $desconsiderarZeramento, $oidCentroCusto )
	*	Pesquisa movimento da conta, no periodo e operacao
	*		@param	$oidConta				OID da conta
	*		@param	$dataInicial			Data inicial
	*		@param	$dataFinal				Data final
	*		@param	$contabilizado			Contabilizado (default = S)
	*		@param	$operacao				(D/C)
	*		@param	$desconsiderarZeramento Desconsiderar zeramento (default = false)
	*/
	function searchMovimentoConta( $oidConta, $dataInicial, $dataFinal,
			 $contabilizado, $operacao, $desconsiderarZeramento, $oidCentroCusto ) {

				// Seta variaveis utilizadas no metodo
				$this->oidConta = $oidConta;
				$dataInicial	= Data::converteDmaAmd( $dataInicial );
				$dataFinal		= Data::converteDmaAmd( $dataFinal );
				$conta			= new Conta();

				$conta->pesquisaContaSemDV( $oidConta );
				$oidEmpresaCont = $conta->getOidEmpresaCont();
				$expressao		= trim ( $conta->getCodigoSintetico() )."%";

				// Cria broker para conexao...
				$broker = $this->criaBroker();

				// Abre conexao...
				if ( !$broker->abreConexao() )
						return false;

				$instrucao	= "select sum(valor) from itemlancamento_cont, cablancamento_cont ";
				$instrucao .= " where codigolancamento = cablancamento_cont.codigo ";
				$instrucao .= " and cablancamento_cont.aberto = 'N' and cablancamento_cont.data between '$dataInicial' ";
				$instrucao .= " and '$dataFinal' ";
				if ( $contabilizado == "S" )
						$instrucao.= " and contabilizado = '$contabilizado' ";
				$instrucao .= " and debitocredito = '$operacao' ";
				if ( $desconsiderarZeramento == true )
						$instrucao .= " and itemlancamento_cont.codigozeramento = 0 ";
				if ( $oidCentroCusto != "0")
						$instrucao .= " and itemlancamento_cont.codigocentrocusto = '$oidCentroCusto' ";
				if ( strcmp( $conta->getTipo(), "S" ) == 0 ) {
						$instrucao .= " and itemlancamento_cont.codigoacesso in ( select contacontabil_cont.codigoacesso ";
						$instrucao .= " from contacontabil_cont where contacontabil_cont.codigosintetico like '$expressao' and ";
						$instrucao .= " codigoempresa = '$oidEmpresaCont' );";
				}
				else
						$instrucao .= " and codigoacesso = '$oidConta';";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {
						$saldo = $broker->retornaResultado( 0, 0 );
				}

				$saldo = empty( $saldo )?0:$saldo;
				
				// fecha conexao...
				$broker->fechaConexao();

				return $saldo;

	}

	/**
	*	findByOidZeramento( $oidEmpresaCont )
	*	Pesquisa pelo OID de zeramento
	*	@param	 $oidEmpresaCont		OID da empresa contábil
	*/
	function findByOidZeramento( $oidEmpresaCont ) {

				// Seta variaveis utilizadas no metodo
				$this->oidEmpresaCont = $oidEmpresaCont;

				// Cria broker para conexao...
				$broker = $this->criaBroker();

				// Abre conexao...
				if ( !$broker->abreConexao() )
						return $flagAchou;

				$instrucao	= "select max(codigozeramento) ";
				$instrucao .= " from itemlancamento_cont, cablancamento_cont ";
				$instrucao .= " where itemlancamento_cont.codigolancamento = cablancamento_cont.codigo ";
				$instrucao .= " and cablancamento_cont.codigoempresa = '$oidEmpresaCont';";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

						// Se conseguiu achar...
						if ( $broker->retornaNumLinhas() > 0 )
								$oidZeramento = $broker->retornaResultado( 0, 0 );

				}

				// fecha conexao...
				$broker->fechaConexao();

				// Retorna oidZeramento ...
				return $oidZeramento;

	}

	/**
	*	updateStatusLancamento( $oidLancamento, $fechaLancamento )
	*	Seta um lancamento para aberto e nao liberado
	*	@param	 $oidLancamento    OID do lancamento
	*	@param	 $fechaLancamento  fecha o lancamento (true/false)
	*	@return  $flagGravou	   true se foi possivel gravar ou false caso contrario
	*/
	function updateStatusLancamento( $oidLancamento, $fechaLancamento ) {

				// Seta variaveis utilizadas no metodo
				$this->oidLancamento = $oidLancamento;
				$flagGravou		 = false;

				// Cria broker para conexao...
				$broker = $this->criaBroker();

				// Abre conexao...
				if ( !$broker->abreConexao() )
						return $flagGravou;

				// Inicia Transacao...
				$broker->iniciaTransacao();

				// Monta instrucao...
				$instrucao	= "update cablancamento_cont ";
				$instrucao .= " set ";
				if ( $fechaLancamento == true )
				   $instrucao .= " aberto = 'N', ";
				else
				   $instrucao .= " aberto = 'S', ";
				$instrucao .= " contabilizado = 'N' ";
				$instrucao .= " where codigo = '$this->oidLancamento';";

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
	*	searchAllLancamentos()
	*	Busca todos os lancamentos
	*/
	function searchAllLancamentos() {

			 // Seta variaveis utilizadas no metodo
			 $this->oidEmpresaCont = $oidEmpresaCont;
			 $dataInicial		   = Data::converteDmaAmd( $dataInicial );
			 $dataFinal		   = Data::converteDmaAmd( $dataFinal );
			 $this->listObjects    = array();
			 $this->listObjects[0][0] = "0";

			 // Cria broker para conexao...
			 $broker = $this->criaBroker();

			 // Abre conexao...
			 if ( !$broker->abreConexao() )
				  return false;

			 $instrucao  = "select codigo, data, codigoempresa ";
			 $instrucao .= " from cablancamento_cont ";
			 $instrucao .= " order by codigoempresa, data, codigo;";

			 // Executa instrucao SQL...
			 if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {
					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
									 Data::converteAmdDma( $broker->retornaResultado( $indx, 1 ) ),
									 $broker->retornaResultado( $indx, 2 ) );
				}

			 }

			// fecha conexao...
			$broker->fechaConexao();

	}

	/**
	*	searchSomaItens( $oidLancamento, $operacao )
	*	Busca soma de itens referentes a operacao e lancamento
	*	@param	$oidLancamento	   OID do lancamento
	*	@param	$operacao		  (D/C)
	*/
	function searchSomaItens( $oidLancamento, $operacao ) {

			 // Cria broker para conexao...
			 $broker = $this->criaBroker();

			 // Abre conexao...
			 if ( !$broker->abreConexao() )
				   return false;

			 $instrucao  = "select sum(valor) from itemlancamento_cont ";
			 $instrucao .= " where codigolancamento = '$oidLancamento' ";
			 $instrucao .= " and debitocredito = '$operacao';";

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
