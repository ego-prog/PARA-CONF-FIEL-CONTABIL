<?php
include "cwTest.inc";

class ItemLancamentoTest extends TestCase {

  var $test;
  function ItemLancamentoTest( $nome ) {
    $this->TestCase( $nome );
  }

  function setUp() {

	$this->test = new ItemLancamento();
    $this->test->setItemLancamento( 1, 6, "Pagamento de conta de luz", 50.50, 
			"D", 0 );
	$this->test->setOidItemLancamento( 1 );
  }

  function testGetOidLancamento() {

    $this->assertEquals( 1, $this->test->getOidLancamento() );

  }

  function testGetOidItemLancamento() {

    $this->assertEquals( 1, $this->test->getOidItemLancamento() );

  }

  function testGetOidConta() {

    $this->assertEquals( 6, $this->test->getOidConta() );

  }

  function testGetHistorico() {

    $this->assertEquals( "PAGAMENTO DE CONTA DE LUZ", $this->test->getHistorico() );

  }

  function testGetValor() {

    $this->assertEquals( (double)50.50, (double)$this->test->getValor() );

  }
  
  function testGetOperacao() {

    $this->assertEquals( "D", $this->test->getOperacao() );

  }

  function testGetOidZeramento() {

    $this->assertEquals( 0, $this->test->getOidZeramento() );

  }

}

class ItemLancamentoProxy {

}

?>

