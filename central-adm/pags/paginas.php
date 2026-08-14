<?php

session_start();

include_once("check-sess.php"); 

?>

<div id="pags">

<?php



$etapa = addslashes(strip_tags(trim($_GET['etapa'])));
$pg    = addslashes(strip_tags(trim($_GET['pg'])));
$id    = addslashes(strip_tags(trim($_GET['id'])));





if ($etapa == ''){



	$etapa = "etapa1";

}



if($etapa == 'etapa1'){



  $sql = 'SELECT * FROM paginas WHERE id = :id';

  

  try{

  $query = $con->prepare($sql);
  $query->bindValue(':id', $id, PDO::PARAM_STR);
  $query->execute();
  $res   = $query->fetchAll(PDO::FETCH_ASSOC);  

  }catch (PDOexception $errorSelect){
  echo 'Erro ao selecionar '.$errorSelect->getMessage();
  }

  foreach($res as $dados);


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

      <span class="titulo1">Alterar Página: <?php echo $dados['titulo']; ?></span>

    </td>

  </tr>

  

</table>



<form action="?pg=<?php echo $pg; ?>&etapa=etapa2&id=<?php echo $dados['id']; ?>" method="post" >

<table width="36%" border="0" id="tabela2">



  <tr>

    <td width="19%" height="47" align="center" class="td_topico">Titulo:</td>

    <td colspan="2" align="left" class="td_input">

      <input type="text" name="titulo" class="input" value="<?php echo $dados['titulo']; ?>" />

    </td>

  </tr>

  <tr>

    <td height="39" align="center" class="td_topico">Texto:</td>

    <td colspan="2" align="left" class="td_input">

      <textarea name="texto" class="textarea"><?php echo $dados['texto']; ?></textarea>

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



}

if($etapa =='etapa2'){



/************************************************************************************************************************************************************************************
************************************************************************************ RECEBENDO AS VARIÁVEIS *************************************************************************
*************************************************************************************************************************************************************************************/



$titulo    = trim($_POST['titulo']);
$texto     = $_POST['texto'];

/************************************************************************************************************************************************************************************
************************************************************************************ INSERINDO NO BANCO ******************************************************************
*************************************************************************************************************************************************************************************/







$sql  = 'UPDATE paginas SET titulo = :titulo, texto = :texto WHERE id = :id';



  try{

  $query = $con->prepare($sql);

  $query->bindValue(':titulo',$titulo,PDO::PARAM_STR);

  $query->bindValue(':texto',$texto,PDO::PARAM_STR);

  $query->bindValue(':id',$id,PDO::PARAM_STR);

  $query->execute();

  

  echo "<div class='msg certo'><span>Página alterada com sucesso!</span></div>";

  echo '<div class="voltar"><a href="?pg=principal" title="Voltar"></a></div>';

  

  

  }catch (PDOexception $errorSelect){

   echo "<div class='msg erro'><span>Erro ao Atualizar dados.</span></div> <br /><br />Código do erro:  ".$errorSelect->getMessage();

  }



}



?>



</div>

