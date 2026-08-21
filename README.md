# Magal Produções

Migração do site legado hospedado no cPanel para controle de versão no GitHub.

## Configuração

1. Copie `Connections/config.example.php` para `Connections/config.php`.
2. Configure `DB_HOST`, `DB_NAME`, `DB_USER` e `DB_PASSWORD` no ambiente do servidor.
3. Não versione `Connections/config.php`.

## Banco de dados

O banco original foi recuperado em 21/08/2026. Uma cópia sanitizada, sem
usuários administrativos, credenciais ou posts com dados pessoais, está disponível em
[`data/banco-publico`](data/banco-publico/README.md).

Os dados de artistas, Serviços e rádios também estão disponíveis em formatos
fáceis de consultar no diretório [`data`](data/README.md).

## Observações da migração

- O diretório de cache e os arquivos de validação temporários não foram versionados.
- `info.php` não foi versionado porque expõe informações do servidor.
- `downloads/CD_VOL_2.rar` não foi versionado porque excede o limite de 100 MiB por arquivo do GitHub.
- O banco original completo não foi versionado por conter credenciais.
- Consulte `SECURITY_REVIEW.md` antes de publicar novamente o site em produção.
