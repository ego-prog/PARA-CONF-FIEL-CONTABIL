<?

// Suite de testes de classes de negocio
include "cwTest.inc";

echo "<center><h1>Suite de testes de classes de negócio utilizando phpUnit<br>";
echo "<h2>Projeto Contábil Web</center>";

$suite = new TestSuite();

// Teste de empresa
$suite->addTest( new TestSuite( "EmpresaTest" ) );

// Teste de termo
$suite->addTest( new TestSuite( "TermoTest" ) );

// Teste de Nota
$suite->addTest( new TestSuite( "NotaTest" ) );

// Teste de Conta DOAR
$suite->addTest( new TestSuite( "ContaDoarTest" ) );

// Teste de Historico Padrao
$suite->addTest( new TestSuite( "HistoricoPadraoTest" ) );

// Teste de Conta
$suite->addTest( new TestSuite( "ContaTest" ) );

// Teste de Orcamento Anual
$suite->addTest( new TestSuite( "OrcamentoTest" ) );

// Teste de Zeramento
$suite->addTest( new TestSuite( "ZeramentoTest" ) );

// Teste de Lancamento
$suite->addTest( new TestSuite( "LancamentoTest" ) );

// Teste de Item de Lancamento
$suite->addTest( new TestSuite( "ItemLancamentoTest" ) );

// Roda suite de testes...
TestRunner::run( $suite );

echo "<hr>";

?>
