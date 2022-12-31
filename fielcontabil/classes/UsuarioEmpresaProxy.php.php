<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 12/04/2005
*	Ultima Atualizacao: 12/04/2005
*	Modulo: UsuarioEmpresaProxy.php
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
include $pathClasses."cw.inc";

/**
*
*   UsuarioEmpresaProxy
*
*   Classe que persiste os dados dos vinculos de usuario a empresa
*   no FIEL Contábil
*
*/
class UsuarioEmpresaProxy extends Proxy {

      var $broker;		// Atributo de persistencia (Singleton)
      var $oidUsuarioEmpresa;	// OID do vinculo de Usuario a Empresa
      var $oidEmpresaCont;	// Codigo da empresa contabil
      var $oidUsuario;		// OID do Usuário
      var $oidEmpresa;		// OID da Empresa
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
      *       setObject( $oidEmpresaCont, $oidUsuario, $oidEmpresa )
      *       Recebe os dados para registro
      *       @param $oidEmpresaCont	 OID da empresa (proprietaria)
      *       @param $oidUsuario	 OID do Usuário
      *       @param $oidEmpresa	 OID da Empresa
      */
      function setObject( $oidEmpresaCont, $oidUsuario, $oidEmpresa ) {

	     // Seta os atributos para objeto
	     $this->oidEmpresaCont = $oidEmpresaCont;
	     $this->oidUsuario	   = $oidUsuario;
	     $this->oidEmpresa	   = $oidEmpresa;

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
		 $instrucao  = "insert into usuarioempresa_cont ( codigo, codigousuario, codigoempresa ) ";
		 $instrucao .= " values ";
		 $instrucao .= " ( nextval('usuarioempresa_pk'), '$this->oidUsuario', '$this->oidEmpresa' );";

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
    *	findByOid( $oidUsuarioEmpresa, $oidEmpresaCont )
    *	Pesquisa pelo OID do Objeto
    *	@param	 $oidUsuarioEmpresa   OID do vínculo de usuário a empresa
    *	@param	 $oidEmpresaCont      OID da empresa (proprietária)
    */
    function findByOid( $oidUsuarioEmpresa, $oidEmpresaCont = 0 ) {

		// Seta variaveis utilizadas no metodo
		$this->oidUsuarioEmpresa = $oidUsuarioEmpresa;
		$flagAchou	      = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagAchou;

		$instrucao  = "select codigo, codigousuario, codigoempresa from usuarioempresa_cont ";
		$instrucao .= " where codigo = '$this->oidUsuarioEmpresa'";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {

			// Se conseguiu achar...
			if ( $broker->retornaNumLinhas() > 0 ) {
				$flagAchou = true;

				// seta variaveis de instancia
				$this->oidUsuarioEmpresa = $broker->retornaResultado( 0, 0 );
				$this->oidUsuario	 = $broker->retornaResultado( 0, 1 );
				$this->oidEmpresa	 = $broker->retornaResultado( 0, 2 );

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
		return array( $this->oidUsuarioEmpresa, $this->oidUsuario, $this->oidEmpresa );

    }

    /**
    *	update( $oidUsuarioEmpresa )
    *	Altera objeto persistente
    *	@param	 $oidUsuarioEmpresa	OID do vínculo de usuário a empresas
    *	@return  $flagGravou  true se foi possivel gravar ou false caso contrario
    */
    function update( $oidUsuarioEmpresa ) {

		// Seta variaveis utilizadas no metodo
		$this->oidUsuarioEmpresa   = $oidUsuarioEmpresa;
		$flagGravou		= false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagGravou;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "update usuarioempresa_cont ";
		$instrucao .= " set codigousuario = '$this->oidUsuario', codigoempresa = '$this->oidEmpresa' ";
		$instrucao .= " where codigo = '$this->oidUsuarioEmpresa';";

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

				$instrucao  = "select codigo, codigousuario, codigoempresa from usuarioempresa_cont ";
				$instrucao .= " order by codigoempresa, codigousuario;";

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
    *	delete( $oidUsuarioEmpresa )
    *	Exclui objeto persistente
    *	@param	 $oidUsuarioEmpresa   OID do vínculo de usuário a empresa
    *	@return  $flagExcluiu true se foi possivel gravar ou false caso contrario
    */
    function delete( $oidUsuarioEmpresa ) {

		// Seta variaveis utilizadas no metodo
		$this->oidUsuarioEmpresa = $oidUsuarioEmpresa;
		$flagExcluiu	      = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagExcluiu;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "delete from usuarioempresa_cont ";
		$instrucao .= "where codigo = '$this->oidUsuarioEmpresa';";

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
