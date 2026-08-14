<?php 
session_start();
include_once("check-sess.php");

$pag = addslashes(strip_tags(trim($_GET['pag'])));
$pg  = addslashes(strip_tags(trim($_GET['pg'])));

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
      <span class="titulo1">Listando Rádios</span>
    </td>
  </tr>
</table>

<table  border="0" cellspacing="10" id="tabela2">

  <tr bgcolor="#CCCCCC">
    <td width="42" align="center" class="td_titulo2">Alterar</td>
    <td width="41" align="center" class="td_titulo2">Excluir</td>
    <td width="119" align="center" class="td_titulo2">Rádio</td>
    <td width="119" align="center" class="td_titulo2">Cidade</td>
    <td width="48" align="center" class="td_titulo2">Imagem</td>
  </tr>
  
  <?php
  
  $sql = 'SELECT * FROM radios ORDER BY id DESC LIMIT '.$inicio.','.$maximo.'';
  
  try{
  $query = $con->prepare($sql);
  $query->execute();
  $res   = $query->fetchAll(PDO::FETCH_ASSOC);
  $count = $query->rowCount(PDO::FETCH_ASSOC);
		 
		 if($count == 0){
			 
			 echo "<div class='no'>Nada foi encontrado</div>";
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
    
    <a href="?pg=op-radios&id=<?php echo $dados['id']; ?>&op=alterar" 
       title='Alterar Rádio: "<?php echo $dados['nome']; ?>"'>
      <img src="images/edit.png" border="0"  />
    </a>
    
    </td>
    <td align="center">
    
      <a href="?pg=op-radios&id=<?php echo $dados['id']; ?>&op=excluir" 
         onclick="certeza=confirm('Tem Certeza que deseja excluir?'); if 
         (certeza==1){ return true; }else{ return false; }" title='Excluir Rádio: "<?php echo $dados['nome']; ?>"'>
        <img src="images/del.png" border="0"  />
      </a>
      
    </td>
    <td align="center" class="td-texto"><?php echo $dados['nome']; ?></td>
    <td align="center" class="td-texto"><?php echo $dados['cidade']; ?></td>
    <td align="center">
      <a href="../images/radios/<?php echo $dados['imagem']; ?>" target="_blank" class="lightbox" title="Ver imagem ampliada">
        <img src="timthumb.php?src=../images/radios/<?php echo $dados['imagem']; ?>&w=140&h=110&zc=1&q=100" border="0" />
      </a>
    </td>
  </tr>
  
  <?php } ?>
    
</table>

  <!-- Paginação -->
  <div class="paginacao">
  <?php
  
  $sqlPag = 'SELECT * FROM parceiros';
    
  try{
   $queryPag = $con->prepare($sqlPag);
   $queryPag->execute();
   $sql_res = $queryPag->fetchAll(PDO::FETCH_ASSOC);
   $total   = $queryPag->rowCount(PDO::FETCH_ASSOC);
  
  }catch (PDOexception $error_select_Pag){
      echo "<div class='msg erro'><span>Erro ao Selecionar dados</span></div> <br /><br />Código do erro:  ".$error_select_Pag->getMessage();
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

