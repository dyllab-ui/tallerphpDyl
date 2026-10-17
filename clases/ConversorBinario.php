<?php
/**
 * Convierte un número entero a binario con divisiones sucesivas entre 2.
 */
class ConversorBinario
{
    private array $pasos = [];

    public function __construct(private int $numero)
    {
    }

    public function convertir(): string
    {
        $this->pasos = [];

        if ($this->numero === 0) {
            return '0';
        }

        // Para un negativo se convierte su valor absoluto y se antepone "-"
        $valor = $this->numero < 0 ? -$this->numero : $this->numero;
        $binario = '';

        while ($valor > 0) {
            $residuo = $valor % 2;
            $this->pasos[] = ['dividendo' => $valor, 'cociente' => intdiv($valor, 2), 'residuo' => $residuo];
            $binario = $residuo . $binario;
            $valor = intdiv($valor, 2);
        }

        return ($this->numero < 0 ? '-' : '') . $binario;
    }

    /** Pasos de las divisiones (se llena después de llamar a convertir()). */
    public function pasos(): array
    {
        return $this->pasos;
    }
}
