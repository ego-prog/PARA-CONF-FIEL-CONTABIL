<?PHP
/**
*
*	FIEL Contábil
*
*	Data de Criacao: 26/05/2003
*	Ultima Atualizacao: 26/05/2003
*	Modulo: cw.inc
*
*	Desenvolvido por APOENA Solucoes em Software Livre
*	suporte@apoenasoftwarelivre.com.br
*	http://www.apoenasoftwarelivre.com.br
*
*	@author Claudimir Zavalik (claudimir@apoenasoftwarelivre.com.br)
*	@author Guilherme Silva de Lacerda (guilherme@apoenasoftwarelivre.com.br)
*	@version	PHP3 & PHP4
*/
// Definições Globais - Path do Sistema
//-------------------------------------
@define( "ROOTSISTEMA", "/var/www/html/fielcontabil/" );    // Diretorio onde está instalado o sistema
// Gera numero para atualizacao de paginas Web
srand( microtime() * 1000000 );
$numeroPagina = rand( 0, 1000 ) * date( "s" );
// Constantes do Contábil
@define( "CW_TAM_BARRA",	3 );
@define( "CW_DIR_IMG",	"../imagens/" );
@define( "CW_MASCARA_CONTA",  "9.9.99.9999" );
@define( "CW_HTML_BRANCO",	"&nbsp;" );
@define( "CW_TOTAL_COMPOSICAO",  20 );
// Nome dos arquivos PDF gerados
@define( "PDF_DIARIO", "cw_diario.pdf" );
@define( "PDF_PLANO_CONTAS", "cw_plano_contas.pdf" );
@define( "PDF_PLANO_CONTAS_DOAR", "cw_plano_contas_doar.pdf" );
@define( "PDF_RAZAO", "cw_razao.pdf" );
@define( "PDF_BALANCETE", "cw_balancete.pdf" );
@define( "PDF_DEMO_RESULT", "cw_demonstrativo.pdf" );
@define( "PDF_BALANCO", "cw_balanco.pdf" );
@define( "PDF_ORCAMENTO", "cw_orcamento.pdf" );
@define( "PDF_DOAR", "cw_doar.pdf" );
@define( "PDF_NAO_CONTAB", "cw_lanc_nao_cont.pdf" );
// Nome dos arquivos TXT gerados
@define( "TXT_DIARIO", "cw_diario.txt" );
@define( "TXT_RAZAO",  "cw_razao.txt" );
@define( "TXT_BALANCETE", "cw_balancete.txt");
@define( "TXT_PLANOCONTAS", "cw_plano.txt");
@define( "TXT_DEMONSTRATIVO","cw_demonstrativo.txt");
@define( "TXT_BALANCO","cw_balanco.txt");
// ---------------------------------------------------------------------------
// PATH da aplicação
// ---------------------------------------------------------------------------
$pathClasses = ROOTSISTEMA . "/classes/";
// ---------------------------------------------------------------------------
// Definicoes de usuario e senha para acesso ao Banco de Dados
// ---------------------------------------------------------------------------
include_once ROOTSISTEMA . "config.php";
// ---------------------------------------------------------------------------
// Controle de Sessão
// ---------------------------------------------------------------------------
// Erro de Sessoes no Contabil
include_once $pathClasses."cwErro.php";
// ---------------------------------------------------------------------------
// Dicionário de Internacionalização (I18N)
// ---------------------------------------------------------------------------
// Dicionario I18N
include_once $pathClasses."MessageBundle.properties";
// ---------------------------------------------------------------------------
// Frameworks e Componentes
// ---------------------------------------------------------------------------
// Framework de Servicos
include_once $pathClasses."servicos/framework_servicos.inc";
// Componentes utilizados
include_once $pathClasses."componente/componentes.inc";
// Framework de Persistencia
include_once $pathClasses."persistencia/framework_persistencia.inc";
// Framework de Relatorios
include_once $pathClasses."relatorio/framework_relatorio.inc";
// ---------------------------------------------------------------------------
// Classes da Aplicação (Negócio)
// ---------------------------------------------------------------------------
// Classe de Mensagens
include_once $pathClasses."MsgCw.php";
// Classe de Relatorios (formato HTML)
include_once $pathClasses."RelatorioHTMLCw.php";
// Classe de Relatorios (formato PDF)
include_once $pathClasses."RelatorioPDFCw.php";
// Classe de cabecalhos das paginas
include_once $pathClasses."TituloCw.php";
// Classe de parametros do sistema
include_once $pathClasses."ParametroCw.php";
// Classe de registro de operacoes do LOG
include_once $pathClasses."LogCw.php";
// Classe de consultas personalizadas
include_once $pathClasses."ConsultaCw.php";
// Classe de usuarios
include_once $pathClasses."UsuarioCw.php";
// Classe de vínculos de Usuários a Empresas
include_once $pathClasses."UsuarioEmpresa.php";
// Classe de Empresas
include_once $pathClasses."Empresa.php";
// Classe de Centros de Custo
include_once $pathClasses."CentroCusto.php";
// Classe de Termos de Abertura e Encerramento
include_once $pathClasses."Termo.php";
// Classe de Notas Explicativas
include_once $pathClasses."Nota.php";
// Classe de Conta DOAR
include_once $pathClasses."ContaDoar.php";
// Classe de Historicos Padroes
include_once $pathClasses."HistoricoPadrao.php";
// Classe de Plano de Contas
include_once $pathClasses."Conta.php";
// Classe de Orcamentos
include_once $pathClasses."Orcamento.php";
// Classe de Zeramentos
include_once $pathClasses."Zeramento.php";
// Classe de Lancamentos
include_once $pathClasses."Lancamento.php";
// Classe de Itens de Lancamentos
include_once $pathClasses."ItemLancamento.php";
// ---------------------------------------------------------------------------
// Classes da Mapeamento (Persistência)
// ---------------------------------------------------------------------------
// Classe de registro de operacoes (LOG)
include_once $pathClasses."LogCwProxy.php";
// Classe de parametros do sistema
include_once $pathClasses."ParametroCwProxy.php";
// Classe de consultas personalizadas
include_once $pathClasses."ConsultaCwProxy.php";
// Classe de usuarios
include_once $pathClasses."UsuarioCwProxy.php";
// Classe de Vínculos de Usuários a Empresas
include_once $pathClasses."UsuarioEmpresaProxy.php";
// Classe de Empresas
include_once $pathClasses."EmpresaProxy.php";
// Classe de Centros de Custo
include_once $pathClasses."CentroCustoProxy.php";
// Classe de Termos de Abertura e Encerramento
include_once $pathClasses."TermoProxy.php";
// Classe de Notas Explicativas
include_once $pathClasses."NotaProxy.php";
// Classe de Conta DOAR
include_once $pathClasses."ContaDoarProxy.php";
// Classe de Historicos Padroes
include_once $pathClasses."HistoricoPadraoProxy.php";
// Classe de Plano de Contas
include_once $pathClasses."ContaProxy.php";
// Classe de Orcamentos
include_once $pathClasses."OrcamentoProxy.php";
// Classe de Zeramentos
include_once $pathClasses."ZeramentoProxy.php";
// Classe de Lancamentos
include_once $pathClasses."LancamentoProxy.php";
// Classe de Itens de Lancamentos
include_once $pathClasses."ItemLancamentoProxy.php";
?>
