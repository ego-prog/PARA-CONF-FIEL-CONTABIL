<?PHP

        // Abre sessao...
        @session_start( "cw" );

        // Recebe oid da Empresa
        $oidEmpresa   = $oidEmpresaSession;
        $loginUsuario = $loginSession;

        if ( empty( $oidEmpresaContCookie ) )
                setcookie( "oidEmpresaContCookie", -1 );

        // Inclui pacote da aplicacao...
        include "./classes/cw.inc";

        $empresa = new Empresa();
        $empresas = $empresa->buscaEmpresa( $oidEmpresa, "",1,$loginUsuario );

?>

<!--
        FIEL Cont�bil
        Desenvolvido por APOENA Solu��es em Software Livre
        suporte@apoenasoftwarelivre.com.br
        http://www.apoenasoftwarelivre.com.br

        Data de Cria��o: 21/03/2005
        �ltima Atualiza��o: 21/03/2005
        M�dulo: cwCadCentro.php
          Cadastro de Centros de Custo
-->

<html>
<head>
<title>::FIEL Cont�bil::</title>

<?PHP
global $mensagemErro;
echo "<br>Exibe a mensagem de erro aqui...";
echo "<br>" . $mensagemErro;

?>

