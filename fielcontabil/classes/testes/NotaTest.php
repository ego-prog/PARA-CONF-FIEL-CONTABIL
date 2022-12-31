<?php
include "cwTest.inc";

class NotaTest extends TestCase {

  var $test;
  function NotaTest( $nome ) {
    $this->TestCase( $nome );
  }

  function setUp() {

    $this->test = new Nota();
    $this->test->setNotaExplicativa( 1, "Nota explicativa de exemplo" );


  }

  function testGetOidEmpresaCont() {

    $this->assertEquals( 1, $this->test->getOidEmpresaCont() );

  }

  function testGetOidNota() {

	$this->test->setOidNota( 1 );
    $this->assertEquals( 1, $this->test->getOidNota() );

  }

  function testGetNota() {

    $this->assertEquals( "Nota explicativa de exemplo", $this->test->getNota() );

  }

  
}

class NotaProxy {

}

?>

