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
    <td width="75" align="center" class="td_titulo2">Categoria</td>
    <td width="105" align="center" class="td_titulo2">Descrição</td>
  </tr>
  
  <?php
  
  $sql = 'SELECT * FROM categorias ORDER BY categoria ASC LIMIT '.$inicio.','.$maximo.'';
  
  try{
  $query = $con->prepare($sql);
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
    <a href="?pg=op-categorias&id=<?php echo $dados['id']; ?>&op=alterar" 
       title='Alterar: "<?php echo $dados['categoria']; ?>"'>
      <img src="images/edit.png" border="0"  />
    </a>
    </td>
    <td align="center" class="td-texto"><?php echo $dados['categoria']; ?></td>
    <td align="center" class="td-texto"><?php echo $dados['descricao']; ?></td>
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
  
  echo "<a href=\"?pg=$pg&amp;pag=1\">Primeira Página</a>";
  
  for ($i = $pag-$links; $i <= $pag-1; $i++){
      
    if ($i <= 0){
      
    }else{
      
        echo"<a href=\"?pg=$pg&amp;pag=$i\">$i</a>";
      
    }
  
  }
  
  echo "<span>$pag</span> ";
  
  for($i = $pag +1; $i <= $pag+$links; $i++){
      
    if($i > $totalPaginas){
      
    }else{
      
      echo "<a href=\"?pg=$pg&amp;pag=$i\">$i</a>";
    }
  }
  
  echo "<a href=\"?pg=$pg&amp;pag=$totalPaginas\">Última página</a>";
  
  }
  ?>
  </div>
  <!-- Paginação -->


</div>