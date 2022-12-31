<html>

<?PHP

	include "Teste1Proxy.php";
	include "Teste2Proxy.php";

	echo "<h1>Teste do Framework de Persistencia</h1>";

	echo "<br>Classe Teste1Proxy usa: ";
	$teste1 = new Teste1Proxy();
	$teste1->testa();

	echo "<br><br>Classe Teste2Proxy usa: ";
	$teste2 = new Teste2Proxy();
	$teste2->testa();



?>
</html>