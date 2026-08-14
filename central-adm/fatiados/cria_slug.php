<?php
function slug($string){
$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ"!@#$%&*()_-+={[}]/?;:.,\\\'<>';
$b = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                              ';
$string = utf8_decode($string);
$string = strtr($string, utf8_decode($a), $b);
$string = strip_tags(trim($string));
$string = str_replace(" ","-",$string);
return strtolower(utf8_encode($string));
}

function tag($string){
$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ"!@#$%&*()_-+={[}]/?;:.\\\'<>';
$b = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                             ';
$string = utf8_decode($string);
$string = strtr($string, utf8_decode($a), $b);
$string = strip_tags(trim($string));
return strtolower(utf8_encode($string));
}

// exemplo de uso
//$posts = slug($_POST['input']);
?>