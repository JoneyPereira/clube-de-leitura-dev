# 🧪 Exemplos em PHP — Capítulo IV (Open/Closed Principle)

Este documento apresenta a conversão conceitual do exemplo do livro (*CalculadoraDePrecos*, originalmente em Java) para **PHP**, mostrando:

- o problema clássico de violação do OCP
- a refatoração orientada a abstrações
- como o código passa a evoluir por **extensão**, não por modificação

O foco é **design**, não tradução literal de sintaxe.

---

## ❌ Exemplo original — Violando o OCP

### Cenário
Uma calculadora de preços aplica regras diferentes de desconto conforme o tipo de compra. A cada nova regra, a classe precisa ser modificada.

### Implementação em PHP (problema)

```php
class CalculadoraDePrecos
{
    public function calcular(float $valor, string $tipo): float
    {
        if ($tipo === 'PROMOCAO') {
            return $valor * 0.9;
        }

        if ($tipo === 'FIDELIDADE') {
            return $valor * 0.85;
        }

        return $valor;
    }
}
```

### 🚨 Problemas de design

- Cada nova regra exige modificar a classe
- Crescimento infinito de `if/else`
- Baixa coesão
- Código difícil de testar

O sistema **não está fechado para modificação**.

---

## 🔎 Identificando o ponto de variação

O primeiro passo para aplicar OCP é identificar:

👉 **o que muda com frequência?**

Neste caso:
- a regra de cálculo de preço

Isso indica a necessidade de uma abstração.

---

## ✅ Refatoração — Aplicando OCP

### Criando a abstração

```php
interface RegraDePreco
{
    public function calcular(float $valor): float;
}
```

---

### Implementações concretas

```php
class PrecoPromocional implements RegraDePreco
{
    public function calcular(float $valor): float
    {
        return $valor * 0.9;
    }
}

class PrecoFidelidade implements RegraDePreco
{
    public function calcular(float $valor): float
    {
        return $valor * 0.85;
    }
}

class PrecoNormal implements RegraDePreco
{
    public function calcular(float $valor): float
    {
        return $valor;
    }
}
```

---

### Classe fechada para modificação

```php
class CalculadoraDePrecos
{
    public function __construct(
        private RegraDePreco $regra
    ) {}

    public function calcular(float $valor): float
    {
        return $this->regra->calcular($valor);
    }
}
```

Agora, a classe **não precisa mais mudar** quando surge uma nova regra.

---

## ➕ Estendendo o sistema (sem modificar código)

Para criar uma nova regra:

```php
class PrecoBlackFriday implements RegraDePreco
{
    public function calcular(float $valor): float
    {
        return $valor * 0.7;
    }
}
```

Nenhuma linha existente foi alterada.

👉 **Extensão, não modificação.**

---

## 🧠 Relação direta com DIP

Observe que:

- `CalculadoraDePrecos` depende de uma **abstração**
- não conhece implementações concretas

Isso é OCP sustentado pelo DIP.

Sem DIP, o OCP não se sustenta.

---

## 🧪 Testabilidade melhora naturalmente

Agora é fácil testar:

```php
$regra = new PrecoPromocional();
$calculadora = new CalculadoraDePrecos($regra);

$resultado = $calculadora->calcular(100);
// resultado = 90
```

Cada regra pode ser testada isoladamente.

---

## ⚙️ E com frameworks como Laravel?

No Laravel, a escolha da regra pode vir do container:

```php
$this->app->bind(RegraDePreco::class, PrecoPromocional::class);
```

Ou de uma fábrica baseada em contexto:

- tipo de cliente
- campanha ativa
- canal de venda

A calculadora continua **intocável**.

---

## 🧾 Conclusão

O exemplo do Capítulo IV mostra que:

- OCP é sobre preparar o código para mudanças reais
- abstrações marcam pontos de extensão
- classes boas evoluem por adição
- OCP e DIP caminham juntos

👉 **Quando novas regras surgem e o código antigo permanece intacto, o OCP está funcionando.**

