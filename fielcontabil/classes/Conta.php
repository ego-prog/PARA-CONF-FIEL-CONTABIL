<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 29/10/2003
*	Modulo: ContaDoar.php
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
*	Conta
*
*	Classe que contem as principais definicoes de contas
*	da contabilidade no Contabil Web
*
*/
class Conta {

	var $oidConta;	      // OID da conta
	var $dv;	      // Digito verificador
	var $codigoSintetico; // Codigo Sintetico
	var $oidContaDoar;    // OID da conta DOAR
	var $oidEmpresaCont;  // Codigo da empresa (proprietaria)
	var $descricao;       // Descricao da conta
	var $tipo;	      // Tipo da conta DOAR (Analitica ou Sintetica)
	var $natureza;	      // Devedora ou Credora
	var $classificacao;   // Despesa, Receita ou Outra
	var $devedora;	      // Pode ficar devedora (S/N)
	var $credora;	      // Pode ficar credora (S/N)
	var $persistence;	  // Utilizado para persistencia dos objetos

	/**
	*  Conta()
	*  Construtor da classe
	*/
	function Conta() {

		$this->persistence = new ContaProxy();

	}

	/**
	*	setConta( $oidEmpresaCont, $codigoSintetico, $descricao, $natureza, $tipo,
	*		$classificacao, $credora, $devedora, $oidContaDoar )
	*	Recebe os dados para manipulacao
	*	@param $oidEmpresaCont	   OID da empresa
	*	@param $codigoSintetico    Codigo sintetico
	*	@param $descricao	       Descricao da conta
	*	@param $natureza		   Natureza
	*	@param $tipo			   Tipo da conta
	*	@param $classificacao	   Classificacao
	*	@param $credora 	   Credora
	*	@param $devedora	   Devedora
	*	@param $oidContaDoar	   OID da conta DOAR
	*/
	function setConta( $oidEmpresaCont, $codigoSintetico, $descricao, $natureza,
			$tipo, $classificacao, $credora, $devedora, $oidContaDoar ) {

		$this->setOidEmpresaCont( $oidEmpresaCont );
		$this->setCodigoSintetico( $codigoSintetico );
		$this->setDescricao( $descricao );
		$this->setNatureza( $natureza );
		$this->setTipo( $tipo );
		$this->setClassificacao( $classificacao );
		$this->setCredora( $credora );
		$this->setDevedora( $devedora );
		$this->setOidContaDoar( $oidContaDoar );

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
	*	setOidContaDoar( $oidContaDoar )
	*	Recebe OID de conta DOAR
	*	@param $oidContaDoar   OID da conta DOAR
	*/
	function setOidContaDoar( $oidContaDoar ) {

		$this->oidContaDoar = $oidContaDoar;

	}

	/**
	*	getOidContaDoar()
	*	Retorna OID de conta DOAR
	*	@return $oidContaDoar	 OID da conta DOAR
	*/
	function getOidContaDoar() {

		return $this->oidContaDoar;

	}

	/**
	*	setCodigoSintetico( $codigoSintetico )
	*	Recebe codigo sintetico
	*	@param $codigoSintetico   Codigo sintetico
	*/
	function setCodigoSintetico( $codigoSintetico ) {

		$this->codigoSintetico = $codigoSintetico;

	}

	/**
	*	getCodigoSintetico()
	*	Retorna codigo sintetico
	*	@return $codigoSintetico	Codigo sintetico
	*/
	function getCodigoSintetico() {

		return $this->codigoSintetico;

	}

	/**
	*	setOidConta( $oidConta )
	*	Recebe OID de conta
	*	@param $oidConta   OID da conta
	*/
	function setOidConta( $oidConta ) {

		$this->oidConta = $oidConta;

	}

	/**
	*	getOidConta()
	*	Retorna OID de conta
	*	@return $oidConta    OID da conta
	*/
	function getOidConta() {

		return $this->oidConta;

	}

	/**
	*	setDescricao( $descricao )
	*	Recebe descricao da conta
	*	@param $descricao	 descricao da conta
	*/
	function setDescricao( $descricao ) {

		$this->descricao = trim( String::upper( $descricao ) );

	}

	/**
	*	getDescricao()
	*	Retorna descricao
	*	@return $descricao		descricao da conta
	*/
	function getDescricao() {

		return $this->descricao;

	}

	/**
	*	setTipo( $tipo )
	*	Recebe tipo da conta
	*	@param $tipo		Tipo de conta
	*/
	function setTipo( $tipo ) {

		$this->tipo = trim( String::upper( $tipo ) );

	}

	/**
	*	getTipo()
	*	Retorna tipo da conta
	*	@return $tipo		Tipo de conta
	*/
	function getTipo() {

		return $this->tipo;

	}

	/**
	*	setNatureza( $natureza )
	*	Recebe natureza da operacao
	*	@param $natureza	natureza
	*/
	function setNatureza( $natureza ) {

		$this->natureza = trim( String::upper( $natureza ) );

	}

	/**
	*	getNatureza()
	*	Retorna natureza
	*	@return $natureza	Natureza
	*/
	function getNatureza() {

		return $this->natureza;

	}

	/**
	*	setClassificacao( $classificacao )
	*	Recebe classificacao
	*	@param $classificacao	Classificacao
	*/
	function setClassificacao( $classificacao ) {

		$this->classificacao = trim( String::upper( $classificacao ) );

	}

	/**
	*	getClassificacao()
	*	Retorna classificacao
	*	@return $classificacao	Classificacao
	*/
	function getClassificacao() {

		return $this->classificacao;

	}

	/**
	*	setCredora( $credora )
	*	Recebe credora
	*	@param $credora 	Credora
	*/
	function setCredora( $credora ) {

		$this->credora = trim( String::upper( $credora ) );

	}

	/**
	*	getCredora()
	*	Retorna credora
	*	@return $credora		Credora
	*/
	function getCredora() {

		return $this->credora;

	}

	/**
	*	setDevedora( $devedora )
	*	Recebe devedora
	*	@param $devedora		Devedora
	*/
	function setDevedora( $devedora ) {

		$this->devedora = trim( String::upper( $devedora ) );

	}

	/**
	*	getDevedora()
	*	Retorna devedora
	*	@return $devedora		Devedora
	*/
	function getDevedora() {

		return $this->devedora;

	}

	/**
	*	setDV( $dv )
	*	Recebe digito verificador
	*	@param $dv		digito verificador
	*/
	function setDV( $dv ) {

		$this->dv = trim( $dv );

	}

	/**
	*	getDV()
	*	Retorna digito verificador
	*	@return $dv		digito verificador
	*/
	function getDV() {

		return $this->dv;

	}

	/**
	*	setOidContaDV( $oidContaDV )
	*	Recebe OID da conta com DV
	*	@param $oidContaDV		Conta com DV
	*/
	function setOidContaDV( $oidContaDV ) {

		$codigoConta = explode( ".", $oidContaDV );
		$this->setOidConta( $codigoConta[0] );
		$this->setDV( $codigoConta[1] );

	}

	/**
	*	getOidContaDV()
	*	Retorna Conta com digito verificador
	*	@return $oidContaDV		conta com digito verificador
	*/
	function getOidContaDV() {

		return $this->getOidConta().".".$this->getDV();

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
		$this->persistence->setObject( $this->getOidEmpresaCont(),
					$this->getCodigoSintetico(),
					$this->getDescricao(),
					$this->getNatureza(),
					$this->getTipo(),
					$this->getClassificacao(),
					$this->getCredora(),
					$this->getDevedora(),
					$this->getOidContaDoar() );

		// Se for inclusão...
		if ( $operacao ) {
			$flagGravou = $this->persistence->save();
			if ( $flagGravou ) {
				$this->setOidConta( $this->persistence->findByParams( $this->getOidEmpresaCont(),
					$this->getCodigoSintetico(),
					$this->getDescricao(),
					$this->getNatureza(),
					$this->getTipo() ) );
				$this->persistence->setDV( Numero::modulo11( $this->getOidConta() ) );
				$flagGravou = $this->persistence->updateDV( $this->getOidConta() ); }
		}
		// se for alteracao...
		else
			$flagGravou = $this->persistence->update( $this->getOidContaDV() );

		return $flagGravou;

	}

	/**
	*	pesquisaConta( $oidContaDV, $oidEmpresaCont )
	*	Retorna conta encontrada
	*	@return true se encontrou conta por OID
	*/
	function pesquisaConta( $oidContaDV, $oidEmpresaCont = 0 ) {

		// Seta variaveis utilizada no metodo
		$flagAchou = false;

		if ( $this->persistence->findByOid( $oidContaDV, $oidEmpresaCont ) ) {
		   $flagAchou = true;

		   // Retorna objeto
		   $objetoAtual = $this->persistence->getObject();

		   // Seta atributos
		   $this->setOidConta( $objetoAtual[0] );
		   $this->setOidEmpresaCont( $objetoAtual[1] );
		   $this->setDV( $objetoAtual[2] );
		   $this->setCodigoSintetico( $objetoAtual[3] );
		   $this->setDescricao( $objetoAtual[4] );
		   $this->setNatureza( $objetoAtual[5] );
		   $this->setTipo( $objetoAtual[6] );
		   $this->setClassificacao( $objetoAtual[7] );
		   $this->setCredora( $objetoAtual[8] );
		   $this->setDevedora( $objetoAtual[9] );
		   $this->setOidContaDoar( $objetoAtual[10] );

		}

		// Retorna se encontrou conta...
		return $flagAchou;

	}

	/**
	*	pesquisaContaSemDV( $oidContaDV, $oidEmpresaCont )
	*	Retorna conta encontrada
	*	@return true se encontrou conta por OID
	*/
	function pesquisaContaSemDV( $oidConta, $oidEmpresaCont = 0 ) {

		// Seta variaveis utilizada no metodo
		$flagAchou = false;

		if ( $this->persistence->findByOidNoDV( $oidConta, $oidEmpresaCont ) ) {
		   $flagAchou = true;

		   // Retorna objeto
		   $objetoAtual = $this->persistence->getObject();

		   // Seta atributos
		   $this->setOidConta( $objetoAtual[0] );
		   $this->setOidEmpresaCont( $objetoAtual[1] );
		   $this->setDV( $objetoAtual[2] );
		   $this->setCodigoSintetico( $objetoAtual[3] );
		   $this->setDescricao( $objetoAtual[4] );
		   $this->setNatureza( $objetoAtual[5] );
		   $this->setTipo( $objetoAtual[6] );
		   $this->setClassificacao( $objetoAtual[7] );
		   $this->setCredora( $objetoAtual[8] );
		   $this->setDevedora( $objetoAtual[9] );
		   $this->setOidContaDoar( $objetoAtual[10] );

		}

		// Retorna se encontrou conta...
		return $flagAchou;

	}

	/**
	*	buscaConta( $oidEmpresaCont, $expressao, $operacao = 1 )
	*	Retorna todos as contas
	*	@param	$oidEmpresaCont OID da empresa
	*	@param	$expressao		Expressao de busca
	*	@param	$operacao	Operacao a ser realizada
	*	@return $contas 		Contas encontradas
	*/
	function buscaConta( $oidEmpresaCont, $expressao, $operacao = 1 ) {

		// Pesquisa contas por criterio de selecao...
		$this->persistence->search( $oidEmpresaCont, $expressao, $operacao );

		// retorna contas encontradas...
		return $this->persistence->getList();

	}

	/**
	*	exclui()
	*	Exclui conta
	*/
	function exclui() {

		// Exclui Conta...
		return $this->persistence->delete( $this->getOidContaDV() );

	}

	/**
	*	pesquisaContaInclusao( $codigoSintetico, $oidEmpresaCont )
	*	Retorna conta para poder incluir
	*	@param	$codigoSintetico Codigo sintetico
	*	@param	$oidEmpresaCont  OID da empresa
	*/
	function pesquisaContaInclusao( $codigoSintetico, $oidEmpresaCont ) {

		// Pesquisa contas por criterio de selecao...
		return $this->persistence->findByOidConta( $codigoSintetico, $oidEmpresaCont );

	}

	/**
	*	consultaPlanoContas( $oidEmpresaCont, $oidEmpresa, $perfilUsuario, $paginaInicial )
	*	Mostra consulta de plano de contas de uma determinada empresa, no formato HTML
	*   @param  $oidEmpresaCont   OID da empresa contabil
	*	@param	$oidEmpresa	  OID da empresa
	*	@param	$perfilUsuario	  Perfil do usuario
	*   @param  $paginaInicial    Número da Página Inicial
	*/
	function consultaPlanoContas( $oidEmpresaCont, $oidEmpresa, $perfilUsuario, $paginaInicial ) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";

		// Instancia objetos, seta atributos...
		$empresa	   = new Empresa();

		$lista	    = $this->buscaConta( $oidEmpresaCont, "", 3 );

		$listaClassificacao["D"] = $campoClassificacaoDespesa;
		$listaClassificacao["R"] = $campoClassificacaoReceita;
		$listaClassificacao["O"] = $campoClassificacaoOutra;

		$listaCredora["S"]	  = $campoPodeCredoraSim;
		$listaCredora["N"]	  = $campoPodeCredoraNao;

		$empresa->pesquisaEmpresa( $oidEmpresaCont );
		
		if ( $lista[0][0] == "0" )
		   return false;
		else {

		     // Seta variaveis auxiliares...
		     $acaoAdicional   = "javascript:window.print();";

		     $voltar	      = $mostra == true?"javascript:history.back();":"javascript:history.back();";

		 	 $infoAdicionais = "<font face=\"Verdana, Arial\" size=\"1\"><a href=\"../pdfs/".TXT_PLANOCONTAS."\">";
			 $infoAdicionais .= $msgCliqueAquiParaVisualizarTXT;
			 $infoAdicionais .= "</a></font>\n<br><br>\n";
		     $infoAdicionais .= "<input type=\"hidden\" name=\"oidEmpresa\" ";
		     $infoAdicionais .= "value=\"".$oidEmpresa."\">\n";
		     $infoAdicionais .= "<input type=\"hidden\" name=\"oidEmpresaCont\" ";
		     $infoAdicionais .= "value=\"".$oidEmpresaCont."\">\n";
		     if ( $perfilUsuario != "O" ) {
				 $infoAdicionais .= "<input type=\"hidden\" name=\"controleNavegacao\" ";
				 $infoAdicionais .= "value=\"2\">\n";
				 $infoAdicionais .= "<input type=\"submit\" name=\"gerar\" class=\"bjanela\" ";
				 $infoAdicionais .= "value=\"".$botaoGerarPDF."\">\n";
			 }
			 else {
				 $infoAdicionais .= "<input type=\"hidden\" name=\"controleNavegacao\" ";
				 $infoAdicionais .= "value=\"3\">\n";
				 $infoAdicionais .= "<input type=\"submit\" name=\"gerar\" class=\"bjanela\" ";
				 $infoAdicionais .= "value=\"".$botaoVisualizarPDF."\">\n";
			 }
		     $infoAdicionais .= "<input type=\"button\" name=\"imprimir\" class=\"bjanela\" ";
		     $infoAdicionais .= "value=\"".$botaoImprimir."\" onClick=\"".$acaoAdicional."\">\n";

		     // Cabecalho...
			 $cabecalho  = "<font face=\"Verdana, Arial\" color=\"#000099\" size=\"2\">";
			 $cabecalho .= $empresa->getOidEmpresaCont()." - ".$empresa->getRazaoSocial();
		     $cabecalho .= "</font><br><br>";

		     // Cria relatorio...
		     $relatorio = new RelatorioHTMLCw( $oidEmpresa,
										$relatorioPlanoContas, $cabecalho );
			
             $this->geraPlanoContasTXT( $oidEmpresaCont, $oidEmpresa, $perfilUsuario, $paginaInicial );
             
		     // Inicia apresentacao do relatorio...
		     $relatorio->inicioRelatorio();
			 
			 $relatorio->mostraString( "<table width=\"100%\" border=\"0\">" );
			 $relatorio->mostraString( "<tr>" );
			 $relatorio->mostraString( "<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"15%\" class=\"tjanela\" align=\"left\">" );
			 $relatorio->mostraString( $relatorioConta );
			 $relatorio->mostraString( "</td>" );
			 $relatorio->mostraString( "<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"center\">" );
			 $relatorio->mostraString( $relatorioCodigoAcesso );
			 $relatorio->mostraString( "</td>" );
			 $relatorio->mostraString( "<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"35%\" class=\"tjanela\" align=\"left\">" );
			 $relatorio->mostraString( $relatorioDescricao );
			 $relatorio->mostraString( "</td>" );
			 $relatorio->mostraString( "<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"center\">" );
			 $relatorio->mostraString( $relatorioNatureza );
			 $relatorio->mostraString( "</td>" );
			 $relatorio->mostraString( "<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"center\">" );
			 $relatorio->mostraString( $relatorioClassificacao );
			 $relatorio->mostraString( "</td>" );
			 $relatorio->mostraString( "<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"center\">" );
			 $relatorio->mostraString( $relatorioPodeCredora );
			 $relatorio->mostraString( "</td>" );
			 $relatorio->mostraString( "<td background=\"../imagens/cw_janela.gif\" border=\"0\" width=\"10%\" class=\"tjanela\" align=\"center\">" );
			 $relatorio->mostraString( $relatorioPodeDevedora );
			 $relatorio->mostraString( "</td></tr>" );

		     // Comeca laco para apresentacao do relatorio...
		     for ( $indx = 0; $indx < sizeof( $lista ); $indx++ ) {

				 // Define cor da linha
				 $cor = ($indx % 2)==0?"lcons1":"lcons2";

				 $relatorio->mostraString( "<tr>" );

				 // Codigo sintetico...
				 $relatorio->mostraString( "<td align=\"left\" width=\"15%\" class=\"".$cor."\">" );
				 $relatorio->mostraString( $lista[$indx][2] );
				 $relatorio->mostraString( "</td>" );

				 // Codigo de acesso...
				 $relatorio->mostraString( "<td align=\"center\" width=\"10%\" class=\"".$cor."\">" );
				 $relatorio->mostraString( $lista[$indx][1] );
				 
    //           Usado para atualizar o DV em cadastros importados.
	//			 $oidConta = explode(".",$lista[$indx][1]);
	//			 $contaAtu = new Conta();
	//			 $contaAtu->pesquisaConta( $oidConta[0]);
	//			 $contaAtu->atualizaDV($oidConta[0]);
	
				 $relatorio->mostraString( "</td>" );

				 // Descricao...
				 $relatorio->mostraString( "<td align=\"left\" width=\"35%\" class=\"".$cor."\">" );
				 $relatorio->mostraString( $lista[$indx][3] );
				 $relatorio->mostraString( "</td>" );

				 // Natureza...
				 $relatorio->mostraString( "<td align=\"center\" width=\"10%\" class=\"".$cor."\">" );
				 $relatorio->mostraString( $lista[$indx][5] );
				 $relatorio->mostraString( "</td>" );

				 // Classificacao...
				 $relatorio->mostraString( "<td align=\"center\" width=\"10%\" class=\"".$cor."\">" );
				 $relatorio->mostraString( $listaClassificacao[ $lista[$indx][6] ] );
				 $relatorio->mostraString( "</td>" );

				 // Pode credora...
				 $relatorio->mostraString( "<td align=\"center\" width=\"10%\" class=\"".$cor."\">" );
		 $relatorio->mostraString( $listaCredora[ $lista[$indx][8] ] );
				 $relatorio->mostraString( "</td>" );

				 // Pode devedora...
				 $relatorio->mostraString( "<td align=\"center\" width=\"10%\" class=\"".$cor."\">" );
		 $relatorio->mostraString( $listaCredora[ $lista[$indx][7] ] );
				 $relatorio->mostraString( "</td>" );

				 $relatorio->mostraString( "</tr>" );

				} // Fim do for indx...

			 // Finaliza relatorio...
		     $relatorio->mostraString( "</table>" );
			 
		     $relatorio->fimRelatorio( "cwConsPlano.php", $infoAdicionais, $voltar );

		     return true;

	       } // Fim da decisao de validacao do array

	}

	/**
	*	geraPlanoContasTXT( $oidEmpresaCont, $oidEmpresa, $perfilUsuario, $paginaInicial )
	*	Gera arquivo TXT com o Plano de Contas
	*   @param  $oidEmpresaCont   OID da empresa contabil
	*	@param	$oidEmpresa	  OID da empresa
	*	@param	$perfilUsuario	  Perfil do usuario
	*   @param  $paginaInicial    Número da Página Inicial
	*/
	function geraPlanoContasTXT( $oidEmpresaCont, $oidEmpresa, $perfilUsuario, $paginaInicial ) {

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";

		// Instancia objetos, seta atributos...
		$empresa	   = new Empresa();

		$lista	    = $this->buscaConta( $oidEmpresaCont, "", 3 );

		$listaClassificacao["D"] = $campoClassificacaoDespesa;
		$listaClassificacao["R"] = $campoClassificacaoReceita;
		$listaClassificacao["O"] = $campoClassificacaoOutra;

		$listaCredora["S"]	  = $campoPodeCredoraSim;
		$listaCredora["N"]	  = $campoPodeCredoraNao;

		$empresa->pesquisaEmpresa( $oidEmpresaCont );
		
		if ( $lista[0][0] == "0" )
		   return false;
		else {

		     // Cria relatorio...
		    $relatorioTXT = new RelatorioTXT();
		    $relatorioTXT->setConf("../pdfs/".TXT_PLANOCONTAS);

		    // Inicia apresentacao do relatorio...
		    $relatorioTXT->inicioRelatorio();
			 
             $contadorLinhas = 70;
             $contadorPagina = $paginaInicial - 1;
		     // Comeca laco para apresentacao do relatorio...
		     for ( $indx = 0; $indx < sizeof( $lista ); $indx++ ) {

				 if ($contadorLinhas > 52) {
					$contadorPagina++;
					$linhaCabec = str_pad("=", 132, "=").CRLF;
					$relatorioTXT->mostraString(chr(15).str_pad(" ", 48)."P L A N O".str_pad(" ", 3)."D E".str_pad(" ",3)+"C O N T A S".CRLF);
					$relatorioTXT->mostraString(String::removeAcento(sprintf("%-40s", $empresa->getRazaoSocial())).str_pad(" ", 85)."FL.".str_pad($contadorPagina, 4, "0", STR_PAD_LEFT).CRLF);
					$relatorioTXT->mostraString($linhaCabec);
					$relatorioTXT->mostraString(str_pad(" ", 4)."Conta".str_pad(" ", 8)."Cod.Acesso".str_pad(" ",4)."D e s c r i c a o".str_pad(" ", 26)."Natureza".str_pad(" ", 5)."Classificacao".str_pad(" ", 3)."Credora ?".str_pad(" ", 5)."Devedora ?".CRLF);
					$relatorioTXT->mostraString($linhaCabec);
					$contadorLinhas = 0;
				 }

				 // Codigo sintetico...
				 $stringCodigoSintetico = sprintf("%-20s",$lista[$indx][2]);
				 $relatorioTXT->mostraString( $stringCodigoSintetico );
				 
				 // Codigo de acesso...
				 $stringCodigoAcesso = sprintf("%-10s",$lista[$indx][1]);
				 $relatorioTXT->mostraString( $stringCodigoAcesso );
				 
    //           Usado para atualizar o DV em cadastros importados.
	//			 $oidConta = explode(".",$lista[$indx][1]);
	//			 $contaAtu = new Conta();
	//			 $contaAtu->pesquisaConta( $oidConta[0]);
	//			 $contaAtu->atualizaDV($oidConta[0]);
	
				 // Descricao...
				 $descricao = sprintf("%-45s",String::removeAcento($lista[$indx][3]));
				 $relatorioTXT->mostraString( $descricao );
				 $relatorioTXT->mostraString( str_pad(" ",3) );

				 // Natureza...
				 $natureza = $lista[$indx][5];
				 $relatorioTXT->mostraString( $natureza );
				 $relatorioTXT->mostraString( str_pad(" ",8) );

				 // Classificacao...
				 $stringClassificacao = sprintf("%-7s",$listaClassificacao[ $lista[$indx][6] ]) ; 
				 $relatorioTXT->mostraString( $stringClassificacao );
				 $relatorioTXT->mostraString( str_pad(" ",13) );

				 // Pode credora...
 				 $relatorioTXT->mostraString( $listaCredora[ $lista[$indx][8] ] );
				 $relatorioTXT->mostraString( str_pad(" ",11) );

				 // Pode devedora...
				 $relatorioTXT->mostraString( $listaCredora[ $lista[$indx][7] ] );

                 $relatorioTXT->mostraString( CRLF );
                 $contadorLinhas++;
                 if ($contadorLinhas > 52) {
                 	 $relatorioTXT->mostraString( FF );
                 }
				} // Fim do for indx...

			 // Finaliza relatorio...
		     $relatorioTXT->mostraString(FF);
			 
		     $relatorioTXT->fimRelatorio();

		     return true;

	       } // Fim da decisao de validacao do array

	}

	/**
	*	consultaPlanoContasPDF( $oidEmpresaCont, $oidEmpresa )
	*	Mostra consulta de plano de contas, em formato PDF
	*   @param  $oidEmpresaCont OID da empresa contabil
	*	@param	$oidEmpresa	    OID da empresa
	*/
	function consultaPlanoContasPDF( $oidEmpresaCont, $oidEmpresa ) {

		// Seta variaveis que possam ser utilizadas...
		$controleLinha	   = 1;
		$flagPreenchido    = false;

		// Instancia objetos, seta atributos...
		$empresa	   = new Empresa();

		$lista	    = $this->buscaConta( $oidEmpresaCont, "", 3 );

		$empresa->pesquisaEmpresa( $oidEmpresaCont );

		// Chama dicionario de internacionalizacao...
		require "../classes/MessageBundle.properties";
		$listaClassificacao["D"] = $campoClassificacaoDespesa;
		$listaClassificacao["R"] = $campoClassificacaoReceita;
		$listaClassificacao["O"] = $campoClassificacaoOutra;

		$listaCredora["S"]	  = $campoPodeCredoraSim;
		$listaCredora["N"]	  = $campoPodeCredoraNao;

		$larguraColunas = array( 20, 22, 70, 15, 20, 15, 15 );
		$cabecalho	= array( $relatorioConta, $relatorioCodigoAcesso, $relatorioDescricao,
					$relatorioNatureza, $relatorioClassificacao,
						$relatorioPodeCredora, $relatorioPodeDevedora );

		// Cria relatorio...
		$relatorio = new RelatorioPDFCw( $oidEmpresa, $relatorioPlanoContas,
			$oidEmpresaCont." - ".$empresa->getRazaoSocial(),
			$tituloSistema, $campoTextoPagina,$paginaInicial, true, $larguraColunas, $cabecalho );

		// Gera instancia de documento...
		$relatorio->getInstancia();

		// Seta margens do documento
		$relatorio->document->SetMargins( 10, 10, 10 );
		$relatorio->document->Open();
		$relatorio->document->AliasNbPages();
		$relatorio->document->SetAutoPageBreak( true, 10 );
		$relatorio->document->AddPage();

		// Monta cabecalho da tabela...
		$relatorio->document->setFonte( $relatorio->fonteTituloTabela );
		$relatorio->document->setCorTexto( $relatorio->corTituloTabela );
		$relatorio->document->setCorFundo( $relatorio->corFundoTituloTabela );
		$relatorio->document->setCorBorda( $relatorio->corBordaTabela );

		$relatorio->document->SetLineWidth( .2 );

		    $relatorio->document->setCorFundo( $relatorio->corFundoTabela );
		    $relatorio->document->setCorTexto( $relatorio->corTextoTabela );
		    $relatorio->document->setFonte( $relatorio->fonteTextoTabela );

		    // Comeca laco para impressao do relatorio...
		    for ( $indx = 0; $indx < sizeof( $lista ); $indx++ ) {

				// Controla preenchimento (automato finito - :-)...
				$flagPreenchido = !$flagPreenchido;

				// Imprime os dados...
				$relatorio->document->Cell( $larguraColunas[0],4, substr( $lista[$indx][2], 0, 29 ),
					    "LR", 0, "L", $flagPreenchido );
				$relatorio->document->Cell( $larguraColunas[1],4, $lista[$indx][1],
					    "LR", 0, "C", $flagPreenchido );
				$relatorio->document->Cell( $larguraColunas[2],4, substr( $lista[$indx][3], 0, 40 ),
					    "LR", 0, "L", $flagPreenchido );
				$relatorio->document->Cell( $larguraColunas[3],4, $lista[$indx][5],
					    "LR", 0, "C", $flagPreenchido );
				$relatorio->document->Cell( $larguraColunas[4],4, $listaClassificacao[ $lista[$indx][6] ],
					    "LR", 0, "C", $flagPreenchido );
				$relatorio->document->Cell( $larguraColunas[5],4, $listaCredora[ $lista[$indx][8] ],
					    "LR", 0, "C", $flagPreenchido );
				$relatorio->document->Cell( $larguraColunas[6],4, $listaCredora[ $lista[$indx][7] ],
					    "LR", 0, "C", $flagPreenchido );

				// Salta linha...
				$relatorio->document->Ln();

				// Incrementa linha...
				$controleLinha++;

				// Se terminou pagina...

				} // Fim do indx


		$relatorio->document->closeDoc( "../pdfs/".PDF_PLANO_CONTAS );

		// Exibe mensagem...
		$msg = new MsgCw( $msgCliqueAquiParaVisualizar,
		       "../imagens/contabil.jpg", "javascript:history.go(-2);" );
		$msg->mostraMsgLink( "../pdfs/".PDF_PLANO_CONTAS, true );
		exit();

	}

    /**
	*	copiaPlanoContas( $oidEmpresaOrigem, $oidEmpresaDestino )
	*	Copia o plano de contas de uma empresa para outra.
	*   @param  $oidEmpresaOrigem    OID da empresa de Origem
	*	@param	$oidEmpresaDestino   OID da empresa de Destino
	*/
	function copiaPlanoContas( $oidEmpresaOrigem, $oidEmpresaDestino ) {

		// Instancia objetos, seta atributos...
		$empresa	   = new Empresa();

		$listaOrigem	    = $this->buscaConta( $oidEmpresaOrigem, "", 3 );
		$listaDestino       = $this->buscaConta( $oidEmpresaDestino,"", 3 );
        
        if ( sizeof($listaDestino) > 1)   // Se ja existem contas cadastradas
           return false;

        $contaDestino = new Conta();
        // Comeca laco para copia das contas
        for ( $indx = 0; $indx < sizeof( $listaOrigem ); $indx++ ) {

  			    $codigoSintetico = $listaOrigem[$indx][2];
				$descricao       = $listaOrigem[$indx][3];
				$classificacao   = $listaOrigem[$indx][6];
                $natureza        = $listaOrigem[$indx][5];
                $tipo            = $listaOrigem[$indx][4];
                $podeCredora     = $listaOrigem[$indx][8];
                $podeDevedora    = $listaOrigem[$indx][7];
                
   				$contaDestino->setConta( $oidEmpresaDestino, $codigoSintetico, $descricao, $natureza, 
						$tipo, $classificacao, $podeCredora, $podeDevedora, $oidContaDoar );

				// Verifica se gravou
				if ( !$contaDestino->grava() )
					return false;
 
  	 	} // Fim do for indx...


		     return true;

	}
	
    /**
	*	atualizaDV ($oidConta)
	*	Atualiza o Dígito de Verificação da Conta
	*   @param  $oidConta            Código de Acesso, sem digito
	*/
	function atualizaDV( $oidConta ) {

	    $this->persistence->setDV(Numero::modulo11($oidConta));
        $this->persistence->updateDV($oidConta);
		
	}

}

?>
