# 📘 Capítulo VIII — Consistência, Objetinhos e Objetões

Este capítulo discute um tema essencial no design orientado a objetos: **garantir que os objetos do domínio estejam sempre em um estado válido**.

A principal ideia é:

> Garantir a integridade do estado é responsabilidade do próprio objeto.

Isso leva a várias discussões importantes:

- consistência de objetos
- validação
- construtores
- tiny types
- DTOs
- imutabilidade
- nomenclatura

---

# 1. Objetos em estado inválido

Um objeto está em **estado inválido** quando seus atributos possuem valores que não fazem sentido para o domínio.

Exemplo ruim:

```php
class Pedido
{
    private ?Cliente $cliente = null;
    private float $valorTotal = 0;
    private array $itens = [];
}

$pedido = new Pedido();
```

Nesse caso, o objeto pode existir sem cliente e sem regras claras.

Isso abre espaço para inconsistências.

---

# 2. Construtores garantem consistência

Uma solução simples é exigir os dados obrigatórios no construtor.

Exemplo equivalente ao código Java do livro:

```php
class Pedido
{
    private Cliente $cliente;
    private float $valorTotal;
    private array $itens;

    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
        $this->valorTotal = 0;
        $this->itens = [];
    }

    public function adicionarItem(Item $item): void
    {
        $this->itens[] = $item;
        $this->recalcularTotal();
    }

    private function recalcularTotal(): void
    {
        $this->valorTotal = array_reduce(
            $this->itens,
            fn($total, $item) => $total + $item->getValor(),
            0
        );
    }
}
```

Agora **não é possível criar um Pedido inválido**.

---

# 3. Objetos de valor (Value Objects)

Um exemplo clássico do livro é **CPF**.

Errado:

```php
class CPF
{
    private string $cpf;

    public function __construct(string $cpf)
    {
        $this->cpf = $cpf;
    }

    public function validar(): bool
    {
        // regras aqui
    }
}
```

Nesse caso, o objeto pode existir **mesmo sendo inválido**.

Melhor abordagem:

```php
class CPF
{
    private string $cpf;

    public function __construct(string $cpf)
    {
        if (!self::cpfValido($cpf)) {
            throw new InvalidArgumentException("CPF inválido");
        }

        $this->cpf = $cpf;
    }

    private static function cpfValido(string $cpf): bool
    {
        return strlen($cpf) === 11;
    }

    public function get(): string
    {
        return $this->cpf;
    }
}
```

Assim **é impossível existir um CPF inválido no sistema**.

---

# 4. Builder ou Factory

Quando criar objetos é complexo, podemos usar padrões criacionais.

Exemplo simples de Factory:

```php
class CPFBuilder
{
    public static function build(string $cpf): CPF
    {
        if(strlen($cpf) !== 11) {
            throw new InvalidArgumentException("CPF inválido");
        }

        return new CPF($cpf);
    }
}
```

---

# 5. Dois tipos de validação

O livro separa validações em dois tipos:

### 1️⃣ Validação de dados

Verifica se o dado enviado pelo usuário tem formato válido.

Exemplo:

- CPF válido
- email válido
- telefone válido

### 2️⃣ Validação de negócio

Regras do domínio.

Exemplo:

- imposto maior que 1%
- cliente menor de idade precisa responsável

Essas validações devem ficar **no domínio**.

---

# 6. Hexagonal Architecture e validação

Arquiteturas hexagonais costumam separar responsabilidades:

```
Adapter (Controller / API)
   ↓
Validação de dados simples

Domínio
   ↓
Validações de negócio
```

Ou seja:

- adaptadores limpam os dados
- domínio garante consistência das regras

---

# 7. Tiny Types

Tiny Types são **pequenas classes que representam um conceito do domínio**.

Exemplo ruim:

```php
new Aluno(
    "Mauricio",
    "mauricio@email.com",
    "Rua X",
    "São Paulo",
    "119999999",
    "12345678901"
);
```

É difícil entender o significado de cada string.

Com tiny types:

```php
new Aluno(
    new Nome("Mauricio"),
    new Email("mauricio@email.com"),
    new Endereco("Rua X", "São Paulo"),
    new Telefone("119999999"),
    new CPF("12345678901")
);
```

Agora o **tipo documenta o domínio**.

Benefícios:

- mais legibilidade
- validação centralizada
- maior expressividade

---

# 8. DTOs (Data Transfer Objects)

DTOs servem para **transportar dados entre camadas**.

Exemplo:

```php
class DadosUsuarioDTO
{
    public function __construct(
        public string $nome,
        public DateTime $ultimoAcesso,
        public int $tentativas
    ) {}
}
```

Eles são úteis para:

- APIs
- relatórios
- integração entre camadas

Importante:

> O problema não é ter DTOs. O problema é ter **apenas DTOs**.

Ou seja, substituir todo domínio por estruturas de dados simples.

---

# 9. Imutabilidade

Objetos imutáveis não mudam de estado após serem criados.

Exemplo:

```php
class Endereco
{
    public function __construct(
        private string $rua,
        private int $numero
    ) {}

    public function alterarRua(string $novaRua): Endereco
    {
        return new Endereco($novaRua, $this->numero);
    }
}
```

Em vez de modificar o objeto existente, criamos **uma nova instância**.

Benefícios:

- menos efeitos colaterais
- código mais previsível
- facilita concorrência

Mas não é bala de prata.

---

# 10. Null Objects

Um problema comum é receber valores nulos.

Uma alternativa é usar **Null Object Pattern**.

```php
interface Cliente
{
    public function nome(): string;
}

class ClienteReal implements Cliente
{
    public function __construct(private string $nome) {}

    public function nome(): string
    {
        return $this->nome;
    }
}

class ClienteNulo implements Cliente
{
    public function nome(): string
    {
        return "Cliente não informado";
    }
}
```

Assim evitamos verificações constantes de `null`.

---

# 11. Nomenclatura

Outro ponto forte do capítulo é a importância dos nomes.

Em sistemas OO:

- nomes de classes
- nomes de métodos
- nomes de atributos

são responsáveis pela **semântica do sistema**.

Boas práticas:

- seguir convenções da linguagem
- usar nomes claros
- refletir o domínio

---

# 12. Equilíbrio no design

O capítulo também alerta sobre exageros.

Nem todo sistema precisa:

- tiny types para tudo
- objetos imutáveis para tudo
- builders complexos

O design deve considerar:

- complexidade do domínio
- tamanho do sistema
- custo de manutenção

---

# 📌 Conclusão

Os principais aprendizados do capítulo são:

1. Objetos devem **sempre estar em estado válido**.
2. Construtores ajudam a garantir consistência.
3. Validações simples ficam nos adaptadores.
4. Validações de negócio ficam no domínio.
5. Tiny Types aumentam expressividade do código.
6. DTOs ajudam a transportar dados entre camadas.
7. Imutabilidade reduz efeitos colaterais.

No final, tudo se resume a um objetivo maior:

> **Criar modelos de domínio claros, consistentes e fáceis de manter.**

