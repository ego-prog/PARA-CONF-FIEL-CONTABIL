<?PHP

/**
*
*	Framework de Persistencia
*
*	Data de Criacao: 17/05/2002
*	Ultima Atualizacao: 17/05/2002
*	Modulo: BrokerPgSQL.php
*	Framework de mapeamento de objetos
*
*	Copyright (C) por APOENA Solucoes em Software Livre
*	http://www.apoenasoftwarelivre.com.br
*
*	@author Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*	@version	PHP3 & PHP4
*/

// Arquivo "header" do Framework
include $pathClassesPersistencia."framework_persistencia.inc";

/**
*
*	BrokerPgSQL
*
*	Classe que contem as principais definicoes para utilizacao do
*	"broker" PostgreSQL
*
*/
class BrokerPgSQL extends BrokerSGBD {

	/**
	*	BrokerPgSQL()
	*	Construtor da classe
	*/
	function BrokerPgSQL() {

		// No construtor e possivel definir algumas definicoes especificas
		// do BD, incluindo maquina, usuario, senha...
		// $this->setParametro( banco, usuario, senha,
		//						"5432", host );

	}

	/**
	*	abreConexao( $persistente )
	*	Abre conexao com o BD
	*	@param	$persistente	Realiza conexao persistente
	*	@return BD_OK			Se conseguiu realizar conexao ao BD ou
	*	@return BD_ERRO 		se nao conseguiu realizar a conexao
	*/
	function abreConexao( $persistente = true ) {

		$this->parametroBD	= " host=".$this->getHost()." port=".$this->getPorta();
		$this->parametroBD .= " dbname=".$this->getNomeBanco();
		$this->parametroBD .= " user=".$this->getUsuario()." password=".$this->getSenha();

		// Para conexao persistente...
		if ( $persistente ) {
			if ( !( $this->handler = pg_pconnect( $this->parametroBD ) ) )
				return BD_ERRO;
			else
				return @pg_exec( $this->handler, "set DATESTYLE TO 'ISO';" )?BD_OK:BD_ERRO; }
		// senao...
		else {
			if ( !( $this->handler = @pg_connect( $this->parametroBD ) ) )
				return BD_ERRO;
			else
				return @pg_exec( $this->handler, "set DATESTYLE TO 'ISO';" )?BD_OK:BD_ERRO; }

	}

	/**
	*	fechaConexao()
	*	Fecha conexao com o BD
	*	@return pg_close()		Resultado da pg_close()
	*/
	function fechaConexao() {

		return @pg_close( $this->handler );

	}

	/**
	*	iniciaTransacao()
	*	Inicia transacao para BD
	*	@return BD_OK			Se conseguiu iniciar a transacao com o BD ou
	*	@return BD_ERRO 		se nao conseguiu iniciar a transacao
	*/
	function iniciaTransacao() {

		return @pg_exec( $this->handler, "begin transaction;" )?BD_OK:BD_ERRO;

	}

	/**
	*	finalizaTransacao()
	*	Finaliza transacao para BD
	*	@return BD_OK			Se conseguiu fnalizar a transacao com o BD ou
	*	@return BD_ERRO 		se nao conseguiu finalizar a transacao
	*/
	function finalizaTransacao() {

		return @pg_exec( $this->handler, "end transaction;" )?BD_OK:BD_ERRO;

	}

	/**
	*	gravaTransacao()
	*	Grava transacao para BD
	*	@return BD_OK			Se conseguiu gravar a transacao com o BD ou
	*	@return BD_ERRO 		se nao conseguiu gravar a transacao
	*/
	function gravaTransacao() {

		return @pg_exec( $this->handler, "commit transaction;" )?BD_OK:BD_ERRO;

	}

	/**
	*	abortaTransacao()
	*	aborta transacao para BD
	*	@return BD_OK			Se conseguiu abortar a transacao com o BD ou
	*	@return BD_ERRO 		se nao conseguiu abortar a transacao
	*/
	function abortaTransacao() {

		return @pg_exec( $this->handler, "abort;" )?BD_OK:BD_ERRO;

	}
	
	/**
	*	atualizaBD( $instrucaoSql )
	*	Atualiza dados no BD
	*	@param	$instrucaoSql	comando de atualizacao
	*	@return BD_OK			Se conseguiu atualizar o BD ou
	*	@return BD_ERRO 		se nao conseguiu atualizar o BD
	*/
	function atualizaBD( $instrucaoSql ) {

		$this->setInstrucaoSql( $instrucaoSql );

		//$this->resultado = @pg_exec( $this->handler, "set DATESTYLE='SQL'" );
		$this->resultado = @pg_exec( $this->handler, $this->getInstrucaoSql() );

		return $this->resultado?BD_OK:BD_ERRO;

	}

	/**
	*	consultaBD()
	*	Consulta dados no BD
	*	@param	$instrucaoSql		comando de atualizacao
	*	@return $resultado		Se conseguiu consultar o BD ou
	*	@return BD_FALHA_CONSULTA	se nao conseguiu consultar o BD
	*/
	function consultaBD( $instrucaoSql ) {

		$this->setInstrucaoSql( $instrucaoSql );

		//$this->resultado = @pg_exec( $this->handler, "set DATESTYLE='SQL'" );
			$this->resultado = @pg_exec( $this->handler, $this->getInstrucaoSql() );

		return !$this->resultado?BD_FALHA_CONSULTA:$this->resultado;

	}

	/**
	*	retornaNumLinhas()
	*	Retorna o numero de linhas resultantes da consulta
	*	@return pg_numrows()	Resultado da pg_numrows()
	*/
	function retornaNumLinhas() {

		return @pg_numrows( $this->resultado );

	}

	/**
	*	retornaNumLinhasAfetadas()
	*	Retorna o numero de linhas afetadas
	*	@return pg_cmdtuples()	Resultado da pg_cmdtuples()
	*/
	function retornaNumLinhasAfetadas() {

		return @pg_cmdtuples( $this->resultado );

	}

	/**
	*	retornaNumColunas()
	*	Retorna o numero de colunas resultantes da consulta
	*	@return pg_numfields()	Resultado da pg_numfields()
	*/
	function retornaNumColunas() {

		return @pg_numfields( $this->resultado );

	}

	/**
	*	retornaNomeColuna( $posicao )
	*	Retorna o nome de uma coluna
	*	@param $posicao 	Posicao da coluna na selecao ou tabela
	*	@return pg_fieldname()	Resultado da pg_fieldname()
	*/
	function retornaNomeColuna( $posicao ) {

		return @pg_fieldname( $this->resultado, $posicao );

	}

	/**
	*	retornaTipoColuna( $posicao )
	*	Retorna o tipo de uma coluna
	*	@param $posicao 		Posicao da coluna na selecao ou tabela
	*	@return pg_fieldtype()	Resultado da pg_fieldname()
	*/
	function retornaTipoColuna( $posicao ) {

		return @pg_fieldtype( $this->resultado, $posicao );

	}

	/**
	*	retornaResultado( $linha, $coluna )
	*	Retorna o resultado da coluna e linha especificada
	*	@param $coluna			Posicao da coluna na selecao ou tabela
	*	@param $linha			Posicao da linha na selecao ou tabela
	*	@return pg_result()	Resultado da pg_result()
	*/
	function retornaResultado( $linha, $coluna ) {

		return @pg_result( $this->resultado, $linha, $coluna );

	}

}

?>
