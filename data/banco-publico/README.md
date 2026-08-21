# Banco público sanitizado

Esta pasta contém uma cópia importável e legível do banco original
`vsmktcombr_magal`, extraído do backup de 20/08/2026.

## Incluído com dados

- `banners`: 11 registros;
- `categorias`: 5 registros;
- `paginas`: 2 registros;
- `parceiros`: 15 registros;
- `radios`: 99 registros.

A estrutura da tabela `posts` está em `00-schema.sql`, mas seus 405 registros
brutos não foram versionados. Galerias e depoimentos antigos contêm nomes de
pessoas e outras informações sensíveis. Os dados públicos necessários de
artistas e Serviços foram extraídos para `../artistas.csv` e `../servicos.md`.

## Removido por segurança

- tabela `usuarios` completa;
- tabela `configuracoes` completa;
- dados brutos da tabela `posts`;
- logins, senhas, códigos e configurações privadas de e-mail.

## Importação

1. Importe primeiro `00-schema.sql`.
2. Importe os demais arquivos `.sql` em ordem alfabética.

Os arquivos preservam a codificação e a estrutura legada do MySQL para permitir
uma restauração fiel. Eles foram divididos por tabela para manter o conteúdo
auditável no GitHub. Os CSVs no diretório `data` estão normalizados em UTF-8
para consulta humana e uso em uma reconstrução moderna.
