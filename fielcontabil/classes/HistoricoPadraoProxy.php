<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 09/11/2003
*	Modulo: HistoricoPadraoProxy.php
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
*   HistoricoPadraoProxy
*
*   Classe que persiste os dados dos historicos padroes
*   no Contábil Web
*
*/
class HistoricoPadraoProxy extends Proxy {

      var $broker;		    // Atributo de persistencia (Singleton)
      var $oidHistorico;	// OID do historico
      var $oidEmpresaCont;	// Codigo da empresa contabil
      var $historico;  		// historico
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
      *       setObject( $oidEmpresaCont, $historico )
      *       Recebe os dados para registro
      *       @param $oidEmpresaCont	 OID da empresa
      *       @param $historico			 Historico
      */
      function setObject( $oidEmpresaCont, $historico ) {

	     // Seta os atributos para objeto
	     $this->oidEmpresaCont = $oidEmpresaCont;
	     $this->historico      = $historico;

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
		 $instrucao  = "insert into historicopadrao_cont ( codigo, codigoempresa, historico ) ";
		 $instrucao .= " values ";
		 $instrucao .= " ( nextval('historicopadrao_pk'), '$this->oidEmpresaCont', '$this->historico' );";

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
    *	findByOid( $oidHistorico, $oidEmpresaCont )
    *	Pesquisa pelo OID do Objeto
    *	@param	 $oidHistorico    OID do historico padrao
	*	@param   $oidEmpresaCont  OID da empresa contabil
    */
    function findByOid( $oidHistorico, $oidEmpresaCont = 0 ) {

		// Seta variaveis utilizadas no metodo
		$this->oidHistorico = $oidHistorico;
		$flagAchou          = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagAchou;

		$instrucao  = "select codigo, codigoempresa, historico from historicopadrao_cont ";
		$instrucao .= " where codigo = '$this->oidHistorico'";
		if ( $oidEmpresaCont != 0 )
			$instrucao .= " and codigoempresa = '$oidEmpresaCont';";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {

			// Se conseguiu achar...
			if ( $broker->retornaNumLinhas() > 0 ) {
				$flagAchou = true;

				// seta variaveis de instancia
				$this->oidHistorico   = $broker->retornaResultado( 0, 0 );
				$this->oidEmpresaCont = $broker->retornaResultado( 0, 1 );
				$this->historico      = $broker->retornaResultado( 0, 2 );

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
		return array( $this->oidHistorico, $this->oidEmpresaCont, $this->historico );

    }

    /**
    *	update( $oidHistorico )
    *	Altera objeto persistente
    *	@param	 $oidHistorico	   OID do historico
    *	@return  $flagGravou  true se foi possivel gravar ou false caso contrario
    */
    function update( $oidHistorico ) {

		// Seta variaveis utilizadas no metodo
		$this->oidHistorico = $oidHistorico;
		$flagGravou	        = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagGravou;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "update historicopadrao_cont ";
		$instrucao .= " set historico = '$this->historico', codigoempresa = '$this->oidEmpresaCont' ";
		$instrucao .= " where codigo = '$this->oidHistorico';";

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

				$instrucao  = "select codigo, historico from historicopadrao_cont ";
				$instrucao .= " where historico like '$this->expressao' ";
				$instrucao .= " and codigoempresa = '$this->oidEmpresaCont' ";
				$instrucao .= " order by codigo, historico;";
				
				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						$broker->retornaResultado( $indx, 1 ) );
				}

			}

			break; }

			// Utilizado para registro de lancamentos...
			case 2: {

				$instrucao  = "select codigoempresa, codigo, historico from historicopadrao_cont ";
				$instrucao .= " where codigoempresa = '$this->oidEmpresaCont' ";
				$instrucao .= " order by codigo, historico;";
				
				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						$broker->retornaResultado( $indx, 1 ),$broker->retornaResultado( $indx, 2 ) );
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
    *	delete( $oidHistorico )
    *	Exclui objeto persistente
    *	@param	 $oidHistorico	 OID do historico
    *	@return  $flagExcluiu true se foi possivel gravar ou false caso contrario
    */
    function delete( $oidHistorico ) {

		// Seta variaveis utilizadas no metodo
		$this->oidHistorico = $oidHistorico;
		$flagExcluiu        = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagExcluiu;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "delete from historicopadrao_cont ";
		$instrucao .= "where codigo = '$this->oidHistorico';";

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
