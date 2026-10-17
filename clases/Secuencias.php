<?php
/**
 * Secuencias numéricas: clase abstracta con dos implementaciones.
 */
abstract class Secuencia
{
    public function __construct(protected int $n)
    {
        if ($n < static::MINIMO || $n > static::MAXIMO) {
            throw new InvalidArgumentException(
                'El número debe estar entre ' . static::MINIMO . ' y ' . static::MAXIMO . '.'
            );
        }
    }

    abstract public function serie(): array;

    abstract public function titulo(): string;
}

class Fibonacci extends Secuencia
{
    public const MINIMO = 1;
    public const MAXIMO = 90;   // F(90) aún cabe en un entero de 64 bits

    // Devuelve los primeros n términos: 0, 1, 1, 2, 3, 5, ...
    public function serie(): array
    {
        $serie = [];
        $a = 0;
        $b = 1;
        for ($i = 0; $i < $this->n; $i++) {
            $serie[] = $a;
            $siguiente = $a + $b;
            $a = $b;
            $b = $siguiente;
        }
        return $serie;
    }

    public function titulo(): string
    {
        return 'Sucesión de Fibonacci (primeros ' . $this->n . ' términos)';
    }
}

class Factorial extends Secuencia
{
    public const MINIMO = 0;
    public const MAXIMO = 20;   // 20! aún cabe en un entero de 64 bits

    // Devuelve 0!, 1!, 2!, ..., n!
    public function serie(): array
    {
        $serie = [];
        $acumulado = 1;
        for ($i = 0; $i <= $this->n; $i++) {
            if ($i > 0) {
                $acumulado *= $i;
            }
            $serie[$i] = $acumulado;   // clave = i, valor = i!
        }
        return $serie;
    }

    public function resultado(): int
    {
        $serie = $this->serie();
        return end($serie);
    }

    public function titulo(): string
    {
        return 'Factorial de ' . $this->n;
    }
}
