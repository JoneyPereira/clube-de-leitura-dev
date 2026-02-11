<?php 
# Exemplos de codigo em PHP do Capitulo 1 — Orientação a Objetos, para que te quero?
echo "Capítulo 1 — Orientação a Objetos, para que te quero?";

# Exemplo ruim (procedural disfarçado de OO)
class Pedido
{
    public function calcularTotal(array $itens, string $tipoCliente)
    {
        $total = 0;

        foreach ($itens as $item) {
            $total += $item['preco'];
        }

        if ($tipoCliente === 'VIP') {
            $total *= 0.9;
        }

        return $total;
    }
}

 # Problemas: Regra de negócio misturada, Difícil adicionar novos tipos de cliente, Classe faz mais de uma coisa

 interface Desconto
{
    public function aplicar(float $valor): float;
}

class DescontoVip implements Desconto
{
    public function aplicar(float $valor): float
    {
        return $valor * 0.9;
    }
}

class SemDesconto implements Desconto
{
    public function aplicar(float $valor): float
    {
        return $valor;
    }
}

class Pedido
{
    public function calcularTotal(array $itens, Desconto $desconto): float
    {
        $total = array_sum(array_column($itens, 'preco'));
        return $desconto->aplicar($total);
    }
}

# Agora sim OO de verdade: Fácil de estender, Baixo acoplamento, Regras isoladas

# Exemplos de codigo em PHP do Capitulo 2 - A COESÃO E O TAL DO SRP
echo "Capitulo II - A COESÃO E O TAL DO SRP";

# Exemplo ruim (baixa coesão)
class Usuario
{
    public function validarEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function salvarNoBanco(array $dados): void
    {
        // lógica de persistência
    }

    public function enviarEmailBoasVindas(string $email): void
    {
        // envio de email
    }
}

# Problemas: Validação, Persistência, Comunicação externa, Tudo numa classe só → 3 motivos para mudar

# Exemplo com SRP aplicado

class ValidadorEmail
{
    public function validar(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}

class UsuarioRepository
{
    public function salvar(array $dados): void
    {
        // persistência
    }
}

class EmailService
{
    public function enviarBoasVindas(string $email): void
    {
        // envio de email
    }
}

# Agora: Cada classe tem uma responsabilidade, Mudanças ficam localizadas, Código respira melhor

