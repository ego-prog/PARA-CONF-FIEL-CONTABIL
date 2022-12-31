<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 19/09/2003
*	Modulo: ParametroCwProxy.php
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
*	ParametroCwProxy
*
*	Classe que persiste os objetos parâmetros
*	utilizados no Contábil
*
*/
class ParametroCwProxy extends Proxy {

	  var $broker;		     // Atributo de persistencia (Singleton)
	  var $oidEmpresa;	     // OID da empresa
	  var $empresa; 	     // Empresa
	  var $linha1;		     // Linha 1
	  var $linha2;		     // Linha 2
	  var $linha3;		     // Linha 3
	  var $logotipo;	     // logotipo
	  var $maximoDiasLog;	     // Maximo de dias referentes ao Log

	/**
	*  getBroker()
	*  Retorna o broker utilizado para persistencia
	*  @return getBroker
	*/
	function getBroker() {

		return BD_PgSQL;

	}

	/**
	*	setObject( $empresa, $linha1, $linha2, $linha3,
	*			     $maximoDiasLog )
	*	Recebe os dados para manipulacao
	*	@param $empresa 	      nome da empresa
	*	@param $linha1		      linha 1 de relatorio
	*	@param $linha2		      linha 2 de relatorio
	*	@param $linha3		      linha 3 de relatorio
	*	@param $maximoDiasLog	      Maximo de dias para manutencao no LOG
	*/
	function setObject( $empresa, $linha1, $linha2, $linha3,
					 $maximoDiasLog ) {

		// Seta os atributos para objeto
		$this->empresa		       = $empresa;
		$this->linha1		       = $linha1;
		$this->linha2		       = $linha2;
		$this->linha3		       = $linha3;
		$this->maximoDiasLog	   = $maximoDiasLog;
		$this->prazoEncaminhamento = $prazoEncaminhamento;

	}

	/**
	*	update( $oidEmpresa )
	*	Altera objeto persistente
	*	@param	 oidEmpresa    OID da empresa
	*	@return  flagGravou    true se foi possivel gravar ou false caso contrario
	*/
	function update( $oidEmpresa ) {

		// Seta variaveis utilizadas no metodo
		$this->oidEmpresa = $oidEmpresa;
		$flagGravou = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
		   return $flagGravou;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "update parametro_cont ";
		$instrucao .= " set cliente = '$this->empresa', linha1 = '$this->linha1', ";
		$instrucao .= " linha2 = '$this->linha2', linha3 = '$this->linha3', ";
		$instrucao .= " maximodiaslog = '$this->maximoDiasLog' ";
		$instrucao .= " where codigocliente = '$this->oidEmpresa';";

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
	*	getObject()
	*	Retorna objeto atual
	*	@return $array				 Retorna objeto atual
	*/
	function getObject() {

		// retorna objeto atual
		return array( $this->oidEmpresa, $this->empresa, $this->linha1,
			   $this->linha2, $this->linha3, $this->maximoDiasLog, 
			   $this->logotipo, $this->prazoEncaminhamento );

	}

	/**
	*	findByOid( $oidEmpresa )
	*	Pesquisa pelo OID do Objeto
	*	@param	 oidEmpresa	OID da empresa
	*/
	function findByOid( $oidEmpresa ) {

		// Seta variaveis utilizadas no metodo
		$this->oidEmpresa = $oidEmpresa;
		$flagAchou = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
		   return $flagAchou;

		$instrucao  = "select codigocliente, cliente, linha1, linha2, linha3, ";
		$instrucao .= " maximodiaslog, logotipo ";
		$instrucao .= " from parametro_cont ";
		$instrucao .= " where codigocliente = '$this->oidEmpresa';";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {
		  $flagAchou = true;

		  // seta variaveis de instancia
		  $this->oidEmpresa	     = $broker->retornaResultado( 0, 0 );
		  $this->empresa	     = $broker->retornaResultado( 0, 1 );
		  $this->linha1 	     = $broker->retornaResultado( 0, 2 );
		  $this->linha2 	     = $broker->retornaResultado( 0, 3 );
		  $this->linha3 	     = $broker->retornaResultado( 0, 4 );
		  $this->maximoDiasLog	 = $broker->retornaResultado( 0, 5 );
		  $this->logotipo	     = $broker->retornaResultado( 0, 6 );

		}

		// fecha conexao...
		$broker->fechaConexao();

		// Retorna flag...
		return $flagAchou;

	}

}

?>
