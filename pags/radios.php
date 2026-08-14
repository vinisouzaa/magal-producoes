<div class="pags">

  <div class="box-titulo">
    <span class="titulo3">RÁDIOS</span>
    <span class="texto1"></span>
  </div>
  <!-- Titulo -->
  
  <ul class="ul-padrao ul-padrao-pg ul-radio">
  
  <?php
  
  $pag  = addslashes(strip_tags($_GET['pag']));
  if($pag >= 1){
  $pag = $pag;
  
  }else{
  $pag = 1;
  
  }
  
  $maximo = 9;
  $inicio = ($pag * $maximo) - $maximo;
  
  $sql = 'SELECT * FROM radios ORDER BY id DESC';
  try{
  $query = $con->prepare($sql);
  $query->execute();
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  $count    = $query->rowCount(PDO::FETCH_ASSOC);
  
      if($count == 0){
         echo '<div class="msg certo">Nenhuma rádio encontrada.</span></div>';
         echo '</div>';
         return false; 
      }
  
  }catch (PDOexception $errorSelect){
  }
  
  foreach($res as $dados){	
  ?>
  
    <li class="artistas">
      <a href="<?php echo $dados['site']; ?>" target="_blank" title="<?php echo $dados['nome']; ?>">
        <img src="<?php echo $urlBase; ?>/timthumb.php?src=<?php echo $urlBase; ?>/images/radios/<?php echo $dados['imagem']; ?>&w=220&h=200&zc=1&q=100" 
        alt="" />
       <span class="caixa-txt">
        <span class="texto3"><?php echo limitaTexto($dados['nome'], 120);?></span>
        <span class="texto1"><?php echo $dados['cidade'];?></span>
        <span class="texto1"><?php echo $dados['frequencia'];?></span>
        <img src="images/icon-radio.png" class="icon-radios" alt="">
      </span>
      </a>
    </li>
    
  <?php } ?>
  
  </ul>

</div>