<?php
include "cwTest.inc";

class ZeramentoTest extends TestCase {

  var $test;
  function ZeramentoTest( $nome ) {
    $this->TestCase( $nome );
  }

  function setUp() {

	$this->test = new Zeramento();
    $this->test->setZeramento( "7", "2", 
					"7", "3", "8", "5", "6" ); 
 
  }

  function testGetOidEmpresaCont() {

    $this->assertEquals( "7", $this->test->getOidEmpresaCont() );

  }

  function testGetContrapartida() {

    $this->assertEquals( "2", $this->test->getContrapartida() );

  }

  function testGetGrupo1() {
	  
	  	$this->assertEquals( "7", $this->test->getGrupo1() );

  }

  function testGetGrupo2() {
	  
	  	$this->assertEquals( "3", $this->test->getGrupo2() );
		
  }

  function testGetGrupo3() {
	  
	  	$this->assertEquals( "8", $this->test->getGrupo3() );

  }
  
  function testGetGrupo4() {
	  
	  	$this->assertEquals( "5", $this->test->getGrupo4() );

  }

  function testGetGrupo5() {
	  
	  	$this->assertEquals( "6", $this->test->getGrupo5() );

  }
  
}

class ZeramentoProxy {

}

?>

