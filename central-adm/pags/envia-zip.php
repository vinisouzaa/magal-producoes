<?php 
session_start();
include_once("check-sess.php"); 
?>
<div id="pags">
<?php

$etapa = addslashes(strip_tags(trim($_GET['etapa'])));
$pg    = addslashes(strip_tags(trim($_GET['pg'])));
$id    = addslashes(strip_tags(trim($_GET['c'])));

if ($etapa == ''){

	$etapa = "etapa1";

}

if($etapa == 'etapa1'){

?>

<table border="0" id="tabela" data-corner="top 8px">

  <tr>
    <td align="center" class="td_titulo">
      <span class="titulo1">Enviar fotos Zipadas</span>
    </td>
  </tr>
  
</table>

<form action="?pg=<?php echo $pg; ?>&etapa=etapa2&c=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
<table width="45%" border="0" id="tabela2">

  <tr>
    <td height="62" align="center" class="td_topico">Zipadas:</td>
    <td align="left" class="td_input">
      <input type="file" name="zipadas" title="Selecione aqui as Fotos em arquivo .ZIP" class="tipTip" />
    </td>
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

// BUSCANDO INFORMAÇÕES DO EVENTO
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
foreach($res as $dados);

$zipadas    = $_POST['zipadas'];
$pasta      = $dados['pasta'];
$uploaddir  = "../images/categorias/".$pasta."/";
$dataImg    = date('d-m-Y');


/************************************************************************************************************************************************************************************
************************************************************************************ TRABALHANDO AS ZIPADAS *************************************************************************
*************************************************************************************************************************************************************************************/

/* Movendo as fotos Zipadas *********************************************************************************************/
if($zipadas != "none") {// verifica campo arquivo
  if (move_uploaded_file($_FILES['zipadas']['tmp_name'], $uploaddir . $_FILES['zipadas']['name'])) {
  $zipadas = $_FILES['zipadas']['name'];
}}

/* Define o arquivo e descompacta as imagens que estão no arquivo zipado *************************************************/
if($zipadas != ''){ /* IF ZIPADAS -  Se o usuário postar o arquivo em zip, entra na função */
	
  $arquivo = '../images/categorias/'.$pasta.'/'.$zipadas;
  $zip = new ZipArchive();
  $zip->open("$arquivo");
  $zip->extractTo("../images/categorias/$pasta/");
  $zip->close();

/* Apagando o arquivo zipado *********************************************************************************************/
  unlink("$arquivo");

/* Conta todas as imagens da pasta do evento ********************************************************/
  $imagens    = glob($uploaddir."{*.jpg,*.jpeg,*.gif,*.png,*.bmp,*.JPG,*.JPEG,*.GIF,*.PNG,*.BMP}",GLOB_BRACE);
  $qtd        = 100000000;
  $atual      = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
  $pagArquivo = array_chunk($imagens, $qtd);			
  $contar     = count($pagArquivo);
  $resultado  = $pagArquivo[$atual-1];

/* percorre o array *****************************************************************************************************/
	foreach ($resultado as $valor){

/* Pega o caminho da imagem e obtém o tamanho ***************************************************************************/
	  if($valor){

		$caminhoZip = $valor;
		$tam_imgZip = getimagesize($caminhoZip);

/* Agora pega o tipo da imagem *****************************************************************************************/
		//$tipo = $tam_imgZip['mime'];
		
/***********************************************************************************************************************
======+ Se a imagem for maior que 950px de largura, então:
+* Define um novo nome para a imagem, 
+* Cria um Array com as permissões de tipos de imagens e verifica se é permitido o tipo informado
+* Inclui o arquivo com a função resize (Redimensionar)
+* E por fim, apaga o arquivo antigo
************************************************************************************************************************/
	  if($tam_imgZip[0] > 950){ 
	  
		$nomeZip = 'data='.$dataImg.'-'.md5(uniqid(rand(), true)).'.'.end(explode('.', $valor));
		$permissao = array('image/jpeg', 'image/jpg', 'image/pjpeg','image/png', 'image/x-png','image/gif');
		
		if(in_array($tam_imgZip['mime'], $permissao)){
		  resize($valor, $nomeZip, 950, $uploaddir);
		  unlink("$valor");
		  
		  
		}else{
		  echo '<div class="msg erro"><span>Esta imagem está fora das permissões de arquivo. Apenas JPG, GIF e PNG.<br />Imagem: '.$nomeZip.'</span></div>';
		}
	  }
	}
  }
  
		echo "<div class='msg certo'><span>Imagens cadastradas com sucesso!</span></div>";
		echo '<div class="voltar"><a href="?pg=listar-itens-cat&cat=galeria" title="Voltar"></a></div>';
		
}

}

?>


</div>
