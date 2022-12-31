<?PHP

/**
*
*   Framework de Persistencia
*
*   Data de Criacao: 17/05/2002
*   Ultima Atualizacao: 26/05/2002
*   Modulo: BrokerMySQL.php
*       Framework de mapeamento de objetos
*
*   Copyright (C) por APOENA Solucoes em Software Livre
*   http://www.apoenasoftwarelivre.com.br
*
*   @author     Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*   @version    PHP3 & PHP4
*/

// Arquivo "header" do Framework

include $pathClassesPersistencia."framework_persistencia.inc";

/**
*
*	BrokerMySQL
*
*   Classe que contem as principais definicoes para utilizacao do
*   "broker" MySQL
*
*/
class BrokerMySQL extends BrokerSGBD {

	/**
	* 	BrokerMySQL()
	* 	Construtor da classe
	*/
	function BrokerMySQL() {

		// No construtor e possivel definir algumas definicoes especificas
		// do BD, incluindo maquina, usuario, senha...
		// $this->setParametro( banco, usuario, senha,
		//						"5432", host );

	}

	/**
	* 	abreConexao( $persistente )
	* 	Abre conexao com o BD
	*	@param  $persistente	Realiza conexao persistente
	*	@return BD_OK			Se conseguiu realizar conexao ao BD	ou
	*	@return BD_ERRO			se nao conseguiu realizar a conexao
	*/
	function abreConexao( $persistente = true ) {

		$this->parametroBD  = " host=".$this->getHost()." port=".$this->getPorta();
		$this->parametroBD .= " dbname=".$this->getNomeBanco();
		$this->parametroBD .= " user=".$this->getUsuario()." password=".$this->getSenha();

		// Para conexao persistente...
		if ( $persistente ) {
			if ( !( $this->handler = @mysql_pconnect( $this->getHost(),
											$this->getUsuario(), $this->getSenha() ) ) )
				return BD_ERRO;
			else
				return BD_OK; }

		// senao...

		else {
			if ( !( $this->handler = @mysql_connect( $this->getHost(),
											$this->getUsuario(), $this->getSenha() ) ) )
				return BD_ERRO;
			else
				return BD_OK; }

	}

	/**
	* 	fechaConexao()
	* 	Fecha conexao com o BD
	*	@return mysql_close()		Resultado da mysql_close()
	*/
	function fechaConexao() {

		return @mysql_close( $this->handler );

	}

	/**
	* 	iniciaTransacao()
	* 	Inicia transacao para BD
	*	@return BD_OK			Se conseguiu iniciar a transacao com o BD ou
	*	@return BD_ERRO			se nao conseguiu iniciar a transacao
	*/
	function iniciaTransacao() {

		// MySQL nao possui controle de transacoes

	}

	/**
	* 	finalizaTransacao()
	* 	Finaliza transacao para BD
	*	@return BD_OK			Se conseguiu fnalizar a transacao com o BD ou
	*	@return BD_ERRO			se nao conseguiu finalizar a transacao
	*/
	function finalizaTransacao() {

		// MySQL nao possui controle de transacoes

	}

	/**
	* 	gravaTransacao()
	* 	Grava transacao para BD
	*	@return BD_OK			Se conseguiu gravar a transacao com o BD ou
	*	@return BD_ERRO			se nao conseguiu gravar a transacao
	*/
	function gravaTransacao() {

		// MySQL nao possui controle de transacoes

	}

	/**
	* 	abortaTransacao()
	* 	aborta transacao para BD
	*	@return BD_OK			Se conseguiu abortar a transacao com o BD ou
	*	@return BD_ERRO			se nao conseguiu abortar a transacao
	*/
	function abortaTransacao() {

		// MySQL nao possui controle de transacoes

	}

	/**
	* 	atualizaBD( $instrucaoSql )
	* 	Atualiza dados no BD
	*	@param 	$instrucaoSql	comando de atualizacao
	*	@return BD_OK			Se conseguiu atualizar o BD ou
	*	@return BD_ERRO			se nao conseguiu atualizar o BD
	*/
	function atualizaBD( $instrucaoSql ) {

		$this->setInstrucaoSql( $instrucaoSql );

	    // ver a funcao para tratamento de datas no MySQL
	    // $this->resultado = @pg_exec( $this->handler, "set DATESTYLE='SQL'" );
		$this->resultado = @mysql_db_query( $this->getNomeBanco(),
								$this->getInstrucaoSql(), $this->handler );

		return $this->resultado?BD_OK:BD_ERRO;

	}

	/**
	* 	consultaBD()
	* 	Consulta dados no BD
	*	@param 	$instrucaoSql		comando de atualizacao
	*	@return $resultado      	Se conseguiu consultar o BD ou
	*	@return BD_FALHA_CONSULTA 	se nao conseguiu consultar o BD
	*/
	function consultaBD( $instrucaoSql ) {

		$this->setInstrucaoSql( $instrucaoSql );

	    // ver a funcao para tratamento de datas no MySQL
		// $this->resultado = @pg_exec( $this->handler, "set DATESTYLE='SQL'" );
		$this->resultado = @mysql_db_query( $this->getNomeBanco(),
								$this->getInstrucaoSql(), $this->handler );

		return !$this->resultado?BD_FALHA_CONSULTA:$this->resultado;

	}

	/**
	* 	retornaNumLinhas()
	* 	Retorna o numero de linhas resultantes da consulta
	*	@return mysql_num_rows()	Resultado da mysql_num_rows()
	*/
	function retornaNumLinhas() {

		return @mysql_num_rows( $this->resultado );

	}

	/**
	* 	retornaNumLinhasAfetadas()
	* 	Retorna o numero de linhas afetadas
	*	@return mysql_affected_rows()	Resultado da mysql_affected_rows()
	*/
	function retornaNumLinhasAfetadas() {

		// na API do MySQL diz que ? $this->handler, por?m deve-se testar com $this->resultado

		return @mysql_affected_rows( $this->handler );

	}

	/**
	* 	retornaNumColunas()
	* 	Retorna o numero de colunas resultantes da consulta
	*	@return mysql_num_fields()	Resultado da mysql_num_fields()
	*/
	function retornaNumColunas() {

		return @mysql_num_fields( $this->resultado );

	}

	/**
	* 	retornaNomeColuna( $posicao )
	* 	Retorna o nome de uma coluna
	*	@param $posicao		Posicao da coluna na selecao ou tabela
	*	@return mysql_field_name()	Resultado da mysql_field_name()
	*/
	function retornaNomeColuna( $posicao ) {

		return @mysql_field_name( $this->resultado, $posicao );

	}

	/**
	* 	retornaTipoColuna( $posicao )
	* 	Retorna o tipo de uma coluna
	*	@param $posicao			Posicao da coluna na selecao ou tabela
	*	@return mysql_field_type()	Resultado da mysql_field_name()
	*/
	function retornaTipoColuna( $posicao ) {

		return @mysql_field_type( $this->resultado, $posicao );

	}

	/**
	* 	retornaResultado( $linha, $coluna )
	* 	Retorna o resultado da coluna e linha especificada
	*	@param $coluna			Posicao da coluna na selecao ou tabela
	*	@param $linha			Posicao da linha na selecao ou tabela
	*	@return	 mysql_result()		Resultado da mysql_result()
	*/
	function retornaResultado( $linha, $coluna ) {

		return @mysql_result( $this->resultado, $linha, $coluna );

	}

}

?>
