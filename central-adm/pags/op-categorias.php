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

  
if ($etapa == ''){
  $etapa = "etapa1";
}

/**************************************************************************************
*************** OPERAÇÃO ALTERAR
***************************************************************************************/
if($op == 'alterar' ){

if($etapa =='etapa1'){
	
	
  $sql = 'SELECT * FROM categorias WHERE id = :id';
  
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


<table border="0" id="tabela" data-corner="top 8px">

  <tr>
    <td align="center" class="td_titulo">
      <span class="titulo1">Alterar ítem de: <?php echo $dadosCat['categoria']; ?></span>
    </td>
  </tr>
  
</table>

<form action="?pg=<?php echo $pg; ?>&op=<?php echo $op; ?>&etapa=etapa2&id=<?php echo $dados['id']; ?>" method="post">

<table width="45%" border="0" id="tabela2">

  <tr>
    <td width="17%" height="47" align="center" class="td_topico">Categoria:</td>
    <td colspan="2" align="left" class="td_input">
      <input type="text" name="categoria" maxlength="250" class="input" value="<?php echo $dados['categoria']; ?>" />
    </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">Descrição:</td>
    <td colspan="2" align="left" class="td_input">
      <textarea name="descricao" class="textarea" maxlength="250" ><?php echo $dados['descricao']; ?></textarea>
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
} if($etapa =='etapa2'){
	
/*************** RECEBENDO AS VARIÁVEIS
***************************************************************************************/
$categoria  = $_POST['categoria'];
$descricao  = $_POST['descricao'];

/*************** UPDATE NO BANCO DE DADOS
***************************************************************************************/
$sql  = 'UPDATE categorias SET categoria = :categoria, descricao = :descricao WHERE id = :id';

  try{
  $query = $con->prepare($sql);
  $query->bindValue(':categoria',$categoria,PDO::PARAM_STR);
  $query->bindValue(':descricao',$descricao,PDO::PARAM_STR);
  $query->bindValue(':id',$id,PDO::PARAM_STR);
  $query->execute();
  
  
  echo "<div class='msg certo'><span>Categoria Alterada com sucesso!</span></div>";
  echo '<div class="voltar"><a href="?pg=listar-categorias" title="Voltar"></a></div>';
  
  }catch (PDOexception $errorSelect){
   echo "<div class='msg erro'><span>Erro ao Atualizar dados.</span></div> <br /><br />Código do erro:  ".$errorSelect->getMessage();
  }

  }
  
}
?>
</div>
