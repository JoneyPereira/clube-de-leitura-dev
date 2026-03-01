# 📘 Capítulo V — Encapsulamento e a Propagação de Mudanças

Este capítulo adiciona o que o autor chama de **grande pilar que faltava: o encapsulamento**.

Se nos capítulos anteriores falamos sobre:

- Coesão
- Acoplamento
- DIP
- OCP

Agora entramos no princípio que **protege tudo isso**.

---

# 1. O que é encapsulamento de verdade?

> "Encapsulamento é o nome que damos à ideia de a classe esconder os detalhes de implementação."

Encapsular não é apenas usar `private`.
Encapsular é:

- esconder o *como*
- expor apenas o *o quê*
- proteger regras de negócio

Uma boa classe permite que você responda:

- ❓ O que ela faz? → Sim
- ❌ Como ela faz? → Não deveria ser óbvio

Se você consegue responder "como" só olhando para fora da classe, ela não está bem encapsulada.

---

# 2. O problema da propagação de mudanças

Um dos maiores perigos em sistemas é este:

> Sempre que a regra de negócio muda, a alteração precisa ser feita em vários lugares.

Isso indica:

- regra espalhada
- falta de encapsulamento
- alto acoplamento lógico

Quanto mais lugares você precisa alterar, mais frágil o sistema se torna.

---

# 3. Exemplo do livro (convertido para PHP)

## ❌ Versão com baixo encapsulamento

```php
class ProcessadorDeBoletos
{
    public function processa(array $boletos, Fatura $fatura): void
    {
        $total = 0;

        foreach ($boletos as $boleto) {
            $pagamento = new Pagamento(
                $boleto->getValor(),
                MeioDePagamento::BOLETO
            );

            // Violação de encapsulamento
            $fatura->getPagamentos()[] = $pagamento;

            $total += $boleto->getValor();
        }

        if ($total >= $fatura->getValor()) {
            $fatura->setPago(true);
        }
    }
}
```

### Problemas aqui

- O processador conhece detalhes internos da Fatura
- Ele manipula diretamente sua lista de pagamentos
- Ele decide quando a fatura está paga

Isso gera **intimidade inapropriada**.

---

## ✅ Versão encapsulada

```php
class ProcessadorDeBoletos
{
    public function processa(array $boletos, Fatura $fatura): void
    {
        foreach ($boletos as $boleto) {
            $pagamento = new Pagamento(
                $boleto->getValor(),
                MeioDePagamento::BOLETO
            );

            $fatura->adicionaPagamento($pagamento);
        }
    }
}
```

Agora a lógica de controle fica dentro da própria Fatura.

---

# 4. Encapsulando a regra dentro da Fatura

```php
class Fatura
{
    private array $pagamentos = [];
    private bool $pago = false;

    public function __construct(private float $valor) {}

    public function adicionaPagamento(Pagamento $pagamento): void
    {
        $this->pagamentos[] = $pagamento;
        $this->atualizaStatus();
    }

    private function atualizaStatus(): void
    {
        $total = array_reduce(
            $this->pagamentos,
            fn($soma, $p) => $soma + $p->getValor(),
            0
        );

        if ($total >= $this->valor) {
            $this->pago = true;
        }
    }

    public function estaPaga(): bool
    {
        return $this->pago;
    }
}
```

Agora:

- Quem sabe quando está paga? → A própria Fatura
- Quem controla seus pagamentos? → A própria Fatura
- Quem conhece o cálculo interno? → Apenas a Fatura

👉 Isso é encapsulamento real.

---

# 5. Tell, Don’t Ask

O capítulo reforça um princípio importante:

> Devemos dizer ao objeto o que fazer, não perguntar algo para depois decidir.

❌ Errado:

```php
if ($fatura->getTotal() >= $fatura->getValor()) {
    $fatura->setPago(true);
}
```

✅ Correto:

```php
$fatura->adicionaPagamento($pagamento);
```

A decisão fica dentro do objeto.

No mundo OO, damos ordens — não interrogamos objetos.

---

# 6. Lei de Demeter

A Lei de Demeter sugere evitar chamadas em cadeia:

❌

```php
$pedido->getCliente()->getEndereco()->getCidade();
```

Isso aumenta acoplamento.

Melhor:

```php
$pedido->cidadeDoCliente();
```

A classe Pedido protege sua estrutura interna.

---

# 7. Cuidado com getters e setters

> "Não crie getters e setters sem pensar."

Se você expõe tudo:

- qualquer classe pode alterar estado
- regras se espalham
- encapsulamento morre

Getters e setters devem existir por um motivo claro.

---

# 8. Como saber se está bem encapsulado?

Faça duas perguntas:

1. Eu sei o que essa classe faz? → Deve saber
2. Eu sei como ela faz? → Não deveria

Se o "como" está visível, há vazamento de implementação.

---

# 9. Encapsulamento e propagação de mudanças

Um sistema saudável se comporta assim:

- você altera uma regra
- altera apenas uma classe
- fica claro quem é impactado

Se você altera uma classe e precisa sair procurando onde mais mexer, o encapsulamento falhou.

---

# 10. Conexão com capítulos anteriores

Encapsulamento sustenta:

- SRP → regras centralizadas
- OCP → extensão segura
- DIP → abstrações protegidas

Sem encapsulamento:

- regras vazam
- dependências aumentam
- mudanças se espalham

---

# Conclusão

Encapsular é:

- esconder detalhes
- concentrar regras
- reduzir pontos de mudança
- proteger o domínio

👉 Quanto menos o sistema souber sobre o "como", mais fácil será evoluí-lo.

Encapsulamento não é detalhe de sintaxe.
É estratégia de sobrevivência do sistema.

