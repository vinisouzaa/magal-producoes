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
	
	
  $sql = 'SELECT * FROM banners WHERE id = :id';
  
  try{
  $query = $con->prepare($sql);
  $query->bindValue(':id',$id,PDO::PARAM_STR);
  $query->execute();
  $res   = $query->fetchAll(PDO::FETCH_ASSOC);
  $count = $query->rowCount(PDO::FETCH_ASSOC);
		 
		 if($count == 0){
			 
			 echo "<div class='msg erro'>Erro!<span>A página que você está tentando acessar não existe!</span></div>";
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
      <span class="titulo1">Alterar Banner</span>
    </td>
  </tr>
  
</table>

<form action="?pg=<?php echo $pg; ?>&op=<?php echo $op; ?>&etapa=etapa2&id=<?php echo $dados['id']; ?>" method="post" enctype="multipart/form-data">
<table width="45%" border="0" id="tabela2">

  <tr>
    <td width="14%" height="47" align="center" class="td_topico">Link:</td>
    <td colspan="2" align="left" class="td_input">
      <input type="text" name="link" class="input" value="<?php echo $dados['link']; ?>" />
    </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">Legenda:</td>
    <td colspan="2" align="left" class="td_input"><input type="text" name="legenda" value="<?php echo $dados['legenda']; ?>" class="input" /></td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">Deseja alterar a imagem?</td>
    
    <td width="11%" class="td_input">Sim
      <input name="radio_imagem" type="radio" value="sim" class="radio"  /></td>
    <td width="75%" colspan="2" class="td_input">Não
      <input name="radio_imagem" type="radio" value="nao" class="radio" checked="checked"/></td>
    </tr>
  <tr>
    <td height="62" align="center" class="td_topico">Imagem:</td>
    <td colspan="2" align="left" class="td_input"><input type="file" name="imagem" /></td>
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
	
$link       = addslashes(strip_tags(trim($_POST['link'])));
$legenda    = addslashes(strip_tags(trim($_POST['legenda'])));
$imagem     = $_POST['imagem'];
$data       = date('Y-m-d H:i:s');
$uploaddir  = "../images/banners/";
$radioImg   = $_POST['radio_imagem'];


/************************************************************************** Apagando a imagem antiga **********************************************************************************/
if($radioImg == "sim"){


$sqlAntiga = 'SELECT * FROM banners WHERE id = :id';

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
}

if($foto_antiga){
  unlink($uploaddir.$foto_antiga);
}



if($imagem != "none") {
	
  if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploaddir . $_FILES['imagem']['name'])) {
  $imagem = $_FILES['imagem']['name'];
  
}}

$sql  = 'UPDATE banners SET imagem = :imagem WHERE id = :id';
  try{
  $query = $con->prepare($sql);
  $query->bindValue(':imagem',$imagem,PDO::PARAM_STR);
  $query->bindValue(':id',$id,PDO::PARAM_STR);
  $query->execute();
  
  $alt = 1;
  
  }catch (PDOexception $errorSelect){
   echo "<div class='msg erro'><span>Erro ao Atualizar dados</span>.</div> <br /><br />Código do erro:  ".$errorSelect->getMessage();
  }


}
/************************************************************************** Apagando a imagem antiga **********************************************************************************/




$sql  = 'UPDATE banners SET link = :link, legenda = :legenda, data = :data WHERE id = :id';

  try{
  $query = $con->prepare($sql);
  $query->bindValue(':link',$link,PDO::PARAM_STR);
  $query->bindValue(':legenda',$legenda,PDO::PARAM_STR);
  $query->bindValue(':data',$data,PDO::PARAM_STR);
  $query->bindValue(':id',$id,PDO::PARAM_STR);
  $query->execute();
  
  echo "<div class='msg certo'><span>Banner alterado com sucesso!</span><br /></div>";
  echo '<div class="voltar"><a href="?pg=listar-banners" title="Voltar"></a></div>';
  
  
  }catch (PDOexception $errorSelect){
   echo "<div class='msg erro'><span>Erro ao Atualizar dados</span>.</div> <br /><br />Código do erro:  ".$errorSelect->getMessage();
  }

  }/**************************************************************************************** Fecha a etapa2 *******************************************************************************/
}/**************************************************************************************** Fecha a op alterar *****************************************************************************/


/**************************************************************************************** abre a op excluir *****************************************************************************/
if($op == 'excluir' ){
	
  // Apagando a foto da pasta
  $sqlAntiga = 'SELECT * FROM banners WHERE id = :id';
  
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
  }
  
  $uploaddir  = "../images/banners/";
  
  if($foto_antiga){
	unlink($uploaddir.$foto_antiga);
  }
  
  // Deletando do banco de dados
  
  $sqlDelete = 'DELETE FROM banners WHERE id = :id';
  
  try{
	$queryDelete = $con->prepare($sqlDelete);
	$queryDelete->bindValue(':id',$id,PDO::PARAM_STR);
	$queryDelete->execute();
	  
	echo "<div class='msg certo'><span>Banner excluído com sucesso!</span></div>";
	echo '<div class="voltar"><a href="?pg=listar-banners" title="Voltar"></a></div>';
	  
  }catch (PDOException $errorDelete){
	  echo "<div class='msg erro'><span>Erro ao deletar dados</span>.</div> <br /><br />Código do erro:  ".$errorDelete->getMessage();
  }  
}
/**************************************************************************************** fecha a op excluir *****************************************************************************/

?>


</div>
