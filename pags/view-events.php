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

  <div class="bx">
    
    <div class="data"><?php echo $dataUp['dia'].'/'.$dataUp['mes'].'/'.date('Y', strtotime($dados['data'])); ?></div>
  
  </div>
  <!-- Box infos -->
  
  
  <div class="box-texto">
  <?php 
  $dados['texto'] = str_replace("../","",$dados['texto']);
  echo $dados['texto'];
   ?>
  </div>
  <!-- Box texto -->
  
   
  <ul class="ul-pg">
  
  <?php
    $imagens    = glob('images/categorias/'.$dados['pasta']."/{*.jpg,*.jpeg,*.gif,*.png,*.bmp,*.JPG,*.JPEG,*.GIF,*.PNG,*.BMP}",GLOB_BRACE);
    $qtd        = 20; 
    $atual      = (isset($_GET['page'])) ? intval($_GET['page']) : 1;
    $pagArquivo = array_chunk($imagens, $qtd);				
    $contar     = count($pagArquivo);
    $resultado  = $pagArquivo[$atual-1];
    foreach ($resultado as $valor){ 
  ?>
  
    <li>
      <a href="<?php echo $urlBase.'/'.$valor; ?>" title="<?php echo $dados['legenda'] ?>" class="lightbox" rel="group">
      <img src="<?php echo $urlBase; ?>/timthumb.php?src=<?php echo $urlBase.'/'.$valor; ?>&w=200&h=160&zc=1&q=100" alt="" />
      </a>
    </li>
  
  <?php } ?>
  
  </ul>
  <!-- UL padrão de fotos -->
   
  <div class="pagFotos">	
  <?php 
	for($p = 1; $contar >= $p ; $p++) {
	  if($p == $atual){
	    printf('<div class="pagoff">%s</div>',$p);
	  }else{
	    printf("<div class=\"pag\" ><a href=\"".$urlBase.'/'.$dados['cat_slug'].'/'.$dados['titulo_slug']."/&page=%s\" >%s</a></div>", $p, $p );
	  }
	}
  ?>    
  </div>
  <!-- Paginação das Fotos -->
      
  <div class="voltar"><a href="javascript:history.back()" title="Voltar">VOLTAR</a></div>
  <!-- Voltar -->
  
  </div>