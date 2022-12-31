<?php
include "cwTest.inc";

class ContaTest extends TestCase {

  var $test;
  function ContaTest( $nome ) {
    $this->TestCase( $nome );
  }

  function setUp() {

    $this->test = new Conta();
    $this->test->setConta( 1, "1.1", "caixa", "C", "S", "R", "S", "S", "0" );

  }

  function testGetOidEmpresaCont() {

    $this->assertEquals( 1, $this->test->getOidEmpresaCont() );

  }

  function testGetDescricao() {

    $this->assertEquals( "CAIXA", $this->test->getDescricao() );

  }

  function testGetCodigoSintetico() {

    $this->assertEquals( "1.1", $this->test->getCodigoSintetico() );

  }

  function testGetOidConta() {

	$this->test->setOidConta( "1" );  
    $this->assertEquals( "1", $this->test->getOidConta() );

  }

  function testGetDV() {

	$this->test->setDV( "9" );  
    $this->assertEquals( "9", $this->test->getDV() );

  }

  function testGetOidContaDV() {

	$this->test->setOidContaDV( "1.9" );  
    $this->assertEquals( "1.9", $this->test->getOidContaDV() );

  }

  function testGetNatureza() {

    $this->assertEquals( "C", $this->test->getNatureza() );

  }

  function testGetTipo() {

    $this->assertEquals( "S", $this->test->getTipo() );

  }

  function testGetClassificacao() {

    $this->assertEquals( "R", $this->test->getClassificacao() );

  }
  
  function testGetDevedora() {

    $this->assertEquals( "S", $this->test->getDevedora() );

  }

  function testGetCredora() {

    $this->assertEquals( "S", $this->test->getCredora() );

  }
  
}

class ContaProxy {

}

?>

