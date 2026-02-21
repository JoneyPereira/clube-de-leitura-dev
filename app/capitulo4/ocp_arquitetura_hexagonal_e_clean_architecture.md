# 🧠 OCP, Arquitetura Hexagonal e Clean Architecture
## Como o Open/Closed Principle molda o fluxo de regras

Este documento conecta **diretamente** o **Open/Closed Principle (OCP)** com a **Arquitetura Hexagonal** e a **Clean Architecture**, mostrando como o princípio influencia **o fluxo de regras de negócio** em sistemas bem projetados.

O foco é **arquitetural e conceitual**, não framework.

---

## 1. OCP além da classe

O OCP costuma ser ensinado no nível de classes:

> “Classes devem estar abertas para extensão e fechadas para modificação.”

Mas, em sistemas reais, o OCP **não para na classe**. Ele se propaga para:

- casos de uso
- módulos
- camadas
- arquitetura como um todo

Quando isso acontece, a arquitetura começa a emergir naturalmente.

---

## 2. O problema arquitetural clássico

Sem OCP, o fluxo costuma ser:

```
Controller → Service → If / Switch → Regra → Infraestrutura
```

Consequências:

- cada nova regra exige mudança em vários pontos
- código cresce para dentro
- regras se misturam
- testes ficam caros

O sistema evolui por **modificação**, não por extensão.

---

## 3. OCP como organizador do fluxo de regras

Quando o OCP é aplicado corretamente:

- regras variáveis são isoladas
- pontos de extensão ficam claros
- o fluxo de execução se estabiliza

A pergunta muda de:
> “Qual regra eu aplico aqui?”

Para:
> “Quem decide qual regra entra em cena?”

---

## 4. Arquitetura Hexagonal: OCP em escala

A Arquitetura Hexagonal materializa o OCP no nível arquitetural.

Ela separa claramente:

- **núcleo (domínio / casos de uso)** → fechado para modificação
- **bordas (adaptadores)** → abertas para extensão

---

## 5. Fluxo de regras na Arquitetura Hexagonal

```
[ Adaptadores ] → [ Portas ] → [ Casos de Uso ]
                          ↓
                     [ Regras ]
```

Características importantes:

- o núcleo não muda quando novas regras surgem
- novas regras entram como **novas implementações**
- dependências sempre apontam para dentro

👉 O OCP protege o núcleo.

---

## 6. Regras como extensões, não decisões

Um erro comum é colocar lógica condicional no núcleo:

```text
if tipo == X → regra A
if tipo == Y → regra B
```

Isso viola o OCP.

O núcleo deveria apenas **orquestrar**:

> “Execute todas as regras que se aplicam.”

Quem decide **quais regras existem** fica fora do núcleo.

---

## 7. Clean Architecture: mesma ideia, outro nome

A Clean Architecture compartilha o mesmo princípio:

- regras de negócio no centro
- detalhes técnicos nas bordas
- dependências apontam para dentro

O OCP aparece quando:

- entidades e casos de uso não precisam mudar
- novas políticas entram por extensão

Arquitetura limpa é, na prática, **OCP aplicado em camadas**.

---

## 8. Fluxo de regras na Clean Architecture

```
Frameworks & Drivers
        ↓
Interface Adapters
        ↓
Use Cases
        ↓
Entities
```

Onde o OCP atua:

- **Entities / Use Cases** → fechados para modificação
- **Adapters / Frameworks** → abertos para extensão

O centro permanece estável enquanto o sistema evolui.

---

## 9. OCP + DIP: dupla inseparável

O OCP só se sustenta arquiteturalmente porque:

- o DIP inverte dependências
- o núcleo depende de abstrações
- detalhes dependem do núcleo

Sem DIP:
- o núcleo conhece detalhes
- o OCP quebra

👉 DIP viabiliza OCP.

---

## 10. Exemplo conceitual de fluxo

1. Caso de uso executa
2. Recebe uma lista de regras (abstrações)
3. Aplica regras
4. Finaliza fluxo

Para adicionar nova regra:

- cria-se uma nova implementação
- registra-se no sistema
- **nenhuma linha do núcleo muda**

---

## 11. Onde frameworks entram (Laravel, etc.)

Frameworks vivem **na borda**:

- resolvem dependências
- escolhem implementações
- conectam mundo externo

Eles **não participam da regra**.

O OCP garante que trocar framework:
- não altera regras
- não quebra o núcleo

---

## 12. Sinais de que o OCP está funcionando

- regras novas entram sem alterar casos de uso
- código antigo permanece estável
- testes do núcleo não mudam
- arquitetura aceita crescimento

---

## 13. Conclusão

O OCP não é apenas um princípio de classe:

- ele define **como o sistema cresce**
- protege o núcleo de mudanças
- orienta o fluxo de regras

Arquitetura Hexagonal e Clean Architecture são consequências naturais de:

👉 **Aplicar OCP + DIP de forma consistente.**

Quando isso acontece, o sistema evolui por adição — nunca por remendo.

