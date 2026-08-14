<?php 
ob_start();
session_start();

include_once("nomeSession.php");
include_once("../Connections/config.php");
include_once("check-sess.php");
include_once("fatiados/calendario.php");
include_once("fatiados/funcoes.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <!-- Arquivos CSS -->
  <link href="css/estilo_adm.css" type="text/css" rel="stylesheet" media="screen" />
  <link href="css/ui-lightness/jquery-ui-1.8.22.custom.css" rel="stylesheet" type="text/css" />
  <link href="js/tooltip/tipTip.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" href="js/evo/themes/white-green/jquery.lightbox.css" />
  <!--[if IE 6]>
  <link rel="stylesheet" type="text/css" href="js/evo/themes/white-green/jquery.lightbox.ie6.css" />
  <![endif]-->
  
  <!-- Arquivos JS -->
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui-1.8.22.custom.min.js"></script>
  <script type="text/javascript" src="js/evo/jquery.lightbox.min.js"></script>
  <script type="text/javascript" src="js/tooltip/jquery.tipTip.minified.js"></script>
  <script type="text/javascript" src="js/corner.js"></script>
  
<script type="text/javascript" src="js/funcoes.js"></script>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  
  <title>Administração <?php echo $conf['titulo_site']; ?></title>
  
<style type="text/css">
body,td,th {
	font-family: yanone;
}
</style>
</head>

<body style="background:#E8E8E8;">

<!------------------------------------------------------------------------------------ Header -------------------------------------------------------------------------------------------------->
<div id="header">
  
  <div id="center"><!-- Center -->

    <a class="logo" href="home.php" title="Voltar para a Página Inicial">
      <img src="images/logo_adm.png" border="0" />
    </a>
    
    <!-- Caixa 1 -->
    <div class="caixa1">
    
      <span class="usuario"><?php $nome = explode(' ',$_SESSION[NOMESESSION]['nome']); echo $nome[0]; ?>, seja bem vindo!</span>
      
      <span class="data"><?php echo $semana.', '.$dia.' de '.$mes.' de '.$ano; ?></span>
      
    </div>
    <!-- Caixa 1 -->
    
    <!-- Caixa 2 -->
    <div class="caixa2">
    
      <span class="titulo-home"></span>
      
      <a href="deslogar.php" title="Sair do Painel de Controle" class="sair">Sair</a>
      <a href="<?php echo $conf['site']; ?>" target="_blank" title="Ver o site" class="sair">Ir para o site</a>
    
    </div>
    <!-- Caixa 2 -->
  
  </div><!-- Center -->

</div>
<!------------------------------------------------------------------------------------ Header -------------------------------------------------------------------------------------------------->

<div class="clear"></div><!-- Clear -->

<!------------------------------------------------------------------------------------ Geral -------------------------------------------------------------------------------------------------->
<div id="geral">

  <div class="menu">
  
    <ul>
      <li><a href="?pg=principal" title="">PÁGINA INICIAL</a></li>
      
      <?php if(checkNivel('1')){ ?>
      <li><a href="#" title="">USUÁRIOS <img src="images/seta-submenu.png" class="seta" /></a>
        <ul>
          <li><a href="?pg=listar-usuarios">Listar Usuários</a></li>
          <li><a href="?pg=cadastrar-usuario">Cadastrar Usuários</a></li>
        </ul>
      </li>
      <?php } ?>
      
      <li><a href="#" title="">BANNERS <img src="images/seta-submenu.png" class="seta" /></a>
        <ul>
          <li><a href="?pg=listar-banners">Listar Banners</a></li>
          <li><a href="?pg=cadastrar-banner">Cadastrar Banner</a></li>
        </ul>
      </li> 
                  
      <li><a href="#" title="">INSTITUCIONAL <img src="images/seta-submenu.png" class="seta" /></a>
        <ul>
		<?php
        $sqlSobre = 'SELECT * FROM paginas WHERE categoria = "sobre-nos"';
          try{
          $querySobre = $con->prepare($sqlSobre);
          $querySobre->execute();
          $resQuerySobre = $querySobre->fetchAll(PDO::FETCH_ASSOC);
          }catch (PDOexception $errorSelectSobre){}   
          foreach($resQuerySobre as $dadosSobre){
        ?>
          <li><a href="?pg=paginas&id=<?php echo $dadosSobre['id']; ?>"><?php echo $dadosSobre['titulo']; ?></a></li>
        <?php } ?>
        </ul>
      </li>
      
      <li><a href="#" title="">SERVIÇOS <img src="images/seta-submenu.png" class="seta" /></a>
        <ul>
		<?php
        $sqlSobre = 'SELECT * FROM paginas WHERE categoria = "servicos"';
          try{
          $querySobre = $con->prepare($sqlSobre);
          $querySobre->execute();
          $resQuerySobre = $querySobre->fetchAll(PDO::FETCH_ASSOC);
          }catch (PDOexception $errorSelectSobre){}   
          foreach($resQuerySobre as $dadosSobre){
        ?>
          <li><a href="?pg=paginas&id=<?php echo $dadosSobre['id']; ?>"><?php echo $dadosSobre['titulo']; ?></a></li>
        <?php } ?>
        </ul>
      </li>
      
      <li><a href="#" title="">ARTISTAS <img src="images/seta-submenu.png" class="seta" /></a>
        <ul>
          <li><a href="?pg=listar-itens-cat&cat=artistas">Listar Artistas</a></li>
          <li><a href="?pg=cadastrar-item-cat&cat=artistas">Cadastrar Artista</a></li>
        </ul>
      </li>
      
      <li><a href="#" title="">GALERIA DE FOTOS <img src="images/seta-submenu.png" class="seta" /></a>
        <ul>
          <li><a href="?pg=listar-itens-cat&cat=galeria">Listar Galerias</a></li>
          <li><a href="?pg=cadastrar-item-cat&cat=galeria">Cadastrar Galeria</a></li>
        </ul>
      </li>
      
      <li><a href="#" title="">VÍDEOS <img src="images/seta-submenu.png" class="seta" /></a>
        <ul>
          <li><a href="?pg=listar-itens-cat&cat=videos">Listar Vídeos</a></li>
          <li><a href="?pg=cadastrar-item-cat&cat=videos">Cadastrar Vídeo</a></li>
        </ul>
      </li>
      
      <li><a href="#" title="">DEPOIMENTOS <img src="images/seta-submenu.png" class="seta" /></a>
        <ul>
          <li><a href="?pg=listar-itens-cat&cat=depoimentos">Listar Depoimentos</a></li>
          <li><a href="?pg=cadastrar-item-cat&cat=depoimentos">Cadastrar Depoimento</a></li>
        </ul>
      </li>
      
      <li><a href="#" title="">PARCEIROS <img src="images/seta-submenu.png" class="seta" /></a>
        <ul>
          <li><a href="?pg=listar-parceiros">Listar Parceiros</a></li>
          <li><a href="?pg=cadastrar-parceiro">Cadastrar Parceiro</a></li>
        </ul>
      </li>
      
      <li><a href="#" title="">RÁDIOS <img src="images/seta-submenu.png" class="seta" /></a>
        <ul>
          <li><a href="?pg=listar-radios">Listar Rádios</a></li>
          <li><a href="?pg=cadastrar-radio">Cadastrar Rádio</a></li>
        </ul>
      </li>
      
      <li><a href="#" title="">CATEGORIAS <img src="images/seta-submenu.png" class="seta" /></a>
        <ul>
          <li><a href="?pg=listar-categorias">Listar categorias</a></li>
        </ul>
      </li>
                      
      <li><a href="?pg=configuracoes" title="">CONFIGURAÇÕES</a></li>
      
    </ul>
      
    </ul>
  
  </div>
  
  <?php include_once("fatiados/query.php"); ?>
  
  <div class="clear"></div><!-- Clear -->

</div>
<!------------------------------------------------------------------------------------ Geral --------------------------------------------------------------------------------------------------> 


<!------------------------------------------------------------------------------------ Rodapé -------------------------------------------------------------------------------------------------> 

<div id="rodape">

  <div class="center">
  
    <!--<a href="http://www.playlan.com.br" title="" target="_blank" class="logo-la"></a>-->
    <span class="copy">© Desenvolvido por Playlan Agência Web. Todos os direitos reservados.</span>
  
  </div>

</div>

<!------------------------------------------------------------------------------------ Rodapé ------------------------------------------------------------------------------------------------->


</body>
<?php ob_end_flush(); ?>
</html>