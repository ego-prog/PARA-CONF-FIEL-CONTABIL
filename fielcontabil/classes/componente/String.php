<?PHP

/**
*
*   Componentes
*
*   Data de Criacao: 21/05/2002
*   Ultima Atualizacao: 12/07/2003
*   Modulo: String.php
*	Componente de conversao de numeros
*
*   Copyright (C) por APOENA Solucoes em Software Livre
*   http://www.apoenasoftwarelivre.com.br
*
*   @author	Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*   @version	PHP3 & PHP4
*/

// Arquivo "header" do Framework
include $pathClassesComponente."componentes.inc";

/**
*
*	String
*
*   Classe que contem as principais definicoes utilizadas para
*   tratamento de strings
*
*/
class String {

   /**
   *  upper( $str )
   *  Converte string para maiuscula, incluindo acentos
   *  @param  $str	String a ser convertida
   *  @return $str	String convertida
   */
   function upper( $str ) {
	   return strtr( strtoupper( $str ),
						"àáâãçéêíóôõüú", "ÀÁÂÃÇÉÊÍÓÔÕÜÚ" );
   }

   /**
   *  contaOcorrencia( $str, $caracter )
   *  Conta ocorrencias de um caracter em uma string
   *  @param  $str		String
   *  @return $caracter caracter a pesquisar
   */
   function contaOcorrencia( $str, $caracter ) {
	   return sizeof( explode( $caracter, $str ) );
   }

   /**
   *	removeCRLF( $str )
   *	Remove CRLF da string
   *	@return $str
   */
   function removeCRLF( $str ) {

	 $texto  = $str;
	 $str	 = "";

	 for ( $indx = 0; $indx < strlen( $texto ); $indx++ ) {
	     $caracter = substr( $texto, $indx, 1 );
	     if ( ord( $caracter ) != 13 && ord( $caracter ) != 10 ) {
		$str = $str . $caracter; }
	 }

	 return $str;

    }

   /**
   *	removeChar( $str, $caracterRem )
   *	Remove caracter da string
   *	@return $str
   */
   function removeChar( $str, $caracterRem ) {

	 $texto  = $str;
	 $str	 = "";

	 for ( $indx = 0; $indx < strlen( $texto ); $indx++ ) {
	     $caracter = substr( $texto, $indx, 1 );
	     if ( $caracter != $caracterRem ) {
		$str = $str . $caracter; }
	 }

	 return $str;

    }

   /**
   *	 removeAcento ($str)
   *	 Remove os acentos e caracteres especiais de strings
   *	 @return $str
   */
   function removeAcento( $str ) {
	$retorno = strtr( $str , "ÀÁÂÃÇÉÊÍÓÔÕÜÚ", "AAAACEEIOOOUU");

	// Nao pode ter nenhum caracter fora do intervalo ASCII de 32 a 126
	for ($indx=0;$indx < strlen( $retorno );$indx++) {
	    $codigoASC = ord(substr($retorno,$indx,1));
	     if ( $codigoASC < 32 || $codigoASC > 126 ) 			   // Se for um caracter especial
	       if ( $codigoASC != 13 && $codigoASC != 10 && $codigoASC != 12 )	  //	e nao for CR, LF ou FF..
	       $retorno = strtr( $retorno, chr($codigoASC), ' ');		  // Troca por branco
	}

	return $retorno;
   }

}
?>
