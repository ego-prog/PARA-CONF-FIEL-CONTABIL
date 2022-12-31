<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 17/10/2003
*	Modulo: TermoProxy.php
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
*   TermoProxy
*
*   Classe que persiste os dados dos termos de abertura cadastrados
*   no Contábil Web
*
*/
class TermoProxy extends Proxy {

      var $broker;		    // Atributo de persistencia (Singleton)
      var $oidTermo;		// OID do termo
      var $oidEmpresaCont;	// Codigo da empresa contabil
      var $descricao;		// Descricao
      var $texto;		    // texto
      var $localizacao; 	// Localizacao
      var $listObjects; 	// Lista de objetos
      var $expressao;		// Expressao de busca
      var $flagAuxiliar;	// Flag auxiliar de desenvolvimento

      /**
      *  	getBroker()
      *  	Retorna o broker utilizado para persistencia
      *  	@return getBroker
      */
      function getBroker() {

		  return BD_PgSQL;

      }

      /**
      *     setObject( $oidEmpresaCont, $descricao, $texto, $localizacao )
      *     Recebe os dados para registro de departamento
      *     @param $oidEmpresaCont	    OID da empresa
      *     @param $descricao 	     	Descricao
      *     @param $texto		     	texto
      *     @param $localizacao	     	Localizacao
      */
      function setObject( $oidEmpresaCont, $descricao, $texto, $localizacao ) {

		  // Seta os atributos para objeto
		  $this->oidEmpresaCont     = $oidEmpresaCont;
		  $this->descricao	       = $descricao;
		  $this->texto	       = $texto;
		  $this->localizacao        = $localizacao;

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
		  $instrucao  = "insert into termo_cont ( codigo, codigoempresa, descricao, ";
		  $instrucao .= " texto, localizacao ) ";
		  $instrucao .= " values ";
		  $instrucao .= " ( nextval('termo_pk'), '$this->oidEmpresaCont', '$this->descricao', '$this->texto', ";
		  $instrucao .= " '$this->localizacao' );";

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
	  *		findByOid( $oidTermo, $oidEmpresaCont )
	  *		Pesquisa pelo OID do Objeto
	  *		@param	 $oidTermo        OID do termo
	  *		@param   $oidEmpresaCont  OID da empresa contabil
	  */
	  function findByOid( $oidTermo, $oidEmpresaCont = 0 ) {

		  // Seta variaveis utilizadas no metodo
		  $this->oidTermo = $oidTermo;
		  $flagAchou = false;

		  // Cria broker para conexao...
		  $broker = $this->criaBroker();

		  // Abre conexao...
		  if ( !$broker->abreConexao() )
		  	return $flagAchou;

			$instrucao  = "select codigo, codigoempresa, descricao, texto, localizacao from termo_cont ";
			$instrucao .= " where codigo = '$this->oidTermo'";
			if ( $oidEmpresaCont != 0 )
				$instrucao .= " and codigoempresa = '$oidEmpresaCont';";

			// Executa instrucao SQL...
			if ( $broker->consultaBD( $instrucao ) ) {

				// Se conseguiu achar...
				if ( $broker->retornaNumLinhas() > 0 ) {
					$flagAchou = true;

					// seta variaveis de instancia
					$this->oidTermo		  = $broker->retornaResultado( 0, 0 );
					$this->oidEmpresaCont = $broker->retornaResultado( 0, 1 );
					$this->descricao	  = $broker->retornaResultado( 0, 2 );
					$this->texto		  = $broker->retornaResultado( 0, 3 );
					$this->localizacao	  = $broker->retornaResultado( 0, 4 );

				}

			}

			// fecha conexao...
			$broker->fechaConexao();

			// Retorna flag...
			return $flagAchou;

	  }

	  /**
	  *		getObject()
	  *		Retorna objeto atual
	  *		@return $array		     Retorna objeto atual
	  */
	  function getObject() {

		  // retorna objeto atual
		  return array( $this->oidTermo, $this->oidEmpresaCont, $this->descricao,
		  	    $this->texto, $this->localizacao );

	  }

	  /**
	  *		update( $oidTermo )
	  *		Altera objeto persistente
	  *		@param	 $oidTermo	   OID do termo
	  *		@return  $flagGravou	   true se foi possivel gravar ou false caso contrario
	  */
	  function update( $oidTermo ) {

		  // Seta variaveis utilizadas no metodo
		  $this->oidTermo = $oidTermo;
		  $flagGravou	= false;

		  // Cria broker para conexao...
		  $broker = $this->criaBroker();

		  // Abre conexao...
		  if ( !$broker->abreConexao() )
		  	return $flagGravou;

		  // Inicia Transacao...
		  $broker->iniciaTransacao();

		  // Monta instrucao...
		  $instrucao  = "update termo_cont ";
		  $instrucao .= " set descricao = '$this->descricao', texto = '$this->texto', localizacao = '$this->localizacao' ";
		  $instrucao .= " where codigo = '$this->oidTermo';";

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
	  *		search( $oidEmpresaCont, $expressao, $operacao )
	  *		Pesquisa por critério de selecao
	  *		@param	$oidEmpresaCont OID da empresa
	  *		@param	$expressao	Expressao de busca
	  *		@param	$operacao	Operacao a ser realizada
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

				  $instrucao  = "select codigo, descricao, texto, localizacao from termo_cont ";
				  $instrucao .= " where descricao like '$this->expressao' ";
				  $instrucao .= " and codigoempresa = '$this->oidEmpresaCont' ";
				  $instrucao .= " order by descricao, texto;";

				  // Executa instrucao SQL...
				  if ( $broker->consultaBD( $instrucao ) ) {

					  // Monta array de retorno
					  for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

						  $this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
						  $broker->retornaResultado( $indx, 1 ), $broker->retornaResultado( $indx, 2 ),
						  $broker->retornaResultado( $indx, 3 ) );
					  }

				  }

			  break; }

		  }

		  // fecha conexao...
		  $broker->fechaConexao();

	  }

	  /**
	  *  	getList()
	  *  	Retorna lista de objetos
	  *  	@return listObjects
	  */
	  function getList() {

		  return $this->listObjects;

	  }

	  /**
	  *		delete( $oidTermo )
	  *		Exclui objeto persistente
	  *		@param	 $oidTermo	 OID do Termo
	  *		@return  $flagExcluiu true se foi possivel gravar ou false caso contrario
	  */
	  function delete( $oidTermo ) {

		  // Seta variaveis utilizadas no metodo
		  $this->oidTermo = $oidTermo;
		  $flagExcluiu	= false;

		  // Cria broker para conexao...
		  $broker = $this->criaBroker();

		  // Abre conexao...
		  if ( !$broker->abreConexao() )
		  	return $flagExcluiu;

		  // Inicia Transacao...
		  $broker->iniciaTransacao();

		  // Monta instrucao...
		  $instrucao  = "delete from termo_cont ";
		  $instrucao .= "where codigo = '$this->oidTermo';";

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
