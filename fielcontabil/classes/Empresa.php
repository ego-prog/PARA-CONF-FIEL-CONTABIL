<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 17/10/2003
*	Modulo: Empresa.php
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
*	Empresa
*
*	Classe que contem as principais definicoes de empresas
*	que registram sua contabilidade no Contabil Web
*
*/
class Empresa {

	var $oidEmpresaCont;	  // OID da empresa que utilizara a contabilidade
	var $oidEmpresa;	      // Codigo da empresa (proprietaria)
	var $razaoSocial;	       // Razao social
	var $cnpj;			  // CNPJ
	var $inscricaoEstadual;   // Inscricao estadual
	var $inscricaoMunicipal;  // Inscricao municipal
	var $endereco;		      // Endereco
	var $bairro;		      // Bairro
	var $cidade;		      // Cidade
	var $cep;			  // CEP
	var $uf;			  // UF
	var $eMail;			  // e-mail
	var $dataInicial;	      // data inicial
	var $dataFinal; 	      // data final
	var $nomeContador;	      // nome do contador
	var $registroContador;	  // registro contador
	var $responsavel;	      // responsavel pela empresa
	var $cpfResponsavel;	  // CPF do responsavel pela empresa
	var $mascaraPlano;	      // Mascara do plano
	var $mascaraDoar;	      // Mascara DOAR
    var $codigoCaixa;	      // Código da Conta Caixa
	var $persistence;	      // Utilizado para persistencia dos objetos
	/**
	*  Empresa()
	*  Construtor da classe
	*/
	function Empresa() {

		$this->persistence = new EmpresaProxy();

	}

	/**
	*	setEmpresa( $oidEmpresa, $razaoSocial, $cnpj, $inscricaoEstadual, $inscricaoMunicipal,
	*		$endereco, $bairro, $cidade, $cep, $uf, $eMail, $dataInicial, $dataFinal,
	*		$nomeContador, $registroContador, $responsavel, $cpfResponsavel, $mascaraPlano, $mascaraDoar, $codigoCaixa )
	*	Recebe os dados para manipulacao
	*	@param $oidEmpresa	       OID da empresa
	*	@param $razaoSocial	       Razao social
	*	@param $cnpj		       CNPJ
	*	@param $inscricaoEstadual      Inscricao estadual
	*	@param $inscricaoMunicipal     Inscricao Municipal
	*	@param $endereco	       Endereco
	*	@param $bairro		       Bairro
	*	@param $cidade		       Cidade
	*	@param $cep		       CEP
	*	@param $uf		       UF
	*	@param $eMail		       e-mail
	*	@param $dataInicial	       Data inicial
	*	@param $dataFinal	       Data final
	*	@param $nomeContador	       Nome do contador
	*	@param $registroContador       Registro do contador
	*	@param $responsavel	       Responsavel pela empresa
	*	@param $cpfResponsavel	       CPF do responsavel
	*	@param $mascaraPlano	       Mascara plano
	*	@param $mascaraDoar	       Mascara DOAR
	*   @param $codigoCaixa        Código da Conta Caixa
	*/
	function setEmpresa( $oidEmpresa, $razaoSocial, $cnpj, $inscricaoEstadual, $inscricaoMunicipal,
	     $endereco, $bairro, $cidade, $cep, $uf, $eMail, $dataInicial, $dataFinal,
	     $nomeContador, $registroContador, $responsavel, $cpfResponsavel, $mascaraPlano, $mascaraDoar, $codigoCaixa ) {

		$this->setOidEmpresa( $oidEmpresa );
		$this->setRazaoSocial( $razaoSocial );
		$this->setCnpj( $cnpj );
		$this->setInscricaoEstadual( $inscricaoEstadual );
		$this->setInscricaoMunicipal( $inscricaoMunicipal );
		$this->setEndereco( $endereco );
		$this->setBairro( $bairro );
		$this->setCidade( $cidade );
		$this->setCep( $cep );
		$this->setUf( $uf );
		$this->setEmail( $eMail );
		$this->setDataInicial( $dataInicial );
		$this->setDataFinal( $dataFinal );
		$this->setNomeContador( $nomeContador );
		$this->setRegistroContador( $registroContador );
		$this->setResponsavel( $responsavel );
		$this->setCpfResponsavel( $cpfResponsavel );
		$this->setMascaraPlano( $mascaraPlano );
		$this->setMascaraDoar( $mascaraDoar );
		$this->setCodigoCaixa( $codigoCaixa );

	}

	/**
	*	setOidEmpresa( $oidEmpresa )
	*	Recebe OID de empresa
	*	@param $oidEmpresa   OID da empresa
	*/
	function setOidEmpresa( $oidEmpresa ) {

		$this->oidEmpresa = $oidEmpresa;

	}

	/**
	*	getOidEmpresa()
	*	Retorna OID de empresa
	*	@return $oidEmpresa    OID da empresa
	*/
	function getOidEmpresa() {

		return $this->oidEmpresa;

	}

	/**
	*	setOidEmpresaCont( $oidEmpresaCont )
	*	Recebe OID de empresa contabil
	*	@param $oidEmpresaCont	 OID da empresa contabil
	*/
	function setOidEmpresaCont( $oidEmpresaCont ) {

		$this->oidEmpresaCont = $oidEmpresaCont;

	}

	/**
	*	getOidEmpresaCont()
	*	Retorna OID de empresa contabil
	*	@return $oidEmpresaCont    OID da empresa contabil
	*/
	function getOidEmpresaCont() {

		return $this->oidEmpresaCont;

	}

	/**
	*	setRazaoSocial( $razaoSocial )
	*	Recebe razao social
	*	@param $razaoSocial	   razao social
	*/
	function setRazaoSocial( $razaoSocial ) {

		$this->razaoSocial = trim( String::upper( $razaoSocial ) );

	}

	/**
	*	getRazaoSocial()
	*	Retorna razao social
	*	@return $razaoSocial	   razao social
	*/
	function getRazaoSocial() {

		return $this->razaoSocial;

	}

	/**
	*	setCnpj( $cnpj )
	*	Recebe CNPJ
	*	@param $cnpj	CNPJ
	*/
	function setCnpj( $cnpj ) {

		$this->cnpj = trim( String::upper( $cnpj ) );

	}

	/**
	*	getCnpj()
	*	Retorna CNPJ
	*	@return $cnpj	    CNPJ
	*/
	function getCnpj() {

		return $this->cnpj;

	}

	/**
	*	setInscricaoEstadual( $inscricaoEstadual )
	*	Recebe inscricao estadual
	*	@param $inscricaoEstadual	 inscricao estadual
	*/
	function setInscricaoEstadual( $inscricaoEstadual ) {

		$this->inscricaoEstadual = trim( String::upper( $inscricaoEstadual ) );

	}

	/**
	*	getInscricaoEstadual()
	*	Retorna inscricao estadual
	*	@return $inscricaoEstadual	 inscricao estadual
	*/
	function getInscricaoEstadual() {

		return $this->inscricaoEstadual;

	}

	/**
	*	setInscricaoMunicipal( $inscricaoMunicipal )
	*	Recebe inscricao municipal
	*	@param $inscricaoMunicipal	  inscricao municipal
	*/
	function setInscricaoMunicipal( $inscricaoMunicipal ) {

		$this->inscricaoMunicipal = trim( String::upper( $inscricaoMunicipal ) );

	}

	/**
	*	getInscricaoMunicipal()
	*	Retorna inscricao municipal
	*	@return $inscricaoMunicipal	  inscricao municipal
	*/
	function getInscricaoMunicipal() {

		return $this->inscricaoMunicipal;

	}

	/**
	*	setEndereco( $endereco )
	*	Recebe endereco
	*	@param $endereco	endereco
	*/
	function setEndereco( $endereco ) {

		$this->endereco = trim( String::upper( $endereco ) );

	}

	/**
	*	getEndereco()
	*	Retorna endereco
	*	@return $endereco	endereco
	*/
	function getEndereco() {

		return $this->endereco;

	}

	/**
	*	setBairro( $bairro )
	*	Recebe bairro
	*	@param $bairro	      bairro
	*/
	function setBairro( $bairro ) {

		$this->bairro = trim( String::upper( $bairro ) );

	}

	/**
	*	getBairro()
	*	Retorna bairro
	*	@return $bairro       bairro
	*/
	function getBairro() {

		return $this->bairro;

	}

	/**
	*	setCidade( $cidade )
	*	Recebe cidade
	*	@param $cidade	      cidade
	*/
	function setCidade( $cidade ) {

		$this->cidade = trim( String::upper( $cidade ) );

	}

	/**
	*	getCidade()
	*	Retorna cidade
	*	@return $cidade       cidade
	*/
	function getCidade() {

		return $this->cidade;

	}

	/**
	*	setCep( $cep )
	*	Recebe CEP
	*	@param $cep   CEP
	*/
	function setCep( $cep ) {

		$this->cep = trim( String::upper( $cep ) );

	}

	/**
	*	getCep()
	*	Retorna CEP
	*	@return $cep	   CEP
	*/
	function getCep() {

		return $this->cep;

	}

	/**
	*	setUf( $uf )
	*	Recebe UF
	*	@param $uf	  UF
	*/
	function setUf( $uf ) {

		$this->uf = trim( String::upper( $uf ) );

	}

	/**
	*	getUf()
	*	Retorna UF
	*	@return $uf	  UF
	*/
	function getUf() {

		return $this->uf;

	}

	/**
	*	setEmail( $eMail )
	*	Recebe e-mail
	*	@param $eMail	e-mail da empresa
	*/
	function setEmail( $eMail ) {

		$this->eMail = strtolower( $eMail );

	}

	/**
	*	getEmail()
	*	Retorna e-mail da empresa
	*	@return $eMail		e-mail da empresa
	*/
	function getEmail() {

		return $this->eMail;

	}

	/**
	*	setDataInicial( $dataInicial )
	*	Recebe data inicial
	*	@param $dataInicial	     data inicial
	*/
	function setDataInicial( $dataInicial ) {

		$this->dataInicial = trim( $dataInicial );

	}

	/**
	*	getDataInicial()
	*	Retorna data inicial
	*	@return $dataInicial	   data inicial
	*/
	function getDataInicial() {

		return $this->dataInicial;

	}

	/**
	*	setDataFinal( $dataFinal )
	*	Recebe data final
	*	@param $dataFinal	 data final
	*/
	function setDataFinal( $dataFinal ) {

		$this->dataFinal = trim( $dataFinal );

	}

	/**
	*	getDataFinal()
	*	Retorna data final
	*	@return $dataFinal	 data final
	*/
	function getDataFinal() {

		return $this->dataFinal;

	}

	/**
	*	setNomeContador( $nomeContador )
	*	Recebe nome do contador
	*	@param $nomeContador   nome do contador
	*/
	function setNomeContador( $nomeContador ) {

		$this->nomeContador = trim( String::upper( $nomeContador ) );

	}

	/**
	*	getNomeContador()
	*	Retorna nome do contador
	*	@return $nomeContador	nome do contador
	*/
	function getNomeContador() {

		return $this->nomeContador;

	}

	/**
	*	setRegistroContador( $registroContador )
	*	Recebe registro do contador
	*	@param $registroContador   registro do contador
	*/
	function setRegistroContador( $registroContador ) {

		$this->registroContador = trim( String::upper( $registroContador ) );

	}

	/**
	*	getRegistroContador()
	*	Retorna registro de contador
	*	@return $registroContador	registro do contador
	*/
	function getRegistroContador() {

		return $this->registroContador;

	}

	/**
	*	setResponsavel( $responsavel )
	*	Recebe responsavel
	*	@param $responsavel		responsavel pela empresa
	*/
	function setResponsavel( $responsavel ) {

		$this->responsavel = trim( String::upper( $responsavel ) );

	}

	/**
	*	getResponsavel()
	*	Retorna nome do responsavel pela empresa
	*	@return $responsavel	  responsavel pela empresa
	*/
	function getResponsavel() {

		return $this->responsavel;

	}

	/**
	*	setCpfResponsavel( $cpfResponsavel )
	*	Recebe CPF do responsavel
	*	@param $cpfResponsavel		   CPF do responsavel pela empresa
	*/
	function setCpfResponsavel( $cpfResponsavel ) {

		$this->cpfResponsavel = trim( String::upper( $cpfResponsavel ) );

	}

	/**
	*	getCpfResponsavel()
	*	Retorna CPF do responsavel pela empresa
	*	@return $cpfResponsavel      CPF do responsavel pela empresa
	*/
	function getCpfResponsavel() {

		return $this->cpfResponsavel;

	}

	/**
	*	setMascaraPlano( $mascaraPlano )
	*	Recebe mascara do plano de contas
	*	@param $mascaraPlano		 mascara do plano
	*/
	function setMascaraPlano( $mascaraPlano ) {

		$this->mascaraPlano = trim( $mascaraPlano );

	}

	/**
	*	getMascaraPlano()
	*	Retorna mascara do plano de contas
	*	@return $mascaraPlano	   mascara do plano
	*/
	function getMascaraPlano() {

		return $this->mascaraPlano;

	}

	/**
	*	setMascaraDoar( $mascaraDoar )
	*	Recebe mascara do plano de contas DOAR
	*	@param $mascaraDoar		mascara do plano DOAR
	*/
	function setMascaraDoar( $mascaraDoar ) {

		$this->mascaraDoar = trim( $mascaraDoar );

	}

	/**
	*	getCodigoCaixa()
	*	Retorna o codigo da conta caixa da empresa
	*	@return $codigoCaixa	  codigo da conta caixa
	*/
	function getCodigoCaixa() {

		return $this->codigoCaixa;

	}

		/**
	*	setCodigoCaixa( $codigoCaixa )
	*	Recebe codigo da conta caixa da empresa
	*	@param $codigoCaixa		codigo da conta caixa
	*/
	function setCodigoCaixa( $codigoCaixa ) {

		$this->codigoCaixa = trim( $codigoCaixa );

	}

	/**
	*	getMascaraDoar()
	*	Retorna mascara do plano de contas DOAR
	*	@return $mascaraDoar	  mascara do plano DOAR
	*/
	function getMascaraDoar() {

		return $this->mascaraDoar;

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
		$this->persistence->setObject( $this->getOidEmpresa(), $this->getRazaoSocial(),
				$this->getCnpj(), $this->getInscricaoEstadual() , $this->getInscricaoMunicipal(),
				$this->getEndereco(), $this->getBairro(), $this->getCidade(), $this->getCep(),
				$this->getUf(), $this->getEmail(), $this->getDataInicial(), $this->getDataFinal(),
				$this->getNomeContador(), $this->getRegistroContador(), $this->getResponsavel(),
				$this->getCpfResponsavel(), $this->getMascaraPlano(), $this->getMascaraDoar(), $this->getCodigoCaixa() );

		// Se for inclusão...
		if ( $operacao )
			$flagGravou = $this->persistence->save();
		// se for alteracao...
		else
			$flagGravou = $this->persistence->update( $this->getOidEmpresaCont() );

		return $flagGravou;

	}

	/**
	*	pesquisaEmpresa( $oidEmpresaCont )
	*	Retorna empresa encontrada
	*	@return true se encontrou empresa por OID
	*/
	function pesquisaEmpresa( $oidEmpresaCont ) {

		// Seta variaveis utilizada no metodo
		$flagAchou = false;

		if ( $this->persistence->findByOid( $oidEmpresaCont ) ) {
		   $flagAchou = true;

		   // Retorna objeto
		   $objetoAtual = $this->persistence->getObject();

		   // Seta atributos
		   $this->setOidEmpresaCont( $objetoAtual[0] );
		   $this->setOidEmpresa( $objetoAtual[1] );
		   $this->setRazaoSocial( $objetoAtual[2] );
		   $this->setCnpj( $objetoAtual[3] );
		   $this->setInscricaoEstadual( $objetoAtual[4] );
		   $this->setInscricaoMunicipal( $objetoAtual[5] );
		   $this->setEndereco( $objetoAtual[6] );
		   $this->setBairro( $objetoAtual[7] );
		   $this->setCidade( $objetoAtual[8] );
		   $this->setCep( $objetoAtual[9] );
		   $this->setUf( $objetoAtual[10] );
		   $this->setEmail( $objetoAtual[11] );
		   $this->setDataInicial( $objetoAtual[12] );
		   $this->setDataFinal( $objetoAtual[13] );
		   $this->setNomeContador( $objetoAtual[14] );
		   $this->setRegistroContador( $objetoAtual[15] );
		   $this->setResponsavel( $objetoAtual[16] );
		   $this->setCpfResponsavel( $objetoAtual[17] );
		   $this->setMascaraPlano( $objetoAtual[18] );
		   $this->setMascaraDoar( $objetoAtual[19] );
		   $this->setCodigoCaixa( $objetoAtual[20] );

		}

		// Retorna se encontrou empresa...
		return $flagAchou;

	}

	/**
	*	buscaEmpresa( $oidEmpresa, $expressao, $operacao = 1 )
	*	Retorna todas as empresas
	*	@param	$oidEmpresa		OID da empresa
	*	@param	$expressao		Expressao de busca
	*	@param	$operacao	Tipo de pesquisa a ser realizada
	*	@return $empresas		empresas encontradas
	*/
	function buscaEmpresa( $oidEmpresa, $expressao, $operacao = 1, $loginUsuario = "" ) {

		// Pesquisa empresas por criterio de selecao...
		$this->persistence->search( $oidEmpresa, $expressao, $operacao, $loginUsuario );

		// retorna empresas encontradas...
		return $this->persistence->getList();

	}

	/**
	*	exclui()
	*	Exclui empresa
	*/
	function exclui() {

		// Exclui empresa...
		return $this->persistence->delete( $this->getOidEmpresaCont() );

	}

}

?>
