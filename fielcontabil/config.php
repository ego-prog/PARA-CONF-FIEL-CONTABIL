<?PHP

/**
*
*       FIEL Cont�bil
*
*       Data de Criacao: 03/05/2005
*       Ultima Atualiza��o: 03/05/2005
*       Modulo: config.php
*               Arquivo de Configura��o do Sistema FIEL Contabil
*
*       Desenvolvido por:APOENA Solu��es em Software Livre
*       http://www.apoenasoftwarelivre.com.br
*
*       @author         Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*       @version        PHP3 & PHP4
*/

// Defini��o de Vers�o do Sistema
//-------------------------------
@define("VERSAO","2.5");

// Defini��es de Banco de Dados
//-----------------------------
@define( "BANCO", "nomebanco" );
@define( "USUARIO", "nomeusuario" );
@define( "SENHA", "senhausuario" );        // Substitua pela senha do usuario postgres
@define( "SERVIDOR", "ipservidor" );       // Substitua pelo IP do Servidor de Banco de Dados
@define( "PORTA", "portaservidor" );                // Substitua pela porta do servidor postgres (normalmente eh 5432)

// Defini��es de Apar�ncia do Sistema
//-----------------------------------
@define( "LOGOMARCA", "logotipo.jpg"); // Substitua pelo arquivo de logotipo a ser usado no Sistema e documentos PDF
                                       // o formato da imagem deve ser JPG, 130 x 90 pixels e o arquivo deve estar no
                                       // diretorio fielcontabil/imagens/

// Defini��es para Upload de Documentos
//-------------------------------------
@define( "TAMANHO_UPLOAD",300000);    // Tamanho m�ximo dos arquivos para Upload (em bytes) Obs.: N�o exceder o limite estabelecido em PHP.INI
@define( "LARGURA_UPLOAD",1000);      // Largura m�xima (em pixels) das imagens enviadas
@define( "ALTURA_UPLOAD", 1100);      // Altura m�xima (em pixels) das imagens enviadas

?>

