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
        FIEL Contábil
        Desenvolvido por APOENA Soluções em Software Livre
        suporte@apoenasoftwarelivre.com.br
        http://www.apoenasoftwarelivre.com.br

        Data de Criação: 21/03/2005
        Última Atualização: 21/03/2005
        Módulo: cwCadCentro.php
          Cadastro de Centros de Custo
-->

<html>
<head>
<title>::FIEL Contábil::</title>

<?PHP
global $mensagemErro;
echo "<br>Exibe a mensagem de erro aqui...";
echo "<br>" . $mensagemErro;

?>

