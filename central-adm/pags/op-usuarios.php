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

$op    = addslashes(strip_tags(trim($_GET['op'])));
$id    = addslashes(strip_tags(trim($_GET['id'])));
$etapa = addslashes(strip_tags(trim($_GET['etapa'])));
$pg    = addslashes(strip_tags(trim($_GET['pg'])));

if ($etapa == ''){
  $etapa = "etapa1";
}

/************************************************************************************************************************************************************************************
************************************************************************************ OPERAÇÃO ATERAR/ETAPA1 *************************************************************************
*************************************************************************************************************************************************************************************/
if($op == 'alterar' ){

if($etapa =='etapa1'){
	
	
  $sql = 'SELECT * FROM usuarios WHERE id = :id';
  
  try{
  $query = $con->prepare($sql);
  $query->bindValue(':id',$id,PDO::PARAM_STR);
  $query->execute();
  $res   = $query->fetchAll(PDO::FETCH_ASSOC);
  $count = $query->rowCount(PDO::FETCH_ASSOC);
	 
	 if($count == 0){
		 
		 echo "<div class='msg erro'><span>Essa página não existe!</span></div>";
		 echo '<div class="voltar"><a href="home.php" title="Voltar"></a></div>';
		 echo "</div>";
		 
		return false; 
	 }
  
  }catch (PDOexception $errorSelect){
  echo 'Erro ao selecionar '.$errorSelect->getMessage();
  }
  foreach($res as $dados){
	  
  }

?>


<table border="0" id="tabela" data-corner="top 8px">

  <tr>
    <td align="center" class="td_titulo"><span class="titulo1">Alterando Usuário</span></td>
  </tr>
  
</table>

<form action="?pg=<?php echo $pg; ?>&op=<?php echo $op; ?>&etapa=etapa2&id=<?php echo $dados['id']; ?>" method="post">
<table width="45%" border="0" id="tabela2">
  <tr>
    <td height="62" align="center" class="td_topico">Nome:</td>
    <td colspan="3" align="left" class="td_input">
      <input type="text" name="nome" value="<?php echo $dados['nome']; ?>" class="input tipTip" title="Nome do Usuário" />
    </td>
  </tr>
  <tr>
    <td width="16%" height="62" align="center" class="td_topico">Nível:</td>
    <td colspan="3" align="left" class="td_input">
    <select class="select tipTip" name="nivel" title="O Nível 2 e 3 não cadastra novos usuários e não tem acesso as opções de úsuarios, já o nivel 1 tem acesso permitido a todas as opções.">
      <option value="<?php echo $dados['nivel']; ?>" selected><?php echo $dados['nivel']; ?></option>
      <option value="" disabled>=======================</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
    </select>   
      </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">E-mail:</td>
    <td colspan="3" align="left" class="td_input">
      <input type="text" name="email" value="<?php echo $dados['email']; ?>" class="input tipTip" title="Podem ser cadastrados vários emails. Separe com (, ) VÍRGULA E ESPAÇO" />
    </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">Login:</td>
    <td width="28%" align="left" class="td_input">
      <input type="text" name="login" value="<?php echo $dados['login']; ?>" class="input2 tipTip" title="O login deve ter entre 4 e 16 caracteres" />
      <input type="hidden" name="loginAntigo" value="<?php echo $dados['login']; ?>" />
      </td>
    <td width="13%" align="left" class="td_input">Senha:</td>
    <td width="43%" align="left" class="td_input">
      <input type="password" name="code" value="<?php echo $dados['code']; ?>" class="input2 tipTip" title="A senha deve ter entre 4 e 16 caracteres" />
      </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">&nbsp;</td>
    <td colspan="3" align="left" class="td_input">
      <input type="submit" value="Alterar Usuário" class="btn" />      
    </td>
  </tr>
  
</table>
</form>

<?php

}

/************************************************************************************************************************************************************************************
************************************************************************************ OPERAÇÃO ATERAR/ETAPA2 *************************************************************************
*************************************************************************************************************************************************************************************/

if($etapa =='etapa2'){

/************************************************************************************************************************************************************************************
************************************************************************************ RECEBENDO AS VARIÁVEIS *************************************************************************
*************************************************************************************************************************************************************************************/

$nome         = addslashes(strip_tags(trim($_POST['nome'])));
$nivel        = addslashes(strip_tags(trim($_POST['nivel'])));
$email        = addslashes(strip_tags(trim($_POST['email'])));
$login        = addslashes(strip_tags(trim($_POST['login'])));
$loginAntigo  = addslashes(strip_tags(trim($_POST['loginAntigo'])));
$code         = addslashes(strip_tags(trim($_POST['code'])));
$senha        = md5($code);

//CORRIGINDO AS VARIÁVEIS
$nome         = corrigeTexto($nome);

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
  $resFind  = $queryFind->fetchAll(PDO::FETCH_ASSOC);
  $count = $queryFind->rowCount(PDO::FETCH_ASSOC);
  }catch (PDOexception $error_selectFind){
   echo 'Erro ao Selecionar Logins '.$error_selectFind->getMessage();
  }
  
  foreach($resFind as $dadosLogin);
  
  if($count > 0 && $dadosLogin['login'] != $loginAntigo){
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
************************************************************************************ FAZ A ALTERAÇÃO NO BANCO DE DADOS ***************************************************************
*************************************************************************************************************************************************************************************/


$sql  = 'UPDATE usuarios SET nivel = :nivel, nome = :nome, email = :email, login = :login, senha = :senha, code = :code WHERE id = :id';

  try{
  $query = $con->prepare($sql);
  $query->bindValue(':nivel',$nivel,PDO::PARAM_STR);
  $query->bindValue(':nome',$nome,PDO::PARAM_STR);
  $query->bindValue(':email',$email,PDO::PARAM_STR);
  $query->bindValue(':login',$login,PDO::PARAM_STR);
  $query->bindValue(':senha',$senha,PDO::PARAM_STR);
  $query->bindValue(':code',$code,PDO::PARAM_STR);
  $query->bindValue(':id',$id,PDO::PARAM_STR);
  $query->execute();
  
  echo "<div class='msg certo'><span>Usuário alterado com sucesso!</span></div>";
  echo '<div class="voltar"><a href="?pg=listar-usuarios" title="Voltar"></a></div>';
  
  }catch (PDOexception $errorSelect){
   echo "<div class='msg erro'><span>Erro ao Atualizar dados.</span></div> <br /><br />Código do erro:  ".$errorSelect->getMessage();
  }

  }
}

/************************************************************************************************************************************************************************************
************************************************************************************ FECHA OPERAÇÃO ALTERAR E ABRE EXCLUIR **********************************************************
*************************************************************************************************************************************************************************************/

if($op == 'excluir' ){

// DELETANDO DO BANCO DE DADOS
$sqlDelete = 'DELETE FROM usuarios WHERE id = :id';

try{
  $queryDelete = $con->prepare($sqlDelete);
  $queryDelete->bindValue(':id',$id,PDO::PARAM_STR);
  $queryDelete->execute();
  	
  echo "<div class='msg certo'><span>Usuário excluído com sucesso!</span></div>";
  echo '<div class="voltar"><a href="?pg=listar-usuarios" title="Voltar"></a></div>';
	
}catch (PDOException $errorDelete){
	echo "<div class='msg erro'><span>Erro ao deletar dados.</span></div> <br /><br />Código do erro:  ".$errorDelete->getMessage();
}  
}
/**************************************************************************************** fecha a op excluir *****************************************************************************/

?>


</div>