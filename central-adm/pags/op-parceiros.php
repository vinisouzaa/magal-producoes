<?php
session_start();
include_once("check-sess.php");
?>
<div id="pags">
<?php

$op    = addslashes(strip_tags(trim($_GET['op'])));
$id    = addslashes(strip_tags(trim($_GET['id'])));
$etapa = addslashes(strip_tags(trim($_GET['etapa'])));
$pg    = addslashes(strip_tags(trim($_GET['pg'])));

if ($etapa == ''){
  $etapa = "etapa1";
}

/*********************************************************************** abre a etapa1 e abre a op alterar *****************************************************************/
if($op == 'alterar' ){

if($etapa =='etapa1'){
	
	
  $sql = 'SELECT * FROM parceiros WHERE id = :id';
  
  try{
  $query = $con->prepare($sql);
  $query->bindValue(':id',$id,PDO::PARAM_STR);
  $query->execute();
  $res   = $query->fetchAll(PDO::FETCH_ASSOC);
  $count = $query->rowCount(PDO::FETCH_ASSOC);
		 
		 if($count == 0){
			 
			 echo "<div class='msg erro'><span>A página que você está tentando acessar não existe!</span></div>";
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
    <td align="center" class="td_titulo">
      <span class="titulo1">Alterar Parceiro</span>
    </td>
  </tr>
  
</table>

<form action="?pg=<?php echo $pg; ?>&op=<?php echo $op; ?>&etapa=etapa2&id=<?php echo $dados['id']; ?>" method="post" enctype="multipart/form-data">
<table border="0" id="tabela2">

  <tr>
    <td width="15%" height="47" align="center" class="td_topico">link:</td>
    <td colspan="2" align="left" class="td_input">
      <input type="text" name="link" value="<?php echo $dados['link']; ?>" class="input" />
    </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">Deseja Alterar a Imagem?</td>
    <td width="12%" align="left" class="td_input"><label>Não <input type="radio" name="rd-img" value="nao" checked="checked" /></label></td>
    <td colspan="2" align="left" class="td_input"><label>Sim <input type="radio" name="rd-img" value="sim" /></label></td>
    </tr>
  <tr>
    <td height="62" align="center" class="td_topico">Imagem:</td>
    <td colspan="3" align="left" class="td_input">
      <input type="file" name="imagem" />
    </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">&nbsp;</td>
    <td colspan="2" align="left" class="td_input">
      <input type="submit" value="Alterar" class="btn" />
      </td>
  </tr>
  
</table>
</form>

<?php

}/*********************************************************************** Fecha a etapa1 e continua na op alterar *****************************************************************/



/*********************************************************************** Começa a etapa2 e continua na op alterar *****************************************************************/
if($etapa =='etapa2'){
	
$link     = $_POST['link'];
$dataImg  = date('d-m-Y');
$radioImg = $_POST['rd-img'];


/******************************************************************************************************************************************************************************
************************************************************************************ ALTERANDO IMAGEM ANTIGA ******************************************************************
*******************************************************************************************************************************************************************************/

if($radioImg == "sim"){


/* Buscando a imagem antiga para apagá-la */
$sqlAntiga = 'SELECT * FROM parceiros WHERE id = :id';

try{
$queryAntiga = $con->prepare($sqlAntiga);
$queryAntiga->bindValue(':id',$id,PDO::PARAM_STR);
$queryAntiga->execute();
$resAntiga   = $queryAntiga->fetchAll(PDO::FETCH_ASSOC);


}catch (PDOexception $errorSelectAntiga){
  echo 'Erro ao selecionar '.$errorSelectAntiga->getMessage();
}

foreach($resAntiga as $dadosAntiga){
  $foto_antiga = $dadosAntiga['imagem']; 
  $uploaddir   = "../images/parceiros/"; 
}

if($foto_antiga){
  unlink($uploaddir.$foto_antiga);
}

$caminho   = $_FILES['imagem']['tmp_name'];
$imagem    = $_FILES['imagem'];
$tam_img   = getimagesize($caminho);


if($tam_img[0] > 500){
$nome = $dataImg.'-'.md5(uniqid(rand(), true)).'.'.end(explode('.', $imagem['name']));
$permissao = array('image/jpeg', 'image/jpg', 'image/pjpeg','image/png', 'image/x-png','image/gif');
		if(in_array($imagem['type'], $permissao)){
			resize($caminho, $nome, 500, $uploaddir);
		}else{
			echo '<div class="msg erro"><span>Esta imagem está fora das permissões de arquivo. Apenas JPG, GIF e PNG</span></div>';
			echo '<div class="msg erro"><span>Imagem: '.$imagem['name'].'</span></div>';
		}
}else{
if($imagem != "none") {// verifica campo arquivo
	if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploaddir . $_FILES['imagem']['name'])) {
	/* Renomeando a imagem */
	$nome = $dataImg.'-'.md5(uniqid(rand(), true)).'.'.end(explode('.', $imagem['name']));
	rename($uploaddir.$imagem['name'], $uploaddir.$nome);
	}
  }
}


$sql  = 'UPDATE parceiros SET imagem = :imagem WHERE id = :id';
  try{
  $query = $con->prepare($sql);
  $query->bindValue(':imagem',$nome,PDO::PARAM_STR);
  $query->bindValue(':id',$id,PDO::PARAM_STR);
  $query->execute();
  
  }catch (PDOexception $errorSelect){
   echo "<div class='msg erro'><span>Erro ao Atualizar dados.</span></div> <br /><br />Código do erro:  ".$errorSelect->getMessage();
  }


}
/*****************************************************************************************************************************************************************************
************************************************************************************ TERMINA A ALTERAÇÃO DA IMAGEM ***********************************************************
******************************************************************************************************************************************************************************/

$sql  = 'UPDATE parceiros SET link = :link WHERE id = :id';

  try{
  $query = $con->prepare($sql);
  $query->bindValue(':link',$link,PDO::PARAM_STR);
  $query->bindValue(':id',$id,PDO::PARAM_STR);
  $query->execute();
  
  echo "<div class='msg certo'><span>Parceiro alterado com sucesso!</span></div>";
  echo '<div class="voltar"><a href="?pg=listar-parceiros" title="Voltar"></a></div>';
  
  
  }catch (PDOexception $errorSelect){
   echo "<div class='msg erro'<span>>Erro ao Atualizar dados.</span></div> <br /><br />Código do erro:  ".$errorSelect->getMessage();
  }

  }/**************************************************************************************** Fecha a etapa2 **************************************************************/
}/**************************************************************************************** Fecha a op alterar ***********************************************************/


/*****************************************************************************************************************************************************************************
************************************************************************************ FECHA OPERAÇÃO ALTERAR E ABRE EXCLUIR ***************************************************
******************************************************************************************************************************************************************************/


if($op == 'excluir' ){
	
/******************************************************************************************************************************************************************************
************************************************************************************ APAGANDO A IMAGEM ******************************************************************
*******************************************************************************************************************************************************************************/

  $sqlAntiga = 'SELECT * FROM parceiros WHERE id = :id';
  
  try{
  $queryAntiga = $con->prepare($sqlAntiga);
  $queryAntiga->bindValue(':id',$id,PDO::PARAM_STR);
  $queryAntiga->execute();
  $resAntiga   = $queryAntiga->fetchAll(PDO::FETCH_ASSOC);
  
  
  }catch (PDOexception $errorSelectAntiga){
	echo 'Erro ao selecionar '.$errorSelectAntiga->getMessage();
  }
  
  foreach($resAntiga as $dadosAntiga){
	$foto_antiga = $dadosAntiga['imagem']; 
	$uploaddir   = "../images/parceiros/"; 
  }
  
  if($foto_antiga){
	  /* Se não for um diretório então apague */
	if(!is_dir($uploaddir.$foto_antiga)){
		unlink($uploaddir.$foto_antiga);
	}
  }
  
  $sqlDelete = 'DELETE FROM parceiros WHERE id = :id';
  
  try{
	$queryDelete = $con->prepare($sqlDelete);
	$queryDelete->bindValue(':id',$id,PDO::PARAM_STR);
	$queryDelete->execute();
	  
	echo "<div class='msg certo'><span>Parceiro excluído com sucesso!</span></div>";
	echo '<div class="voltar"><a href="?pg=listar-parceiros" title="Voltar"></a></div>';
	  
  }catch (PDOException $errorDelete){
	  echo "<div class='msg erro'<span>>Erro ao Atualizar dados.</span></div> <br /><br />Código do erro:  ".$errorDelete->getMessage();
  }  
}
/**************************************************************************************** fecha a op excluir *****************************************************************************/

?>


</div>
