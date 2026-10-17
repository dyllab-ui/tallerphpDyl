<?php
/**
 * Calcula promedio (media aritmética), mediana y moda de una serie de números reales.
 */
class Estadistica
{
    private array $datos;

    public function __construct(array $datos)
    {
        if (count($datos) === 0) {
            throw new InvalidArgumentException('Debe ingresar al menos un número.');
        }
        $this->datos = array_values(array_map('floatval', $datos));
    }

    public function cantidad(): int
    {
        return count($this->datos);
    }

    public function promedio(): float
    {
        return array_sum($this->datos) / count($this->datos);
    }

    public function mediana(): float
    {
        $ordenados = $this->datos;
        sort($ordenados);
        $n = count($ordenados);
        $mitad = intdiv($n, 2);

        if ($n % 2 === 1) {
            return $ordenados[$mitad];
        }
        return ($ordenados[$mitad - 1] + $ordenados[$mitad]) / 2;
    }

    /** Devuelve un arreglo con todas las modas (vacío si ningún valor se repite). */
    public function moda(): array
    {
        $frecuencias = array_count_values(array_map('strval', $this->datos));
        $maxima = max($frecuencias);

        if ($maxima === 1) {
            return [];
        }

        $modas = [];
        foreach ($frecuencias as $valor => $veces) {
            if ($veces === $maxima) {
                $modas[] = (float) $valor;
            }
        }
        sort($modas);
        return $modas;
    }
}
