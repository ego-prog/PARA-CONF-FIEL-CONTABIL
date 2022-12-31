<?php
include "cwTest.inc";

class ContaDoarTest extends TestCase {

  var $test;
  function ContaDoarTest( $nome ) {
    $this->TestCase( $nome );
  }

  function setUp() {

    $this->test = new ContaDoar();
    $this->test->setContaDoar( 1, "Lucros e Dividendos", "A" );


  }

  function testGetOidEmpresaCont() {

    $this->assertEquals( 1, $this->test->getOidEmpresaCont() );

  }

  function testGetDescricao() {

    $this->assertEquals( "LUCROS E DIVIDENDOS", $this->test->getDescricao() );

  }

  function testGetTipo() {

    $this->assertEquals( "A", $this->test->getTipo() );

  }

}

class ContaDoarProxy {

}

?>

