# 📘 Over-Encapsulation — Quando Encapsular Demais Atrapalha

Encapsulamento é um dos pilares da OO.
Mas, como qualquer princípio de design, quando aplicado de forma exagerada pode gerar o efeito contrário.

Over-encapsulation acontece quando:

- Escondemos coisas que não precisam ser escondidas
- Criamos camadas desnecessárias
- Multiplicamos métodos intermediários sem ganho real
- Tornamos o código difícil de entender e evoluir

---

# 1. O que é encapsular demais?

Encapsular bem é esconder detalhes de implementação.

Encapsular demais é:

- Esconder comportamento que deveria ser explícito
- Criar métodos "pass-through" que só delegam chamadas
- Transformar objetos simples em labirintos de indireções

---

# 2. Exemplo simples em PHP

## ✅ Encapsulamento saudável

```php
class Pedido
{
    private array $itens = [];

    public function adicionarItem(Item $item): void
    {
        $this->itens[] = $item;
    }

    public function total(): float
    {
        return array_reduce(
            $this->itens,
            fn($soma, $item) => $soma + $item->subtotal(),
            0
        );
    }
}
```

Aqui temos:

- Regra protegida
- Estado interno protegido
- API simples

---

## ❌ Over-encapsulation

```php
class Pedido
{
    private ItensCollection $itens;

    public function __construct()
    {
        $this->itens = new ItensCollection();
    }

    public function adicionarItem(Item $item): void
    {
        $this->itens->adicionar($item);
    }

    public function total(): float
    {
        return $this->itens->calcularTotal();
    }
}

class ItensCollection
{
    private array $itens = [];

    public function adicionar(Item $item): void
    {
        $this->itens[] = $item;
    }

    public function calcularTotal(): float
    {
        return array_reduce(
            $this->itens,
            fn($soma, $item) => $soma + $item->subtotal(),
            0
        );
    }
}
```

Pergunta importante:

👉 Essa nova classe realmente trouxe uma responsabilidade diferente?

Se não trouxe:

- Criamos complexidade sem necessidade
- Aumentamos indireção
- Aumentamos pontos de navegação
- Dificultamos leitura

---

# 3. Sintomas de over-encapsulation

Você pode estar encapsulando demais quando:

- Existem muitas classes com 20 linhas que só delegam chamadas
- Métodos existem apenas para "passar adiante"
- Você precisa abrir 5 arquivos para entender uma regra simples
- A complexidade acidental é maior que a regra de negócio

---

# 4. Encapsulamento vs Transparência do Domínio

Encapsular não significa esconder o domínio.

Se o domínio diz que um Pedido tem Itens, isso é natural.

Mas esconder demais pode tornar o domínio obscuro.

Código orientado a objeto deve:

- Esconder detalhes técnicos
- Tornar o domínio mais claro

Se o domínio fica mais difícil de entender, você passou do ponto.

---

# 5. Over-encapsulation e Clean Architecture

Na Clean Architecture, às vezes vemos:

- UseCases
- Services
- Managers
- Handlers
- Facades
- Factories
- Repositories

Todos com 10–15 linhas.

Se cada camada só delega para outra, você não tem arquitetura — você tem burocracia.

Arquitetura deve proteger regras.
Não criar paredes decorativas.

---

# 6. Quando criar uma nova classe faz sentido?

Crie uma nova abstração quando:

- Existe uma nova responsabilidade clara
- Existe variação comportamental futura
- Existe regra de negócio independente
- Existe complexidade real a ser isolada

Não crie abstração por antecipação.

---

# 7. Over-encapsulation vs YAGNI

YAGNI (You Aren't Gonna Need It) se conecta diretamente aqui.

Encapsular demais geralmente é:

- Antecipação de mudança que talvez nunca aconteça
- Medo de alteração futura
- Excesso de zelo arquitetural

Boa arquitetura é equilibrada.

---

# 8. Regra prática para equilíbrio

Pergunte-se:

1. Isso reduz pontos reais de mudança?
2. Isso melhora a legibilidade do domínio?
3. Isso diminui acoplamento real?
4. Ou só aumenta indireção?

Se a resposta for a última, provavelmente é over-encapsulation.

---

# 9. Encapsulamento ideal

Encapsulamento saudável:

- Esconde detalhes técnicos
- Centraliza regras
- Diminui propagação de mudanças
- Torna o domínio mais claro

Over-encapsulation:

- Esconde demais
- Cria burocracia estrutural
- Aumenta complexidade acidental
- Dificulta entendimento

---

# Conclusão

Encapsulamento é proteção.

Mas proteção excessiva vira isolamento.

O objetivo não é esconder tudo.
É esconder o que muda.

Boa arquitetura não é a que tem mais camadas.
É a que tem menos pontos de dor quando o sistema evolui.

