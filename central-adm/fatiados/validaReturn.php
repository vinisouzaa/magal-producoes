<?php


function valida_email($endereco){

  $pattern = "^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-]+\.[a-zA-Z0-9\-\.]+$";

 
  if (eregi($pattern, $endereco)){

	 return true;
  }
  else {
	 return false;
  }   
}



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



function validaCPF($cpf)
{	// Verifiva se o número digitado contém todos os digitos
    $cpf = str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);
	
	// Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
	{
	return false;
    }
	else
	{   // Calcula os números para verificar se o CPF é verdadeiro
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf{$c} != $d) {
                return false;
            }
        }

        return true;
    }
}


function validaCNPJ($cnpj) {
if (strlen($cnpj) <> 18) return 0;
  $soma1 = ($cnpj[0] * 5) +
   
  ($cnpj[1] * 4) +
  ($cnpj[3] * 3) +
  ($cnpj[4] * 2) +
  ($cnpj[5] * 9) +
  ($cnpj[7] * 8) +
  ($cnpj[8] * 7) +
  ($cnpj[9] * 6) +
  ($cnpj[11] * 5) +
  ($cnpj[12] * 4) +
  ($cnpj[13] * 3) +
  ($cnpj[14] * 2);
  $resto = $soma1 % 11;
  $digito1 = $resto < 2 ? 0 : 11 - $resto;
  $soma2 = ($cnpj[0] * 6) +
   
  ($cnpj[1] * 5) +
  ($cnpj[3] * 4) +
  ($cnpj[4] * 3) +
  ($cnpj[5] * 2) +
  ($cnpj[7] * 9) +
  ($cnpj[8] * 8) +
  ($cnpj[9] * 7) +
  ($cnpj[11] * 6) +
  ($cnpj[12] * 5) +
  ($cnpj[13] * 4) +
  ($cnpj[14] * 3) +
  ($cnpj[16] * 2);
  $resto = $soma2 % 11;
  $digito2 = $resto < 2 ? 0 : 11 - $resto;
  return (($cnpj[16] == $digito1) && ($cnpj[17] == $digito2));
} 

?>