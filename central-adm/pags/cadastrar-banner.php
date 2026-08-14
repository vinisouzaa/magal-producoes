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
      <span class="titulo1">Cadastrar Banner</span>
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
    <td height="62" align="center" class="td_topico">Legenda:</td>
    <td align="left" class="td_input"><input type="text" name="legenda" class="input" /></td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">Imagem:</td>
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
	
$link       = addslashes(strip_tags(trim($_POST['link'])));
$legenda    = addslashes(strip_tags(trim($_POST['legenda'])));
$imagem     = $_POST['imagem'];
$data       = date('Y-m-d H:i:s');
$uploaddir  = "../images/banners/";

/* Movendo a Imagem */
if($imagem != "none") {
	
  if (move_uploaded_file($_FILES['imagem']['tmp_name'], $uploaddir . $_FILES['imagem']['name'])) {
  $imagem = $_FILES['imagem']['name'];
  
}}



$sql  = 'INSERT INTO banners (imagem, link, legenda, data) VALUES (:imagem, :link, :legenda, :data)';

  try{
  $query = $con->prepare($sql);
  $query->bindValue(':imagem',$imagem,PDO::PARAM_STR);
  $query->bindValue(':link',$link,PDO::PARAM_STR);
  $query->bindValue(':legenda',$legenda,PDO::PARAM_STR);
  $query->bindValue(':data',$data,PDO::PARAM_STR);
  $query->execute();
  
  echo "<div class='msg certo'><span>Banner cadastrado com sucesso!</span></div>";
  echo '<div class="voltar"><a href="?pg=listar-banners" title="Voltar"></a></div>';
  
  }catch (PDOexception $error_select_Pd){
   echo 'Erro ao Cadastrar '.$error_select_Pd->getMessage();
  }


}

?>


</div>
