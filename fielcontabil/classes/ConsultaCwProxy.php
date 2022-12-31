<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 19/09/2003
*	Modulo: ConsultaCwProxy.php
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
*	ConsultaCwProxy
*
*	Classe que persiste as consultas cadastradas
*	no Contábil
*
*/
class ConsultaCwProxy extends Proxy {

	  var $broker;		       // Atributo de persistencia (Singleton)
	  var $oidConsulta;	       // OID da consulta
	  var $oidEmpresa;	       // OID da empresa
	  var $perfilUsuario;	       // Perfil do usuario
	  var $titulo;		       // titulo da consulta
	  var $modulo;		       // modulo PHP
	  var $instrucaoSql;	       // Instrucao SQL
	  var $listObjects;	       // Lista de objetos
	  var $column;		       // Colunas
	  var $row;		       // Linhas

	/**
	*  getBroker()
	*  Retorna o broker utilizado para persistencia
	*  @return getBroker
	*/
	function getBroker() {

		return BD_PgSQL;

	}

	/**
	*	setObject( $oidEmpresa, $perfilUsuario,
	*		    $titulo, $modulo, $instrucaoSql )
	*	Recebe os dados para registro da Consulta
	*	@param $oidEmpresa	   OID da empresa
	*	@param $perfilUsuario	   Perfil do usuario
	*	@param $titulo		   titulo da consulta
	*	@param $modulo		   modulo PHP
	*	@param $instrucaoSql	   Instrucao SQL
	*/
	function setObject( $oidEmpresa, $perfilUsuario,
			     $titulo, $modulo, $instrucaoSql ) {

		// Seta os atributos para objeto 
		$this->oidEmpresa    = $oidEmpresa;
		$this->perfilUsuario = $perfilUsuario;
		$this->titulo	     = $titulo;
		$this->modulo	     = $modulo;
		$this->instrucaoSql  = $instrucaoSql;

	}

	/**
	*	save()
	*	Grava objeto persistente
	*	@return  flagGravou	  true se foi possivel gravar ou false caso contrario
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
		$instrucao  = "insert into consulta_cont ( codigo, codigocliente, titulo, ";
		$instrucao .= " modulo, instrucaosql, perfilusuario ) values ";
		$instrucao .= " ( nextval('consulta_cont_pk'), '$this->oidEmpresa', ";
		$instrucao .= " '$this->titulo', '$this->modulo', ";
		$instrucao .= " '$this->instrucaoSql', '$this->perfilUsuario' );";

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
	*	search( $oidEmpresa, $perfilUsuario )
	*	Pesquisa por critério de selecao
	*	@param	 oidEmpresa	  OID da empresa
	*	@param	 $perfilUsuario   Perfil do usuario
	*/
	function search( $oidEmpresa, $perfilUsuario ) {

		// Seta variaveis utilizadas no metodo
		$this->oidEmpresa	 = $oidEmpresa;
		$this->perfilUsuario	 = $perfilUsuario;
		$this->listObjects[0][0] = "0";

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
		   return false;

		$instrucao  = "select codigo, titulo, modulo, instrucaosql ";
		$instrucao .= " from consulta_cont ";
		$instrucao .= " where codigocliente = '$this->oidEmpresa' and ";
		$instrucao .= " perfilusuario = '$this->perfilUsuario' order by titulo;";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {

		  // Monta array de retorno
		  for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

			  $this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
							$broker->retornaResultado( $indx, 1 ),
							$broker->retornaResultado( $indx, 2 ),
							$broker->retornaResultado( $indx, 3 ) );

		  }

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
	*	findByOid( $oidConsulta )
	*	Pesquisa pelo OID do Objeto
	*	@param	 oidConsulta	 OID da consulta
	*/
	function findByOid( $oidConsulta ) {

		// Seta variaveis utilizadas no metodo
		$this->oidConsulta = $oidConsulta;
		$flagAchou = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
		   return $flagAchou;

		$instrucao  = "select codigo, codigocliente, titulo, modulo, instrucaosql, ";
		$instrucao .= "perfilusuario ";
		$instrucao .= "from consulta_cont ";
		$instrucao .= "where codigo = '$this->oidConsulta';";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {

		  // Se conseguiu achar...
		  if ( $broker->retornaNumLinhas() > 0 ) {
			  $flagAchou = true;

			  // seta variaveis de instancia
			  $this->oidEmpresa	      = $broker->retornaResultado( 0, 1 );
			  $this->titulo 	      = $broker->retornaResultado( 0, 2 );
			  $this->modulo 	      = $broker->retornaResultado( 0, 3 );
			  $this->instrucaoSql	      = $broker->retornaResultado( 0, 4 );
			  $this->perfilUsuario	      = $broker->retornaResultado( 0, 5 );
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
		return array( $this->oidEmpresa, $this->titulo, $this->modulo,
			   $this->instrucaoSql, $this->perfilUsuario );

	}

	/**
	*	execute( $instrucaoSql )
	*	Executa Instrucao Sql
	*	@param $instrucaoSql	Instrucao SQL
	*	@return true se conseguiu executar consulta
	*/
	function execute( $instrucaoSql ) {

		// Seta variaveis
		$flagExecutou = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
		   return $flagExecutou;

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucaoSql ) ) {
		  $flagExecutou = true;

		  // Retorna nome das colunas a serem listadas
		  for ( $indx = 0; $indx < $broker->retornaNumColunas(); $indx++ )
			  $this->column[$indx] = $broker->retornaNomeColuna( $indx );

		  // Retorna linhas...
		  for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {
			  for ( $indy = 0; $indy < $broker->retornaNumColunas(); $indy++ ) {

				  // Se for data, formatar...
				  if ( $broker->retornaTipoColuna( $indy ) == "date" )
					 $this->row[$indx][$indy] = Data::converteAmdDma( $broker->retornaResultado( $indx, $indy ) );
				  else
					 $this->row[$indx][$indy] = $broker->retornaResultado( $indx, $indy );

			  }
		  }
		}

		// fecha conexao...
		$broker->fechaConexao();

		return $flagExecutou;

	}

	/**
	*  getRows()
	*  Retorna as linhas encontradas
	*  @return $row 	 Linhas
	*/
	function getRows() {

		return $this->row;

	}

	/**
	*  getCols()
	*  Retorna as colunas encontradas
	*  @return $column		Colunas
	*/
	function getCols() {

		return $this->column;

	}

}

?>
