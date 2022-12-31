<?PHP

/**
*
*   Testes de unidade com phpUnit
*
*   Data de Criacao: 20/04/2003
*   Ultima Atualizacao: 10/04/2003
*   Modulo: cwTest.inc
*       Teste de unidade de classes com phpUnit
*
*   Copyright (C) por APOENA Solucoes em Software Livre
*   http://www.apoenasoftwarelivre.com.br
*
*   @author     Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*   @version    PHP3 & PHP4
*/

// ---------------------------------------------------------------------------
// PATH da aplicação
// ---------------------------------------------------------------------------
// Verifica diretorio para direcionamento do PATH
$dirAtualPath = dirname( $PHP_SELF );

// O Path na fabrica é /contabil...
if ( $dirAtualPath == "/contabil/admin" || $dirAtualPath == "/contabil/supervisao" || $dirAtualPath == "/contabil/operacao"
        || $dirAtualPath == "/contabil/classes/persistencia"
        || $dirAtualPath == "/contabil/classes/relatorio" || $dirAtualPath == "/contabil/classes/componente"
        || $dirAtualPath == "/contabil/classes/testes"
        || $dirAtualPath == "/contabil/classes/servicos" )
    $pathClasses = "../";
else
    $pathClasses = "./classes/";

// Framework phpUnit
include_once "PHPUnit.php";

// Componente de Numero
@include_once "../componente/Numero.php";

// Componente de String
@include_once "../componente/String.php";

// Classe Empresa
// Nao esquecer... Quando for definir uma classe de negocio para teste, deve-se criar
// uma referencia para a classe "Proxy", dentro do proprio arquivo
@include_once "../Empresa.php";

// Classe de teste (Empresa)
include_once "EmpresaTest.php";

// Classe Termo
@include_once "../Termo.php";

// Classe de teste (Termo)
include_once "TermoTest.php";

// Classe Nota
@include_once "../Nota.php";

// Classe Conta DOAR
@include_once "../ContaDoar.php";

// Classe de teste (Conta DOAR)
include_once "ContaDoarTest.php";

// Classe Historico Padrao
@include_once "../HistoricoPadrao.php";

// Classe de teste (Historico Padrao)
include_once "HistoricoPadraoTest.php";

// Classe Conta
@include_once "../Conta.php";

// Classe de teste (Conta)
include_once "ContaTest.php";

// Classe Orcamento
@include_once "../Orcamento.php";

// Classe de teste (Orcamento)
include_once "OrcamentoTest.php";

// Classe Zeramento
@include_once "../Zeramento.php";

// Classe de teste (Zeramento)
include_once "ZeramentoTest.php";

// Classe Lancamento
@include_once "../Lancamento.php";

// Classe de teste (Lancamento)
include_once "LancamentoTest.php";

// Classe Item de Lancamento
@include_once "../ItemLancamento.php";

// Classe de teste (Item de Lancamento)
include_once "ItemLancamentoTest.php";

?>
