# 🧪 Exemplos em PHP com Testes — Capítulo III (DIP + PHPUnit)

Este documento complementa os exemplos do Capítulo III (*Acoplamento e DIP*) adicionando **testes automatizados com PHPUnit**.

O foco aqui é mostrar **como o bom design (baixo acoplamento + DIP)** facilita testes simples, rápidos e confiáveis.

---

## 📦 Estrutura sugerida do projeto

```text
app/
 ├─ NotaFiscal/
 │   ├─ GeradorNotaFiscal.php
 │   ├─ EnviadorEmail.php
 │   ├─ NotaFiscalRepository.php
 │   └─ …

tests/
 └─ GeradorNotaFiscalTest.php
```

Essa separação já reflete um design mais limpo e testável.

---

## 🔌 Abstrações (interfaces)

```php
<?php
// app/NotaFiscal/EnviadorEmail.php

interface EnviadorEmail
{
    public function enviar(string $mensagem): void;
}
```

```php
<?php
// app/NotaFiscal/NotaFiscalRepository.php

interface NotaFiscalRepository
{
    public function salvar(array $notaFiscal): void;
}
```

---

## 🧠 Classe de alto nível (caso de uso)

```php
<?php
// app/NotaFiscal/GeradorNotaFiscal.php

class GeradorNotaFiscal
{
    public function __construct(
        private NotaFiscalRepository $repository,
        private EnviadorEmail $enviadorEmail
    ) {}

    public function gerar(array $pedido): array
    {
        $notaFiscal = [
            'valor' => $pedido['valor'],
            'imposto' => $pedido['valor'] * 0.2,
        ];

        $this->repository->salvar($notaFiscal);
        $this->enviadorEmail->enviar('Nota fiscal gerada');

        return $notaFiscal;
    }
}
```

Note que o método **retorna a nota fiscal**, facilitando a asserção no teste.

---

## 🧪 Testando com PHPUnit

### Objetivo do teste

- Garantir que a nota fiscal é calculada corretamente
- Verificar se as dependências são chamadas
- Testar **sem banco, sem e-mail real**

---

### Teste unitário com mocks

```php
<?php
// tests/GeradorNotaFiscalTest.php

use PHPUnit\Framework\TestCase;

class GeradorNotaFiscalTest extends TestCase
{
    public function testGeraNotaFiscalComImposto(): void
    {
        $repositoryMock = $this->createMock(NotaFiscalRepository::class);
        $emailMock = $this->createMock(EnviadorEmail::class);

        $repositoryMock
            ->expects($this->once())
            ->method('salvar');

        $emailMock
            ->expects($this->once())
            ->method('enviar')
            ->with('Nota fiscal gerada');

        $gerador = new GeradorNotaFiscal(
            $repositoryMock,
            $emailMock
        );

        $notaFiscal = $gerador->gerar(['valor' => 100.0]);

        $this->assertEquals(100.0, $notaFiscal['valor']);
        $this->assertEquals(20.0, $notaFiscal['imposto']);
    }
}
```

---

## ✅ O que esse teste prova?

Graças ao **DIP e ao baixo acoplamento**, conseguimos:

- Testar apenas a regra de negócio
- Simular dependências com mocks
- Evitar dependência de infraestrutura
- Criar testes rápidos e determinísticos

Se o código estivesse fortemente acoplado, esse teste seria **impossível ou muito custoso**.

---

## ⚠️ Como seria sem DIP?

Sem interfaces:
- Não dá para mockar dependências
- Testes viram integração sem querer
- Setup complexo
- Testes lentos

👉 Design ruim gera testes ruins.

---

## ⚙️ E com Laravel?

No Laravel, o container de dependências resolve tudo automaticamente:

```php
$this->app->bind(
    NotaFiscalRepository::class,
    NotaFiscalRepositoryMysql::class
);
```

Nos testes, você pode sobrescrever facilmente:

```php
$this->app->bind(
    NotaFiscalRepository::class,
    FakeNotaFiscalRepository::class
);
```

Ou usar mocks diretamente:

```php
$this->mock(NotaFiscalRepository::class);
```

O framework **potencializa** o DIP, mas não substitui o design.

---

## 🧾 Conclusão

- Bons testes nascem de bom design
- DIP facilita testes unitários reais
- PHPUnit funciona melhor com código desacoplado
- Frameworks como Laravel tornam esse padrão natural

👉 Se está difícil testar, o problema provavelmente **não é o PHPUnit**, é o design.

