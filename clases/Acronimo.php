<?php
/**
 * Convierte una frase en su acrónimo.
 * Los guiones y espacios separan palabras; los demás signos se eliminan.
 */
class Acronimo
{
    public function __construct(private string $frase)
    {
    }

    public function generar(): string
    {
        // Elimina todo lo que no sea letra, número, espacio o guion
        $limpia = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $this->frase);
        $palabras = preg_split('/[\s-]+/u', trim($limpia), -1, PREG_SPLIT_NO_EMPTY);

        $siglas = '';
        foreach ($palabras as $palabra) {
            $siglas .= mb_strtoupper(mb_substr($palabra, 0, 1, 'UTF-8'), 'UTF-8');
        }
        return $siglas;
    }
}
