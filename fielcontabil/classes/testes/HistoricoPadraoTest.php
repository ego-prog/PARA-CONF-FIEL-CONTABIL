<?php
include "cwTest.inc";

class HistoricoPadraoTest extends TestCase {

  var $test;
  function HistoricoPadraoTest( $nome ) {
    $this->TestCase( $nome );
  }

  function setUp() {

    $this->test = new HistoricoPadrao();
    $this->test->setHistoricoPadrao( 1, "historico padrao de exemplo" );


  }

  function testGetOidEmpresaCont() {

    $this->assertEquals( 1, $this->test->getOidEmpresaCont() );

  }

  function testGetOidHistorico() {

	$this->test->setOidHistorico( 1 );
    $this->assertEquals( 1, $this->test->getOidHistorico() );

  }

  function testGetHistorico() {

    $this->assertEquals( "HISTORICO PADRAO DE EXEMPLO", $this->test->getHistorico() );

  }

  
}

class HistoricoPadraoProxy {

}

?>

