<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 17/10/2003
*	Modulo: Termo.php
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
*	Termo
*
*	Classe que contem as principais definicoes de termos de abertura e encerramento
*	da contabilidade no Contabil Web
*
*/
class Termo {

	var $oidTermo;		  // OID do termo de abertura
	var $oidEmpresaCont;	  // Codigo da empresa (proprietaria)
	var $descricao; 	  // Descricao
	var $texto;		  // Texto
	var $localizacao;	  // localizacao I = Inicio F = fim
	var $persistence;	  // Utilizado para persistencia dos objetos

	/**
	*  Termo()
	*  Construtor da classe
	*/
	function Termo() {

		$this->persistence = new TermoProxy();

	}

	/**
	*	setTermo( $oidEmpresaCont, $descricao, $texto, $localizacao )
	*	Recebe os dados para manipulacao
	*	@param $oidEmpresaCont		   OID da empresa
	*	@param $descricao	       Descricao
	*	@param $texto		       Texto do termo
	*	@param $localizacao	       Localizacao
	*/
	function setTermo( $oidEmpresaCont, $descricao, $texto, $localizacao ) {

		$this->setOidEmpresaCont( $oidEmpresaCont );
		$this->setDescricao( $descricao );
		$this->setTexto( $texto );
		$this->setLocalizacao( $localizacao );

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
	*	setOidTermo( $oidTermo )
	*	Recebe OID de termo
	*	@param $oidTermo   OID do termo
	*/
	function setOidTermo( $oidTermo ) {

		$this->oidTermo = $oidTermo;

	}

	/**
	*	getOidTermo()
	*	Retorna OID de termo
	*	@return $oidTermo    OID do termo
	*/
	function getOidTermo() {

		return $this->oidTermo;

	}

	/**
	*	setDescricao( $descricao )
	*	Recebe descricao
	*	@param $descricao	 descricao
	*/
	function setDescricao( $descricao ) {

		$this->descricao = trim( String::upper( $descricao ) );

	}

	/**
	*	getDescricao()
	*	Retorna descricao
	*	@return $descricao	 descricao
	*/
	function getDescricao() {

		return $this->descricao;

	}

	/**
	*	setTexto( $texto )
	*	Recebe texto
	*	@param $texto	 texto
	*/
	function setTexto( $texto ) {

		$this->texto = trim( $texto );

	}

	/**
	*	getTexto()
	*	Retorna texto
	*	@return $texto	     texto
	*/
	function getTexto() {

		return $this->texto;

	}

	/**
	*	setLocalizacao( $localizacao )
	*	Recebe localizacao
	*	@param $localizacao	   localizacao
	*/
	function setLocalizacao( $localizacao ) {

		$this->localizacao = trim( String::upper( $localizacao ) );

	}

	/**
	*	getLocalizacao()
	*	Retorna localizacao
	*	@return $localizacao	   localizacao
	*/
	function getLocalizacao() {

		return $this->localizacao;

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
		$this->persistence->setObject( $this->getOidEmpresaCont(), $this->getDescricao(),
				$this->getTexto(), $this->getLocalizacao() );

		// Se for inclusão...
		if ( $operacao )
			$flagGravou = $this->persistence->save();
		// se for alteracao...
		else
			$flagGravou = $this->persistence->update( $this->getOidTermo() );

		return $flagGravou;

	}

	/**
	*	pesquisaTermo( $oidTermo, $oidEmpresaCont )
	*	Retorna termo encontrado
	*	@return true se encontrou termo por OID
	*/
	function pesquisaTermo( $oidTermo, $oidEmpresaCont = 0 ) {

		// Seta variaveis utilizada no metodo
		$flagAchou = false;

		if ( $this->persistence->findByOid( $oidTermo, $oidEmpresaCont ) ) {
		   $flagAchou = true;

		   // Retorna objeto
		   $objetoAtual = $this->persistence->getObject();

		   // Seta atributos
		   $this->setOidTermo( $objetoAtual[0] );
		   $this->setOidEmpresaCont( $objetoAtual[1] );
		   $this->setDescricao( $objetoAtual[2] );
		   $this->setTexto( $objetoAtual[3] );
		   $this->setLocalizacao( $objetoAtual[4] );

		}

		// Retorna se encontrou termo...
		return $flagAchou;

	}

	/**
	*	buscaTermo( $oidEmpresaCont, $expressao )
	*	Retorna todos os termos
	*	@param	$oidEmpresaCont 	OID da empresa
	*	@param	$expressao		    Expressao de busca
	*	@return $termos 		    termos encontrados
	*/
	function buscaTermo( $oidEmpresaCont, $expressao ) {

		// Pesquisa termos por criterio de selecao...
		$this->persistence->search( $oidEmpresaCont, $expressao );

		// retorna termos encontrados...
		return $this->persistence->getList();

	}

	/**
	*	exclui()
	*	Exclui termo
	*/
	function exclui() {

		// Exclui termo...
		return $this->persistence->delete( $this->getOidTermo() );

	}

}

?>
