<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 17/11/2003
*	Modulo: OrcamentoProxy.php
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
*   OrcamentoProxy
*
*   Classe que persiste os dados de orcamentos
*   no Contábil Web
*
*/
class OrcamentoProxy extends Proxy {

      var $broker;		    // Atributo de persistencia (Singleton)
	  var $oidConta;	// OID da conta
	  var $dv;		// Digito verificador
	  var $ano;		// Ano
	  var $previsto;	// Previsto nos meses
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
      *     setObject( $oidConta, $ano, $previsto )
      *     Recebe os dados para registro
	  *		@param $oidConta	   OID da Conta
	  *		@param $ano				   Ano de previsao
	  *		@param $previsto	   Previsto
      */
      function setObject( $oidConta, $ano, $previsto ) {

	     // Seta os atributos para objeto
	     $this->oidConta = $oidConta;
	     $this->ano      = $ano;
		 $this->previsto = $previsto;

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
		 $instrucao  = "insert into orcamento_cont ( codigoacesso, ano, previsto01, previsto02, ";
		 $instrucao .= " previsto03, previsto04, previsto05, previsto06, previsto07, previsto08, ";
		 $instrucao .= " previsto09, previsto10, previsto11, previsto12 ) ";
		 $instrucao .= " values ";
		 $instrucao .= " ( '$this->oidConta', '$this->ano', ";
		 for ( $indx = 0; $indx < 12; $indx++ ) {
			$tempPrevisto = $this->previsto[$indx]; 
			$instrucao .= " '$tempPrevisto' ";
			$instrucao .= ( $indx == 11 )?"":", ";
		 }
		 $instrucao .= " );";
		 
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
    *	findByOid( $oidConta, $ano )
    *	Pesquisa pelo OID do Objeto
    *	@param	 $oidConta   OID da conta
	*	@param	 $ano	     Ano
    */
    function findByOid( $oidConta, $ano ) {

		// Seta variaveis utilizadas no metodo
		$this->oidConta = $oidConta;
		$this->ano	= $ano;
		$flagAchou	= false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagAchou;

		$instrucao  = "select codigoacesso, ano, previsto01, previsto02, previsto03, ";
		$instrucao .= " previsto04, previsto05, previsto06, previsto07, previsto08, ";
		$instrucao .= " previsto09, previsto10, previsto11, previsto12 ";
		$instrucao .= " from orcamento_cont where codigoacesso = '$this->oidConta'";
		$instrucao .= " and ano = '$this->ano';";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {

			// Se conseguiu achar...
			if ( $broker->retornaNumLinhas() > 0 ) {
				$flagAchou = true;

				// seta variaveis de instancia
				$this->oidConta  = $broker->retornaResultado( 0, 0 );
				$this->ano	 = $broker->retornaResultado( 0, 1 );
				$this->previsto  = array( $broker->retornaResultado( 0, 2 ), $broker->retornaResultado( 0, 3 ),
							$broker->retornaResultado( 0, 4 ), $broker->retornaResultado( 0, 5 ),
							$broker->retornaResultado( 0, 6 ), $broker->retornaResultado( 0, 7 ),
							$broker->retornaResultado( 0, 8 ), $broker->retornaResultado( 0, 9 ),
							$broker->retornaResultado( 0, 10 ), $broker->retornaResultado( 0, 11 ),
							$broker->retornaResultado( 0, 12 ), $broker->retornaResultado( 0, 13 ) );

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
		return array( $this->oidConta, $this->ano, $this->previsto );

    }

    /**
    *	update( $oidConta, $ano )
    *	Altera objeto persistente
    *	@param	 $oidConta	OID da conta
	*	@param	 $ano		Ano
    *	@return  $flagGravou	true se foi possivel gravar ou false caso contrario
    */
    function update( $oidConta, $ano ) {

		// Seta variaveis utilizadas no metodo
		$this->oidConta = $oidConta;
		$this->ano	= $ano;
		$flagGravou	    = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagGravou;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "update orcamento_cont ";
		$instrucao .= " set ";
			for ( $indx = 0; $indx < 12; $indx++ ) {
				$num = $indx + 1;
				$instrucao .= " previsto";
				$instrucao .= ($indx < 9)?"0".$num:$num;
				$tempPrevisto = $this->previsto[$indx];
				$instrucao .= " = '$tempPrevisto'";
				$instrucao .= ( $indx == 11 )?"":", ";
			}
		$instrucao .= " where codigoacesso = '$this->oidConta' ";
		$instrucao .= " and ano = '$this->ano';";
		
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
    *	search( $oidEmpresaCont, $ano, $operacao )
    *	Pesquisa por critério de selecao
	*	@param	$oidEmpresaCont OID da empresa
    *	@param	$ano		    Ano
    *	@param	$operacao	    Operacao a ser realizada
    */
    function search( $oidEmpresaCont, $ano, $operacao = 1 ) {

		// Seta variaveis utilizadas no metodo
		$this->oidEmpresaCont	 = $oidEmpresaCont;
		$this->ano		 = $ano;
		$this->listObjects[0][0] = "0";

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return false;

		switch( $operacao ) {

			case 1: {

				// Seta variavel de pesquisa...
				$instrucao  = "select orc.codigoacesso, orc.ano from ";
				$instrucao .= " orcamento_cont orc, contacontabil_cont conta, empresa_cont emp where ";
				$instrucao .= " conta.codigoacesso = orc.codigoacesso and conta.codigoempresa = emp.codigo ";
				$instrucao .= " and conta.codigoempresa = '$oidEmpresaCont' ";
				$instrucao .= " and orc.ano = '$this->ano' ";
				$instrucao .= " order by orc.ano, orc.codigoacesso;";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						$broker->retornaResultado( $indx, 1 ) );
				}

			}

			break; }

			case 2: {

				// Seta variavel de pesquisa...
				$instrucao  = "select orc.codigoacesso, orc.ano, orc.previsto01, orc.previsto02, ";
				$instrucao .= " orc.previsto03, orc.previsto04, orc.previsto05, orc.previsto06, ";
				$instrucao .= " orc.previsto07, orc.previsto08, orc.previsto09, orc.previsto10, ";
				$instrucao .= " orc.previsto11, orc.previsto12 ";
				$instrucao .= " from ";
				$instrucao .= " orcamento_cont orc, contacontabil_cont conta, empresa_cont emp where ";
				$instrucao .= " conta.codigoacesso = orc.codigoacesso and conta.codigoempresa = emp.codigo ";
				$instrucao .= " and conta.codigoempresa = '$oidEmpresaCont' ";
				$instrucao .= " and orc.ano = '$this->ano' ";
				$instrucao .= " order by orc.ano, orc.codigoacesso;";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						$broker->retornaResultado( $indx, 1 ), $broker->retornaResultado( $indx, 2 ), 
						$broker->retornaResultado( $indx, 3 ), $broker->retornaResultado( $indx, 4 ), 
						$broker->retornaResultado( $indx, 5 ), $broker->retornaResultado( $indx, 6 ),
						$broker->retornaResultado( $indx, 7 ), $broker->retornaResultado( $indx, 8 ),
						$broker->retornaResultado( $indx, 9 ), $broker->retornaResultado( $indx, 10 ),
						$broker->retornaResultado( $indx, 11 ),$broker->retornaResultado( $indx, 12 ),
						$broker->retornaResultado( $indx, 13 ) );
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
    *	delete( $oidConta, $ano )
    *	Exclui objeto persistente
    *	@param	 $oidConta	  OID da conta
	*	@param	 $ano	      Ano
    *	@return  $flagExcluiu true se foi possivel gravar ou false caso contrario
    */
    function delete( $oidConta, $ano ) {

		// Seta variaveis utilizadas no metodo
		$this->oidConta = $oidConta;
		$this->ano	= $ano;
		$flagExcluiu	= false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagExcluiu;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "delete from orcamento_cont ";
		$instrucao .= "where codigoacesso = '$this->oidConta' and ano = '$this->ano';";

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

}

?>
