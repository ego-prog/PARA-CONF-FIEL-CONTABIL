<?PHP

/**
*
*   Componentes
*
*   Data de Criacao: 21/05/2002
*   Ultima Atualizacao: 21/05/2002
*   Modulo: Data.php
*       Componente de Calendario
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
*	Calendario
*
*   Classe que contem as principais definicoes utilizadas para
*   apresentacao de Calendario, retornando a data selecionada
*
*/
class Calendario {

	var $data;			// Data a ser tratada
	var $dia;			// dia
	var $mes;			// mes
	var $ano;			// ano
	var $diaSemana;		// dia da semana
	var $diaCalend;		// dia da semana para calendario
	var $diaExtenso;	// dia da semana por extenso
	var $totalDias;		// total de dias no mes
	var $mesExtenso;   	// mes por extenso

	/**
	* 	Calendario( )
	* 	Construtor para instanciar a Objeto
	*/
	function Calendario ( ) {

		$this->diaCalend  = array( "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb" );

		$this->diaExtenso = array( "Domingo", "Segunda-feira", "Terça-feira",
					"Quarta-feira", "Quinta-feira", "Sexta-feira", "Sáb" );

		$this->totalDias  = array( "31", "28", "31",
					"30", "31", "30", "31", "31", "30", "31", "30", "31" );

		$this->mesExtenso = array( "Jan", "Fev", "Mar", "Abr", "Mai",
								"Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez" );
	}

	/**
	* 	setData( $data )
	* 	Recebe data
	*	@param 	$data		data
	*/
    function setData( $data ) {

		$this->data 	= $data;
		$this->dia		= substr( $data, 0, 2 );
		$this->mes		= substr( $data, 3, 2 );
		$this->ano		= substr( $data, 6, 4 );

	}

	/**
	* 	getDia()
	* 	Retorna dia
	*	@return	$dia		dia
	*/
    function getDia() {

		return $this->dia;

	}

	/**
	* 	getMes()
	* 	Retorna mes
	*	@return	$mes		mes
	*/
    function getMes() {

		return $this->mes;

	}

	/**
	* 	getAno()
	* 	Retorna ano
	*	@return	$ano		ano
	*/
    function getAno() {

		return $this->ano;

	}

	/**
	* 	getDiaSemanaCalend( $numero )
	* 	Retorna dia da semana para Calendario
	*	@param	$numero		numero correspondente ao dia
	*	@return	$diaCalend
	*/
    function getDiaSemanaCalend( $numero ) {

		return $this->diaCalend[$numero];

	}

	/**
	* 	getDiaSemanaExt( $numero )
	* 	Retorna dia da semana por extenso
	*	@param	$numero		numero correspondente ao dia
	*	@return	$diaExtenso
	*/
    function getDiaSemanaExt( $numero ) {

		return $this->diaExtenso[$numero];

	}

	/**
	* 	getTotalDias( $mes, $ano )
	* 	Retorna total de dias do mes no ano
	*	@param	$mes			mes
	*	@param	$ano			ano
	*	@return	$totalDias		total de dias do mes no ano
	*/
    function getTotalDias( $mes, $ano ) {

		if ( ( $ano % 4 ) == 0 )
			$this->totalDias[1] = $this->totalDias[1] + 1;

		return $this->totalDias[( $mes - 1 )];

	}

	/**
	* 	getDiaSemana( $data )
	* 	Retorna dia da semana para a data especificada
	*	@param	$data		data a ser convertida
	*	@return	$diaSemana
	*/
    function getDiaSemana( $data ) {

		$this->setData( $data );

		$dividendo 	= (int)( ( 14 - $this->mes )/ 12 );
		$ano_dif 	= $this->ano - $dividendo;
		$mes_dif 	= $this->mes + ( 12 * $dividendo ) - 2;

		$this->diaSemana = ( $this->dia + $ano_dif + (int)( $ano_dif / 4 ) -
				(int)( $ano_dif/100) + (int)( $ano_dif / 400 ) +
				(int)( (31 * $mes_dif ) / 12 ) ) % 7;

		return $this->diaSemana;

	}

	/**
	* 	mostraCalendario( $mes, $ano )
	* 	Exibe calendario para mes e ano
	*	@param	$mes			mes
	*	@param	$ano			ano
	*/
    function mostraCalendario( $mes, $ano ) {

		// Mostra Mes e Ano...
		echo "<table><tr><td align=\"center\">\n";
		echo "<font size=\"+1\" color=\"#000000\" face=\"Verdana, Arial\">\n";
		echo "<strong>".$this->mesExtenso[($mes - 1)]." - ".$ano."</strong></font>\n";
		echo "<br><br></td></tr></table>\n";

		// Comeca desenho de Calendario...
		echo "<table border =\"0\" width=\"50%\" bgcolor=\"#FFFFFF\"><tr>";
		for ( $indx = 0; $indx < 7; $indx++ ) {
	        echo "<td class=\"tjanela\" width=\"13%\" align=\"center\">";
				echo $this->diaCalend[$indx];
			echo "</td>"; }
		echo "</tr>";

		// Laco para montagem de datas no mes e ano...
		$diaAtual 			= 1;
		$controleDiaSemana 	= 0;
		$controleCor 		= 0;
		$mes = (int) $mes;

		while ( $this->getTotalDias( $mes, $ano ) >= $diaAtual ) {

			// Monta data...
			$dataAtual  = ($diaAtual > 9?$diaAtual:"0".$diaAtual )."/"; // Dia...
			$dataAtual .= ($mes > 9?$mes:"0".$mes )."/";   // Mes...
			$dataAtual .= $ano;
			$cor = $controleCor % 2 == 0?"lcons1":"lcons2";

			// Teste: Verificar dia da semana...
			if ( $controleDiaSemana == $this->getDiaSemana( $dataAtual ) ) {

					// Se dia da semana...
					if ( $controleDiaSemana <= 6 ) {

						    echo "<td class=".$cor." width=\"13%\" align=\"center\">";
							echo "<a href=\"javascript:setaValor( '".$dataAtual."' );\">";
							echo substr( $dataAtual, 0, 2 );
							echo "</a>\n";
							echo "</td>\n"; }

					$controleDiaSemana = $controleDiaSemana + 1;
					$diaAtual = $diaAtual + 1;

					// Se controlador passou o numero de dias...
					if ( $controleDiaSemana > 6 ) {
						echo "</tr>\n";
						echo "<tr>\n";
						$controleDiaSemana = 0;
						$controleCor = $controleCor + 1; }
			}

			// Finaliza tabela de dias...
			else {
		        echo "<td class=".$cor." width=\"13%\" align=\"center\">";
					echo "&nbsp;";
				echo "</td>\n";
				$controleDiaSemana = $controleDiaSemana + 1; }

		}

		// se passou...
		if ( $controleDiaSemana < 7 ) {
			    echo "<td class=".$cor." width=\"13%\" align=\"center\">";
					echo "&nbsp;";
				echo "</td>"; }

		echo "</tr>";

		echo "</table>";

	}

}

?>
