<?PHP

/**
*
*   Componentes
*
*   Data de Criacao: 21/05/2002
*   Ultima Atualizacao: 21/05/2002
*   Modulo: Data.php
*       Componente de conversao de datas
*
*   Copyright (C) por APOENA Solucoes em Software Livre
*   http://www.apoenasoftwarelivre.com.br
*
*   @author     Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*   @version    PHP3 & PHP4
*/

// Arquivo "header" do Framework
include $pathClassesComponente."componentes.inc";

/**
*
*	Data
*
*   Classe que contem as principais definicoes utilizadas para
*   tratamento de datas
*
*/
class Data {

	/**
	* 	converteDmaMda( $data )
	* 	Converte DD/MM/AAAA para MM/DD/AAAA
	*	@param 	$data		data a ser convertida
	*	@return data convertida no formato
	*/
    function converteDmaMda( $data ) {

		return substr( $data, 3, 2 )."-".substr( $data, 0, 2 )."-".substr( $data, 6, 4 );

	}

	/**
	* 	converteMdaDma( $data )
	* 	Converte MM/DD/AAAA para DD/MM/AAAA
	*	@param 	$data		data a ser convertida
	*	@return data convertida no formato
	*/
    function converteMdaDma( $data ) {

		return substr( $data, 3, 2 )."/".substr( $data, 0, 2 )."/".substr( $data, 6, 4 );

	}

	/**
	* 	converteDmaAmd( $data )
	* 	Converte DD/MM/AAAA para AAAA/MM/DD
	*	@param 	$data		data a ser convertida
	*	@return data convertida no formato
	*/
    function converteDmaAmd( $data ) {

		return substr( $data, 6, 4 )."-".substr( $data, 3, 2 )."-".substr( $data, 0, 2 );

	}

	/**
	* 	converteAmdDma( $data )
	* 	Converte AAAA/MM/DD para DD/MM/AAAA
	*	@param 	$data		data a ser convertida
	*	@return data convertida no formato
	*/
    function converteAmdDma( $data ) {

		return substr( $data, 8, 2 )."/".substr( $data, 5, 2 )."/".substr( $data, 0, 4 );

	}

	/**
	* 	calculaHora( $hora1, $hora2, $operacao )
	* 	Calcula duas horas baseada em operacao definida
	*	@param 	$hora1		hora 1
	*	@param	$hora2		hora 2
	*	@param	$operacao	operacao a ser realizada ( "ADICAO", "SUBTRACAO" )
	*	@return hora:minuto	hora e minutos calculada
	*/
    function calculaHora( $hora1, $hora2, $operacao ) {

		$hora_1  	= substr( $hora1, 0, 2 );
		$minuto_1	= substr( $hora1, 3, 2 );
		$hora_2  	= substr( $hora2, 0, 2 );
		$minuto_2	= substr( $hora2, 3, 2 );

		if ( strtoupper( $operacao ) == "ADICAO" ) {
			$hora 		= (int)$hora_1 + (int)$hora_2;
			$minuto		= (int)$minuto_1 + (int)$minuto_2;

			if ( $minuto >= 60 ) {
				$minuto = $minuto - 60;
				$hora   = $hora + 1; }

		}

		$minuto = $minuto == "0"?"00":($minuto > 9?$minuto:"0".$minuto);
		$hora   = $hora == "0"?"00":($hora > 9?$hora:"0".$hora);
		return $hora.":".$minuto;

	}

	/**
	* 	maiorHora( $hora1, $hora2 )
	* 	Testa qual hora e a maior
	*	@param 	$hora1		hora 1
	*	@param	$hora2		hora 2
	*	@return maior		retorna 1 se a maior hora for a 1a., caso contrario 2.
	*/
    function maiorHora( $hora1, $hora2 ) {

		$hora_1  	= substr( $hora1, 0, 2 );
		$minuto_1	= substr( $hora1, 3, 2 );
		$hora_2  	= substr( $hora2, 0, 2 );
		$minuto_2	= substr( $hora2, 3, 2 );

		$maior = $hora_1 > $hora_2? 1:
					( $hora_2 > $hora_1? 2:
						( $minuto_1 > $minuto_2? 1: 2 ) );

		return $maior;

	}

	/**
	* 	somaDia( $data, $dias )
	* 	Adiciona dia(s) a data
	*	@param 	$data		  data
	*	@param	$dias		  dias a serem adicionados
	*	@return dataPrevista  data incrementada
	*/
    function somaDia( $data, $dias ) {
	
		$dia = substr($data, 0, 2);
		$mes = substr($data, 3, 2);
		$ano = substr($data, 6, 4);
		$diaPrevisto = $dia + $dias;
		$dataPrevista = date( "d/m/Y", mktime( 0, 0, 0, $mes, $diaPrevisto, $ano ) );
		return $dataPrevista;
	}

	/**
	* 	retornaDia( $data )
	* 	Retorna dia de data
	*	@param 	$data		  data
	*	@return $dia
	*/
    function retornaDia( $data ) {
	
		return substr($data, 0, 2);

	}

	/**
	* 	retornaMes( $data )
	* 	Retorna mes de data
	*	@param 	$data		  data
	*	@return $mes
	*/
    function retornaMes( $data ) {
	
		return substr($data, 3, 2);

	}

	/**
	* 	retornaAno( $data )
	* 	Retorna dia de data
	*	@param 	$data		  data
	*	@return $ano
	*/
    function retornaAno( $data ) {
	
		return substr($data, 6, 4);

	}

}

?>