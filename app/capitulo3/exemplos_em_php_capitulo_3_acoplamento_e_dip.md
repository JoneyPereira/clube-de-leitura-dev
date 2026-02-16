# 🧪 Exemplos em PHP — Capítulo III (Acoplamento e DIP)

Este documento apresenta **exemplos práticos em PHP**, baseados nos exemplos do livro *Orientação a Objetos e SOLID para Ninjas* (originalmente em Java), com foco em **acoplamento**, **interfaces** e **Princípio da Inversão de Dependência (DIP)**.

O objetivo não é traduzir código linha a linha, mas **preservar a ideia de design**.

---

## ❌ Exemplo 1 — Alto acoplamento (problema clássico)

### Cenário
Uma classe responsável por gerar nota fiscal conhece diretamente detalhes de:
- envio de e-mail
- persistência em banco

Isso cria um forte acoplamento e torna mudanças caras.

### Implementação em PHP (problema)

```php
class EnviadorEmail
{
    public function enviar(string $mensagem): void
    {
        echo "Enviando email: {$mensagem}\n";
    }
}

class NotaFiscalDao
{
    public function salvar(array $notaFiscal): void
    {
        echo "Salvando nota fiscal no banco\n";
    }
}

class GeradorNotaFiscal
{
    public function gerar(array $pedido): void
    {
        $notaFiscal = [
            'valor' => $pedido['valor'],
            'imposto' => $pedido['valor'] * 0.2,
        ];

        $dao = new NotaFiscalDao();
        $dao->salvar($notaFiscal);

        $email = new EnviadorEmail();
        $email->enviar('Nota fiscal gerada');
    }
}
```

### 🚨 Problemas desse design

- Classe conhece implementações concretas
- Difícil testar (não dá para mockar facilmente)
- Mudanças em e-mail ou persistência afetam o gerador
- Viola o DIP

---

## ✅ Exemplo 2 — Aplicando DIP com interfaces

### Ideia
O módulo de alto nível (**GeradorNotaFiscal**) passa a depender de **abstrações**, não de detalhes.

---

### Interfaces

```php
interface EnviadorEmail
{
    public function enviar(string $mensagem): void;
}

interface NotaFiscalRepository
{
    public function salvar(array $notaFiscal): void;
}
```

---

### Implementações concretas

```php
class EnviadorEmailSmtp implements EnviadorEmail
{
    public function enviar(string $mensagem): void
    {
        echo "Enviando email via SMTP: {$mensagem}\n";
    }
}

class NotaFiscalRepositoryMysql implements NotaFiscalRepository
{
    public function salvar(array $notaFiscal): void
    {
        echo "Salvando nota fiscal no MySQL\n";
    }
}
```

---

### Módulo de alto nível desacoplado

```php
class GeradorNotaFiscal
{
    public function __construct(
        private NotaFiscalRepository $repository,
        private EnviadorEmail $enviadorEmail
    ) {}

    public function gerar(array $pedido): void
    {
        $notaFiscal = [
            'valor' => $pedido['valor'],
            'imposto' => $pedido['valor'] * 0.2,
        ];

        $this->repository->salvar($notaFiscal);
        $this->enviadorEmail->enviar('Nota fiscal gerada');
    }
}
```

---

### Benefícios do novo design

- Baixo acoplamento
- Classes dependem de abstrações
- Código fácil de testar
- Implementações podem variar sem impacto

---

## 🧠 Acoplamento lógico (alerta de design)

Mesmo usando interfaces, ainda é possível ter **acoplamento lógico**, quando:
- regras diferentes mudam juntas
- classes compartilham responsabilidades implícitas

Esse tipo de acoplamento indica:
- responsabilidades mal definidas
- encapsulamento fraco

Interfaces ajudam, mas **não resolvem tudo sozinhas**.

---

## ⚙️ E na prática com frameworks PHP?

Frameworks modernos como **Laravel** já aplicam esses princípios por padrão:

- Injeção de dependência automática
- Container de serviços
- Programação orientada a interfaces

### Exemplo no Laravel

```php
class GeradorNotaFiscal
{
    public function __construct(
        private NotaFiscalRepository $repository,
        private EnviadorEmail $enviador
    ) {}
}
```

O Laravel resolve automaticamente as dependências no container:

```php
$this->app->bind(NotaFiscalRepository::class, NotaFiscalRepositoryMysql::class);
```

---

## 🧾 Conclusão

Os exemplos do Capítulo III mostram que:

- Acoplamento excessivo torna o sistema frágil
- DIP protege o código contra mudanças
- Interfaces são ferramentas, não solução mágica
- Frameworks como Laravel facilitam boas práticas

👉 O desenvolvedor deve focar menos em *como instanciar* e mais em *como modelar dependências*.

Esse cuidado é o que diferencia código funcional de código **sustentável a longo prazo**.

