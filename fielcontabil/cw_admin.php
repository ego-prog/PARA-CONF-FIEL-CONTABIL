<?
 // Acesso ao sistema de Administracao do Cont�bil
 // link: cw_admin.php?action=login&userId=APOENA
 $numeroIp = empty($REMOTE_ADDR)?$SERVER_ADDR:$REMOTE_ADDR;

 ?>
<!--							       -->
<!-- FIEL Cont�bil					       -->
<!--  Desenvolvido por APOENA Solu��es em Software Livre       -->
<!--  suporte@apoenasoftwarelivre.com.br		       -->
<!--  http://www.apoenasoftwarelivre.com.br		       -->
<!--							       -->
<!-- Data de Cria��o: 19/09/2003			       -->
<!-- �ltima Atualiza��o: 19/09/2003			       -->
<!-- M�dulo: cw_admin.php				       -->
<!--	Administra��o do Sistema			       -->
<!-- cw_admin.php?action=login&userId=APOENA -->
<html>
<head>
<title>::FIEL Cont�bil::</title>


<script language="javascript">

	//--------------------------------------------
	// validaDados()
	// - Testa validade dos dados preenchidos
	//--------------------------------------------
	function validaDados( controle ) {

		var mensagem = 'Erro(s) de preenchimento encontrado(s):';
		var retorna  = true;

		if ( controle == 1 ) {
		   // -- Empresa
			if ( testaNulo( document.forms[0].cliente ) ) {
				mensagem += '\n - Empresa n�o preenchida';
				retorna = false; }

			// -- Linha 1
			if ( testaNulo( document.forms[0].linha1 ) ) {
				mensagem += '\n - Linha 1 n�o preenchida';
				retorna = false; }

			// -- Linha 2
			if ( testaNulo( document.forms[0].linha2 ) ) {
				mensagem += '\n - Linha 2 n�o preenchida';
				retorna = false; }

			// -- Linha 3
			if ( testaNulo( document.forms[0].linha3 ) ) {
				mensagem += '\n - Linha 3 n�o preenchida';
				retorna = false; }

			// -- Maximo de dias para limpeza do LOG
			if ( testaNulo( document.forms[0].maximo_dias ) ) {
				mensagem += '\n - No. m�ximo de dias n�o para limpeza do LOG n�o preenchido';
				retorna = false; }

			if ( !retorna ) {
			    alert( mensagem );
			    document.forms[0].cliente.focus(); } }

		if ( controle == 2 ) {
			// -- Nome
			if ( testaNulo( document.forms[0].nome ) ) {
				mensagem += '\n - Nome do usu�rio n�o preenchido';
				retorna = false; }

			// -- Login
			if ( testaNulo( document.forms[0].login ) ) {
				mensagem += '\n - Login n�o preenchido';
				retorna = false; }

			// -- Senha
			if ( testaNulo( document.forms[0].senha ) ) {
				mensagem += '\n - Senha n�o preenchida';
				retorna = false; }

			// -- Confirma Senha
			if ( testaNulo( document.forms[0].conf_senha ) ) {
				mensagem += '\n - Confirma senha n�o preenchida';
				retorna = false; }

			// -- Senha
			if ( !comparaCampo( document.forms[0].senha, document.forms[0].conf_senha ) ) {
				mensagem += '\n - Senhas n�o s�o iguais';
				retorna = false; }

			if ( !retorna ) {
				alert( mensagem );
				document.forms[0].nome.focus(); } }

		return retorna;

	}

	//--------------------------------------------
	// comparaCampo()
	// - Testa se campos s�o iguais
	//--------------------------------------------
	function comparaCampo( campo1, campo2 ) {

		return ( campo1.value == campo2.value )?true:false;

	}

	//--------------------------------------------
	// testaNulo()
	// - Testa se campo � nulo
	//--------------------------------------------
	function testaNulo( nome_campo ) {

		return ( nome_campo.value.length == 0 )?true:false;

	}

</SCRIPT>

<?PHP

	// Seta as variaveis para acesso ao banco de dados

	$host	 = "localhost";
	$usuario = "postgres";
	$bd	 = "contabil";
	$senhabd = "retipuj1321";

	if ( empty( $userId ) )
	   $userId="guest";

	if ( empty( $action ) || ( $userId != "APOENA" ) ) {
	   echo "<center><br><h1>Voc� n�o est� habilitado a usar o CW_ADMIN</h1></center>";
	   exit(); }

?>

</head>
<?PHP

   if ( empty( $controleNavegacao ) )
	  $controleNavegacao = 0;


	switch( $controleNavegacao ) {

	// Menu
	default: {
?>
<body bgcolor="#FFFFFF">

	<div align="center">

	<table border="0" width="100%" bgcolor="#000000">
	<tr>
		<td align="center" bgcolor="#000000"><br>
			<font face="Verdana, Tahoma, Arial" size="+1" color="#FFFFFF">
			<b>Administra��o do Sistema - APOENA Software Livre</b>
			<font>
		</td>
	</tr>
	</table>

	<br><br><br><br><br>
	<table border="0" width="60%" bgcolor="#000000">
	<tr>
		<td align="center"><br>
			<font face="Verdana, Tahoma, Arial" size="1" color="#FFFFFF">
			<B>MENU DE ADMINISTRA��O</B>
			<font>
		</td>
	</tr>
	</table>
	<table border="0" width="60%" bgcolor="#c0c0c0">
	<tr>
		<td align="center" bgcolor="#c0c0c0"><br>
			<font face="Verdana, Tahoma, Arial" size="1" color="#000099">
			<a href="cw_admin.php?action=login&userId=APOENA&controleNavegacao=1">Cadastro de Empresas</a>
			<font>
		</td>
	</tr>
	<tr>
		<td align="center" bgcolor="#c0c0c0"><br>
			<font face="Verdana, Tahoma, Arial" size="1" color="#000099">
			<a href="cw_admin.php?action=login&userId=APOENA&controleNavegacao=2">Cadastro de Usu�rios</a>
			<font>
		</td>
	</tr>
	</table>

  </div>

</body>

	<?PHP
		 break; }

	// Inclusao de Empresas
	case 1: {
	?>
	<body bgcolor="#FFFFFF" onLoad="this.document.f_empresa.cliente.focus();">

	<div align="center">

	<table border="0" width="100%" bgcolor="#000000">
	<tr>
		<td align="center" bgcolor="#000000"><br>
			<font face="Verdana, Tahoma, Arial" size="+1" color="#FFFFFF">
			<b>Cadastro de Empresas</b>
			<font>
		</td>
	</tr>
	</table>

	<form action="cw_admin.php"
				name="f_empresa" method="post" enctype="multipart/form-data"
				onSubmit="return validaDados( 1 );">

	<input type="hidden" name="action" value="login">
	<input type="hidden" name="userId" value="APOENA">
	<input type="hidden" name="controleNavegacao" value="3">

	<br>
	<table border="0" width="80%">
	<tr>
		<td align="center" bgcolor="#000000"><br>
			<font face="Verdana, Tahoma, Arial" size="1" color="#FFFFFF">
			<B>Cadastro de Empresas</B>
			<font>
		</td>
	</tr>
	</table>
	<table border="0" width="80%" bgcolor="#c0c0c0">
	<tr>
		<td align="right" width="30%" bgcolor="#c0c0c0">
			<font face="Verdana, Tahoma, Arial" size="1" color="#000099">
			Empresa:
			<font>
		</td>
		<td align="left" width="70%" bgcolor="#c0c0c0">
			<input type="text" name="cliente" size="40" maxlength="70">
		</td>
	</tr>
	<tr>
		<td align="right" width="30%" bgcolor="#c0c0c0">
			<font face="Verdana, Tahoma, Arial" size="1" color="#000099">
			Linha 1:
			<font>
		</td>
		<td align="left" width="70%" bgcolor="#c0c0c0">
			<input type="text" name="linha1" size="40" maxlength="70">
		</td>
	</tr>
	<tr>
		<td align="right" width="30%" bgcolor="#c0c0c0">
			<font face="Verdana, Tahoma, Arial" size="1" color="#000099">
			Linha 2:
			<font>
		</td>
		<td align="left" width="70%" bgcolor="#c0c0c0">
			<input type="text" name="linha2" size="40" maxlength="70">
		</td>
	</tr>
	<tr>
		<td align="right" width="30%" bgcolor="#c0c0c0">
			<font face="Verdana, Tahoma, Arial" size="1" color="#000099">
			Linha 3:
			<font>
		</td>
		<td align="left" width="70%" bgcolor="#c0c0c0">
			<input type="text" name="linha3" size="40" maxlength="70">
		</td>
	</tr>
	<tr>
		<td align="right" width="30%" bgcolor="#c0c0c0">
			<font face="Verdana, Tahoma, Arial" size="1" color="#000099">
			M�ximo de Dias (LOG):
			<font>
		</td>
		<td align="left" width="70%" bgcolor="#c0c0c0">
			<input type="text" name="maximo_dias" size="3" maxlength="3">
		</td>
	</tr>
	<tr>
		<td align="right" width="30%" bgcolor="#c0c0c0">
			<font face="Verdana, Tahoma, Arial" size="1" color="#000099">
			Bras�o:
			<font>
		</td>
		<td align="left" width="70%" bgcolor="#c0c0c0">
			<input type="file" name="logotipo">
		</td>
	</tr>
	<tr>
		<td align="right" width="30%" bgcolor="#c0c0c0">
		&nbsp;
		</td>
		<td align="left" width="70%" bgcolor="#c0c0c0">
			<input type="submit" name="enviar" value="Gravar">
			<input type="reset" name="limpar" value="Limpar Formul�rio">
			<input type="button" name="voltar" value="Voltar" onClick="javascript:history.back();">
		</td>
	</tr>

	</table>

	</form>

	</div>

	</body>


	<?PHP
		 break; }

	// Inclusao de usu�rios
	case 2: {
	?>

	<body bgcolor="#FFFFFF" onLoad="this.document.f_usuario.nome.focus();">

	<div align="center">

	<table border="0" width="100%" bgcolor="#000000">
	<tr>
		<td align="center" bgcolor="#000000"><br>
			<font face="Verdana, Tahoma, Arial" size="+1" color="#FFFFFF">
			<b>Cadastro de Usu�rios</b>
			<font>
		</td>
	</tr>
	</table>

	<form action="cw_admin.php"
				name="f_usuario" method="post" onSubmit="return validaDados( 2 );">

	<input type="hidden" name="action" value="login">
	<input type="hidden" name="userId" value="APOENA">
	<input type="hidden" name="controleNavegacao" value="4">

	<br>
	<table border="0" width="80%">
	<tr>
		<td align="center" bgcolor="#000000"><br>
			<font face="Verdana, Tahoma, Arial" size="1" color="#FFFFFF">
			<B>Cadastro de Usu�rios</B>
			<font>
		</td>
	</tr>
	</table>
	<table border="0" width="80%" bgcolor="#c0c0c0">
	<tr>
		<td align="right" width="30%" bgcolor="#c0c0c0">
			<font face="Verdana, Tahoma, Arial" size="1" color="#000099">
			Nome:
			<font>
		</td>
		<td align="left" width="70%" bgcolor="#c0c0c0">
			<input type="text" name="nome" size="30" maxlength="40">
		</td>
	</tr>
	<tr>
		<td align="right" width="30%" bgcolor="#c0c0c0">
			<font face="Verdana, Tahoma, Arial" size="1" color="#000099">
			Login:
			<font>
		</td>
		<td align="left" width="70%" bgcolor="#c0c0c0">
			<input type="text" name="login" size="10" maxlength="12">
		</td>
	</tr>
	<tr>
		<td align="right" width="30%" bgcolor="#c0c0c0">
			<font face="Verdana, Tahoma, Arial" size="1" color="#000099">
			Senha:
			<font>
		</td>
		<td align="left" width="70%" bgcolor="#c0c0c0">
			<input type="password" name="senha" size="10" maxlength="12">
		</td>
	</tr>
	<tr>
		<td align="right" width="30%" bgcolor="#c0c0c0">
			<font face="Verdana, Tahoma, Arial" size="1" color="#000099">
			Senha:
			<font>
		</td>
		<td align="left" width="70%" bgcolor="#c0c0c0">
			<input type="password" name="conf_senha" size="10" maxlength="12">
		</td>
	</tr>
	<tr>
		<td align="right" width="30%" bgcolor="#c0c0c0">
			<font face="Verdana, Tahoma, Arial" size="1" color="#000099">
			Perfil do usu�rio:
			<font>
		</td>
		<td align="left" width="70%" bgcolor="#c0c0c0">
			<select name="perfilusuario">
				<option value="A">Administra��o do Sistema</option>
				<option value="S">Supervis�o Operacional</option>
				<option value="O">Operador Cont�bil</option>
			</select>
		</td>
	</tr>

	<tr>
		<td align="right" width="30%" bgcolor="#c0c0c0">
			<font face="Verdana, Tahoma, Arial" size="1" color="#000099">
			Empresa:
			<font>
		</td>
		<td align="left" width="70%" bgcolor="#c0c0c0">
			<select name="codigocliente">

			<?PHP
			  $param  = " host=".$host." port=5432 dbname=".$bd;
			  $param .= " user=".$usuario." password=".$senhabd;

			if ( !( $banco=pg_connect( $param ) ) ) {
				echo "N�o foi poss�vel estabelecer conex�o com o Banco o de dadoso";
				exit;
				}

	    $inst  = "select codigocliente,cliente from parametro_cont ";
	    $inst .= " order by cliente;";

			// Envia a Query para o BD
			$resultado = @pg_exec( $banco, $inst );
			$numlin    = @pg_numrows( $resultado );
			if ( $numlin > 0 ) {
				for ( $indx = 0; $indx < $numlin; $indx++ ) {
				echo "<option value=\"" .  pg_result( $resultado, $indx, 0 ) . "\">";
				echo pg_result( $resultado, $indx, 1) . "</option>\n";
				}
			}
			pg_close( $banco );

			?>


			</select>
		</td>
	</tr>
	<tr>
		<td align="right" width="30%" bgcolor="#c0c0c0">
		&nbsp;
		</td>
		<td align="left" width="70%" bgcolor="#c0c0c0">
			<input type="submit" name="enviar" value="Gravar">
			<input type="reset" name="limpar" value="Limpar Formul�rio">
			<input type="button" name="voltar" value="Voltar" onClick="javascript:history.back();">
		</td>
	</tr>

	</table>

	</form>

	</div>

	</body>

	<?PHP
		 break; }

	case 3: {

		 // Fazer todas as manipulacoes (Montagem de string e conexao com BD aqui)

		// Copia para o diretorio imagens
		$copia = copy( $logotipo, "imagens/" . $logotipo_name );
		$logotipo = $logotipo_name;


	// Caso n�o consiga criar uma conex�o...
		$param	= " host=".$host." port=5432 dbname=".$bd;
		$param .= " user=".$usuario." password=".$senhabd;
		if ( !( $banco=pg_connect( $param ) ) ) {

			echo "<center><h1>N�o foi possivel acessar o banco de dados !!</h1></center>";

		exit;
		}

		// Monta a Query de inclus�o de Registro
		$inst	= "insert into parametro_cont ";
		$inst  .= "( codigocliente, cliente, linha1, linha2, linha3, ";
		$inst  .= "maximodiaslog, logotipo )";
		$inst  .= " values ";
		$inst  .= "( nextval('parametro_cont_pk'), '$cliente', '$linha1','$linha2', '$linha3', ";
		$inst  .= "'$maximo_dias', '$logotipo_name' );";

		$resultado = pg_exec( $banco, $inst );



		if ( !$resultado ) {
			echo "<center><h1>N�o foi possivel incluir os dados no banco de dados !!</h1></center>";
			echo "<br>" . $inst ."<br>";
			exit;
		}
		else {
			echo "<center><h1>Inclus�o de Prefeitura realizada com sucesso!!</h1></center>";
		}
		pg_close( $banco );


	?>
	  <center>
	  <a href="javascript:history.back();">Voltar</a></center>

	<?PHP
		 break; }

	case 4: {

		 // Fazer todas as manipulacoes (Montagem de string e conexao com BD aqui)

		// Caso n�o consiga criar uma conex�o...
		$param	= " host=".$host." port=5432 dbname=".$bd;
		$param .= " user=".$usuario." password=".$senhabd;
		if ( !( $banco=pg_connect( $param ) ) ) {

			echo "<center><h1>N�o foi possivel acessar o banco de dados !!</h1></center>";

		exit;
		}

		// Monta a Query de inclus�o de Registro
		$inst	= "insert into usuario_cont ";
		$inst  .= "( codigocliente, codigo, nome, login, senha, perfilusuario )";
		$inst  .= " values ";
		$inst  .= "( '$codigocliente', nextval('usuario_cont_pk'), '$nome', '$login', '$senha', '$perfilusuario');";

		$resultado = pg_exec( $banco, $inst );



		if ( !$resultado ) {
			echo "<center><h1>N�o foi possivel incluir os dados no banco de dados !!</h1></center>";
			echo "<br>" . $inst ."<br>";
			exit;
		}
		else {
			echo "<center><h1>Inclus�o de Usuario realizada com sucesso!!</h1></center>";
		}
		pg_close( $banco );


	?>
	  <center>
	  <a href="javascript:history.back();">Voltar</a></center>

<?PHP
		 break; }

	}
?>

</html>
