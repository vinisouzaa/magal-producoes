<?php

/*************************************************************************************
**************** FUNÇÃO PARA CALENDÁRIO (DIA ATUAL)
*************************************************************************************/

/* Leitura das datas */
date_default_timezone_set('America/Cuiaba');

$dia    = date('d');
$mes    = date('m');
$ano    = date('Y');
$semana = date('w');

/*Configuração do mês*/
switch ($mes) {
	
	case 1 : $mes = "Janeiro"; break;
	case 2 : $mes = "Fevereiro"; break;
	case 3 : $mes = "Mar&ccedil;o"; break;
	case 4 : $mes = "Abril"; break;
	case 5 : $mes = "Maio"; break;
	case 6 : $mes = "Junho"; break;
	case 7 : $mes = "Julho"; break;
	case 8 : $mes = "Agosto"; break;
	case 9 : $mes = "Setembro"; break;
	case 10 : $mes = "Outubro"; break;
	case 11 : $mes = "Novembro"; break;
	case 12 : $mes = "Dezembro"; break;

}
/*Configuração da semana*/
switch ($semana) {
	
	case 0 : $semana = "Domingo"; break;
	case 1 : $semana = "Segunda-feira"; break;
	case 2 : $semana = "Ter&ccedil;a-feira"; break;
	case 3 : $semana = "Quarta-feira"; break;
	case 4 : $semana = "Quinta-feira"; break;
	case 5 : $semana = "Sexta-feira"; break;
	case 6 : $semana = "S&aacute;bado"; break;

}
//echo ("$semana, $dia DE $mes DE 20$ano");



/*************************************************************************************
**************** FUNÇÃO PARA RENOMEAR DATA EX: 25/Jul
*************************************************************************************/

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

/**********************************************************************************************************************
**************** Função limitaTexto Desenvolvida por L.A. Sites Data: 16/11/2011 ::::Todos os direitos Reservados:::
***********************************************************************************************************************/

function limitaTexto($texto, $qtLetras){
  $texto = strip_tags($texto);
  $contatamanho = strlen($texto);
  if($contatamanho > $qtLetras){
		$textoCerto = substr_replace($texto, "ver mais", $qtLetras, $contatamanho - $qtLetras);
	}else{
		$textoCerto = $texto;
	}
	return $textoCerto;
}


/*************************************************************************************
**************** FUNÇÃO PARA ENVIO DE E-MAIL AUTENTICADO
*************************************************************************************/

function sendMail($assunto,$mensagem,$remetente,$nomeRemetente,$destino1,$nomeDestino,$anexo = '',$destino2 = '',$destino3 = ''){
	
  require_once('mail/class.phpmailer.php'); //Include pasta/classe do PHPMailer
  
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
  $mail->Password = $conf['code_email_contato']; //senha
  
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
  
  if($anexo != ''){
	  $mail->AddAttachment($anexo['tmp_name'],$anexo['name']);//anexa o arquivo
  }
  
  
  
  //$mail->SMTPDebug  = 2;
  
  if($mail->Send()){
  		return true;
  }else{
  		return false;
  }
}


/*************************************************************************************
**************** BUSCANDO CONFIGURAÇÕES
*************************************************************************************/

$sqlConf = 'SELECT * FROM configuracoes';
  try{
  $queryConf = $con->prepare($sqlConf);
  $queryConf->execute();
  $resConf  = $queryConf->fetchAll(PDO::FETCH_ASSOC);

  }catch (PDOexception $errorSelectConf){
   echo 'Erro ao selecionar '.$errorSelectConf->getMessage();
  }
  foreach($resConf as $conf);


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