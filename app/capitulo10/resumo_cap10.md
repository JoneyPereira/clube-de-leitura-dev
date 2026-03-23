# 📘 Capítulo X — Métricas de Código

Este capítulo introduz um tema muito importante para quem trabalha com sistemas reais:
**como identificar problemas de design antes que eles se tornem críticos**.

A ideia central é:

> Não conseguimos garantir qualidade apenas “no olho” — precisamos de **métricas**.

---

# 🎯 Objetivo das Métricas

Em sistemas grandes, com dezenas ou centenas de classes:

* é impossível analisar tudo manualmente
* problemas de design passam despercebidos
* refatorações ficam reativas (e não preventivas)

Por isso usamos métricas como:

> **heurísticas** para apontar possíveis problemas

⚠️ Importante:

> Métricas não dizem “isso está errado”
> Elas dizem: **“olhe aqui, pode ter um problema”**

---

# 📊 Principais Métricas

O capítulo apresenta algumas métricas clássicas.

---

# 1. 🔁 Complexidade Ciclomática (McCabe)

Mede **quantos caminhos diferentes existem em um método**.

Exemplo simples:

```php
function calcularDesconto($valor)
{
    if ($valor > 1000) {
        return $valor * 0.1;
    } else {
        return 0;
    }
}
```

Aqui temos:

* 1 decisão (`if`)
* 2 caminhos possíveis

👉 Complexidade = **2**

---

## Problemas de alta complexidade

Quando a complexidade cresce:

* código difícil de entender
* difícil de testar (muitos cenários)
* maior chance de bugs

Exemplo ruim:

```php
if (...) {
    if (...) {
        if (...) {
            // ...
        }
    }
}
```

---

## Regra prática

* até 5 → ok
* 5 a 10 → atenção
* > 10 → refatorar

---

# 2. 📏 Tamanho (Classes e Métodos)

O tamanho também é um ótimo indicador.

Exemplo de alerta:

* métodos com muitas linhas
* classes com muitas responsabilidades

```php
class SistemaFinanceiro {
    // 500 linhas...
}
```

Problema:

* difícil de entender
* difícil de manter
* tende a virar **God Class**

---

## Regra prática

> Se está grande demais, provavelmente está fazendo coisa demais.

---

# 3. 🧩 LCOM (Lack of Cohesion of Methods)

Mede **falta de coesão** de uma classe.

Ou seja:

> Quantos “grupos de responsabilidades” existem dentro da mesma classe.

---

## Exemplo ruim

```php
class Usuario
{
    public function salvar() {}
    public function calcularSalario() {}
    public function enviarEmail() {}
}
```

Essa classe:

* persiste dados
* faz cálculo
* envia email

👉 Baixa coesão (alto LCOM)

---

## Interpretação

* LCOM alto → classe com múltiplas responsabilidades
* LCOM baixo → classe coesa

---

# 4. 🔗 Acoplamento (Aferente e Eferente)

## Acoplamento Eferente (Ce)

Quantas classes **essa classe depende**.

```php
class PedidoService
{
    private EmailService $email;
    private Repository $repo;
    private Logger $logger;
}
```

👉 Alto acoplamento eferente = muita dependência

---

## Acoplamento Aferente (Ca)

Quantas classes **dependem dessa classe**.

👉 Alto acoplamento aferente:

* indica classe importante
* mudanças são mais arriscadas

---

## Interpretação

* alto acoplamento → maior impacto de mudanças
* baixo acoplamento → maior flexibilidade

---

# 🧠 Como usar essas métricas

O objetivo NÃO é:

❌ “seguir números cegamente”

O objetivo é:

✔ identificar pontos suspeitos
✔ priorizar refatorações
✔ melhorar design continuamente

---

# 🔍 Ferramentas

O livro menciona ferramentas que automatizam análise.

Uma das mais conhecidas é:

* SonarQube

Ela analisa:

* complexidade
* duplicação
* cobertura de testes
* code smells

---

# 🧪 Exemplo prático de uso

Imagine um sistema com 200 classes.

Você roda análise e encontra:

* Classe A → complexidade 25
* Classe B → LCOM alto
* Classe C → alto acoplamento

👉 Essas são candidatas a refatoração.

---

# 🧱 Relação com Design Smells

Métricas ajudam a detectar smells:

| Métrica           | Pode indicar                    |
| ----------------- | ------------------------------- |
| Alta complexidade | código difícil / lógica confusa |
| Classe grande     | God Class                       |
| LCOM alto         | baixa coesão                    |
| Alto acoplamento  | dificuldade de manutenção       |

---

# 🏷️ Nomes também importam

O capítulo reforça:

> Métricas ajudam, mas **bons nomes continuam essenciais**

Porque:

* nomes comunicam intenção
* ajudam na leitura
* reduzem ambiguidade

---

# 📌 Conclusão

Métricas de código são ferramentas importantes para:

* detectar problemas cedo
* guiar refatorações
* melhorar qualidade do sistema

Mas devem ser usadas com cuidado:

> **Métricas são guias, não regras absolutas.**

Resumo:

* use métricas como **heurísticas**
* combine com conhecimento de design
* foque em melhorar continuamente

---

# 💡 Frase-chave do capítulo

> “O objetivo é encontrar problemas de forma rápida e barata.”
