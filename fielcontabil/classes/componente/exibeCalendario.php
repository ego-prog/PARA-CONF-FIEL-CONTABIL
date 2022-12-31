<!--                                                                  -->
<!-- Componente de Calend�rio                                         -->
<!-- Desenvolvido por APOENA Solu��es em Software Livre               -->
<!--                                                                  -->
<!--    Guilherme Silva de Lacerda                                    -->
<!--    guilherme@apoenasoftwarelivre.com.br                          -->
<!--    http://www.apoenasoftwarelivre.com.br                         -->
<!--                                                                  -->
<!-- Data de Cria��o: 21/05/2002                                      -->
<!-- �ltima Atualiza��o: 21/05/2002                                   -->
<!-- M�dulo: exibeCalendario.php                                      -->
<!-- 	Mostra calendario    				                          -->

<html>

<head>
<title>Calend�rio</title>

<SCRIPT LANGUAGE="javascript">

	//--------------------------------------------
	// setaValor()
	// - Seta valor recebido
	//--------------------------------------------
	function setaValor( numero ) {

		window.opener.setaAtributo( numero, 0, 2 );
		window.close();

	}

</SCRIPT>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="./calendario.css">
</head>

<body class="pagina">
<div align="center">

<form name="calendario" method="POST">

     <!-- Dados para acesso ao sistema -->
<table width="100%" bgcolor="#FFFFFF">

	 <?PHP
	 	
	 	include "./componentes.inc";
		
		$calend = new Calendario;
		
		
	 	if ( empty( $gera_calend ) )
	 		$gera_calend = 0;

		if ( $gera_calend == 1 ) {
			if ( $operacao == "R" ) {
				$mes = $mes - 1;
				if ( $mes < 1 ) {
					$mes = 12;
					$ano = $ano - 1; }
			}
			if ( $operacao == "A" ) {
					$mes = $mes + 1;
				if ( $mes > 12 ) {
					$mes = 1;
					$ano = $ano + 1; }
			}

		echo "<input type=\"hidden\" name=\"mes\" value=\"".$mes."\">";
		echo "<input type=\"hidden\" name=\"ano\" value=\"".$ano."\">";

		}

		$calend->mostraCalendario( $mes, $ano );



?>

<input type="hidden" name="gera_calend" value="1">
<input type="hidden" name="operacao" value="1">
      <tr>
          <td width="40%" align="right">
                    &nbsp;
                </td>

                <td width="60%" align="left"><br><br>
	        	    <input type="submit" class="bjanela"
						name= "bt_voltar" value=" << "
						OnClick="javascript:document.forms[0].operacao.value='R';">&nbsp;
					<input type="submit" class="bjanela"
						name= "bt_gravar" value=" >> "
						OnClick="javascript:document.forms[0].operacao.value='A';">
                </td>
     </tr>
	</table>

</form>
</div>
</body>

</html>

