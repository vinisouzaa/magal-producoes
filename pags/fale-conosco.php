<div class="pags">



  <div class="box-titulo">

    <span class="titulo2">Fale Conosco</span>

    <span class="texto1 align-left"><?php echo $conf['texto_contato']; ?></span>

  </div>



<span class="foneP"><?php echo $conf['telefone']; ?></span>

  

<?php



$etapa = addslashes(strip_tags(trim($_GET['etapa'])));

$pg    = addslashes(strip_tags(trim($_GET['pg'])));



if ($etapa == ''){

	$etapa = "etapa1";

}



if($etapa == 'etapa1'){





?>



    <div class="contato contato-pg form">

    

      <form name="sendContato" action="<?php echo $urlBase;?>/fale-conosco&etapa=etapa2" method="post">

      

        <label class="label">

          <input class="input" name="nome" value="Nome" />

        </label>

        <label class="label">

          <input class="input" name="email" value="Email" />

        </label>

        <label class="label2">

          <input class="input2" name="telefone" value="Telefone" />

        </label>

        <label class="label2">

          <input class="input2" name="celular" value="Celular" />

        </label>   

        <label class="label2">

          <input class="input2" name="cidade" value="Cidade" />

        </label>

        <label class="label2">

          <input class="input2" name="estado" value="Estado" />

        </label>

        <label>

          <textarea name="mensagem" class="textarea">Conte-nos o que você está precisando</textarea>

        </label> 
        
        <label class="label2">

          <input class="input2" name="captcha_txt" placeholder="Digite o texto da imagem" />

        </label>
        
        <label class="label2">

        
         <img id="captcha" src="fatiados/captcha/securimage_show.php" alt="" class="captcha" />
         <a tabindex="-1" href="#" title="Atualizar imagem" class="tooltip" onclick="document.getElementById('captcha').src = 'fatiados/captcha/securimage_show.php?sid=' + Math.random(); this.blur(); return false">
          <img src="fatiados/captcha/refresh.png" alt="Atualizar imagem" onclick="this.blur()" class="refresh">
         </a>

        </label>   

        <label>

          <input type="submit" name="SbSend" value="ENVIAR" class="submit" />

        </label> 

      </form>

    

    </div>

    <!-- Contato --> 

<?php



}elseif($etapa =='etapa2'){





// RECEBENDO AS VARIÁVEIS

$nome       = addslashes(strip_tags(trim($_POST['nome'])));

$email      = addslashes(strip_tags(trim($_POST['email'])));

$fone       = addslashes(strip_tags(trim($_POST['telefone'])));

$celular    = addslashes(strip_tags(trim($_POST['celular'])));

$cidade     = addslashes(strip_tags(trim($_POST['cidade'])));

$estado     = addslashes(strip_tags(trim($_POST['estado'])));

$msgCliente = addslashes(strip_tags(trim($_POST['mensagem'])));

$codeCaptcha = addslashes(strip_tags(trim($_POST['captcha_txt'])));

$assunto    = 'Mensgem do site Magal Produções';





$valNome = verificaCampos($nome, 4, 'Nome');

if($valNome['condicao'] == 'falso'){

	echo'

	<div class="msg erro">

	  Erro!

	  <span>'.$valNome['erro'].'</span>

	</div>

	<div class="voltar"><a class="vt-princpal at" href="javascript:history.back()" title="Voltar">VOLTAR</a></div>

	';

	echo '</div>';

	return false;

}



// VALIDANDO OS CAMPOS

$valEmail = valida_email($email);

if($valEmail == false){

	echo'

	<div class="msg erro">

	  Erro!

	  <span>E-mail inválido!</span>

	</div>

	<div class="voltar"><a class="vt-princpal at" href="javascript:history.back()" title="Voltar">VOLTAR</a></div>

	';

	echo '</div>';

	return false;

}



// VERIFICANDO SE PELO MENOS UM TELEFONE FOI PREENCHIDO

if($fone == '' && $celular == ''){

	echo'

	<div class="msg erro">

	  <span>Por favor, preencha pelo menos um telefone!</span>

	</div>

	<div class="voltar"><a class="vt-princpal at" href="javascript:history.back()" title="Voltar">VOLTAR</a></div>

	';

	echo '</div>';

	return false;	

}



// VALIDANDO A CIDADE

$valCidade = verificaCampos($cidade, '', 'Cidade');

if($valCidade['condicao'] == 'falso'){

	echo'

	<div class="msg erro">

	  Erro!

	  <span>'.$valCidade['erro'].'</span>

	</div>

	<div class="voltar"><a class="vt-princpal at" href="javascript:history.back()" title="Voltar">VOLTAR</a></div>

	';

	echo '</div>';

	return false;

}



// VALIDANDO O ESTADO

$valEstado = verificaCampos($estado, '', 'Estado');

if($valEstado['condicao'] == 'falso'){

	echo'

	<div class="msg erro">

	  Erro!

	  <span>'.$valEstado['erro'].'</span>

	</div>

	<div class="voltar"><a class="vt-princpal at" href="javascript:history.back()" title="Voltar">VOLTAR</a></div>

	';

	echo '</div>';

	return false;

}



$valMsg = verificaCampos($msgCliente, '', 'Mensagem');

if($valMsg['condicao'] == 'falso'){

	echo'

	<div class="msg erro">

	  Erro!

	  <span>'.$valMsg['erro'].'</span>

	</div>

	<div class="voltar"><a class="vt-princpal at" href="javascript:history.back()" title="Voltar">VOLTAR</a></div>

	';

	echo '</div>';

	return false;

}

require_once 'fatiados/captcha/securimage.php';
$securimage    = new Securimage();
if(!$securimage->check($codeCaptcha)) {
	echo'

	<div class="msg erro">
	  Erro!
	  <span>O código da imagem está incorreto, por favor preencha novamente.</span>
	</div>
	<div class="voltar"><a class="vt-princpal at" href="javascript:history.back()" title="Voltar">VOLTAR</a></div>
	';
	echo '</div>';
	return false;
}


$mensagem = '

<div style="width:94%; padding:3%; display:inline-block; background:#f6f6f6;"><h1 style="font:22px Trebuchet MS; color:#09c; letter-spacing:-1px; font-weight:bold; margin:0px 0 30px 00px;">Olá,  Esta é uma mensagem enviada por: '.$nome.'</h1>

<span style="font:16px Trebuchet MS; color:#555; letter-spacing:-1px;">DADOS DO ENVIO:<br/><br />Email: '.$email.'<br />Telefone: '.$fone.'<br />Celular: '.$celular.'<br />Cidade: '.$cidade.'<br />Estado: '.$estado.'</span></div><div style="width:94%; padding:3%; display:inline-block; background:#eee;"><span style="color:#111; font:20px Trebuchet MS; font-variant:small-caps;">Mensagem: <br /><br /></span><span style="font:16px Trebuchet MS; color:#555; letter-spacing:-1px;">'.$msgCliente.'</span></div><div style="width:96%; padding:2%; display:inline-block; background:#09c; color:#fff;"><span style="font:16px Trebuchet MS; color:#fff; letter-spacing:-1px;">Atenciosamente,</span> <a href="'.$conf['site'].'" target="_blank" style="color:#FFF; font-weight:bold; text-decoration:none; font:16px Trebuchet MS;">'.$conf['site'].'</a><br/><span style="font:16px Trebuchet MS; color:#fff; letter-spacing:-1px;">Data de envio: '.date('d/m/Y H:i:s').'</span></div>

';



sendMail($assunto,$mensagem,$conf['email_contato'],$conf['titulo'],$conf['email_recebe'],$conf['titulo']);

	 echo '<div class="msg certo">Mensagem enviada com sucesso!<span> Em breve responderemos!</span></div>';

	 echo '<div class="voltar"><a class="vt-princpal at" href="index.php" title="Voltar">VOLTAR</a></div>';









}

?>
</div>
