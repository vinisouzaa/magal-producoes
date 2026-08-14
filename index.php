<?php
session_start();
//INCLUDES PHP
include_once("Connections/config.php");
include_once("fatiados/funcoes.php");
include_once("fatiados/functions.php");
?>
<!doctype html>
<html>

<head>
  <!-- CSS -->
  <link rel="shortcut icon" href="<?php echo $urlBase; ?>/images/favicon.png" type="image/x-icon">
  <link href="<?php echo $urlBase; ?>/css/estilo-magal.css" type="text/css" rel="stylesheet" media="screen" />
  <link rel="stylesheet" type="text/css" href="<?php echo $urlBase; ?>/js/tooltipster/tooltipster.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo $urlBase; ?>/js/tooltipster/themes/tooltipster-ok.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo $urlBase; ?>/js/evo/themes/white-green/jquery.lightbox.css" />
  
  <!-- Owl Carousel Assets -->
  <link rel="stylesheet" href="<?php echo $urlBase; ?>/css/owl.carousel.css">
  <link rel="stylesheet" href="<?php echo $urlBase; ?>/css/owl.theme.css">
  
  <!-- JS -->
  <script type="text/javascript" src="<?php echo $urlBase; ?>/js/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo $urlBase; ?>/js/corner.js"></script>
  <script type="text/javascript" src="<?php echo $urlBase; ?>/js/evo/jquery.lightbox.min.js"></script>
  <script type="text/javascript" src="<?php echo $urlBase; ?>/js/jquery.cycle.all.js"></script>
  <script type="text/javascript" src="<?php echo $urlBase; ?>/js/jquery.easing.js"></script>
  <script type="text/javascript" src="<?php echo $urlBase; ?>/js/owl.carousel.js"></script>
  <script type="text/javascript" src="<?php echo $urlBase; ?>/js/tooltipster/jquery.tooltipster.min.js"></script>
  
  
  <script type="text/javascript" src="<?php echo $urlBase; ?>/js/funcoes.js"></script>
  <meta charset="utf-8">
  <?php get_metas(); ?>
<title><?php get_titulo(); ?></title>
  
</head>

<body>
<div class="header cem-porcento">

  <div class="fix">
  
    <a class="logo" href="<?php echo $urlBase; ?>/home" title="Página Inicial">
      <img src="<?php echo $urlBase; ?>/images/logo.png" alt="" />
    </a>
    
    <div class="redes-top">
      <span class="msg-god"></span>
      <ul>
	<li><a href="https://www.magalproducoes.com.br/download/CD_VOL_2.rar" title="Downloads de CD Volume 2" class="tooltip" target="_blank"><img src="<?php echo $urlBase; ?>/images/downlod_cd.png" alt=""></a></li>
        <li><a href="https://instagram.com/magalproducoes" title="Instagram" class="tooltip" target="_blank"><img src="<?php echo $urlBase; ?>/images/instagram.png" alt=""></a></li>
        <li><a href="https://www.youtube.com/channel/UCFPVEEsfLy10o-RoU7hB7hg" title="Youtube" class="tooltip" target="_blank"><img src="<?php echo $urlBase; ?>/images/youtube.png" alt=""></a></li>
        <li><a href="https://www.facebook.com/magalproducoes?fref=ts" title="Facebook" class="tooltip" target="_blank"><img src="<?php echo $urlBase; ?>/images/facebook.png" alt=""></a></li>
        <li><a href="<?php echo $urlBase; ?>/fale-conosco" title="Fale Conosco" class="tooltip" target="_blank"><img src="<?php echo $urlBase; ?>/images/icon-contato.png" alt=""></a></li>
      </ul>
    </div>
    
    <div class="nav">
      <ul>
        <li><a href="<?php echo $urlBase; ?>/home" title="Página inicial">HOME</a></li>
        <li><a href="<?php echo $urlBase; ?>/institucional/sobre-nos" title="Conheça mais sobre nossa empresa">SOBRE NÓS</a></li>
        <li><a href="<?php echo $urlBase; ?>/institucional/servicos" title="Serviços e Roteiro" >SERVIÇOS</a></li>
        <li><a href="<?php echo $urlBase; ?>/artistas" title="Artistas" >ARTISTAS</a></li>
        <li><a href="<?php echo $urlBase; ?>/videos" title="Vídeos" >VÍDEOS</a></li>
	 <li><a href="<?php echo $urlBase; ?>/radios" title="Rádios" >RÁDIOS</a></li>
        <li><a href="<?php echo $urlBase; ?>/galeria" title="Galeria de Fotos" >FOTOS</a></li>
        <li><a href="<?php echo $urlBase; ?>/fale-conosco" title="Fale Conosco" >CONTATO</a></li>
      </ul>
    </div>
  
  </div>
  <!-- Fix -->
  
</div>
<!-- Header -->

<?php //if($pagina == 'home' | $pagina == ''){ ?>

<div class="backgrounds pics2" align="center">

  <?php
	
	$sqlBanner = 'SELECT * FROM banners ORDER BY id DESC';
	try{
	$queryBanner = $con->prepare($sqlBanner);
	$queryBanner->execute();
	$resBanner  = $queryBanner->fetchAll(PDO::FETCH_ASSOC);
	
	}catch (PDOexception $errorBanner){}
	
	foreach($resBanner as $dadosBanner){
  
  ?>
  
  <div style="background:url(<?php echo $urlBase.'/images/banners/'.$dadosBanner['imagem']; ?>) no-repeat center center;" class="bg1"></div>
  
  <?php } ?>
</div> 
<!-- Banner -->
<?php //} ?>

<div class="box">
  
  <?php include_once("fatiados/query_url_amigavel.php"); ?>
  
</div>
<!-- Box -->

<div class="box-parceiros">

  <div class="fix">
  
    <div class="parceiros">
  
	<?php
    
    $sqlParc = "SELECT * FROM parceiros ORDER BY id DESC";
    
    try{
    $queryParc = $con->prepare($sqlParc);
    $queryParc->execute();
    $resQueryParc = $queryParc->fetchAll(PDO::FETCH_ASSOC);
    
    }catch (PDOexception $errorSelectParc){
    }
        
    foreach($resQueryParc as $dadosParc){
    
    ?>
    
      <div class="item">
        <a href="<?php echo $dadosParc['link'];?>" title="<?php echo $dadosParc['titulo'];?>" target="_blank">
          <img src="<?php echo $urlBase;?>/images/parceiros/<?php echo $dadosParc['imagem']; ?>" />
        </a>
      </div>
    
    <?php } ?>
  
    </div>
  
  </div>
  <!-- Fix -->
 
</div>
<!-- Portifolio -->

<div class="footer cem-porcento">

  <div class="fix">
  
    <span><?php echo $conf['copyright']; ?></span>
    <a href="http://www.playlan.com.br" title="Dê vida ao seu negócio! Descubra um novo horizonte." class="logo-developer tooltip"></a>
  
  </div>
  <!-- Fix -->
  
</div>
<!-- Footer -->

</body>
</html>