<?php 
session_start();
include_once("check-sess.php"); 
?>
<div id="pags">
<?php

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

if($etapa == 'etapa1'){
?>

<!-- TinyMCE -->
<script type="text/javascript" src="tinymce/tiny_mce.js"></script>
<script type="text/javascript" src="tinymce/plugins/tinybrowser/tb_tinymce.js.php"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
    language : "pt",
		mode : "textareas",
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
      <span class="titulo1">Cadastrar ítem: <?php echo $dadosCat['categoria']; ?></span>
    </td>
  </tr>
  
</table>

<form action="?pg=<?php echo $pg; ?>&etapa=etapa2&cat=<?php echo $cat; ?>" method="post" enctype="multipart/form-data">
<table width="45%" border="0" id="tabela2">

  <tr>
    <td width="17%" height="47" align="center" class="td_topico">Título:</td>
    <td width="83%" align="left" class="td_input">
      <input type="text" name="titulo" class="input" />
    </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">Texto:</td>
    <td align="left" class="td_input"><textarea name="texto" class="textarea"></textarea></td>
  </tr>
  <?php if($dadosCat['cat_slug'] == 'videos' | $dadosCat['cat_slug'] == 'depoimentos'){ ?>
	
  <tr>
    <td height="46" align="center" class="td_topico">LINK DO YOUTUBE:</td>
    <td align="left" class="td_input">
      <input type="text" name="embed" class="input" />
    </td>
  </tr>	
		
  <?php }else{ ?>
  <tr>
    <td height="62" align="center" class="td_topico">Imagem:</td>
    <td align="left" class="td_input">
      <input type="file" name="imagem" />
      </td>
  </tr>
  
  <?php } ?>
  
  <tr>
    <td height="46" align="center" class="td_topico">Tags:</td>
    <td align="left" class="td_input">
      <input type="text" name="tags" class="input" />
    </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">&nbsp;</td>
    <td align="left" class="td_input">
      <input type="submit" value="Cadastrar" class="btn" />
    </td>
  </tr>
  
</table>

<input type="hidden" name="categoria" value="<?php echo $dadosCat['categoria']; ?>" />

</form>

<?php

}
if($etapa =='etapa2'){

/**************************************************************************************
*************** RECEBENDO AS VARIÁVEIS
***************************************************************************************/

$embed      = '';

$titulo     = $_POST['titulo'];
$tags       = $_POST['tags'];
$data       = date('Y-m-d');
$texto      = $_POST['texto'];
$imagem     = $_FILES['imagem'];
$embed     .= $_POST['embed'];
$dataImg    = date('d-m-Y');
$categoria = $_POST['categoria'];
$catSlug   = $cat;
$pasta     = date('d-m-Y').'-'.md5(uniqid(rand(), true));
mkdir("../images/categorias/$pasta", 0777 );
$uploaddir = "../images/categorias/".$pasta."/";

// CRIANDO O SLUG
include("fatiados/cria_slug.php");
$titSlug  = slug($titulo);
$tagsSlug = tag($tags);

/**************************************************************************************
*************** MOVENDO A IMAGEM
***************************************************************************************/

if($imagem['name'] != ''){

$caminho   = $_FILES['imagem']['tmp_name'];
$tam_img   = getimagesize($caminho);

if($tam_img[0] > 950){
	$nomeImg = $dataImg.'-'.md5(uniqid(rand(), true)).'.'.end(explode('.', $imagem['name']));
	$permissao = array('image/jpeg', 'image/jpg', 'image/pjpeg','image/png', 'image/x-png','image/gif');
            if(in_array($imagem['type'], $permissao)){
				resize($caminho, $nomeImg, 950, $uploaddir);
			}else{
				echo '<div class="msg erro"><span>Esta imagem está fora das permissões de arquivo. Apenas JPG, GIF e PNG.<br />Imagem: $nomeImg</span></div>';
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

/************************************************************************************************************************************************************************************
************************************************************************************ INSERINDO NO BANCO *****************************************************************
*************************************************************************************************************************************************************************************/

$sql  = 'INSERT INTO posts (titulo, titulo_slug, imagem, url, data, categoria, cat_slug, texto, tags, tags_slug, pasta) ';
$sql .= 'VALUES (:titulo, :titulo_slug, :imagem, :url, :data, :categoria, :cat_slug, :texto, :tags, :tags_slug, :pasta)';

  try{
  $query = $con->prepare($sql);
  $query->bindValue(':titulo',$titulo,PDO::PARAM_STR);
  $query->bindValue(':titulo_slug',$titSlug,PDO::PARAM_STR);
  $query->bindValue(':imagem',$nomeImg,PDO::PARAM_STR);
  $query->bindValue(':url',$embed,PDO::PARAM_STR);
  $query->bindValue(':data',$data,PDO::PARAM_STR);
  $query->bindValue(':categoria',$categoria,PDO::PARAM_STR);
  $query->bindValue(':cat_slug',$catSlug,PDO::PARAM_STR);
  $query->bindValue(':texto',$texto,PDO::PARAM_STR);
  $query->bindValue(':tags',$tags,PDO::PARAM_STR);
  $query->bindValue(':tags_slug',$tagsSlug,PDO::PARAM_STR);
  $query->bindValue(':pasta',$pasta,PDO::PARAM_STR);
  $query->execute();
  
  /* Faz a atualização automática do sitemap.xml */
  include("fatiados/gerador_sitemaps.php");
  
  /* Faz a atualização automática do rss.xml */
  include("fatiados/gerador_rss.php");
  
  echo "<div class='msg certo'><span>Operação realizada com sucesso!</span></div>";
  echo '<div class="voltar"><a href="?pg=listar-itens-cat&cat='.$cat.'" title="Voltar"></a></div>';
  
  }catch (PDOException $error){
	  echo "<div class='msg erro'><span>Erro ao Inserir dados.</span></div> <br /><br />Código do erro:  ".$error->getMessage();
  } 


}

?>


</div>
