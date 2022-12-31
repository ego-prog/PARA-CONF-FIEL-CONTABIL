<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 19/09/2003
*	Modulo: UsuarioCwProxy.php
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
*	UsuarioCwProxy
*
*	Classe que persiste os usuarios cadastrados
*	no Contábil
*
*/
class UsuarioCwProxy extends Proxy {

	  var $broker;		       // Atributo de persistencia (Singleton)
	  var $oidUsuario;	       // OID do usuario
	  var $oidEmpresa;	       // OID da empresa
	  var $perfilUsuario;	       // Perfil do usuario
	  var $numeroIp;	       // Numero IP de acesso
	  var $nome;		       // Nome do usuario
	  var $login;		       // Login do usuario
	  var $senha;		       // senha do usuario
	  var $listObjects;	       // Lista de objetos
	  var $expressao;	       // Expressao de busca

	/**
	*  getBroker()
	*  Retorna o broker utilizado para persistencia
	*  @return getBroker
	*/
	function getBroker() {

		return BD_PgSQL;

	}

	/**
	*	setObject( $oidEmpresa, $nome,
	*		     $login, $senha, $perfilUsuario, $numeroIp )
	*	Recebe os dados para registro de usuario
	*	@param $oidEmpresa     OID da empresa
	*	@param $nome	       nome do usuario
	*	@param $login	       login do usuario
	*	@param $senha	       senha de acesso
	*	@param $perfilUsuario  Perfil do usuario
	*	@param $numeroIp       Numero IP de acesso
	*/
	function setObject( $oidEmpresa, $nome,
			      $login, $senha, $perfilUsuario, $numeroIp ) {

		// Seta os atributos para objeto
		$this->oidEmpresa    = $oidEmpresa;
		$this->nome	     = $nome;
		$this->login	     = $login;
		$this->senha	     = $senha;
		$this->perfilUsuario = $perfilUsuario;
		$this->numeroIp      = $numeroIp;

	}

	/**
	*	setUserPass( $oidEmpresa, $oidUsuario, $login, $senha )
	*	Recebe os dados para registro de usuario
	*	@param $oidEmpresa	OID da empresa
	*	@param $oidUsuario	OID do usuario
	*	@param $login		login do usuario
	*	@param $senha		senha de acesso
	*/
	function setUserPass( $oidEmpresa, $oidUsuario,
					   $login, $senha ) {

		// Seta os atributos para objeto
		$this->oidEmpresa  = $oidEmpresa;
		$this->oidUsuario  = $oidUsuario;
		$this->login	   = $login;
		$this->senha	   = $senha;

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
		$instrucao  = "insert into usuario_cont ( codigo, codigocliente, nome, ";
		$instrucao .= " login, senha, perfilusuario, numeroip ) values ";
		$instrucao .= " ( nextval('usuario_cont_pk'), '$this->oidEmpresa', ";
		$instrucao .= " '$this->nome', '$this->login', ";
		$instrucao .= " '$this->senha', '$this->perfilUsuario', '$this->numeroIp' );";

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
	*	updatePass()
	*	Grava objeto persistente
	*	@return  flagGravou	  true se foi possivel gravar ou false caso contrario
	*/
	function updatePass() {

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
		$instrucao  = "update usuario_cont set ";
		$instrucao .= " senha = '$this->senha' where ";
		$instrucao .= " codigocliente = '$this->oidEmpresa' and ";
		$instrucao .= " codigo = '$this->oidUsuario' and login = '$this->login';";

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
	*	findByOid( $oidUsuario )
	*	Pesquisa pelo OID do Objeto
	*	@param	 $oidUsuario	 OID do usuario
	*/
	function findByOid( $oidUsuario ) {

		// Seta variaveis utilizadas no metodo
		$this->oidUsuario = $oidUsuario;
		$flagAchou = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
		   return $flagAchou;

		$instrucao  = "select codigo, codigocliente, nome, login, senha, ";
		$instrucao .= " perfilusuario ";
		$instrucao .= " from usuario_cont ";
		$instrucao .= " where codigo = '$this->oidUsuario';";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {

		  // Se conseguiu achar...
		  if ( $broker->retornaNumLinhas() > 0 ) {
			  $flagAchou = true;

			  // seta variaveis de instancia
			  $this->oidUsuario	= $broker->retornaResultado( 0, 0 );
			  $this->oidEmpresa	= $broker->retornaResultado( 0, 1 );
			  $this->nome		= $broker->retornaResultado( 0, 2 );
			  $this->login		= $broker->retornaResultado( 0, 3 );
			  $this->senha		= $broker->retornaResultado( 0, 4 );
			  $this->perfilUsuario	= $broker->retornaResultado( 0, 5 );
		  }
		}

		// fecha conexao...
		$broker->fechaConexao();

		// Retorna flag...
		return $flagAchou;

	}

	/**
	*	findByLogin( $login, $senha )
	*	Pesquisa usuario pelo login e senha
	*	@param	$login	login do usuario
	*	@param	$senha	senha
	*	@return true se encontrou ou false caso usuario nao esteja cadastrado
	*/
	function findByLogin( $login, $senha ) {

		// Seta variaveis utilizadas no metodo
		$flagAchou = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
		   return $flagAchou;

		$instrucao  = "select codigo, codigocliente, nome, login, senha, ";
		$instrucao .= " perfilusuario ";
		$instrucao .= " from usuario_cont ";
		$instrucao .= " where login = '$login' and senha = '$senha';";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {

		  // Se conseguiu achar...
		  if ( $broker->retornaNumLinhas() > 0 ) {
			  $flagAchou = true;

			  // seta variaveis de instancia
			  $this->oidUsuario	= $broker->retornaResultado( 0, 0 );
			  $this->oidEmpresa	= $broker->retornaResultado( 0, 1 );
			  $this->nome		= $broker->retornaResultado( 0, 2 );
			  $this->login		= $broker->retornaResultado( 0, 3 );
			  $this->senha		= $broker->retornaResultado( 0, 4 );
			  $this->perfilUsuario	= $broker->retornaResultado( 0, 5 );
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
		return array( $this->oidUsuario, $this->oidEmpresa, $this->nome,
			$this->login, $this->senha, $this->perfilUsuario );

	}

	/**
	*	findByLoginPass( $login, $senha, $oidUsuario, $operacao )
	*	Pesquisa usuario se e possivel gravar usuario com determinado login e senha
	*	@param	$login		login do usuario
	*	@param	$senha		senha
	*	@param	$oidUsuario	OID do usuario
	*	@param	$operacao	se true e inclusao e false para alteracao
	*	@return true se e possivel gravar usuario ou false caso usuario nao possa
	*					ser cadastrado
	*/
	function findByLoginPass( $login, $senha, $oidUsuario, $operacao ) {

		// Seta variaveis utilizadas no metodo
		$flagRetorna = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
		   return false;

		// Se for inclusao, teste simples de login e senha...
		if ( $operacao ) {

			$instrucao  = "select login, senha ";
			$instrucao .= " from usuario_cont ";
			$instrucao .= " where login = '$login' and senha = '$senha';";

			// Executa instrucao SQL...
			if ( $broker->consultaBD( $instrucao ) )

			// Se conseguiu achar...
			if ( $broker->retornaNumLinhas() == 0 )
				$flagRetorna = true;

		}
		// se operacao for de alteracao...
		else {
			$instrucao  = "select codigo, login, senha ";
			$instrucao .= " from usuario_cont ";
			$instrucao .= " where codigo = '$oidUsuario' and login = '$login' and ";
			$instrucao .= " senha = '$senha';";

			// Executa instrucao SQL...
			if ( $broker->consultaBD( $instrucao ) )

			// Se conseguiu achar...
			if ( $broker->retornaNumLinhas() == 1 )
				$flagRetorna = true;

		}

		// fecha conexao...
		$broker->fechaConexao();

		// Retorna flag...
		return $flagRetorna;

	}

	/**
	*	update( $oidUsuario )
	*	Altera objeto persistente
	*	@param	 $oidUsuario	  OID do usuario
	*	@return  $flagGravou   true se foi possivel gravar ou false caso contrario
	*/
	function update( $oidUsuario ) {

		// Seta variaveis utilizadas no metodo
		$this->oidUsuario = $oidUsuario;
		$flagGravou = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
		   return $flagGravou;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "update usuario_cont ";
		$instrucao .= " set nome = '$this->nome', login = '$this->login', ";
		$instrucao .= " senha = '$this->senha', perfilusuario = '$this->perfilUsuario' ";
		$instrucao .= " where codigo = '$this->oidUsuario';";

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
	*	search( $oidEmpresa, $expressao, $operacao )
	*	Pesquisa por critério de selecao
	*	@param	$oidEmpresa	OID da empresa
	*	@param	$expressao	Expressao de busca
	*	@param	$operacao	Operacao a ser realizada
	*/
	function search( $oidEmpresa, $expressao, $operacao = 1 ) {

		// Seta variaveis utilizadas no metodo
		$this->oidEmpresa = $oidEmpresa;
		$this->listObjects[0][0] = "0";

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
		   return false;

		switch( $operacao ) {

			case 1: {

				// Seta variavel de pesquisa...
				$this->expressao = "%".strtoupper( trim( $expressao ) )."%";

				$instrucao  = "select codigo, nome, login ";
				$instrucao .= " from usuario_cont ";
				$instrucao .= " where nome like '$this->expressao' ";
				$instrucao .= " and codigocliente = '$this->oidEmpresa' ";
				$instrucao .= " order by nome, login;";
				
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
	*	delete( $oidUsuario )
	*	Exclui objeto persistente
	*	@param	 $oidUsuario	  OID do usuario
	*	@return  $flagExcluiu	  true se foi possivel gravar ou false caso contrario
	*/
	function delete( $oidUsuario ) {

		// Seta variaveis utilizadas no metodo
		$this->oidUsuario = $oidUsuario;
		$flagExcluiu	  = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
		   return $flagExcluiu;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "delete from usuario_cont ";
		$instrucao .= " where codigo = '$this->oidUsuario';";

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
	*	findByEmpresaLogin( $oidEmpresa, $login )
	*	Pesquisa usuario pelo OID da empresa e login
	*	@param	$oidEmpresa	 OID da empresa
	*	@param	$login		 login do usuario
	*	@return OID do usuario
	*/
	function findByEmpresaLogin( $oidEmpresa, $login ) {

		// Seta variaveis utilizadas no metodo
		$flagAchou = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
		   return $flagAchou;

		$instrucao  = "select codigo, codigocliente, nome, login, senha, ";
		$instrucao .= " perfilusuario ";
		$instrucao .= " from usuario_cont ";
		$instrucao .= " where login = '$login' and codigocliente = '$oidEmpresa';";

		// Executa instrucao SQL...
		if ( $broker->consultaBD( $instrucao ) ) {

		  // Se conseguiu achar...
		  if ( $broker->retornaNumLinhas() > 0 ) {
			  $flagAchou = true;

			  // seta variaveis de instancia
			  $this->oidUsuario		= $broker->retornaResultado( 0, 0 );

		  }
		}

		// fecha conexao...
		$broker->fechaConexao();

		// Retorna OID...
		return $this->oidUsuario;

	}

}

?>
