<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 19/09/2003
*	Modulo: LogCwProxy.php
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
*	LogCwProxy
*
*	Classe que persiste as operacoes registradas (LOG)
*	no Contábil
*
*/
class LogCwProxy extends Proxy {

	  var $broker;		      // Atributo de persistencia (Singleton)
	  var $oidEmpresa;	      // OID da empresa
	  var $loginUsuario;	      // Login do usuario
	  var $data;		      // Data
	  var $hora;		      // Hora
	  var $numeroIp;	      // Numero IP
	  var $descricao;	      // descricao
	  var $complemento;	      // complemento
	  var $listObjects;	      // Lista de objetos	  

	/**
	*  getBroker()
	*  Retorna o broker utilizado para persistencia
	*  @return getBroker
	*/
	function getBroker() {

		return BD_PgSQL;

	}

	/**
	*	setObject( $oidEmpresa, $data, $hora, $loginUsuario,
	*		     $numeroIp, $descricao, $complemento )
	*	Recebe os dados para registro
	*	@param $oidEmpresa	 OID da empresa
	*	@param $data		 data
	*	@param $hora		 hora
	*	@param $loginUsuario	 login de usuario
	*	@param $numeroIp	 Numero IP
	*	@param $descricao	 Descricao
	*	@param $complemento	 Complemento
	*/
	function setObject( $oidEmpresa, $data, $hora, $loginUsuario,
				$numeroIp, $descricao, $complemento ) {

		// Seta os atributos para objeto
		$this->oidEmpresa    = $oidEmpresa;
		$this->data	     = $data;
		$this->hora	     = $hora;
		$this->numeroIp      = $numeroIp;
		$this->loginUsuario  = $loginUsuario;
		$this->descricao     = $descricao;
		$this->complemento   = $complemento;

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
		$instrucao  = "insert into log_cont ( codigocliente, data, ";
		$instrucao .= " hora, loginusuario, ";
		$instrucao .= " numeroip, descricao, complemento ) values ";
		$instrucao .= " ( '$this->oidEmpresa', '$this->data', ";
		$instrucao .= " '$this->hora', '$this->loginUsuario', ";
		$instrucao .= " '$this->numeroIp', '$this->descricao', '$this->complemento' );";

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
	*	delete( $numDias, $oidEmpresa )
	*	Deleta objeto persistente
	*	@param	 $numDias	  Numero de Dias que tem que ficar no log
	*	@param	 $oidEmpresa	  OID de empresa
	*	@return  flagDeletou	  true se deletou algum registro
	*/
	function delete( $numDias, $oidEmpresa ) {

		// Seta variaveis utilizadas no metodo
		$flagDeletou = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
		   return $flagDeletou;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "delete from log_cont ";
		$instrucao .= "where data < date_add( now(), interval -$numDias day ) ";
		$instrucao .= "and codigocliente = '$oidEmpresa';";

		// Executa instrucao SQL...
		if ( $broker->atualizaBD( $instrucao ) ) {
		  $flagDeletou = true;
		  $broker->gravaTransacao(); }
		else
		  $broker->abortaTransacao();

		// Finaliza Transacao...
		$broker->finalizaTransacao();

		// fecha conexao...
		$broker->fechaConexao();

		// Retorna flag...
		return $flagDeletou;

	}

	/**
	*	findByLoginNumeroIp( $oidEmpresa, $dataInicial, $dataFinal, $numeroIp, $loginUsuario )
	*	Pesquisa transacoes baseados no filtro informado
	*	@param	$oidEmpresa   OID da empresa
	*	@param	$dataInicial  data inicial
	*	@param	$dataFinal    data final
	*	@param	$numeroIp     Numero IP
	*	@param	$loginUsuario Login do usuario
	*/
	function findByLoginNumeroIp( $oidEmpresa, $dataInicial, $dataFinal, 
				$numeroIp = 0, $loginUsuario = 0 ) {

		// Seta variaveis utilizadas no metodo
		$this->oidEmpresa	 = $oidEmpresa;
		$this->listObjects[0][0] = "0";
		$dataInicial		 = Data::converteDmaAmd( $dataInicial );
		$dataFinal		 = Data::converteDmaAmd( $dataFinal );

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
		   return false;

		$instrucao  = "select data, hora, loginusuario, numeroip, descricao, complemento ";
		$instrucao .= " from log_cont ";
		$instrucao .= " where data between '$dataInicial' and '$dataFinal' ";

		if ( $numeroIp != 0 )
		   $instrucao .= " and numeroip like '$numeroIp%' ";

		if ( $loginUsuario != "0" )
		   $instrucao .= " and loginusuario = '$loginUsuario' ";

		$instrucao .= " order by data, hora, loginusuario, numeroip;";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {

			// Monta array de retorno
			for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

				$this->listObjects[$indx] = array( Data::converteAmdDma( $broker->retornaResultado( $indx, 0 ) ),
							  $broker->retornaResultado( $indx, 1 ),
							  $broker->retornaResultado( $indx, 2 ),
							  $broker->retornaResultado( $indx, 3 ),
							  $broker->retornaResultado( $indx, 4 ),
							  $broker->retornaResultado( $indx, 5 ) );
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

}

?>
