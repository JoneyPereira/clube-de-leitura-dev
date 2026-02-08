# clube-de-leitura-dev
Repositório do projeto Clube de Leitura (setup mínimo).

Uso rápido
- Requisitos: Docker (em modo Linux containers) e Shell (Git Bash ou PowerShell).
- Executar um arquivo PHP dentro do container:

```bash
./build php /app/index.php        # se index.php estiver na raiz do projeto
./build php app/index.php        # se o projeto usar a pasta `app`
```

Notas sobre Windows/Git Bash
- O script `build` já trata a conversão de caminhos no Git Bash/MSYS e usa `--mount` + `--workdir`.
- Se houver problemas com mounts, rode em PowerShell ou ative "Switch to Linux containers" no Docker Desktop.

Sugestões
- Para executar sempre dentro da pasta `app`, mova os arquivos para `app/` ou deixe como está — o `build` detecta automaticamente.
