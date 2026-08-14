<?php 
session_start();
include_once("check-sess.php"); 

// RESTRITO - SOMENTE NIVEL 1 TEM ACESSO
if(!checkNivel('1')){
	header('Location: home.php');
}

$pag = addslashes(strip_tags(trim($_GET['pag'])));
$pg  = addslashes(strip_tags(trim($_GET['pg'])));
$p   = addslashes(strip_tags(trim($_POST['p'])));

if(!isset($_POST['p'])){ /* Se o post p não existir, p será GET p */
	$p = addslashes(strip_tags($_GET['p']));
}

if($p == '') $p = 'todos';

if($pag >= 1){
 $pag = $pag;
}else{
 $pag = 1;
}

$maximo = 10;
$inicio = ($pag * $maximo) - $maximo;

?>

<div class="pags">

<table border="0" id="tabela" data-corner="top 8px">
  <tr>
    <td align="center" class="td_titulo">
      <span class="titulo1">Usuários</span>
    </td>
  </tr>
</table>

<table  border="0" cellspacing="10" id="tabela2">  
  <tr bgcolor="#CCCCCC">
    <td align="center" class="td_titulo2">Alterar</td>
    <td align="center" class="td_titulo2">Excluir</td>
    <td align="center" class="td_titulo2">Nível</td>
    <td align="center" class="td_titulo2">Nome</td>
    <td align="center" class="td_titulo2">E-mail</td>
    <td align="center" class="td_titulo2">Login</td>
  </tr>
  
  <?php
  
  if($p != 'todos'){
	
	$sql = 'SELECT * FROM usuarios WHERE nome LIKE :p OR email LIKE :p ORDER BY nome ASC LIMIT '.$inicio.','.$maximo.'';
  
  }else{
  
	$sql = 'SELECT * FROM usuarios ORDER BY nome ASC LIMIT '.$inicio.','.$maximo.'';
	  
  }
    
  try{
  $query = $con->prepare($sql);
  if($p != 'todos'){ $query->bindValue(':p','%'.$p.'%',PDO::PARAM_STR);}
  $query->execute();
  $res   = $query->fetchAll(PDO::FETCH_ASSOC);
  $count = $query->rowCount(PDO::FETCH_ASSOC);
		 
	 if($count == 0){
		 
		 echo "<div class='msg certo'><span>Nenhum usuário cadastrado.</span></div>";
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
      <a href="?pg=op-usuarios&id=<?php echo $dados['id']; ?>&op=alterar" 
         title='Alterar: "<?php echo $dados['nome']; ?>"'>
        <img src="images/edit.png" border="0"  />
      </a>
    </td>
    <td align="center">
      <a href="?pg=op-usuarios&id=<?php echo $dados['id']; ?>&op=excluir" 
         onclick="certeza=confirm('Tem Certeza que deseja excluir?'); if 
         (certeza==1){ return true; }else{ return false; }" title='Excluir: "<?php echo $dados['nome']; ?>"'>
        <img src="images/del.png" border="0"  />
      </a>
    </td>
    <td align="center" class="td-texto"><?php echo $dados['nivel']; ?></td>
    <td align="center" class="td-texto"><?php echo $dados['nome']; ?></td>
    <td align="center" class="td-texto"><?php echo $dados['email']; ?></td>
    <td align="center" class="td-texto"><?php echo $dados['login']; ?></td>
  </tr>
  
  <?php } ?>
    
</table>

  <!-- Paginação -->
  <div class="paginacao">
  <?php
  
 if($p != 'todos'){
	
	$sqlPag = 'SELECT * FROM usuarios WHERE nome LIKE :p OR email LIKE :p';
  
  }else{
  
	$sqlPag = 'SELECT * FROM usuarios';
	  
  }
  
  try{
   $queryPag = $con->prepare($sqlPag);
   if($p != 'todos'){ $queryPag->bindValue(':p','%'.$p.'%',PDO::PARAM_STR);}
   $queryPag->execute();
   $sql_res = $queryPag->fetchAll(PDO::FETCH_ASSOC);
   $total   = $queryPag->rowCount(PDO::FETCH_ASSOC);
  
  }catch (PDOexception $error_select_Pag){
      echo "<div class='msg erro'><span>Erro ao Selecionar dados. Código do erro: &nbsp;&nbsp;&nbsp; ".$error_select_Pag->getMessage()."</span></div>";
  }
  
  if($total > $maximo){
      
  $totalPaginas = ceil($total/$maximo);
  $links        = '5'; //QUANTIDADE DE LINKS NO PAGINATOR
  
  echo "<a href=\"?pg=$pg&amp;p=$p&amp;pag=1\">Primeira Página</a>";
  
  for ($i = $pag-$links; $i <= $pag-1; $i++){
      
    if ($i <= 0){
      
    }else{
      
        echo"<a href=\"?pg=$pg&amp;p=$p&amp;pag=$i\">$i</a>";
      
    }
  
  }
  
  echo "<span>$pag</span> ";
  
  for($i = $pag +1; $i <= $pag+$links; $i++){
      
    if($i > $totalPaginas){
      
    }else{
      
      echo "<a href=\"?pg=$pg&amp;p=$p&amp;pag=$i\">$i</a>";
    }
  }
  
  echo "<a href=\"?pg=$pg&amp;p=$p&amp;pag=$totalPaginas\">Última página</a>";
  
  }
  ?>
  </div>
  <!-- Paginação -->


</div>