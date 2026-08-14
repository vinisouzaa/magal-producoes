<?php
session_start();
include_once("check-sess.php"); 
?>
<div id="pags">
<?php

$etapa = addslashes(strip_tags(trim($_GET['etapa'])));
$pg    = addslashes(strip_tags(trim($_GET['pg'])));
$id    = addslashes(strip_tags(trim($_GET['id'])));

if ($etapa == ''){

	$etapa = "etapa1";

}

if($etapa == 'etapa1'){
	
  $sql = 'SELECT * FROM configuracoes ORDER BY id DESC LIMIT 1';
  
  try{
  $query = $con->prepare($sql);
  $query->execute();
  $res   = $query->fetchAll(PDO::FETCH_ASSOC);
    
  }catch (PDOexception $errorSelect){
  echo 'Erro ao selecionar '.$errorSelect->getMessage();
  }
  foreach($res as $dados){
	  
  }

?>

<table border="0" id="tabela" data-corner="top 8px">

  <tr>
    <td align="center" class="td_titulo">
      <span class="titulo1">Configurações do Site</span>
    </td>
  </tr>
  
</table>

<form action="?pg=<?php echo $pg; ?>&etapa=etapa2&id=<?php echo $dados['id']; ?>" method="post">
<table width="42%" border="0" id="tabela2">
  <tr>
    <td height="47" align="center" class="td_topico">Título do site</td>
    <td align="left" class="td_input">
      <input type="text" name="tituloSite" value="<?php echo $dados['titulo_site']; ?>" class="input" />
    </td>
  </tr>
  <tr>
    <td width="23%" height="47" align="center" class="td_topico">Descrição do site::</td>
    <td width="77%" align="left" class="td_input">
      <input type="text" name="descricao" value="<?php echo $dados['descricao']; ?>" class="input" />
    </td>
  </tr>
  <tr>
    <td height="47" align="center" class="td_topico">Palavras Chave:</td>
    <td align="left" class="td_input">
      <input type="text" name="palavras" value="<?php echo $dados['palavras_chave']; ?>" class="input" />
    </td>
  </tr>
  <tr>
    <td height="45" align="center" class="td_topico">Endereço do Site:</td>
    <td align="left" class="td_input">
      <input type="text" name="url" value="<?php echo $dados['url']; ?>" class="input" />
    </td>
  </tr>
  <tr>
    <td height="47" align="center" class="td_topico">Copyright:</td>
    <td align="left" class="td_input">
      <textarea name="copy" class="textarea" style="height:120px;"><?php echo $dados['copyright']; ?></textarea>
    </td>
  </tr>
  <tr>
    <td height="47" align="center" class="td_topico">E-mail:</td>
    <td align="left" class="td_input">
      <input type="text" name="email_contato" value="<?php echo $dados['email_contato']; ?>" class="input" />
    </td>
  </tr>
  <tr>
    <td height="52" align="center" class="td_topico">Senha do E-mail:</td>
    <td align="left" class="td_input">
      <input type="password" name="senha" value="<?php echo $dados['code_email_contato']; ?>" class="input" />
    </td>
  </tr>
  <tr>
    <td height="49" align="center" class="td_topico">Servidor do E-mail:</td>
    <td align="left" class="td_input">
      <input type="text" name="servidorMail" value="<?php echo $dados['servidor_email']; ?>" class="input" />
    </td>
  </tr>
  <tr>
    <td height="51" align="center" class="td_topico">Porta:</td>
    <td align="left" class="td_input">
      <input type="text" name="porta" value="<?php echo $dados['porta_email']; ?>" class="input" />
    </td>
  </tr>
  <tr>
    <td height="47" align="center" class="td_topico">E-mail p/ Receber:</td>
    <td align="left" class="td_input">
      <input type="text" name="emailRecebe" value="<?php echo $dados['email_recebe']; ?>" class="input" />
    </td>
  </tr>
  <tr>
    <td height="47" align="center" class="td_topico">Endereço:</td>
    <td align="left" class="td_input">
      <textarea class="textarea" name="endereco"><?php echo $dados['endereco']; ?></textarea>
    </td>
  </tr>
  <tr>
    <td height="47" align="center" class="td_topico">Telefone:</td>
    <td align="left" class="td_input">
      <input type="text" name="telefone" value="<?php echo $dados['telefone']; ?>" class="input" />
    </td>
  </tr>
  <tr>
    <td height="47" align="center" class="td_topico">Texdo do contato:</td>
    <td align="left" class="td_input">
      <textarea class="textarea" name="textoContato"><?php echo $dados['texto_contato']; ?></textarea>
    </td>
  </tr>
  <tr>
    <td height="62" align="center" class="td_topico">&nbsp;</td>
    <td align="left" class="td_input">
      <input type="submit" value="Aplicar" class="btn" />
      </td>
  </tr>
  
</table>
</form>

<?php

}
if($etapa =='etapa2'){

$tituloSite    = addslashes(strip_tags($_POST['tituloSite']));
$descricao     = addslashes(strip_tags($_POST['descricao']));
$palavras      = addslashes(strip_tags($_POST['palavras']));
$url           = addslashes(strip_tags($_POST['url']));
$copy          = $_POST['copy'];
$emailContato  = $_POST['email_contato'];
$code          = addslashes(strip_tags($_POST['senha']));
$senha         = md5($code);
$servidorMail  = addslashes(strip_tags($_POST['servidorMail']));
$porta         = addslashes(strip_tags($_POST['porta']));	
$emailRecebe   = $_POST['emailRecebe'];
$endereco      = $_POST['endereco'];
$telefone      = $_POST['telefone'];
$textoContato  = $_POST['textoContato'];


$sql  = 'UPDATE configuracoes SET titulo_site = :tituloSite, descricao = :descricao, palavras_chave = :palavras, url = :url, copyright = :copy, email_contato = :emailContato, ';
$sql .= 'senha_email_contato = :senha, code_email_contato = :code, email_recebe = :emailRecebe, servidor_email = :servidorMail, porta_email = :porta, endereco = :endereco, ';
$sql .= 'telefone = :telefone, texto_contato = :textoContato WHERE id = :id';
  try{
  $query = $con->prepare($sql);
  $query->bindValue(':tituloSite',$tituloSite,PDO::PARAM_STR);
  $query->bindValue(':descricao',$descricao,PDO::PARAM_STR);
  $query->bindValue(':palavras',$palavras,PDO::PARAM_STR);
  $query->bindValue(':url',$url,PDO::PARAM_STR);
  $query->bindValue(':copy',$copy,PDO::PARAM_STR);
  $query->bindValue(':emailContato',$emailContato,PDO::PARAM_STR);
  $query->bindValue(':senha',$senha,PDO::PARAM_STR);
  $query->bindValue(':code',$code,PDO::PARAM_STR);
  $query->bindValue(':emailRecebe',$emailRecebe,PDO::PARAM_STR);
  $query->bindValue(':servidorMail',$servidorMail,PDO::PARAM_STR);
  $query->bindValue(':porta',$porta,PDO::PARAM_STR);
  $query->bindValue(':endereco',$endereco,PDO::PARAM_STR);
  $query->bindValue(':telefone',$telefone,PDO::PARAM_STR);
  $query->bindValue(':textoContato',$textoContato,PDO::PARAM_STR);
  $query->bindValue(':id',$id,PDO::PARAM_STR);
  $query->execute();
  
  echo "<div class='msg certo'><span>Configurações alteradas com sucesso!</span></div>";
  echo '<div class="voltar"><a href="?pg=principal" title="Voltar"></a></div>';
  
  
  }catch (PDOexception $errorSelect){
   echo "<div class='msg erro'><span>Erro ao Atualizar configurações.</span></div> <br /><br />Código do erro:  ".$errorSelect->getMessage();
  }


}

?>


</div>
