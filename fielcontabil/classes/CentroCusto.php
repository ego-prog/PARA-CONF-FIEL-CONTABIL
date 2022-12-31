<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 09/11/2003
*	Modulo: CentroCusto.php
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
*	CentroCusto
*
*	Classe que contem as principais definicoes de centros de custo
*	da contabilidade no FIEL Contabil
*
*/
class CentroCusto {

	var $oidCentroCusto;	// OID do centro de custo
	var $oidEmpresaCont;	// Codigo da empresa (proprietaria)
	var $sigla;		// Sigla do Centro de Custo
	var $descricao; 	// Descricao do Centro de Custo
	var $persistence;	// Utilizado para persistencia dos objetos

	/**
	*  CentroCusto()
	*  Construtor da classe
	*/
	function CentroCusto() {

		$this->persistence = new CentroCustoProxy();

	}

	/**
	*	setCentroCusto( $oidEmpresaCont, $sigla, $descricao )
	*	Recebe os dados para manipulacao
	*	@param $oidEmpresaCont	   OID da empresa
	*	@param $sigla		   Sigla do Centro de Custo
	*	@param $descricao	   Descricao do Centro de Custo
	*/
	function setCentroCusto( $oidEmpresaCont, $sigla, $descricao ) {

		$this->setOidEmpresaCont( $oidEmpresaCont );
		$this->setSigla( $sigla );
		$this->setDescricao( $descricao );

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
	*	setOidCentroCusto( $oidCentroCusto )
	*	Recebe OID de Centro de Custo
	*	@param $oidCentroCusto	 OID do centro de custo
	*/
	function setOidCentroCusto( $oidCentroCusto ) {

		$this->oidCentroCusto = $oidCentroCusto;

	}

	/**
	*	getOidCentroCusto()
	*	Retorna OID de centro de custo
	*	@return $oidCentroCusto    OID do centro de custo
	*/
	function getOidCentroCusto() {

		return $this->oidCentroCusto;

	}

	/**
	*	setSigla( $sigla )
	*	Recebe sigla do Centro de Custo
	*	@param $sigla	    Sigla do Centro de Custo
	*/
	function setSigla( $sigla ) {

		$this->sigla = trim( String::upper( $sigla ) );

	}

	/**
	*	getSigla()
	*	Retorna Sigla de Centro de Custo
	*	@return $sigla	   Sigla do Centro de Custo
	*/
	function getSigla() {

		return $this->sigla;

	}

	/**
	*	setDescricao( $descricao )
	*	Recebe descricao do Centro de Custo
	*	@param $descricao      Descricao do Centro de Custo
	*/
	function setDescricao( $descricao ) {

		$this->descricao = trim( String::upper( $descricao ) );

	}

	/**
	*	getDescricao()
	*	Retorna Descricao de Centro de Custo
	*	@return $descricao     Descricao do Centro de Custo
	*/
	function getDescricao() {

		return $this->descricao;

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
		$this->persistence->setObject( $this->getOidEmpresaCont(), $this->getSigla(), $this->getDescricao() );

		// Se for inclusão...
		if ( $operacao )
			$flagGravou = $this->persistence->save();
		// se for alteracao...
		else
			$flagGravou = $this->persistence->update( $this->getOidCentroCusto() );

		return $flagGravou;

	}

	/**
	*	pesquisaCentroCusto( $oidCentroCusto, $oidEmpresaCont )
	*	Retorna Centro de Custo encontrado
	*	@return true se encontrou Centro de Custo por OID
	*/
	function pesquisaCentroCusto( $oidCentroCusto, $oidEmpresaCont = 0 ) {

		// Seta variaveis utilizada no metodo
		$flagAchou = false;

		if ( $this->persistence->findByOid( $oidCentroCusto, $oidEmpresaCont ) ) {
		   $flagAchou = true;

		   // Retorna objeto
		   $objetoAtual = $this->persistence->getObject();

		   // Seta atributos
		   $this->setOidCentroCusto( $objetoAtual[0] );
		   $this->setOidEmpresaCont( $objetoAtual[1] );
		   $this->setSigla( $objetoAtual[2] );
		   $this->setDescricao( $objetoAtual[3] );

		}

		// Retorna se encontrou historico...
		return $flagAchou;

	}

	/**
	*	buscaCentroCusto( $oidEmpresaCont, $expressao )
	*	Retorna todos os centros de custo
	*	@param	$oidEmpresaCont OID da empresa
	*	@param	$expressao		Expressao de busca
	*	@return $lista			Centros de Custo encontrados
	*/
	function buscaCentroCusto( $oidEmpresaCont, $expressao, $operacao = 1 ) {

		// Pesquisa notas por criterio de selecao...
		$this->persistence->search( $oidEmpresaCont, $expressao, $operacao );

		// retorna notas encontradas...
		return $this->persistence->getList();

	}

	/**
	*	exclui()
	*	Exclui centro de custo
	*/
	function exclui() {

		// Exclui ...
		return $this->persistence->delete( $this->getOidCentroCusto() );

	}

}

?>
