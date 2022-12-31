<?PHP

/**
*
*   Componentes
*
*   Data de Criacao: 21/05/2002
*   Ultima Atualizacao: 12/07/2003
*   Modulo: Numero.php
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
*	Numero
*
*   Classe que contem as principais definicoes utilizadas para
*   tratamento de numeros
*
*/
class Numero {

   /**
   *  convReal( $valor )
   *  Converte valor (geralmente float) para formato de reais
   *  @param  $valor		 Valor a ser convertido
   *  @param  $sinal		 Se true, retorna valor com sinal "-" na frente do numero
   *  @return $valorConvertido
   */
    function convReal( $valor, $sinal = false ) {

	     $valor = sprintf( "%.2f", $valor );

	     // Testa se é negativo...
	     if( $valor < 0 ) {
		 $negArray = "$valor";
		 $negTmpArray = explode( "-", $negArray );
		 $valor = $negTmpArray[1];
		 $md = "neg";
	     }

	     $limpa  = str_replace( ".", "", $valor );
	     $limpa2 = str_replace( ",", "", $limpa );
	     $valor  = "$limpa2";
	     $size   = strlen( $limpa );

	     if ( $size == 2 ) {
	       $vt_v = $valor; $valor = "00".$vt_v; }

	     if ( $size == 1 ) {
	       $vt_v = $valor; $valor = "000".$vt_v; }

	     $size = strlen($valor);

	     if( $size > 2 ) {
	       $str_mod = $size - 3;
	       $param = $size -2;
	       $m = 3;
	       $ctrl_str = $str_mod;
	       $mi = 1;

	       $sub_count = 1; $count = 0;
	       while( $count <= $str_mod ) {

		 $n_array = $valor[$ctrl_str];

		 if( $count == 0 ) {
		   $var_temp = $n_array;
		 }
		 else {
		   if( $sub_count == 3 ) {
		       if( $ctrl_str == 0 ) {
			 $nvar_temp = $n_array.$var_temp;
			 $var_temp = $nvar_temp;
			 $sub_count = 0; }
		       else {
			 $nvar_temp = ".".$n_array.$var_temp;
			 $var_temp = $nvar_temp;
			 $sub_count = 0;
		       }
		   }
		   else {
		     $nvar_temp = $n_array.$var_temp;
		     $var_temp = $nvar_temp;
		   }
		 }

		 $count++;
		 $sub_count++;
		 $ctrl_str--;
	      }

	      $moeda = "";	   // Se desejar, pode colocar "R$ "
	      $c1 = $valor[$str_mod+1].$valor[$str_mod+2];

	      if( @$md == "neg" ) {  // Para colocar o sinal de "-", basta adicionar abaixo apos $moeda (Guilherme)
		  $sinalNeg = ( $sinal == true )?"-":"";
		  $valorConvertido = $moeda.$sinalNeg.$var_temp.",".$c1;
	      }
	      else { // PARA REMOVER O R$ REMOVA A VAR ($moeda)
		  $valorConvertido = $moeda.$var_temp.",".$c1;
	      }// PARA REMOVER O R$ REMOVA A VAR ($moeda)
	      $var_temp = $valorConvertido;
	    }

	    return $valorConvertido;

    }

    /**
    *  extenso( $valor, $moeda, $formato )
    *  Converte valor (geralmente float) para formato de reais
    *  @param  $moeda
    *  @param  $formato
    *  @return $porExtenso
    */
    function extenso( $valor, $moeda, $formato = 3 ) {

	   if ( $formato == 1 )
	      $porExtenso = strtolower( $this->retornaExtenso( $valor, $moeda ) );
	   elseif ( $formato == 2 )
	      $porExtenso = strtoupper( $this->retornaExtenso( $valor, $moeda ) );
	   elseif ( $formato == 3 )
	      $porExtenso = ucfirst( strtolower( trim($this->retornaExtenso( $valor, $moeda )) ) );
	   return $porExtenso;

    }

    /**
    *  trio_extenso( $cVALOR )
    *  Retorna os numeros por extenso de 3 em 3
    *  @param  $cVALOR
    *  @return $cRESULT
    */
    function trio_extenso( $cVALOR ) {

	     $aUNID   = array(""," UM "," DOIS "," TRES "," QUATRO "," CINCO ",
				   " SEIS "," SETE "," OITO "," NOVE ");
	     $aDEZE   = array("","   "," VINTE E"," TRINTA E"," QUARENTA E",
			" CINQUENTA E"," SESSENTA E"," SETENTA E"," OITENTA E"," NOVENTA E ");
	     $aCENT   = array("","CENTO E","DUZENTOS E","TREZENTOS E",
		      "QUATROCENTOS E","QUINHENTOS E","SEISCENTOS E","SETECENTOS E","OITOCENTOS E","NOVECENTOS E");
	     $aEXC    = array(" DEZ "," ONZE "," DOZE "," TREZE ",
		      " QUATORZE "," QUINZE "," DESESSEIS "," DESESSETE "," DEZOITO "," DESENOVE ");

	     $nPOS1   = substr( $cVALOR, 0, 1 );
	     $nPOS2   = substr( $cVALOR, 1, 1 );
	     $nPOS3   = substr( $cVALOR, 2, 1 );
	     $cCENTE  = $aCENT[ ( $nPOS1 ) ];
	     $cDEZE   = $aDEZE[ ( $nPOS2 ) ];
	     $cUNID   = $aUNID[ ( $nPOS3 ) ];

	     if ( substr( $cVALOR, 0, 3 ) == "100" ) {
	       $cCENTE = "CEM "; }

	     if ( substr( $cVALOR, 1, 1 ) == "1" ) {
	       $cDEZE = $aEXC[$nPOS3];
	       $cUNID = ""; }

	       $cRESULT = $cCENTE . $cDEZE . $cUNID;
	       $cRESULT = substr($cRESULT,0,strlen($cRESULT)-1);

	       return $cRESULT;
    }

    /**
    *  retornaExtenso( $cVALOR, $lMOEDA )
    *  Retorna valor por extenso
    *  @param  $cVALOR
    *  @param  $lMOEDA
    *  @return $porExtenso
    */
    function retornaExtenso($cVALOR, $lMOEDA) {
	     // pict 999.999.999,99

	     $zeros = "000.000.000,00";
	     $cVALOR = number_format( $cVALOR, 2 );
	     $cVALOR = substr( $zeros, 0, strlen( $zeros ) - strlen( $cVALOR ) ) . $cVALOR;
	     $nVALOR = 2;

	     if ( $lMOEDA ) {
		$cMOEDA_SINGULAR = " REAL";
		$cMOEDA_PLURAL	 = " REAIS"; }
	     else {
		$cMOEDA_SINGULAR = "";
		$cMOEDA_PLURAL	 = ""; }

		//cVALOR  = transform( nVALOR, "@ZE 999,999,999.99");
		//$cRETURN = substr($cVALOR,0,3) . substr($cVALOR,4,3) . substr($cVALOR,8,3);

	     $cMILHAO = $this->trio_extenso(substr($cVALOR,0,3)) . ( (substr($cVALOR,0,3)>1) ? ' MILHOES' : '' );
	     $cMILHAR = $this->trio_extenso(substr($cVALOR,4,3)) . ( (substr($cVALOR,4,3)>0) ? ' MIL' : '' );
	     $cUNIDAD = $this->trio_extenso(substr($cVALOR,8,3)) . ( ($nVALOR==1) ? $cMOEDA_SINGULAR : $cMOEDA_PLURAL);
	     $cCENTAV = $this->trio_extenso("0" . substr($cVALOR,12,2)) . ((substr($cVALOR,12,2)>0) ? " CENTAVOS" : "");

	     $cRETURN = $cMILHAO . ((strlen(trim($cMILHAO))<>0 && strlen(trim($cMILHAR))<>0) ? ", " : "") .
		      $cMILHAR . ((strlen(trim($cMILHAR))<>0 && strlen(trim($cUNIDAD))<>0) ? ", " : "") .
		      $cUNIDAD . ((strlen(trim($cUNIDAD))<>0 && strlen(trim($cCENTAV))<>0) ? ", " : "") .
		      $cCENTAV;
	return $cRETURN;

    }

    /**
    *	modulo11( $numero, $base, $r )
    *  	Retorna digito verificador usando algoritmo de modulo 11
    *  	@param  $numero		Numero utilizado para gerar o DV
    *  	@param  $base		Base
    *  	@return $r			Se 0, retorna DV, se não o resto
    */
	function modulo11( $numero, $base = 9, $r = 0 ) {

		$fator = 2;
		$soma  = 0;
		// Realiza laco para soma dos numeros, utilizando o fator
		for ( $indx = strlen( $numero ); $indx > 0; $indx-- ) {
			
			$numeros[ $indx ] = substr( $numero, $indx - 1, 1 );
			$parcial[ $indx ] = $numeros[ $indx ] * $fator;
			
			$soma += $parcial[ $indx ];
			
			if ( $fator == $base )
				$fator = 1;
			$fator++;
			
		}

		// Calculo do modulo 11 
		// se $r for zero, retorna digito
		if ( $r == 0 ) {
		
			$soma *= 10;
			$digito = $soma % 11;
			
			if ( $digito == 10 ) $digito = 0;
			
			$retorno = $digito;
			
		}
		elseif ( $r == 1 ) {
			
			$resto   = $soma % 11;
			$retorno = $resto;
		}
		
		return $retorno;

	}
	
}

?>
