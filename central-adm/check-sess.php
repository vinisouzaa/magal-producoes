<?php

// VERIFICANDO A SESSÃO, SE NÃO EXISTIR, REDIRECIONA PARA O LOGIN
if(!$_SESSION[NOMESESSION]){
	
	$_SESSION[NOMESESSION] = '';
	unset($_SESSION[NOMESESSION]);
	header('Location: index.php');	
	
}else{
	
	//BUSCANDO O USUÁRIO PELOS DADOS DA SESSÃO
	$userId    = $_SESSION[NOMESESSION]['id'];
	$userLogin = $_SESSION[NOMESESSION]['login'];
	$userSenha = $_SESSION[NOMESESSION]['senha'];
	$sqlUser   = 'SELECT * FROM usuarios WHERE id = :userId AND login = :userLogin AND senha = :userSenha';
	
	try{
	$queryUser = $con->prepare($sqlUser);
	$queryUser->bindValue(':userId',$userId ,PDO::PARAM_STR);
	$queryUser->bindValue(':userLogin',$userLogin,PDO::PARAM_STR);
	$queryUser->bindValue(':userSenha',$userSenha,PDO::PARAM_STR);
	$queryUser->execute();
	$countUser = $queryUser->rowCount(PDO::FETCH_ASSOC);
	
	}catch (PDOexception $error_selectUser){}  
		   
	if($countUser <= 0){
	  
	 $_SESSION[NOMESESSION] = '';
	 unset($_SESSION[NOMESESSION]);	 
	 header('Location: index.php');
	 return false; 
	 
	}
	
}



// CHECANDO O NÍVEL DOS USUÁRIOS

$nivel = $_SESSION[NOMESESSION]['nivel'];

function checkNivel($nivelPermitido){
	
	
	if($GLOBALS['nivel'] <= $nivelPermitido && $GLOBALS['nivel'] != '0' && $GLOBALS['nivel'] <= '3'){
		
		return true;
		
	}else{
	
		return false;
		
	}
	
}

?>