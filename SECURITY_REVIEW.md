# Revisão de segurança necessária

Esta é uma aplicação PHP legada e deve passar por revisão antes de voltar à produção.

## Arquivo isolado

`css/fontes/config.php` foi excluído da cópia preparada. O arquivo estava em uma pasta de fontes e continha rotinas de conexão de rede incompatíveis com a finalidade esperada desse diretório.

O arquivo original permanece preservado no backup recebido e não foi alterado.

## Componentes antigos

O projeto contém versões antigas de TimThumb, PHPMailer, TinyMCE e scripts JavaScript. Esses componentes devem ser atualizados ou substituídos antes de uma nova publicação pública.

