/**************************************************************************************
*************** CHAMADA JQUERY CYCLE
***************************************************************************************/
$(document).ready(function() {
	$.fn.cycle.defaults.timeout = 600;
	$('.backgrounds').cycle({ 
		 fx:     'turnLeft', 
		 speed: 2000,
		 easing: 'easeOutExpo',
		 timeout: 350,
		 pager: '.pgCicle'
	});	
});
/**************************************************************************************
*************** SELECIONANDO OBJETOS PARA FORMATAÇÃO CSS
***************************************************************************************/

$(document).ready(function(){
	
	$(".servicos-front li:eq(3)").css("margin-right", "0");
	$(".estudios-front li:eq(2)").css("margin-right", "0");
	$(".portifolio-front li:eq(3)").css("margin-right", "0");
	$(".portifolio-front li:eq(7)").css("margin-right", "0");
	
	$(".box-clientes-pg a[href='#']").css("cursor","auto");
	$(".box-clientes .itens a").click(function(){
		return false;	
	});
	
});
/**************************************************************************************
*************** EFEITO DO MENU
***************************************************************************************/

$(document).ready(function(){
	
	$(".nav a").hover(function(){
		
		//hover
			
	},function(){
		//normal
	
	});
});


/**************************************************************************************
*************** EFEITO UL PADRÃO
***************************************************************************************/
$(document).ready(function() {
	
	$(".ul-padrao a").hover(function(){
		
		$(this).find(".imagem-oculta").fadeIn("600");
		
	},function(){
		
		$(this).find(".imagem-oculta").fadeOut("600");	
		
	});
});

$(".servicos-front .box-icone").corner("100px");

/**************************************************************************************
*************** PLUGIN OWL | PARCEIROS
***************************************************************************************/

$(document).ready(function() {
  
  $(".parceiros").owlCarousel({
	autoPlay: 3000, //Set AutoPlay to 3 seconds
	items : 3
  });
  
});

/**************************************************************************************
*************** CHAMADA JQUERY LIGHTBOX
***************************************************************************************/
$(document).ready(function(){
  $(".lightbox").lightbox(); 
});


/**************************************************************************************
*************** CHAMADA JQUERY TOOLTIPSTER
***************************************************************************************/

$(document).ready(function(){
	
	$('.tooltip').tooltipster({
		animation: 'fade',
		theme: 'tooltipster-noir',
		delay: 1
	});
	
	$('.tooltip-width').tooltipster({
		animation: 'fade',
		theme: 'tooltipster-noir',
		delay: 1,
		maxWidth: 160
	});
	
});



/**************************************************************************************
*************** FUNÇÃO EFEITO DOS INPUTS
***************************************************************************************/
function inputEfeito(nome,valor,corFoco,corPerdeFoco,sizeFoco,sizePerdeFoco){
	   $(nome).focus(function(){
			   if($(this).val() == valor){
					  $(this).val("");
					  $(this).css("color",corFoco);
					  $(this).animate({width:sizeFoco});
			   }
		});
	   $(nome).focus(function(){
			   if($(this).val() != valor){
					  $(this).css("color",corFoco);
					  $(this).animate({width:sizeFoco});
			   }
		});
	   $(nome).blur(function(){
			   if($(this).val() == ""){
					  $(this).val(valor);
					  $(this).css("color",corPerdeFoco);
					  $(this).animate({width:sizePerdeFoco});
			   }
			   if($(this).val() != ""){
					  $(this).css("color",corPerdeFoco);
					  $(this).animate({width:sizePerdeFoco});
			   }
		});
}

$(function(){
	inputEfeito(".form input[name='nome']","Nome","#444","#999","100%","100%");
	inputEfeito(".form input[name='email']","Email","#444","#999","100%","100%");
	inputEfeito(".form input[name='telefone']","Telefone","#444","#999","107%","107%");
	inputEfeito(".form input[name='celular']","Celular","#444","#999","107%","107%");
	inputEfeito(".form input[name='cidade']","Cidade","#444","#999","107%","107%");
	inputEfeito(".form input[name='estado']","Estado","#444","#999","107%","107%");
	inputEfeito(".form textarea[name='mensagem']","Conte-nos o que você está precisando","#444","#999","94.5%","94.5%");
	inputEfeito(".form textarea[name='obs']","Observações","#444","#999","94.5%","94.5%");
	inputEfeito(".form-search input[name='pesquisa']","O que você procura?","#444","#999","280px","280px");
});

$(document).ready(function(){
	$( ".form form" ).submit(function(){
		
		if ( $(".form input[name='nome']").val() === "Nome" ) {
		  $(".form input[name='nome']").val("");
		}
		
		if ( $(".form input[name='email']").val() === "Email" ) {
		  $(".form input[name='email']").val("");
		}
		
		if ( $(".form input[name='telefone']").val() === "Telefone" ) {
		  $(".form input[name='telefone']").val("");
		}
		
		if ( $(".form input[name='celular']").val() === "Celular" ) {
		  $(".form input[name='celular']").val("");
		}
		
		if ( $(".form input[name='cidade']").val() === "Cidade" ) {
		  $(".form input[name='cidade']").val("");
		}
		
		if ( $(".form input[name='estado']").val() === "Estado" ) {
		  $(".form input[name='estado']").val("");
		}
		
		if ( $(".form textarea[name='mensagem']").val() === "Conte-nos o que você está precisando" ) {
		  $(".form textarea[name='mensagem']").val("");
		}
		
		if ( $(".form textarea[name='obs']").val() === "Observações" ) {
		  $(".form textarea[name='obs']").val("");
		}
		
		if ( $(".form-search input[name='pesquisa']").val() === "O que você procura?" ) {
		  $(".form-search input[name='pesquisa']").val("");
		}
	  
	});
});