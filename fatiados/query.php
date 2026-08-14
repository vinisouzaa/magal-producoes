
<?php 

$pg  = addslashes(strip_tags(trim($_GET['pg'])));

foreach ($_REQUEST as $___opt => $___val) {
  $$___opt = $___val;
}

	if(empty($pg)) {
		
		include("pags/principal.php");
		
	}elseif(substr($pg, 0, 4)=='http' or substr($pg,0, 1)=="/" or substr($pg, 0, 1)=="." or substr($pg, 0, 3)=="www") {
        
		echo '<div id="ops">
			  	<span class="oops">OopS!</span><span class="txt">A página não existe. Por favor selecione uma página a partir do Menu Principal.</span>
			  </div>';
		
	}elseif(!is_file("pags/$pg.php")){
		
		echo '<div id="ops">
			  	<span class="oops">OopS!</span><span class="txt">A página não existe. Por favor selecione uma página a partir do Menu Principal.</span>
			  </div>';
		   
	}else {
		
		include("pags/$pg.php");

	}

?>
