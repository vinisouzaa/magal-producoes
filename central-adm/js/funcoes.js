/* Data Picker */
$(document).ready(function(){
$(".datepicker").datepicker({

    dateFormat: 'yy-mm-dd',
    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'
        ],

    dayNamesMin: [
    'Dom','Seg','Ter','Qua','Qui','Sex','Sab','Dom'
    ],

    dayNamesShort: [
    'Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'
    ],
	
    monthNames: [  'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro',
    'Outubro','Novembro','Dezembro'
    ],

    monthNamesShort: [
    'Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set',
    'Out','Nov','Dez'
    ],

    nextText: 'Próximo',
    prevText: 'Anterior',
	changeMonth: true, // permite a seleção de meses
	changeYear: true, // permite a seleção de anos
	yearRange: "-80:+10" // Range dos anos: vai de -x até +y anos
    });

});

$(document).ready(function(){
    $(".menu ul li").hover(function(){
        $(this).children("ul").css("display","block")
    }, function(){
        $(this).children("ul").css("display","none")
    })
})


/* Função para mostrar os Tamnahos dos produtos -----------------------------------------------------------------------*/
$(document).ready(function(){
        $("#pags #sim").hide();

        $("input[name='rd-tam']").click(function(){
                $("#pags #sim").hide();
                $( '#'+$( this ).val() ).show('slow');
        });
});
/* Função para mostrar os Tamnahos dos produtos -----------------------------------------------------------------------*/



/* Validação do Login */
$(function(){
  $('#logar').click(
	function(){
		$('#mensagens').slideUp('fast');
		
		if( $('#valEmail').val() == ''){
			$('#mensagens').html('E-mail Inválido!').slideDown('fast');
			return false;
			
		}else if( $('#valSenha').val() == '' ){
			$('#mensagens').html('Senha Inválida!').slideDown('fast');
			return false;
		}
	  }
	);	
  }
);

/* Função Tooltip */
$(function(){
  $(".logo-la").tipTip();
  $(".sair").tipTip();
  $("#tabela2 a").tipTip();
  $("#tipTip").tipTip();
  $(".tipTip").tipTip();
});  

/* Funções para o jQuery Corner */
$(".sair").corner("8px");    
$("#tabela").corner();  
$(".btn").corner("8px");   


/* jQuery Lightbox Evolution */
$(document).ready(function(){
  $('#box-fotos .foto').lightbox();
  $('.lightbox').lightbox();
});





