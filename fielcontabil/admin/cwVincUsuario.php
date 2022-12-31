<!--
        FIEL Contábil
        Desenvolvido por APOENA Soluções em Software Livre
        suporte@apoenasoftwarelivre.com.br
        http://www.apoenasoftwarelivre.com.br

        Data de Criação: 08/05/2005
        Última Atualização: 08/05/2005
        Módulo: cwVincUsuario.php
          Opção para Vincular Usuários a Empresas
-->
<html>
<head>
<title>::FIEL Contábil::</title>

<script language="javascript">

        //--------------------------------------------
        // voltaMenuAdmin()
        // - Retorna ao Menu Admministração
        //--------------------------------------------
        function voltaMenuAdmin( ) {

                 document.location = "cwMenuAdmin.php";

        }

        //--------------------------------------------
        // excluiVinculo()
        // - Exclui um vinculo
        //--------------------------------------------
        function excluiVinculo( codigoUsuarioEmpresa ) {

                 document.location = "cwGravaAdmin.php?tipoOperacao=8&oidUsuarioEmpresa=" + codigoUsuarioEmpresa;

        }
        //--------------------------------------------
        // abreAjuda()
        // - Abre ajuda
        //--------------------------------------------
        function abreAjuda( arquivo ) {

                var janela;
                window.open(arquivo, 'janela',
                'toolbar=no,location=no,directories=no,menubar=no,width=500,height=300');

        }

</SCRIPT>

<!-- Vincula lista de estilos -->
<link rel="stylesheet" type="text/css" href="../estilo/cw.css">

</head>

<body class="pagina">
<?PHP

        // Inclui pacote da aplicacao...
        include "../classes/cw.inc";

        $cabec = new TituloCw( $tituloVincUsuario );
        $cabec->mostra();

        echo "\n<!-- numero da pagina: $numeroPagina -->\n";
?>
        <br><br><br>


<?PHP

                // Carrega os vínculos atuais
                $vinculoUsuarioEmpresa = new UsuarioEmpresa();
                $listaUE = $vinculoUsuarioEmpresa->buscaUsuarioEmpresa( "" );

                // Carrega o vetor de Empresas
                $empresa = new Empresa();
                $listaEmpresas = $empresa->buscaEmpresa( 1, "");

                // Carrega o vetor de Usuários
                $usuario = new UsuarioCw();
                $listaUsuarios = $usuario->buscaUsuario( 1, "");
?>
                <body class="pagina">

                <div align="center">

                <br>

                <form action="cwGravaAdmin.php"
                                        name="formVincUsuario" method="get">

                <input type="hidden" name="tipoOperacao" value="7">
                <table class="ejanela" width="90%">
                <tr class="ejanela">
                <td>
                <!-- Janela -->
                <table border="0" width="100%">
                        <tr>
                        <td border="0" width="85%" class="tjanela">
                                <?PHP echo $tituloVincUsuario; ?>
                        </td>
                        <td width="15%" align="center" class="tjanela">
                                <input type="button" class="btitulo" name= "bt_fechar"
                                        value="<?= $botaoFechaJanela; ?>" onClick="javascript:voltaMenuAdmin();">
                        </td>
                        </tr>
                </table>

                </td>
                </tr>
                <tr>
                <td>

                <!-- Opções do Menu -->
                <table class="cjanela" border="0" width="100%">

                        <tr>
                                <td width="30%" align="right" class="cjanela">
                                  <?PHP echo $campoEmpresa; ?>
                                </td>

                                <td width="70%" align="left" class="cjanela">
                                                <select name="oidEmpresaUsuaria" class="dljanela">
                                                <?PHP
                                                for ( $indx = 0; $indx < sizeof( $listaEmpresas ); $indx++ ) {
                                                ?>
                                                        <option value="<?= trim( $listaEmpresas[$indx][0] ); ?>"><?= trim( $listaEmpresas[$indx][1] ); ?></option>
                                                <?PHP } ?>
                                                </select>
                                </td>
                        </tr>

                        <tr>
                                <td width="30%" align="right" class="cjanela">
                                  <?PHP echo $campoNomeUsuario; ?>
                                </td>

                                <td width="70%" align="left" class="cjanela">
                                                <select name="oidUsuario" class="dljanela">
                                                <?PHP
                                                for ( $indx = 0; $indx < sizeof( $listaUsuarios ); $indx++ ) {
                                                ?>
                                                        <option value="<?= trim( $listaUsuarios[$indx][0] ); ?>"><?= trim( $listaUsuarios[$indx][1] . ' (' . $listaUsuarios[$indx][2] . ')' ); ?></option>
                                                <?PHP } ?>
                                                </select>
                                </td>
                        </tr>

                        <tr>
                                <td width="30%" align="right">&nbsp;
                                </td>
                                <td width="70%" align="left">
                                        <input type="submit" class="bjanela" value="<?PHP echo $botaoIncluir; ?>" name="bt_incluir">
                                        <input type="button" class="bjanela" value="<?PHP echo $botaoImprimir; ?>"
                                                   name="bt_imprimir" OnClick="javascript:window.print();">
                                        <input type="button" class="bjanela"
                                                value="<?PHP echo $botaoVoltar; ?>" name="bt_voltar"
                                                OnClick="javascript:voltaMenuAdmin();">
                                </td>
                        </tr>

                </table>
                </td>
                </tr>
                </table>
                <br>
           <table width="80%" border="0">
                          <tr>
                          <td align="center" width="45%" class="tjanela">
                          <?= $relatorioEmpresa; ?>
                          </td>
                          <td align="center" width="45%" class="tjanela">
                          <?= $relatorioUsuario; ?>
                          </td>
                          <td align="center" width="10%" class="tjanela">
                          <?= $relatorioOperacao; ?>
                          </td>
                          </tr>

                          <?

                          if ( $listaUE[0][0] != "0" ) {
                                // Comeca laco para apresentacao do relatorio...
                                for ( $indx = 0; $indx < sizeof( $listaUE ); $indx++ ) {

                                                 // Define cor da linha
                                                 $cor = ($indx % 2)==0?"lcons1":"lcons2";
                                                 echo "<tr>";

                                                 echo "<td align=\"left\" width=\"45%\" class=\"".$cor."\">";
                                                 $empresa->pesquisaEmpresa( $listaUE[$indx][2] );
                                                 echo $empresa->getRazaoSocial();
                                                 echo "</td>";

                                                 echo "<td align=\"left\" width=\"45%\" class=\"".$cor."\">";
                                                 $usuario->pesquisaUsuario( $listaUE[$indx][1] );
                                                 echo $usuario->getNome() . " (" . $usuario->getLogin() . ")";
                                                 echo "</td>";

                                                 echo "<td align=\"center\" width=\"30%\" class=\"".$cor."\">";
                                                 echo "<a href=\"javascript:if ( confirm( 'Tem certeza que deseja excluir vínculo de usuário e Empresa?' ) ) excluiVinculo( ".$listaUE[$indx][0]." );\"><img src=\"../imagens/apagar.gif\" border=\"0\" alt=\"$botaoExcluir\"></a>";
                                                 echo "</td>";
                                                 echo "</tr>";

                                         } // Fim do indx...
                           }

                           ?>
                           </table>

                          <br>

                <br>
                </form>

                </div>

                </body>

