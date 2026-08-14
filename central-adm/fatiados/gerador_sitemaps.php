<?php

//Abre o diretorio raiz
$handle= @opendir(".");
// abre ou cria o arquivo xml
$xml = fopen("../sitemap.xml","w+");
//Gravamos os dados iniciais do xml
fwrite($xml,"<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n\n");

//Abre url
$conteudo  = '  <url>'."\n";	 
//pega o Dominio e o nome do arquivo
$conteudo .= '     <loc>'.$urlBase.'</loc>'."\n";
//pega a data atual e informa no xml
$conteudo .= '     <lastmod>'.date('Y-m-d').'</lastmod>'."\n";
//informa a frequencia de atualização da pagina
$conteudo .= '     <changefreq>daily</changefreq>'."\n";
//informa a prioridade da pagina
$conteudo .= '     <priority>1.0</priority>'."\n";
//Fecha url
$conteudo .= '  </url>'."\n";
fwrite($xml,$conteudo);

$sql = 'SELECT * FROM posts ORDER BY id DESC';

try{
$query = $con->prepare($sql);
$query->execute();
$res   = $query->fetchAll(PDO::FETCH_ASSOC);

}catch (PDOexception $errorSelect){
echo 'Erro ao selecionar '.$errorSelect->getMessage();
}
foreach($res as $res_url){
	
	$tituloSlug = $res_url['titulo_slug'];
	$data       = $res_url['data'];
	$catSlug    = $res_url['cat_slug'];

//Abre url
$conteudo  = '  <url>'."\n";	 
//pega o Dominio e o nome do arquivo
$conteudo .='     <loc>'.$urlBase.'/'.$catSlug.'/'.$tituloSlug.'</loc>'."\n";
//pega a data atual e informa no xml
$conteudo .= '     <lastmod>'.date('Y-m-d', strtotime($data)).'</lastmod>'."\n";
//informa a frequencia de atualização da pagina
$conteudo .= '     <changefreq>monthly</changefreq>'."\n";
//informa a prioridade da pagina
$conteudo .= '     <priority>0.2</priority>'."\n";
//Fecha url
$conteudo .= '  </url>'."\n";
fwrite($xml,$conteudo);
}

// PÁGINAS FIXAS
$paginaFixa  = '  <url>'."\n";
$paginaFixa .= '     <loc>'.$urlBase.'/o-que-fazemos'.'</loc>'."\n";
$paginaFixa .= '     <lastmod>'.date('Y-m-d').'</lastmod>'."\n";
$paginaFixa .= '     <changefreq>monthly</changefreq>'."\n";
$paginaFixa .= '     <priority>0.2</priority>'."\n";
$paginaFixa .= '  </url>'."\n";

$paginaFixa  = '  <url>'."\n";
$paginaFixa .= '     <loc>'.$urlBase.'/portifolio'.'</loc>'."\n";
$paginaFixa .= '     <lastmod>'.date('Y-m-d').'</lastmod>'."\n";
$paginaFixa .= '     <changefreq>monthly</changefreq>'."\n";
$paginaFixa .= '     <priority>0.2</priority>'."\n";
$paginaFixa .= '  </url>'."\n";

fwrite($xml,$paginaFixa);

closedir($handle);
//Fechamos a estrutura do xml
fwrite($xml,"\n</urlset>");
//Fecha o arquivo aberto (para liberar memoria do servidor)
fclose($xml);
?>