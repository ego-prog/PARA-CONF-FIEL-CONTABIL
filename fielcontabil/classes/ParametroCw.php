<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 19/09/2003
*	Modulo: ParametroCw.php
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
*	ParametroCw
*
*	Classe que contem as principais definicoes de parâmetros
*	utilizados no Contábil
*
*/
class ParametroCw extends Parametro {

	var $oidEmpresa;	     // Codigo da empresa
	var $persistence;	     // Utilizado para persistencia dos objetos

	/**
	*  ParametroCw()
	*  Construtor da classe
	*/
	function ParametroCw() {

		$this->persistence = new ParametroCwProxy();

	}

	/**
	*	setParametroCw( $empresa, $linha1, $linha2, $linha3,
	*			 $maximoDiasLog )
	*	Recebe os dados para manipulacao
	*	@param $empresa 	       nome da empresa
	*	@param $linha1		       linha 1 de relatorio
	*	@param $linha2		       linha 2 de relatorio
	*	@param $linha3		       linha 3 de relatorio
	*	@param $maximoDiasLog	       Maximo de dias para manutencao no LOG
	*/
	function setParametroCw( $empresa, $linha1, $linha2, $linha3,
					 $maximoDiasLog ) {

		$this->setParametro( $empresa, $linha1, $linha2, $linha3, $maximoDiasLog );

	}

	/**
	*	grava( $operacao = true )
	*	Grava objeto
	*	@param $operacao	Operacao a ser realizada (true = inclusao | false = alteracao)
	*	@return se conseguiu gravar
	*/
	function grava( $operacao = true ) {

		// Se for inclusão...
		// No caso de parametros, é só inclusao...
		if ( $operacao ) {
		   $this->persistence->setObject( $this->getEmpresa(), $this->getLinha1(),
				    $this->getLinha2(), $this->getLinha3(),
				    $this->getMaximoDiasLog() );

		  return $this->persistence->update( $this->getOidEmpresa() );

		}

	}

	/**
	*	setOidEmpresa( $oidEmpresa )
	*	Recebe OID de empresa
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
	*	pesquisaEmpresa( $oidEmpresa )
	*	Pesquisa empresa por OID especificado
	*	@param $oidEmpresa    codigo da empresa
	*/
	function pesquisaEmpresa( $oidEmpresa ) {

		$flagAchou = false;

		if ( $this->persistence->findByOid( $oidEmpresa ) ) {
		   $flagAchou = true;

		   // Retorna objeto
		   $objetoAtual = $this->persistence->getObject();

		   // Seta atributos
		   $this->setOidEmpresa( $objetoAtual[0] );
		   $this->setEmpresa( $objetoAtual[1] );
		   $this->setLinha1( $objetoAtual[2] );
		   $this->setLinha2( $objetoAtual[3] );
		   $this->setLinha3( $objetoAtual[4] );
		   $this->setMaximoDiasLog( $objetoAtual[5] );
		   $this->setLogotipo( $objetoAtual[6] );

		}

		//return $flagAchou;
		return true;

	}

}

?>
