# Conteúdo recuperado sem o banco de dados

Este diretório reúne o conteúdo que foi possível reconstruir a partir dos
arquivos do backup, de materiais do próprio responsável pelo site e de fontes
públicas.

## Arquivos

- `artistas.csv`: nomes e endereços antigos das páginas de artistas.
- `servicos.md`: texto integral da página institucional de Serviços.
- `radios.csv`: relação de rádios, cidades e frequências.

## Origem dos dados

- Os artistas foram recuperados de `rss.xml` e `sitemap.xml`, presentes no
  backup do site.
- O texto de Serviços foi recuperado da página institucional ainda acessível
  em `https://www.magalproducoes.com.br/institucional/servicos`.
- Os nomes e as cidades das rádios vieram da relação enviada em 14/08/2024,
  nos arquivos “Relação-Radios_MT - Magal 2.pdf” e
  “Relação-Radios_MT - Leo - Magal.pdf”.
- As frequências não constavam nos PDFs nem no backup. Elas foram reconstruídas
  por pesquisa pública em 17/08/2026.

## Atenção sobre as frequências

Rádios podem trocar de frequência, nome ou rede. A coluna `status` distingue:

- `confirmada`: frequência encontrada em fonte recente ou na própria emissora;
- `historica`: corresponde à marca da relação, mas a rádio mudou de nome ou
  frequência depois;
- `a_confirmar`: houve conflito entre fontes ou não foi possível confirmar uma
  frequência terrestre.

Assim, `radios.csv` serve como base de reconstrução, mas as linhas marcadas
`a_confirmar` devem ser validadas antes da publicação definitiva.
