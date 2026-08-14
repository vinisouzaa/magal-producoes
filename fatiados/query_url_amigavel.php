<?php 


$url       = addslashes(strip_tags($_GET['url']));
$search    = addslashes(strip_tags($_POST['pesquisa']));
$urlE      = explode('/', $url);
$pagina    = $urlE['0'];
$post      = $urlE['1'];

$paginas = array('institucional', 'fale-conosco', 'rss', 'home', 'radios');


/* Verifica se a pagina existe(Primeiro parametro) e verifica se ela está dentro das páginas permitidas */
if(isset($pagina) && $pagina !='' && in_array($pagina, $paginas)){ 
	
	include "pags/$pagina.php";
	
}elseif(isset($post) && $post != '' && $pagina != 'tags'){ 
	
	include "pags/post.php";
	
	/* Se a página(Primeiro parametro) não existe, inclua a home */	
}elseif(isset($pagina) && $pagina == ''){ 
	
	include "pags/home.php";
	
	/* Se a página(Primeiro parametro) existir e se for igual a TAGS, inclua tags.php */
}elseif(isset($pagina) && $pagina == 'tags'){ 
	
	include "pags/tags.php";
	
}elseif(isset($pagina) && $pagina == 'rss'){ 
		
	header('Location: '.$urlBase.'/rss.xml');
	
}else{
	
	include "pags/categoria.php"; /* Se nada acima for encontrado, mostre as categorias */
}

?>