<div class="fix">

<?php
$pag  = addslashes(strip_tags($_GET['pag']));
if($pag >= 1){
 $pag = $pag;
}else{
 $pag = 1;
}

$maximo = 9;
$inicio = ($pag * $maximo) - $maximo;

/**************** BUSCANDO A CATEGORIA
*************************************************************************************/
$sqlSlug = 'SELECT * FROM categorias WHERE cat_slug = :pagina';
try{
$querySlug = $con->prepare($sqlSlug);
$querySlug->bindValue(':pagina',$pagina,PDO::PARAM_STR);
$querySlug->execute();
$res_Slug = $querySlug->fetchAll(PDO::FETCH_ASSOC);
$count    = $querySlug->rowCount(PDO::FETCH_ASSOC);

	if($count == 0){
	   include("pags/404.php");
	   return false; 
	}

}catch (PDOexception $error_select_Slug){
 echo 'Erro ao selecionar '.$error_select_Slug->getMessage();
}
foreach($res_Slug as $dadosSlug){
	$nomeCat  = $dadosSlug['categoria'];
	$slugCat  = $dadosSlug['cat_slug'];
	$descCat  = $dadosSlug['descricao'];
}
?>

    
  <div class="titulo1">
    <span class="t1"><?php echo $nomeCat; ?></span>
    <span class="t2"><?php echo $descCat; ?></span>
  </div>
  
  <ul class="ul-padrao ul-padrao-pg">


<?php
/*************** CATEGORIA SERVICOS, ARTISTAS E FOTOS
*****************************************************************/
if($slugCat == 'artistas' | $slugCat == 'galeria'){
    
    $sqlCat = 'SELECT * FROM posts WHERE cat_slug = :slugCat ORDER BY id DESC LIMIT '.$inicio.','.$maximo.'';
    try{
    $queryCat = $con->prepare($sqlCat);
    $queryCat->bindValue(':slugCat',$slugCat,PDO::PARAM_STR);
    $queryCat->execute();
    $resCat = $queryCat->fetchAll(PDO::FETCH_ASSOC);
    
    }catch (PDOexception $error_select_Cat){
     echo 'Erro ao selecionar '.$error_select_Cat->getMessage();
    }
    foreach($resCat as $dadosCat){
    
    ?>

      <li class="artistas">
        <a href="<?php echo $urlBase.'/'.$dadosCat['cat_slug'].'/'.$dadosCat['titulo_slug']; ?>" title="<?php echo $dadosCat['titulo']; ?>">
          <img src="<?php echo $urlBase; ?>/images/read-artistas2.png" alt="" class="imagem-oculta" />
          <img src="<?php echo $urlBase; ?>/timthumb.php?src=<?php echo $urlBase; ?>/images/categorias/<?php echo $dadosCat['pasta'].'/'.$dadosCat['imagem']; ?>&w=300&h=260&zc=1&q=100" 
          alt="" />
         <span class="caixa-txt">
          <span class="texto3"><?php echo limitaTexto($dadosCat['titulo'], 100);?></span>
          <span class="texto1"><?php echo limitaTexto($dadosCat['texto'], 0);?></span>
        </span>
        </a>
      </li>
      
    <?php 
	
	} 
}

/*************** CATEGORIA VÍDEOS | DEPOIMENTOS
*****************************************************************/
if($slugCat == 'depoimentos' | $slugCat == 'videos'){
    
    $sqlCat = 'SELECT * FROM posts WHERE cat_slug = :slugCat ORDER BY id DESC LIMIT '.$inicio.','.$maximo.'';
    try{
    $queryCat = $con->prepare($sqlCat);
    $queryCat->bindValue(':slugCat',$slugCat,PDO::PARAM_STR);
    $queryCat->execute();
    $resCat = $queryCat->fetchAll(PDO::FETCH_ASSOC);
    
    }catch (PDOexception $error_select_Cat){
     echo 'Erro ao selecionar '.$error_select_Cat->getMessage();
    }
    foreach($resCat as $dadosCat){
    
    ?>

      <li class="artistas">
        <a href="<?php echo $urlBase.'/'.$dadosCat['cat_slug'].'/'.$dadosCat['titulo_slug']; ?>" title="<?php echo $dadosCat['titulo']; ?>">
         <?php echo $dadosCat['url']; ?>
         <span class="caixa-txt">
          <span class="texto3"><?php echo limitaTexto($dadosCat['titulo'], 100);?></span>
          <span class="texto1"><?php echo limitaTexto($dadosCat['texto'], 120);?></span>
        </span>
        </a>
      </li>
      
    <?php 
	
	} 
}

?>

  </ul>
  

<div class="paginacao">

<?php

$sqlPag = 'SELECT * FROM posts WHERE cat_slug = :slugCat';
  
try{
 $queryPag = $con->prepare($sqlPag);
 $queryPag->bindValue(':slugCat',$slugCat,PDO::PARAM_STR);
 $queryPag->execute();
 $sql_res = $queryPag->fetchAll(PDO::FETCH_ASSOC);
 $total   = $queryPag->rowCount(PDO::FETCH_ASSOC);

}catch (PDOexception $error_select_Pag){
   echo 'Erro ao selecionar '.$error_select_Pag->getMessage();
}

if($total > $maximo){
    
$totalPaginas = ceil($total/$maximo);
$links        = '5'; //QUANTIDADE DE LINKS NO PAGINATOR

echo "<a href=\"$urlBase/$pagina/&amp;pag=1\">Primeira Página</a>";

for ($i = $pag-$links; $i <= $pag-1; $i++){
    
  if ($i <= 0){
    
  }else{
      echo"<a href=\"$urlBase/$pagina/&amp;pag=$i\">$i</a>"; 
  }
}

echo "<span>$pag</span>";

for($i = $pag +1; $i <= $pag+$links; $i++){
    
  if($i > $totalPaginas){
    
  }else{
    echo "<a href=\"$urlBase/$pagina/&amp;pag=$i\">$i</a>";
  }
}
echo "<a href=\"$urlBase/$pagina/&amp;pag=$totalPaginas\">Última página</a>";
}
?>
</div>
<!-- Paginação -->

</div>