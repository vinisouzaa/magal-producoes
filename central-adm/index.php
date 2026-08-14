<?php
ob_start();
session_start();

include_once("nomeSession.php");
include_once("../Connections/config.php");
include_once("fatiados/funcoes.php");

//EFETUA O LOGIN
if(!empty($_SESSION[NOMESESSION])){
	header('Location: home.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  
  <!-- Arquivos CSS -->
  <link href="css/estilo_adm.css" type="text/css" rel="stylesheet" media="screen" />
  <link href="../css/reset.css" type="text/css" rel="stylesheet" media="screen" />
  <link href="js/tooltip/tipTip.css" rel="stylesheet" type="text/css" />
  
  <!-- Arquivos JS -->
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/tooltip/jquery.tipTip.minified.js"></script>
  <script type="text/javascript" src="js/funcoes.js"></script>
  
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  
  <title>Administração <?php echo $conf['titulo_site']; ?></title>
  
</head>

<body class="body1">

<div class="det-top"></div>

<div id="box">

  <?php
  
	if(isset($_POST['sendLoger'])){
				
		//RECUPERANDO AS VARIÁVEIS
		$loger = addslashes(strip_tags(trim($_POST['loger'])));
		$senha = addslashes(strip_tags(trim($_POST['senha'])));
		$salva = addslashes(strip_tags(trim($_POST['remember'])));
		
		// VALIDANDO O LOGIN
		$valLogin = verificaCampos($loger, 4, 'Login');
		if($valLogin['condicao'] == 'falso'){
			echo'
			<div class="msg erro">
			  Erro!
			  <span>'.$valLogin['erro'].'</span>
			</div>
			';
		}else{
		  //VALIDANDO A SENHA
		  $valSenha = verificaCampos($senha, 4, 'Senha');
		  if($valSenha['condicao'] == 'falso'){
			  echo'
			  <div class="msg erro">
				Erro!
				<span>'.$valSenha['erro'].'</span>
			  </div>
			  ';
		  }else{
			  
			  //VERIFICANDO SE O E-MAIL DIGITADO EXISTE NO BANCO DE DADOS
			  $sql = 'SELECT * FROM usuarios WHERE login = :loger';
			  try{
				$query = $con->prepare($sql);
				$query->bindValue(':loger',$loger,PDO::PARAM_STR);
				$query->execute();
				$res   = $query->fetchAll(PDO::FETCH_ASSOC);
				$count = $query->rowCount(PDO::FETCH_ASSOC);
			  }catch (PDOexception $errorSelect){
			    echo 'Erro ao selecionar '.$errorSelect->getMessage();
			  } 
			   if($count > 0){
				 
				 foreach($res as $dados){
					//VERIFICANDO SE LOGIN E SENHA SÃO CORRETOS
					if($loger == $dados['login'] && md5($senha) == $dados['senha']){
											  
					  //SETANDO A SESSÃO
					  $_SESSION[NOMESESSION] = $dados;
					  header('Location: '.$_SERVER['PHP_SELF']);
						
					}else{
					  echo'
					  <div class="msg erro">
						Erro!
						<span>A senha informada não confere!</span>
					  </div>
					  '; 
					}
					 
				 }
				 
			   }else{
				  echo'
				  <div class="msg erro">
					Erro!
					<span>Login Inválido!<span>Seu cadastro não existe!</span></span>
				  </div>
				  ';    
			   }
			  
		  }//IF DA VALIDAÇÃO DA SENHA
		}//IF DA VALIDAÇÃO DO LOGIN
	// IF DO POST sendLoger
	}
	
	if(!$_GET['remember']){ 
	
	?>
  
    <div class="tit"><h1>Administração <?php echo $conf['titulo_site']; ?></h1></div>
    
    <form name="login" action="" method="POST">
    
      <div class="list">
        <span>Login:</span><input type="text" name="loger" maxlength="30" class="inp valLogin" value="<?php if($loger) echo $loger; ?>" />
      </div>
     <div class="list">
        <span>Senha:</span><input type="password" name="senha" maxlength="16" class="inp valSenha" value="<?php if($senha) echo $senha; ?>" />
      </div>
      <div class="list2">
        <input type="submit" value="Logar" name="sendLoger" class="sub" id="logar" />
        <a href="index.php?remember=true" class="esqueci" title="Esqueceu sua senha?">Esqueci minha senha!</a>
      </div>
    
    </form>
    
    <?php 
	
	}else{ 
	
	  if(isset($_POST['sendRecupera'])){
		  
		  $email = addslashes(strip_tags(trim($_POST['mailRecover'])));
		  
		  // VALIDANDO O EMAIL
		  $valMail = verificaCampos($email, 6, 'E-mail');
		  if($valMail['condicao'] == 'falso'){
			  echo'
			  <div class="msg erro">
				Erro!
				<span>'.$valMail['erro'].'</span>
			  </div>
			  ';
		  }else{
			
			$sql = 'SELECT * FROM usuarios WHERE email = :email';
			try{
			  $query = $con->prepare($sql);
			  $query->bindValue(':email',$email,PDO::PARAM_STR);
			  $query->execute();
			  $res   = $query->fetchAll(PDO::FETCH_ASSOC);
			  $count = $query->rowCount(PDO::FETCH_ASSOC);
			}catch (PDOexception $errorSelect){
			  echo 'Erro ao selecionar '.$errorSelect->getMessage();
			}
			  if($count <= 0){
				  
				  echo '<div class="msg erro">Erro!<span>Seu e-mail é inválido!</span></div>';
				  				  
			  }else{
				  
				foreach($res as $dadosEmail){
					
				}
				$arrayEmails = str_replace(' ','',explode(',',$dadosEmail['email']));
				
				if(in_array($email, $arrayEmails)){
					
					$mensagem = '
<div style="width:90%; padding:5%; display:inline-block; background:#f6f6f6;"><h1 style="font:22px Trebuchet MS; color:#09c; letter-spacing:-1px; font-weight:bold; margin:0px 0 30px 00px;">Prezado '.$dadosEmail['nome'].', recupere sua senha!</h1><span style="font:16px Trebuchet MS; color:#555; letter-spacing:-1px;">Estamos entrando em contato por causa de uma solicitação de recuperação de senha em nosso sistema!<br/><br />VERIFIQUE SEUS DADOS ABAIXO:</span></div><div style="width:90%; padding:5%; display:inline-block; background:#eee;"><span style="font:16px Trebuchet MS; color:#555; letter-spacing:-1px;">LOGIN: '.$dadosEmail['login'].'<br/>SENHA: '.$dadosEmail['code'].'<br/><br/><br/><span style="color:#F00; font-size:20px;">Recomendamos a você que altere seus dados após efetuar o login em nosso sistema.</span></span></div><div style="width:96%; padding:2%; display:inline-block; background:#09c; color:#fff;"><br/><span style="font:16px Trebuchet MS; color:#fff; letter-spacing:-1px;">Data de envio: '.date('d/m/Y H:i:s').'</span></div>
					';
					echo '<div class="msg certo">Você acaba de recuperar a sua senha!<span>As instruções foram enviadas para o e-mail: <strong>'.$email.'</strong>.</span></div>';
					sendMail('Recupere seus dados de acesso!',$mensagem,$conf['email_contato'],'Mensagem do site',$email,$dadosEmail['nome']);
					
				}else{
					
					echo '<div class="msg erro">Erro!<span>Seu e-mail é inválido!</span></div>';
					
				}
				
				
				  
			  }//IF COUNT > 0
		  }// IF DA VALIDAÇÃO DO E-MAIL
	  }//IF DO POST sendRecupera
	
	?>
    
  <div style="display:none;">
  <div class="msg certo">
    Sucesso!
    <span>Descrição do resultado</span>
  </div>
  </div>
    
    <div class="tit"><h1>Administração <?php echo $conf['titulo_site']; ?></h1></div>
    
    <form name="remember" action="" method="post">
    
      <div class="list">
        <span>Email:</span>
        <input type="text" name="mailRecover" class="inp valEmail tipTip" title="As instruções de recuperação de senha serão enviadas em seu e-mail!" value="<?php if($email) echo $email; ?>" />
      </div>
      
      <div class="list2">
        <input type="submit" value="Enviar" name="sendRecupera" class="sub" />
        <a href="index.php" class="esqueci" title="Voltar">Voltar</a>
      </div>
    
    </form>
    <?php } ?>
    
</div>

</body>
<?php ob_end_flush(); ?>
</html>