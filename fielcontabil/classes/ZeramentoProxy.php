<?PHP

/**
*
*		FIEL Contábil
*
*		Data de Criacao: 26/05/2003
*		Ultima Atualizacao: 17/11/2003
*		Modulo: ZeramentoProxy.php
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
include $pathClasses."cw.inc";

/**
*
*	ZeramentoProxy
*
*	Classe que persiste os dados de zeramentos
*	no Contábil Web
*
*/
class ZeramentoProxy extends Proxy {

	  var $broker;					// Atributo de persistencia (Singleton)
	  var $oidZeramento;	// OID de zeramento
	  var $contrapartida;	// Contrapartida (codigo da conta)
	  var $grupo1;			// Grupo 1
	  var $grupo2;			// Grupo 2
	  var $grupo3;			// Grupo 3
	  var $grupo4;			// Grupo 4
	  var $grupo5;			// Grupo 5
	  var $listObjects; 		// Lista de objetos
	  var $expressao;			// Expressao de busca
	  var $flagAuxiliar;		// Flag auxiliar de desenvolvimento

	  /**
	  * 		getBroker()
	  *  Retorna o broker utilizado para persistencia
	  *  @return getBroker
	  */
	  function getBroker() {

				  return BD_PgSQL;

	  }

	  /**
	  * 	setObject( $oidEmpresaCont, $contrapartida, $grupo1, $grupo2,
	  * 							$grupo3, $grupo4, $grupo5 )
	  * 	Recebe os dados para registro
	  * 			@param $oidEmpresaCont	   OID da empresa contabil
	  * 			@param $contrapartida	   Contrapartida
	  * 			@param $grupo1			   grupo 1
	  * 			@param $grupo2			   grupo 2
	  * 			@param $grupo3			   grupo 3
	  * 			@param $grupo4			   grupo 4
	  * 			@param $grupo5			   grupo 5
	  */
	  function setObject( $oidEmpresaCont, $contrapartida, $grupo1,
								$grupo2, $grupo3, $grupo4, $grupo5 ) {

			 // Seta os atributos para objeto
			 $this->oidEmpresaCont = $oidEmpresaCont;
			 $this->contrapartida  = $contrapartida;
			 $this->grupo1		   = $grupo1;
			 $this->grupo2		   = $grupo2;
			 $this->grupo3		   = $grupo3;
			 $this->grupo4		   = $grupo4;
			 $this->grupo5		   = $grupo5;

	  }

		  /**
		  * 			save()
		  * 			Grava objeto persistente
		  * 			@return  flagGravou 	  true se foi possivel gravar ou false caso contrario
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
				 $instrucao  = "insert into zeramento_cont ( codigo, codigoempresa, ";
				 $instrucao .= " contrapartida, grupo1, grupo2, grupo3, grupo4, grupo5 ) ";
				 $instrucao .= " values ";
				 $instrucao .= " ( nextval('zeramento_pk'), '$this->oidEmpresaCont', ";
				 $instrucao .= " '$this->contrapartida', ";
				 $instrucao .= ( empty( $this->grupo1 ) )? "null, ":"'$this->grupo1', ";
				 $instrucao .= ( empty( $this->grupo2 ) )? "null, ":"'$this->grupo2', ";
				 $instrucao .= ( empty( $this->grupo3 ) )? "null, ":"'$this->grupo3', ";
				 $instrucao .= ( empty( $this->grupo4 ) )? "null, ":"'$this->grupo4', ";
				 $instrucao .= ( empty( $this->grupo5 ) )? "null );":"'$this->grupo5');";

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
	*	findByOid( $oidZeramento )
	*	Pesquisa pelo OID do Objeto
	*	@param	 $oidZeramento	 OID do zeramento
		*/
	function findByOid( $oidZeramento ) {

				// Seta variaveis utilizadas no metodo
				$this->oidZeramento = $oidZeramento;
				$flagAchou			= false;

				// Cria broker para conexao...
				$broker = $this->criaBroker();

				// Abre conexao...
				if ( !$broker->abreConexao() )
						return $flagAchou;

				$instrucao	= "select codigo, codigoempresa, contrapartida, ";
				$instrucao .= " grupo1, grupo2, grupo3, grupo4, grupo5 ";
				$instrucao .= " from zeramento_cont where codigo = '$this->oidZeramento';";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

						// Se conseguiu achar...
						if ( $broker->retornaNumLinhas() > 0 ) {
								$flagAchou = true;

								// seta variaveis de instancia
								$this->oidZeramento   = $broker->retornaResultado( 0, 0 );
								$this->oidEmpresaCont = $broker->retornaResultado( 0, 1 );
								$this->contrapartida  = $broker->retornaResultado( 0, 2 );
								$this->grupo1		  = $broker->retornaResultado( 0, 3 );
								$this->grupo2		  = $broker->retornaResultado( 0, 4 );
								$this->grupo3		  = $broker->retornaResultado( 0, 5 );
								$this->grupo4		  = $broker->retornaResultado( 0, 6 );
								$this->grupo5		  = $broker->retornaResultado( 0, 7 );
								
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
				return array( $this->oidZeramento, $this->oidEmpresaCont, $this->contrapartida,
										$this->grupo1, $this->grupo2, $this->grupo3, $this->grupo4, $this->grupo5 );

	}

	/**
	*	search( $oidEmpresaCont, $operacao )
	*	Pesquisa por critério de selecao
	*	@param	$oidEmpresaCont  OID da empresa contabil
	*	@param	$operacao		Operacao a ser realizada
	*/
	function search( $oidEmpresaCont, $operacao = 1 ) {

				// Seta variaveis utilizadas no metodo
				$this->oidEmpresaCont	 = $oidEmpresaCont;
				$this->listObjects[0][0] = "0";

				// Cria broker para conexao...
				$broker = $this->criaBroker();

				// Abre conexao...
				if ( !$broker->abreConexao() )
						return false;

				switch( $operacao ) {

						case 1: {

								// Seta variavel de pesquisa...
								$instrucao	= "select codigo from zeramento_cont ";
								$instrucao .= " where codigoempresa = '$this->oidEmpresaCont' ";
								$instrucao .= " order by contrapartida;";

								// Executa instrucao SQL...
								if ( $broker->consultaBD( $instrucao ) ) {

								// Monta array de retorno
								for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

										$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ) );
								}

						}

						break; }

						case 2: {

								// Seta variavel de pesquisa...
								$instrucao	= "select codigo, codigoempresa, contrapartida, ";
								$instrucao .= " grupo1, grupo2, grupo3, grupo4, grupo5 ";
								$instrucao .= " from zeramento_cont where codigoempresa = '$this->oidEmpresaCont';";

								// Executa instrucao SQL...
								if ( $broker->consultaBD( $instrucao ) ) {

								// Se conseguiu achar...
								if ( $broker->retornaNumLinhas() > 0 ) {

										// seta variaveis de instancia
										$this->oidZeramento 	  = $broker->retornaResultado( 0, 0 );
										$this->oidEmpresaCont = $broker->retornaResultado( 0, 1 );
										$this->contrapartida  = $broker->retornaResultado( 0, 2 );
										$this->grupo1		  = $broker->retornaResultado( 0, 3 );
										$this->grupo2		  = $broker->retornaResultado( 0, 4 );
										$this->grupo3		  = $broker->retornaResultado( 0, 5 );
										$this->grupo4		  = $broker->retornaResultado( 0, 6 );
										$this->grupo5		  = $broker->retornaResultado( 0, 7 );

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
	*	delete( $oidZeramento )
	*	Exclui objeto persistente
	*	@param	 $oidZeramento			OID de zeramento
	*	@return  $flagExcluiu true se foi possivel gravar ou false caso contrario
	*/
	function delete( $oidZeramento ) {

				// Seta variaveis utilizadas no metodo
				$this->oidZeramento = $oidZeramento;
				$flagExcluiu	= false;

				// Cria broker para conexao...
				$broker = $this->criaBroker();

				// Abre conexao...
				if ( !$broker->abreConexao() )
						return $flagExcluiu;

				// Inicia Transacao...
				$broker->iniciaTransacao();

				// Monta instrucao...
				$instrucao	= "delete from zeramento_cont ";
				$instrucao .= "where codigo = '$this->oidZeramento';";

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
	*	findByOidZeramento( $oidEmpresaCont, $contrapartida )
	*	Pesquisa pelo OID do Objeto
	*	@param	 $oidEmpresaCont		OID da empresa
		*		@param	 $contrapartida 	Contrapartida
		*/
	function findByOidZeramento( $oidEmpresaCont, $contrapartida ) {

				// Seta variaveis utilizadas no metodo
				$this->oidEmpresaCont = $oidEmpresaCont;
				$this->contrapartida  = $contrapartida;
				$flagAchou			  = false;

				// Cria broker para conexao...
				$broker = $this->criaBroker();

				// Abre conexao...
				if ( !$broker->abreConexao() )
						return $flagAchou;

				$instrucao	= "select codigo, codigoempresa, contrapartida, ";
				$instrucao .= " grupo1, grupo2, grupo3, grupo4, grupo5 ";
				$instrucao .= " from zeramento_cont where codigoempresa = '$this->oidEmpresaCont' and contrapartida = '$this->contrapartida';";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

						// Se conseguiu achar...
						if ( $broker->retornaNumLinhas() > 0 )
								$flagAchou = true;

				}

				// fecha conexao...
				$broker->fechaConexao();

				// Retorna flag...
				return $flagAchou;

	}
		
}

?>
