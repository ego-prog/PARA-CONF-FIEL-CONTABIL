<?PHP

/**
*
*   Framework de Relatorio
*
*   Data de Criacao: 21/01/2005
*   Ultima Atualizacao: 21/01/2005
*   Modulo: RelatorioTXT.php
*	Framework de relatorio
*
*   Copyright (C) por APOENA Solucoes em Software Livre
*   http://www.apoenasoftwarelivre.com.br
*
*   @author	Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*   @version	PHP3 & PHP4
*/

// Arquivo "header" do Framework
include $pathClassesRelatorio."framework_relatorio.inc";

/**
*
*	RelatorioTXT
*
*   Classe que contem as principais definicoes de relatorios no formato TXT
*   gerados em algumas opções do Sistema
*
*/
class RelatorioTXT extends AbstractFormat {

	var $nomeArquivo;      // Nome do Arquivo TXT a ser gerado
	var $arquivoSaida;     // Handler do arquivo de saída
	var $tituloRelatorio;  // Titulo do Relatorio
	var $numeroPagina;     // Número da Página
	var $nomeEmpresa;      // Nome da Empresa a constar no cabeçalho

	/**
	*	setConf( $nomeArquivo )
	*	Recebe configuracao da classe
	*	@param $nomeArquivo	nome do arquivo a ser gerado
	*/
	function setConf( $nomeArquivo ) {

		$this->nomeArquivo   = $nomeArquivo;
	}

	/**
	*	inicioRelatorio()
	*	Inicia formatacao do relatorio
	*/
    function inicioRelatorio() {

		// Cria o arquivo TXT...
	       $this->arquivoSaida=@fopen($this->nomeArquivo,"w");
	      if ($this->arquivoSaida)
		 $retorno=true;
	      else
	      {
		 $retorno=false;
	      }
	     return $retorno;
    }

    /**
    *	    fimRelatorio( )
    *	    Finaliza o relatorio, fechando o relatório
    */

    function fimRelatorio( ) {

	 if (@fclose($this->arquivoSaida))
	 {
	     $retorno=true;
	 }
	 else
	 {
	     $retorno=false;
	 }
	 return $retorno;

    }

	/**
	*	mostraString( $linha )
	*	Mostra string no relatorio
	*	@param	$linha		Linha a ser exibida
	*/
	function mostraString( $linha ) {

	    @fwrite($this->arquivoSaida, $linha, strlen($linha));  // CLAUDIMIR

	}


}

?>
