<?PHP

/**
*
*		FIEL Contábil
*
*		Data de Criacao: 26/05/2003
*		Ultima Atualizacao: 17/11/2003
*		Modulo: Zeramento.php
*
*		Desenvolvido por APOENA Solucoes em Software Livre
*		suporte@apoenasoftwarelivre.com.br
*		http://www.apoenasoftwarelivre.com.br
*
*		@author 		Claudimir Zavalik (claudimir@apoenasoftwarelivre.com.br)
*		@author 		Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*		@version		PHP3 & PHP4
*/

// Arquivo "header" do Contábil
include $pathClasses."cw.inc";

/**
*
*		Zeramento
*
*		Classe que contem as principais definicoes de zeramentos de contas
*		da contabilidade no Contabil Web
*
*/
class Zeramento {

		var $oidZeramento;	  // OID do zeramento
		var $oidEmpresaCont;  // OID da empresa contabil
		var $contrapartida;   // Contrapartida (codigo da conta)
		var $grupo1;		  // Grupo 1
		var $grupo2;		  // Grupo 2
		var $grupo3;		  // Grupo 3
		var $grupo4;		  // Grupo 4
		var $grupo5;		  // Grupo 5
		var $persistence;		  // Utilizado para persistencia dos objetos

		/**
		*  Zeramento()
		*  Construtor da classe
		*/
		function Zeramento() {

				$this->persistence = new ZeramentoProxy();

		}

		/**
		*		setZeramento( $oidEmpresaCont, $contrapartida, $grupo1,
		*						$grupo2, $grupo3, $grupo4, $grupo5 )
		*		Recebe os dados para manipulacao
		*		@param $oidEmpresaCont	   OID da empresa contabil
		*		@param $contrapartida	   Contrapartida
		*		@param $grupo1			   grupo 1
		*		@param $grupo2			   grupo 2
		*		@param $grupo3			   grupo 3
		*		@param $grupo4			   grupo 4
		*		@param $grupo5			   grupo 5
		*/
		function setZeramento( $oidEmpresaCont, $contrapartida, $grupo1,
								$grupo2, $grupo3, $grupo4, $grupo5 ) {

				$this->setOidEmpresaCont( $oidEmpresaCont );
				$this->setContrapartida( $contrapartida );
				$this->setGrupo1( $grupo1 );
				$this->setGrupo2( $grupo2 );
				$this->setGrupo3( $grupo3 );
				$this->setGrupo4( $grupo4 );
				$this->setGrupo5( $grupo5 );			

		}

		/**
		*		setOidZeramento( $oidZeramento )
		*		Recebe OID de zeramento
		*		@param $oidZeramento	OID do Zeramento
		*/
		function setOidZeramento( $oidZeramento ) {

				$this->oidZeramento = $oidZeramento;

		}

		/**
		*		getOidZeramento()
		*		Retorna OID de zeramento
		*		@return $oidZeramento	OID de zeramento
		*/
		function getOidZeramento() {

				return $this->oidZeramento;

		}

		/**
		*		setContrapartida( $contrapartida )
		*		Recebe contrapartida
		*		@param $contrapartida	contrapartida
		*/
		function setContrapartida( $contrapartida ) {

				$this->contrapartida = $contrapartida;

		}

		/**
		*		getContrapartida()
		*		Retorna contrapartida
		*		@return $contrapartida	Contrapartida
		*/
		function getContrapartida() {

				return $this->contrapartida;

		}

		/**
		*		setGrupo1( $grupo1 )
		*		Recebe grupo
		*		@param $grupo1	Grupo
		*/
		function setGrupo1( $grupo1 ) {

				$this->grupo1 = $grupo1;

		}

		/**
		*		getGrupo1()
		*		Retorna grupo
		*		@return $grupo1 Grupo
		*/
		function getGrupo1() {

				return $this->grupo1;

		}

		/**
		*		setGrupo2( $grupo2 )
		*		Recebe grupo
		*		@param $grupo2	Grupo
		*/
		function setGrupo2( $grupo2 ) {

				$this->grupo2 = $grupo2;

		}

		/**
		*		getGrupo2()
		*		Retorna grupo
		*		@return $grupo2 Grupo
		*/
		function getGrupo2() {

				return $this->grupo2;

		}

		/**
		*		setGrupo3( $grupo3 )
		*		Recebe grupo
		*		@param $grupo3	Grupo
		*/
		function setGrupo3( $grupo3 ) {

				$this->grupo3 = $grupo3;

		}

		/**
		*		getGrupo3()
		*		Retorna grupo
		*		@return $grupo3 Grupo
		*/
		function getGrupo3() {

				return $this->grupo3;

		}

		/**
		*		setGrupo4( $grupo4 )
		*		Recebe grupo
		*		@param $grupo4	Grupo
		*/
		function setGrupo4( $grupo4 ) {

				$this->grupo4 = $grupo4;

		}

		/**
		*		getGrupo4()
		*		Retorna grupo
		*		@return $grupo4 Grupo
		*/
		function getGrupo4() {

				return $this->grupo4;

		}

		/**
		*		setGrupo5( $grupo5 )
		*		Recebe grupo
		*		@param $grupo5	Grupo
		*/
		function setGrupo5( $grupo5 ) {

				$this->grupo5 = $grupo5;

		}

		/**
		*		getGrupo5()
		*		Retorna grupo
		*		@return $grupo5 Grupo
		*/
		function getGrupo5() {

				return $this->grupo5;

		}

		/**
		*		setOidEmpresaCont( $oidEmpresaCont )
		*		Recebe OID de empresa contabil
		*		@param $oidEmpresaCont	 OID da empresa contabil
		*/
		function setOidEmpresaCont( $oidEmpresaCont ) {

				$this->oidEmpresaCont = $oidEmpresaCont;

		}

		/**
		*		getOidEmpresaCont()
		*		Retorna OID de empresa contabil
		*		@return $oidEmpresaCont    OID da empresa contabil
		*/
		function getOidEmpresaCont() {

				return $this->oidEmpresaCont;

		}
		
		/**
		*		grava( $operacao = true )
		*		Grava objeto
		*		@param $operacao		Operacao a ser realizada (true = inclusao | false = alteracao)
		*		@return se conseguiu gravar
		*/
		function grava( $operacao = true ) {

				// Seta variaveis utilizada no metodo...
				$flagGravou = false;

				// Seta dados...
				$this->persistence->setObject( $this->getOidEmpresaCont(), 
										$this->getContrapartida(),
										$this->getGrupo1(), $this->getGrupo2(), $this->getGrupo3(),
										$this->getGrupo4(), $this->getGrupo5() );

				// Se for inclusão...
				if ( $operacao ) 
						$flagGravou = $this->persistence->save();

				return $flagGravou;

		}

		/**
		*		pesquisaZeramento( $oidZeramento )
		*		Retorna zeramento encontrado
		*		@return true se encontrou zeramento por OID
		*/
		function pesquisaZeramento( $oidZeramento ) {

				// Seta variaveis utilizada no metodo
				$flagAchou = false;

				if ( $this->persistence->findByOid( $oidZeramento ) ) {
				   $flagAchou = true;

				   // Retorna objeto
				   $objetoAtual = $this->persistence->getObject();

				   // Seta atributos
				   $this->setOidZeramento( $objetoAtual[0] );
				   $this->setOidEmpresaCont( $objetoAtual[1] );
				   $this->setContrapartida( $objetoAtual[2] );
				   $this->setGrupo1( $objetoAtual[3] );
				   $this->setGrupo2( $objetoAtual[4] );
				   $this->setGrupo3( $objetoAtual[5] );
				   $this->setGrupo4( $objetoAtual[6] );
				   $this->setGrupo5( $objetoAtual[7] );

				}

				// Retorna se encontrou zeramento...
				return $flagAchou;

		}

		/**
		*		buscaZeramento( $oidEmpresaCont, $operacao = 1 )
		*		Retorna todos os zeramentos definidos
		*		@param	$oidEmpresaCont OID empresa contabil
		*		@return $zeramentos 			zeramentos encontrados
		*/
		function buscaZeramento( $oidEmpresaCont, $operacao = 1 ) {

				// Pesquisa orcamentos por criterio de selecao...
				$this->persistence->search( $oidEmpresaCont, $operacao );

				// retorna zeramentos encontrados...
				return $this->persistence->getList();

		}

		/**
		*		exclui()
		*		Exclui zeramento
		*/
		function exclui() {

				// Exclui zeramento...
				return $this->persistence->delete( $this->getOidZeramento() );

		}

		/**
		*		pesquisaZeramentoInclusao( $oidEmpresaCont, $contrapartida )
		*		Retorna se pode incluir zeramento
		*		@return true se encontrou zeramento por OID de empresa e contrapartida
		*/
		function pesquisaZeramentoInclusao( $oidEmpresaCont, $contrapartida ) {

				return $this->persistence->findByOidZeramento( $oidEmpresaCont, 
																				$contrapartida );

		}
		
		/**
		*		setaZeramento( $oidEmpresaCont )
		*		Seta zeramento encontrado
		*		@return true se encontrou zeramento por OID
		*/
		function setaZeramento( $oidEmpresaCont ) {

		   // Retorna objeto
		   $this->buscaZeramento( $oidEmpresaCont, 2 );
		   
		   $objetoAtual = $this->persistence->getObject();

		   // Seta atributos
		   $this->setOidZeramento( $objetoAtual[0] );
		   $this->setOidEmpresaCont( $objetoAtual[1] );
		   $this->setContrapartida( $objetoAtual[2] );
		   $this->setGrupo1( $objetoAtual[3] );
		   $this->setGrupo2( $objetoAtual[4] );
		   $this->setGrupo3( $objetoAtual[5] );
		   $this->setGrupo4( $objetoAtual[6] );
		   $this->setGrupo5( $objetoAtual[7] );

		}
		
}

?>
