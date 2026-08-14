<?php 
session_start();
include_once("check-sess.php"); 
?>
<div id="pags">
<style type="text/css">
<!--
.classe{width:400px; height:30px; background:#E4E4E4;}
.classe:hover{ background:#CCCCCC;}

.submit{ width:150px; height:30px;}


-->
</style>


<?php

$id    = addslashes(strip_tags(trim($_GET['id'])));
$pg    = addslashes(strip_tags(trim($_GET['pg'])));
$etapa = addslashes(strip_tags(trim($_GET['etapa'])));
$cat   = addslashes(strip_tags(trim($_GET['cat'])));

// RECEBENDO AS VARIAVEIS DO FORM //

$img   = $_FILES['img'];
$data  = date("d-m-Y");

if ($etapa == ''){

$etapa = "etapa1";

}

if ($etapa=="etapa1"){

  $sql = 'SELECT * FROM posts WHERE id = :id';
  
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
      <span class="titulo1">Cadastrar Imagens - "<?php echo $dados['titulo']; ?>"</span>
    </td>
  </tr>
  
</table>

<form action="?pg=<?php echo $pg; ?>&id=<?php echo $id; ?>&etapa=etapa2&cat=<?php echo $dados['cat_slug']; ?>" method="post" enctype="multipart/form-data">
<table width="31%" border="0" id="tabela2">

  <tr>
    <td width="14%" height="47" align="center" class="td_topico">Imagem:</td>
    <td width="86%" align="left" class="td_input">
      <input type="file" name="img[]" />
    </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">Imagem:</td>
    <td align="left" class="td_input">
      <input type="file" name="img[]" />
    </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">Imagem:</td>
    <td align="left" class="td_input">
      <input type="file" name="img[]" />
    </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">Imagem:</td>
    <td align="left" class="td_input">
      <input type="file" name="img[]" />
    </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">Imagem:</td>
    <td align="left" class="td_input">
      <input type="file" name="img[]" />
    </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">Imagem:</td>
    <td align="left" class="td_input">
      <input type="file" name="img[]" />
    </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">&nbsp;</td>
    <td align="left" class="td_input">
      <input type="submit" value="Cadastrar" class="btn" />
      <a href="?pg=envia-zip&c=<?php echo $dados['id']; ?>" class="link" title="Enviar fotos Zipadas">Enviar fotos Zipadas</a>
    </td>
  </tr>
  
</table>
</form>

<?php

}

if ( $etapa == "etapa2"){
	
	
$sql = 'SELECT * FROM posts WHERE id = :id';

try{
$query = $con->prepare($sql);
$query->bindValue(':id',$id,PDO::PARAM_STR);
$query->execute();
$res   = $query->fetchAll(PDO::FETCH_ASSOC);

}catch (PDOexception $errorSelect){
echo 'Erro ao selecionar '.$errorSelect->getMessage();
}
foreach($res as $dados){
	
}

$uploaddir = '../images/categorias/'.$dados['pasta'].'/';
$contar    = count($img);
$contar    = $contar+1;
		
for($i = 0; $i < $contar; $i++){

if($img['name'][$i] != ''){

$caminho = $img['tmp_name'][$i];
$tam_img = getimagesize($caminho);

$alt = 'sim';

if($tam_img[0] > 950){
	$nome = $data.'-'.md5(uniqid(rand(), true)).'.'.end(explode('.', $img['name'][$i]));
	$permissao = array('image/jpeg', 'image/jpg', 'image/pjpeg','image/png', 'image/x-png','image/gif');
            if(in_array($img['type'][$i], $permissao)){
				resize($caminho, $nome, 950, $uploaddir);
			}
  }else{
	if($img != "none") {// verifica campo arquivo
		if (move_uploaded_file($img['tmp_name'][$i], $uploaddir . $img['name'][$i])) {
		$nome = $data.'-'.md5(uniqid(rand(), true)).'.'.end(explode('.', $img['name'][$i]));
		rename($uploaddir.$img['name'][$i], $uploaddir.$nome);
		}
  	}  
  }

}

}
	
if($alt == 'sim'){
	
	 echo "<div class='msg certo'><span>Imagens cadastradas com sucesso!</span></div>";
	 echo '<div class="voltar"><a href="?pg=listar-itens-cat&cat='.$cat.'" title="Voltar"></a></div>';

}else{
	
	 echo "<div class='msg erro'><span>Você não fez nenhuma alteração.</span></div>";
	 echo '<div class="voltar"><a href="javascript:history.back()" title="Voltar"></a></div>';
	
}


}
?>
</div>