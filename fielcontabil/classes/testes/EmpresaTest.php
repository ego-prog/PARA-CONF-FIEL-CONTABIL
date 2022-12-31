<?php
include "cwTest.inc";

class EmpresaTest extends TestCase {

  var $test;
  function EmpresaTest( $nome ) {
    $this->TestCase( $nome );
  }

  function setUp() {

    $this->test = new Empresa();
    $this->test->setEmpresa( 1, "Teste de empresa", "04.273.288/0001-29", "12345", "54321",
             "Barros Cassal, 531/206", "Bom Fim", "POA", "90035-190", "RS", "apoena@smic.prefpoa.com.br",
             "16/10/2003", "17/10/2003", "Carmen Delia Branco", "CRC 101133", "Guilherme Lacerda", "97516651087",
             "99.99.99.99", "9.9.999", 0 );


  }

  function testGetOidEmpresa() {

    $this->assertEquals( 1, $this->test->getOidEmpresa() );

  }

  function testGetRazaoSocial() {

    $this->assertEquals( "TESTE DE EMPRESA", $this->test->getRazaoSocial() );

  }

  function testGetCnpj() {

    $this->assertEquals( "04.273.288/0001-29", $this->test->getCnpj() );

  }

  function testGetInscricaoEstadual() {

    $this->assertEquals( "12345", $this->test->getInscricaoEstadual() );

  }

  function testGetInscricaoMunicipal() {

    $this->assertEquals( "54321", $this->test->getInscricaoMunicipal() );

  }

  function testGetEndereco() {

    $this->assertEquals( "BARROS CASSAL, 531/206", $this->test->getEndereco() );

  }

  function testGetBairro() {

    $this->assertEquals( "BOM FIM", $this->test->getBairro() );

  }

  function testGetCidade() {

    $this->assertEquals( "POA", $this->test->getCidade() );

  }

  function testGetUf() {

    $this->assertEquals( "RS", $this->test->getUf() );

  }

  function testGetEmail() {

    $this->assertEquals( "apoena@smic.prefpoa.com.br", $this->test->getEmail() );

  }

  function testGetDataInicial() {

    $this->assertEquals( "16/10/2003", $this->test->getDataInicial() );

  }

  function testGetDataFinal() {

    $this->assertEquals( "17/10/2003", $this->test->getDataFinal() );

  }

  function testGetNomeContador() {

    $this->assertEquals( "CARMEN DELIA BRANCO", $this->test->getNomeContador() );

  }

  function testGetRegistroContador() {

    $this->assertEquals( "CRC 101133", $this->test->getRegistroContador() );

  }

  function testGetResponsavel() {

    $this->assertEquals( "GUILHERME LACERDA", $this->test->getResponsavel() );

  }

  function testGetCpfResponsavel() {

    $this->assertEquals( "97516651087", $this->test->getCpfResponsavel() );

  }

  function testGetMascaraPlano() {

    $this->assertEquals( "99.99.99.99", $this->test->getMascaraPlano() );

  }

  function testGetMascaraDoar() {

    $this->assertEquals( "9.9.999", $this->test->getMascaraDoar() );

  }

}

class EmpresaProxy {

}

?>

