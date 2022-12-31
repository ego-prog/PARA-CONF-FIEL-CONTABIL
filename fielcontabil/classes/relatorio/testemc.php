<?

include "FPDFTable.php";

$lista   = array();
$lista[] = array( "12/02/2003", "1.1.1", "Caixa", "teste de texto teste de texto teste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de texto", "190,00" );
$lista[] = array( "12/04/2002", "1.1.1.9", "HSBC", "teste de texto teste de texto teste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de texto", "150,00" );
$lista[] = array( "12/02/2003", "1.1.1", "Caixa", "teste de texto teste de texto teste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de texto", "190,00" );
$lista[] = array( "12/04/2002", "1.1.1.9", "HSBC", "teste de texto teste de texto teste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de texto", "150,00" );
$lista[] = array( "12/02/2003", "1.1.1", "Caixa", "teste de texto teste de texto teste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de texto", "190,00" );
$lista[] = array( "12/04/2002", "1.1.1.9", "HSBC", "teste de texto teste de texto teste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de texto", "150,00" );
$lista[] = array( "12/02/2003", "1.1.1", "Caixa", "teste de texto teste de texto teste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de texto", "190,00" );
$lista[] = array( "12/04/2002", "1.1.1.9", "HSBC", "teste de texto teste de texto teste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de texto", "150,00" );
$lista[] = array( "12/02/2003", "1.1.1", "Caixa", "teste de texto teste de texto teste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de texto", "190,00" );
$lista[] = array( "12/04/2002", "1.1.1.9", "HSBC", "teste de texto teste de texto teste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de textoteste de texto", "150,00" );


$confLista = array();
$confLista[] = array( 0, "C", 0 );
$confLista[] = array( 0, "L", 0 );
$confLista[] = array( 0, "L", 0 );
$confLista[] = array( 0, "J", 0 );
$confLista[] = array( 0, "R", 0 );

$pdf=new FPDFTable();

$pdf->Open();
$pdf->AddPage();

$pdf->SetFont('Arial','',10);

$pdf->SetWidths(array(30,30,30,60,30));

for($i=0;$i<sizeof($lista);$i++)
$pdf->Row(array($lista[$i][0],$lista[$i][1],$lista[$i][2],$lista[$i][3],$lista[$i][4]), $confLista );
$pdf->Output( "mc.pdf");

?>
