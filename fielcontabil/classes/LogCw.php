<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 19/09/2003
*	Modulo: LogCw.php
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
*	LogCw
*
*	Classe que contem as principais definicoes de LOG de operacoes
*	registradas no LOG
*
*/
class LogCw extends Log {

	var $oidEmpresa;	// Codigo da empresa
	var $loginUsuario;	// Login do usuario que registrou a operacao
	var $persistence;	// Utilizado para persistencia dos objetos

	/**
	*  LogCw()
	*  Construtor da classe
	*/
	function LogCw() {

		$this->persistence = new LogCwProxy();

	}

	/**
	*	setLogCw( $oidEmpresa, $loginUsuario, $numeroIp, $descricao, $complemento )
	*	Recebe os dados para registro de operacao
	*	@param $oidEmpresa	OID da empresa
	*	@param $loginUsuario	Login do usuario que registrou a operacao
	*	@param $numeroIp	host em que foi realizado a operacao
	*	@param $descricao	descricao da operacao
	*	@param $complemento	complemento
	*/
	function setLogCw( $oidEmpresa, $loginUsuario, $numeroIp,
					$descricao, $complemento ) {

		$this->setRegistro( $numeroIp, $descricao, $complemento );
		$this->setData( date( "Y/m/d" ) );
		$this->setLoginUsuario( $loginUsuario );
		$this->setOidEmpresa( $oidEmpresa );

	}

	/**
	*	grava( $operacao = true )
	*	Grava objeto
	*	@param $operacao		 Operacao a ser realizada (true = inclusao | false = alteracao)
	*	@return se conseguiu gravar
	*/
	function grava( $operacao = true ) {

		// Se for inclusão...
		if ( $operacao ) {
		   $this->persistence->setObject( $this->getOidEmpresa(),
				  $this->getData(), $this->getHora(),
				  $this->getLoginUsuario(), $this->getNumeroIp(),
				  $this->getDescricao(),
				  $this->getComplemento() );

		  return $this->persistence->save();

		}

	}

	/**
	*	limpaLog( $numDias, $oidEmpresa )
	*	Limpa o arquivo de Log
	*	@param $numDias 	      Numero de Dias a manter no LOG
	*	@param $oidEmpresa	      Codigo da empresa
	*	@return se deletou algo
	*/
	function limpaLog( $numDias, $oidEmpresa ) {

		//  Retorna se deletou algo
		//$this->persistence->delete( $numDias, $oidEmpresa );
		// Ver funcoes correspondentes no PgSql
		return true;

	}

	/**
	*	setLoginUsuario( $loginUsuario )
	*	Recebe login de usuario
	*	@param $loginUsuario   login do usuario
	*/
	function setLoginUsuario( $loginUsuario ) {

		$this->loginUsuario = $loginUsuario;

	}

	/**
	*	getLoginUsuario()
	*	Retorna login de usuario
	*	@return $loginUsuario	 login do usuario
	*/
	function getLoginUsuario() {

		return $this->loginUsuario;

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
	*	pesquisaLog( $oidEmpresa, $dataInicial, $dataFinal, $numeroIp, $loginUsuario )
	*	Pesquisa transacoes no LOG
	*	@param	$oidEmpresa   OID da empresa
	*	@param	$dataInicial  data inicial
	*	@param	$dataFinal    data final
	*	@param	$numeroIp     Numero IP (pode ser range)
	*	@param	$loginUsuario Login do usuario
	*	@return $listaLog     Lista de transacoes encontradas
	*/
	function pesquisaLog( $oidEmpresa, $dataInicial, $dataFinal,
			      $numeroIp = 0, $loginUsuario = 0 ) {

		// Seta variaveis que possam ser utilizadas...
		$this->setOidEmpresa( $oidEmpresa );

		// realiza pesquisa...
		$this->persistence->findByLoginNumeroIp( $this->getOidEmpresa(), $dataInicial,
			 $dataFinal, $numeroIp, $loginUsuario );

		// Retorna resultado...
		$listaLog = $this->persistence->getList();
		return ( $listaLog[0][0] != "0" )?$listaLog:false;

	}

	/**
	*	mostraPesquisaLog( $listaLog )
	*	Exibe resultado da pesquisa de logs
	*	@param	$listaLog  lista de logs
	*/
	function mostraPesquisaLog( $listaLog ) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";

		// Seta variaveis auxiliares...
		$voltar 	 = "javascript:history.back();";
		$infoAdicionais  = "";

		// criacao de relatorio...
		$cabecalho = "<br>";

		// Cria relatorio...
		$relatorio = new RelatorioHTMLCw( $this->getOidEmpresa(), $cabecConsLog,
				$cabecalho, "NENHUM", true );

		// Inicia apresentacao da consulta...
		$relatorio->inicioRelatorio();
		$relatorio->mostraString( "<table border=\"0\" width=\"100%\">" );

		// Monta titulos das colunas...
		$relatorio->mostraString( "<tr>" );
		$relatorio->mostraString( "<td align=\"center\" width=\"20%\" class=\"tjanela\">" );
		$relatorio->mostraString( $relatorioDataHora );
		$relatorio->mostraString( "</td>" );
		$relatorio->mostraString( "<td align=\"center\" width=\"20%\" class=\"tjanela\">" );
		$relatorio->mostraString( $relatorioLoginUsuario );
		$relatorio->mostraString( "</td>" );
		$relatorio->mostraString( "<td align=\"left\" width=\"20%\" class=\"tjanela\">" );
		$relatorio->mostraString( $relatorioNumeroIp );
		$relatorio->mostraString( "</td>" );
		$relatorio->mostraString( "<td align=\"left\" width=\"20%\" class=\"tjanela\">" );
		$relatorio->mostraString( $relatorioDescricao );
		$relatorio->mostraString( "</td>" );
		$relatorio->mostraString( "<td align=\"left\" width=\"20%\" class=\"tjanela\">" );
		$relatorio->mostraString( $relatorioComplemento );
		$relatorio->mostraString( "</td>" );
		$relatorio->mostraString( "</tr>" );

		// Comeca laco para apresentacao das transacoes efetuadas...
		for ( $indx = 0; $indx < sizeof( $listaLog ); $indx++ ) {

			// Define cor da linha
			$cor = ($indx % 2)==0?"lcons1":"lcons2";

			$relatorio->mostraString( "<tr>" );

			// Data e Hora
			$relatorio->mostraString( "<td align=\"center\" width=\"20%\" class=\"".$cor."\">" );
			$relatorio->mostraString( $listaLog[$indx][0]." - ".$listaLog[$indx][1] );
			$relatorio->mostraString( "</td>" );

			// Login
			$relatorio->mostraString( "<td align=\"center\" width=\"20%\" class=\"".$cor."\">" );
			$relatorio->mostraString( $listaLog[$indx][2] );
			$relatorio->mostraString( "</td>" );

			// Numero IP
			$relatorio->mostraString( "<td align=\"left\" width=\"20%\" class=\"".$cor."\">" );
			$relatorio->mostraString( $listaLog[$indx][3] );
			$relatorio->mostraString( "</td>" );

			// Descricao
			$relatorio->mostraString( "<td align=\"left\" width=\"20%\" class=\"".$cor."\">" );
			$relatorio->mostraString( $listaLog[$indx][4] );
			$relatorio->mostraString( "</td>" );

			// Complemento
			$relatorio->mostraString( "<td align=\"left\" width=\"20%\" class=\"".$cor."\">" );
			$relatorio->mostraString( $listaLog[$indx][5] );
			$relatorio->mostraString( "</td>" );

			$relatorio->mostraString( "</tr>" );

			}

			// Finaliza relatorio...
		$relatorio->mostraString( "</table>" );
		$relatorio->fimRelatorio( "", $infoAdicionais, $voltar );

	}

}

?>
