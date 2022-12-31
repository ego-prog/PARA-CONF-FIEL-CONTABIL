<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 29/10/2003
*	Modulo: NotaProxy.php
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
*   NotaProxy
*
*   Classe que persiste os dados das notas explicativas
*   no Contábil Web
*
*/
class NotaProxy extends Proxy {

      var $broker;		    // Atributo de persistencia (Singleton)
      var $oidNota;  		// OID da nota
      var $oidEmpresaCont;	// Codigo da empresa contabil
      var $nota;    		// Nota
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
      *       setObject( $oidEmpresaCont, $nota )
      *       Recebe os dados para registro
      *       @param $oidEmpresaCont	 OID da empresa
      *       @param $nota		 	     Nota
      */
      function setObject( $oidEmpresaCont, $nota ) {

	     // Seta os atributos para objeto
	     $this->oidEmpresaCont = $oidEmpresaCont;
	     $this->nota	       = $nota;

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
		 $instrucao  = "insert into nota_cont ( codigo, codigoempresa, notaexplicativa ) ";
		 $instrucao .= " values ";
		 $instrucao .= " ( nextval('nota_pk'), '$this->oidEmpresaCont', '$this->nota' );";

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
    *	findByOid( $oidNota, $oidEmpresaCont )
    *	Pesquisa pelo OID do Objeto
    *	@param	 $oidNota         OID da nota explicativa
	*	@param   $oidEmpresaCont  OID da empresa contabil
    */
    function findByOid( $oidNota, $oidEmpresaCont = 0 ) {

		// Seta variaveis utilizadas no metodo
		$this->oidNota = $oidNota;
		$flagAchou     = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagAchou;

		$instrucao  = "select codigo, codigoempresa, notaexplicativa from nota_cont ";
		$instrucao .= " where codigo = '$this->oidNota'";
		if ( $oidEmpresaCont != 0 )
			$instrucao .= " and codigoempresa = '$oidEmpresaCont';";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {

			// Se conseguiu achar...
			if ( $broker->retornaNumLinhas() > 0 ) {
				$flagAchou = true;

				// seta variaveis de instancia
				$this->oidNota		  = $broker->retornaResultado( 0, 0 );
				$this->oidEmpresaCont = $broker->retornaResultado( 0, 1 );
				$this->nota           = $broker->retornaResultado( 0, 2 );

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
		return array( $this->oidNota, $this->oidEmpresaCont, $this->nota );

    }

    /**
    *	update( $oidNota )
    *	Altera objeto persistente
    *	@param	 $oidNota	   OID da nota
    *	@return  $flagGravou  true se foi possivel gravar ou false caso contrario
    */
    function update( $oidNota ) {

		// Seta variaveis utilizadas no metodo
		$this->oidNota = $oidNota;
		$flagGravou	   = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagGravou;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "update nota_cont ";
		$instrucao .= " set notaexplicativa = '$this->nota', codigoempresa = '$this->oidEmpresaCont' ";
		$instrucao .= " where codigo = '$this->oidNota';";

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

				$instrucao  = "select codigo, notaexplicativa from nota_cont ";
				$instrucao .= " where notaexplicativa like '$this->expressao' ";
				$instrucao .= " and codigoempresa = '$this->oidEmpresaCont' ";
				$instrucao .= " order by codigo, notaexplicativa;";

				// Executa instrucao SQL...
				if ( $broker->consultaBD( $instrucao ) ) {

				// Monta array de retorno
				for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

					$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						$broker->retornaResultado( $indx, 1 ) );
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
    *	delete( $oidNota )
    *	Exclui objeto persistente
    *	@param	 $oidNota	 OID da nota
    *	@return  $flagExcluiu true se foi possivel gravar ou false caso contrario
    */
    function delete( $oidNota ) {

		// Seta variaveis utilizadas no metodo
		$this->oidNota = $oidNota;
		$flagExcluiu   = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagExcluiu;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "delete from nota_cont ";
		$instrucao .= "where codigo = '$this->oidNota';";

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
