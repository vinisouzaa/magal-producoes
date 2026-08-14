<?php 
session_start();
include_once("check-sess.php"); 
?>
<div id="pags">
<?php

$id    = addslashes(strip_tags($_GET['id']));
$pg    = addslashes(strip_tags($_GET['pg']));
$etapa = addslashes(strip_tags(trim($_GET['etapa'])));



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

if ($etapa == ''){
	$etapa = "etapa1";
}

if ($etapa=="etapa1"){

?>

<table border="0" id="tabela" data-corner="top 8px">

  <tr>
    <td align="center" class="td_titulo">
      <span class="titulo1"> Listando fotos de:  "<?php echo $dados['titulo']; ?>"</span>
    </td>
  </tr>
  
</table>

<!-- Box Fotos -->
<div id="box-fotos">

<?php

//Criando a PAGINAÇÃO

$imagens = glob('../images/categorias/'.$dados['pasta'].'/{*.jpg,*.jpeg,*.gif,*.png,*.JPG,*.JPEG,*.GIF,*.PNG}',GLOB_BRACE);

$qtd     = 20;

$atual   = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

$pagArquivo = array_chunk($imagens, $qtd);
					
$contar     = count($pagArquivo);

$resultado  = $pagArquivo[$atual-1];
						
/*percorre o array*/

foreach ($resultado as $valor){ 

?>
			
  <div class="fotos">
  
    <a href='<?php echo $valor; ?>' target="_blank" class="foto tipTip" title="Ver imagem Ampliada" rel="group">
      <img src="timthumb.php?src=<?php echo $valor; ?>&w=130&h=130&zc=1&q=100" border="0" />
    </a>
     
    <div class="delete">
    
      <a href="?pg=<?php echo $pg; ?>&etapa=etapa2&id=<?php echo $id; ?>&imagem=<?php echo $valor; ?>&cat=<?php echo $cat; ?>" onclick="certeza=confirm('Tem Certeza que deseja excluir?'); if(certeza==1){ return true; }else{ return false; }" class="tipTip" title="Apagar esta Imagem!">
        <img src="images/del.png" border="0" />
      </a>
      
    </div>
     
  </div>

<?php } ?>

</div>
<!-- Box Fotos -->

<!-- Paginação -->
<div id="paginacao">
	<ul>
<?php 
	for($p = 1; $contar >= $p ; $p++) {
	  if($p == $atual){
	    printf('<li><span class="pagoff">%s</span></li>',$p);
	  }else{
	    printf("<li><a href=\"?pg=".$pg."&id=".$id."&page=%s\" class=\"pag\">%s</a></li>", $p, $p );
	  }
	}
?>  
  </ul>
</div>
<!-- Paginação -->

<?php

}

if ( $etapa == "etapa2"){

$id    = addslashes(strip_tags($_GET['id']));
$valor = addslashes(strip_tags($_GET['imagem']));

if(unlink($valor)){

		echo "<div class='msg certo'><span>Foto excluída com sucesso!</span></div>";
?>

<div class="voltar"><a href="?pg=<?php echo $pg; ?>&id=<?php echo $id; ?>&cat=<?php echo $cat; ?>" title="Voltar" ></a></div>

<?php


	}

}
?>

</div>