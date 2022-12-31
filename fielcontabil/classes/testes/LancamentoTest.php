<?php
include "cwTest.inc";

class LancamentoTest extends TestCase {

  var $test;
  function LancamentoTest( $nome ) {
    $this->TestCase( $nome );
  }

  function setUp() {

	$this->test = new Lancamento();
    $this->test->setLancamento( 1, "16/10/2003", "26/11/2003", "03:00:00", 
			"guilherm", "N" );
	$this->test->setAberto( "S" );
	$this->test->setLiberaLancamento( 275, "26/10/2003", "03:00:00", "carmem", "S" );  
 
  }

  function testGetOidLancamento() {

    $this->assertEquals( 275, $this->test->getOidLancamento() );

  }

  function testGetOidEmpresaCont() {

    $this->assertEquals( 1, $this->test->getOidEmpresaCont() );

  }

  function testGetDataLancamento() {

    $this->assertEquals( "16/10/2003", $this->test->getDataLancamento() );

  }

  function testGetDataDigitacao() {

    $this->assertEquals( "26/11/2003", $this->test->getDataDigitacao() );

  }

  function testGetHoraDigitacao() {

    $this->assertEquals( "03:00:00", $this->test->getHoraDigitacao() );

  }
  
  function testGetLoginOperador() {

    $this->assertEquals( "guilherm", $this->test->getLoginOperador() );

  }

  function testGetDataLiberacao() {

    $this->assertEquals( "26/10/2003", $this->test->getDataLiberacao() );

  }

  function testGetHoraLiberacao() {

    $this->assertEquals( "03:00:00", $this->test->getHoraLiberacao() );

  }

  function testGetLoginSupervisor() {

    $this->assertEquals( "carmem", $this->test->getLoginSupervisor() );

  }
  
  function testGetAberto() {

    $this->assertEquals( "S", $this->test->getAberto() );

  }

  function testGetContabilizado() {

    $this->assertEquals( "S", $this->test->getContabilizado() );

  }
  
}

class LancamentoProxy {

}

?>

