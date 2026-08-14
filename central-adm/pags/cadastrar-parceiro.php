<?php
session_start();
include_once("check-sess.php");
?>
<div id="pags">
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
    <td align="center" class="td_titulo">
      <span class="titulo1">Cadastrar Parceiro</span>
    </td>
  </tr>
  
</table>

<form action="?pg=<?php echo $pg; ?>&etapa=etapa2" method="post" enctype="multipart/form-data">
<table border="0" id="tabela2">

  <tr>
    <td width="14%" height="47" align="center" class="td_topico">Link:</td>
    <td width="86%" align="left" class="td_input">
      <input type="text" name="link" class="input" />
    </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">Foto:</td>
    <td align="left" class="td_input"><input type="file" name="imagem" /></td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">&nbsp;</td>
    <td align="left" class="td_input">
      <input type="submit" value="Cadastrar" class="btn" />
      </td>
  </tr>
  
</table>
</form>

<?php

}
if($etapa =='etapa2'){
	
$link     = $_POST['link'];
$imagem   = $_FILES['imagem'];
$dataImg  = date('d-m-Y');

/*****************************************************************************************************************************************************************************
************************************************************************************ MOVENDO A IMAGEM ************************************************************************
******************************************************************************************************************************************************************************/

if($imagem['name'] != ''){

$uploaddir = "../images/parceiros/";
$caminho   = $_FILES['imagem']['tmp_name'];
$tam_img   = getimagesize($caminho);

if($tam_img[0] > 500){
	$nomeImg = $dataImg.'-'.md5(uniqid(rand(), true)).'.'.end(explode('.', $imagem['name']));
	$permissao = array('image/jpeg', 'image/jpg', 'image/pjpeg','image/png', 'image/x-png','image/gif');
            if(in_array($imagem['type'], $permissao)){
				resize($caminho, $nomeImg, 500, $uploaddir);
			}else{
				echo '<div class="msg erro"><span>Esta imagem está fora das permissões de arquivo. Apenas JPG, GIF e PNG</span></div>';
				echo '<div class="msg erro"><span>Imagem: '.$imagem['name'].'</span></div>';
			}
  }else{
	if($imagem != "none") {// verifica campo arquivo
		if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploaddir . $_FILES['imagem']['name'])) {
		/* Renomeando a imagem */
	    $nomeImg = $dataImg.'-'.md5(uniqid(rand(), true)).'.'.end(explode('.', $imagem['name']));
	    rename($uploaddir.$imagem['name'], $uploaddir.$nomeImg);
		}
  	}
  }

}

$sql  = 'INSERT INTO parceiros (imagem, link) VALUES (:imagem, :link)';

  try{
  $query = $con->prepare($sql);
  $query->bindValue(':imagem',$nomeImg,PDO::PARAM_STR);
  $query->bindValue(':link',$link,PDO::PARAM_STR);
  $query->execute();
  
  echo "<div class='msg certo'><span>Parceiro cadastrado com sucesso!</span></div>";
  echo '<div class="voltar"><a href="?pg=listar-parceiros" title="Voltar"></a></div>';
  
  }catch (PDOexception $errorSelect){
   echo 'Erro ao Cadastrar '.$errorSelect->getMessage();
  }


}

?>


</div>
