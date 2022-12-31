<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 29/10/2003
*	Modulo: Nota.php
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
*	Nota
*
*	Classe que contem as principais definicoes de notas explicativas
*	da contabilidade no Contabil Web
*
*/
class Nota {

	var $oidNota;		  // OID da nota explicativa
	var $oidEmpresaCont;  // Codigo da empresa (proprietaria)
	var $nota; 	          // Descricao da nota explicativa
	var $persistence;	  // Utilizado para persistencia dos objetos

	/**
	*  Nota()
	*  Construtor da classe
	*/
	function Nota() {

		$this->persistence = new NotaProxy();

	}

	/**
	*	setNotaExplicativa( $oidEmpresaCont, $nota )
	*	Recebe os dados para manipulacao
	*	@param $oidEmpresaCont	   OID da empresa
	*	@param $nota    	       Nota
	*/
	function setNotaExplicativa( $oidEmpresaCont, $nota ) {

		$this->setOidEmpresaCont( $oidEmpresaCont );
		$this->setNota( $nota );

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
	*	setOidNota( $oidNota )
	*	Recebe OID de nota
	*	@param $oidNota   OID da nota
	*/
	function setOidNota( $oidNota ) {

		$this->oidNota = $oidNota;

	}

	/**
	*	getOidNota()
	*	Retorna OID de nota
	*	@return $oidNota    OID da nota
	*/
	function getOidNota() {

		return $this->oidNota;

	}

	/**
	*	setNota( $nota )
	*	Recebe nota explicativa
	*	@param $nota	 nota explicativa
	*/
	function setNota( $nota ) {

		$this->nota = trim( $nota );

	}

	/**
	*	getNota()
	*	Retorna nota
	*	@return $nota	nota
	*/
	function getNota() {

		return $this->nota;

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
		$this->persistence->setObject( $this->getOidEmpresaCont(), $this->getNota() );

		// Se for inclusão...
		if ( $operacao )
			$flagGravou = $this->persistence->save();
		// se for alteracao...
		else
			$flagGravou = $this->persistence->update( $this->getOidNota() );

		return $flagGravou;

	}

	/**
	*	pesquisaNota( $oidNota, $oidEmpresaCont )
	*	Retorna nota encontrado
	*	@return true se encontrou nota por OID
	*/
	function pesquisaNota( $oidNota, $oidEmpresaCont = 0 ) {

		// Seta variaveis utilizada no metodo
		$flagAchou = false;

		if ( $this->persistence->findByOid( $oidNota, $oidEmpresaCont ) ) {
		   $flagAchou = true;

		   // Retorna objeto
		   $objetoAtual = $this->persistence->getObject();

		   // Seta atributos
		   $this->setOidNota( $objetoAtual[0] );
		   $this->setOidEmpresaCont( $objetoAtual[1] );
		   $this->setNota( $objetoAtual[2] );

		}

		// Retorna se encontrou nota...
		return $flagAchou;

	}

	/**
	*	buscaNota( $oidEmpresaCont, $expressao )
	*	Retorna todos as notas
	*	@param	$oidEmpresaCont OID da empresa
	*	@param	$expressao		Expressao de busca
	*	@return $notas		    notas encontradas
	*/
	function buscaNota( $oidEmpresaCont, $expressao ) {

		// Pesquisa notas por criterio de selecao...
		$this->persistence->search( $oidEmpresaCont, $expressao );

		// retorna notas encontradas...
		return $this->persistence->getList();

	}

	/**
	*	exclui()
	*	Exclui nota
	*/
	function exclui() {

		// Exclui nota...
		return $this->persistence->delete( $this->getOidNota() );

	}

}

?>
