<?php 
$protocolo    = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === false) ? 'http' : 'https'; 
$host         = $_SERVER['HTTP_HOST']; 
$script       = $_SERVER['SCRIPT_NAME']; 
$parametros   = $_SERVER['QUERY_STRING']; 
$UrlAtual     = $protocolo . '://' . $host . $script . '?' . $parametros; 
 
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-like" data-href="<?php echo $UrlAtual; ?>" 
data-send="false" data-layout="button_count" data-width="auto" data-show-faces="true"></div>