# Conteúdo recuperado do banco original

Este diretório reúne o conteúdo público recuperado do banco
`vsmktcombr_magal`, extraído do backup de 20/08/2026.

## Arquivos principais

- `artistas.csv`: 8 artistas, páginas e caminhos exatos das imagens;
- `servicos.md`: texto integral da página de Serviços;
- `radios.csv`: 99 rádios com nome, cidade, frequência, site e imagem;
- `radios-pesquisa-2026.csv`: relação reconstruída anteriormente por pesquisa
  pública, preservada para comparação histórica;
- `banco-publico/*.sql`: estrutura MySQL e dados públicos seguros de banners,
  categorias, páginas, parceiros e rádios.

## Segurança

As tabelas administrativas `usuarios` e `configuracoes` foram excluídas da
cópia publicada porque continham logins, senhas, códigos e configurações
privadas de e-mail. Os 405 registros brutos de `posts` também não foram
versionados porque galerias e depoimentos antigos contêm dados pessoais e
informações sensíveis. Os dados públicos necessários de artistas e Serviços
estão disponíveis nos arquivos próprios deste diretório.

## Conferência dos arquivos

- imagens dos artistas encontradas no repositório: 8 de 8;
- imagens das rádios encontradas no repositório: 99 de 99;
- mídias vinculadas às publicações encontradas: 268 de 274;
- seis imagens ausentes pertencem somente a galerias antigas.
