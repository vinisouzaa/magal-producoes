# Magal Produções

Migração do site legado hospedado no cPanel para controle de versão no GitHub.

## Configuração

1. Copie `Connections/config.example.php` para `Connections/config.php`.
2. Configure `DB_HOST`, `DB_NAME`, `DB_USER` e `DB_PASSWORD` no ambiente do servidor.
3. Não versione `Connections/config.php`.

## Observações da migração

- O diretório de cache e os arquivos de validação temporários não foram versionados.
- `info.php` não foi versionado porque expõe informações do servidor.
- `downloads/CD_VOL_2.rar` não foi versionado porque excede o limite de 100 MiB por arquivo do GitHub.
- O banco de dados não faz parte do backup de diretório recebido.
- Parte do conteúdo que dependia do banco foi reconstruída no diretório
  [`data`](data/README.md): artistas, texto de Serviços e relação de rádios.
- Consulte `SECURITY_REVIEW.md` antes de publicar novamente o site em produção.
