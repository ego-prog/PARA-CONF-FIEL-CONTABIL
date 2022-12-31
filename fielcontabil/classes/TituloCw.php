<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 26/05/2003
*	Modulo: TituloCw.php
*
*	Desenvolvido por APOENA Solucoes em Software Livre
*	suporte@apoenasoftwarelivre.com.br
*	http://www.apoenasoftwarelivre.com.br
*
*	@author 	Claudimir Zavalik (claudimir@apoenasoftwarelivre.com.br)
*	@author 	Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*	@version	PHP3 & PHP4
*/

// Arquivo "header" do VOX
include $pathClasses."cw.inc";

/**
*
*	TituloCw
*
*	Classe que contem as principais definicoes de titulos das
*	paginas a serem exibidas no Contabil WEB
*
*/
class TituloCw extends Cabecalho {

	/**
	*	TituloCw( $titulo )
	*	Construtor
	*	@param $titulo			titulo a ser exibida
	*/
	function TituloCw( $titulo ) {

		$this->setTitulo( $titulo );
		$this->setConf( "msg", "msg" );

	}

}

?>
