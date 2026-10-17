<?php
/**
 * Conjunto de números enteros sin repetidos.
 */
class Conjunto
{
    private array $elementos;

    public function __construct(array $elementos)
    {
        $unicos = array_values(array_unique(array_map('intval', $elementos)));
        sort($unicos);
        $this->elementos = $unicos;
    }

    public function elementos(): array
    {
        return $this->elementos;
    }

    public function union(Conjunto $otro): Conjunto
    {
        return new Conjunto(array_merge($this->elementos, $otro->elementos));
    }

    public function interseccion(Conjunto $otro): Conjunto
    {
        return new Conjunto(array_intersect($this->elementos, $otro->elementos));
    }

    public function diferencia(Conjunto $otro): Conjunto
    {
        return new Conjunto(array_diff($this->elementos, $otro->elementos));
    }

    public function __toString(): string
    {
        if (count($this->elementos) === 0) {
            return '∅ (conjunto vacío)';
        }
        return '{ ' . implode(', ', $this->elementos) . ' }';
    }
}
