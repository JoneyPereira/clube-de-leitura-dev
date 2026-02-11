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

Notas do livro
- Capítulo I - ORIENTAÇÃO A OBJETOS,  PARA QUE TE QUERO?
> "sabendo o que são classes, a usar o mecanismo de herança e viram
exemplos de Cachorro, Gato e Papagaio para entender
polimorfismo"

> "procedural disfarçado de
orientado a objeto"

> "pensar no projeto de
classes, em como elas se encaixam e como elas serão estendidas é o
que importa."

> "aprender e a escrever softwares ainda melhores."

- Capítulo II - A COESÃO E O TAL DO SRP

[Decorator](https://refactoring.guru/pt-br/design-patterns/decorator)

[Decorator em PHP](https://refactoring.guru/pt-br/design-patterns/decorator/php/example)

> "Design Patterns com Java: Projeto
orientado a objetos guiado por padrões"

> "ARQUITETURA HEXAGONAL"

> "Classes coesas são mais fáceis de serem mantidas, reutilizadas e
tendem a ter menos bugs. Pense nisso."

> "Coesão é fundamental, mas acoplamento também. Essa é uma
balança interessante. Falaremos mais sobre o assunto no próximo
capítulo."

[Design Patterns in PHP](https://github.com/gabrielanhaia/php-design-patterns)


