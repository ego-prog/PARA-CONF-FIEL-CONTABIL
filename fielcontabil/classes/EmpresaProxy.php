<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 17/10/2003
*	Modulo: EmpresaProxy.php
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
*   EmpresaProxy
*
*   Classe que persiste os dados das empresas cadastradas
*   no Contábil Web
*
*/
class EmpresaProxy extends Proxy {

      var $broker;		       // Atributo de persistencia (Singleton)
      var $oidEmpresaCont;	   // OID da empresa que utilizara a contabilidade
      var $oidEmpresa;		   // Codigo da empresa (proprietaria)
      var $razaoSocial; 	   // Razao social
      var $cnpj;		       // CNPJ
      var $inscricaoEstadual;  // Inscricao estadual
      var $inscricaoMunicipal; // Inscricao municipal
      var $endereco;		   // Endereco
      var $bairro;		       // Bairro
      var $cidade;		       // Cidade
      var $cep; 		       // CEP
      var $uf;			       // UF
      var $eMail;		       // e-mail
      var $dataInicial; 	   // data inicial
      var $dataFinal;		   // data final
      var $nomeContador;	   // nome do contador
      var $registroContador;   // registro contador
      var $responsavel; 	   // responsavel pela empresa
      var $cpfResponsavel;	   // CPF do responsavel pela empresa
      var $mascaraPlano;	   // Mascara do plano
      var $mascaraDoar; 	   // Mascara DOAR
	  var $codigoCaixa;	   // Código da Conta Caixa
      var $listObjects; 	   // Lista de objetos
      var $expressao;	       // Expressao de busca
      var $flagAuxiliar;	   // Flag auxiliar de desenvolvimento

      /**
      *  getBroker()
      *  Retorna o broker utilizado para persistencia
      *  @return getBroker
      */
      function getBroker() {

		  return BD_PgSQL;

      }

      /**
      *       setObject( $oidEmpresa, $razaoSocial, $cnpj, $inscricaoEstadual, $inscricaoMunicipal,
      * 	      $endereco, $bairro, $cidade, $cep, $uf, $eMail, $dataInicial, $dataFinal,
      * 	      $nomeContador, $registroContador, $responsavel, $cpfResponsavel, $mascaraPlano, $mascaraDoar )
      *       Recebe os dados para registro de departamento
      *       @param $oidEmpresa	     OID da empresa
      *       @param $razaoSocial	     Razao social
      *       @param $cnpj		     CNPJ
      *       @param $inscricaoEstadual      Inscricao estadual
      *       @param $inscricaoMunicipal     Inscricao Municipal
      *       @param $endereco		     Endereco
      *       @param $bairro		     Bairro
      *       @param $cidade		     Cidade
      *       @param $cep		     CEP
      *       @param $uf		     UF
      *       @param $eMail		     e-mail
      *       @param $dataInicial	     Data inicial
      *       @param $dataFinal 	     Data final
      *       @param $nomeContador	     Nome do contador
      *       @param $registroContador	     Registro do contador
      *       @param $responsavel	     Responsavel pela empresa
      *       @param $cpfResponsavel	     CPF do responsavel
      *       @param $mascaraPlano	     Mascara plano
      *       @param $mascaraDoar	     Mascara DOAR
	  *	  @param $codigoCaixa	     Código da Conta Caixa
      */
      function setObject( $oidEmpresa, $razaoSocial, $cnpj, $inscricaoEstadual, $inscricaoMunicipal,
	     $endereco, $bairro, $cidade, $cep, $uf, $eMail, $dataInicial, $dataFinal,
	     $nomeContador, $registroContador, $responsavel, $cpfResponsavel, $mascaraPlano, $mascaraDoar, $codigoCaixa ) {

	     // Seta os atributos para objeto
	     $this->oidEmpresa	       = $oidEmpresa;
	     $this->razaoSocial        = $razaoSocial;
	     $this->cnpj		   = $cnpj;
	     $this->inscricaoEstadual  = $inscricaoEstadual;
	     $this->inscricaoMunicipal = $inscricaoMunicipal;
	     $this->endereco	       = $endereco;
	     $this->bairro		   = $bairro;
	     $this->cidade		   = $cidade;
	     $this->cep 		   = $cep;
	     $this->uf			   = $uf;
	     $this->eMail		   = $eMail;
	     $this->dataInicial        = Data::converteDmaAmd( $dataInicial );
	     $this->dataFinal	       = Data::converteDmaAmd( $dataFinal );
	     $this->nomeContador       = $nomeContador;
	     $this->registroContador   = $registroContador;
	     $this->responsavel        = $responsavel;
	     $this->cpfResponsavel     = $cpfResponsavel;
	     $this->mascaraPlano       = $mascaraPlano;
	     $this->mascaraDoar        = $mascaraDoar;
		 $this->codigoCaixa	   = $codigoCaixa;

    }

    /**
    *	save()
    *	Grava objeto persistente
    *	@return  flagGravou	  true se foi possivel gravar ou false caso contrario
    */
    function save() {

		// Seta variaveis utilizadas no metodo
		$flagGravou = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagGravou;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "insert into empresa_cont ( codigo, codigocliente, razaosocial, ";
		$instrucao .= " cnpj, inscricaoestadual, inscricaomunicipal, endereco, bairro, ";
		$instrucao .= " cidade, cep, uf, email, datainicial, datafinal, nomecontador, ";
		$instrucao .= " registrocontador, responsavel, cpfresponsavel, mascaraplano, mascaradoar, codigocaixa ) ";
		$instrucao .= " values ";
		$instrucao .= " ( nextval('empresa_pk'), '$this->oidEmpresa', '$this->razaoSocial', '$this->cnpj', ";
		$instrucao .= " '$this->inscricaoEstadual', '$this->inscricaoMunicipal', '$this->endereco', ";
		$instrucao .= " '$this->bairro', '$this->cidade', '$this->cep', '$this->uf', '$this->eMail', '$this->dataInicial', ";
		$instrucao .= " '$this->dataFinal', '$this->nomeContador', '$this->registroContador', '$this->responsavel', ";
		$instrucao .= " '$this->cpfResponsavel', '$this->mascaraPlano', '$this->mascaraDoar', $this->codigoCaixa );";

		// Executa instrucao SQL...
		if ( $broker->atualizaBD( $instrucao ) ) {
			$flagGravou = true;
			$broker->gravaTransacao(); }
		else
			$broker->abortaTransacao();

		// Finaliza Transacao...
		$broker->finalizaTransacao();

		// fecha conexao...
		$broker->fechaConexao();

		// Retorna flag...
		return $flagGravou;

    }

    /**
    *	findByOid( $oidEmpresaCont )
    *	Pesquisa pelo OID do Objeto
    *	@param	 $oidEmpresaCont    OID da empresa contabil
    */
    function findByOid( $oidEmpresaCont ) {

		// Seta variaveis utilizadas no metodo
		$this->oidEmpresaCont = $oidEmpresaCont;
		$flagAchou = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagAchou;

			$instrucao  = "select codigo, codigocliente, razaosocial, cnpj, inscricaoestadual, inscricaomunicipal, ";
			$instrucao .= " endereco, bairro, cidade, cep, uf, email, datainicial, datafinal, nomecontador, ";
			$instrucao .= " registrocontador, responsavel, cpfresponsavel, mascaraplano, mascaradoar, codigocaixa from empresa_cont ";
			$instrucao .= " where codigo = '$this->oidEmpresaCont';";

			// Executa instrucao SQL...
			if ( $broker->consultaBD( $instrucao ) ) {

			// Se conseguiu achar...
			if ( $broker->retornaNumLinhas() > 0 ) {
				$flagAchou = true;

				// seta variaveis de instancia
				$this->oidEmpresaCont	  = $broker->retornaResultado( 0, 0 );
				$this->oidEmpresa	  = $broker->retornaResultado( 0, 1 );
				$this->razaoSocial	      = $broker->retornaResultado( 0, 2 );
				$this->cnpj			  = $broker->retornaResultado( 0, 3 );
				$this->inscricaoEstadual  = $broker->retornaResultado( 0, 4 );
				$this->inscricaoMunicipal = $broker->retornaResultado( 0, 5 );
				$this->endereco 	      = $broker->retornaResultado( 0, 6 );
				$this->bairro		      = $broker->retornaResultado( 0, 7 );
				$this->cidade		      = $broker->retornaResultado( 0, 8 );
				$this->cep		      = $broker->retornaResultado( 0, 9 );
				$this->uf			  = $broker->retornaResultado( 0, 10 );
				$this->eMail		  = $broker->retornaResultado( 0, 11 );
				$this->dataInicial	  = Data::converteAmdDma( $broker->retornaResultado( 0, 12 ) );
				$this->dataFinal	      = Data::converteAmdDma( $broker->retornaResultado( 0, 13 ) );
				$this->nomeContador	  = $broker->retornaResultado( 0, 14 );
				$this->registroContador   = $broker->retornaResultado( 0, 15 );
				$this->responsavel	      = $broker->retornaResultado( 0, 16 );
				$this->cpfResponsavel	  = $broker->retornaResultado( 0, 17 );
				$this->mascaraPlano	      = $broker->retornaResultado( 0, 18 );
				$this->mascaraDoar	  = $broker->retornaResultado( 0, 19 );
				$this->codigoCaixa	  = $broker->retornaResultado( 0, 20 );

			}

		}

		// fecha conexao...
		$broker->fechaConexao(); 

		// Retorna flag...
		return $flagAchou;

    }

    /**
    *	getObject()
    *	Retorna objeto atual
    *	@return $array		     Retorna objeto atual
    */
    function getObject() {

		// retorna objeto atual
		return array( $this->oidEmpresaCont, $this->oidEmpresa, $this->razaoSocial,
			$this->cnpj, $this->inscricaoEstadual, $this->inscricaoMunicipal,
			$this->endereco, $this->bairro, $this->cidade, $this->cep, $this->uf,
			$this->eMail, $this->dataInicial, $this->dataFinal, $this->nomeContador,
			$this->registroContador, $this->responsavel, $this->cpfResponsavel,
			$this->mascaraPlano, $this->mascaraDoar, $this->codigoCaixa );

    }

    /**
    *	update( $oidEmpresaCont )
    *	Altera objeto persistente
    *	@param	 $oidEmpresaCont   OID da empresa contabil
    *	@return  $flagGravou	   true se foi possivel gravar ou false caso contrario
    */
    function update( $oidEmpresaCont ) {

		// Seta variaveis utilizadas no metodo
		$this->oidEmpresaCont = $oidEmpresaCont;
		$flagGravou	      = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagGravou;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "update empresa_cont ";
		$instrucao .= " set razaosocial = '$this->razaoSocial', cnpj = '$this->cnpj', inscricaoestadual = '$this->inscricaoEstadual', ";
		$instrucao .= " inscricaomunicipal = '$this->inscricaoMunicipal', endereco = '$this->endereco', ";
		$instrucao .= " bairro = '$this->bairro', cidade = '$this->cidade', cep = '$this->cep', uf = '$this->uf', ";
		$instrucao .= " email = '$this->eMail', datainicial = '$this->dataInicial', datafinal = '$this->dataFinal', ";
		$instrucao .= " nomecontador = '$this->nomeContador', registrocontador = '$this->registroContador', responsavel = '$this->responsavel', ";
		$instrucao .= " cpfresponsavel = '$this->cpfResponsavel', mascaraplano = '$this->mascaraPlano', mascaradoar = '$this->mascaraDoar', codigocaixa = '$this->codigoCaixa' ";
		$instrucao .= " where codigo = '$this->oidEmpresaCont';";

		// Executa instrucao SQL...
		if ( $broker->atualizaBD( $instrucao ) ) {
			$flagGravou = true;
			$broker->gravaTransacao(); }
		else
			$broker->abortaTransacao();

		// Finaliza Transacao...
		$broker->finalizaTransacao();

		// fecha conexao...
		$broker->fechaConexao();

		// Retorna flag...
		return $flagGravou;

    }

    /**
    *	search( $oidEmpresa, $expressao, $operacao, $loginUsuario )
    *	Pesquisa por critério de selecao
    *	@param	$oidEmpresa	OID da empresa
    *	@param	$expressao	Expressao de busca
    *	@param	$operacao	Operacao a ser realizada
    */
    function search( $oidEmpresa, $expressao, $operacao = 1, $loginUsuario = "" ) {

		// Seta variaveis utilizadas no metodo
		$this->oidEmpresa = $oidEmpresa;
		$this->listObjects = array();
		$this->listObjects[0][0] = "0";

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return false;

		switch( $operacao ) {

			case 1: {

					// Seta variavel de pesquisa...
					$this->expressao     = "%".strtoupper( trim( $expressao ) )."%";

					$instrucao  = "select codigo, razaosocial, cnpj, ";
					$instrucao .= " inscricaoestadual, inscricaomunicipal, endereco from empresa_cont ";
					$instrucao .= " where razaosocial like '$this->expressao' ";
					$instrucao .= " and codigocliente = '$this->oidEmpresa' ";
					if ($loginUsuario != "")
					    $instrucao .= " and codigo in (select codigoempresa from usuarioempresa_cont where codigousuario = (select codigo from usuario_cont where login='$loginUsuario')) ";
					$instrucao .= " order by razaosocial, cnpj;";

					// Executa instrucao SQL...
					if ( $broker->consultaBD( $instrucao ) ) {

						// Monta array de retorno
						for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

							$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
							$broker->retornaResultado( $indx, 1 ), $broker->retornaResultado( $indx, 2 ),
							$broker->retornaResultado( $indx, 3 ), $broker->retornaResultado( $indx, 4 ) );
						}

					}

			break; }

			// Retorna oidEmpresa, Descricao e mascaras (Plano de Contas e DOAR)
			case 2: {

					// Seta variavel de pesquisa...
					$this->expressao     = "%".strtoupper( trim( $expressao ) )."%";

					$instrucao  = "select codigo, razaosocial, mascaraplano, mascaradoar from empresa_cont ";
					$instrucao .= " where razaosocial like '$this->expressao' ";
					$instrucao .= " and codigocliente = '$this->oidEmpresa' ";
					if ($loginUsuario != "")
					    $instrucao .= " and codigo in (select codigoempresa from usuarioempresa_cont where codigousuario = (select codigo from usuario_cont where login='$loginUsuario')) ";
					$instrucao .= " order by razaosocial, cnpj;";

					// Executa instrucao SQL...
					if ( $broker->consultaBD( $instrucao ) ) {

						// Monta array de retorno
						for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

							$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
							$broker->retornaResultado( $indx, 1 ), $broker->retornaResultado( $indx, 2 ),
							$broker->retornaResultado( $indx, 3 ) );
						}

					}

			break; }

			// Retorna oidEmpresa, Descricao, mascaras e periodo contabil (Utilizado no registro de lancamentos)
			case 3: {

					// Seta variavel de pesquisa...
					$this->expressao     = "%".strtoupper( trim( $expressao ) )."%";

					$instrucao  = "select codigo, razaosocial, mascaraplano, mascaradoar, datainicial, datafinal from empresa_cont ";
					$instrucao .= " where codigocliente = '$this->oidEmpresa' ";
					if ($loginUsuario != "")
					    $instrucao .= " and codigo in (select codigoempresa from usuarioempresa_cont where codigousuario = (select codigo from usuario_cont where login='$loginUsuario')) ";
					$instrucao .= " order by razaosocial, codigo;";

					// Executa instrucao SQL...
					if ( $broker->consultaBD( $instrucao ) ) {

						// Monta array de retorno
						for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

							$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
							$broker->retornaResultado( $indx, 1 ), $broker->retornaResultado( $indx, 2 ),
							$broker->retornaResultado( $indx, 3 ), Data::converteAmdDma( $broker->retornaResultado( $indx, 4 ) ),
							Data::converteAmdDma( $broker->retornaResultado( $indx, 5 ) ) );
						}

					}

			break; }

			case 4: {

					// Seta variavel de pesquisa...
					$this->expressao     = "%".strtoupper( trim( $expressao ) )."%";

					$instrucao  = "select codigo, razaosocial, cnpj, ";
					$instrucao .= " inscricaoestadual, inscricaomunicipal, endereco from empresa_cont ";
					$instrucao .= " where razaosocial like '$this->expressao' ";
					$instrucao .= " and codigocliente = '$this->oidEmpresa' ";
					$instrucao .= " and ( select count(*) from contacontabil_cont ";
					$instrucao .= " where contacontabil_cont.codigoempresa = empresa_cont.codigo ";
					$instrucao .= " and contacontabil_cont.tipo = 'A' ) > 0 ";
					if ($loginUsuario != "")
					    $instrucao .= " and codigo in (select codigoempresa from usuarioempresa_cont where codigousuario = (select codigo from usuario_cont where login='$loginUsuario')) ";
					$instrucao .= " order by razaosocial, cnpj;";

					// Executa instrucao SQL...
					if ( $broker->consultaBD( $instrucao ) ) {

						// Monta array de retorno
						for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

							$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
							$broker->retornaResultado( $indx, 1 ), $broker->retornaResultado( $indx, 2 ),
							$broker->retornaResultado( $indx, 3 ), $broker->retornaResultado( $indx, 4 ) );
						}

					}

			break; }

			case 5: {

					// Seta variavel de pesquisa...
					$this->expressao     = "%".strtoupper( trim( $expressao ) )."%";

					$instrucao  = "select codigo, razaosocial, mascaraplano, mascaradoar ";
					$instrucao .= " from empresa_cont ";
					$instrucao .= " where razaosocial like '$this->expressao' ";
					$instrucao .= " and codigocliente = '$this->oidEmpresa' ";
					$instrucao .= " and ( select count(*) from contadoar_cont ";
					$instrucao .= " where contadoar_cont.codigoempresa = empresa_cont.codigo ";
					$instrucao .= " and contadoar_cont.tipo = 'A' ) > 0 ";
					if ($loginUsuario != "")
					    $instrucao .= " and codigo in (select codigoempresa from usuarioempresa_cont where codigousuario = (select codigo from usuario_cont where login='$loginUsuario')) ";
					$instrucao .= " order by razaosocial, cnpj;";

					// Executa instrucao SQL...
					if ( $broker->consultaBD( $instrucao ) ) {

						// Monta array de retorno
						for ( $indx = 0; $indx < $broker->retornaNumLinhas(); $indx++ ) {

							$this->listObjects[$indx] = array( $broker->retornaResultado( $indx, 0 ),
							$broker->retornaResultado( $indx, 1 ), $broker->retornaResultado( $indx, 2 ),
							$broker->retornaResultado( $indx, 3 ) );
						}

					}

			break; }

		}

		// fecha conexao...
		$broker->fechaConexao();

    }

    /**
    *  getList()
    *  Retorna lista de objetos
    *  @return listObjects
    */
    function getList() {

		return $this->listObjects;

    }

    /**
    *	delete( $oidEmpresaCont )
    *	Exclui objeto persistente
    *	@param	 $oidEmpresaCont   OID da empresa contabil
    *	@return  $flagExcluiu true se foi possivel gravar ou false caso contrario
    */
    function delete( $oidEmpresaCont ) {

		// Seta variaveis utilizadas no metodo
		$this->oidEmpresaCont = $oidEmpresaCont;
		$flagExcluiu	      = false;

		// Cria broker para conexao...
		$broker = $this->criaBroker();

		// Abre conexao...
		if ( !$broker->abreConexao() )
			return $flagExcluiu;

		// Inicia Transacao...
		$broker->iniciaTransacao();

		// Monta instrucao...
		$instrucao  = "delete from empresa_cont ";
		$instrucao .= "where codigo = '$this->oidEmpresaCont';";

		// Executa instrucao SQL...
		if ( $broker->atualizaBD( $instrucao ) ) {
			$flagExcluiu = true;
			$broker->gravaTransacao(); }
		else
			$broker->abortaTransacao();

		// Finaliza Transacao...
		$broker->finalizaTransacao();

		// fecha conexao...
		$broker->fechaConexao();

		// Retorna flag...
		return $flagExcluiu;

    }

}

?>
