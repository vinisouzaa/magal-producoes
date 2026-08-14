<?php

/**************************************************************************************************************************************************
******************************* FUNÇÃO PARA RENOMEAR DATA EX: 25/Jul
**************************************************************************************************************************************************/
function renomeiaData($data){
	
  $mes = date('m',strtotime($data));
  $dia = date('d',strtotime($data));
  
  switch ($mes) {
  case 1  : $mes = "Jan"; break;
  case 2  : $mes = "Fev"; break;
  case 3  : $mes = "Mar"; break;
  case 4  : $mes = "Abr"; break;
  case 5  : $mes = "Mai"; break;
  case 6  : $mes = "Jun"; break;
  case 7  : $mes = "Jul"; break;
  case 8  : $mes = "Ago"; break;
  case 9  : $mes = "Set"; break;
  case 10 : $mes = "Out"; break;
  case 11 : $mes = "Nov"; break;
  case 12 : $mes = "Dez"; break;
  }
  
   $dataCerta['dia'] = $dia;
   $dataCerta['mes'] = $mes;
   return $dataCerta;
   //return $dia.'/'.$mes;
}

/**************************************************************************************************************************************************
******************************* FUNÇÃO PARA LIMITAR TEXTOS - By L.A Sites - Data: 16/11/2011
**************************************************************************************************************************************************/
function limitaTexto($texto, $qtLetras){
  $texto = strip_tags($texto);
  $contatamanho = strlen($texto);
  if($contatamanho > $qtLetras){
		$textoCerto = substr_replace($texto, "...", $qtLetras, $contatamanho - $qtLetras);
	}else{
		$textoCerto = $texto;
	}
	return $textoCerto;
}


/**************************************************************************************************************************************************
******************************* BUSCANDO CONFIGURAÇÕES DO SITE
**************************************************************************************************************************************************/
$sqlConf = 'SELECT * FROM configuracoes';
  try{
  $queryConf = $con->prepare($sqlConf);
  $queryConf->execute();
  $resConf  = $queryConf->fetchAll(PDO::FETCH_ASSOC);

  }catch (PDOexception $errorSelectConf){
   echo 'Erro ao selecionar '.$errorSelectConf->getMessage();
  }
  foreach($resConf as $conf);


/**************************************************************************************************************************************************
******************************* FUNÇÃO PARA APAGAR UM DIRETÓRIO
**************************************************************************************************************************************************/
function apagar($dir){
	
  if(is_dir($dir)) {
	  
    if($handle = opendir($dir)) {
		
      while(false !== ($file = readdir($handle))) {
		  
        if(($file == ".") or ($file == "..")) {
			
          continue;
        }
		
        if(is_dir($dir . $file)) {
			
          apagar($dir . $file . "/");
		  
        }else{
			
          unlink($dir . $file);
		  
        }
		
      }
	  
    }else{
	
		print("nao foi possivel abrir o arquivo.");
		return false;
		
    }

    // fecha a pasta aberta
    closedir($handle);
	
    // apaga a pasta, que agora esta vazia
    rmdir($dir);
	
  }else{
	  
	print("diretorio informado invalido");
	return false;
	
  }
}

/**************************************************************************************************************************************************
******************************* FUNÇÃO PARA REMIMENSIONAR - Desenvolvido por David CHC
**************************************************************************************************************************************************/
function resize($tmp, $name, $largura, $pasta){
	list($width, $height, $type, $attr) = getimagesize($tmp);
	switch($type){
		case 1: $img = imagecreatefromgif($tmp);break;
		case 2: $img = imagecreatefromjpeg($tmp);break;
		case 3: $img = imagecreatefrompng($tmp);break;
		default:exit('Imagem permitidas são GIF, JPEG, PNG');
	}
	$altura = ($largura * $height)/$width;
	$nova = imagecreatetruecolor($largura, $altura);
	imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $width, $height);
	switch($type){
		case 1: imagegif($nova, "$pasta/$name");break;
		case 2: imagejpeg($nova, "$pasta/$name");break;
		case 3: imagepng($nova, "$pasta/$name");break;
		default:exit('Imagem permitidas são GIF, JPEG, PNG');
	}
	imagedestroy($img);
	imagedestroy($nova);
}


/**************************************************************************************************************************************************
******************************* FUNÇÃO PARA CORRIGIR TEXTO EX: echo corrigeTexto("JoÃo DE BaRRoS"); Resultado: João de Barros
**************************************************************************************************************************************************/
function corrigeTexto($string){

	$string      = ucwords(mb_strtolower($string, 'UTF-8'));
	$stringEx    = explode(' ', $string);
	$countString = count($stringEx);

	for($i = 0; $i < $countString; $i++){

		if(strlen($stringEx[$i]) == 1 || strlen($stringEx[$i]) == 2){

			$stringEx[$i] = mb_strtolower($stringEx[$i], 'UTF-8');

		}
	}

	$stringEx = implode(' ', $stringEx);
	return $stringEx;

}


//FUNÇÃO PARA ENVIO DE E-MAIL AUTENTICADO
function sendMail($assunto,$mensagem,$remetente,$nomeRemetente,$destino1,$nomeDestino,$destino2 = '',$destino3 = ''){
	
  require_once('../mail/class.phpmailer.php'); //Include pasta/classe do PHPMailer
  
  $conexao = 'mysql:host='.HOST.';dbname='.DB;
  try{
  $con = new PDO($conexao,USER,PASS);
  $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  }catch (PDOexception $error_conecta){
	 echo 'Erro ao conectar-se com o banco de dados! ';
  }
  
  //BUSCANDO CONFIGURAÇÕES DO SITE
  $sql = 'SELECT * FROM configuracoes';
  try{
	$query = $con->prepare($sql);
	$query->execute();
	$res  = $query->fetchAll(PDO::FETCH_ASSOC);
	}catch (PDOexception $error_select){
	 echo 'Erro ao selecionar '.$error_select->getMessage();
	}
  foreach($res as $conf);
  
  $mail = new PHPMailer(); //INICIA A CLASSE
  $mail->IsSMTP(); //Habilita envio SMPT
  $mail->SMTPSecure = 'ssl';
  $mail->SMTPAuth = true; //Ativa email autenticado
  $mail->IsHTML(true);
  
  $mail->Host = $conf['servidor_email']; //Servidor de envio
  $mail->Port = $conf['porta_email']; //Porta de envio
  $mail->Username = $conf['email_contato']; //email para smtp autenticado
  $mail->Password = $conf['code']; //seleciona a porta de envio
  
  $mail->From = utf8_decode($remetente); //remtente
  $mail->FromName = utf8_decode($nomeRemetente); //remtetene nome
  
  $mail->Subject = utf8_decode($assunto); //assunto
  $mail->Body = utf8_decode($mensagem); //mensagem
  $mail->AddAddress(utf8_decode($destino1),utf8_decode($nomeDestino)); //email e nome do destino
  
  if($destino2 != ''){
	  $mail->AddAddress(utf8_decode($destino2),utf8_decode($nomeDestino));
  }
  
  if($destino3 != ''){
	  $mail->AddAddress(utf8_decode($destino3),utf8_decode($nomeDestino));
  }
  
  //$mail->SMTPDebug  = 2;
  
  if($mail->Send()){
  		return true;
  }else{
  		return false;
  }
}

/*************************************************************************************
**************** FUNÇÃO PARA VALIDAR CAMPOS DE FORMULÁRIO
*************************************************************************************/

function verificaCampos($campo, $minimo, $nomeCampo){

  /* Se a qtd mínima de caracteres não for definida entre neste código */
  if($minimo == ''){

	  if($nomeCampo == ''){
		  $erro = 'Por favor preencha todos os campos.';

	  }else{	
		  $erro = 'Por favor preencha o campo '.$nomeCampo.'.';	
	  }

	  if ($campo == "") {
		  $return = array('condicao' => 'falso','erro' =>$erro);
		  return $return;
		  
	  }else{
		  return true;
	  }
  /* Se for definida, entre neste */	
  }else{

  if($nomeCampo == ''){
	  $erro = 'Por favor preencha todos os campos.';
	  
  }else{	
	  $erro = 'Por favor preencha o campo '.$nomeCampo.', Mínimo '.$minimo.' Caracteres.';	
  }
  
	if ($campo == "" || strlen($campo) < $minimo) {

		$return = array('condicao' => 'falso','erro' =>$erro);
		return $return;
		
	}else{
		return true;
	}
  }
}

/*************************************************************************************
**************** FUNÇÃO PARA VALIDAR EMAILS
*************************************************************************************/

function valida_email($endereco){

  $pattern = "^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-]+\.[a-zA-Z0-9\-\.]+$";
  if (eregi($pattern, $endereco)){
	 return true; 
  }

  else {
	 return false;
  }   
}

?>