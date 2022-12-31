<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 12/04/2005
*	Ultima Atualizacao: 12/04/2005
*	Modulo: UsuarioEmpresa.php
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
*	UsuarioEmpresa
*
*	Classe que contem as principais definicoes do vinculo entre
*	Usuarios do sistema e empresas cadastradas
*
*/
class UsuarioEmpresa {

	var $oidEmpresaCont;	// Codigo da empresa (proprietaria)
	var $oidUsuario;	// OID do usuario
	var $oidEmpresa;	// OID da empresa

	/**
	*  UsuarioEmpresa()
	*  Construtor da classe
	*/
	function UsuarioEmpresa() {

		$this->persistence = new UsuarioEmpresaProxy();

	}

	/**
	*	setUsuarioEmpresa( $oidEmpresaCont, $oidUsuario, $oidEmpresa )
	*	Recebe os dados para manipulacao
	*	@param $oidEmpresaCont	   OID da empresa (proprietária)
	*	@param $oidUsuario	   OID do usuário
	*	@param $oidEmpresa	   OID da empresa
	*/
	function setUsuarioEmpresa( $oidEmpresaCont, $oidUsuario, $oidEmpresa ) {

		$this->setOidEmpresaCont( $oidEmpresaCont );
		$this->setOidUsuario( $oidUsuario );
		$this->setOidEmpresa( $oidEmpresa );

	}

	/**
	*	setOidEmpresaCont( $oidEmpresaCont )
	*	Recebe OID de empresa
	*	@param $oidEmpresaCont	 OID da empresa
	*/
	function setOidEmpresaCont( $oidEmpresaCont ) {

		$this->oidEmpresaCont = $oidEmpresaCont;

	}

	/**
	*	getOidEmpresaCont()
	*	Retorna OID de empresa
	*	@return $oidEmpresaCont    OID da empresa
	*/
	function getOidEmpresaCont() {

		return $this->oidEmpresaCont;

	}

	/**
	*	setOidUsuarioEmpresa( $oidUsuarioEmpresa )
	*	Recebe OID de Vínculo entre usuario e empresa
	*	@param $oidUsuarioEmpresa   OID do vínculo usuario x empresa
	*/
	function setOidUsuarioEmpresa( $oidUsuarioEmpresa ) {

		$this->oidUsuarioEmpresa = $oidUsuarioEmpresa;

	}

	/**
	*	getOidUsuarioEmpresa()
	*	Retorna OID de vínculo usuário x empresa
	*	@return $oidUsuarioEmpresa    OID do vínculo usuário x empresa
	*/
	function getOidUsuarioEmpresa() {

		return $this->oidUsuarioEmpresa;

	}

	/**
	*	setOidUsuario( $oidUsuario )
	*	Recebe OID do Usuário
	*	@param $oidUsuario	 OID do Usuário
	*/
	function setOidUsuario( $oidUsuario ) {

		$this->oidUsuario = $oidUsuario;

	}

	/**
	*	getOidUsuario()
	*	Retorna OID do Usuario
	*	@return $oidUsuario	OID do Usuário
	*/
	function getOidUsuario() {

		return $this->oidUsuario;

	}

	/**
	*	setOidEmpresa( $oidEmpresa )
	*	Recebe OID da Empresa
	*	@param $oidEmpresa	OID da Empresa
	*/
	function setOidEmpresa( $oidEmpresa ) {

		$this->oidEmpresa = $oidEmpresa;

	}

	/**
	*	getOidEmpresa()
	*	Retorna OID da Empresa
	*	@return $oidEmpresa	OID da Empresa
	*/
	function getOidEmpresa() {

		return $this->oidEmpresa;

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
		$this->persistence->setObject( $this->getOidUsuario(), $this->getOidEmpresa() );

		// Se for inclusão...
		if ( $operacao )
			$flagGravou = $this->persistence->save();
		// se for alteracao...
		else
			$flagGravou = $this->persistence->update( $this->getOidUsuarioEmpresa() );

		return $flagGravou;

	}

	/**
	*	pesquisaUsuarioEmpresa( $oidUsuarioEmpresa, $oidEmpresaCont )
	*	Retorna Vínculo de Usuário x Empresa encontrado
	*	@return true se encontrou Vínculo de Usuario a Empresa por OID
	*/
	function pesquisaUsuarioEmpresa( $oidUsuarioEmpresa, $oidEmpresaCont = 0 ) {

		// Seta variaveis utilizada no metodo
		$flagAchou = false;

		if ( $this->persistence->findByOid( $oidUsuarioEmpresa, $oidEmpresaCont ) ) {
		   $flagAchou = true;

		   // Retorna objeto
		   $objetoAtual = $this->persistence->getObject();

		   // Seta atributos
		   $this->setOidUsuarioEmpresa( $objetoAtual[0] );
		   $this->setOidEmpresaCont( $objetoAtual[1] );
		   $this->setOidUsuario( $objetoAtual[2] );
		   $this->setOidEmpresa( $objetoAtual[3] );

		}

		// Retorna se encontrou historico...
		return $flagAchou;

	}

	/**
	*	buscaUsuarioEmpresa( $expressao )
	*	Retorna todos os Vínculos de Usuário x Empresa
	*	@param	$expressao		Expressao de busca
	*	@return $lista			Vínculos encontrados
	*/
	function buscaUsuarioEmpresa( $expressao, $operacao = 1 ) {

		// Pesquisa notas por criterio de selecao...
		$this->persistence->search( $expressao, $operacao );

		// retorna notas encontradas...
		return $this->persistence->getList();

	}

	/**
	*	exclui()
	*	Exclui vínculo de Usuário a Empresa
	*/
	function exclui() {

		// Exclui ...
		return $this->persistence->delete( $this->getOidUsuarioEmpresa() );

	}

}

?>
