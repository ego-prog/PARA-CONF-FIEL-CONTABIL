<?PHP

/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 26/05/2003
*	Modulo: MsgCw.php
*
*	Desenvolvido por APOENA Solucoes em Software Livre
*	suporte@apoenasoftwarelivre.com.br
*	http://www.apoenasoftwarelivre.com.br
*
*	@author 	Claudimir Zavalik (claudimir@apoenasoftwarelivre.com.br)
*	@author 	Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*	@version	PHP3 & PHP4
*/

// Arquivo "header" do Contábil
include $pathClasses."cw.inc";

/**
*
*	MsgCw
*
*	Classe que contem as principais definicoes de mensagens
*	exibidas no FIEL Contábil
*
*/
class MsgCw extends Msg {

	/**
	*	MsgCw( $msg, $imagem, $acaoExecutada )
	*	Construtor
	*	@param $msg			mensagem a ser exibida
	*	@param $imagem			imagem da aplicacao
	*	@param $acaoExecutada	acao a ser executada
	*/
	function MsgCw( $msg, $imagem = "../imagens/contabil.jpg",
			$acaoExecutada = "javascript:history.go(-1);" ) {

		$this->setConf( "bjanela", $imagem, $acaoExecutada );
		$this->setMensagem( $msg );

	}

}

?>
