<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 19/09/2003
*	Modulo: ConsultaCw.php
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
*	ConsultaCw
*
*	Classe que contem as principais operacoes de consultas (Editor)
*	registradas no Contábil
*
*/
class ConsultaCw extends Consulta {

	var $oidEmpresa;	   // Codigo da Empresa
	var $perfilUsuario;	   // Perfil do usuario
	var $persistence;	   // Utilizado para persistencia dos objetos

	/**
	*  ConsultaCw()
	*  Construtor da classe
	*/
	function ConsultaCw() {

		$this->persistence = new ConsultaCwProxy();

	}

	/**
	*	setConsultaCw( $oidEmpresa, $perfilUsuario, $titulo,
	*		       $modulo, $instrucaoSql )
	*	Recebe os dados para registro de Consulta
	*	@param $oidEmpresa	       OID da empresa
	*	@param $perfilUsuario	       Perfil do usuario que possuira a consulta
	*	@param $titulo		       Titulo da consulta
	*	@param $modulo		       Modulo PHP
	*	@param $instrucaoSql	       Instrucao SQL
	*/
	function setConsultaCw( $oidEmpresa, $perfilUsuario, $titulo,
					      $modulo, $instrucaoSql ) {

		$this->setConsulta( $titulo, $modulo, $instrucaoSql );
		$this->setPerfilUsuario( $perfilUsuario );
		$this->setOidEmpresa( $oidEmpresa );

	}

	/**
	*	grava( $operacao = true )
	*	Grava objeto
	*	@param $operacao	  Operacao a ser realizada (true = inclusao | false = alteracao)
	*	@return se conseguiu gravar
	*/
	function grava( $operacao = true ) {

		// Se for inclusão...
		if ( $operacao ) {
		   $this->persistence->setObject( $this->getOidEmpresa(), $this->getPerfilUsuario(),
				      $this->getTitulo(), $this->getModulo(),
				      $this->getInstrucaoSql() );

		  return $this->persistence->save();

		}

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
	*	setOidEmpresa( $oidEmpresa )
	*	Recebe OID de empresa
	*	@param $oidEmpresa   codigo da empresa
	*/
	function setOidEmpresa( $oidEmpresa ) {

		$this->oidEmpresa = $oidEmpresa;

	}

	/**
	*	getOidEmpresa()
	*	Retorna OID de Empresa
	*	@return $oidEmpresa    codigo da empresa
	*/
	function getOidEmpresa() {

		return $this->oidEmpresa;

	}

	/**
	*	buscaConsulta( $oidEmpresa, $perfilUsuario )
	*	Retorna todas as consultas encontradas para empresa e Perfil de Usuario
	*	@param	$oidEmpresa	OID da empresa
	*	@param	$perfilUsuario	Perfil do usuario
	*	@return $consultas	consultas encontradas
	*/
	function buscaConsulta( $oidEmpresa, $perfilUsuario ) {

		// Pesquisa consultas por criterio de selecao...
		$this->persistence->search( $oidEmpresa, $perfilUsuario );

		// retorna consultas encontradas...
		return $this->persistence->getList();

	}

	/**
	*	executaConsulta( $oidConsulta, $estilo )
	*	Executa consulta na lista de objetos
	*	@param $oidConsulta    OID da consulta
	*	@param $estilo         Estilo CSS (diretorio . ou ..)
	*/
	function executaConsulta( $oidConsulta, $estilo = 0 ) {

		// Seta variaveis utilizada no metodo
		$flagAchou = false;

		if ( $this->persistence->findByOid( $oidConsulta ) ) {
		   $flagAchou = true;

		   // Retorna objeto
		   $objetoAtual = $this->persistence->getObject();

		   // Seta atributos
		   $this->setTitulo( $objetoAtual[1] );
		   $this->setModulo( $objetoAtual[2] );
		   $this->setInstrucaoSql( $objetoAtual[3] );

		}

		// Se não for vazio a instrucao SQL...
		if ( strlen( $this->getInstrucaoSql() ) > 0 ) {
			// Classe de Cabeçalho
			echo "<html>\n<head>\n<title>\n::FIEL Contábil::\n</title>\n";
			echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"./estilo/cw.css\">\n";
			echo "</head>\n<body class=\"pagina\">\n";
			$this->mostraConsulta( $this->getTitulo(), $this->getInstrucaoSql(), true, $estilo );
			echo "</body>\n</html>\n";
		}

		// Executa modulo PHP
		else {
			$cabec = new TituloCw( $this->getTitulo() );
			$cabec->mostra();
			$this->mostraModulo( $this->getModulo() ); }

	}

	/**
	*	mostraConsulta( $titulo, $instrucaoSql, $mostra, $estilo )
	*	Mostra uma consulta baseada em uma Query
	*	@param $titulo			titulo da consulta
	*	@param $instrucaoSql	OID da consulta
	*	@param $mostra			Mostra mensagem de finalizacao
	*	@param $estilo          Diretorio do estilo
	*/
	function mostraConsulta( $titulo, $instrucaoSql, $mostra, $estilo = 0 ) {

	   // Executa consulta
	   $retorna = true;
	   if ( !$this->persistence->execute( $instrucaoSql ) ) {
		  $retorna = false; }
	
	   else { 
		   // Seta parametros...
		   $linhas  = $this->persistence->getRows();
		   $colunas = $this->persistence->getCols();

		   // Montagem...
		   echo "<html>\n<head>\n<title>\n::FIEL Contábil::</title>\n";
		   if ( $estilo == 0 )
		   		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"../estilo/cw.css\">\n";
		   else
		   		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"./estilo/cw.css\">\n";
		   echo "</head>\n<body class=\"pagina\">\n";
		   echo "<br><br>\n";
		   echo "<div align=\"center\">\n";
		   echo "<p align=\"center\" class=\"tcons\">".$titulo."</p>\n";
		   echo "<table width=\"100%\" border=\"0\">\n";
		   echo "<tr>\n";

		   for ( $indx = 0; $indx < sizeof( $colunas ); $indx++ ) {
			   echo "<td class=\"tjanela\" valign=\"top\" align=\"center\">\n";
			   echo $colunas[ $indx ];
				echo "</td>\n"; }

				echo "</tr>\n";
				echo "<tr>\n";

				for ( $indx = 0; $indx < sizeof( $linhas ); $indx++ ) {
					for ( $indy = 0; $indy < sizeof( $colunas ); $indy++ ) {

						$cor = ($indx % 2)==0?"lcons1":"lcons2";
						echo "<td class=".$cor." valign=\"top\">\n";

						if ( strlen( trim( $linhas[$indx][$indy] ) ) == 0 )
							echo "-";
						else
							echo $linhas[$indx][$indy];
						echo "</td>\n"; }

						echo "</tr>\n"; }

						echo "</table>\n";
						echo "</div>\n";

						if ( $mostra ) {
							echo "<center>\n";
							echo "<form name=\"final\" action=\"executa.cgi\" method=\"post\">\n";
							echo "<input type=\"button\" name=\"imprimir\" class=\"bjanela\" value=\" Imprimir \" onClick=\"javascript:window.print();\">\n&nbsp;";		  
							echo "<input type=\"button\" name=\"voltar\" class=\"bjanela\" value=\" Voltar \" onClick=\"javascript:history.back();\">\n";
							echo "</form></center>\n"; }
						else {
							echo "<center>\n";
							echo "<form name=\"final\" action=\"teste\" method=\"post\">\n";
							echo "<input type=\"button\" name=\"imprimir\" class=\"bjanela\" value=\" Imprimir \" onClick=\"javascript:window.print();\">\n&nbsp;";		  
							echo "<input type=\"button\" name=\"voltar\" class=\"bjanela\" value=\" Fechar \" onClick=\"javascript:window.self.close();\">\n";
						echo "</form></center>\n"; }

						echo "</body></html>\n";

	   			}
				
			return $retorna;
		}

}

?>
