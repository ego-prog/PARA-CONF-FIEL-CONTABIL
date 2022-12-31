<!--
	FIEL Contábil
	Desenvolvido por APOENA Soluções em Software Livre
	suporte@apoenasoftwarelivre.com.br
	http://www.apoenasoftwarelivre.com.br

	Data de Criação: 26/05/2003
	Última Atualização: 26/05/2003
	Módulo: cwCabec.php
	  Cabecalho da aplicacao
-->
<html>

<script language="javascript">

     function abreJanela( arquivo ) {

		var janela;
		window.open(arquivo, 'janela',
		'toolbar=no,location=no,directories=no,menubar=no,scrollbars=yes,resizable=yes');

	}

</SCRIPT>

<?PHP
include "config.php";
?>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="estilo/cw.css">

<body class="cabec">
<div align="center">

	<table class="cabec" width="100%" border="0"
			height="19" align="center">

		<?PHP
			$empresa = strtr( $empresa, "_", " " );
			$linha1  = strtr( $linha1, "_", " " );
			$linha2  = strtr( $linha2, "_", " " );
		?>

		<tr class="cabec">

			<!-- Logotipo da Empresa "<?PHP echo $logo; ?>" -->
			<td width="15%" class="cabec" align="center">
<!--				    <img src="<?PHP echo $logo; ?>" border="0">  -->
				<img src="imagens/contabil.jpg" width="110" border="0"><br>
                <font face="Verdana, Arial" size=1><?PHP echo 'Versão ' . VERSAO; ?></font><br>
            </td>
			<td width="10%" class="cabec" align="center">
<!-- Creative Commons License -->
<a rel="license" href="javascript:abreJanela('http://creativecommons.org/licenses/by-nc-sa/2.0/br/deed.pt');"><img alt="Creative Commons License" border="0" src="http://creativecommons.org/images/public/somerights20.pt.gif" /></a><br />
<!-- /Creative Commons License -->


<!--

<rdf:RDF xmlns="http://web.resource.org/cc/"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#">
<Work rdf:about="">
   <dc:type rdf:resource="http://purl.org/dc/dcmitype/Interactive" />
   <license rdf:resource="http://creativecommons.org/licenses/by-nc-sa/2.0/br/" />
</Work>

<License rdf:about="http://creativecommons.org/licenses/by-nc-sa/2.0/br/">
   <permits rdf:resource="http://web.resource.org/cc/Reproduction" />
   <permits rdf:resource="http://web.resource.org/cc/Distribution" />
   <requires rdf:resource="http://web.resource.org/cc/Notice" />
   <requires rdf:resource="http://web.resource.org/cc/Attribution" />
   <prohibits rdf:resource="http://web.resource.org/cc/CommercialUse" />
   <permits rdf:resource="http://web.resource.org/cc/DerivativeWorks" />
   <requires rdf:resource="http://web.resource.org/cc/ShareAlike" />
</License>

</rdf:RDF>

-->




			</td>

			<!-- Texto Título do Sistema -->
			<td width="50%" valign="middle">
				<p align="center"><font face="Verdana, Arial" size="4"
				   color="#FFFFFF"><?PHP echo $empresa; ?></font><br>
				<b><font face="Verdana, Arial" size="2"
				   color="#FFFFFF"><?PHP echo $linha1; ?><br>
				<?PHP echo $linha2; ?></b></font></p>
			</td>

			<!-- Logotipo da APOENA -->
			<td width="15%" align="center">			
				<a href="javascript:abreJanela('http://www.apoenasoftwarelivre.com.br');"><img src="./imagens/apoena_pequeno.gif" width="43" border="0" alt="por Apoena Software Livre"></a>
			</td>

	  </tr>

  </table>

</div>
</body>

</html>

