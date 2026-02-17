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

[Resumo do capítulo 1 e 2](app/capitulo1-2/resumo_capitulos_1_e_2_oo_e_srp.md)

[Exemplos de código](app/capitulo1-2/index.php)

- Capítulo III - ACOPLAMENTO E O TAL DO DIP

> "tenha classes que são muito coesas e pouco acopladas"

> "problema do acoplamento é que uma mudança em qualquer uma das classes pode impactar em mudanças na classe principal"

> "a partir do momento em que uma classe possui muitas dependências, todas elas podem propagar problemas para a classe principal."

> "modelaremos nossos sistemas fugindo dos acoplamentos perigosos"

> "dependência é estável"

> "acoplar-se a classes, interfaces, módulos, que sejam estáveis, que tendam a mudar muito pouco"

> "interfaces possuem um papel muito importante em sistemas orientados a objetos"

> "padrões de projeto ajudam você a desacoplar seus projetos de classe"

> "Módulos de alto nível não devem depender de módulos de baixo nível. Ambos devem depender de abstrações"

> "Abstrações não devem depender de detalhes. Detalhes devem depender de abstrações"

> "Princípio de Inversão de Dependência"

> "solução é pensar não só no acoplamento, mas também em divisão de responsabilidades"

> "acoplamento lógico pode nos indicar um mau projeto de classes, ou mesmo código que não está bem encapsulado"

[Resumo do capítulo 3](app/capitulo3/resumo_capitulo3-dip.md)

[Exemplos de código](app/capitulo3/exemplos_em_php_capitulo_3_acoplamento_e_dip.md)
