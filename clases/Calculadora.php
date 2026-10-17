<?php
/**
 * Operaciones básicas de la calculadora.
 * Porcentaje: "A % de B" = A * B / 100
 */
class Calculadora
{
    public const OPERACIONES = [
        'suma'           => '+',
        'resta'          => '−',
        'multiplicacion' => '×',
        'division'       => '÷',
        'porcentaje'     => '% de',
    ];

    public function operar(float $a, float $b, string $operacion): float
    {
        switch ($operacion) {
            case 'suma':
                return $a + $b;
            case 'resta':
                return $a - $b;
            case 'multiplicacion':
                return $a * $b;
            case 'division':
                if ($b == 0) {
                    throw new DivisionByZeroError('No se puede dividir entre cero.');
                }
                return $a / $b;
            case 'porcentaje':
                return ($a * $b) / 100;
            default:
                throw new InvalidArgumentException('Operación no válida.');
        }
    }

    public function simbolo(string $operacion): string
    {
        return self::OPERACIONES[$operacion] ?? '?';
    }
}
