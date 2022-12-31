<?php
include "cwTest.inc";

class OrcamentoTest extends TestCase {

  var $test;
  function OrcamentoTest( $nome ) {
    $this->TestCase( $nome );
  }

  function setUp() {

	$valorPrevisto = array( 20.0, 0.0, 6.50, 45.20, 50, 60, 70, 0, 0, 10, 0, 120 );   
    $this->test = new Orcamento();
    $this->test->setOrcamento( "7.8", 2003, $valorPrevisto ); 
 
  }

  function testGetOidConta() {

    $this->assertEquals( "7.8", $this->test->getOidConta() );

  }

  function testGetDV() {

	$codigoConta = explode( ".", $this->test->getOidConta() );
	$dv = Numero::modulo11( $codigoConta[0] );
    $this->assertEquals( (integer)$dv, (integer)$codigoConta[1] );

  }

  function testGetAno() {

    $this->assertEquals( 2003, (integer)$this->test->getAno() );

  }

  function testGetPrevistoMes() {
	  
	  $valorPrevisto = array( 20.0, 0.0, 6.50, 45.20, 50, 60, 70, 0, 0, 10, 0, 120 );

	  for ( $indx = 0; $indx < sizeof( $valorPrevisto ); $indx++ )
	  	$this->assertEquals( (double)$valorPrevisto[$indx], (double)$this->test->getPrevistoMes( $indx ) );

  }

  function testGetPrevisto() {
	  
	  $valorPrevisto = array( 20.0, 0.0, 6.50, 45.20, 50, 60, 70, 0, 0, 10, 0, 120 );

	  $this->assertEquals( $valorPrevisto, $this->test->getPrevisto() );

  }
  
}

class OrcamentoProxy {

}

?>

