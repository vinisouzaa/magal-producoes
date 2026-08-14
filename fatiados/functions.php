<?php
$url       = addslashes(strip_tags($_GET['url']));
$search    = addslashes(strip_tags($_POST['pesquisa']));
$urlE      = explode('/', $url);
$pagina    = $urlE['0'];
$post      = $urlE['1'];
$paginas   = array('institucional', 'fale-conosco', 'rss', 'home', 'radios');

/*************************************************************************************
************** FUNÇÃO GET_TITULO
**************************************************************************************/

function get_titulo(){

include("Connections/config.php");

$url       = addslashes(strip_tags($_GET['url']));
$search    = addslashes(strip_tags($_POST['pesquisa']));
$urlE      = explode('/', $url);
$pagina    = $urlE['0'];
$post      = $urlE['1'];

$paginas = array('institucional', 'fale-conosco', 'rss', 'home', 'radios');

if(isset($pagina) && $pagina !='' && in_array($pagina, $paginas)){ // ENTRA EM ALGUMA PÁGINA COMUN 
	

	$sql = 'SELECT * FROM configuracoes';
    try{
    $query = $con->prepare($sql);
    $query->execute();
    $res_query = $query->fetchAll(PDO::FETCH_ASSOC);    

    }catch (PDOexception $error_select){}
	foreach($res_query as $dados){}	

	echo $dados['titulo_site'];

}elseif(isset($post) && $post != '' && $pagina != 'tags'){ // ENTRA NO POST

	$sql = 'SELECT * FROM posts WHERE titulo_slug = :post';
    try{
    $query = $con->prepare($sql);
	$query->bindValue(':post',$post,PDO::PARAM_STR);
    $query->execute();
    $res_query = $query->fetchAll(PDO::FETCH_ASSOC);

    }catch (PDOexception $error_select){
		echo 'Erro ao selecionar '.$error_select->getMessage();
    }
	foreach($res_query as $dados);

	echo $dados['titulo'];

}elseif(isset($pagina) && $pagina == ''){ // TITULO DO SITE

	$sql = 'SELECT * FROM configuracoes';
    try{
    $query = $con->prepare($sql);
    $query->execute();
    $res_query = $query->fetchAll(PDO::FETCH_ASSOC);    

    }catch (PDOexception $error_select){}

	foreach($res_query as $dados){}	

	echo $dados['titulo_site'];	

}elseif(isset($pagina) && $pagina == 'tags'){  // tags	

	echo 'Fábrika do Som';	

}else{ // SE NÃO ENCONTRAR NADA, SERÁ CATEGORIA

	$sqlCat = 'SELECT * FROM categorias WHERE cat_slug = :pagina';
    try{
    $queryCat = $con->prepare($sqlCat);
	$queryCat->bindValue(':pagina',$pagina,PDO::PARAM_STR);
    $queryCat->execute();
    $res_queryCat = $queryCat->fetchAll(PDO::FETCH_ASSOC);

    }catch (PDOexception $error_selectCat){
		echo 'Erro ao selecionar '.$error_selectCat->getMessage();
    }
	
	foreach($res_queryCat as $dadosCat);

	if($dadosCat['categoria']){
		echo $dadosCat['categoria'];
	}else{
		echo "Página Não Encontrada!";
	}

 }
}

/*************************************************************************************
************** FUNÇÃO GET_METAS
**************************************************************************************/

function get_metas(){

include("Connections/config.php");

$url       = addslashes(strip_tags($_GET['url']));
$search    = addslashes(strip_tags($_POST['pesquisa']));
$urlE      = explode('/', $url);
$pagina    = $urlE['0'];
$post      = $urlE['1'];

$paginas = array('institucional', 'fale-conosco', 'rss', 'home', 'radios');

if(isset($post) && $post != '' && $pagina != 'politicas'){

	$sql = 'SELECT * FROM posts WHERE titulo_slug = :post';
    try{
    $query = $con->prepare($sql);
	$query->bindValue(':post',$post,PDO::PARAM_STR);
    $query->execute();
    $res_query = $query->fetchAll(PDO::FETCH_ASSOC);    

    }catch (PDOexception $error_select){}
	
	foreach($res_query as $res);	

    $qtLetras     = 250;
	$texto        = strip_tags($res['texto']);
	$contatamanho = strlen($texto);
	if($contatamanho > $qtLetras){
		$textoCerto = substr_replace($texto, "...", $qtLetras, $contatamanho - $qtLetras);
	} else {
		$textoCerto = $texto;
	}

	echo '<meta name="description" content="'.$textoCerto.'" />';
	echo '<meta name="keywords" content="'.$res['tags'].'" />';

}else{

	$sql = 'SELECT * FROM configuracoes';
    try{
    $query = $con->prepare($sql);
    $query->execute();
    $res_query = $query->fetchAll(PDO::FETCH_ASSOC);    

    }catch (PDOexception $error_select){
		echo 'Erro ao selecionar '.$error_select->getMessage();
    }

	foreach($res_query as $dados);

	echo '<meta name="description" content="'.$dados['descricao'].'" />';
	echo '<meta name="keywords" content="'.$dados['palavras_chave'].'" />';

  }
}
?>