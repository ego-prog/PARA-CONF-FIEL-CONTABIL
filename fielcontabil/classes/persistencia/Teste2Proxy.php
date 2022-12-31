<?PHP

include "framework_persistencia.inc";

class Teste2Proxy extends Proxy {


	function getBroker() {

		return BD_ORACLE;
	}

	function testa() {

		$objeto = $this->criaBroker();
		echo "<br>".$objeto->mostra();

	}

}

?>
