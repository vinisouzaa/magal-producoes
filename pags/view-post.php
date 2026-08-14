<div class="pags">
<?php
    
    $sql = 'SELECT * FROM posts WHERE cat_slug = :pagina AND titulo_slug = :post';
    
    try{
    $query = $con->prepare($sql);
	$query->bindValue(':pagina',$pagina,PDO::PARAM_STR);
	$query->bindValue(':post',$post,PDO::PARAM_STR);	
    $query->execute();
    $res_query = $query->fetchAll(PDO::FETCH_ASSOC);
	$count     = $query->rowCount(PDO::FETCH_ASSOC);
		 
		 if($count == 0){
			 
			 include("pags/404.php");
			 return false; 
		 }
    
    }catch (PDOexception $error_select){
		echo 'Erro ao selecionar '.$error_select->getMessage();
    }
        
    foreach($res_query as $dados);
	$dataUp = renomeiaData($dados['data']);
    
?>
    
<div class="titulo3"><?php echo $dados['titulo']; ?></div>
<!-- topico -->


  <div class="bx">
    
    <div class="data"><?php echo $dataUp['dia'].'/'.$dataUp['mes'].'/'.date('Y', strtotime($dados['data'])); ?></div>
  
  </div>
  
  <div class="box-texto">
    
    <?php if($dados['imagem'] != '' && $dados['cat_slug'] != 'depoimentos' && $dados['cat_slug'] != 'videos'){?>
    
      <a href="<?php echo $urlBase.'/images/categorias/'.$dados['pasta'].'/'.$dados['imagem'];?>" title="<?php echo $dados['titulo']; ?>" class="lightbox foto-pg">
        <img src="<?php echo $urlBase; ?>/timthumb.php?src=<?php echo $urlBase.'/images/categorias/'.$dados['pasta'].'/'.$dados['imagem'];?>&w=370&h=280&zc=1&q=100" >
      </a>
      
    <?php 
	
	}elseif($dados['cat_slug'] == 'depoimentos' | $dados['cat_slug'] == 'videos'){
	
		echo $dados['url'];
	
	} 
	
	?>
    
    <div class="texto-pg">
      <?php 
      $dados['texto'] = str_replace("../","",$dados['texto']);
      echo $dados['texto'];
       ?>
    </div>
  
  </div>
  
   <div class="voltar"><a href="javascript:history.back()" title="Voltar">VOLTAR</a></div>

</div>