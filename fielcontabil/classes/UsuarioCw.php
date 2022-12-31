<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 19/09/2003
*	Modulo: UsuarioCw.php
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
*	UsuarioCw
*
*	Classe que contem as principais definicoes de usuarios
*	utilizados no Contábil
*
*/
class UsuarioCw extends Usuario {

	var $oidEmpresa;	   // Codigo da Prefeitura
	var $perfilUsuario;	   // Perfil de usuario
	var $oidUsuario;	   // Codigo do usuario
	var $persistence;	   // Utilizado para persistencia dos objetos

	/**
	*  UsuarioCw()
	*  Construtor da classe
	*/
	function UsuarioCw() {

		$this->persistence = new UsuarioCwProxy();

	}

	/**
	*	setUsuarioCw( $oidEmpresa, $nome, $login, $senha, $perfilUsuario, $numeroIp )
	*	Recebe os dados para manipulacao
	*	@param $oidEmpresa	      OID da empresa
	*	@param $nome		      nome do usuario
	*	@param $login		      login do usuario
	*	@param $senha		      senha
	*	@param $perfilUsuario	      perfil do usuario
	*	@param $numeroIp	      numero IP
	*/
	function setUsuarioCw( $oidEmpresa, $nome, $login, $senha, $perfilUsuario,
					 $numeroIp ) {

		$this->setUsuario( $nome, $login, $senha, $numeroIp );
		$this->setOidEmpresa( $oidEmpresa );
		$this->setPerfilUsuario( $perfilUsuario );

	}

	/**
	*	setAtualizaSenhaUsuario( $oidUsuario, $login, $senha )
	*	Recebe os dados para manipulacao
	*	@param $oidUsuario		 OID do usuario
	*	@param $login			 login do usuario
	*	@param $senha			 senha
	*/
	function setAtualizaSenhaUsuario( $oidUsuario, $login, $senha ) {

		$this->setOidUsuario( $oidUsuario );
		$this->setLogin( $login );
		$this->setSenha( $senha );

	}

	/**
	*	grava( $operacao = true )
	*	Grava objeto
	*	@param $operacao	Operacao a ser realizada (true = inclusao | false = alteracao)
	*	@return se conseguiu gravar
	*/
	function grava( $operacao = true ) {

		// Seta variaveis utilizada no metodo...
		$flagGravou = false;

		// Seta dados...
	    $this->persistence->setObject( $this->getOidEmpresa(), $this->getNome(),
		      $this->getLogin(), $this->getSenha(), $this->getPerfilUsuario(),
			  $this->getNumeroIp() );

		// Se for inclusão...
		if ( $operacao )
			$flagGravou = $this->persistence->save();
		// se for alteracao...
		else
			$flagGravou = $this->persistence->update( $this->getOidUsuario() );

		return $flagGravou;

	}

	/**
	*	atualizaSenha()
	*	Grava objeto
	*	@return se conseguiu gravar
	*/
	function atualizaSenha() {

		// Seta variaveis utilizada no metodo...
		$flagGravou = false;

		// Seta dados...
	    $this->persistence->setUserPass( $this->getOidEmpresa(), $this->getOidUsuario(),
		      $this->getLogin(), $this->getSenha() );

		$flagGravou = $this->persistence->updatePass();

		return $flagGravou;

	}

	/**
	*	setOidEmpresa( $oidEmpresa )
	*	Recebe OID de Empresa
	*	@param $oidEmpresa   codigo da empresa
	*/
	function setOidEmpresa( $oidEmpresa ) {

		$this->oidEmpresa = $oidEmpresa;

	}

	/**
	*	getOidEmpresa()
	*	Retorna OID de empresa
	*	@return $oidEmpresa    codigo da empresa
	*/
	function getOidEmpresa() {

		return $this->oidEmpresa;

	}

	/**
	*	setOidUsuario( $oidUsuario )
	*	Recebe OID de usuario
	*	@param $oidUsuario	codigo do usuario
	*/
	function setOidUsuario( $oidUsuario ) {

		$this->oidUsuario = $oidUsuario;

	}

	/**
	*	getOidUsuario()
	*	Retorna OID de usuario
	*	@return $oidUsuario	  codigo do usuario
	*/
	function getOidUsuario() {

		return $this->oidUsuario;

	}

	/**
	*	setPerfilUsuario( $perfilUsuario )
	*	Recebe perfil de usuario
	*	@param $perfilUsuario	perfil do usuario
	*/
	function setPerfilUsuario( $perfilUsuario ) {

		$this->perfilUsuario = $perfilUsuario;

	}

	/**
	*	getPerfilUsuario()
	*	Retorna perfil do usuario
	*	@return $perfilUsuario	  perfil do usuario
	*/
	function getPerfilUsuario() {

		return $this->perfilUsuario;

	}

	/**
	*	pesquisaUsuario( $oidUsuario )
	*	Retorna usuario encontrado
	*	@return true se encontrou usuario por OID
	*/
	function pesquisaUsuario( $oidUsuario ) {

		// Seta variaveis utilizada no metodo
		$flagAchou = false;

		if ( $this->persistence->findByOid( $oidUsuario ) ) {
		   $flagAchou = true;

		   // Retorna objeto
		   $objetoAtual = $this->persistence->getObject();

		   // Seta atributos
		   $this->setOidUsuario( $objetoAtual[0] );
		   $this->setOidEmpresa( $objetoAtual[1] );
		   $this->setNome( $objetoAtual[2] );
		   $this->setLogin( $objetoAtual[3] );
		   $this->setSenha( $objetoAtual[4] );
		   $this->setPerfilUsuario( $objetoAtual[5] );

		}

		// Retorna se encontrou usuario...
		return $flagAchou;

	}

	/**
	*	validaAcessoUsuario( $login, $senha )
	*	Retorna se é possivel acessar o sistema
	*	@param	$login	Login do usuario
	*	@param	$senha	Senha do usuario
	*	@return true se encontrou usuario por OID
	*/
	function validaAcessoUsuario( $login, $senha ) {

		// Seta variaveis utilizada no metodo
		$flagAchou = false;

		if ( $this->persistence->findByLogin( $login, $senha ) ) {
		   $flagAchou = true;

		   // Retorna objeto
		   $objetoAtual = $this->persistence->getObject();

		   // Seta atributos
		   $this->setOidUsuario( $objetoAtual[0] );
		   $this->setOidEmpresa( $objetoAtual[1] );
		   $this->setNome( $objetoAtual[2] );
		   $this->setLogin( $objetoAtual[3] );
		   $this->setSenha( $objetoAtual[4] );
		   $this->setPerfilUsuario( $objetoAtual[5] );

		}

		// Retorna se encontrou usuario...
		return $flagAchou;

	}

	/**
	*	validaUsuario( $login, $senha, $oidUsuario, $operacao )
	*	Verifica se é possivel a gravacao de login para usuario
	*	@param	$login		Login do usuario
	*	@param	$senha		Senha do usuario
	*	@param	$oidUsuario	OID do usuario
	*	@param	$operacao	true se e inclusao e false se e alteracao
	*	@return true se encontrou usuario por OID
	*/
	function validaUsuario( $login, $senha, $oidUsuario = 0, $operacao = true ) {

		// retorna se e possivel gravar usuario...
		return $this->persistence->findByLoginPass( $login, $senha,
				$oidUsuario, $operacao );

	}

	/**
	*	buscaUsuario( $oidEmpresa, $expressao )
	*	Retorna todos os usuarios
	*	@param	$oidEmpresa    OID da empresa
	*	@param	$expressao     Expressao de busca
	*	@return $usuarios      usuarios encontrados
	*/
	function buscaUsuario( $oidEmpresa, $expressao ) {

		// Pesquisa usuarios por criterio de selecao...
		$this->persistence->search( $oidEmpresa, $expressao );

		// retorna usuarios encontrados...
		return $this->persistence->getList();

	}

	/**
	*	exclui()
	*	Exclui usuario
	*/
	function exclui() {

		// Exclui usuario...
		return $this->persistence->delete( $this->getOidUsuario() );

	}

	/**
	*	pesquisaInfoAtualizaSenha( $oidEmpresa, $login )
	*	Pesquisa informacoes relativas a atualizacao de senha
	*	@param	$oidEmpresa	OID da empresa
	*	@param	$login		Login do usuario
	*	@return true se encontrou usuario por OID
	*/
	function pesquisaInfoAtualizaSenha( $oidEmpresa, $login ) {

		// Executa uma chamada composta...
		return $this->pesquisaUsuario( $this->persistence->findByEmpresaLogin( $oidEmpresa,
							$login ) );

	}


}

?>
