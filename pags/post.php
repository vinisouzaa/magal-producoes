<?php

if($pagina == 'servicos' | $pagina == 'artistas' | $pagina == 'depoimentos' | $pagina == 'videos'){
	
	include_once("pags/view-post.php");
	
}elseif($pagina == 'galeria'){
	
	include_once("pags/view-events.php");
	
}else{
	
   include("pags/404.php");
   return false; 
   
}
    
?>
