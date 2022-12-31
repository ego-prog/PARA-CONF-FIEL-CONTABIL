<?PHP
$pathClasses = ".";
include "framework_persistencia.inc";

class Teste1Proxy extends Proxy {


	function getBroker() {

		return BD_MySQL;
	}

	function testa() {

		$objeto = $this->criaBroker();
		echo "<br>".$objeto->mostra();

	}

}

?>
