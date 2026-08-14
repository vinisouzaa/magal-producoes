<?php 
session_start();
include_once("check-sess.php"); 

$pag        = addslashes(strip_tags(trim($_GET['pag'])));
$pg         = addslashes(strip_tags(trim($_GET['pg'])));
$cat        = addslashes(strip_tags(trim($_GET['cat'])));

if($pag >= 1){
 $pag = $pag;
}else{
 $pag = 1;
}

// DEFININDO AS CATEGORIAS
  $sqlCat = 'SELECT * FROM categorias WHERE cat_slug = :cat ORDER BY id DESC LIMIT 1';
  
  try{
  $queryCat = $con->prepare($sqlCat);
  $queryCat->bindValue(':cat',$cat,PDO::PARAM_STR);
  $queryCat->execute();
  $resCat   = $queryCat->fetchAll(PDO::FETCH_ASSOC);
  $countCat = $queryCat->rowCount(PDO::FETCH_ASSOC);
  if($countCat == 0){
	 echo '<div id="pags">';
	 echo "<div class='msg erro'><span>Nada foi encontrado</span></div>";
	 echo '</div>';
	return false; 
  }
  }catch (PDOexception $errorSelectCat){
  echo 'Erro ao selecionar '.$errorSelectCat->getMessage();
  }
  foreach($resCat as $dadosCat);

$maximo = 10;
$inicio = ($pag * $maximo) - $maximo;

?>

<div id="pags">

<table border="0" id="tabela" data-corner="top 8px">
  <tr>
    <td align="center" class="td_titulo">
      <span class="titulo1">Listando <?php echo $dadosCat['categoria']; ?></span>
    </td>
  </tr>
</table>

<table  border="0" cellspacing="10" id="tabela2">

  <tr bgcolor="#CCCCCC">
    <td width="42" align="center" class="td_titulo2">Alterar</td>
    <td width="42" align="center" class="td_titulo2">Excluir</td>
    <?php if($dadosCat['cat_slug'] == 'galeria'){ ?>
    <td width="42" align="center" class="td_titulo2">Enviar Fotos</td>
    <td width="38" align="center" class="td_titulo2">Listar Fotos</td>
    <?php } ?>
    <td width="119" align="center" class="td_titulo2">Título</td>
    <td width="48" align="center" class="td_titulo2">Data</td>
    <td width="29" align="center" class="td_titulo2">Imagem</td>
  </tr>
  
  <?php
  
  $sql = 'SELECT * FROM posts WHERE cat_slug = :cat ORDER BY id DESC LIMIT '.$inicio.','.$maximo.'';
  
  try{
  $query = $con->prepare($sql);
  $query->bindValue(':cat',$cat,PDO::PARAM_STR);
  $query->execute();
  $res   = $query->fetchAll(PDO::FETCH_ASSOC);
  $count = $query->rowCount(PDO::FETCH_ASSOC);
		 
		 if($count == 0){
			 
			 echo "<div class='msg erro'><span>Nada foi encontrado!</span></div>";
			 echo '</table></div>';
			 
			return false; 
		 }
  
  }catch (PDOexception $errorSelect){
  echo 'Erro ao selecionar '.$errorSelect->getMessage();
  }
  foreach($res as $dados){
  
  ?>
  
  <tr bgcolor="#FFFFFF">
    <td align="center">
    <a href="?pg=op-itens-cat&id=<?php echo $dados['id']; ?>&op=alterar&cat=<?php echo $cat; ?>" 
       title='Alterar: "<?php echo $dados['titulo']; ?>"'>
      <img src="images/edit.png" border="0"  />
    </a>
    </td>
    <td align="center">
      <a href="?pg=op-itens-cat&id=<?php echo $dados['id']; ?>&op=excluir&cat=<?php echo $cat; ?>" 
         onclick="certeza=confirm('Tem Certeza que deseja excluir?'); if 
         (certeza==1){ return true; }else{ return false; }" title='Excluir: "<?php echo $dados['titulo']; ?>"'>
        <img src="images/del.png" border="0"  />
      </a>
    </td>
    
    <?php if($dadosCat['cat_slug'] == 'galeria'){ ?>
    
    <td align="center">
      <a href="?pg=cadastrar_imagens&id=<?php echo $dados['id']; ?>" 
         title='Enviar Fotos: "<?php echo $dados['titulo']; ?>"'>
        <img src="images/upload.png" border="0"  />
      </a>
    </td>
    <td align="center">
      <a href="?pg=alterar_imagens&id=<?php echo $dados['id']; ?>" 
         title='Listar Fotos: "<?php echo $dados['titulo']; ?>"'>
        <img src="images/list.png" border="0"  />
      </a>
    </td>
    
    <?php } ?>
    
    <td align="center" class="td-texto"><?php echo $dados['titulo']; ?></td>
    <td align="center" class="td-texto">
	<?php 
	  $data = renomeiaData($dados['data']);
	  echo $data['dia'].'/'.$data['mes'].'/'.date('Y', strtotime($dados['data']));
	?>
    </td>
    
    <td align="center">
      <?php 
	  
	    if($dados['cat_slug'] == 'depoimentos' | $dados['cat_slug'] == 'videos'){ 
			echo $dados['url'];
		}else{
	  
	  ?>
      <a href="../images/categorias/<?php echo $dados['pasta'].'/'.$dados['imagem']; ?>" target="_blank" class="lightbox" title="Ver imagem ampliada">
        <img src="timthumb.php?src=../images/categorias/<?php echo $dados['pasta'].'/'.$dados['imagem']; ?>&w=160&h=110&zc=1&q=100" border="0" />
      </a>
      <?php } ?>
    </td>
    
  </tr>
  
  <?php } ?>
    
</table>

  <!-- Paginação -->
  <div class="paginacao">
  <?php
  
  $sqlPag = 'SELECT * FROM posts WHERE cat_slug = :cat';
    
  try{
   $queryPag = $con->prepare($sqlPag);
   $queryPag->bindValue(':cat',$cat,PDO::PARAM_STR);
   $queryPag->execute();
   $sql_res = $queryPag->fetchAll(PDO::FETCH_ASSOC);
   $total   = $queryPag->rowCount(PDO::FETCH_ASSOC);
  
  }catch (PDOexception $error_select_Pag){
      echo "<div class='msg erro'><span>Erro ao Selecionar dados.</span></div> <br /><br />Código do erro:  ".$error_select_Pag->getMessage();
  }
  
  if($total > $maximo){
      
  $totalPaginas = ceil($total/$maximo);
  $links        = '5'; //QUANTIDADE DE LINKS NO PAGINATOR
  
  echo "<a href=\"?pg=$pg&amp;cat=$cat&amp;pag=1\">Primeira Página</a>";
  
  for ($i = $pag-$links; $i <= $pag-1; $i++){
      
    if ($i <= 0){
      
    }else{
      
        echo"<a href=\"?pg=$pg&amp;cat=$cat&amp;pag=$i\">$i</a>";
      
    }
  
  }
  
  echo "<span>$pag</span> ";
  
  for($i = $pag +1; $i <= $pag+$links; $i++){
      
    if($i > $totalPaginas){
      
    }else{
      
      echo "<a href=\"?pg=$pg&amp;cat=$cat&amp;pag=$i\">$i</a>";
    }
  }
  
  echo "<a href=\"?pg=$pg&amp;cat=$cat&amp;pag=$totalPaginas\">Última página</a>";
  
  }
  ?>
  </div>
  <!-- Paginação -->


</div>