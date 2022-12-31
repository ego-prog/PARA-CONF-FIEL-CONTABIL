<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 09/11/2003
*	Modulo: HistoricoPadrao.php
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
*	HistoricoPadrao
*
*	Classe que contem as principais definicoes de historicos padroes
*	da contabilidade no Contabil Web
*
*/
class HistoricoPadrao {

	var $oidHistorico;    // OID do historico padrao
	var $oidEmpresaCont;  // Codigo da empresa (proprietaria)
	var $historico;       // texto do historico
	var $persistence;	  // Utilizado para persistencia dos objetos

	/**
	*  HistoricoPadrao()
	*  Construtor da classe
	*/
	function HistoricoPadrao() {

		$this->persistence = new HistoricoPadraoProxy();

	}

	/**
	*	setHistoricoPadrao( $oidEmpresaCont, $historico )
	*	Recebe os dados para manipulacao
	*	@param $oidEmpresaCont	   OID da empresa
	*	@param $historico		   Historico padrao
	*/
	function setHistoricoPadrao( $oidEmpresaCont, $historico ) {

		$this->setOidEmpresaCont( $oidEmpresaCont );
		$this->setHistorico( $historico );

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
	*	setOidHistorico( $oidHistorico )
	*	Recebe OID de historico
	*	@param $oidHistorico   OID do historico
	*/
	function setOidHistorico( $oidHistorico ) {

		$this->oidHistorico = $oidHistorico;

	}

	/**
	*	getOidHistorico()
	*	Retorna OID de historico
	*	@return $oidHistorico    OID do historico
	*/
	function getOidHistorico() {

		return $this->oidHistorico;

	}

	/**
	*	setHistorico( $historico )
	*	Recebe historico
	*	@param $historico	Historico padrao
	*/
	function setHistorico( $historico ) {

		$this->historico = trim( String::upper( $historico ) );

	}

	/**
	*	getHistorico()
	*	Retorna historico
	*	@return $historico	Historico padrao
	*/
	function getHistorico() {

		return $this->historico;

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
		$this->persistence->setObject( $this->getOidEmpresaCont(), $this->getHistorico() );

		// Se for inclusão...
		if ( $operacao )
			$flagGravou = $this->persistence->save();
		// se for alteracao...
		else
			$flagGravou = $this->persistence->update( $this->getOidHistorico() );

		return $flagGravou;

	}

	/**
	*	pesquisaHistoricoPadrao( $oidHistorico, $oidEmpresaCont )
	*	Retorna historico encontrado
	*	@return true se encontrou nota por OID
	*/
	function pesquisaHistoricoPadrao( $oidHistorico, $oidEmpresaCont = 0 ) {

		// Seta variaveis utilizada no metodo
		$flagAchou = false;

		if ( $this->persistence->findByOid( $oidHistorico, $oidEmpresaCont ) ) {
		   $flagAchou = true;

		   // Retorna objeto
		   $objetoAtual = $this->persistence->getObject();

		   // Seta atributos
		   $this->setOidHistorico( $objetoAtual[0] );
		   $this->setOidEmpresaCont( $objetoAtual[1] );
		   $this->setHistorico( $objetoAtual[2] );

		}

		// Retorna se encontrou historico...
		return $flagAchou;

	}

	/**
	*	buscaHistoricoPadrao( $oidEmpresaCont, $expressao )
	*	Retorna todos os historicos padroes
	*	@param	$oidEmpresaCont OID da empresa
	*	@param	$expressao		Expressao de busca
	*	@return $notas		    notas encontradas
	*/
	function buscaHistoricoPadrao( $oidEmpresaCont, $expressao, $operacao = 1 ) {

		// Pesquisa notas por criterio de selecao...
		$this->persistence->search( $oidEmpresaCont, $expressao, $operacao );

		// retorna notas encontradas...
		return $this->persistence->getList();

	}

	/**
	*	exclui()
	*	Exclui historico padrao
	*/
	function exclui() {

		// Exclui ...
		return $this->persistence->delete( $this->getOidHistorico() );

	}

}

?>
