<div class="pags">

  <?php
    
    $sql = 'SELECT * FROM paginas WHERE categoria = :post';
    
    try{
    $query = $con->prepare($sql);
    $query->bindValue(':post',$post,PDO::PARAM_STR);
    $query->execute();
    $res_query = $query->fetchAll(PDO::FETCH_ASSOC);	   
    
    }catch (PDOexception $error_select){
        echo 'Erro ao selecionar '.$error_select->getMessage();
    }
        
    foreach($res_query as $dados);
      
  ?>
  <div class="titulo3"><?php echo $dados['titulo']; ?></div>
  
  <div class="box-texto">
    <?php 
      $dados['texto'] = str_replace("../","",$dados['texto']);
      echo $dados['texto'];
    ?>
  </div>

</div>