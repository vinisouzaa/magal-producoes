<div class="fix">


  <div class="box-titulo">
    <span class="titulo1">MAGAL DIVULGAÇÕES ARTÍSTICAS</span>
    <span class="texto1">“O NOSSO OBJETIVO E QUALIDADE, SERIEDADE, TRANSPAR&Ecirc;NCIA E UM TRABALHO BEM FEITO.”</span>
  </div>
  <!-- Titulo -->
  
  <div class="box1">
  
    <ul class="ul-padrao">
      
      <li class="artistas">
        <span class="titulo2">&nbsp; ARTISTAS</span>
        <a href="<?php echo $urlBase.'/artistas'; ?>" title="Conheça nossos artistas">
          <img src="<?php echo $urlBase; ?>/images/read-artistas.png" alt="" class="imagem-oculta" />
          <img src="<?php echo $urlBase.'/images/artistas.gif';?>" 
            alt="">
        </a>
      </li>
      
	  <?php
      
		$sqlDepo = 'SELECT * FROM posts WHERE cat_slug = "depoimentos" ORDER BY id DESC LIMIT 1';
		try{
		$queryDepo = $con->prepare($sqlDepo);
		$queryDepo->execute();
		$resDepo   = $queryDepo->fetchAll(PDO::FETCH_ASSOC);
		
		}catch (PDOexception $errorSelectDepo){
		 echo 'Erro ao selecionar '.$errorSelectDepo->getMessage();
		}
		foreach($resDepo as $dadosDepo);
      
      ?>
      
      <li class="artistas">
        <span class="titulo2">DEPOIMENTOS <a href="<?php echo $urlBase.'/depoimentos'; ?>" class="link1">Ver mais</a></span>
        <a href="" title="">
          <?php echo $dadosDepo['url']; ?>
        </a>
      </li>
    </ul>
    <!-- ul padrão -->
            
    <ul class="ul-padrao ul-galeria">
      <span class="titulo2">GALERIA DE FOTOS</span>
      
	  <?php
      
		$sqlGal = 'SELECT * FROM posts WHERE cat_slug = "galeria" ORDER BY id DESC LIMIT 2';
		try{
		$queryGal = $con->prepare($sqlGal);
		$queryGal->execute();
		$resGal   = $queryGal->fetchAll(PDO::FETCH_ASSOC);
		
		}catch (PDOexception $errorSelectGal){
		 echo 'Erro ao selecionar '.$errorSelectGal->getMessage();
		}
		foreach($resGal as $dadosGal){
      
      ?>
      
      <li>
        <a href="<?php echo $urlBase.'/'.$dadosGal['cat_slug'].'/'.$dadosGal['titulo_slug']; ?>" title="<?php echo $dadosGal['titulo']; ?>">
          <img src="<?php echo $urlBase; ?>/images/read-fotos.png" alt="" class="imagem-oculta" />
          <img src="<?php echo $urlBase; ?>/timthumb.php?src=<?php echo $urlBase; ?>/images/categorias/<?php echo $dadosGal['pasta'].'/'.$dadosGal['imagem']; ?>&w=330&h=165&zc=1&q=100" alt="">
          <span class="texto1">
		  <strong><?php echo limitaTexto($dadosGal['titulo'], 60);?></strong><br /><br />
		  <?php
             $dataEv = renomeiaData($dadosGal['data']); 
             echo $dataEv['dia'].'/'.$dataEv['mes'];
          ?>
          </span>
        </a>
      </li>
      
      <?php } ?>
      
    </ul>
    <!-- ul padrão -->
  
  </div>
  <!-- box1 -->
  
  <div class="right">
  
    <!-- Facebook Home -->
      <li class="face-home">
      
        <h2 class="topico2">Curta-nos no Facebook</h2>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-like-box" data-href="https://www.facebook.com/magalproducoes" data-width="280" data-height="560" data-colorscheme="dark" data-show-faces="true" data-header="false" data-stream="true" data-show-border="false"></div>        
        <a href="#" class="youtube-home" title="Youtube"></a>
        <a href="#" class="twitter-home" title="Twitter"></a>
        <a href="#" class="palcomp3-home" title="Palco MP3"></a>
        
      </li>
      <!-- Facebook Home -->
      
  </div>
  <!-- right -->
  
  
</div>
<!-- fix -->