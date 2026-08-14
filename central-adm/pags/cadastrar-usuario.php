<?php 
 
session_start();
include_once("check-sess.php"); 

// RESTRITO - SOMENTE NIVEL 1 TEM ACESSO
if(!checkNivel('1')){
	header('Location: home.php');
}

?>
<div class="pags">
<?php

$etapa = addslashes(strip_tags(trim($_GET['etapa'])));
$pg    = addslashes(strip_tags(trim($_GET['pg'])));

if ($etapa == ''){

	$etapa = "etapa1";

}

if($etapa == 'etapa1'){
	
?>

<table border="0" id="tabela" data-corner="top 8px">

  <tr>
    <td align="center" class="td_titulo"><span class="titulo1">Cadastro de Usuário</span></td>
  </tr>
  
</table>

<form action="?pg=<?php echo $pg; ?>&etapa=etapa2" method="post">
<table width="45%" border="0" id="tabela2">
  <tr>
    <td height="62" align="center" class="td_topico">Nome:</td>
    <td colspan="3" align="left" class="td_input">
      <input type="text" name="nome" class="input tipTip" title="Nome do Usuário" />
    </td>
  </tr>
  <tr>
    <td width="16%" height="62" align="center" class="td_topico">Nível:</td>
    <td colspan="3" align="left" class="td_input">
    <select class="select tipTip" name="nivel" title="O Nível 2 não cadastra novos usuários e não tem acesso as opções de úsuarios, já o nivel 1 tem acesso permitido a todas as opções.">
      <option value="1" selected>1</option>
      <option value="2">2</option>
    </select>   
      </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">E-mail:</td>
    <td colspan="3" align="left" class="td_input">
      <input type="text" name="email" class="input tipTip" title="Podem ser cadastrados vários emails. Separe com (, ) VÍRGULA E ESPAÇO" />
    </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">Login:</td>
    <td width="28%" align="left" class="td_input">
      <input type="text" name="login" class="input2 tipTip" title="O login deve ter entre 4 e 16 caracteres" />
      </td>
    <td width="13%" align="left" class="td_input">Senha:</td>
    <td width="43%" align="left" class="td_input">
      <input type="password" name="code" class="input2 tipTip" title="A senha deve ter entre 4 e 16 caracteres" />
      </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">&nbsp;</td>
    <td colspan="3" align="left" class="td_input">
      <input type="submit" value="Cadastrar Usuário" class="btn" />      
    </td>
  </tr>
  
</table>
</form>

<?php

}
if($etapa =='etapa2'){

/************************************************************************************************************************************************************************************
************************************************************************************ RECEBENDO AS VARIÁVEIS *************************************************************************
*************************************************************************************************************************************************************************************/

$nome   = addslashes(strip_tags(trim($_POST['nome'])));
$nivel  = addslashes(strip_tags(trim($_POST['nivel'])));
$email  = addslashes(strip_tags(trim($_POST['email'])));
$login  = addslashes(strip_tags(trim($_POST['login'])));
$code   = addslashes(strip_tags(trim($_POST['code'])));
$senha  = md5($code);

//CORRIGINDO AS VARIÁVEIS
$nome = corrigeTexto($nome);

/************************************************************************************************************************************************************************************
************************************************************************************ VALIDANDO OS CAMPOS ****************************************************************************
*************************************************************************************************************************************************************************************/

// VALIDANDO OS CAMPOS

$valEmail = valida_email($email);
if($valEmail == false){
	echo'
	<div class="msg erro">
	  Erro!
	  <span>E-mail inválido!</span>
	</div>
	<div class="voltar"><a href="javascript:history.back()" title="Voltar"></a></div>
	';
	echo '</div>';
	return false;
}

$valLogin = verificaCampos($login, 4, 'Login');
if($valLogin['condicao'] == 'falso'){
	echo'
	<div class="msg erro">
	  Erro!
	  <span>'.$valLogin['erro'].'</span>
	</div>
	<div class="voltar"><a href="javascript:history.back()" title="Voltar"></a></div>
	';
	echo '</div>';
	return false;
}

$valCode = verificaCampos($code, 4, 'Senha');
if($valCode['condicao'] == 'falso'){
	echo'
	<div class="msg erro">
	  Erro!
	  <span>'.$valCode['erro'].'</span>
	</div>
	<div class="voltar"><a href="javascript:history.back()" title="Voltar"></a></div>
	';
	echo '</div>';
	return false;
}


// VERIFICANDO SE O LOGIN EXISTE NO BANCO

$sqlFind  = 'SELECT * FROM usuarios WHERE login = :login';

  try{
  $queryFind = $con->prepare($sqlFind);
  $queryFind->bindValue(':login',$login,PDO::PARAM_STR);
  $queryFind->execute();
  $count = $queryFind->rowCount(PDO::FETCH_ASSOC);
  }catch (PDOexception $error_selectFind){
   echo 'Erro ao Selecionar Logins '.$error_selectFind->getMessage();
  }
  
  if($count > 0){
	echo'
	<div class="msg erro">
	  Erro!
	  <span>O Login "'.$login.'" já existe, por favor escolha outro!</span>
	</div>
	<div class="voltar"><a href="javascript:history.back()" title="Voltar"></a></div>
	';
	echo '</div>';
	return false;
  }


/************************************************************************************************************************************************************************************
************************************************************************************ INSERINDO OS DADOS NO BANCO ********************************************************************
*************************************************************************************************************************************************************************************/

$sql  = 'INSERT INTO usuarios (nivel, nome, email, login, senha, code) ';
$sql .= 'VALUES (:nivel, :nome, :email, :login, :senha, :code)';

  try{
  $query = $con->prepare($sql);
  $query->bindValue(':nivel',$nivel,PDO::PARAM_STR);
  $query->bindValue(':nome',$nome,PDO::PARAM_STR);
  $query->bindValue(':email',$email,PDO::PARAM_STR);
  $query->bindValue(':login',$login,PDO::PARAM_STR);
  $query->bindValue(':senha',$senha,PDO::PARAM_STR);
  $query->bindValue(':code',$code,PDO::PARAM_STR);
  $query->execute();
  
  echo "
	<div class='msg certo'>
	  <span>Usuário cadastrado com sucesso!</span>
	</div>
  ";
  echo '<div class="voltar"><a href="?pg=listar-usuarios" title="Voltar"></a></div>';
  
  }catch (PDOexception $errorUpdate){
   echo 'Erro ao Cadastrar '.$errorUpdate->getMessage();
  }
  
}

?>

</div>
