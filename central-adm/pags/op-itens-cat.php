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
$cat   = addslashes(strip_tags(trim($_GET['cat'])));

// DEFININDO AS CATEGORIAS
$sqlCat = 'SELECT * FROM categorias WHERE cat_slug = :cat ORDER BY id DESC LIMIT 1';

try{
$queryCat = $con->prepare($sqlCat);
$queryCat->bindValue(':cat',$cat,PDO::PARAM_STR);
$queryCat->execute();
$resCat   = $queryCat->fetchAll(PDO::FETCH_ASSOC);
$countCat = $queryCat->rowCount(PDO::FETCH_ASSOC);
if($countCat == 0){
   echo "<div class='msg erro'>Erro!<span>Essa página não existe!</span></div>";
   echo '</div>';
  return false; 
}
}catch (PDOexception $errorSelectCat){
echo 'Erro ao selecionar '.$errorSelectCat->getMessage();
}
foreach($resCat as $dadosCat);
  
if ($etapa == ''){
  $etapa = "etapa1";
}

/**************************************************************************************
*************** OPERAÇÃO ALTERAR
***************************************************************************************/
if($op == 'alterar' ){

if($etapa =='etapa1'){
	
	
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

<!-- TinyMCE -->
<script type="text/javascript" src="tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="tinymce/plugins/tinybrowser/tb_tinymce.js.php"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
    language : "pt",
		mode : "specific_textareas",
        editor_selector : "textareaE",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,media",

		// Theme options
theme_advanced_buttons1:
"code,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,cleanup,link,unlink,image,table,formatselect,fontselect,",

		// Theme options
		theme_advanced_buttons2 : "fontsizeselect,forecolor,backcolor,fullscreen,media",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",


		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
	 content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
    file_browser_callback : "tinyBrowser",
		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->

<table border="0" id="tabela" data-corner="top 8px">

  <tr>
    <td align="center" class="td_titulo">
      <span class="titulo1">Alterar ítem de: <?php echo $dadosCat['categoria']; ?></span>
    </td>
  </tr>
  
</table>

<form action="?pg=<?php echo $pg; ?>&op=<?php echo $op; ?>&etapa=etapa2&id=<?php echo $dados['id']; ?>&cat=<?php echo $cat; ?>" method="post" enctype="multipart/form-data">

<table width="45%" border="0" id="tabela2">

  <tr>
    <td width="17%" height="47" align="center" class="td_topico">Título:</td>
    <td colspan="2" align="left" class="td_input">
      <input type="text" name="titulo" class="input" value="<?php echo $dados['titulo']; ?>" />
    </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">Texto:</td>
    <td colspan="2" align="left" class="td_input">
      <textarea name="texto" class="textarea textareaE" ><?php echo $dados['texto']; ?></textarea>
      </td>
  </tr>
  
  <?php if($dadosCat['cat_slug'] == 'videos' | $dadosCat['cat_slug'] == 'depoimentos'){ ?>
  <tr>
    <td height="46" align="center" class="td_topico">LINK DO YOUTUBE:</td>
    <td align="left" class="td_input">
      <textarea name="embed" class="textarea" rows="4" ><?php echo $dados['url']; ?></textarea>
    </td>
  </tr>	
  
  <?php }else{ ?>
  
  <tr>
    <td height="62" align="center" class="td_topico">Deseja Alterar a imagem?</td>
    <td width="12%" align="left" class="td_input"><label>Não <input type="radio" name="rd-img" value="nao" checked="checked" /></label></td>
    <td width="71%" align="left" class="td_input"><label>Sim <input type="radio" name="rd-img" value="sim" /></label></td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">Imagem:</td>
    <td colspan="2" align="left" class="td_input">
      <input type="file" name="imagem" />
    </td>
  </tr>
  
  <?php } ?>
  
  <tr>
    <td height="51" align="center" class="td_topico">Tags:</td>
    <td colspan="2" align="left" class="td_input">
      <input type="text" name="tags" class="input" value="<?php echo $dados['tags']; ?>" />
    </td>
  </tr>
  <tr>
    <td height="49" align="center" class="td_topico">Data:</td>
    <td colspan="2" align="left" class="td_input">
      <input type="text" name="data" class="input datepicker" value="<?php echo $dados['data']; ?>" />
    </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">&nbsp;</td>
    <td colspan="2" align="left" class="td_input">
      <input type="submit" value="Alterar" class="btn" />
    </td>
  </tr>
  
</table>

<input type="hidden" name="categoria" value="<?php echo $dadosCat['categoria']; ?>" />

</form>


<?php

}

/**************************************************************************************
*************** ETAPA 2
***************************************************************************************/
if($etapa =='etapa2'){
	

/**************************************************************************************
*************** RECEBENDO AS VARIÁVEIS
***************************************************************************************/
$embed      = '';

$titulo    = $_POST['titulo'];
$texto     = $_POST['texto'];
$tags      = $_POST['tags'];
$data      = $_POST['data'];
$embed    .= $_POST['embed'];
$dataImg   = date('d-m-Y');
$radioImg  = $_POST['rd-img'];
$categoria = $_POST['categoria'];
$catSlug   = $cat;

// CRIANDO O SLUG
include("fatiados/cria_slug.php");
$titSlug  = slug($titulo);
$tagsSlug = tag($tags);

/**************************************************************************************
*************** ALTERANDO A IMAGEM ANTIGA
***************************************************************************************/
if($radioImg == "sim"){

/* Buscando a imagem antiga para apagá-la */
$sqlAntiga = 'SELECT * FROM posts WHERE id = :id';

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
  $uploaddir   = "../images/categorias/".$dadosAntiga['pasta']."/"; 
}

if($foto_antiga){
  unlink($uploaddir.$foto_antiga);
}

$caminho   = $_FILES['imagem']['tmp_name'];
$imagem    = $_FILES['imagem'];
$tam_img   = getimagesize($caminho);

if($tam_img[0] > 950){
$nomeImg   = $dataImg.'-'.md5(uniqid(rand(), true)).'.'.end(explode('.', $imagem['name']));
$permissao = array('image/jpeg', 'image/jpg', 'image/pjpeg','image/png', 'image/x-png','image/gif');
		if(in_array($imagem['type'], $permissao)){
			resize($caminho, $nomeImg, 950, $uploaddir);
		}else{
			echo 'Esta imagem está fora das permissões de arquivo. Apenas JPG, GIF e PNG<br />';
			echo 'Imagem: $nome<br />';
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

$sql  = 'UPDATE posts SET imagem = :imagem WHERE id = :id';
  try{
  $query = $con->prepare($sql);
  $query->bindValue(':imagem',$nomeImg,PDO::PARAM_STR);
  $query->bindValue(':id',$id,PDO::PARAM_STR);
  $query->execute();
  
  }catch (PDOexception $errorSelect){
   echo "<div class='msg erro'><span>Erro ao Atualizar dados.</span></div> <br /><br />Código do erro:  ".$errorSelect->getMessage();
  }

}


/**************************************************************************************
*************** UPDATE NO BANCO DE DADOS
***************************************************************************************/
$sql  = 'UPDATE posts SET titulo = :titulo, titulo_slug = :titulo_slug, url = :url, data = :data, categoria = :categoria, cat_slug = :cat_slug, texto = :texto,';
$sql .= ' tags = :tags, tags_slug = :tags_slug WHERE id = :id';

  try{
  $query = $con->prepare($sql);
  $query->bindValue(':titulo',$titulo,PDO::PARAM_STR);
  $query->bindValue(':titulo_slug',$titSlug,PDO::PARAM_STR);
  $query->bindValue(':url',$embed,PDO::PARAM_STR);
  $query->bindValue(':data',$data,PDO::PARAM_STR);
  $query->bindValue(':categoria',$categoria,PDO::PARAM_STR);
  $query->bindValue(':cat_slug',$catSlug,PDO::PARAM_STR);
  $query->bindValue(':texto',$texto,PDO::PARAM_STR);
  $query->bindValue(':tags',$tags,PDO::PARAM_STR);
  $query->bindValue(':tags_slug',$tagsSlug,PDO::PARAM_STR);
  $query->bindValue(':id',$id,PDO::PARAM_STR);
  $query->execute();
  
  /* Faz a atualização automática do sitemap.xml */
  include("fatiados/gerador_sitemaps.php");
  
  /* Faz a atualização automática do rss.xml */
  include("fatiados/gerador_rss.php");
  
  echo "<div class='msg certo'><span>Operação realizada com sucesso!</span></div>";
  echo '<div class="voltar"><a href="?pg=listar-itens-cat&cat='.$cat.'" title="Voltar"></a></div>';
  
  }catch (PDOexception $errorSelect){
   echo "<div class='msg erro'><span>Erro ao Atualizar dados.</span></div> <br /><br />Código do erro:  ".$errorSelect->getMessage();
  }

  }
}

/************************************************************************************************************************************************************************************
************************************************************************************ FECHA OPERAÇÃO ALTERAR E ABRE EXCLUIR **********************************************************
*************************************************************************************************************************************************************************************/

if($op == 'excluir' ){

$catSlug   = $cat;

// Apagando a foto da pasta
$sqlAntiga = 'SELECT * FROM posts WHERE id = :id';

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
  $pasta       = "../images/categorias/".$dadosAntiga['pasta']."/";
}

// DELETANDO DO BANCO DE DADOS
$sqlDelete = 'DELETE FROM posts WHERE id = :id';

try{
  $queryDelete = $con->prepare($sqlDelete);
  $queryDelete->bindValue(':id',$id,PDO::PARAM_STR);
  $queryDelete->execute();
  
  //CHAMA-SE A FUNÇÃO APAGAR PASTA
  apagar($pasta);
  
  /* Faz a atualização automática do sitemap.xml */
  include("fatiados/gerador_sitemaps.php");
  
  /* Faz a atualização automática do rss.xml */
  include("fatiados/gerador_rss.php");
  
  echo "<div class='msg certo'><span>Operação realizada com sucesso!</span></div>";
  echo '<div class="voltar"><a href="?pg=listar-itens-cat&cat='.$cat.'" title="Voltar"></a></div>';
	
}catch (PDOException $errorDelete){
	echo "<div class='msg erro'></span>Erro ao deletar dados.</span></div> <br /><br />Código do erro:  ".$errorDelete->getMessage();
}  
}

?>


</div>
