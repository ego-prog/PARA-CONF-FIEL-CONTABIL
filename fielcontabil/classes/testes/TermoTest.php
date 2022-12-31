<?php
include "cwTest.inc";

class TermoTest extends TestCase {

  var $test;
  function TermoTest( $nome ) {
    $this->TestCase( $nome );
  }

  function setUp() {

    $this->test = new Termo();
    $this->test->setTermo( 1, "Teste de empresa", "texto a ser incluido", "I" );


  }

  function testGetOidEmpresaCont() {

    $this->assertEquals( 1, $this->test->getOidEmpresaCont() );

  }

  function testGetDescricao() {

    $this->assertEquals( "TESTE DE EMPRESA", $this->test->getDescricao() );

  }

  function testGetTexto() {

    $this->assertEquals( "texto a ser incluido", $this->test->getTexto() );

  }

  function testGetLocalizacao() {

    $this->assertEquals( "I", $this->test->getLocalizacao() );

  }

}

class TermoProxy {

}

?>

