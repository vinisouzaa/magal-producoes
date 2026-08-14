<?php

//Abre o diretorio raiz
$handle= @opendir(".");
// abre ou cria o arquivo xml
$xml = fopen("../rss.xml","w+");
//Gravamos os dados iniciais do xml
fwrite($xml,"<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<rss version=\"2.0\">\n<channel>\n\n");

// Buscando os dados da página
$sql = 'SELECT * FROM configuracoes';

try{
$query = $con->prepare($sql);
$query->execute();
$res   = $query->fetchAll(PDO::FETCH_ASSOC);

}catch (PDOexception $errorSelect){
echo 'Erro ao selecionar '.$errorSelect->getMessage();
}
foreach($res as $dados);
	

//Titulo RSS
$conteudo  = '<title>'.$dados['titulo'].'</title>'."\n";	 
//Link para ass
$conteudo .='<link>'.$urlBase.'</link>'."\n";
//Descrição RSS
$conteudo .= '<description>'.$dados['descricao'].'</description>'."\n\n\n";
fwrite($xml,$conteudo);
/* Função para limitar o texto */

/* Buscando Posts */
$sqlUrl = 'SELECT * FROM posts ORDER BY id DESC';

try{
$queryUrl = $con->prepare($sqlUrl);
$queryUrl->execute();
$resUrl   = $queryUrl->fetchAll(PDO::FETCH_ASSOC);

}catch (PDOexception $errorSelectUrl){
echo 'Erro ao selecionar '.$errorSelectUrl->getMessage();
}

foreach($resUrl as $res_url){
	
	$tituloSlug = $res_url['titulo_slug'];
	$data       = $res_url['data'];
	$catSlug    = $res_url['cat_slug'];
	$tituloPost = $res_url['titulo'];
	$descPost   = $res_url['texto'];
	

//Abre ITEM FEED
$conteudo  = '  <item>'."\n";	 
//Titulo do FEED
$conteudo .='     <title>'.$tituloPost.'</title>'."\n";
//LINK PARA O FEED
$conteudo .= '     <link>'.$urlBase.'/'.$catSlug.'/'.$tituloSlug.'</link>'."\n";
//DESCREVE O FEED
$conteudo .= '     <description>'.htmlentities(limitaTexto($descPost,700)).'</description>'."\n";
//Fecha ITEM FEED
$conteudo .= '  </item>'."\n";
fwrite($xml,$conteudo);
}

// PÁGINAS FIXAS
$paginaFixa  = '\n\n  <item>'."\n";
$paginaFixa .='     <title>O que fazemos</title>'."\n";
$paginaFixa .= '     <link>'.$urlBase.'/o-que-fazemos'.'</link>'."\n";
$paginaFixa .= '     <description>Veja nossos serviços!</description>'."\n";
$paginaFixa .= '  </item>'."\n";

$paginaFixa .= '\n\n  <item>'."\n";
$paginaFixa .='     <title>Portifólio</title>'."\n";
$paginaFixa .= '     <link>'.$urlBase.'/portifolio'.'</link>'."\n";
$paginaFixa .= '     <description>Veja aqui nossos serviços já realizados</description>'."\n";
$paginaFixa .= '  </item>'."\n";

fwrite($xml,$paginaFixa);

closedir($handle);
//Fechamos a estrutura do xml
fwrite($xml,"\n</channel>\n</rss>");
//Fecha o arquivo aberto (para liberar memoria do servidor)
fclose($xml);

?>