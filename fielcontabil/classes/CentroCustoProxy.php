<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 21/03/2005
*	Ultima Atualizacao: 21/03/2005
*	Modulo: CentroCustoProxy.php
*
*	Desenvolvido por APOENA Solucoes em Software Livre
*	suporte@apoenasoftwarelivre.com.br
*	http://www.apoenasoftwarelivre.com.br
*
*	@author 	Claudimir Zavalik (claudimir@apoenasoftwarelivre.com.br)
*	@author 	Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*	@version	PHP3 & PHP4
*/

// Arquivo "header" do FIEL Contábil
// include $pathClasses."cw.inc";

/**
*
*   CentroCustoProxy
*
*   Classe que persiste os dados dos centros de custo
*   no FIEL Contábil
*
*/
class CentroCustoProxy extends Proxy {

      var $broker;		// Atributo de persistencia (Singleton)
      var $oidCentroCusto;	// OID do centro de custo
      var $oidEmpresaCont;	// Codigo da empresa contabil
      var $sigla;		// Sigla
      var $descricao;		// Descricao
      var $listObjects; 	// Lista de objetos
      var $expressao;		// Expressao de busca
      var $flagAuxiliar;	// Flag auxiliar de desenvolvimento

      /**
      *  getBroker()
      *  Retorna o broker utilizado para persistencia
      *  @return getBroker
      */
      function getBroker() {

		  return BD_PgSQL;

      }

      /**
      *       setObject( $oidEmpresaCont, $sigla, $descricao )
      *       Recebe os dados para registro
      *       @param $oidEmpresaCont	 OID da empresa
      *       @param $sigla		 Sigla
      *       @param $descricao 	 Descricao
      */
      function setObject( $oidEmpresaCont, $sigla, $descricao ) {

	     // Seta os atributos para objeto
	     $this->oidEmpresaCont = $oidEmpresaCont;
	     $this->sigla	   = $sigla;
	     $this->descricao	   = $descricao;

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
		 $instrucao  = "insert into centrocusto_cont ( codigo, codigoempresa, sigla, descricao ) ";
		 $instrucao .= " values ";
		 $instrucao .= " ( nextval('centrocusto_pk'), '$this->oidEmpresaCont', '$this->sigla', '$this->descricao' );";

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
    *	findByOid( $oidCentroCusto, $oidEmpresaCont )
    *	Pesquisa pelo OID do Objeto
    *	@param	 $oidCentroCusto    OID do centro de custo
    *	    @param   $oidEmpresaCont  OID da empresa contabil
    */
    function findByOid( $oidCentroCusto, $oidEmpresaCont = 0 ) {

		// Seta variaveis utilizadas no metodo
		$this->oidCentroCusto = $oidCentroCusto;
		$flagAchou	      = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagAchou;

		$instrucao  = "select codigo, codigoempresa, sigla, descricao from centrocusto_cont ";
		$instrucao .= " where codigo = '$this->oidCentroCusto'";
		if ( $oidEmpresaCont != 0 )
			$instrucao .= " and codigoempresa = '$oidEmpresaCont';";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {

			// Se conseguiu achar...
			if ( $broker->retornaNumLinhas() > 0 ) {
				$flagAchou = true;

				// seta variaveis de instancia
				$this->oidCentroCusto = $broker->retornaResultado( 0, 0 );
				$this->oidEmpresaCont = $broker->retornaResultado( 0, 1 );
				$this->sigla	      = $broker->retornaResultado( 0, 2 );
				$this->descricao      = $broker->retornaResultado( 0, 3 );

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
		return array( $this->oidCentroCusto, $this->oidEmpresaCont, $this->sigla, $this->descricao );

    }

    /**
    *	update( $oidCentroCusto )
    *	Altera objeto persistente
    *	@param	 $oidCentroCusto     OID do centro de custo
    *	@return  $flagGravou  true se foi possivel gravar ou false caso contrario
    */
    function update( $oidCentroCusto ) {

		// Seta variaveis utilizadas no metodo
		$this->oidCentroCusto	= $oidCentroCusto;
		$flagGravou		= false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagGravou;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "update centrocusto_cont ";
		$instrucao .= " set sigla = '$this->sigla', descricao = '$this->descricao', codigoempresa = '$this->oidEmpresaCont' ";
		$instrucao .= " where codigo = '$this->oidCentroCusto';";

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

				$instrucao  = "select codigo, sigla, descricao from centrocusto_cont ";
				$instrucao .= " where descricao like '$this->expressao' ";
				if ($oidEmpresaCont != "0")
				    $instrucao .= " and codigoempresa = '$this->oidEmpresaCont' ";
				$instrucao .= " order by codigo, descricao;";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						$broker->retornaResultado( $indx, 1 ),
						$broker->retornaResultado( $indx, 2 ) );
				}

			}

			break; }

			// Utilizado para registro de lancamentos...
			case 2: {

				$instrucao  = "select codigoempresa, codigo, sigla, descricao from centrocusto_cont ";
				$instrucao .= " where codigoempresa = '$this->oidEmpresaCont' ";
				$instrucao .= " order by codigo, descricao;";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						$broker->retornaResultado( $indx, 1 ),$broker->retornaResultado( $indx, 2 ), $broker->retornaResultado($indx, 3) );
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
    *	delete( $oidCentroCusto )
    *	Exclui objeto persistente
    *	@param	 $oidCentroCusto   OID do centro de custo
    *	@return  $flagExcluiu true se foi possivel gravar ou false caso contrario
    */
    function delete( $oidCentroCusto ) {

		// Seta variaveis utilizadas no metodo
		$this->oidCentroCusto = $oidCentroCusto;
		$flagExcluiu	      = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagExcluiu;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "delete from centrocusto_cont ";
		$instrucao .= "where codigo = '$this->oidCentroCusto';";

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
